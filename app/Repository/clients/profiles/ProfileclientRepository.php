<?php
namespace App\Repository\clients\profiles;

use App\Http\Requests\clients\profiles\ProfileclientRequest;
use App\Interfaces\clients\profiles\ProfileclientRepositoryInterface;
use App\Models\Client;
use App\Models\profileclient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;
use Illuminate\Support\Facades\Redirect;

class ProfileclientRepository implements ProfileclientRepositoryInterface
{
    public function edit($request)
    {
        return view('Dashboard.dashboard_client.profile_client.edit', ['user' => $request->user()]);
    }

    public function update($request)
    {
        try{
            $id = $request->profileclientid;
            $client_id = $request->client_id;
            $client = Client::findOrFail($client_id);
            $profileclient = profileclient::findOrFail($id);
                DB::beginTransaction();
                    $client->update([
                        'name' =>  $request->name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                    ]);
                    if($request->clienType == '1'){
                        $profileclient->update([
                            'adderss' => $request->address,
                            'city' => $request->city,
                            'postalcode' => $request->postalcode,
                            'clienType' => $request->clienType,
                            'commercialRegistrationNumber' => Null,
                            'nationalIdNumber' => $request->nationalIdNumber,
                            'taxNumber' => $request->taxNumber,
                        ]);
                    }
                    if($request->clienType == '0'){
                        $profileclient->update([
                            'adderss' => $request->address,
                            'city' => $request->city,
                            'postalcode' => $request->postalcode,
                            'clienType' => $request->clienType,
                            'nationalIdNumber' => $request->nationalIdNumber,
                            'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
                            'taxNumber' => $request->taxNumber,
                        ]);
                    }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('profileclient.edit');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('profileclient.edit');
        }
    }

    public function destroy($request)
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
