<?php
namespace App\Interfaces\dashboard_user\Sections;


interface childrenRepositoryInterface
{

    //* get All Childrens
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* store Childrens
    public function store($request);

    //* Update Sections
    public function update($request);

    //* Show Children Products
    public function showchildren($id);

    //* Hide Children
    public function editstatusdéactive($id);

    //* show Children
    public function editstatusactive($id);

    //* destroy Children
    public function destroy($request);

    //* delete All Children
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Restore  All Children
    public function restoreallchildrens();

    //* Restore  All Select Children
    public function restoreallselectchildrens($request);
}
