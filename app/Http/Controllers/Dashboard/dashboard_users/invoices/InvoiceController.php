<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\invoices;

use App\Http\Controllers\Controller;
use App\Interfaces\dashboard_user\Invoices\InvoicesRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoices;

    public function __construct(InvoicesRepositoryInterface $invoices)
    {
        $this->invoices = $invoices;
    }

    public function indexsingleinvoice()
    {
      return  $this->invoices->indexsingleinvoice();
    }

    public function softdeletesingleinvoice()
    {
      return  $this->invoices->softdeletesingleinvoice();
    }

    public function destroysingleinvoice(Request $request)
    {
        return $this->invoices->destroysingleinvoice($request);
    }

    public function deleteallsingleinvoice()
    {
        return $this->invoices->deleteallsingleinvoice();
    }

    public function invoicestatus($id)
    {
        return $this->invoices->invoicestatus($id);
    }

    public function restoresingleinvoice($id)
    {
        return $this->invoices->restoresingleinvoice($id);
    }
}
