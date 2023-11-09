<?php
namespace App\Repository\dashboard_user\Invoices;

use App\Interfaces\dashboard_user\Invoices\InvoicesRepositoryInterface;
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

        $invoices_nomethodpay = invoice::latest()->where('invoice_classify',1)->where('type', 0)->get();
        $invoices_catchpayment = invoice::latest()->where('invoice_classify',1)->where('type', 1)->get();
        $invoices_postpaid = invoice::latest()->where('invoice_classify',1)->where('type', 2)->get();
        $invoices_banktransfer = invoice::latest()->where('invoice_classify',1)->where('type', 3)->get();
        $invoices_card = invoice::latest()->where('invoice_classify',1)->where('type', 4)->get();

        $invoices_statusNew = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 1)->get();
        $invoices_statusSent = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 2)->get();
        $invoices_statusUnderreview = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 3)->get();
        $invoices_statusComplete = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 3)->get();

        $invoices_typeDraft = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 1)->get();
        $invoices_typePaid = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 2)->get();
        $invoices_typeCanceled = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 3)->get();

        return view('Dashboard/dashboard_user/invoices.SingleInvoices.indexsingleinvoice', [
            'single_invoices'=>$invoices,
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid,
            'invoices_nomethodpay'=> $invoices_nomethodpay,
            'invoices_catchpayment'=> $invoices_catchpayment,
            'invoices_postpaid'=> $invoices_postpaid,
            'invoices_banktransfer'=> $invoices_banktransfer,
            'invoices_card'=> $invoices_card,
            'invoices_statusNew'=> $invoices_statusNew,
            'invoices_statusSent'=> $invoices_statusSent,
            'invoices_statusUnderreview'=> $invoices_statusUnderreview,
            'invoices_statusComplete'=> $invoices_statusComplete,
            'invoices_typeDraft'=> $invoices_typeDraft,
            'invoices_typePaid'=> $invoices_typePaid,
            'invoices_typeCanceled'=> $invoices_typeCanceled,
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

    public function deleteallsingleinvoice(){
        DB::table('invoices')->where('invoice_classify',1)->delete();
        return redirect()->route('SingleInvoices.indexsingleinvoice');
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
            toastr()->success(trans('Dashboard/messages.edit'));
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

    public function indexgroupInvoices(){
        $invoices = invoice::latest()->where('invoice_classify',2)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();

        $invoices_nomethodpay = invoice::latest()->where('invoice_classify',2)->where('type', 0)->get();
        $invoices_catchpayment = invoice::latest()->where('invoice_classify',2)->where('type', 1)->get();
        $invoices_postpaid = invoice::latest()->where('invoice_classify',2)->where('type', 2)->get();
        $invoices_banktransfer = invoice::latest()->where('invoice_classify',2)->where('type', 3)->get();
        $invoices_card = invoice::latest()->where('invoice_classify',2)->where('type', 4)->get();

        $invoices_statusNew = invoice::latest()->where('invoice_classify',2)->where('invoice_status', 1)->get();
        $invoices_statusSent = invoice::latest()->where('invoice_classify',2)->where('invoice_status', 2)->get();
        $invoices_statusUnderreview = invoice::latest()->where('invoice_classify',2)->where('invoice_status', 3)->get();
        $invoices_statusComplete = invoice::latest()->where('invoice_classify',2)->where('invoice_status', 3)->get();

        $invoices_typeDraft = invoice::latest()->where('invoice_classify',2)->where('invoice_type', 1)->get();
        $invoices_typePaid = invoice::latest()->where('invoice_classify',2)->where('invoice_type', 2)->get();
        $invoices_typeCanceled = invoice::latest()->where('invoice_classify',2)->where('invoice_type', 3)->get();

        return view('Dashboard/dashboard_user/invoices.GroupInvoices.indexgroupInvoice', [
            'group_invoices'=>$invoices,
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid,
            'invoices_nomethodpay'=> $invoices_nomethodpay,
            'invoices_catchpayment'=> $invoices_catchpayment,
            'invoices_postpaid'=> $invoices_postpaid,
            'invoices_banktransfer'=> $invoices_banktransfer,
            'invoices_card'=> $invoices_card,
            'invoices_statusNew'=> $invoices_statusNew,
            'invoices_statusSent'=> $invoices_statusSent,
            'invoices_statusUnderreview'=> $invoices_statusUnderreview,
            'invoices_statusComplete'=> $invoices_statusComplete,
            'invoices_typeDraft'=> $invoices_typeDraft,
            'invoices_typePaid'=> $invoices_typePaid,
            'invoices_typeCanceled'=> $invoices_typeCanceled,
        ]);
    }

    public function softdeletegroupInvoices(){
        $single_invoices = invoice::onlyTrashed()->latest()->where('invoice_classify',2)->get();
        return view('Dashboard/dashboard_user/invoices.GroupInvoices.softdeletegroupInvoices',compact('single_invoices'));
    }

    public function deleteallgroupInvoices(){
        DB::table('invoices')->where('invoice_classify',2)->delete();
        return redirect()->route('GroupInvoices.indexgroupInvoices');
    }

    public function restoregroupInvoices($id){
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
}
