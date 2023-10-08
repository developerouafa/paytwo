<?php
namespace App\Interfaces\Products;


interface mainRepositoryInterface
{

    //* No Exist In Stock
    public function editstocknoexist($id);

    //* Exist In Stock
    public function editstockexist($id);

}
