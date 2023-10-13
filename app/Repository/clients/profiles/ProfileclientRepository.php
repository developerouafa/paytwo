<?php
namespace App\Repository\Clients\Profiles;

use App\Http\Requests\Clients\Profiles\ProfileclientRequest;
use App\Interfaces\Clients\Profiles\ProfileclientRepositoryInterface;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileclientRepository implements ProfileclientRepositoryInterface
{
    public function edit($request)
    {
        return view('Dashboard/dashboard_client/profile.edit', ['user' => $request->user()]);
    }

    //* function Update Information Client
    public function updateprofileclient($request)
    {
        try{

        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profile.edit');
        }
    }
}
