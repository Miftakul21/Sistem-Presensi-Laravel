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
                    <table class="table table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <td>No</td>
                                <td>Nama Perusahaan</td>
                                <td>Tipe</td>
                                <td>Latitude</td>
                                <td>Longtitude</td>
                                <td>Radius</td>
                                <td>Zona</td>
                                <td>Jam Masuk</td>
                                <td>Jam Keluar</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latitude as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td class="text-capitalize">{{ $data->tipe }}</td>
                                <td>{{ $data->latitude }}</td>
                                <td>{{ $data->longtitude }}</td>
                                <td>{{ $data->radius }}</td>
                                <td>{{ $data->zona_waktu }}</td>
                                <td>{{ $data->jam_masuk }}</td>
                                <td>{{ $data->jam_keluar }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                    <button class="btn btn-warning btn-sm">Edit</button>
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
                            <label for="longtitude" class="form-label font-weight-bold">Longtitude</label>
                            <input type="text" name="longtitude"
                                class="form-control @error('longtitude') is-invalid  @enderror" id="longtitude"
                                placeholder="Longtitude">
                            @error('longtitude')
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
                        <div class="d-flex  align-items-center">
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
})
</script>

@endsection