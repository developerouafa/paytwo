<?php
namespace App\Repository\dashboard_user\sections;

use App\Interfaces\dashboard_user\sections\SectionRepositoryInterface;
use App\Models\product;
use App\Models\section;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Exports\SectionsExport;
use Maatwebsite\Excel\Facades\Excel;
class SectionRepository implements SectionRepositoryInterface
{
    public function index()
    {
      $sections = section::latest()->selectsections()->withsections()->parent()->get();
      return view('Dashboard/dashboard_user.Sections.index',compact('sections'));
    }

    public function export()
    {
        return Excel::download(new SectionsExport, 'sections.xlsx');
    }

    public function softdelete()
    {
      $sections = section::onlyTrashed()->latest()->selectsections()->withsections()->parent()->get();
      return view('Dashboard/dashboard_user.Sections.softdelete',compact('sections'));
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
            section::create([
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar],
                'user_id' => auth()->user()->id,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Sections.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Sections.store');
        }
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();
            $section = section::findOrFail($request->id);
            if(App::isLocale('en')){
                $section->update([
                    'name' => $request->name_en
                ]);
            }
            elseif(App::isLocale('ar')){
                $section->update([
                    'name' => $request->name_ar
                ]);
            }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Sections.update');
        }
    }

    public function destroy($request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                section::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Sections.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Sections.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                DB::beginTransaction();
                section::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Sections.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Sections.softdelete');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    section::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Sections.softdelete');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Sections.softdelete');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                section::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Sections.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Sections.index');
            }
        }
    }

    public function showsection($id)
    {
        $section = section::findOrFail($id);
        $products = product::where('section_id', $id)->get();
        return view('Dashboard/dashboard_user/Sections.showproduct',compact('section', 'products'));
    }

    public function editstatusdéactive($id)
    {
        try{
            $Section = section::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Sections.index');
        }
    }

    public function editstatusactive($id)
    {
        try{
            $Section = section::findorFail($id);
            DB::beginTransaction();
            $Section->update([
                'status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Sections.index');
        }
    }

    public function deleteall()
    {
        DB::table('sections')->whereNull('deleted_at')->parent()->delete();
        return redirect()->route('Sections.index');
    }

    public function deleteallsoftdelete()
    {
        DB::table('sections')->whereNotNull('deleted_at')->parent()->delete();
        return redirect()->route('Sections.softdelete');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
            section::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Sections.softdelete');
        }
    }

    public function restoreallsections()
    {
        try{
            DB::beginTransaction();
            section::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Sections.softdelete');
        }
    }

    public function restoreallselectsections($request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    section::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Sections.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Sections.softdelete');
        }
    }
}
