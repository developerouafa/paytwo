<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\PaymentRepositoryInterface;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\PaymentAccount;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function index()
    {
        $payments =  PaymentAccount::latest()->get();
        return view('Dashboard.dashboard_user.Payment.index',compact('payments'));
    }

    public function softdelete()
    {
        $payments =  PaymentAccount::onlyTrashed()->latest()->get();
        return view('Dashboard.dashboard_user.Payment.softdelete',compact('payments'));
    }

    public function create($request)
    {
        $invoice_id = $request->invoice_id;
        $client_id = $request->client_id;
        return view('Dashboard.dashboard_user.Payment.add',compact('invoice_id', 'client_id'));
    }

    public function show($id)
    {
        $payment_account = PaymentAccount::findorfail($id);
        $fund_account = fund_account::where('Payment_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_user.Payment.print',compact('payment_account', 'invoice_number'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();

            // store Payment_accounts
            $payment_accounts = new PaymentAccount();
            $payment_accounts->date =date('y-m-d');
            $payment_accounts->client_id = $request->client_id;
            $payment_accounts->amount = $request->credit;
            $payment_accounts->description = $request->description;
            $payment_accounts->user_id = auth()->user()->id;
            $payment_accounts->save();

            // store fund_accounts
            $fund_accounts = new fund_account();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->invoice_id = $request->invoice_id;
            $fund_accounts->credit = $request->credit;
            $fund_accounts->user_id = auth()->user()->id;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // store client_accounts
            $client_accounts = new client_account();
            $client_accounts->date =date('y-m-d');
            $client_accounts->client_id = $request->client_id;
            $client_accounts->Payment_id = $payment_accounts->id;
            $client_accounts->invoice_id = $request->invoice_id;
            $client_accounts->Debit = $request->credit;
            $client_accounts->user_id = auth()->user()->id;
            $client_accounts->credit = 0.00;
            $client_accounts->save();

            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Payment.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Payment.createpy');
        }
    }

    public function edit($id)
    {
        $payment_accounts = PaymentAccount::findorfail($id);
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Payment.edit',compact('payment_accounts','Clients'));
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();

            // update Payment_accounts
            $payment_accounts = PaymentAccount::findorfail($request->id);
            $payment_accounts->date =date('y-m-d');
            $payment_accounts->client_id = $request->client_id;
            $payment_accounts->amount = $request->credit;
            $payment_accounts->description = $request->description;
            $payment_accounts->save();

            // update fund_accounts
            $fund_accounts = fund_account::where('Payment_id',$payment_accounts->id)->first();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->credit = $request->credit;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // update client_accounts
            $client_accounts = client_account::where('Payment_id',$payment_accounts->id)->first();
            $client_accounts->date =date('y-m-d');
            $client_accounts->client_id = $request->client_id;
            $client_accounts->Payment_id = $payment_accounts->id;
            $client_accounts->Debit = $request->credit;
            $client_accounts->credit = 0.00;
            $client_accounts->save();

            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Payment.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Payment.edit');
        }
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try {
                DB::beginTransaction();
                    PaymentAccount::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Payment.index');
            }
            catch (\Exception $exception) {
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Payment.destroy');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                PaymentAccount::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Payment.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Payment.destroy');
            }
        }
    }

    public function deleteall()
    {
        DB::table('paymentaccounts')->delete();
        return redirect()->route('Payment.index');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
                PaymentAccount::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Payment.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Payment.softdelete');
        }
    }

    public function forcedelete($id)
    {
        try{
            DB::beginTransaction();
                PaymentAccount::onlyTrashed()->find($id)->forcedelete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('Payment.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Payment.softdelete');
        }
    }
}
