<!doctype html>
<html lang="en">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--favicon-->
		<link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
		<!-- loader-->
		<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
		<script src="{{asset('assets/js/pace.min.js')}}"></script>
		<!-- Bootstrap CSS -->
		<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
        {{-- sweet alert --}}
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>

	<link href="{{asset('assets/css/font.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
		<title>Departemen IT PT RMK Energy Tbk</title>
	</head>

    <style>
        .card{
            box-shadow: 0 2px 6px 0 rgb(0 0 0 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
        }
    </style>

@php
   $url_ims = "https://".$_SERVER['HTTP_HOST'];
@endphp

<body class="bg-login">
	<!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            {{-- <img src="{{asset('assets/images/logo-img.png')}}" width="180" alt="" /> --}}
                        </div>
                        <div class="card" style="">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <img src="{{asset('assets/images/LOGORMKE.png')}}" width="180" alt="" />

                                        {{-- <h3 class="">Sign in</h3>
                                        <p>Don't have an account yet? <a href="{{ url('authentication-signup') }}">Sign up here</a>
                                        </p> --}}
                                    </div>
                                    {{-- <div class="d-grid">
                                        <a class="btn my-4 shadow-sm btn-white" href="javascript:;"> 
                                            <span class="d-flex justify-content-center align-items-center">
                                                <img class="me-2" src="{{asset('assets/images/icons/search.svg')}}" width="16" alt="Image Description">
                                                <span>Sign in with Google</span>
											</span>
                                        </a> <a href="javascript:;" class="btn btn-facebook"><i class="bx bxl-facebook"></i>Sign in with Facebook</a>
                                    </div> --}}
                                    {{-- <div class="login-separater text-center mb-4"> <span>LOGIN</span> --}}
                                    <div class="login-separater text-center mb-4"> <span>LOGIN WITH EMAIL OR <a href="#" id="btn-qr-code">QR CODE</a></span>

                                        <hr/>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="col-12">
                                                <label for="email" class="form-label">Email :</label>
                                                <input type="text" name="email" class="form-control" required id="email" placeholder="Masukkan Email">
                                            </div>
                                            
                                            <div class="col-12">
                                                <label for="nip" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password" required class="form-control border-end-0" id="password" value="" placeholder="Masukkan Password"> <a href="#" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end">	<a href="{{ url('authentication-forgot-password') }}">Forgot Password ?</a>
                                            </div> --}}
                                            @error('email')
                                                <div class="col-12 ">
                                                    <div class="text-center" style="color: #EE2B25">{{$message}}</div>
                                                </div>
                                            @enderror
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Masuk</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div style="margin-top: 15px;" >
                                        <a href="{{$url_ims}}"  style="text-decoration:underline"><i  style="text-decoration:underline" class="bx bx-arrow-to-left"></i> Kembali ke IMS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
	<!--end wrapper-->
    @include('auth.form-qr-code')

	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets/js/instascan.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });

            $('#btn-qr-code').click(function () {
                let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                scanner.addListener('scan', function (content) {
                    // $('#email').val(content);
                    // $('#password').attr('readonly', true);
                    // $('#password').val('secret');
                    // $('#modal-login-qr-code').modal('hide');
                    // $('#form-login').submit();
                    var url = "{{url('/qr-check')}}"+"/"+content
                    $.ajax({
                        method: "get",
                        url: url,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 200) {
                                $('#modal-login-qr-code').modal('hide');
                                Swal.fire({
                                    title: 'Sedang proses...',
                                    html: 'Mohon tunggu sebentar...',
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                                var url = "{{route('admin.dashboard')}}";
                                window.location = url;
                            }else{
                                // localstream.getTracks()[0].stop();
                                swal.fire('Gagal!',response.text, "error"), function() {
                                    var url = "{{route('admin.dashboard')}}";
                                    window.location = url;
                                };
                            }
                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                });
                
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                            // true for mobile device
                            scanner.start(cameras[1]);
                            }else{
                            // false for not mobile device
                            scanner.start(cameras[0]);
                        }
                    } else {
                        alert("Kamera tidak terdeteksi!")
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    alert(e)
                console.error(e);
                });
                $('#modal-login-qr-code').modal('show');
            })

            $('#btn-tutup').click(function () {
                $('#modal-login-qr-code').modal('hide');
                var url = "{{route('admin.dashboard')}}";
                window.location = url;
            });
        });
    </script>
</body>

</html>
