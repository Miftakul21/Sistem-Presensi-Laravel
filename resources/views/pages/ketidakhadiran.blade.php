@extends('layouts.template2')
@section('title', 'Ketidakhadiran Pegawai')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ketidakhadiran Pegawai</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-8">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover table-ketidakhadiran" id="example" width="100%">
                        <thead class="bg-primary text-white">
                            <tr class="">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Deskripsi</th>
                                <th>File</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ketidakhadiran as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d F Y', strtotime($data->tanggal)) }}</td>
                                <td>{{ $data->keterangan }}</td>
                                <td>{{ $data->deskripsi }}</td>
                                <td>
                                    <a target="_blank" href="{{ asset('upload/file/'.$data->file) }}"
                                        class="btn badge rounded-pill bg-primary">download</a>
                                </td>
                                <td><span class="badge rounded-pill @if ($data->status_pengajuan == 'Pending')
                                    bg-secondary @elseif ($data->status_pengajuan == 'Rejected') bg-danger @else bg-success
                                @endif">{{ $data->status_pengajuan }}</span></td>
                                <td width="18%">
                                    <button class="badge rounded-pill bg-warning btn" data-toggle="modal"
                                        data-target="#exampleModal{{ $data->id }}" @if($data->status_pengajuan ==
                                        'Accepted') disabled @endif>Update</button>
                                    <button class="badge rounded-pill bg-danger btn ml-2" id="btn-delete-ketidakhadiran"
                                        data-id="{{ $data->id }}" @if($data->status_pengajuan == 'Accepted') disabled
                                        @endif>Delete</button>
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
                <div class="card-header font-weight-bold bg-primary text-white">Form Ketidakhadiran</div>
                <div class="card-body">
                    <form method="POST" action="/ketidakhadiran" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                placeholder="Keterangan">
                            @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" placeholder="Deskripsi ketidahadiran" id="floatingTextarea"
                                name="deskripsi"></textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal">
                            @error('tanggal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file">Surat ketidakharian</label>
                            <input type="file" class="form-control" placeholder="Keterangan surat" name="file">
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                            <a class="btn btn-secondary font-weight-bold ml-3" id="hapus-form-ketidakhadiran">Hapus</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@foreach ($ketidakhadiran as $data)
<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Ketidakhadiran {{ $data->id }}
                    {{ $data->keterangan }} </h5>
                <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times fa-1x"></i></a>
            </div>
            <div class="modal-body">
                <form method="POST" action="/ketidakhadiran-update" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" name="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                            placeholder="Keterangan" value="{{ $data->keterangan }}">
                        @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" placeholder="Deskripsi ketidahadiran" id="floatingTextarea"
                            name="deskripsi">{{ $data->deskripsi }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $data->tanggal }}">
                        @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file">Surat ketidakharian</label>
                        <input type="file" class="form-control" placeholder="Keterangan surat" name="file">
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


@endsection