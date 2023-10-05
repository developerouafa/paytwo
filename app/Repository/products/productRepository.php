<?php
namespace App\Repository\Products;

use App\Interfaces\Products\productRepositoryInterface;
use App\Models\product;
use App\Models\Section;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class productRepository implements productRepositoryInterface
{

    public function index()
    {
        $products = product::query()->productselect()->productwith()->get();
        $childrens = Section::query()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::query()->selectsections()->withsections()->parent()->get();
        return view('Dashboard/Products.products',compact('products', 'childrens', 'sections'));
    }

    public function create(){
        $childrens = Section::query()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::query()->selectsections()->withsections()->parent()->get();
        return view('Dashboard/Products.productscreate',compact('childrens', 'sections'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
            product::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
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

    // public function update($request)
    // {
    //     try{
    //         DB::beginTransaction();
    //         $section = Section::findOrFail($request->id);
    //         if(App::isLocale('en')){
    //             $section->update([
    //                 'name' => $request->name_en
    //             ]);
    //         }
    //         elseif(App::isLocale('ar')){
    //             $section->update([
    //                 'name' => $request->name_ar
    //             ]);
    //         }
    //         DB::commit();
    //         toastr()->success(trans('Dashboard/messages.edit'));
    //         return redirect()->route('Sections.index');
    //     }
    //     catch(\Exception $exception){
    //         DB::rollBack();
    //         toastr()->error(trans('Dashboard/messages.error'));
    //         return redirect()->route('Sections.index');
    //     }
    // }

    // public function destroy($request)
    // {
    //     try{
    //         DB::beginTransaction();
    //         Section::findOrFail($request->id)->delete();
    //         DB::commit();
    //         toastr()->success(trans('Dashboard/messages.delete'));
    //         return redirect()->route('Sections.index');
    //     }
    //     catch(\Exception $exception){
    //         DB::rollBack();
    //         toastr()->error(trans('Dashboard/messages.error'));
    //         return redirect()->route('Sections.index');
    //     }
    // }

    // public function show($id)
    // {

    // }

}
