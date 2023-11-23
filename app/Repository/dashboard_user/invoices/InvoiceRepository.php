<?php
namespace App\Repository\dashboard_user\invoices;

use App\Interfaces\dashboard_user\invoices\InvoicesRepositoryInterface;
use App\Mail\mailclient;
use App\Models\Client;
use App\Models\fund_account;
use App\Models\invoice;
use App\Notifications\banktransferntf;
use App\Notifications\invoicent;
use App\Notifications\montaryinvoice;
use App\Notifications\paymentgateways;
use App\Notifications\postpaidbillinvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class InvoiceRepository implements InvoicesRepositoryInterface
{
    public function indexsingleinvoice(){
        $invoices = invoice::latest()->where('invoice_classify',1)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();

        return view('Dashboard/dashboard_user/invoices.SingleInvoices.indexsingleinvoice', [
            'single_invoices'=>$invoices,
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid
        ]);
    }

    public function softdeletesingleinvoice(){
        $single_invoices = invoice::onlyTrashed()->latest()->where('invoice_classify',1)->get();
        return view('Dashboard/dashboard_user/invoices.SingleInvoices.softdeletesingleinvoice',compact('single_invoices'));
    }

    public function destroy($request){
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    invoice::findOrFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('SingleInvoices.indexsingleinvoice');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('SingleInvoices.indexsingleinvoice');
            }
        }
        // Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                invoice::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('SingleInvoices.softdeletesingleinvoice');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('SingleInvoices.softdeletesingleinvoice');
            }
        }
        // Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    invoice::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('SingleInvoices.softdeletesingleinvoice');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('SingleInvoices.softdeletesingleinvoice');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                invoice::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('SingleInvoices.indexsingleinvoice');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('SingleInvoices.indexsingleinvoice');
            }
        }
    }

    public function deleteallsingleinvoices(){
        DB::table('invoices')->whereNull('deleted_at')->where('invoice_classify',1)->delete();
        return redirect()->route('SingleInvoices.indexsingleinvoice');
    }

    public function deleteallsoftdelete(){
        DB::table('invoices')->whereNotNull('deleted_at')->where('invoice_classify',1)->delete();
        return redirect()->route('SingleInvoices.softdeletesingleinvoice');
    }

    public function invoicestatus($id)
    {
        try{
            $single_invoice = invoice::findorfail($id);
            DB::beginTransaction();

            $single_invoice->invoice_status = '2';
            $single_invoice->save();

            // في حالة كانت الفاتورة لم يتم الاختيار بعد
            // if($single_invoice->type == 0){
            //     $single_invoice->invoice_status = '2';
            //     $single_invoice->save();

            //     $client = Client::where('id', '=', $single_invoice->client_id)->get();
            //     $user_create_id = $single_invoice->user_id;
            //     $invoice_id = $single_invoice->id;
            //     $message = __('Dashboard/main-header_trans.nicase');
            //     Notification::send($client, new invoicent($user_create_id, $invoice_id, $message));

            //     $mailclient = Client::findorFail($single_invoice->client_id);
            //     $nameclient = $mailclient->name;
            //     $url = url('en/Invoices/print/'.$invoice_id);
            //     Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
            // }

            // // في حالة كانت الفاتورة نقدي
            // if($single_invoice->type == 1){
            //     $single_invoice->invoice_status = '2';
            //     $single_invoice->save();

            //     $client = Client::where('id', '=', $single_invoice->client_id)->get();
            //     $user_create_id = $single_invoice->user_id;
            //     $invoice_id = $single_invoice->id;
            //     $message = __('Dashboard/main-header_trans.nicasemontary');
            //     Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

            //     $mailclient = Client::findorFail($single_invoice->client_id);
            //     $nameclient = $mailclient->name;
            //     $url = url('en/Invoices/print/'.$invoice_id);
            //     Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
            // }

            // // في حالة كانت الفاتورة اجل
            // if($single_invoice->type == 2){
            //     $single_invoice->invoice_status = '2';
            //     $single_invoice->save();

            //     $client = Client::where('id', '=', $single_invoice->client_id)->get();
            //     $user_create_id = $single_invoice->user_id;
            //     $invoice_id = $single_invoice->id;
            //     $message = __('Dashboard/main-header_trans.nicasepostpaid');
            //     Notification::send($client, new postpaidbillinvoice($user_create_id, $invoice_id, $message));

            //     $mailclient = Client::findorFail($single_invoice->client_id);
            //     $nameclient = $mailclient->name;
            //     $url = url('en/Invoices/print/'.$invoice_id);
            //     Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
            // }

            // // في حالة كانت الفاتورة حوالة بنكية
            // if($single_invoice->type == 3){
            //     $single_invoice->invoice_status = '2';
            //     $single_invoice->save();

            //     $client = Client::where('id', '=', $single_invoice->client_id)->get();
            //     $user_create_id = $single_invoice->user_id;
            //     $invoice_id = $single_invoice->id;
            //     $message = __('Dashboard/main-header_trans.nicasepymgtw');
            //     Notification::send($client, new banktransferntf($user_create_id, $invoice_id, $message));

            //     $mailclient = Client::findorFail($single_invoice->client_id);
            //     $nameclient = $mailclient->name;
            //     $url = url('en/Invoices/print/'.$invoice_id);
            //     Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
            // }

            // // في حالة كانت الفاتورة بطاقة
            // if($single_invoice->type == 4){
            //     $single_invoice->invoice_status = '2';
            //     $single_invoice->save();

            //     $client = Client::where('id', '=', $single_invoice->client_id)->get();
            //     $user_create_id = $single_invoice->user_id;
            //     $invoice_id = $single_invoice->id;
            //     $message = __('Dashboard/main-header_trans.nicasebanktransfer');
            //     Notification::send($client, new paymentgateways($user_create_id, $invoice_id, $message));

            //     $mailclient = Client::findorFail($single_invoice->client_id);
            //     $nameclient = $mailclient->name;
            //     $url = url('en/Invoices/print/'.$invoice_id);
            //     Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));

            // }

            DB::commit();
            toastr()->success(trans('Dashboard/messages.beensent'));
            return redirect()->route('SingleInvoices.indexsingleinvoice');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('SingleInvoices.indexsingleinvoice');
        }
    }

    public function restoresingleinvoice($id){
        try{
            DB::beginTransaction();
                invoice::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }
    }

    public function restoreallsingleinvoices()
    {
        try{
            DB::beginTransaction();
                invoice::withTrashed()->where('invoice_classify', 1)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }
    }

    public function restoreallselectsingleinvoices($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    invoice::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }
    }

    public function indexgroupInvoices(){
        $invoices = invoice::latest()->where('invoice_classify',2)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();

        return view('Dashboard/dashboard_user/invoices.GroupInvoices.indexgroupInvoice', [
            'group_invoices'=>$invoices,
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid,
        ]);
    }

    public function softdeletegroupInvoices(){
        $group_invoices = invoice::onlyTrashed()->latest()->where('invoice_classify',2)->get();
        return view('Dashboard/dashboard_user/invoices.GroupInvoices.softdeletesgroupInvoice',compact('group_invoices'));
    }

    public function deleteallgroupInvoices(){
        DB::table('invoices')->whereNull('deleted_at')->where('invoice_classify',2)->delete();
        return redirect()->route('GroupInvoices.indexgroupInvoices');
    }

    public function deleteallsoftdeletegr(){
        DB::table('invoices')->whereNotNull('deleted_at')->where('invoice_classify',2)->delete();
        return redirect()->route('GroupInvoices.softdeletegroupInvoices');
    }

    public function restoregroupInvoice($id){
        try{
            DB::beginTransaction();
                invoice::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }
    }

    public function restoreallgroupInvoices()
    {
        try{
            DB::beginTransaction();
                invoice::withTrashed()->where('invoice_classify', 2)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }
    }

    public function restoreallselectgroupInvoices($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    invoice::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('GroupInvoices.softdeletegroupInvoices');
        }
    }
}
