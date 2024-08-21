<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function index()
    {
        $nomor_random = mt_rand(1, 99);
        $nomor_random = $nomor_random < 10 ? $nomor_random . '0' : $nomor_random;
        $nip = 'NIP'.date('Y').$nomor_random;

        $role = [
            'karyawan',
            'admin',
            'direktur',
            'manager', 
        ];

        $divisi = DB::table('divisi')->get();
        $karyawan = DB::table('users')->whereNotNull('role')->get();
        $lokasi = DB::table('location')->get();

        return view('pages.karyawan', [
            'role' => $role, 'roles' => $role, 'divisi' => $divisi, 'nip' => $nip, 'karyawan' => $karyawan,
            'lokasi' => $lokasi,
        ]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|max:14',
            'alamat' => 'required|string',
            'role' => 'required|string',
            'divisi' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $insert = DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'divisi' => $request->divisi,
            'id_location' => $request->id_location,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($insert) {
            return redirect('/karyawan')->with(['success' => 'Berhasil simpan']);
        }

        return redirect('/karyawan')->with(['error' => 'Gagal simpan']);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
        ]);
        
        $delete = DB::table('users')->where('id', $request->id)->delete();

        if($delete) {
            return redirect('/karyawan')->with(['success' => 'Berhasil delete']);
        }   
        
        return redirect('/karyawan')->with(['error' => 'Gagal delete']);
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'email' => 'required|email',
            'nomor_telepon' => 'required|string|max:14',
            'alamat' => 'required|string',
            'role' => 'required|string',
            'divisi' => 'required|string',
        ]);

        $update = DB::table('users')->where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'divisi' => $request->divisi,
            'id_location' => $request->id_location,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($update) {
            return redirect('/karyawan')->with(['success' => 'Berhasil update']);
        }

        return redirect('/karyawan')->with(['error' => 'Gagal update']);
    }

    public function profile()
    {
        return view('pages.profile');
    }
}