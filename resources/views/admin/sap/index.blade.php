@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data SAP Item</h2>
                    <p></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <button class="btn btn-primary mb-3" style="" id="btn-tambah-sap">Tambah</button>
                        <table id="dtsi" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>No. SAP</td>
                                    <td>Kode</td>
                                    <td>Nama</td>
                                    <td>Merk</td>
                                    <td>Serie</td>
                                    <td>Kategori</td>
                                    <td>Actions</td>
                                    <td>Updated_at</td>
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
@include('admin.sap.form.form-add')
@include('admin.sap.form.form-edit')
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var dtsi = $('#dtsi').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order": [[ 7, "desc" ]],
                "ajax": "{{route('item.getAll')}}",
                "columns": [
                    {data:'sap_item_number', name:"sap_item_number"},
                    {data:'kode_item', name:"kode_item"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'merk', name:"merk"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'kategori.kategori', name:"kategori.kategori"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-sap">Edit</button>'
                    }},
                    {data:'updated_at', name:"updated_at"},
                ]
            });

            $('#btn-tambah-sap').click(function () {
                $('#modal-tambah-sap').modal('show');
            })

            $('#btn-simpan-sap').click(function () {
                id = $('#id_item').val();
                sap = $('#sap_item_number').val();

                if(id == ""){
                    swal.fire('Error!', "Item harus dipilih!", "error");
                }else if(sap == ""){
                    swal.fire('Error!', "No SAP tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', id);
                data.append('sap_item_number', sap);

                $.ajax({
                    method: "POST",
                    url: "{{route('sap.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('sap.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#dtsi tbody ').on('click', '#btn-edit-sap', function () {
                var id = dtsi.row($(this).parents('tr')).data().id;

                var url = "{{url('/admin/item/sap')}}" + "/" + id;

                $.ajax({
                    method: "GET",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#id_item-edit').val(response.id).change();
                        $('#sap_item_number-edit').val(response.sap_item_number);
                        $('#modal-edit-sap').modal('show');
                        
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

            })

            $('#btn-update-sap').click(function () {
                id = $('#id_item-edit').val();
                sap = $('#sap_item_number-edit').val();

                if(id == ""){
                    swal.fire('Error!', "Item harus dipilih!", "error");
                }else if(sap == ""){
                    swal.fire('Error!', "No SAP tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', id);
                data.append('sap_item_number', sap);

                $.ajax({
                    method: "POST",
                    url: "{{route('sap.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('sap.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

        });
    </script>
@endsection