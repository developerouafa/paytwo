<?php
namespace App\Interfaces\dashboard_user\Invoices;


interface InvoicesRepositoryInterface
{
    //* get All Softdeletesingleinvoice
    public function indexsingleinvoice();

    //* get All Softdelete singleinvoice
    public function softdeletesingleinvoice();

    //* destroy Invoice singleinvoice
    public function destroy($request);

    //* delete All Invoice singleinvoice
    public function deleteallsingleinvoice();

    //* Invoice Status singleinvoice
    public function invoicestatus($id);

    //* Restore singleinvoice
    public function restoresingleinvoice($id);

    //* get All groupinvoice
    public function indexgroupInvoices();

    //* get All Softdelete groupinvoice
    public function softdeletegroupInvoices();

    //* delete All Invoice groupinvoice
    public function deleteallgroupInvoices();

    //* Restore groupinvoice
    public function restoregroupInvoices($id);
}
