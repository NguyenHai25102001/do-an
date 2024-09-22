<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;

class ExportImport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    public $listData;

    function __construct($listData)
    {
        $this->listData = $listData;
        $this->count = count($this->listData);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $arr = [];
        $listData = $this->listData;

        foreach ($listData as $key => $item) {
            $myArr = [
                $key + 1,
                $item->product_name,
                $item->attribute_name,
                number_format($item->survive_sl),
                number_format($item->survive_tt),
                number_format($item->import_sl),
                number_format($item->import_tt),
                number_format($item->export_sl),
                number_format($item->export_tt),
                number_format($item->ending_sl),
                number_format($item->ending_tt),
            ];
            array_push($arr, $myArr);
        }
        return collect($arr);
    }

    public function headings(): array
    {
        $array = ["STT", "Tên sản phẩm", "Loại sản phẩm", "Tồn đầu số lượng", "Tồn đầu thành tiền", "Nhập số lượng","Nhập thành tiền","Xuất số lượng","Xuất thành tiền","Tồn cuối số lượng","Tồn cuối thành tiền"];
        return $array;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->mergeCells("A2:K2")->setCellValue('A2', 'THỐNG KÊ XUẤT NHẬP HÀNG');
                $style = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ];
                $event->sheet->getStyle('2')->applyFromArray($style);
                $event->sheet->getStyle('A')->applyFromArray($style);
                $event->sheet->getStyle('B')->applyFromArray($style);
                $event->sheet->getStyle('C')->applyFromArray($style);
                $event->sheet->getStyle('D')->applyFromArray($style);
                $event->sheet->getStyle('E')->applyFromArray($style);
                $event->sheet->getStyle('F')->applyFromArray($style);
                $event->sheet->getStyle('G')->applyFromArray($style);
                $event->sheet->getStyle('H')->applyFromArray($style);
                $event->sheet->getStyle('I')->applyFromArray($style);
                $event->sheet->getStyle('J')->applyFromArray($style);
                $event->sheet->getStyle('K')->applyFromArray($style);
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(40);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);
                $event->sheet->getColumnDimension('I')->setWidth(20);
                $event->sheet->getColumnDimension('J')->setWidth(20);
                $event->sheet->getColumnDimension('K')->setWidth(20);
                $event->sheet->getDelegate()->getStyle("5")->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle("A2")->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle("5")->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle("6")->getAlignment()->setHorizontal('center');
            },
            AfterSheet::class => function (AfterSheet $event) {
                $style = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ];
                $event->sheet->mergeCells("A5:A6");
                $event->sheet->mergeCells("B5:B6");
                $event->sheet->mergeCells("C5:C6");
                $event->sheet->mergeCells("D5:D6");
                $event->sheet->mergeCells("E5:E6");
                $event->sheet->mergeCells("F5:F6");
                $event->sheet->mergeCells("G5:G6");
                $event->sheet->mergeCells("H5:H6");
                $event->sheet->mergeCells("I5:I6");
                $event->sheet->mergeCells("J5:J6");
                $event->sheet->mergeCells("K5:K6");
                $event->sheet->getStyle('A5:A6')->applyFromArray($style);
                $event->sheet->getStyle('B5:B6')->applyFromArray($style);
                $event->sheet->getStyle('C5:C6')->applyFromArray($style);
                $event->sheet->getStyle('D5:D6')->applyFromArray($style);
                $event->sheet->getStyle('E5:E6')->applyFromArray($style);
                $event->sheet->getStyle('F5:F6')->applyFromArray($style);
                $event->sheet->getStyle('G5:G6')->applyFromArray($style);
                $event->sheet->getStyle('H5:H6')->applyFromArray($style);
                $event->sheet->getStyle('I5:I6')->applyFromArray($style);
                $event->sheet->getStyle('J5:J6')->applyFromArray($style);
                $event->sheet->getStyle('K5:K6')->applyFromArray($style);
                $styleBorder = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A5:A' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('B5:B' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('C5:C' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('D5:D' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('E5:E' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('F5:F' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('G5:G' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('H5:H' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('I5:I' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('J5:J' . ($this->count + 6))->applyFromArray($styleBorder);
                $event->sheet->getDelegate()->getStyle('K5:K' . ($this->count + 6))->applyFromArray($styleBorder);
                for ($i = 5; $i <= $this->count + 6; $i++) {
                    $event->sheet->getDelegate()->getStyle('A' . $i . ':K' . $i)->applyFromArray($styleBorder);
                }
            }
        ];

    }
}
