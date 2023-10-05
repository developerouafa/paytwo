<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Interfaces\Products\productRepositoryInterface;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $Products;

    public function __construct(productRepositoryInterface $Products)
    {
        $this->Products = $Products;
    }

    public function index()
    {
      return  $this->Products->index();
    }

    public function create()
    {
      return  $this->Products->create();
    }

    public function store(Request $request)
    {
        return $this->Products->store($request);
    }
}
