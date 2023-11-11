<?php
namespace App\Repository\dashboard_user\Invoices;

use App\Interfaces\dashboard_user\Invoices\GroupProductRepositoryInterface;
use App\Models\fund_account;
use App\Models\groupprodcut;
use App\Models\invoice;
use Illuminate\Support\Facades\DB;

class GroupProductRepository implements GroupProductRepositoryInterface
{
    public function index(){
        return view('Dashboard/dashboard_user/invoices.GroupProducts.index', [
            'groupservices'=>groupprodcut::latest()->get()
        ]);
    }

    public function softdelete(){
        $single_invoices = groupprodcut::onlyTrashed()->latest()->where('invoice_classify',1)->get();
        return view('Dashboard/dashboard_user/invoices.GroupProducts.softdelete',compact('single_invoices'));
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
                    groupprodcut::findOrFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('GroupServices.index');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('GroupServices.index');
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
