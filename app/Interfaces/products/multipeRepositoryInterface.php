<?php
namespace App\Interfaces\Products;


interface multipeRepositoryInterface
{
    //* function Index Multipe Image
    public function index($id);

    //* function Store Multipe Image
    public function store($request);

    //* function Store Multipe Update
    public function edit($request);

    //* function delete Image
    public function destroy($request);
}
