<?php

namespace App\Helpers;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExcelHelper
{
    public static function export($data, $filename = 'export.xlsx')
    {
        $headers = !empty($data) ? array_keys($data[0]) : [];

        $export = new class($data, $headers) implements FromArray, WithHeadings, WithStyles {
            protected $data;
            protected $headings;

            public function __construct($data, $headings)
            {
                $this->data = $data;
                $this->headings = $headings;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headings;
            }

            public function styles(Worksheet $sheet)
            {
                $styles = [];

                // Style header (row 1)
                $styles[1] = [
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4CAF50'], // green
                    ],
                ];

                // Style data rows (2 to N)
                $rowCount = count($this->data) + 1; // +1 because headings are at row 1
                for ($i = 2; $i <= $rowCount; $i++) {
                    $styles[$i] = [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F5F5F5'], // light gray
                        ],
                    ];
                }

                return $styles;
            }
        };

        return Excel::download($export, $filename);
    }
}
