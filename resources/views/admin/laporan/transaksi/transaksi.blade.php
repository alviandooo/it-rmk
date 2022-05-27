@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Laporan Transaksi Aset</h2>
                    <p>{{Breadcrumbs::render('laporan-transaksi')}}</p>
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
                                        <label for="">Jenis Transaksi:</label>
                                        <select name="jenis_laporan" id="jenis-laporan" style="width: 100%" class="form-control ">
                                            {{-- <option value="4">Semua</option> --}}
                                            <option value="0">Pengembalian</option>
                                            <option value="1">Penyerahan</option>
                                            <option value="2">Kerusakan</option>
                                            <option value="3">Perbaikan</option>
                                            <option value="5">Network Device</option>
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

        <div class="row" id="table1">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtdata" style="width:100%" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Nomor Aset</b></th>
                                    <th><b>Kategori</b></th>
                                    <th><b>Aset</b></th>
                                    <th><b>Serie</b></th>
                                    <th><b>NIK</b></th>
                                    <th><b>User</b></th>
                                    <th><b>Jabatan</b></th>

                                </tr>
                            </thead>
                            <tbody id="isi-data">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="table2">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtdata2" style="width:100%" class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Nomor Aset</b></th>
                                    <th><b>Nama Device</b></th>
                                    <th><b>Nomor Device</b></th>
                                    <th><b>Model</b></th>
                                    <th><b>Merk</b></th>
                                    <th><b>IP</b></th>
                                    <th><b>Lokasi</b></th>
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

            if($('#jenis-laporan').val() != "5"){
                $('#table2').css('display','none');
                $('#table1').css('display','block');
            }

            $('#jenis-laporan').change(function () {
                console.log(this.value);
                if(this.value != "5"){
                    $('#table2').css('display','none');
                    $('#table1').css('display','block');
                }else{
                    $('#table2').css('display','block');
                    $('#table1').css('display','none');
                }
            })

            var urltbl = "{{url('/admin/laporan/transaksi/4')}}"+"/"+"{{date('Y-m-d')}}"+"/"+"{{date('Y-m-d')}}"
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
                    {data:'kode_item', name:"kode_item"},
                    {data:'kategori', name:"kategori"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'nip', name:"nip"},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                ]
            });

            var urltbl2 = "{{url('/admin/laporan/transaksi/5')}}"+"/"+"{{date('Y-m-d')}}"+"/"+"{{date('Y-m-d')}}"
            var dtd2 = $('#dtdata2').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": urltbl2,
                "columns": [
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    // {data:'tanggal', name:"tanggal"},
                    {data:'kode_item', name:"kode_item"},
                    {data:'item.nama_item', name:"item.nama_item"},
                    {data:'device_no', name:"device_no"},
                    {data:'item.serie_item', name:"item.serie_item"},
                    {data:'item.merk', name:"item.merk"},
                    {data:'ip', name:"ip"},
                    {data:'lokasi_network_device.nama_lokasi', name:"lokasi_network_device.nama_lokasi"},
                    
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
                    url: "{{route('laporan.checklaporantransaksi')}}",
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
                            var url = "{{url('/admin/laporan/transaksi/')}}"+"/"+$('#jenis-laporan').val()+"/"+tawal+"/"+takhir
                            if($('#jenis-laporan').val() != "5"){
                                dtd.ajax.url(url).load();
                            }else{
                                dtd2.ajax.url(url).load();
                            }

                        }else{
                            swal.fire('Data Tidak Ditemukan!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                               
                    }
                });
            });

            $('#btn-pdf').click(function () {
                var tawal = new Date($('#tanggal-awal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                var takhir = new Date($('#tanggal-akhir').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var url = "{{url('/admin/laporan/transaksi/export/2')}}"+"/"+$('#jenis-laporan').val()+"/"+tawal+"/"+takhir
                $('#form-export').attr('action',url);
                $('#form-export').attr('method','get');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });

            $('#btn-excel').click(function () {
                var tawal = new Date($('#tanggal-awal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                var takhir = new Date($('#tanggal-akhir').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var url = "{{url('/admin/laporan/transaksi/export/1')}}"+"/"+$('#jenis-laporan').val()+"/"+tawal+"/"+takhir
                $('#form-export').attr('action',url);
                $('#form-export').attr('method','get');
                $('#form-export').attr('target','_blank');
                $('#form-export').submit();
            });
        
        });
    </script>

@endsection