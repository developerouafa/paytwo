<?php
namespace App\Repository\dashboard_user\Products;

use App\Interfaces\dashboard_user\Products\promotionRepositoryInterface;
use App\Models\product;
use App\Models\promotion;
use Illuminate\Support\Facades\DB;

class promotionRepository implements promotionRepositoryInterface
{

    public function index($id)
    {
        $promotion = promotion::latest()->where('product_id', $id)->withPromotion()->get();
        $product = product::where('id', $id)->first();
        return view('Dashboard/dashboard_user/promotions.promotions', compact('promotion', 'product'));
    }


    public function store($request)
    {
        try{
            $id = $request->id;
            $product = product::findOrFail($id);
            DB::beginTransaction();
                promotion::create([
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'price' => $request->price,
                    'product_id' => $product->id,
                    'user_id' => auth()->user()->id,
                ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->back();
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* function update other Promotion
    public function update($request)
    {
        try{
            $promotion_id = $request->id;
            $promotion = Promotion::findOrFail($promotion_id);
            DB::beginTransaction();
                $promotion->update([
                    'price' => $request->price,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time
                ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->back();
        }catch(\Exception $execption){
            DB::rollBack();
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* Hide Promotion
    public function editstatusdéactive($id)
    {
        try{
            $Promotion = promotion::findorFail($id);
            DB::beginTransaction();
            $Promotion->update([
                'expired' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* show Promotion
    public function editstatusactive($id)
    {
        try{
            $Promotion = promotion::findorFail($id);
            DB::beginTransaction();
            $Promotion->update([
                'expired' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('message.update'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    //* function delete other Promotion
    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    promotion::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->back();
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->back();
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    promotion::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->back();
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->back();
            }
        }
    }

    //* function delete all Promotion
    public function deleteall()
    {
        DB::table('promotions')->delete();
        return redirect()->back();
    }
}
