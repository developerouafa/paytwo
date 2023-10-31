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

    //* Show Invoices Monetary notification
    public function showinvoicemonetarynt($id);

    //* Show Invoices Postpaid
    public function showinvoicePostpaid($id);

    //* Show Invoices Postpaid notification
    public function showinvoicePostpaidnt($id);

    //* Show Invoices Banktransfer
    public function showinvoiceBanktransfer($id);

    //* Show Invoices Banktransfer notification
    public function showinvoiceBanktransfernt($id);

    //* Receipt Invoices notifications
    public function showinvoicereceiptnt($id);

    //* PostPaid Invoices notifications
    public function showinvoicereceiptPostpaidnt($id);

    //* Receipt Invoices
    public function receipt($id);

    //* Receipt Postpaid Invoices
    public function receiptpostpaid($id);

    //* Print Receipt Invoices
    public function printreceipt($id);

    //* Print PostPaid Invoices
    public function printpostpaid($id);

    //* Confirm Invoices Banktransfer
    public function confirm($request);

    //* Checkout Invoices Banktransfer
    public function checkout();

    //* Pay Invoices Banktransfer
    public function pay($request);
}
