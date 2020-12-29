<?php

namespace App\Services;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Export implements FromArray, WithHeadings
{
    protected $body;
    protected $header;

    public function __construct(
        array $body,
        array $header
    ) 
    {
        $this->body = $body;
        $this->header = $header;
    }

    public function array(): array
    {
        return $this->body;
    }

    public function headings(): array
    {
        return $this->header;
    }
}
