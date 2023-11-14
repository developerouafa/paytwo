<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ClientLoginRequest;
use App\Models\Client;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function store(ClientLoginRequest $request)
    {
        if ($request->authenticate()) {
            $request->session()->regenerate();
            if(Auth::user()->Status == "1"){
                return redirect()->intended(RouteServiceProvider::Client);
            }
            else{
                $id = Auth::user()->id;
                $client = Client::findorFail($id);
                $client->update([
                    'ClientStatus' => 0,
                ]);
                Auth::guard('client')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/');
            }
        }
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/messages.error'))]);
    }


    public function destroy(Request $request)
    {
        $id = Auth::user()->id;
        $client = Client::findorFail($id);
        $client->update([
            'ClientStatus' => 0,
        ]);

        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
