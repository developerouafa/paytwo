<?php
namespace App\Interfaces\dashboard_user\products;


interface mainRepositoryInterface
{

    //* function store Image
    public function store($request);

    //* function Update Image
    public function edit($request);

    //* function delete Image
    public function destroy($request);
}
