@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Item</h2>
                    <p>{{Breadcrumbs::render('kategori-laptop')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-item">Tambah</button>
                            <a href="{{route('item.exportitembykategori',['1','1'])}}" class="btn btn-sm btn-warning" style="margin-bottom: 15px" target="_blank">Excel</a>
                            <a href="{{route('item.exportitembykategori',['1','2'])}}" class="btn btn-sm btn-danger" style="margin-bottom: 15px" target="_blank">PDF</a>
                        <table id="dtitem" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
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
                                    <td>Created_at</td>
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
@include('admin.item.form.form-add')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dti = $('#dtitem').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order": [[ 7, "desc" ]],
                "ajax": "{{route('item.datalaptop')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'kode_item', name:"kode_item"},
                    {data:'kategori.kategori', name:"kategori.kategori"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'merk', name:"merk"},
                    {data:null, render:function(a,b,c,d){
                        if (c.status_item == "1") {
                            return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Ready</span>';
                        }else{
                            return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">N/A</span>';
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if (c.status_fisik == "1") {
                            return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Baik</span>';
                        }else if(c.status_fisik == "3"){
                            return '<span style="background-color:#FFC107; padding: 5px; border-radius:5px;">Perbaikan</span>';
                        }else{
                            return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Rusak</span>';
                        }
                    }},
                    {data:'created_at', name:"created_at"},
                    {data:null, render:function(a,b,c,d){
                        return '<a href="{{url('/admin/item/edit/')}}'+'/'+c.id+'" class="btn btn-warning btn-sm">Edit</a><a href="{{url('/qrcode/')}}'+'/'+c.id+'" target="_blank" style="margin-left:5px;" class="btn btn-sm btn-success">QRCode</a>'
                    }},
                ]
            });  

            $('#btn-tambah-item').click(function () {
                $('#modal-tambah-item').modal('show');
                $('#select2kategori').attr('disabled', true);
            });

            $('#btn-simpan-item').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal_item', tgl);
                data.append('kode_item', $('#kode_item').val());
                data.append('kategori_id', $('#select2kategori').val());
                data.append('satuan_id', $('#select2satuan').val());
                data.append('nama_item', $('#nama_item').val());
                data.append('merk', $('#merk_item').val());
                data.append('serie_item', $('#serie_item').val());
                data.append('deskripsi', $('#deskripsi_item').val());
                data.append('sap_item_number', $('#sap_item').val());
                data.append('keterangan', $('#keterangan').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('item.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/item/laptop')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#select2satuan').select2({
                dropdownParent: $('#modal-tambah-item'),
            });

        });
    </script>
@endsection