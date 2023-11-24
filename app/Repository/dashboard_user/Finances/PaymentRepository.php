<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\PaymentRepositoryInterface;
use App\Mail\CatchpaymentMailMarkdown;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\PaymentAccount;
use App\Notifications\catchpayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function index()
    {
        $fund_accounts = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->get();
        return view('Dashboard.dashboard_user.Payment.index',compact('fund_accounts'));
    }

    public function softdelete()
    {
        $payments =  PaymentAccount::onlyTrashed()->latest()->get();
        return view('Dashboard.dashboard_user.Payment.softdelete',compact('payments'));
    }

    public function create($id)
    {
        $invoice_id = $id;
        $invoice = invoice::findorFail($id);
        $client_id = $invoice->client_id;
        return view('Dashboard.dashboard_user.Payment.add',compact('invoice_id', 'invoice', 'client_id'));
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
            $payment_accounts = PaymentAccount::create([
                'date' => date('y-m-d'),
                'client_id' => $request->client_id,
                'amount' => $request->credit,
                'description' => $request->description,
                'user_id' => auth()->user()->id
            ]);

            // store fund_accounts
            fund_account::create([
                'date' => date('y-m-d'),
                'Payment_id' => $payment_accounts->id,
                'invoice_id' => $request->invoice_id,
                'credit' => $request->credit,
                'user_id' => auth()->user()->id,
                'Debit' => 0.00
            ]);

            // store client_accounts
            client_account::create([
                'date' => date('y-m-d'),
                'client_id' => $request->client_id,
                'Payment_id' => $payment_accounts->id,
                'invoice_id' => $request->invoice_id,
                'Debit' => $request->credit,
                'user_id' => auth()->user()->id,
                'credit' => 0.00
            ]);

            $client = Client::where('id', '=', $request->client_id)->get();
            $user_create_id = auth()->user()->id;
            $invoice_id = $request->invoice_id;
            $message = __('Dashboard/main-header_trans.nicasepayment');
            Notification::send($client, new catchpayment($user_create_id, $invoice_id, $message));

            $mailclient = Client::findorFail($request->client_id);
            $nameclient = $mailclient->name;
            $url = url('en/Invoices/receiptpostpaid/'.$invoice_id);
            Mail::to($mailclient->email)->send(new CatchpaymentMailMarkdown($message, $nameclient, $url));

            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Payment.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Payment.index');
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

            $client = Client::where('id', '=', $request->client_id)->get();
            $user_create_id = auth()->user()->id;
            $invoice_id = $request->invoice_id;
            $message = __('Dashboard/main-header_trans.nicasepaymentup');
            Notification::send($client, new catchpayment($user_create_id, $invoice_id, $message));

            // $mailclient = Client::findorFail($request->client_id);
            // $nameclient = $mailclient->name;
            // $url = url('en/Invoices/receiptpostpaid/'.$invoice_id);
            // Mail::to($mailclient->email)->send(new CatchpaymentMailMarkdown($message, $nameclient, $url));

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
        // Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                PaymentAccount::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Payment.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Payment.softdelete');
            }
        }
        // Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    PaymentAccount::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Payment.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Payment.softdelete');
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
        DB::table('paymentaccounts')->whereNull('deleted_at')->delete();
        return redirect()->route('Payment.index');
    }

    public function deleteallsoftdelete()
    {
        DB::table('paymentaccounts')->whereNotNull('deleted_at')->delete();
        return redirect()->route('Payment.softdelete');
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

    public function restoreallPaymentaccount()
    {
        try{
            DB::beginTransaction();
                PaymentAccount::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Payment.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Payment.softdelete');
        }
    }

    public function restoreallselectPaymentaccount($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    PaymentAccount::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Payment.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Payment.softdelete');
        }
    }

}
