<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\invoices;

use App\Http\Controllers\Controller;
use App\Interfaces\dashboard_user\Invoices\InvoiceRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $Invoices;

    public function __construct(InvoiceRepositoryInterface $Invoices)
    {
        $this->Invoices = $Invoices;
    }

    public function index()
    {
      return  $this->Invoices->index();
    }

    public function softdelete()
    {
      return  $this->Invoices->softdelete();
    }

    public function destroy(Request $request)
    {
        return $this->Invoices->destroy($request);
    }

    public function deleteall()
    {
        return $this->Invoices->deleteall();
    }

    public function restore($id)
    {
        return $this->Invoices->restore($id);
    }

    public function forcedelete($id)
    {
        return $this->Invoices->forcedelete($id);
    }
}
