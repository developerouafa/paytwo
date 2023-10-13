<?php

namespace App\Http\Controllers\Dashboard\Clients\profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Profiles\ProfileclientRequest;
use App\Interfaces\Clients\Profiles\ProfileclientRepositoryInterface;
use Illuminate\Http\Request;

class ProfileclientController extends Controller
{

    private $Profile_Clients;

    public function __construct(ProfileclientRepositoryInterface $Profile_Clients)
    {
        $this->Profile_Clients = $Profile_Clients;
    }

    public function edit(Request $request)
    {
      return  $this->Profile_Clients->edit($request);
    }

    public function updateprofileclient(ProfileclientRequest $request)
    {
      return  $this->Profile_Clients->edit($request);
    }
}
