<?php

namespace App\Exports;

use App\Facility;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Session;


class QueryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.excel.export_excel', [
            'export' => Session::get('data')
        ]);
    }
}
