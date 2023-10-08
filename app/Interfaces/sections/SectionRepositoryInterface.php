<?php
namespace App\Interfaces\Sections;


interface SectionRepositoryInterface
{

    //* get All Sections
    public function index();

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
}
