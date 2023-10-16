<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Products;

use App\Http\Controllers\Controller;
use App\Interfaces\dashboard_user\Products\stockRepositoryInterface;

class StockproductController extends Controller
{
    private $Stock;

    public function __construct(stockRepositoryInterface $Stock)
    {
        $this->Stock = $Stock;
    }

    public function editstocknoexist($id)
    {
      return  $this->Stock->editstocknoexist($id);
    }

    public function editstockexist($id)
    {
      return  $this->Stock->editstockexist($id);
    }

}
