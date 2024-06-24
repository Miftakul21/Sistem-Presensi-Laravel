<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LocationController extends Controller
{
    public function index()
    {
        $latitude = DB::table('location')->get();

        return view('pages.location', ['latitude' => $latitude]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'tipe' => 'required|string',
            'latitude' => 'required|string',
            'longtitude' => 'required|string',
            'radius' => 'required|int',
            'zona_waktu' => 'required|string',
            'jam_masuk' => 'required|string',
            'jam_keluar' => 'required|string'
        ]);

        $insert = DB::table('location')->insert([
            'name' => $request->name,
            'tipe' => $request->tipe,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'radius' => $request->radius,
            'zona_waktu' => $request->zona_waktu,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y=m-d H:i:s'),
        ]);

        if($insert) {
            return redirect('/location')->with(['success' => 'Berhasil simpan']);
        }

        return redirect('/loaction')->with(['error' => 'Gagal simpan']);
    }
}