@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <h2>Data Unit of Material</h2>
                    <p>{{Breadcrumbs::render('uom')}}</p>
                </div>
            </div>
        </div>

        <div class="row col-md-3">
            <div class="card">
                <div class="card-body" >
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="">Unit of Material :</label>
                            <input type="text" class="form-control form-control-sm" id="satuan_item">
                        </div>
                        <button class="btn btn-sm btn-primary mt-2" style="float:right" id="btn-tambah-satuan">Tambah</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                        <table id="dtsatuan" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>UOM</td>
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

@include('admin.satuan.form.form-edit')

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            var dts = $('#dtsatuan').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('satuan.getAll')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'satuan', name:"satuan"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-satuan">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-satuan">Hapus</button>'
                    }},
                ]
            });

            $('#dtsatuan tbody').on('click','#btn-edit-satuan', function () {
                var id = dts.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/satuan/edit/')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-satuan').modal('show');
                        $('#satuan_item-edit').val(response.satuan);
                        $('#id-edit').val(response.id);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-satuan').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('satuan', $('#satuan_item-edit').val());
                data.append('id', $('#id-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('satuan.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-edit-satuan').modal('hide');
                            $('#dtsatuan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-tambah-satuan').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('satuan', $('#satuan_item').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('satuan.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('satuan.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtsatuan tbody').on('click','#btn-hapus-satuan', function () {
                var id = dts.row($(this).parents('tr')).data().id;
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
                            url: "{{route('satuan.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtsatuan').DataTable().ajax.reload();
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