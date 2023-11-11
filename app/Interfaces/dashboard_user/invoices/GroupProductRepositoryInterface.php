<?php
namespace App\Interfaces\dashboard_user\Invoices;


interface GroupProductRepositoryInterface
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
}
