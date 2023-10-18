<?php
namespace App\Interfaces\dashboard_user\Products;


interface productRepositoryInterface
{

    //* get All Products
    public function index();

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
}
