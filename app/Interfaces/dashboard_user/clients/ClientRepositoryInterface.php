<?php
namespace App\Interfaces\dashboard_user\Clients;


interface ClientRepositoryInterface
{
    //* get All Clients
    public function index();

    //* get All Clients
    public function create();

    //* store Clients
    public function store($request);

    //* Update Clients
    public function update($request);

    //* destroy Clients
    public function destroy($request);

    //* show Client
    public function showsection($id);

    //* Hide Client
    public function editstatusdéactive($id);

    //* show Client
    public function editstatusactive($id);

    //* delete All Client
    public function deletetruncate();
}
