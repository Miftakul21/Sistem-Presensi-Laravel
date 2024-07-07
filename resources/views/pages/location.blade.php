@extends('layouts.template2')
@section('title', 'Location')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lokasi Perusahaan</h1>
    </div>

    <!-- Alert crud -->
    @if (session('error'))
    <script>
    Swal.fire({
        title: "Error",
        text: "{{ session('error') }}",
        icon: "error"
    });
    </script>
    @endif

    @if (session('success'))
    <script>
    toastr.success("{{ session('success') }}", "Success");
    </script>
    @endif

    <!-- End alert -->

    <div class="row mb-5">
        <div class="col-8">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover" id="table-location">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <td>No</td>
                                <td>Nama Perusahaan</td>
                                <td>Tipe</td>
                                <td>Latitude</td>
                                <td>Longitude</td>
                                <td>Radius</td>
                                <td>Zona</td>
                                <td>Jam Masuk</td>
                                <td>Jam Keluar</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($location as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td class="text-capitalize">{{ $data->tipe }}</td>
                                <td>{{ $data->latitude }}</td>
                                <td>{{ $data->longitude }}</td>
                                <td>{{ $data->radius }}</td>
                                <td>{{ $data->zona_waktu }}</td>
                                <td>{{ $data->jam_masuk }}</td>
                                <td>{{ $data->jam_keluar }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-danger btn-sm" id="btn-delete-location"
                                        data-id="{{ $data->id }}">Delete</button>
                                    <button class="btn btn-warning btn-sm ml-2" data-toggle="modal"
                                        data-target="#exampleModal{{ $data->id }}">Edit</>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-sm">
                <div class="card-header font-weight-bold bg-primary text-white">
                    Form
                </div>
                <div class="card-body">
                    <form method="POST" action="/location">
                        @csrf
                        <div class="mb-3">
                            <label for="perusahaan" class="form-label font-weight-bold">Perusahaan</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="perusahaan" placeholder="Nama Perusahaan">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipe" class="form-label font-weight-bold">Tipe</label>
                            <select class="form-control @error('tipe') is-invalid  @enderror" name="tipe" id="tipe">
                                <option value="">Pilih Tipe</option>
                                <option value="Pusat">Pusat</option>
                                <option value="Cabang">Cabang</option>
                            </select>
                            @error('tipe')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label font-weight-bold">Latitude</label>
                            <input type="text" name="latitude"
                                class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                                placeholder="Latitude">
                            @error('laitude')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label font-weight-bold">Longitude</label>
                            <input type="text" name="longtitude"
                                class="form-control @error('longitude') is-invalid  @enderror" id="longitude"
                                placeholder="Longitude">
                            @error('longitude')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="radius" class="form-label font-weight-bold">Radius</label>
                            <input type="text" name="radius" class="form-control @error('radius') is-invalid @enderror"
                                id="radius" placeholder="Radius">
                            @error('radius')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="zona" class="form-label font-weight-bold">Zona Waktu</label>
                            <select class="form-control @error('zona_waktu') is-invalid @enderror" name="zona_waktu"
                                id="zona">
                                <option value="">Pilih Zona</option>
                                <option value="WIB">WIB</option>
                                <option value="WITA">WITA</option>
                                <option value="WIT">WIT</option>
                            </select>
                            @error('zona_waktu')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label font-weight-bold">Waktu Masuk</label>
                            <input type="time" name="jam_masuk"
                                class="form-control @error('jam_masuk') is-invalid @enderror" id="jam_masuk">
                            @error('jam_masuk')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jam_keluar" class="form-label font-weight-bold">Waktu Keluar</label>
                            <input type="time" name="jam_keluar"
                                class="form-control @error('jam_keluar') is-invalid @enderror" id="jam_keluar">
                            @error('jam_keluar')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                            <a class="btn btn-secondary font-weight-bold ml-3" id="hapus-form">Hapus</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

@foreach ($location as $data)
<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Location</h5>
                <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times fa-1x"></i></a>
            </div>
            <div class="modal-body">
                <form method="POST" action="/locaion-update">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="mb-3">
                        <label for="perusahaan-update" class="form-label font-weight-bold">Perusahaan</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="perusahaan-update" placeholder="Nama Perusahaan" value="{{ $data->name }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tipe-update" class="form-label font-weight-bold">Tipe</label>
                        <select class="form-control @error('tipe') is-invalid  @enderror" name="tipe" id="tipe-update">
                            <option value="">Pilih Tipe</option>
                            <option value="Pusat" @if($data->tipe == 'pusat') selected @endif>Pusat</option>
                            <option value="Cabang" @if($data->tipe == 'cabang') selected @endif>Cabang</option>
                        </select>
                        @error('tipe')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="latitude-update" class="form-label font-weight-bold">Latitude</label>
                        <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
                            id="latitude-update" placeholder="Latitude" value="{{ $data->latitude }}">
                        @error('laitude')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="longitude-update" class="form-label font-weight-bold">Longitude</label>
                        <input type="text" name="longitude"
                            class="form-control @error('longitude') is-invalid  @enderror" id="longitude-update"
                            placeholder="Longitude" value="{{ $data->longitude }}">
                        @error('longtitude')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="radius-update" class="form-label font-weight-bold">Radius</label>
                        <input type="text" name="radius" class="form-control @error('radius') is-invalid @enderror"
                            id="radius-update" placeholder="Radius" value="{{ $data->radius }}">
                        @error('radius')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="zona-update" class="form-label font-weight-bold">Zona Waktu</label>
                        <select class="form-control @error('zona_waktu') is-invalid @enderror" name="zona_waktu"
                            id="zona-update" value="{{ $data->zona_waktu }}">
                            <option value="">Pilih Zona</option>
                            <option value="WIB" @if($data->zona_waktu == 'WIB') selected @endif>WIB</option>
                            <option value="WITA" @if($data->zona_waktu == 'WITA') selected @endif>WITA</option>
                            <option value="WIT" @if($data->zona_waktu == 'WIT') selected @endif>WIT</option>
                        </select>
                        @error('zona_waktu')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jam_masuk-update" class="form-label font-weight-bold">Waktu Masuk</label>
                        <input type="time" name="jam_masuk"
                            class="form-control @error('jam_masuk') is-invalid @enderror" id="jam_masuk-update"
                            value="{{ $data->jam_masuk }}">
                        @error('jam_masuk')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jam_keluar-update" class="form-label font-weight-bold">Waktu Keluar</label>
                        <input type="time" name="jam_keluar"
                            class="form-control @error('jam_keluar') is-invalid @enderror" id="jam_keluar-update"
                            value="{{ $data->jam_keluar }}">
                        @error('jam_keluar')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="" class="btn btn-secondary ml-3" data-dismiss="modal">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
$('#hapus-form').on('click', function() {
    $('#perusahaan').val('');
    $('#tipe').val('');
    $('#latitude').val('');
    $('#longtitude').val('');
    $('#radius').val('');
    $('#zona').val('');
    $('#jam_masuk').val('');
    $('#jam_keluar').val('');
});
</script>
@endsection