@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Laporan Pengguna Aset</h2>
                    <p>{{Breadcrumbs::render('laporan-pengguna')}}</p>
                </div>
            </div>
        </div>
        
        {{-- form data --}}
        {{-- <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row border" style="padding: 10px;">
                        <form action="" id="form-export">
                            @csrf
                            <input type="hidden" name="jenis_laporan" id="jenis_laporan" value="0">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Status MR :</label>
                                        <select name="jenis_laporan" id="jenis-laporan" style="width: 100%" class="form-control ">
                                            <option value="4">Semua</option>
                                            <option value="0">Process</option>
                                            <option value="1">Complete</option>
                                            <option value="3">Incomplete</option>
                                            <option value="2">Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Tanggal Awal :</label>
                                        <input type="date" name="tanggal_awal" id="tanggal-awal" class="datepicker form-control" value="{{date("Y-m-d")}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Tanggal Akhir :</label>
                                        <input type="date" name="tanggal_akhir" id="tanggal-akhir" class="datepicker form-control" value="{{date("Y-m-d")}}">
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding-top: 20px;">
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-info text-white" id="btn-lihat">Lihat</a>
                                        <a href="#" class="btn btn-success" id="btn-excel">Excel</a>
                                        <a href="#" class="btn btn-danger" id="btn-pdf">PDF</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <a href="{{route('laporan.penggunaexport', 1)}}" target="_blank" class="btn btn-success" id="btn-excel">Excel</a>
                        <a href="{{route('laporan.penggunaexport', 2)}}" target="_blank" class="btn btn-danger" id="btn-pdf">PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtdata" style="width:100%" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><b>User</b></th>
                                    <th><b>Jabatan</b></th>
                                    <th><b>No Aset</b></th>
                                    <th><b>Kategori</b></th>
                                    <th><b>Merk</b></th>
                                    <th><b>Deskripsi</b></th>
                                </tr>
                            </thead>
                            <tbody >

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            var dtd = $('#dtdata').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('laporan.datapengguna')}}",
                "columns": [
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:'kode_item', name:"kode_item"},
                    {data:'kategori', name:"kategori"},
                    {data:'merk', name:"merk"},
                    {data:'deskripsi', name:"deskripsi"},
                ]
            });
        });
    </script>

@endsection