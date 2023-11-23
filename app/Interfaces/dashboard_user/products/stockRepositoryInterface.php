<?php
namespace App\Interfaces\dashboard_user\products;


interface stockRepositoryInterface
{

    //* No Exist In Stock
    public function editstocknoexist($id);

    //* Exist In Stock
    public function editstockexist($id);

}
