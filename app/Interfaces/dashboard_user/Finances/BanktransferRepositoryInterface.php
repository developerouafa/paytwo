<?php


namespace App\Interfaces\dashboard_user\Finances;


interface BanktransferRepositoryInterface
{
    //* get All Banktransfer
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* show Banktransfer
    public function show($id);

    //* destroy Banktransfer
    public function destroy($request);

    //* delete All Banktransfer
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
