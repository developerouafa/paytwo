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

    public function destroy(Request $request)
    {
        return $this->invoices->destroy($request);
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

    public function indexgroupInvoices()
    {
      return  $this->invoices->indexgroupInvoices();
    }

    public function softdeletegroupInvoices()
    {
      return  $this->invoices->softdeletegroupInvoices();
    }

    public function deleteallgroupInvoices()
    {
        return $this->invoices->deleteallgroupInvoices();
    }

    public function restoregroupInvoices($id)
    {
        return $this->invoices->restoregroupInvoices($id);
    }

    public function restoreallgroupInvoices()
    {
        return $this->invoices->restoreallgroupInvoices();
    }
}
