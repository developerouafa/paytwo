<?php


namespace App\Interfaces\dashboard_user\Finances;


interface PaymentgatewayRepositoryInterface
{
    //* get All Bankcard
    public function index();

    //* get All Softdelete
    public function softdelete();

    //* show Bankcard
    public function show($id);

    //* destroy Bankcard
    public function destroy($request);

    //* delete All Bankcard
    public function deleteall();

    //* Restore
    public function restore($id);

    //* restore all Paymentgateway
    public function restoreallPaymentgateway();

    //* restore all select Paymentgateway
    public function restoreallselectPaymentgateway($request);
}
