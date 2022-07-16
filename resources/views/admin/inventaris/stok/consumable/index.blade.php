@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Stok Aset</h2>
                    <p>{{Breadcrumbs::render('stok-consumable')}}</p>
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
                                    <td>Kategori</td>
                                    <td>Jumlah Kategori</td>
                                    <td>Jumlah Asset</td>
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
                "ajax": "{{route('stok.allconsumable')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'kategori.kategori', name:"kategori.kategori"},
                    {data:'jumlah_item', name:"jumlah_item"},
                    {data:'stok', name:"stok"},
                    {data:null, render:function(a,b,c,d){
                        var url = "{{url('/admin/inventaris/stok')}}" +"/"+c.kategori_id+"/detail"
                        // var url = "{{url('/admin/inventaris/stok/')}}"+"/"+c.kategori_id
                        return '<a href="'+url+'" class="btn btn-sm btn-warning">Detail</a>'
                    }},
                ]
            });  

        });
    </script>
@endsection