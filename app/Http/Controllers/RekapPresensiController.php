<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Exports\PresensiHarianExport;
use App\Exports\PresensiBulananExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapPresensiController extends Controller
{
    public function index(Request $request)
    {
        $user;

        $start_date = $request->start_date;
        $finish_date = $request->finish_date;

        if($start_date && $finish_date) {
            $user = DB::table('users')
                        ->join('presensi', 'users.id', '=', 'presensi.id_user')
                        ->select('users.id', 'users.name', 'users.nip', 'presensi.tanggal_masuk', 'presensi.jam_masuk', 
                                'presensi.tanggal_keluar', 'presensi.jam_keluar', 'users.id_location')
                        ->whereBetween('presensi.tanggal_masuk', [$start_date, $finish_date])
                        ->orderBy('tanggal_masuk', 'DESC')
                        ->get();
        } else {
            $user = DB::table('users')
                        ->join('presensi', 'users.id', '=', 'presensi.id_user')
                        ->select('users.id', 'users.name', 'users.nip', 'presensi.tanggal_masuk', 'presensi.jam_masuk', 
                                'presensi.tanggal_keluar', 'presensi.jam_keluar', 'users.id_location')
                        ->orderBy('tanggal_masuk', 'DESC')
                        ->get();
        }

        $location = DB::table('location')->get();
        return view('pages.rekap_harian', ['user' => $user, 'location' => $location, 'first_date' => $start_date, 'finish_date' => $finish_date]);
    }

    public function rekapBulanan(Request $request)
    {
        $user;
        $month = $request->month;
        $year = $request->year;

        // dd($month);
        if($month && $year) {
            $user = DB::table('users')
                        ->join('presensi', 'users.id', '=', 'presensi.id_user')
                        ->select('users.id', 'users.name', 'users.nip', 'presensi.tanggal_masuk', 'presensi.jam_masuk', 
                                'presensi.tanggal_keluar', 'presensi.jam_keluar', 'users.id_location')
                        ->whereMonth('presensi.tanggal_masuk', '=', $month)
                        ->whereYear('presensi.tanggal_masuk', '=', $year)
                        ->orderBy('tanggal_masuk', 'DESC')
                        ->get();
        } else {
            $user = DB::table('users')
                ->join('presensi', 'users.id', '=', 'presensi.id_user')
                ->select('users.id', 'users.name', 'users.nip', 'presensi.tanggal_masuk', 'presensi.jam_masuk', 
                        'presensi.tanggal_keluar', 'presensi.jam_keluar', 'users.id_location')
                ->orderBy('tanggal_masuk', 'DESC')
                ->get();
        }

        $location = DB::table('location')->get();
        return view('pages.rekap_bulanan', ['user' => $user, 'location' => $location, 'month' => $month, 'year' => $year]);
    }

    public function exportLaporanHarian(Request $request) 
    {
        $startDate = $request->startDate;
        $finishDate = $request->finishDate;

        return Excel::download(new PresensiHarianExport($startDate, $finishDate), 'rekap_laporan_harian.xlsx');
    }

    public function exportLaporanBulanan(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        return Excel::download(new PresensiBulananExport($month, $year), 'rekap_laporan_bulanan.xlsx');
    }
}