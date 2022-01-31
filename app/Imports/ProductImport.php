<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToCollection, WithStartRow
{

    public function collection(Collection $collection)
    {
        return $collection->all();
    }

    public function startRow(): int
    {
        return 2;
    }
}
