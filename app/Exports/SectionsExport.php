<?php

namespace App\Exports;

use App\Models\section;
use Maatwebsite\Excel\Concerns\FromCollection;

class SectionsExport implements FromCollection
{
    public function collection()
    {
        return section::all();
    }
}
?>
