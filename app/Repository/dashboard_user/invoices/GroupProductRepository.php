<?php
namespace App\Repository\dashboard_user\invoices;

use App\Interfaces\dashboard_user\invoices\GroupProductRepositoryInterface;
use App\Models\groupprodcut;
use App\Models\pivot_product_group;
use Illuminate\Support\Facades\DB;

class GroupProductRepository implements GroupProductRepositoryInterface
{
    public function index(){
        return view('Dashboard/dashboard_user/invoices.GroupProducts.index', [
            'groupservices'=>groupprodcut::latest()->get()
        ]);
    }

    public function softdelete(){
        $groupservices = groupprodcut::onlyTrashed()->latest()->get();
        return view('Dashboard/dashboard_user/invoices.GroupProducts.softdelete',compact('groupservices'));
    }

    public function show($id){
        $product_group = pivot_product_group::where('groupprodcut_id', $id)->with('product')->with('groupprodcut')->get();
        return view('Dashboard/dashboard_user/invoices.GroupProducts.show',compact('product_group'));
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
        // Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                    groupprodcut::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('GroupServices.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('GroupServices.softdelete');
            }
        }
        // Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    groupprodcut::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('GroupServices.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('GroupServices.softdelete');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    groupprodcut::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('GroupServices.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('GroupServices.index');
            }
        }
    }

    public function deleteall(){
        DB::table('groupprodcuts')->whereNull('deleted_at')->delete();
        return redirect()->route('GroupServices.index');
    }

    public function deleteallsoftdelete(){
        DB::table('groupprodcuts')->whereNotNull('deleted_at')->delete();
        return redirect()->route('GroupServices.index');
    }

    public function restore($id){
        try{
            DB::beginTransaction();
                groupprodcut::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('SingleInvoices.softdeletesingleinvoice');
        }
    }

    public function restoreallGroupServices()
    {
        try{
            DB::beginTransaction();
                groupprodcut::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('GroupServices.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('GroupServices.softdelete');
        }
    }

    public function restoreallselectGroupServices($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    groupprodcut::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('GroupServices.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('GroupServices.softdelete');
        }
    }
}
