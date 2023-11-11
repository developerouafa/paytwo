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

    public function indexsingleinvoice()
    {
      return  $this->groupproducts->indexsingleinvoice();
    }

    public function softdeletesingleinvoice()
    {
      return  $this->groupproducts->softdeletesingleinvoice();
    }

    public function destroy(Request $request)
    {
        return $this->groupproducts->destroy($request);
    }

    public function deleteallsingleinvoice()
    {
        return $this->groupproducts->deleteallsingleinvoice();
    }
}
