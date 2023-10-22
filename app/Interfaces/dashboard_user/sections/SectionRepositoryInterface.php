<?php
namespace App\Interfaces\dashboard_user\Sections;


interface SectionRepositoryInterface
{

    //* get All Sections
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* store Sections
    public function store($request);

    //* Update Sections
    public function update($request);

    //* destroy Sections
    public function destroy($request);

    //* show Section Products
    public function showsection($id);

    //* Hide Section
    public function editstatusdéactive($id);

    //* show Section
    public function editstatusactive($id);

    //* delete All Section
    public function deleteall();

    //* Restore
    public function restore($id);

    //* Force Delete
    public function forcedelete($id);
}
