<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\ClientRequest;
use App\Interfaces\Clients\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    private $Clients;

    public function __construct(ClientRepositoryInterface $Clients)
    {
        $this->Clients = $Clients;
    }

    public function index()
    {
      return  $this->Clients->index();

    }

    public function create()
    {
      return  $this->Clients->create();

    }

    public function showsection($id)
    {
       return $this->Clients->showsection($id);
    }


    public function store(ClientRequest $request)
    {
        return $this->Clients->store($request);
    }

    public function update(Request $request)
    {
        return $this->Clients->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Clients->destroy($request);
    }

    public function editstatusdéactive($id)
    {
        return $this->Clients->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Clients->editstatusactive($id);
    }
}
