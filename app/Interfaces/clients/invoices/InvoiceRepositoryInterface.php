<?php
namespace App\Interfaces\Clients\Invoices;


interface InvoiceRepositoryInterface
{
    //* get All Invoices Monetary
    public function indexmonetary();

    //* get All Invoices Postpaid
    public function indexPostpaid();

    //* get All Invoices Banktransfer
    public function indexBanktransfer();

    //* Show Invoices Monetary
    public function showinvoicemonetary($id);

    //* Show Invoices Postpaid
    public function showinvoicePostpaid($id);

    //* Show Invoices Banktransfer
    public function showinvoiceBanktransfer($id);
}
