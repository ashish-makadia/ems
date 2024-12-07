<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class WorkLogReportExport implements WithHeadings, ShouldAutoSize,FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $headings = ['No Headings given'];
    public $redCells = null;
    public $data = [];

    public function __construct($headings = null, $redCells = null, $data = [])
    {
        $this->headings = $headings ?? $this->headings;
        $this->redCells = $redCells;
        $this->data = $data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    // public function collection()
    // {
    //     $data = $this->data;
    //     return collect($data);
    // }

    public function view(): View {
        return view($this->data['file_path'], [
                  'data' => $this->data
        ]);
    }

    public function styles(Worksheet $sheet)
    {

    }
}
