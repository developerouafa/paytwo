<?php
namespace App\Interfaces\dashboard_user\Sections;


interface childrenRepositoryInterface
{

    //* get All Childrens
    public function index();

    //* store Childrens
    public function store($request);

    //* Update Sections
    public function update($request);

    //* Show Children Products
    public function showchildren($id);

    //* destroy Sections
    public function destroy($request);
}
