<?php
namespace App\Interfaces\dashboard_user\Products;


interface productRepositoryInterface
{
    //* get All Products
    public function index();

    //* Show One Product
    public function show($id);

    //* get All Softdelete
    public function softdelete();

    //* store Products
    public function create();

    //* store Products
    public function store($request);

    //* DropDown Children
    public function getchild($id);

    //* Hide Product
    public function editstatusdéactive($id);

    //* show Product
    public function editstatusactive($id);

    //* Update Products
    public function update($request);

    //* destroy Product
    public function destroy($request);

    //* delete All Product
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Restore All Products
    public function restoreallproducts();

    //* Restore All Select Products
    public function restoreallselectproducts($request);
}
