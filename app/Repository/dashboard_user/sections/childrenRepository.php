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
        $childrens = Section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::selectsections()->Withsections()->parent()->get();
        return view('Dashboard/dashboard_user.childrens.childrens', compact('childrens', 'sections'));
    }

    public function softdelete()
    {
        $childrens = Section::onlyTrashed()->latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = Section::selectsections()->Withsections()->parent()->get();
        return view('Dashboard/dashboard_user.childrens.softdelete',compact('childrens', 'sections'));
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

    public function editstatusdéactive($id)
    {
        try{
            $Section = Section::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children_index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Children_index');
        }
    }

    public function editstatusactive($id)
    {
        try{
            $Section = Section::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children_index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Children_index');
        }
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    Section::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Children_index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Children_index');
            }
        }
        // Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                    Section::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Children.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Children.softdelete');
            }
        }
        // Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    Section::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Children.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Children.softdelete');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    Section::destroy($delete_select_id);
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

    public function deleteall()
    {
        DB::table('sections')->whereNull('deleted_at')->child()->delete();
        return redirect()->route('Children.index');
    }

    public function deleteallsoftdelete()
    {
        DB::table('sections')->whereNotNull('deleted_at')->child()->delete();
        return redirect()->route('Children.index');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
                Section::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Children.softdelete');
        }
    }

    public function restoreallchildrens()
    {
        try{
            DB::beginTransaction();
                Section::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Children.softdelete');
        }
    }

    public function restoreallselectchildrens($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    Section::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Children.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Children.softdelete');
        }
    }
}
