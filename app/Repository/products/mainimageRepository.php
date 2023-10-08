<?php
namespace App\Repository\Products;

use App\Interfaces\Products\mainRepositoryInterface;
use App\Models\product;
use App\Models\promotion;
use App\Models\Section;
use App\Models\stockproduct;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class mainimageRepository implements mainRepositoryInterface
{
    //* No Exist In Stock
    public function editstocknoexist($id)
    {
        try{
            $stock = stockproduct::findorFail($id);
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
