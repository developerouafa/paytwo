<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\BanktransferRepositoryInterface;
use App\Models\banktransfer;
use App\Models\fund_account;
use Illuminate\Support\Facades\DB;

class BanktransferRepository implements BanktransferRepositoryInterface
{

    public function index()
    {
        $fund_accounts = fund_account::whereNotNull('bank_id')->with('invoice')->with('banktransfer')->get();
        return view('Dashboard.dashboard_user.banktransfer.index',compact('fund_accounts'));
    }

    public function softdelete()
    {
        $banktransfers =  banktransfer::onlyTrashed()->latest()->get();
        return view('Dashboard.dashboard_user.banktransfer.softdelete',compact('banktransfers'));
    }

    public function show($id)
    {
        $banktransfer = banktransfer::findorfail($id);
        $fund_account = fund_account::where('bank_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_user.banktransfer.print',compact('banktransfer', 'invoice_number'));
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                banktransfer::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Banktransfer.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Banktransfer.index');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                banktransfer::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Banktransfer.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Banktransfer.index');
            }
        }
    }

    public function deleteall()
    {
        DB::table('banktransfer')->delete();
        return redirect()->route('Banktransfer.index');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
            banktransfer::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Banktransfer.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Banktransfer.softdelete');
        }
    }

    public function forcedelete($id)
    {
        try{
            DB::beginTransaction();
              banktransfer::onlyTrashed()->find($id)->forcedelete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('Banktransfer.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Banktransfer.softdelete');
        }
    }
}
