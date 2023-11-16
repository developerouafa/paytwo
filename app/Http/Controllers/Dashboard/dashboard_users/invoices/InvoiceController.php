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

    public function deleteallsingleinvoices()
    {
        return $this->invoices->deleteallsingleinvoices();
    }

    public function deleteallsoftdelete()
    {
        return $this->invoices->deleteallsoftdelete();
    }

    public function invoicestatus($id)
    {
        return $this->invoices->invoicestatus($id);
    }

    public function restoresingleinvoice($id)
    {
        return $this->invoices->restoresingleinvoice($id);
    }

    public function restoreallsingleinvoices()
    {
        return $this->invoices->restoreallsingleinvoices();
    }

    public function restoreallselectsingleinvoices(Request $request)
    {
        return $this->invoices->restoreallselectsingleinvoices($request);
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

    public function deleteallsoftdeletegr()
    {
        return $this->invoices->deleteallsoftdeletegr();
    }

    public function restoregroupInvoice($id)
    {
        return $this->invoices->restoregroupInvoice($id);
    }

    public function restoreallgroupInvoices()
    {
        return $this->invoices->restoreallgroupInvoices();
    }

    public function restoreallselectgroupInvoices(Request $request)
    {
        return $this->invoices->restoreallselectgroupInvoices($request);
    }
}
