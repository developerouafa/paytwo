<?php
namespace App\Repository\Sections;

use App\Interfaces\Sections\childrenRepositoryInterface;
use App\Models\Section;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class childrenRepository implements childrenRepositoryInterface
{
    public function index()
    {
        $childrens = Section::selectchildrens()->withchildrens()->child()->get();
        $sections = Section::selectsections()->Withsections()->parent()->get();
        return view('Dashboard.childrens.childrens', compact('childrens', 'sections'));
    }
}
