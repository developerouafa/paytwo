<?php
namespace App\Repository\dashboard_user\products;

use App\Interfaces\dashboard_user\products\mainRepositoryInterface;
use App\Models\mainimageproduct;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\DB;

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
                            'mainimage' => $image,
                            'user_id' => auth()->user()->id,
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
