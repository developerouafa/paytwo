<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\childrens;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Sections\StorechildrenRequest;
use App\Http\Requests\dashboard_user\Sections\UpdatechildrenRequest;
use App\Interfaces\dashboard_user\Sections\childrenRepositoryInterface;
use Illuminate\Http\Request;

class childrenController extends Controller
{
    private $Sections;

    public function __construct(childrenRepositoryInterface $Sections)
    {
        $this->Sections = $Sections;
    }

    public function index()
    {
      return  $this->Sections->index();

    }

    public function store(StorechildrenRequest $request)
    {
        return $this->Sections->store($request);
    }

    public function update(UpdatechildrenRequest $request)
    {
        return $this->Sections->update($request);
    }

    public function showchildren($id)
    {
       return $this->Sections->showchildren($id);
    }

    public function editstatusdéactive($id)
    {
        return $this->Sections->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Sections->editstatusactive($id);
    }

    public function destroy(Request $request)
    {
        return $this->Sections->destroy($request);
    }
}
