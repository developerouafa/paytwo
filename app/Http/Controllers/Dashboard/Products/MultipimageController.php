<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\validationimageProductRequest;
use App\Interfaces\Products\multipeRepositoryInterface;
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
}
