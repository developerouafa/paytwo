<?php
namespace App\Repository\dashboard_user\Products;

use App\Interfaces\dashboard_user\Products\multipeRepositoryInterface;
use App\Models\mainimageproduct;
use App\Models\multipimage;
use App\Models\product;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\DB;

class multipimageRepository implements multipeRepositoryInterface
{
    use UploadImageTraitt;

    //* function Index Multipe Image
    public function index($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $mainimage  = mainimageproduct::selectmainimage()->where('product_id',$id)->get();
        $multimg  = multipimage::selectmultipimage()->where('product_id',$id)->get();
        return view('Dashboard/dashboard_user/images.images',compact('Product', 'mainimage','multimg'));
    }

    //* function store Image
    public function store($request)
    {
        try{
            //Added photo
            if($request->has('image')){
                DB::beginTransaction();

                $image = $this->uploadImageproducts($request, 'fileproducts');

                        multipimage::create([
                            'product_id' => $request->product_id,
                            'multipimage' => $image,
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

    // //* function edit Image
    public function edit($request)
    {
        try{
            $id = $request->id;
            $mainimage = multipimage::findOrFail($id);
            if($request->has('image')){
                $image = $mainimage->multipimage;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
                $image = $this->uploadImageproducts($request, 'fileproducts');
                DB::beginTransaction();
                    $mainimage->update([
                        'multipimage' => $image
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
            $img = multipimage::findorFail($request->id);
            DB::beginTransaction();
                $img->delete();
                $image = $img->multipimage;
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

    //* function delete All Image
    public function deletetruncate()
    {
        DB::table('multipimages')->delete();
        return redirect()->back();
    }
}
