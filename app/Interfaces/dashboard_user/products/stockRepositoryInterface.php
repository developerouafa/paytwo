<?php
namespace App\Interfaces\dashboard_user\Products;


interface stockRepositoryInterface
{

    //* No Exist In Stock
    public function editstocknoexist($id);

    //* Exist In Stock
    public function editstockexist($id);

}
