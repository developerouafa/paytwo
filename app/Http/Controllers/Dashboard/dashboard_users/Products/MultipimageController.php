<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Products\validationimageProductRequest;
use App\Interfaces\dashboard_user\Products\multipeRepositoryInterface;
use Illuminate\Http\Request;

class MultipimageController extends Controller
{
    private $Multipeimage;

    public function __construct(multipeRepositoryInterface $Multipeimage)
    {
        $this->Multipeimage = $Multipeimage;
    }

    public function index($id)
    {
      return  $this->Multipeimage->index($id);
    }

    public function store(validationimageProductRequest $request)
    {
      return  $this->Multipeimage->store($request);
    }

    public function edit(validationimageProductRequest $request)
    {
      return  $this->Multipeimage->edit($request);
    }

    public function destroy(Request $request)
    {
      return  $this->Multipeimage->destroy($request);
    }

    public function deleteall()
    {
      return  $this->Multipeimage->deleteall();
    }
}
