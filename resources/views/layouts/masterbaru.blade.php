<!doctype html>
<html lang="en" class="semi-dark color-header header-color1 headercolor1">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
		
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
	<!--plugins-->
	@yield("style")
	<link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/font.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

    <!-- Theme Style CSS -->
    {{-- <link rel="stylesheet" href="{{asset('assets/css/dark-theme.css')}}" /> --}}
    <link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" />

	{{-- datatables --}}
	<link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	{{-- select2 --}}
	<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />

	{{-- datetimepicker --}}
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.time.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datetimepicker/css/classic.date.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css')}}">

	<style>
		@media (-webkit-device-pixel-ratio:1.25){
			body {
				/* transform : scale(0.8);
				height: 100%;
				background-image: url("assets/images/background-rmk.png");
				*/
				zoom: 0.85;
			}

			.modal{

			}
			
		}
	</style>

	<title>PT RMK ENERGY Tbk</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--start header -->
		@include("layouts.header")
		<!--end header -->
		<!--navigation-->
		@include("layouts.nav")
		<!--end navigation-->
		<!--start page wrapper -->
		@yield("content")
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2022. Departement IT PT RMK ENERGY Tbk </p>
		</footer>
	</div>
	<!--end wrapper-->
    <!--start switcher-->
    <!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>

	{{-- datatables --}}
    <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	
	{{-- select2 --}}
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

	{{-- datepicker --}}
	<script src="{{asset('assets/plugins/datetimepicker/js/legacy.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.time.js')}}"></script>
	<script src="{{asset('assets/plugins/datetimepicker/js/picker.date.js')}}"></script>
	<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js')}}"></script>

	{{-- sweet alert --}}
    <script src="{{asset('assets/js/sweetalert.js')}}"></script>

	{{-- chart --}}	

	<script>
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});

		$('.datepicker').pickadate({
			selectMonths: true,
	        selectYears: true,
			dateFormat: 'Y-m-d'
		})
	</script>

	<script>
		$(document).ready(function () {
			$.ajax({
                    method: "GET",
                    url: "{{route('permintaan.getJumlahBelumApprove')}}",
                    processData: false,
                    contentType: false,
                    success: function(response) {
						$('#notif_jumlah_belum_approve').append(response);
						$('#total_notifikasi').append(response);
					},
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
		})
	</script>

	@yield("script")
</body>

</html>
