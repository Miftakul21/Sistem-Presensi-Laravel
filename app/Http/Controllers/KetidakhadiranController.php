<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;


class KetidakhadiranController extends Controller
{
    public function index()
    {
        $ketidakhadiran = DB::table('ketidakhadiran')
                            ->where('id_user', Auth::user()->id)
                            ->get();
        return view('pages.ketidakhadiran', compact('ketidakhadiran'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc|max:2048',
        ]);

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/file'), $fileName);
        }

        $insert = DB::table('ketidakhadiran')->insert([
            'id_user' => Auth::user()->id,
            'keterangan' => $request->keterangan,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'file' => $fileName,
            'status_pengajuan' => 'Pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if($insert) {
            return redirect('/ketidakhadiran')->with('success', 'Berhasil');
        } 

        return redirect('/ketidakhadiran')->with('error', 'Gagal');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'keterangan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required',
            'file' => 'file|mimes:jpg,pdf,doc|max:2048',
        ]);
        
        $data = DB::table('ketidakhadiran')->where('id', $request->id)->latest()->first();
        $file_name = '';
        
        if(empty($request->file)) {
            $file_name = $data->file; 
        } else {
            // hapus file lama
            if($request->hasFile('file')) {
                if(file_exists('upload/file/'.$data->file)) {
                    unlink('upload/file/'.$data->file);
                }
            }
            // simpan file baru
            $file = $request->file('file');
            $file_name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/file'), $file_name);
        }

        $update = DB::table('ketidakhadiran')
                    ->where('id', $request->id)
                    ->update([
                        'keterangan' => $request->keterangan,
                        'tanggal' => $request->tanggal,
                        'deskripsi' => $request->deskripsi,
                        'file' => $file_name,
                        'status_pengajuan' => 'Pendding',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
        
        if($update) {
            return redirect('/ketidakhadiran')->with('success', 'Berhasil update');
        }
        return redirect('/ketidakhadiran')->with('error', 'Gagal update');
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $data = DB::table('ketidakhadiran')->where('id', $id);
        $file = $data->latest()->first();

        if(file_exists('upload/file/'.$file->file)) {
            unlink('upload/file/'.$file->file);
        }
        
        $delete = $data->delete();
    
        if($delete) {
            return redirect('/ketidakhadiran')->with('success', 'Berhasil hapus');
        }

        return redirect('/ketidakhadiran')->with('error', 'Gagal hapus');
    }

    public function getDataKetidakhadiran()
    {
        $ketidakhadiran = DB::table('ketidakhadiran')->get();
        return view('pages.data_ketidakhadiran', compact('ketidakhadiran'));
    }

    public function statusKetidakhadiran(Request $request)
    {
        // dd($request->all());
        $update = DB::table('ketidakhadiran')
                    ->where('id', $request->id)
                    ->update([
                        'status_pengajuan' => $request->status_pengajuan
                    ]);

        if($update) {
            return redirect('/data-ketidakhadiran')->with('success', 'Berhasil ubah status pengajuan');
        }

        return redirect('/data-ketidakhadiran')->with('error', 'Gagal ubah status pengajuan');
    }
}