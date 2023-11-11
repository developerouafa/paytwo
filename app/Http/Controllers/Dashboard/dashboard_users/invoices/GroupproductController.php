<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\groupproducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupproductController extends Controller
{
    private $groupproducts;

    public function __construct( $groupproducts)
    {
        $this->groupproducts = $groupproducts;
    }

    public function index()
    {
      return  $this->groupproducts->index();
    }

    public function softdelete()
    {
      return  $this->groupproducts->softdelete();
    }

    public function show($id){
      return  $this->groupproducts->show($id);
    }

    public function destroy(Request $request)
    {
        return $this->groupproducts->destroy($request);
    }

    public function deleteall()
    {
        return $this->groupproducts->deleteall();
    }

    public function restore($id)
    {
        return $this->groupproducts->restore($id);
    }
}
