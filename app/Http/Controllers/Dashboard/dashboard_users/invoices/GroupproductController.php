<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\invoices;

use App\Http\Controllers\Controller;
use App\Interfaces\dashboard_user\Invoices\GroupProductRepositoryInterface;
use Illuminate\Http\Request;

class GroupproductController extends Controller
{
    private $groupproducts;

    public function __construct(GroupProductRepositoryInterface $groupproducts)
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

    public function deleteallsoftdelete()
    {
        return $this->groupproducts->deleteallsoftdelete();
    }

    public function restore($id)
    {
        return $this->groupproducts->restore($id);
    }

    public function restoreallGroupServices(){
        return $this->groupproducts->restoreallGroupServices();
    }

    public function restoreallselectGroupServices(Request $request){
        return $this->groupproducts->restoreallselectGroupServices($request);
    }
}
