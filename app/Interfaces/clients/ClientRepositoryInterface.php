<?php
namespace App\Interfaces\Clients;


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

    //* show Section Products
    public function showsection($id);

    //* Hide Section
    public function editstatusdéactive($id);

    //* show Section
    public function editstatusactive($id);
}
