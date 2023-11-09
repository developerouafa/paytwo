<?php
namespace App\Interfaces\dashboard_user\Invoices;


interface InvoicesRepositoryInterface
{
    //* get All Softdeletesingleinvoice
    public function indexsingleinvoice();

    //* get All Softdelete singleinvoice
    public function softdeletesingleinvoice();

    //* destroy Invoice singleinvoice
    public function destroysingleinvoice($request);

    //* delete All Invoice singleinvoice
    public function deleteallsingleinvoice();

    //* Invoice Status singleinvoice
    public function invoicestatus($id);

    //* Restore singleinvoice
    public function restoresingleinvoice($id);

    //* Force Delete singleinvoice
    public function forcedeletesingleinvoice($id);
}
