<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LocationController extends Controller
{
    public function index()
    {
        $location = DB::table('location')->get();

        return view('pages.location', ['location' => $location]);
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
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'zona_waktu' => $request->zona_waktu,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($insert) {
            return redirect('/location')->with(['success' => 'Berhasil simpan']);
        }

        return redirect('/loaction')->with(['error' => 'Gagal simpan']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|int'
        ]);

        $delete = DB::table('location')->where('id', $request->id)->delete();

        if($delete) {
            return redirect('/location')->with(['success' => 'Berhasil hapus']);
        }

        return redirect('/locaion')->with(['error' => 'Gagal hapus']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'tipe' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'radius' => 'required|int',
            'zona_waktu' => 'required|string',
            'jam_masuk' => 'required|string',
            'jam_keluar' => 'required|string'
        ]);

        $update = DB::table('location')->where('id', $request->id)->update([
            'name' => $request->name,
            'tipe' => $request->tipe,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'zona_waktu' => $request->zona_waktu,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($update) {
            return redirect('/location')->with(['success' => 'Berhasil update']);
        }

        return redirect('/location')->with(['error' => 'Gagal update']);
    }
}