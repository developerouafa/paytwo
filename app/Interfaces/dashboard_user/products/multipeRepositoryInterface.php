<?php
namespace App\Interfaces\dashboard_user\products;


interface multipeRepositoryInterface
{
    //* function Index Multipe Image
    public function index($id);

    //* function Store Multipe Image
    public function store($request);

    //* function Update Multipe Image
    public function edit($request);

    //* function delete MultipeImage
    public function destroy($request);

    //* delete All MultipeImage
    public function deleteall();
}
