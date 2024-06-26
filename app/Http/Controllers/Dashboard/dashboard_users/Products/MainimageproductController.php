<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Products\validationimageProductRequest;
use App\Interfaces\dashboard_user\Products\mainRepositoryInterface;
use Illuminate\Http\Request;

class MainimageproductController extends Controller
{
    private $Mainimage;

    public function __construct(mainRepositoryInterface $Mainimage)
    {
        $this->Mainimage = $Mainimage;
    }

    public function store(validationimageProductRequest $request)
    {
      return  $this->Mainimage->store($request);
    }

    public function edit(validationimageProductRequest $request)
    {
      return  $this->Mainimage->edit($request);
    }

    public function destroy(Request $request)
    {
      return  $this->Mainimage->destroy($request);
    }
}
