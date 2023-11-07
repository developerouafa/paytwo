<?php
namespace App\Interfaces\dashboard_user\Clients;


interface ClientRepositoryInterface
{
    //* get All Clients
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* get All Clients
    public function create();

    //* Create Client Account
    public function createclient();

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
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
