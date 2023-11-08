<?php

namespace App\Http\Controllers;

use App\Interfaces\dashboard_user\Finances\BanktransferRepositoryInterface;
use App\Models\banktransfer;
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

    public function create($id)
    {
        return $this->Banktransfer->create($id);
    }

    public function store(receiptRequest $request)
    {
       return $this->Banktransfer->store($request);
    }

    public function show($id)
    {
        return $this->Banktransfer->show($id);
    }

    public function edit($id)
    {
        return $this->Banktransfer->edit($id);
    }

    public function update(receiptRequest $request)
    {
        return $this->Banktransfer->update($request);
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

    public function forcedelete($id)
    {
        return $this->Banktransfer->forcedelete($id);
    }
}
