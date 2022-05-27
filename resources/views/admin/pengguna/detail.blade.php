@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Detail Pengguna Aset</h2>
                    <p>{{Breadcrumbs::render('pengguna-detail', $datakaryawan[0]->nama)}}</p>
                </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">NIP</label>
                                    <input type="text" class="form-control form-control-sm" name="" readonly id="nip" value="{{$datakaryawan[0]->nip}}">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Nama</label>
                                    <input type="text" class="form-control form-control-sm" name="" readonly id="nama" value="{{$datakaryawan[0]->nama}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Jabatan</label>
                                    <input type="text" name="" readonly id="jabatan" class="form-control form-control-sm" value="{{$datakaryawan[0]->jabatan->jabatan}}">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Departemen</label>
                                    <input type="text" name="" readonly id="departemen" class="form-control form-control-sm" value="{{$datakaryawan[0]->departemen->departemen}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Area Kerja</label>
                                    <input type="text" name="" readonly id="area_kerja" class="form-control form-control-sm" value="{{$datakaryawan[0]->area_kerja->nama_area}}">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 style="text-align: center">Data Device</h4>
                    <div class="table-responsive">
                        <table id="dtpengguna" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>No Aset</td>
                                    <td>Nama</td>
                                    <td>Merk</td>
                                    <td>Serie</td>
                                    <td>Spesifikasi</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 style="text-align: center">Data Services</h4>
                    <div class="table-responsive">
                        <table id="dtpenggunaservice" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>No Aset</td>
                                    <td>Nama</td>
                                    <td>Merk</td>
                                    <td>Serie</td>
                                    <td>Spesifikasi</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>

        <div class="row col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 style="text-align: center">Data Item Consumable</h4>
                    <div class="table-responsive">
                        <table id="dtpenggunaitemservice" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>No Aset</td>
                                    <td>Nama</td>
                                    <td>Merk</td>
                                    <td>Jumlah</td>
                                    <td>Aset Service</td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                 </div>
            </div>
        </div>

    </div>
</div>

@section('script')
    <script>
        $(document).ready(function () {
            var dtp = $('#dtpengguna').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "pageLength" : 5,
                "ajax": "{{route('pengguna.riwayat', Request::segment(3))}}",
                "columns": [
                    {data:'kode_item', name:"kode_item"},
                    {data:'nama', name:"nama"},
                    {data:'merk', name:"merk"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'deskripsi', name:"deskripsi"},
                    {data:null, render:function(a,b,c,d){
                        if(c.jenis == 'DIGUNAKAN'){
                            return '<span class="badge bg-warning" style="color:black">DIGUNAKAN</span>'
                        }else{
                            return '<span class="badge bg-success" style="color:black">DIKEMBALIKAN</span>'
                        }
                    }},
                ]
            });  

            var dtps = $('#dtpenggunaservice').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "pageLength" : 5,
                "ajax": "{{route('pengguna.getRiwayatPenggunaService', Request::segment(3))}}",
                "columns": [
                    {data:'kode_item', name:"kode_item"},
                    {data:'nama', name:"nama"},
                    {data:'merk', name:"merk"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'deskripsi', name:"deskripsi"},
                    {data:null, render:function(a,b,c,d){
                        if(c.jenis == 'KERUSAKAN'){
                            return '<span class="badge bg-danger">KERUSAKAN</span>'
                        }else{
                            return '<span class="badge bg-success" style="color:black">PERBAIKAN</span>'
                        }
                    }},
                ]
            }); 

            var dtpis = $('#dtpenggunaitemservice').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "pageLength" : 5,
                "ajax": "{{route('pengguna.getRiwayatPenggunaItemService', Request::segment(3))}}",
                "columns": [
                    {data:'kode_item', name:"kode_item"},
                    {data:'nama', name:"nama"},
                    {data:'merk', name:"merk"},
                    {data:'jumlah', name:"jumlah"},
                    {data:'kode_item_perbaikan', name:"kode_item_perbaikan"},

                ]
            });  

        });
    </script>
@endsection