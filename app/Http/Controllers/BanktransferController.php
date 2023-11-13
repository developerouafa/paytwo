<?php

namespace App\Http\Controllers;

use App\Interfaces\dashboard_user\Finances\BanktransferRepositoryInterface;
use Illuminate\Http\Request;

class BanktransferController extends Controller
{
    private $Banktransfer;

    public function __construct(BanktransferRepositoryInterface $Banktransfer)
    {
        $this->Banktransfer = $Banktransfer;
    }

    public function index()
    {
        return $this->Banktransfer->index();
    }

    public function softdelete()
    {
      return  $this->Banktransfer->softdelete();
    }

    public function show($id)
    {
        return $this->Banktransfer->show($id);
    }

    public function destroy(Request $request)
    {
        return $this->Banktransfer->destroy($request);
    }

    public function deleteall()
    {
        return $this->Banktransfer->deleteall();
    }

    public function restore($id)
    {
        return $this->Banktransfer->restore($id);
    }

    public function restoreallBanktransfer(){
        return $this->Banktransfer->restoreallBanktransfer();
    }

    public function restoreallselectBanktransfer(Request $request){
        return $this->Banktransfer->restoreallselectBanktransfer($request);
    }
}
