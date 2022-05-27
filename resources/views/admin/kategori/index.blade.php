@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <h2>Data Kategori</h2>
                    <p>{{Breadcrumbs::render('kategori')}}</p>
                </div>
            </div>
        </div>

        <div class="row col-md-3">
            <div class="card">
                <div class="card-body" >
                    <div class="table-responsive">
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="">Kategori Item :</label>
                                <input type="text" class="form-control form-control-sm" id="kategori_item">
                            </div>
                            <div class="form-group mt-2">
                                <label for="">Kode :</label>
                                <input type="text" class="form-control form-control-sm" id="kode_kategori">
                            </div>
                            <button class="btn btn-sm btn-primary mt-2" style="float:right" id="btn-tambah-kategori">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                        <table id="dtkategori" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Kode</td>
                                    <td>Kategori</td>
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

@include('admin.kategori.form.form-edit')

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            var dtk = $('#dtkategori').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('kategori.getAll')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'kode', name:"kode"},
                    {data:'kategori', name:"kategori"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-kategori">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-kategori">Hapus</button>'
                    }},
                ]
            });

            $('#dtkategori tbody').on('click','#btn-edit-kategori', function () {
                var id = dtk.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/kategori/edit/')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-kategori').modal('show');
                        $('#kategori_item-edit').val(response.kategori);
                        $('#kode-edit').val(response.kode);
                        $('#id-edit').val(response.id);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-kategori').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kategori', $('#kategori_item-edit').val());
                data.append('kode', $('#kode-edit').val());
                data.append('id', $('#id-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('kategori.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-edit-kategori').modal('hide');
                            $('#dtkategori').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-tambah-kategori').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kategori', $('#kategori_item').val());
                data.append('kode', $('#kode_kategori').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('kategori.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('kategori.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtkategori tbody').on('click','#btn-hapus-kategori', function () {
                var id = dtk.row($(this).parents('tr')).data().id;
                var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('id',id);
                swal.fire({
                    title: "Hapus?",
                    icon: 'question',
                    text: "Anda yakin ingin menghapus data?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                    
                }).then(function (e) {
                    if(e.value == true){
                        $.ajax({
                            method: "POST",
                            url: "{{route('kategori.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtkategori').DataTable().ajax.reload();
                                    swal.fire('Berhasil!',response.text, "success");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    
                                }
                            });
                    }else{

                    }

                }) 
            });
        });
    </script>
@endsection