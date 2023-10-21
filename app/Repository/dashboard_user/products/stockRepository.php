<?php
namespace App\Repository\dashboard_user\Products;

use App\Interfaces\dashboard_user\Products\stockRepositoryInterface;
use App\Models\stockproduct;
use Illuminate\Support\Facades\DB;

class stockRepository implements stockRepositoryInterface
{
    //* No Exist In Stock
    public function editstocknoexist($id)
    {
        try{
            $stock = stockproduct::latest()->findorFail($id);
            DB::beginTransaction();
            $stock->update([
                'stock' => 1,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Products.index');
        }
    }

    //* Exist In Stock
    public function editstockexist($id)
    {
        try{
            $stock = stockproduct::findorFail($id);
            DB::beginTransaction();
            $stock->update([
                'stock' => 0,
            ]);
            DB::commit();
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Products.index');
        }
    }
}
