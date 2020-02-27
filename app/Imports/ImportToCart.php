<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\BeforeSheet;

class ImportToCart implements ToCollection, WithHeadingRow, WithEvents
{

    public $sheetNames;
    public $sheetData;

    /**
     * ImportToCart constructor.
     */
    public function __construct()
    {
        $this->sheetNames = [];
        $this->sheetData = [];
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this->sheetData = $collection;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetNames[] = $event->getSheet()->getTitle();
            }
        ];
    }

}
