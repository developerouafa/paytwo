<?php

namespace App\Http\Controllers\Dashboard\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\imageuser;
use App\Models\profileuser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->with('profileuser')->paginate(5);
        return view('Dashboard/users.show_users',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('Dashboard/users.Add_user',compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
                $user = User::create([
                    'name' => ['en' => $request->nameen, 'ar' => $request->namear],
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                $user->assignRole($request->input('roles_name'));
                $user_id = User::latest()->first()->id;
                profileuser::create([
                    'clienType' => $request->clienType,
                    'nationalIdNumber' => $request->nationalIdNumber,
                    'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
                    'taxNumber' => $request->taxNumber,
                    'adderss' => $request->adderss,
                    'user_id' => $user_id,
                ]);
                // imageuser::create([
                //     'user_id' => $user_id,
                // ]);
            DB::commit();
            toastr()->success(__('Dashboard/messages.add'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('Dashboard/users.show',compact('user'));
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('Dashboard/users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        // Validation
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'name_'.app()->getLocale() => 'required',
            ],[
                'email.required' =>__('Dashboard/users.emailrequired'),
                'email.unique' =>__('Dashboard/users.emailunique'),
                'password.required' =>__('Dashboard/users.passwordrequired'),
                'password.same' =>__('Dashboard/users.passwordsame'),
                'roles_name.required' =>__('Dashboard/users.rolesnamerequired'),
                'name.required' => __('Dashboard/users.namerequired')
            ]);
        try{
            DB::beginTransaction();

                $user = User::find($id);
                $password = $user->password;

                if(App::isLocale('en')){
                    if(!empty($input['password'])){
                        $user->update([
                            'name' => $request->name_en,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $user->update([
                            'name' => $request->name_en,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => $password,
                        ]);
                    }
                }
                elseif(App::isLocale('ar')){
                    if(!empty($input['password'])){
                        $user->update([
                            'name' => $request->name_ar,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $user->update([
                            'name' => $request->name_ar,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => $password,
                        ]);
                    }
                }

                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $user->assignRole($request->input('roles'));

            DB::commit();
            toastr()->success(__('Dashboard/messages.edit'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }
    public function destroy(Request $request)
    {
        try{
            $id = $request->user_id;

            $tableimageuser = imageuser::where('user_id',$id)->first();
            $image = $tableimageuser->image;

            if(!$image) abort(404);
            unlink(public_path('storage/'.$image));

            DB::beginTransaction();
            User::find($id)->delete();

            DB::commit();
            toastr()->success(__('Dashboard/messages.delete'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }
}
