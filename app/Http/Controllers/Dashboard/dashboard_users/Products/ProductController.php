<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Products\StoreProductRequest;
use App\Http\Requests\dashboard_user\Products\UpdateProductRequest;
use App\Interfaces\dashboard_user\Products\productRepositoryInterface;
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

    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'name_'.app()->getLocale() => 'required|unique:products,name->'.app()->getLocale().','.$request->id,
            'price' => 'required',
        ],[
            'name_'.app()->getLocale().'.required' =>__('Dashboard/products.namerequired'),
            'name.unique' =>__('Dashboard/products.nameunique'),
            'price.required' =>__('Dashboard/products.pricerequired'),
        ]);
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

    public function deleteall()
    {
        return $this->Products->deleteall();
    }
}
