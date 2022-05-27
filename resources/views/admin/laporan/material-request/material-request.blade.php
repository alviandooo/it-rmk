@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Laporan Material Request</h2>
                    <p>{{Breadcrumbs::render('laporan-material-request')}}</p>
                </div>
            </div>
        </div>
        
        <div class="row">
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
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtdata" style="width:100%" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Nomor Request Order</b></th>
                                    {{-- <th><b>Nama</b></th> --}}
                                    <th><b>Jumlah Item</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody id="isi-data">

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
{{-- <script src="{{asset('assets/plugins/chartjs/js/chartjs-custom.js')}}"></script> --}}
    <script>
        $(document).ready(function () {
            var urltbl = "{{url('/admin/laporan/material-request/datalaporan/4')}}"+"/"+"{{date('Y-m-d')}}"+"/"+"{{date('Y-m-d')}}"
            var dtd = $('#dtdata').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": urltbl,
                "columns": [
                    // {data:'tanggal', name:"tanggal"},
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'ro_no', name:"ro_no"},
                    {data:null, render:function(a,b,c,d){
                        return c.item_permintaan[0].jumlah;
                    }},
                    {data:null, render:function(a,b,c,d){
                        if(c.status_permintaan == '0'){
                            return '<span class="badge bg-warning" style="color:black">PROCESS</span></a>'
                        }else if(c.status_permintaan == '1'){
                            return '<span class="badge bg-success" style="color:black">COMPLETE</span></a>'
                        }else if(c.status_permintaan == '2'){
                            return '<span class="badge bg-danger" style="">PENDING</span></a>'
                        }else if(c.status_permintaan == '3'){
                            return '<span class="badge bg-info" style="color:black">INCOMPLETE</span></a>'
                        }
                    }},
                ]
            });

            $('#btn-lihat').click(function () {
                var tawal = new Date($('#tanggal-awal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                var takhir = new Date($('#tanggal-akhir').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('jenis_laporan', $('#jenis-laporan').val());
                data.append('tanggal_awal', tawal);
                data.append('tanggal_akhir', takhir);
                $.ajax({
                    method: "POST",
                    url: "{{route('laporan.material-request-checklaporan')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            // var data1 = response.data.data
                            // Object.keys(data1).forEach(function(key) {
                            //     // console.log(key, data1[key].id);
                            //     $('#isi-data').append('<tr><td>'+data1[key].kode_item+'</td></tr>')
                            // });
                            var url = "{{url('/admin/laporan/material-request/datalaporan/')}}"+"/"+$('#jenis-laporan').val()+"/"+tawal+"/"+takhir
                            dtd.ajax.url(url).load();


                        }else{
                            swal.fire('Data Tidak Ditemukan!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                               
                    }
                });
            });

            $('#btn-pdf').click(function () {
                $('#form-export').attr('action','{{route("laporan.material-request-laporanpdf")}}');
                $('#form-export').attr('method','post');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });

            $('#btn-excel').click(function () {
                $('#form-export').attr('action','{{route("laporan.material-request-laporanexcel")}}');
                $('#form-export').attr('method','post');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });
        
        });
    </script>

@endsection