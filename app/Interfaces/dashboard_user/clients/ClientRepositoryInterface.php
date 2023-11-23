<?php
namespace App\Interfaces\dashboard_user\clients;


interface ClientRepositoryInterface
{
    //* get All Clients
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* Create Client Account
    public function createclient();

    //* store Clients
    public function store($request);

    //* Update Clients
    public function update($request);

    //* destroy Clients
    public function destroy($request);

    //* show Invoice Client
    public function showinvoice($id);

    //* destroy_invoices_client
    public function destroy_invoices_client($request);

    //* show Invoice Client Print
    public function clientinvoice($id);

    //* Hide Client
    public function editstatusdéactive($id);

    //* show Client
    public function editstatusactive($id);

    //* delete All Client
    public function deleteall();

    //* deleteallsoftdelete All Client
    public function deleteallsoftdelete();

    //* Restore
    public function restore($id);

    //* Restore All Clients
    public function restoreallclients();

    //* Restore All Select Clients
    public function restoreallselectclients($request);
}
