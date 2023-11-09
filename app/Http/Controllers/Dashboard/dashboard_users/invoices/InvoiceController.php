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

    public function indexsingleinvoice()
    {
      return  $this->Invoices->indexsingleinvoice();
    }

    public function softdeletesingleinvoice()
    {
      return  $this->Invoices->softdeletesingleinvoice();
    }

    public function destroysingleinvoice(Request $request)
    {
        return $this->Invoices->destroysingleinvoice($request);
    }

    public function deleteallsingleinvoice()
    {
        return $this->Invoices->deleteallsingleinvoice();
    }

    public function restoresingleinvoice($id)
    {
        return $this->Invoices->restoresingleinvoice($id);
    }

    public function forcedeletesingleinvoice($id)
    {
        return $this->Invoices->forcedeletesingleinvoice($id);
    }
}
