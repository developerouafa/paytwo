<?php

namespace App\Http\Controllers;

use App\Models\imageuser;
use App\Traits\UploadImageTraitt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageuserController extends Controller
{
    Use UploadImageTraitt;

    //* function Store Image User
    public function store(Request $request)
    {
        try{
            $input = $request->all();
            if(!empty($input['imageuser'])){
                $path = $this->uploadImage($request, 'file1');
                DB::beginTransaction();
                imageuser::create([
                    'user_id' => $request->id,
                    'image'=>$path
                ]);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.add'));
                return redirect()->route('profile.edit');
            }else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->success(trans('Dashboard/messages.err'));
            return redirect()->route('profile.edit');
        }
    }

    //* function Update Image User
    public function update(Request $request)
    {
        $request->validate([
            'imageuser' => ['required'],
        ],[
            'imageuser.required' =>__('Dashboard/messages.imageuserrequired'),
        ]);
        try{
            $idimageuser = Auth::user()->id;
            $tableimageuser = imageuser::where('user_id','=',$idimageuser)->first();
            if($request->has('imageuser')){
                    $image = $tableimageuser->image;
                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                    $image = $this->uploadImage($request, 'file1');
                    DB::beginTransaction();
                    $tableimageuser->update([
                        'image' => $image
                    ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.edit'));
                    return redirect()->route('profile.edit');
            }
            else{
                toastr()->error(trans('Dashboard/messages.imageuserrequired'));
                return redirect()->route('profile.edit');
            }
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }

    //* function Delete Image User
    public function destroy(ImageUser $imageUser)
    {
        try{
            $id = Auth::user()->id;
            $tableimageuser = imageuser::where('user_id','=',$id)->first();
            DB::beginTransaction();
            $tableimageuser->delete();
            $image = $tableimageuser->image;
            if(!$image) abort(404);
            unlink(public_path('storage/'.$image));
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }
}
