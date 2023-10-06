<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Interfaces\Products\productRepositoryInterface;
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

    public function store(StoreProductRequest $request)
    {
        return $this->Products->store($request);
    }

    public function update(UpdateProductRequest $request)
    {
        return $this->Products->update($request);
    }

    public function getchild($id)
    {
        return $this->Products->getchild($id);
    }

    public function editstatusdéactive($id)
    {
        return $this->Products->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Products->editstatusactive($id);
    }

    public function destroy(Request $request)
    {
        return $this->Products->destroy($request);
    }
}
