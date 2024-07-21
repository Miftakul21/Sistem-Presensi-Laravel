<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiHarianExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithEvents
{
    protected $startDate;
    protected $finishDate;

    public function __construct($startDate, $finishDate)
    {
        $this->startDate = $startDate;
        $this->finishDate = $finishDate;
    }

    public function array(): array
    {
        $location = DB::table('location')->get();
        $no = 1;

        $query = DB::table('users')
                    ->join('presensi', 'users.id', '=', 'presensi.id_user')
                    ->select('users.id', 'users.name', 'users.nip', 'presensi.tanggal_masuk', 'presensi.jam_masuk',
                            'presensi.tanggal_keluar', 'presensi.jam_keluar', 'users.id_location');
        
        if(!empty($this->startDate) && !empty($this->finishDate))
        {
            $query->whereBetween('presensi.tanggal_masuk', [$this->startDate, $this->finishDate]);
        }

        $users = $query->orderBy('tanggal_masuk', 'DESC')->get();

        $data = $users->map(function ($presensi) use ($location, &$no) {
            $timestamp_masuk = $presensi->tanggal_masuk.' '.$presensi->jam_masuk;
            $timestamp_keluar = $presensi->tanggal_keluar.' '.$presensi->jam_keluar;
            
            $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp_masuk);
            $waktuKeluar = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp_keluar);

            $selisih = $waktuKeluar->diffInSeconds($waktuMasuk);
            $totalJam = floor($selisih / 3600);
            $totalMenit = floor(($selisih % 3600) / 60);

            $jam_kerja_kantor = $location->firstWhere('id', $presensi->id_location);
            $jam_masuk_kantor = Carbon::createFromFormat('H:i', $jam_kerja_kantor->jam_masuk);
            $jam_masuk_user = Carbon::createFromFormat('H:i:s', $presensi->jam_masuk);

            $selisih_waktu = $jam_masuk_user->diffInSeconds($jam_masuk_kantor);
            $totalJamMasuk = floor($selisih_waktu / 3600);
            $totalMenitMasuk = floor(($selisih_waktu % 3600) / 60);

            return [
                'no' => $no++,
                'Name' => $presensi->name,
                'NIP' => $presensi->nip,
                'Tanggal' => date('d F Y', strtotime($presensi->tanggal_masuk)),
                'Jam Masuk' => $presensi->jam_masuk,
                'Jam Keluar' => $presensi->jam_keluar,
                'Masuk' => $totalJam.' Jam '.$totalMenit.' Menit',
                'Terlambat' => $totalJamMasuk.' Jam '.$totalMenitMasuk.' Menit'
            ];

        })->toArray();
        
        return $data;
    }

    public function headings(): array 
    {
        return ['No', 'Name', 'NIP', 'Tanggal', 'Jam Masuk', 'Jam Keluar', 'Masuk', 'Terlambat'];
    }

    public function title(): string
    {
        return "Laporan Presensi";
    }

    public function registerEvents(): array
    {
        return [
            AffterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'Rekap Presensi');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->setCellValue('A2', 'Tanggal Awal:');
                $sheet->setCellValue('B2', $this->startDate);
                $sheet->setCellValue('D2', 'Tanggal Akhir:');
                $sheet->setCellValue('E2', $this->finishDate);

                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                $heightRow = $sheet->getHighestRow();
                $cellRange = 'A4:H'.$heightRow;

                $sheet->getStyle('A4:H4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'CCCCCC',
                        ],
                    ]
                ]);

                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }

}