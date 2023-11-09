<?php
namespace App\Repository\dashboard_user\Products;

use App\Interfaces\dashboard_user\Invoices\InvoiceRepositoryInterface;
use App\Models\invoice;
use Illuminate\Support\Facades\DB;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function indexsingleinvoice(){
        $invoices = invoice::latest()->get();
        return view('Dashboard/dashboard_user/Invoices.SingleInvoices.invoices',compact('invoices'));
    }

    public function softdeletesingleinvoice(){
        $invoices = invoice::onlyTrashed()->latest()->get();
        return view('Dashboard/dashboard_user/Invoices.SingleInvoices.invoices',compact('invoices'));
    }

    public function destroysingleinvoice($request){
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    invoice::findOrFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Invoices.SingleInvoices.indexsingleinvoice');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Invoices.SingleInvoices.indexsingleinvoice');
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
                return redirect()->route('Invoices.SingleInvoices.indexsingleinvoice');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Invoices.SingleInvoices.indexsingleinvoice');
            }
        }
    }

    public function deleteallsingleinvoice(){
        DB::table('invoices')->delete();
        return redirect()->route('Invoices.SingleInvoices.indexsingleinvoice');
    }

    public function restoresingleinvoice($id){
        try{
            DB::beginTransaction();
                invoice::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Invoices.SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Invoices.SingleInvoices.softdeletesingleinvoice');
        }
    }

    public function forcedeletesingleinvoice($id){
        try{
            DB::beginTransaction();
            invoice::onlyTrashed()->find($id)->forcedelete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('Invoices.SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Invoices.SingleInvoices.softdeletesingleinvoice');
        }
    }
}
