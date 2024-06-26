<?php
namespace App\Repository\dashboard_user\products;

use App\Interfaces\dashboard_user\products\productRepositoryInterface;
use App\Models\mainimageproduct;
use App\Models\multipimage;
use App\Models\product;
use App\Models\section;
use App\Models\stockproduct;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class productRepository implements productRepositoryInterface
{

    public function index()
    {
        $products = product::latest()->productselect()->productwith()->get();
        $childrens = section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = section::latest()->selectsections()->withsections()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('Dashboard/dashboard_user/products.products',compact('products', 'childrens', 'sections', 'stockproduct'));
    }

    public function show($id)
    {
        $product = product::findOrFail($id);
        $childrens = section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = section::latest()->selectsections()->withsections()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('Dashboard/dashboard_user/products.Show',compact('product', 'childrens', 'sections', 'stockproduct'));
    }

    public function softdelete()
    {
        $products = product::onlyTrashed()->latest()->productselect()->productwith()->get();
        $childrens = section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = section::latest()->selectsections()->withsections()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('Dashboard/dashboard_user/products.softdelete',compact('products', 'childrens', 'sections', 'stockproduct'));
    }

    public function create(){
        $childrens = section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = section::latest()->selectsections()->withsections()->parent()->get();
        return view('Dashboard/dashboard_user/products.productscreate',compact('childrens', 'sections'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
            product::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'description' => ['en' => $request->description_en, 'ar' => $request->description_ar],
                'price' => $request->price,
                'section_id' => $request->section,
                'parent_id' => $request->children,
                'user_id' => auth()->user()->id,
            ]);

            $product_id = product::latest()->first()->id;
            stockproduct::create([
                'product_id'=> $product_id,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Products.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Products.createprod');
        }
    }

    public function getchild($id)
    {
        $childrens = DB::table("sections")->where("parent_id", $id)->pluck('id', 'name');
        return json_encode($childrens);
    }

    public function editstatusdéactive($id)
    {
        try{
            $Section = product::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Products.index');
        }
    }

    public function editstatusactive($id)
    {
        try{
            $Section = product::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Products.index');
        }
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();
            $section = product::findOrFail($request->id);
            if(App::isLocale('en')){
                $section->update([
                    'name' => $request->name_en,
                    'description' => $request->description_en,
                    'price' => $request->price,
                    'section_id' => $request->section,
                    'parent_id' => $request->children,
                ]);
            }
            elseif(App::isLocale('ar')){
                $section->update([
                    'name' => $request->name_ar,
                    'description' => $request->description_ar,
                    'price' => $request->price,
                    'section_id' => $request->section,
                    'parent_id' => $request->children,
                ]);
            }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Products.index');
        }
    }

    public function destroy($request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    product::findOrFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Products.index');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Products.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                //! Delete Image
                $img = mainimageproduct::where('product_id', $request->id)->first();
                    if($img){
                        $img->delete();
                        $image = $img->mainimage;
                        if(!$image) abort(404);
                        unlink(public_path('storage/'.$image));
                    }

                $multipimages = multipimage::where('product_id', $request->id)->get();
                    if($multipimages){
                        foreach($multipimages as $img){
                            if(!empty($img->multipimage)){
                                $image = $img->multipimage;
                                if(!$image) abort(404);
                                unlink(public_path('storage/'.$image));
                            }
                        }
                    }
                DB::beginTransaction();
                    product::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Products.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Products.softdelete');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);

                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    $img = mainimageproduct::where('product_id', $dl)->first();
                    if($img){
                        $img->delete();
                        $image = $img->mainimage;
                        if(!$image) abort(404);
                        unlink(public_path('storage/'.$image));
                    }

                    $multipimages = multipimage::where('product_id', $dl)->get();
                    if($multipimages){
                        foreach($multipimages as $img){
                            if(!empty($img->multipimage)){
                                $image = $img->multipimage;
                                if(!$image) abort(404);
                                unlink(public_path('storage/'.$image));
                            }
                        }
                    }

                    product::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Products.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Products.softdelete');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    product::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Products.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Products.index');
            }
        }
    }

    public function deleteall()
    {
        DB::table('products')->whereNull('deleted_at')->delete();
        return redirect()->route('Products.index');
    }

    public function deleteallsoftdelete()
    {
        $mainimageproduct = mainimageproduct::get();
        if($mainimageproduct){
            foreach($mainimageproduct as $img){
                if(!empty($img->multipimage)){
                    $image = $img->multipimage;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
            }
        }

        $multipimage = multipimage::get();
        if($mainimageproduct){
            foreach($multipimage as $img){
                if(!empty($img->multipimage)){
                    $image = $img->multipimage;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
            }
        }

        DB::table('products')->whereNotNull('deleted_at')->delete();
        return redirect()->route('Products.softdelete');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
                product::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Products.softdelete');
        }
    }

    public function restoreallproducts()
    {
        try{
            DB::beginTransaction();
                product::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Products.softdelete');
        }
    }

    public function restoreallselectproducts($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    product::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Products.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Products.softdelete');
        }
    }
}
