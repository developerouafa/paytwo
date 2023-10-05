<?php
namespace App\Repository\Sections;

use App\Interfaces\Sections\childrenRepositoryInterface;
use App\Models\Section;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class childrenRepository implements childrenRepositoryInterface
{
    public function index()
    {
        $childrens = Section::selectchildrens()->withchildrens()->child()->get();
        $sections = Section::selectsections()->Withsections()->parent()->get();
        return view('Dashboard.childrens.childrens', compact('childrens', 'sections'));
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
            return redirect()->route('childcat_index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('childcat_index');
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
                return redirect()->route('childcat_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('childcat_index');
        }
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
            return redirect()->route('childcat_index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('childcat_index');
        }
    }
}
