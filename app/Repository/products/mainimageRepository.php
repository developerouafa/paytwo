<?php
namespace App\Repository\Products;

use App\Interfaces\Products\mainRepositoryInterface;
use App\Models\mainimageproduct;
use App\Models\product;
use App\Models\promotion;
use App\Models\Section;
use App\Models\stockproduct;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class mainimageRepository implements mainRepositoryInterface
{
    use UploadImageTraitt;

    //* function store Image
    public function store($request)
    {
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();

                $image = $this->uploadImageproducts($request, 'fileproducts');

                        mainimageproduct::create([
                            'product_id' => $request->product_id,
                            'mainimage' => $image
                        ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.add'));
                    return redirect()->back();
            }
            // No Add photo
            else{
                toastr()->error(trans('Dashboard/messages.imagerequired'));
                return redirect()->back();
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* function edit Image
    public function edit($request)
    {
        try{
            $id = $request->id;
            $mainimage = mainimageproduct::findOrFail($id);
            if($request->has('image')){
                $image = $mainimage->multipimage;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImageproducts($request, 'fileproducts');
                DB::beginTransaction();
                    $mainimage->update([
                        'mainimage' => $image
                    ]);

                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->back();
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* function delete Image
    public function destroy($request)
    {
        try{
            $img = mainimageproduct::findorFail($request->id);
            DB::beginTransaction();
                $img->delete();
                $image = $img->mainimage;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
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
