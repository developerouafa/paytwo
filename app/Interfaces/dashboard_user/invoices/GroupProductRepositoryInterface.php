<?php
namespace App\Interfaces\dashboard_user\Invoices;


interface GroupProductRepositoryInterface
{
    //* get All Group Product(services)
    public function index();

    //* get All Softdelete Group Product(services)
    public function softdelete();

    //* View Group Product(services)
    public function show($id);

    //* destroy Group Product(services)
    public function destroy($request);

    //* delete All Group Product(services)
    public function deleteall();

    //* Restore Group Product(services)
    public function restore($id);
}
