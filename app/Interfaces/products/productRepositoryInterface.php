<?php
namespace App\Interfaces\Products;


interface productRepositoryInterface
{

    // get All Products
    public function index();

    // store Products
    public function create();

    // store Products
    public function store($request);

    // // Update Products
    // public function update($request);

    // // destroy Products
    // public function destroy($request);

    // // destroy Products
    // public function show($id);

}
