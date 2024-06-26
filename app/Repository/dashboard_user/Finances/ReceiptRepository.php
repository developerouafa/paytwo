<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use App\Mail\CatchreceiptMailMarkdown;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\receipt_account;
use App\Notifications\catchreceipt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReceiptRepository implements ReceiptRepositoryInterface
{

    public function index()
    {
        $fund_accounts = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->get();
        return view('Dashboard.dashboard_user.Receipt.index',compact('fund_accounts'));
    }

    public function softdelete()
    {
        $receipts =  receipt_account::onlyTrashed()->latest()->get();
        return view('Dashboard.dashboard_user.Receipt.softdelete',compact('receipts'));
    }

    public function create($id)
    {
        $invoice_id = $id;
        $invoice = invoice::findorFail($id);
        $client_id = $invoice->client_id;
        return view('Dashboard.dashboard_user.Receipt.add',compact('invoice_id', 'invoice', 'client_id'));
    }

    public function show($id)
    {
        $receipt = receipt_account::findorfail($id);
        $fund_account = fund_account::where('receipt_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_user.Receipt.print',compact('receipt', 'invoice_number'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
                // store receipt_accounts
                $receipt_accounts = new receipt_account();
                $receipt_accounts->date =date('y-m-d');
                $receipt_accounts->client_id = $request->client_id;
                $receipt_accounts->amount = $request->Debit;
                $receipt_accounts->description = $request->description;
                $receipt_accounts->user_id = auth()->user()->id;
                $receipt_accounts->save();

                // store fund_accounts
                $fund_accounts = new fund_account();
                $fund_accounts->date =date('y-m-d');
                $fund_accounts->receipt_id = $receipt_accounts->id;
                $fund_accounts->invoice_id = $request->invoice_id;
                $fund_accounts->Debit = $request->Debit;
                $fund_accounts->user_id = auth()->user()->id;
                $fund_accounts->credit = 0.00;
                $fund_accounts->save();

                // store client_accounts
                $client_accounts = new client_account();
                $client_accounts->date =date('y-m-d');
                $client_accounts->client_id = $request->client_id;
                $client_accounts->receipt_id = $receipt_accounts->id;
                $client_accounts->invoice_id = $request->invoice_id;
                $client_accounts->user_id = auth()->user()->id;
                $client_accounts->Debit = 0.00;
                $client_accounts->credit =$request->Debit;
                $client_accounts->save();

                $client = Client::where('id', '=', $request->client_id)->get();
                $user_create_id = auth()->user()->id;
                $invoice_id = $request->invoice_id;
                $message = __('Dashboard/main-header_trans.nicasereceipt');
                Notification::send($client, new catchreceipt($user_create_id, $invoice_id, $message));

                $mailclient = Client::findorFail($request->client_id);
                $nameclient = $mailclient->name;
                $url = url('en/Invoices/receipt/'.$invoice_id);
                Mail::to($mailclient->email)->send(new CatchreceiptMailMarkdown($message, $nameclient, $url));
            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Receipt.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Receipt.index');
        }
    }

    public function edit($id)
    {
        $receipt_accounts = receipt_account::findorfail($id);
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Receipt.edit',compact('receipt_accounts','Clients'));
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();
            // store receipt_accounts
            $receipt_accounts = receipt_account::findorfail($request->id);
            $receipt_accounts->date =date('y-m-d');
            $receipt_accounts->amount = $request->Debit;
            $receipt_accounts->description = $request->description;
            $receipt_accounts->save();
            // store fund_accounts
            $fund_accounts = fund_account::where('receipt_id',$request->id)->first();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->receipt_id = $receipt_accounts->id;
            $fund_accounts->Debit = $request->Debit;
            $fund_accounts->credit = 0.00;
            $fund_accounts->save();
            // store client_accounts
            $client_accounts = client_account::where('receipt_id',$request->id)->first();
            $client_accounts->date =date('y-m-d');
            $client_accounts->receipt_id = $receipt_accounts->id;
            $client_accounts->Debit = 0.00;
            $client_accounts->credit =$request->Debit;
            $client_accounts->save();

            $client = Client::where('id', '=', $request->client_id)->get();
            $user_create_id = auth()->user()->id;
            $invoice_id = $request->invoice_id;
            $message = __('Dashboard/main-header_trans.nicasereceiptup');
            Notification::send($client, new catchreceipt($user_create_id, $invoice_id, $message));

            $mailclient = Client::findorFail($request->client_id);
            $nameclient = $mailclient->name;
            $url = url('en/Invoices/receipt/'.$invoice_id);
            Mail::to($mailclient->email)->send(new CatchreceiptMailMarkdown($message, $nameclient, $url));

            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Receipt.index');
        }

        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Receipt.edit');
        }
    }

    public function destroy($request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    receipt_account::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                    receipt_account::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.softdelete');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    receipt_account::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.softdelete');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    receipt_account::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.index');
            }
        }
    }

    public function deleteall()
    {
        DB::table('receipt_accounts')->whereNull('deleted_at')->delete();
        return redirect()->route('Receipt.index');
    }

    public function deleteallsoftdelete()
    {
        DB::table('receipt_accounts')->whereNotNull('deleted_at')->delete();
        return redirect()->route('Receipt.softdelete');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
              receipt_account::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Receipt.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Receipt.softdelete');
        }
    }

    public function restoreallReceiptAccount()
    {
        try{
            DB::beginTransaction();
                receipt_account::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Receipt.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Receipt.softdelete');
        }
    }

    public function restoreallselectReceiptAccount($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    receipt_account::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Receipt.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Receipt.softdelete');
        }
    }
}
