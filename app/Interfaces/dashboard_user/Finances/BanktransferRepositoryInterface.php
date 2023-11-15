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

    //* delete all softdelete Banktransfer
    public function deleteallsoftdelete();

    //* Restore
    public function restore($id);

    //* restore all Banktransfer
    public function restoreallBanktransfer();

    //* restore all select Banktransfer
    public function restoreallselectBanktransfer($request);
}
