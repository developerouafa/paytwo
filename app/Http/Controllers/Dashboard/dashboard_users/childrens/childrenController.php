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

    public function softdelete()
    {
      return  $this->Sections->softdelete();
    }

    public function store(StorechildrenRequest $request)
    {
        return $this->Sections->store($request);
    }

    public function update(Request $request)
    {
        // validations
        $this->validate($request, [
            'name_'.app()->getLocale() => 'required|unique:sections,name->'.app()->getLocale().','.$request->id,
            'section_id' => 'required',
        ],[
            'name_'.app()->getLocale().'.required' =>__('Dashboard/sections_trans.namechrequired'),
            'name_'.app()->getLocale().'.unique' =>__('Dashboard/sections_trans.namechunique'),
            'section_id.required' =>__('Dashboard/sections_trans.sectionidrequired'),
        ]);
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

    public function restore($id)
    {
        return $this->Sections->restore($id);
    }

    public function forcedelete($id)
    {
        return $this->Sections->forcedelete($id);
    }
}
