<?php

namespace App\Http\Controllers\Dashboard\profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\profileuser;
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
        // $id = Auth::user()->id;
        // $imageuser = User::query()->select('id')->where('id', '=', $id)->with('image')->with('profileuser')->get();
        // return view('profile.edit', ['user' => $request->user(),], compact('imageuser'));
        $id = Auth::user()->id;
        $imageuser = User::query()->select('id')->where('id', '=', $id)->with('image')->get();
        return view('profile.edit', ['user' => $request->user(),], compact('imageuser'));
    }

        //* function Update Information User
        // public function updateprofile(ProfileUpdateRequest $request)
        // {
        //     try{
        //         $id = $request->profileid;
        //         $user_id = $request->user_id;
        //         $user = User::findOrFail($user_id);
        //         $profileuser = profileuser::findOrFail($id);
        //                 DB::beginTransaction();
        //                 if(App::isLocale('en')){
        //                     $user->update([
        //                         'name' =>  $request->name_en,
        //                         'phone' => $request->phone,
        //                     ]);
        //                     $profileuser->update([
        //                         'adderss' => $request->address,
        //                         'clienType' => $request->clienType,
        //                         'nationalIdNumber' => $request->nationalIdNumber,
        //                         'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
        //                         'taxNumber' => $request->taxNumber,
        //                     ]);
        //                 }
        //                 elseif(App::isLocale('ar')){
        //                     $user->update([
        //                         'name' =>  $request->name_ar,
        //                         'phone' => $request->phone,
        //                     ]);
        //                     $profileuser->update([
        //                         'adderss' => $request->address,
        //                         'clienType' => $request->clienType,
        //                         'nationalIdNumber' => $request->nationalIdNumber,
        //                         'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
        //                         'taxNumber' => $request->taxNumber,
        //                     ]);
        //                 }
        //                 DB::commit();
        //                 toastr()->success(trans('Dashboard/messages.edit'));
        //                 return redirect()->route('profile.edit');
        //     }catch(\Exception $execption){
        //         DB::rollBack();
        //         toastr()->error(trans('Dashboard/messages.error'));
        //         return redirect()->route('profile.edit');
        //     }
        // }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
