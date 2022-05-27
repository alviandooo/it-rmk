@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Laporan Stok Aset</h2>
                    <p>{{Breadcrumbs::render('laporan-stok')}}</p>
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
                                        <label for="">Jenis Laporan :</label>
                                        <select name="jenis_data" id="jenis_data" style="width: 100%" class="form-control ">
                                            <option value="1">Aset Masuk</option>
                                            <option value="2">Aset Ready</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 tanggaldiv">
                                    <div class="form-group">
                                        <label for="">Tanggal Awal :</label>
                                        <input type="date" name="tanggal_awal" id="tanggal-awal" class="datepicker form-control" value="{{date("Y-m-d")}}">
                                    </div>
                                </div>
                                <div class="col-md-2 tanggaldiv">
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
{{-- 
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container1" id="grafik">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtdata" style="width:100%" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><b>Nomor Aset</b></th>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Kategori</b></th>
                                    {{-- <th><b>Nama</b></th> --}}
                                    <th><b>Serie</b></th>
                                    <th><b>Merk</b></th>
                                    <th><b>Kondisi</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Jumlah</b></th>
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
            $('#jenis_data').change(function () {
                if(this.value == '2'){
                    $('.tanggaldiv').css('display','none');
                }else{
                    $('.tanggaldiv').css('display','block');
                }
            })

            var urltbl = "{{url('/admin/inventaris/stok/')}}"+"/"+"{{date('Y-m-d')}}"+"/"+"{{date('Y-m-d')}}"+"/0"
            var dtd = $('#dtdata').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": urltbl,
                "columns": [
                    {data:'kode_item', name:"kode_item"},
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'item.kategori.kategori', name:"item.kategori.kategori"},
                    // {data:'nama_item', name:"nama_item"},
                    {data:'item.serie_item', name:"item.serie_item"},
                    {data:'item.merk', name:"item.merk"},
                    {data:null, render:function(a,b,c,d){
                        if (c.item.status_fisik == "1") {
                            return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Baik</span>';
                        }else{
                            return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Rusak</span>';
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if (c.item.status_item == "1") {
                            return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Ready</span>';
                        }else{
                            return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Digunakan</span>';
                        }
                    }},
                    {data:'jumlah', name:"jumlah"},
                    
                ]
            });

            $('#btn-lihat').click(function () {
                var tawal = new Date($('#tanggal-awal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                var takhir = new Date($('#tanggal-akhir').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('jenis_data', $('#jenis_data').val());
                data.append('tanggal_awal', tawal);
                data.append('tanggal_akhir', takhir);
                $.ajax({
                    method: "POST",
                    url: "{{route('laporan.datalaporan')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            var url = "{{url('/admin/inventaris/stok/')}}"+"/"+tawal+"/"+takhir+"/"+$('#jenis_data').val()
                            dtd.ajax.url(url).load();

                            // $('#chart2').remove();
                            // $('#grafik').append('<canvas id="chart2"><canvas>');

                            // var ctx = document.getElementById("chart2").getContext('2d');
                            // var myChart = new Chart(ctx, {
                            //     type: 'bar',
                            //     data: {
                            //         labels: ['LAPTOP', 'PRINTER', 'PC', 'NETWORK DEVICE', 'PERIPHERAL', 'CONSUMABLE'],
                            //         datasets: [{
                            //             label: 'Total',
                            //             data: [response.data.totalperkategori.LAPTOP, response.data.totalperkategori.PRINTER, response.data.totalperkategori.PC, response.data.totalperkategori.NETWORK_DEVICE, response.data.totalperkategori.PERIPHERAL, response.data.totalperkategori.CONSUMABLE],
                            //             backgroundColor: "#0d6efd"
                            //         }]
                            //     },
                            //     options: {
                            //         maintainAspectRatio: false,
                            //         legend: {
                            //             display: true,
                            //             labels: {
                            //                 fontColor: '#585757',
                            //                 boxWidth: 40
                            //             }
                            //         },
                            //         tooltips: {
                            //             enabled: true
                            //         },
                            //         scales: {
                            //             xAxes: [{
                            //                 ticks: {
                            //                     beginAtZero: true,
                            //                     fontColor: '#585757'
                            //                 },
                            //                 gridLines: {
                            //                     display: true,
                            //                     color: "rgba(0, 0, 0, 0.07)"
                            //                 },
                            //             }],
                            //             yAxes: [{
                            //                 ticks: {
                            //                     beginAtZero: true,
                            //                     fontColor: '#585757'
                            //                 },
                            //                 gridLines: {
                            //                     display: true,
                            //                     color: "rgba(0, 0, 0, 0.07)"
                            //                 },
                            //             }]
                            //         }
                            //     }
                            // });

                        }else{
                            swal.fire('Data Tidak Ditemukan!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                               
                    }
                });
            });

            $('#btn-excel').click(function () {
                $('#jenis_laporan').val('1');
                $('#form-export').attr('action','{{route("laporan.datalaporan")}}');
                $('#form-export').attr('method','post');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });

            $('#btn-pdf').click(function () {
                $('#jenis_laporan').val('2');
                $('#form-export').attr('action','{{route("laporan.datalaporan")}}');
                $('#form-export').attr('method','post');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });
        
        });
    </script>

@endsection