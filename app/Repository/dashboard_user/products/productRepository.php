<?php
namespace App\Repository\dashboard_user\Products;

use App\Interfaces\dashboard_user\Products\productRepositoryInterface;
use App\Models\product;
use App\Models\Section;
use App\Models\stockproduct;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class productRepository implements productRepositoryInterface
{

    public function index()
    {
        $products = product::latest()->productselect()->productwith()->get();
        $childrens = Section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::latest()->selectsections()->withsections()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('Dashboard/dashboard_user/Products.products',compact('products', 'childrens', 'sections', 'stockproduct'));
    }

    public function create(){
        $childrens = Section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::latest()->selectsections()->withsections()->parent()->get();
        return view('Dashboard/dashboard_user/Products.productscreate',compact('childrens', 'sections'));
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
            return redirect()->route('Products.index');
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
        // Delete One Request
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
        // Delete Group Request
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
        DB::table('products')->delete();
        return redirect()->route('Products.index');
    }
}
