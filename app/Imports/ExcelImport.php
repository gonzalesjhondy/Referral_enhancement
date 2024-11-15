<?php

namespace App\Imports;

use App\Facility;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class ExcelImport implements ToCollection
{
    public $data;

    public function collection(Collection $rows)
    {
        $this->data = $rows;
    }


    public function model(array $row)
    {
        return new Facility([
            'name' => $row
        ]);
    }

    public function displayRow(): object
    {
        return $this->data;
    }
}
