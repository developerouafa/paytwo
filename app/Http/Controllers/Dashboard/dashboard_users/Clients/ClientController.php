<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\clients\ClientRequest;
use App\Interfaces\dashboard_user\Clients\ClientRepositoryInterface;
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

    public function softdelete()
    {
      return  $this->Clients->softdelete();
    }

    public function create()
    {
      return  $this->Clients->create();
    }

    public function createclient()
    {
      return  $this->Clients->createclient();
    }

    public function showinvoice($id)
    {
       return $this->Clients->showinvoice($id);
    }

    public function clientinvoice($id){
       return $this->Clients->clientinvoice($id);
    }

    public function store(ClientRequest $request)
    {
        return $this->Clients->store($request);
    }

    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|regex:/(0)[0-9]{6}/|unique:clients,phone'.','.$request->id,
            'email' => 'required|email|unique:clients,email,'.$request->id,
            'password' => 'same:confirm-password',
        ],[
            'name.required' => __('Dashboard/clients_trans.nameisrequired'),
            'password.required' =>__('Dashboard/users.passwordrequired'),
            'password.same' =>__('Dashboard/users.passwordsame'),
            'phone.required' =>__('Dashboard/clients_trans.phoneisrequired'),
            'phone.unique' =>__('Dashboard/clients_trans.phoneisunique'),
            'email.required' =>__('Dashboard/users.emailrequired'),
            'email.unique' =>__('Dashboard/users.emailunique'),
        ]);
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

    public function deleteall()
    {
        return $this->Clients->deleteall();
    }

    public function restore($id)
    {
        return $this->Clients->restore($id);
    }

    public function forcedelete($id)
    {
        return $this->Clients->forcedelete($id);
    }
}
