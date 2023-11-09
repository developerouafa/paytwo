<?php
namespace App\Interfaces\dashboard_user\Invoices;


interface InvoiceRepositoryInterface
{
    //* get All Invoices
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* destroy Product
    public function destroy($request);

    //* delete All Product
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
