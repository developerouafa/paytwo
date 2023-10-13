<?php
namespace App\Repository\Clients\Profiles;

use App\Http\Requests\Clients\Profiles\ProfileclientRequest;
use App\Interfaces\Clients\Profiles\ProfileclientRepositoryInterface;
use App\Models\Client;
use App\Models\profileclient;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileclientRepository implements ProfileclientRepositoryInterface
{
    public function edit($request)
    {
        return view('Dashboard/dashboard_client/profile.edit', ['user' => $request->user()]);
    }

    //* function Update Information Client
    public function update($request)
    {
        // try{
            $id = $request->profileclientid;
            $client_id = $request->client_id;
            $client = Client::findOrFail($client_id);
            $profileclient = profileclient::findOrFail($id);
                    DB::beginTransaction();
                        $client->update([
                            'name' =>  $request->name,
                            'phone' => $request->phone,
                        ]);
                        $profileclient->update([
                            'adderss' => $request->address,
                            'clienType' => $request->clienType,
                            'nationalIdNumber' => $request->nationalIdNumber,
                            'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
                            'taxNumber' => $request->taxNumber,
                        ]);
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.edit'));
                    return redirect()->route('profileclient.edit');
        // }catch(\Exception $execption){
        //     DB::rollBack();
        //     toastr()->error(trans('Dashboard/messages.error'));
        //     return redirect()->route('profileclient.edit');
        // }
    }
}
