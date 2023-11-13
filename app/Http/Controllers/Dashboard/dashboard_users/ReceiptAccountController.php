<?php

namespace App\Http\Controllers\Dashboard\dashboard_users;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\receiptRequest;
use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use Illuminate\Http\Request;

class ReceiptAccountController extends Controller
{
    private $Receipt;

    public function __construct(ReceiptRepositoryInterface $Receipt)
    {
        $this->Receipt = $Receipt;
    }

    public function index()
    {
        return $this->Receipt->index();
    }

    public function softdelete()
    {
      return  $this->Receipt->softdelete();
    }

    public function create($id)
    {
        return $this->Receipt->create($id);
    }

    public function store(receiptRequest $request)
    {
       return $this->Receipt->store($request);
    }

    public function show($id)
    {
        return $this->Receipt->show($id);
    }

    public function edit($id)
    {
        return $this->Receipt->edit($id);
    }

    public function update(receiptRequest $request)
    {
        return $this->Receipt->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Receipt->destroy($request);
    }

    public function deleteall()
    {
        return $this->Receipt->deleteall();
    }

    public function restore($id)
    {
        return $this->Receipt->restore($id);
    }

    public function restoreallReceiptAccount(){
        return $this->Receipt->restoreallReceiptAccount();
    }

    public function restoreallselectReceiptAccount(Request $request){
        return $this->Receipt->restoreallselectReceiptAccount($request);
    }
}
