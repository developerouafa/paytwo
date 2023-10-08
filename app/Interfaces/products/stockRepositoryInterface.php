<?php
namespace App\Interfaces\Products;


interface stockRepositoryInterface
{

    //* No Exist In Stock
    public function editstocknoexist($id);

    //* Exist In Stock
    public function editstockexist($id);

}
