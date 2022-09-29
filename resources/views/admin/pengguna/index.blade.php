@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Pengguna Aset</h2>
                    <p>{{Breadcrumbs::render('pengguna')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <select name="" id="kategori_departemen" class="single-select" style="width: 10%; text-align:center">
                        <option value="0">Semua</option>
                        @foreach ($datadepartemen as $dp)
                            <option value="{{$dp->id}}">{{$dp->departemen}}</option>
                        @endforeach
                    </select>
                    <div class="table-responsive mt-3">
                        {{-- <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-masuk">Tambah</button> --}}
                        <table id="dtpengguna" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Jabatan</td>
                                    <td>Departemen</td>
                                    <td>Jumlah Barang</td>
                                    <td>action</td>
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

            $('#kategori_departemen').change(function () {
                var url = "{{url('/admin/pengguna/all')}}"+"/"+ this.value
                dtp.ajax.url(url).load();
            })

            var dtp = $('#dtpengguna').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "ajax": "{{url('/admin/pengguna/all')}}"+"/"+$('#kategori_departemen').val(),
                "columns": [
                    {data:'nip', name:"nip"},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:'departemen', name:"departemen"},
                    {data:'jumlah_item', name:"jumlah_item"},
                    {data:null, render:function(a,b,c,d){
                        return '<a href="{{url('/admin/pengguna/')}}'+'/'+c.nip+'/detail" class="btn btn-warning btn-sm">Detail</a>'
                    }},
                ]
            });  

        });
    </script>
@endsection
