<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use DB;

class PresensiController extends Controller
{
    public function index()
    {
        // Format Waktu Lokasi Presensi (WIB, WITA, WIT)
        $zona_waktu = DB::table('location')->where('id', Auth::user()->id_location)->first();

        $cek_presensi_masuk = DB::table('presensi')
                                ->where('id_user', Auth::user()->id)
                                ->whereDate('tanggal_masuk', date('Y-m-d'))
                                ->count();

        $cek_presensi_keluar = DB::table('presensi')
                                ->where('id_user', Auth::user()->id)
                                ->whereDate('tanggal_masuk', date('Y-m-d'))
                                ->whereDate('tanggal_keluar', date('Y-m-d'))
                                ->count();

        return view('pages.presensi', ['zona_waktu' => $zona_waktu, 'cek_presensi_masuk' => $cek_presensi_masuk, 'cek_presensi_keluar' => $cek_presensi_keluar]);
    }

    public function getLocation() 
    {
        $data = DB::table('location')->where('id', Auth::user()->id_location)->get();

        if($data) {
            return response()->json(['data' => $data], 200);
        }
        return response()->json(['message' => 'Data not found'], 404);
    }

    public function presensiMasuk(Request $request)
    {
        $idUserLocation = DB::table('users')->where('id', Auth::user()->id)->first();
        $dataLocation = DB::table('location')->where('id', $idUserLocation->id_location)->first();

        // Set Location Time
        if($dataLocation->zona_waktu == 'WIB') {
            date_default_timezone_set('Asia/Jakarta');
        } elseif ($dataLocation->zona_waktu == 'WITA') {
            date_default_timezone_set('Asia/Makasar');
        } elseif($dataLocation->zona_waktu == 'WIT') {
            date_default_timezone_set('Asia/Jayapura');
        }

        // Get coordinate user and location office
        $latitude_user = (double) $request->latitude_user;
        $longitude_user = (double) $request->longitude_user;
        $latitude_office = (double) $dataLocation->latitude;
        $longitude_office = (double) $dataLocation->longitude;
        $radius_office = (double) $dataLocation->radius;

        $jarak = $this->haversineGreatCircleDistance($latitude_user, $longitude_user, $latitude_office, $longitude_office);
        $jarak = round($jarak, 2);

        if($jarak > $radius_office) {
            return redirect('/presensi')->with(['error' => 'Presensi masuk gagal']);
        } else {
            // Set upload image 
            $binary_date = base64_decode($request->image_webcam);
            $name_image = str::random(10).'.jpg';
            $path = Storage::disk('public_images_presensi_masuk');
            $path->put($name_image, $binary_date);

            // Insert Presensi
            $insert_presensi =  DB::table('presensi')->insert([
                'id_user' => Auth::user()->id,
                'tanggal_masuk' => date('Y-m-d'),
                'jam_masuk' => date('H:i:s'),
                'foto_masuk' => $name_image,
                'tanggal_keluar' => null,
                'jam_keluar' => null,
                'foto_keluar' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            if($insert_presensi) {
                return redirect('/presensi')->with(['success' => 'Berhasil presensi masuk']);   
            } else {
                return redirect('/presensi')->with(['error' => 'Presensi masuk gagal']);
            }

        }
    }

    public function presensiKeluar(Request $request)
    {
        // dd($request->all());
        $idUserLocation = DB::table('users')->where('id', Auth::user()->id)->first();
        $dataLocation = DB::table('location')->where('id', $idUserLocation->id_location)->first();   

        // Set Location Time
        if($dataLocation->zona_waktu == 'WIB') {
            date_default_timezone_set('Asia/Jakarta');
        } elseif ($dataLocation->zona_waktu == 'WITA') {
            date_default_timezone_set('Asia/Makasar');
        } elseif($dataLocation->zona_waktu == 'WIT') {
            date_default_timezone_set('Asia/Jayapura');
        }

        // Get coordinate user and location office
        $latitude_user = (double) $request->latitude_user;
        $longitude_user = (double) $request->longitude_user;
        $latitude_office = (double) $dataLocation->latitude;
        $longitude_office = (double) $dataLocation->longitude;
        $radius_office = (double) $dataLocation->radius;

        $jarak = $this->haversineGreatCircleDistance($latitude_user, $longitude_user, $latitude_office, $longitude_office);
        $jarak = round($jarak, 2);


        if($jarak > $radius_office) {
            return redirect('/presensi')->with(['error' => 'Presensi keluar gagal']);
        } else {
            // Set upload image 
            $binary_date = base64_decode($request->image_webcam);
            $name_image = str::random(10).'.jpg';
            $path = Storage::disk('public_images_presensi_keluar');
            $path->put($name_image, $binary_date);

            $presensi_keluar = DB::table('presensi')
                                ->where('id_user', Auth::user()->id)
                                ->whereDate('tanggal_masuk', date('Y-m-d'))
                                ->update([
                                    'tanggal_keluar' => date('Y-m-d'),
                                    'jam_keluar' => date('H:i:s'),
                                    'foto_keluar' => $name_image,
                                ]);

            if($presensi_keluar) {
                return redirect('/presensi')->with(['success' => 'Presensi keluar berhasil']);
            }
            return redirect('/presensi')->with(['error' => 'Presensi keluar gagal']);
        }
    }



    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // Mengonversi dari derajat ke radian
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        // Perbedaan lintang dan bujur
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Menggunakan rumus Haversine
        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
        ));

        // Jarak dalam meter
        $distance = $angle * $earthRadius;

        return $distance;
    }

}