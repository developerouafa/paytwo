<?php
namespace App\Repository\Products;

use App\Interfaces\Products\multipeRepositoryInterface;
use App\Models\mainimageproduct;
use App\Models\multipimage;
use App\Models\product;
use App\Models\promotion;
use App\Models\Section;
use App\Models\stockproduct;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class multipimageRepository implements multipeRepositoryInterface
{
    use UploadImageTraitt;

    //* function Index Multipe Image
    public function index($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $mainimage  = mainimageproduct::selectmainimage()->where('product_id',$id)->get();
        $multimg  = multipimage::selectmultipimage()->where('product_id',$id)->get();
        return view('Dashboard/images.images',compact('Product', 'mainimage','multimg'));
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
                            'multipimage' => $image
                        ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.create'));
                    return redirect()->back();
            }
            // No Add photo
            else{
                toastr()->error(trans('messagevalidation.users.imagerequired'));
                return redirect()->back();
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
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
                toastr()->success(trans('Dashboard/messages.update'));
                return redirect()->back();
            }
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    //* function delete Image
    public function delete($request)
    {
        // try{
            $id = $request->id;
            $img = multipimage::findorFail($id);
            // DB::beginTransaction();
                $img->delete();
                $image = $img->multimg;
                if(!$image) abort(404);
                unlink(public_path('storage/'.$image));
            // DB::commit();
                toastr()->success(trans('message.delete'));
                return redirect()->back();
        // }catch(\Exception $execption){
        //     DB::rollBack();
        //     toastr()->error(trans('message.error'));
        //     return redirect()->back();
        // }
    }
}
