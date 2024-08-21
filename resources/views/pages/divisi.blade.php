@extends('layouts.template2')
@section('title', 'Divisi')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Divisi</h1>
    </div>


    <!-- End alert -->

    <!-- Content Row -->
    <div class="row">

        <div class="col-8 ">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-borderd table-hover" widh="100%" id="table-divisi">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th col="span">No</th>
                                <th col="span">Divisi</th>
                                <th col="span">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisi as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->divisi }}</td>
                                <td colspan="1">
                                    <button class="btn btn-danger btn-sm" id="btn-delete-divisi"
                                        data-id="{{ $data->id }}">Delete</button>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#exampleModal{{ $data->id }}">Edit</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white font-weight-bold">
                    Form Divisi
                </div>
                <div class="card-body">
                    <form method="POST" action="/divisi">
                        @csrf
                        <div class="mb-3">
                            <label for="divisi" class="form-label font-weight-bold">Divisi</label>
                            <input type="text" name="divisi" class="form-control" id="divisi"
                                placeholder="masukkan divisi....">
                        </div>
                        <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($divisi as $data)
    <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update</h5>
                    <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times fa-1x"></i></a>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/divisi-update">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" value="{{ $data->id }}" name="id">
                            <label for="divisi-update" class="form-label font-weight-bold">Divisi</label>
                            <input type="text" class="form-control" id="divisi-update" name="divisi"
                                value="{{ $data->divisi }}">
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


</div>
<!-- /.container-fluid -->

@endsection