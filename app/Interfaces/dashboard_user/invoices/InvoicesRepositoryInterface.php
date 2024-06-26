<?php
namespace App\Interfaces\dashboard_user\invoices;


interface InvoicesRepositoryInterface
{
    //* get All Softdeletesingleinvoice
    public function indexsingleinvoice();

    //* get All Softdelete singleinvoice
    public function softdeletesingleinvoice();

    //* destroy Invoice singleinvoice
    public function destroy($request);

    //* delete All Invoice singleinvoice
    public function deleteallsingleinvoices();

    //* delete all softdelete Invoice singleinvoice
    public function deleteallsoftdelete();

    //* Invoice Status singleinvoice
    public function invoicestatus($id);

    //* Restore singleinvoice
    public function restoresingleinvoice($id);

    //* Restore All singleinvoice
    public function restoreallsingleinvoices();

    //* Restore Select singleinvoice
    public function restoreallselectsingleinvoices($request);

    //* get All groupinvoice
    public function indexgroupInvoices();

    //* get All Softdelete groupinvoice
    public function softdeletegroupInvoices();

    //* delete All Invoice groupinvoice
    public function deleteallgroupInvoices();

    //* delete all softdelete Invoice groupinvoice
    public function deleteallsoftdeletegr();

    //* Restore groupinvoice
    public function restoregroupInvoice($id);

    //* Restore All groupinvoice
    public function restoreallgroupInvoices();

    //* Restore Select groupinvoice
    public function restoreallselectgroupInvoices($request);
}
