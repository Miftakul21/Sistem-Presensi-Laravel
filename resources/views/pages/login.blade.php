@extends('layouts.template')
@section('title', 'Login Page')
@section('content')
<div class="container">
    @if (session('error'))
    <script>
    Swal.fire({
        position: "top-center",
        icon: "error",
        title: `{{session('error')}}`,
        showConfirmButton: false,
        timer: 1500
    });
    </script>
    @endif

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Sistem Absensi</h1>
                                </div>
                                <form class="user" method="POST" action="/auth-login">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                            id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email"
                                            name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a class="small" href="forgot-password.html">Lupa password?</a>
                                    <span class="small">Belum punya akun? <a href="register.html">Daftar</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection