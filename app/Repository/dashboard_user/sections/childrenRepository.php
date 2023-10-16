<?php
namespace App\Repository\dashboard_user\Sections;

use App\Interfaces\dashboard_user\Sections\childrenRepositoryInterface;
use App\Models\product;
use App\Models\Section;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class childrenRepository implements childrenRepositoryInterface
{
    public function index()
    {
        $childrens = Section::selectchildrens()->withchildrens()->child()->get();
        $sections = Section::selectsections()->Withsections()->parent()->get();
        return view('Dashboard/dashboard_user.childrens.childrens', compact('childrens', 'sections'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
            Section::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'parent_id' => $request->section_id,
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children_index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Children_index');
        }
    }

    public function update($request)
    {
        try{
            $children = $request->id;
            $child = Section::findOrFail($children);
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $child->update([
                        'name' => $request->name_en,
                        'parent_id' => $request->section_id,
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $child->update([
                        'name' => $request->name_ar,
                        'parent_id' => $request->section_id,
                    ]);
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('Children_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Children_index');
        }
    }

    public function showchildren($id)
    {
        $section = Section::findOrFail($id);
        $products = product::where('parent_id', $id)->get();
        return view('Dashboard/dashboard_user/childrens.showproduct',compact('section', 'products'));
    }

    public function destroy($request)
    {
        try{
            $id = $request->id;
            $children = Section::findorFail($id);
            DB::beginTransaction();
                $children->delete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('Children_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Children_index');
        }
    }
}
