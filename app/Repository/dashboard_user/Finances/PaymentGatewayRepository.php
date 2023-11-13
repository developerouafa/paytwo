<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\PaymentgatewayRepositoryInterface;
use App\Models\fund_account;
use App\Models\paymentgateway;
use Illuminate\Support\Facades\DB;

class PaymentGatewayRepository implements PaymentgatewayRepositoryInterface
{

    public function index()
    {
        $fund_accounts = fund_account::whereNotNull('Gateway_id')->with('invoice')->with('paymentgateway')->get();
        return view('Dashboard.dashboard_user.paymentgateway.index',compact('fund_accounts'));
    }

    public function softdelete()
    {
        $paymentgateways =  paymentgateway::onlyTrashed()->latest()->get();
        return view('Dashboard.dashboard_user.paymentgateway.softdelete',compact('paymentgateways'));
    }

    public function show($id)
    {
        $paymentgateway = paymentgateway::findorfail($id);
        $fund_account = fund_account::where('Gateway_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_user.paymentgateway.print',compact('paymentgateway', 'invoice_number'));
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                paymentgateway::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('paymentgateway.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('paymentgateway.index');
            }
        }
        // Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                paymentgateway::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('paymentgateway.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('paymentgateway.softdelete');
            }
        }
        // Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    paymentgateway::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('paymentgateway.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('paymentgateway.softdelete');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                paymentgateway::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('paymentgateway.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('paymentgateway.index');
            }
        }
    }

    public function deleteall()
    {
        DB::table('paymentgateways')->delete();
        return redirect()->route('paymentgateway.index');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
            paymentgateway::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('paymentgateway.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('paymentgateway.softdelete');
        }
    }

    public function restoreallPaymentgateway()
    {
        try{
            DB::beginTransaction();
                paymentgateway::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('paymentgateway.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('paymentgateway.softdelete');
        }
    }

    public function restoreallselectPaymentgateway($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    paymentgateway::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('paymentgateway.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('paymentgateway.softdelete');
        }
    }
}
