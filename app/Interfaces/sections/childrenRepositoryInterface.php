<?php
namespace App\Interfaces\Sections;


interface childrenRepositoryInterface
{

    // get All Childrens
    public function index();

    // store Childrens
    public function store($request);

    // Update Sections
    public function update($request);

    // destroy Sections
    public function destroy($request);
}
