<?php
namespace App\Interfaces\dashboard_user\products;


interface promotionRepositoryInterface
{

    //* get Promotion
    public function index($id);

    //* store Promotion
    public function store($request);

    //* Update Promotion
    public function update($request);

    //* Hide Promotion
    public function editstatusdéactive($id);

    //* show Promotion
    public function editstatusactive($id);

    //* destroy Promotion
    public function destroy($request);

    //* function delete all Promotion
    public function deleteall();

}
