@extends('layouts.template2')
@section('title', 'Presensi')
@section('content')

<!-- Format Time -->
<?php 
    if($zona_waktu->zona_waktu == 'WIB') {
        date_default_timezone_set('Asia/Jakarta');
    } else if($zona_waktu->zona_waktu == 'WITA'){
        date_default_timezone_set('Asia/Makasar');
    } else if($zona_waktu->zona_waktu == 'WIT') {
        date_default_timezone_set('Asia/Jayapura');
    } else {
        echo "Waktu tidak ditentukan";
    }
?>

{{ $cek_presensi_keluar }}

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Presensi</h1>
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

    <!-- Content Row -->
    <div class="row">
        <div class="col-4 offset-2">
            <div class="card h-100">
                <div class="card-header font-weight-bold bg-primary text-white">
                    Presensi Masuk
                </div>
                @if ($cek_presensi_masuk == 0)
                <div class="card-body text-center">
                    <h5 class="mb-2" id="tanggal-masuk">26 Juni 2024</h5>
                    <h1 class="mb-2 font-weight-bold" id="jam-masuk">16:27:00</h1>
                    <button class="btn btn-primary font-weight-bold" data-toggle="modal"
                        data-target="#staticBackdrop">Masuk</button>
                </div>
                @else
                <div class="card-body text-center">
                    <i class="fas fa-thumbs-up fa-3x mb-2"></i>
                    <h5 class="font-weight-bold">Anda Sudah Melakukan <br> Presensi Masuk</h5>
                </div>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="card h-100">
                <div class="card-header font-weight-bold bg-danger text-white">
                    Presensi Keluar
                </div>
                @if ($cek_presensi_keluar == 0)
                @if (strtotime(date('H:i:s')) < strtotime($zona_waktu->jam_keluar))
                    <div class="card-body text-center">
                        <i class="fas fa-thumbs-up fa-3x mb-2"></i>
                        <h5 class="font-weight-bold">Mohon Tunggu <br> Waktu Jam Kerja Selesai </h5>
                    </div>
                    @elseif ($cek_presensi_masuk == 0 && (strtotime(date('H:i:s')) >
                    strtotime($zona_waktu->jam_keluar)))
                    <div class="card-body text-center">
                        <i class="fas fa-thumbs-up fa-3x mb-2"></i>
                        <h5 class="font-weight-bold">Mohon Melakukan Presensi Masuk <br> Terlebih Dahulu </h5>
                    </div>
                    @else
                    <div class="card-body text-center">
                        <h5 class="mb-2" id="tanggal-keluar">26 Juni 2024</h5>
                        <h1 class="mb-2 font-weight-bold" id="jam-keluar">16:27:00</h1>
                        <button class="btn btn-danger font-weight-bold" data-toggle="modal"
                            data-target="#staticBackdrop2">Keluar</button>
                    </div>
                    @endif
                    @else
                    <div class="card-body text-center">
                        <i class="fas fa-thumbs-up fa-3x mb-2"></i>
                        <h5 class="font-weight-bold">Anda Sudah Melakukan <br> Presensi Keluar</h5>
                    </div>
                    @endif
            </div>
        </div>
    </div>

    <!-- Location user and kantor -->
    <div class="row mt-3 mb-2">
        <div class="col-4 offset-4">
            <div class="card">
                <div class="card-header font-weight-bold bg-secondary text-white">
                    Lokasi Anda
                </div>
                <div class="card-body">
                    <input type="hidden" id="latitude-location">
                    <input type="hidden" id="longitude-location">
                    <input type="hidden" id="radius-location">
                    <div id="map" style="height: 280px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Presensi Masuk  -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Presensi Masuk</h5>
                <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div id="my_camera" style="witdh: 100%"></div>
                        <button id="btn-snapshot" class="btn btn-primary mt-2">Ambil</button>
                    </div>
                </div>

                <div class="card mt-3 d-none" id="preview-webcam">
                    <div class="card-body">
                        <div class="card-header font-weight-bold">
                            Preview
                        </div>
                        <div id="my_result"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/presensi-masuk" class="d-inline">
                    @csrf
                    <input type="hidden" id="latitude-user" name="latitude_user">
                    <input type="hidden" id="longitude-user" name="longitude_user">
                    <input type="hidden" id="image-webcam" name="image_webcam">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Presensi Keluar -->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Presensi Keluar</h5>
                <a data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <div id="my_camera2" style="witdh: 100%"></div>
                        <button id="btn-snapshot2" class="btn btn-primary mt-2">Ambil</button>
                    </div>
                </div>

                <div class="card mt-3 d-none" id="preview-webcam2">
                    <div class="card-body">
                        <div class="card-header font-weight-bold">
                            Preview
                        </div>
                        <div id="my_result2"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/presensi-keluar" class="d-inline">
                    @csrf
                    <input type="hidden" id="latitude-user2" name="latitude_user">
                    <input type="hidden" id="longitude-user2" name="longitude_user">
                    <input type="hidden" id="image-webcam2" name="image_webcam">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>



<script>
/*
    SET CURREN DATE AND TIME
*/
dateCurrent();

function dateCurrent() {
    const month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
        'November', 'Desember'
    ];

    const date = new Date();
    const tanggal = date.getDate(),
        bulan = month[date.getMonth()],
        tahun = date.getFullYear();
    $('#tanggal-masuk').html(`${tanggal} ${bulan} ${tahun}`);
    $('#tanggal-keluar').html(`${tanggal} ${bulan} ${tahun}`);
}

timeCurrent();

function timeCurrent() {
    const time = new Date();
    let jam = time.getHours() < 10 ? '0' + time.getHours() : time.getHours(),
        menit = time.getMinutes() < 10 ? '0' + time.getMinutes() : time.getMinutes(),
        detik = time.getSeconds() < 10 ? '0' + time.getSeconds() : time.getSeconds();

    $('#jam-masuk').html(`${jam}:${menit}:${detik}`);
    $('#jam-keluar').html(`${jam}:${menit}:${detik}`);

    setTimeout(timeCurrent, 1000);
}

/*
    SET LOCATION USER AND LOCATION
*/
getLocationOffice()

function getLocationOffice() {
    $.ajax({
        url: `/get-location-office`,
        type: 'GET',
        success: (res) => {
            $('#latitude-location').val(`${res.data[0].latitude}`);
            $('#longitude-location').val(`${res.data[0].longitude}`);
            $('#radius-location').val(`${res.data[0].radius}`);
        },
        error: (error) => {
            alert('error mas bro');
        }
    });
}


getLocation();

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log('Geolocation is not supported by this browser.');
    }
}

function showPosition(position) {
    $('#latitude-user').val(position.coords.latitude);
    $('#longitude-user').val(position.coords.longitude);
    $('#latitude-user2').val(position.coords.latitude);
    $('#longitude-user2').val(position.coords.longitude);


    let latitude = position.coords.latitude;
    let longitude = position.coords.longitude;
    const latitudeOffice = $('#latitude-location').val(),
        longitudeOffice = $('#longitude-location').val(),
        radiusOffice = $('#radius-location').val();

    var map = L.map('map').setView([latitudeOffice, longitudeOffice], 25);

    // Marker Location User
    var marker = L.marker([latitude, longitude]).addTo(map);
    marker.bindPopup('User Location').openPopup();

    // Marker Location Office
    var circle = L.circle([latitudeOffice, longitudeOffice], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: radiusOffice
    }).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
}

/*
    SET WEBCAM
*/
Webcam.set({
    width: '100%',
    height: 240,
    dest_width: 640,
    dest_height: 480,
    image_format: 'jpeg',
    jpeg_quality: 90,
    force_flash: false
});

Webcam.attach('#my_camera');
Webcam.attach('#my_camera2');
$('#btn-snapshot').on('click', function() {
    $('#preview-webcam').removeClass('d-none');

    Webcam.snap(function(data_uri) {
        $('#my_result').html(`<img src="${data_uri}"  style="width: 100%; height: 240; " />`);
        const image = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

        $('#image-webcam').val(image);
    });
});

$('#btn-snapshot2').on('click', function() {
    $('#preview-webcam2').removeClass('d-none');

    Webcam.snap(function(data_uri) {
        $('#my_result2').html(`<img src="${data_uri}"  style="width: 100%; height: 240; " />`);
        const image = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

        $('#image-webcam2').val(image);
    });
});
</script>

@endsection