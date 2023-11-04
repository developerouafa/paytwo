<?php
namespace App\Interfaces\Clients\Invoices;


interface InvoiceRepositoryInterface
{
    //* get All Invoices
    public function index();

    //* get All Invoices Monetary
    public function indexmonetary();

    //* get All Invoices Monetary
    public function indexbanktransfer();

    //* get All Invoices Postpaid
    public function indexPostpaid();

    //* get All Invoices card
    public function indexcard();

    //* Invoices Completed
    public function Complete($request);

    //* Invoices Continue
    public function Continue($id);

    //* Invoices Modify Payment Method
    public function modifypymethod($request);

    //* Invoices Modify Confirm Payment
    public function Confirmpayment($request);

    //* Invoices CompletePayment
    public function Completepayment($id);

    //* Invoices ErrorPayment
    public function Errorinpayment($id);

    //* Show Invoices Monetary
    public function showinvoice($id);

    //* Show Invoices notification
    public function showinvoicent($id);

    //* Receipt Invoices notifications
    public function showinvoicereceiptnt($id);

    //* PostPaid Invoices notifications
    public function showinvoicereceiptPostpaidnt($id);

    //* Receipt Invoices
    public function receipt($id);

    //* Receipt Postpaid Invoices
    public function receiptpostpaid($id);

    //* Print Invoices
    public function print($id);

    //* Print Receipt Invoices
    public function printreceipt($id);

    //* Print PostPaid Invoices
    public function printpostpaid($id);

    //* Confirm Invoices card
    public function confirm($request);

    //* Checkout Invoices card
    public function checkout();

    //* Pay Invoices card
    public function pay($request);
}
