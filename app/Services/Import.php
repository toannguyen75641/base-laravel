<?php

namespace App\Services;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class Import implements 
                    ToModel,
                    SkipsOnFailure,
                    WithHeadingRow,
                    WithStartRow,
                    WithValidation
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        return null;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
    * @return int
    */
    public function startRow(): int
    {
        return 2;
    }
}
