@extends('layouts.template2')
@section('title', 'Karyawan')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Karyawan</h1>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-karyawan" id="example" width="100%">
                        <thead class="bg-primary">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Divisi</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nip }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->nomor_telepon }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td class="text-capitalize">{{ $data->role }}</td>
                                <td>{{ $data->divisi }}</td>
                                <td>
                                    @php
                                    $lokasi_presensi = $lokasi->firstWhere('id', $data->id_location);
                                    @endphp
                                    {{ $lokasi_presensi->name ?? '' }}
                                </td>
                                <td class="d-flex">
                                    <button class="btn btn-danger btn-sm" id="btn-delete-karyawan"
                                        data-id="{{ $data->id }}">Delete</button>
                                    <button class="btn btn-warning btn-sm ml-2" data-toggle="modal"
                                        data-target="#exampleModal{{ $data->id }}">Edit</button>
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
                <div class="card-header bg-primary text-white font-weight-bold">
                    Form
                </div>
                <div class="card-body">
                    <form method="POST" action="/karyawan">
                        @csrf
                        <div class="mb-3">
                            <label for="nip" class="form-label font-weight-bold">Nomor Induk Karyawan</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                id="perusahaan" value="{{ $nip }}" disabled>
                            <input type="hidden" value="{{ $nip }}" name="nip">
                            @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label font-weight-bold">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" placeholder="Nama" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nomor_telepon" class="form-label font-weight-bold">Nomor Telepon</label>
                            <input type="nomor_telepon" name="nomor_telepon"
                                class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon"
                                placeholder="Nomor telepon" value="{{ old('nomor_telepon') }}">
                            @error('nomor_telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat" placeholder="Alamat" value="{{ old('alamat') }}">
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label font-weight-bold">Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                <option value="">Pilih role</option>
                                @foreach ($role as $role)
                                <option value="{{ $role }}" class="text-capitalize">{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="divisi" class="form-label font-weight-bold">Divisi</label>
                            <select class="form-control @error('divisi') is-invalid @enderror" name="divisi"
                                id="divisi">
                                <option value="">Pilih divisi</option>
                                @foreach ($divisi as $divisis)
                                <option value="{{ $divisis->divisi }}">{{ $divisis->divisi }}
                                </option>
                                @endforeach
                            </select>
                            @error('divisi')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label font-weight-bold">Lokasi</label>
                            <select class="form-control @error('id_location') is-invalid @enderror" name="id_location"
                                id="lokasi">
                                <option value="">Pili lokasi</option>
                                @foreach ($lokasi as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label font-weight-bold">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                placeholder="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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

@foreach ($karyawan as $data)
<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Location</h5>
                <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times fa-1x"></i></a>
            </div>
            <div class="modal-body">
                <form method="POST" action="/karyawan-update">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="mb-3">
                        <label for="nip-updae" class="form-label font-weight-bold">Nomor Induk Karyawan</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                            value="{{ $data->nip }}" disabled>
                        @error('nip')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Nama" value="{{ $data->name }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Email" value="{{ $data->email }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label font-weight-bold">Nomor Telepon</label>
                        <input type="nomor_telepon" name="nomor_telepon"
                            class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon"
                            placeholder="Nomor telepon" value="{{ $data->nomor_telepon }}">
                        @error('nomor_telepon')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label font-weight-bold">Alamat</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            id="alamat" placeholder="Alamat" value="{{ $data->alamat }}">
                        @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label font-weight-bold">Role</label>
                        <select class="form-control text-capitalize  @error('role') is-invalid @enderror" name="role"
                            id="role">
                            <option value="">Pilih role</option>
                            @foreach ($roles as $role)
                            @if ($data->role == $role)
                            <option value="{{ $role }}" selected>{{ $role }}</option>
                            @else
                            <option value="{{ $role }}">{{ $role }}</option>
                            @endif
                            @endforeach
                        </select>
                        @error('role')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="divisi" class="form-label font-weight-bold">Divisi</label>
                        <select class="form-control @error('divisi') is-invalid @enderror" name="divisi" id="divisi">
                            <option value="">Pilih divisi</option>
                            @foreach ($divisi as $divisis)
                            @if($divisis->divisi == $data->divisi)
                            <option value="{{ $divisis->divisi }}" class="text-capitalize" selected>
                                {{ $divisis->divisi }}</option>
                            @else
                            <option value="{{ $divisis->divisi }}" class="text-capitalize">{{ $divisis->divisi }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('divisi')
                        {{ $message }}
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="location-update" class="form-label font-weight-bold">Lokasi</label>
                        <select class="form-control" name="id_location" id="location-update">
                            <option value="">Pilih lokasi</option>
                            @foreach ($lokasi as $lokasi_update)
                            @if ($lokasi_update->id == $data->id_location)
                            <option value="{{ $lokasi_update->id }}" selected>{{ $lokasi_update->name }}</option>
                            @endif
                            <option value="{{ $lokasi_update->id }}">{{ $lokasi_update->name }}</option>
                            @endforeach
                        </select>

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
    $('#name').val('');
    $('#email').val('');
    $('#nomor_telepon').val('');
    $('#alamat').val('');
    $('#divisi').val('');
    $('#role').val('');
    $('#password').val('');
});
</script>

@endsection