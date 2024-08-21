@extends('layouts.template2')
@section('title', 'Dashboard')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-4 offset-4">
            <div class="card border border-top border-primary">
                <div class="card-body">
                    <center>
                        <img style="border-radius: 100%; width: 150px; height: 150px; background-size: cover"
                            src="{{ asset('images/person.jpeg') }}" alt="image-person">
                    </center>
                    <table class="table mt-4 d-flex align-center justify-content-center">
                        <tr>
                            <td>Nama</td>
                            <td> : {{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> : {{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon</td>
                            <td> : {{ Auth::user()->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <td>Divisi </td>
                            <td> : {{ Auth::user()->divisi }}</td>
                        </tr>
                        <tr>
                            <td>Role </td>
                            <td> : {{ Auth::user()->role }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> : {{ Auth::user()->alamat }}</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

@endsection