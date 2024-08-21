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
        <div class="col-10">
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
                                <td><span data-toggle="modal" data-target="#exampleModal{{ $data->id }}" class="badge rounded-pill @if ($data->status_pengajuan == 'Pending')
                                    bg-secondary @elseif ($data->status_pengajuan == 'Rejected') bg-danger  @else bg-success
                                @endif">{{ $data->status_pengajuan }}</span>
                                </td>

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
                <form method="POST" action="/status-ketidakhadiran">
                    @csrf
                    <input type="hidden" value="{{ $data->id }}" name="id">
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" name="keterangan"
                            class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                            placeholder="Keterangan" value="{{ $data->keterangan }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" placeholder="Deskripsi ketidahadiran" id="floatingTextarea"
                            name="deskripsi" readonly>{{ $data->deskripsi }}</textarea>

                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ $data->tanggal }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
                        <select name="status_pengajuan" id="status_pengajuan" class="form-control">
                            <option class="text-secondary font-weight-bold" value="Pendding" @if ($data->
                                status_pengajuan == 'Pendding')
                                selected @endif>
                                Pendding
                            </option>
                            <option class="text-danger font-weight-bold" value="Rejected" @if ($data->status_pengajuan
                                == 'Rejected')
                                selected @endif>
                                Rejected
                            </option>
                            <option class="text-success font-weight-bold" value="Accepted" @if ($data->status_pengajuan
                                == 'Pendding')
                                selected @endif>
                                Accepted
                            </option>
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


@endsection