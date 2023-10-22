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

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
