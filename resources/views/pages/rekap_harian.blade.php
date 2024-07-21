@extends('layouts.template2')
@section('title', 'Rekap Presensi Harian')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekap Presensi Harian</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-2">
            <form action="/rekap-laporan-harian" method="GET">
                @csrf
                <input type="hidden" name="startDate" id="startDate" value="{{ $first_date }}">
                <input type="hidden" name="finishDate" id="finishDate" value="{{ $finish_date }}">
                <button class="btn btn-success">Export Excel</button>
            </form>
        </div>

        <div class="col-md-9">
            <form action="/rekap-harian" method="GET">
                <div class="input-group">
                    <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $first_date }}">
                    <input type="date" name="finish_date" class="form-control" id="finish_date"
                        value="{{ $finish_date }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>


    </div>

    <div class="row  mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover" id="example">
                        <thead class="bg-primary text-white font-weight-bold">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>NIP</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Masuk</th>
                                <th>Terlambat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)

                            @php
                            // Menghitung waktu jam kerja
                            $timestamp_masuk = $data->tanggal_masuk.' '.$data->jam_masuk;
                            $timestamp_keluar = $data->tanggal_keluar.' '.$data->jam_keluar;

                            $waktuMasuk = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp_masuk);
                            $waktuKeluar = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp_keluar);

                            $selisih = $waktuKeluar->diffInSeconds($waktuMasuk);
                            $totalJam = floor($selisih / 3600);
                            $totalMenit = floor(($selisih % 3600) / 60);

                            // Menghitung jam terlambat
                            $jam_kerja_kantor = $location->firstWhere('id', $data->id_location);

                            $jam_masuk_kantor = Carbon\Carbon::createFromFormat('H:i', $jam_kerja_kantor->jam_masuk);
                            $jam_masuk_user = Carbon\Carbon::createFromFormat('H:i:s', $data->jam_masuk);

                            $selisih_waktu = $jam_masuk_user->diffInSeconds($jam_masuk_kantor);


                            $totalJamMasuk = floor($selisih_waktu / 3600);
                            $totalMenitMasuk = floor(($selisih_waktu % 3600) / 60);

                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->nip }}</td>
                                <td>{{ date('d F Y', strtotime($data->tanggal_masuk)) }}</td>
                                <td>{{ $data->jam_masuk }}</td>
                                <td>{{ $data->jam_keluar }}</td>
                                <td>{{ $totalJam }} Jam {{ $totalMenit }} Menit</td>
                                <td>{{ $totalJamMasuk }} Jam {{ $totalMenitMasuk }} Menit</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<script>
$(document).ready(function() {
    $('#start_date').on('change', function() {
        let start_date = $(this).val();
        $('#startDate').val(start_date);
    });

    $('#finish_date').on('change', function() {
        let finish_date = $(this).val();
        $('#finishDate').val(finish_date);
    });
});
</script>

@endsection