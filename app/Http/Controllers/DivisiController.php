<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DivisiController extends Controller
{
    public function index()
    {
        $data = DB::table('divisi')->get();
        return view('pages.divisi', ['divisi' => $data]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'divisi' => 'required|string',
        ]);

        $divisi = DB::table('divisi')->insertOrIgnore([
            'divisi' => $request->divisi,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),    
        ]);

        if($divisi) {
            return redirect('/divisi')->with(['success' => 'Berhasil simpan']);
        }

        return redirect('/divisi')->with(['error' => 'Gagal simpan']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|int'
        ]);

        $delete = DB::table('divisi')->where('id', $request->id)->delete();

        if($delete) {
            return redirect('/divisi')->with(['success' => 'Berhasil hapus']);
        }

        return redirect('/divisi')->with(['error' => 'Gagal hapus']);
    }

    public function update(Request $request) 
    {
        $request->validate([
            'id' => 'required|int',
            'divisi' => 'required|string'
        ]);

        $update = DB::table('divisi')->where('id', $request->id)->update([
            'divisi' => $request->divisi
        ]);

        if($update) {
            return redirect('/divisi')->with(['success' => 'Berhasil update']);
        }

        return redirect('/divisi')->with(['error' => 'Gagal update']);
    }
}