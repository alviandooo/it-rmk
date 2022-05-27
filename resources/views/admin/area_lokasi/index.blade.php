@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
            <div class="card">
                <div class="card-body" >
                    <h2>Area Lokasi Network Device</h2>
                    <p>{{Breadcrumbs::render('area-lokasi-device')}}</p>
                </div>
            </div>

        <div class="row">
            <div class="col-md-5">
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <h5 style="margin-bottom: -5px;">Area Network Device</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="margin-top: -12px;">
                                <div class="row">
                                    <button class="btn btn-sm btn-primary mt-2" style="float:left; width:80px; margin-left:13px; margin-bottom:15px; margin-top:-10px;" id="btn-tambah-area" >Tambah</button>
                                    <table id="dtarea" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                                        <thead>
                                            <tr>
                                                <td hidden></td>
                                                <td>Area</td>
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

            <div class="col-md-7">
                    <div class="card">
                        <div class="card-header" style="text-align: center">
                            <h5 style="margin-bottom: -5px;">Lokasi Network Device</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="margin-top: -12px;">
                                <div class="row">
                                    <button class="btn btn-sm btn-primary mt-2" style="float:left; width:80px; margin-left:13px; margin-bottom:15px; margin-top:-10px;" id="btn-tambah-lokasi" >Tambah</button>
                                    <table id="dtlokasi" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                                        <thead>
                                            <tr>
                                                <td hidden></td>
                                                <td>Lokasi</td>
                                                <td>Area</td>
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

        
    </div>
</div>

@include('admin.area_lokasi.form.form-add-area')
@include('admin.area_lokasi.form.form-add-lokasi')
@include('admin.area_lokasi.form.form-edit-area')
@include('admin.area_lokasi.form.form-edit-lokasi')
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            var dta = $('#dtarea').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('arealokasi.allarea')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'nama_area_lokasi', name:"nama_area_lokasi"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-area">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-area">Hapus</button>'
                    }},
                ]
            });

            var dtl = $('#dtlokasi').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('arealokasi.alllokasi')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'nama_lokasi', name:"nama_lokasi"},
                    {data:'area_lokasi_network_device.nama_area_lokasi', name:"area_lokasi_network_device.nama_area_lokasi"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-lokasi">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-lokasi">Hapus</button>'
                    }},
                ]
            });

            $('#btn-tambah-area').click(function () {
                $('#modal-tambah-area').modal('show');
            })

            $('#btn-simpan-area').click(function () {

                if($('#area').val() == ''){
                    swal.fire('Gagal!', "Area tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('nama_area_lokasi', $('#area').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('arealokasi.storearea')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('arealokasi.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#btn-tambah-lokasi').click(function () {
                $('#modal-tambah-lokasi').modal('show');
            })

            $('#btn-simpan-lokasi').click(function () {

                if($('#area_lokasi').val() == ''){
                    swal.fire('Gagal!', "Area tidak boleh kosong!", "error");
                }else if($('#lokasi').val() == ''){
                    swal.fire('Gagal!', "Lokasi tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('area_lokasi_network_device_id', $('#area_lokasi').val());
                data.append('nama_lokasi', $('#lokasi').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('arealokasi.storelokasi')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('arealokasi.index')}}";
                            window.location = url;

                        }else{
                            // swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#dtarea tbody').on('click','#btn-edit-area', function () {
                var id = dta.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/area-lokasi')}}"+"/"+id+"/area";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-area').modal('show');
                        $('#area-edit').val(response.nama_area_lokasi);
                        $('#area-id-edit').val(response.id);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtlokasi tbody').on('click','#btn-edit-lokasi', function () {
                var id = dtl.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/area-lokasi')}}"+"/"+id+"/lokasi";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-lokasi').modal('show');
                        $('#lokasi-id-edit').val(response.id);
                        $('#area-lokasi-edit').val(response.area_lokasi_network_device_id);
                        $('#lokasi-edit').val(response.nama_lokasi);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-update-area').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#area-id-edit').val());
                data.append('nama_area_lokasi', $('#area-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('arealokasi.updatearea')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-area').modal('hide');
                            $('#dtarea').DataTable().ajax.reload();
                            $('#dtlokasi').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#btn-update-lokasi').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#lokasi-id-edit').val());
                data.append('nama_lokasi', $('#lokasi-edit').val());
                data.append('area_lokasi_network_device_id', $('#area-lokasi-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('arealokasi.updatelokasi')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-lokasi').modal('hide');
                            $('#dtlokasi').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#dtarea tbody').on('click','#btn-hapus-area', function () {
                var id = dta.row($(this).parents('tr')).data().id;
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
                            url: "{{route('arealokasi.deletearea')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    $('#dtarea').DataTable().ajax.reload();
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

            

            $('#dtlokasi tbody').on('click','#btn-hapus-lokasi', function () {
                var id = dtl.row($(this).parents('tr')).data().id;
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
                            url: "{{route('arealokasi.deletelokasi')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    $('#dtlokasi').DataTable().ajax.reload();
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