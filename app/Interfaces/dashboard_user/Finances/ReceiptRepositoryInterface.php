<?php


namespace App\Interfaces\dashboard_user\Finances;


interface ReceiptRepositoryInterface
{
    //* get All Receipt
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* show form add
    public function create($request);

    //* store Receipt
    public function store($request);

    //* edit Receipt
    public function edit($id);

    //* show Receipt
    public function show($id);

    //* Update Receipt
    public function update($request);

    //* destroy Receipt
    public function destroy($request);

    //* delete All Receipt
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
