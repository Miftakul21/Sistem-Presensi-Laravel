@extends('layouts.template2')
@section('title', 'Rekap Presensi Bulanan')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekap Presensi Bulanan</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-2">
            <form action="/rekap-laporan-bulanan" method="GET">
                @csrf
                <input type="hidden" name="month" id="getMonth" value="{{ $month }}">
                <input type="hidden" name="year" id="getYear" value="{{ $year }}">
                <button class="btn btn-success">Export Excel</button>
            </form>
        </div>

        <div class="col-md-9">
            <form action="/rekap-bulanan" method="GET">
                <div class="input-group">
                    <select name="month" class="form-control" id="month">
                        <option value="">--Pilih Bulan--</option>
                        <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>Juni</option>
                        <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>Desember</option>
                    </select>

                    <select name="year" class="form-control" id="year">
                        <option value="">--Pilih Tahun--</option>
                        <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2022" {{ request('year') == '2022' ? 'selected' : '' }}>2022</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row  mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover" id="example" width="100%">
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
$('#month').on('change', function() {
    const month = $(this).val();
    $('#getMonth').val(month);

});

$('#year').on('change', function() {
    const year = $(this).val();
    $('#getYear').val(year);
});
</script>

@endsection