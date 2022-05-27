@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Detail Stok Item</h2>
                    @if (Request::segment(4) == "6")
                        <p>{{Breadcrumbs::render('stok-kategori-consumable', ucwords(strtolower($kategori)))}}</p>
                    @else
                        <p>{{Breadcrumbs::render('stok-kategori', ucwords(strtolower($kategori)))}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtstok" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Kode Item</td>
                                    <td>Kategori</td>
                                    <td>Nama</td>
                                    <td>Serie</td>
                                    <td>Merk</td>
                                    <td>Status</td>
                                    <td>Kondisi</td>
                                    <td>Jumlah</td>
                                    <td>Actions</td>
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

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dti = $('#dtstok').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "ajax": "{{route('stok.detailbykategori', Request::segment(4))}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'kode_item', name:"kode_item"},
                    {data:'kategori.kategori', name:"kategori.kategori"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'merk', name:"merk"},
                    {data:null, render:function(a,b,c,d){
                        if (c.jumlah == '0') {
                            return '<span style="background-color:#FFC107; padding: 5px; border-radius:5px;">Kosong</span>';
                        }else{
                            if (c.status_item == "1") {
                                return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Ada</span>';
                            }else{
                                return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Digunakan</span>';
                            }
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if (c.status_fisik == "1") {
                            return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Baik</span>';
                        }else{
                            return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Rusak</span>';
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        return c.jumlah;
                    }},
                    {data:null, render:function(a,b,c,d){
                        return '<a href="{{url('/admin/item/edit/')}}'+'/'+c.id+'" class="btn btn-warning btn-sm">Edit</a>'
                    }},
                ]
            });  

        });
    </script>
@endsection