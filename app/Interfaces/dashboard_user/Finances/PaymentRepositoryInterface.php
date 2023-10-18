<?php


namespace App\Interfaces\dashboard_user\Finances;


interface PaymentRepositoryInterface
{
    //* get All Payment
    public function index();

    //* show form add
    public function create();

    //* store Payment
    public function store($request);

    //* edit Payment
    public function edit($id);

    //* show Payment
    public function show($id);

    //* Update Payment
    public function update($request);

    //* destroy Payment
    public function destroy($request);

    //* delete All Payment
    public function deletetruncate();
}
