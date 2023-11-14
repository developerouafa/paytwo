<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    //* Display the user's profile form
    public function edit(Request $request): View
    {
        $imageuser = User::query()->select('id')->where('id', Auth::user()->id)->with('image')->get();
        return view('profile.edit', ['user' => $request->user(),], compact('imageuser'));
    }

    //* function Update Information User
    public function updateprofile(ProfileUpdateRequest $request)
    {
        try{
            $user_id = Auth::user()->id;
            $user = User::findOrFail($user_id);
                DB::beginTransaction();
                if(App::isLocale('en')){
                    $user->update([
                        'name' =>  $request->name_en,
                        'phone' => $request->phone,
                    ]);
                }
                elseif(App::isLocale('ar')){
                    $user->update([
                        'name' =>  $request->name_ar,
                        'phone' => $request->phone,
                    ]);
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('profile.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }

    //* function Delete Information User & Logout
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
