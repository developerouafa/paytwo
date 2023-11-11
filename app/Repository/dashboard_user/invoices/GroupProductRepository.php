<?php
namespace App\Repository\dashboard_user\Invoices;

use App\Interfaces\dashboard_user\Invoices\GroupProductRepositoryInterface;
use App\Models\fund_account;
use App\Models\invoice;
use Illuminate\Support\Facades\DB;

class GroupProductRepository implements GroupProductRepositoryInterface
{
    public function index(){
        $invoices = invoice::latest()->where('invoice_classify',1)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();

        return view('Dashboard/dashboard_user/invoices.SingleInvoices.indexsingleinvoice', [
            'single_invoices'=>$invoices,
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid
        ]);
    }

    public function softdelete(){
        $single_invoices = invoice::onlyTrashed()->latest()->where('invoice_classify',1)->get();
        return view('Dashboard/dashboard_user/invoices.SingleInvoices.softdeletesingleinvoice',compact('single_invoices'));
    }

    public function show($id){
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

    public function deleteall(){
        DB::table('invoices')->where('invoice_classify',1)->delete();
        return redirect()->route('SingleInvoices.indexsingleinvoice');
    }

    public function restore($id){
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
}
