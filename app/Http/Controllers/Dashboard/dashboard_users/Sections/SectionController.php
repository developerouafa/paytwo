<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Sections\StoreSectionRequest;
use App\Http\Requests\dashboard_user\Sections\UpdateSectionRequest;
use App\Interfaces\dashboard_user\Sections\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    private $Sections;

    public function __construct(SectionRepositoryInterface $Sections)
    {
        $this->Sections = $Sections;
    }

    public function index()
    {
      return  $this->Sections->index();

    }

    public function showsection($id)
    {
       return $this->Sections->showsection($id);
    }


    public function store(StoreSectionRequest $request)
    {
        return $this->Sections->store($request);
    }

    public function update(UpdateSectionRequest $request)
    {
        return $this->Sections->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Sections->destroy($request);
    }

    public function editstatusdéactive($id)
    {
        return $this->Sections->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Sections->editstatusactive($id);
    }
}
