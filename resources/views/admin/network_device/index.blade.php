@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <h2>Data Network Device</h2>
                    <p>{{Breadcrumbs::render('network-device')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="" style="margin-bottom: 10px;">
                            {{-- <button class="btn btn-sm btn-primary" id="btn-tambah">Tambah</button> --}}
                            <a href="#" class="btn btn-sm btn-primary" id="btn-tambah">Tambah</a>
                            <a href="{{route('item.exportnd','1')}}" class="btn btn-sm btn-warning" style="" target="_blank">Excel</a>
                            <a href="{{route('item.exportnd','2')}}" class="btn btn-sm btn-danger" style="" target="_blank">PDF</a>

                        </div>
                        <table id="dtnd" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>Area Lokasi Device</td>
                                    <td>Jumlah</td>
                                    <td>Action</td>
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
@include('admin.network_device.form.form-add')
@include('admin.area_lokasi.form.form-add-lokasi')
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $('#kode_item').select2({dropdownParent: $('#modal-tambah'),});
            $('#lokasi_device').select2({dropdownParent: $('#modal-tambah'),});

            var dtnd = $('#dtnd').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('networkdevice.allbyarea')}}",
                "columns": [
                    {data:'area', name:"area"},
                    {data:'jumlah', name:"jumlah"},
                    {data:null, render:function(a,b,c,d){
                        var url = "{{url('/admin/network-device')}}"+ "/" + c.id + "/detail-area"
                        return '<a href="'+url+'" class="btn btn-sm btn-warning">Detail</a>'
                    }},
                ]
            });

            $('#btn-tambah').click(function () {
               $('#modal-tambah').modal('show'); 
            });

            $('#btn-simpan').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode_item', $('#kode_item').val());
                data.append('device_no', $('#device_no').val());
                data.append('tanggal', tgl);
                data.append('ip', $('#ip').val());
                data.append('username', $('#username').val());
                data.append('password', $('#password').val());
                data.append('alias', $('#alias').val().toUpperCase());
                data.append('ssid', $('#ssid').val());
                data.append('ssid_password', $('#ssid_password').val());
                data.append('lokasi_network_device_id', $('#lokasi_device').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('networkdevice.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('networkdevice.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                }); 
            });

            $('#tambah-lokasi').click(function () {
                $('#modal-tambah').modal('hide'); 
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
                            var url = "{{route('networkdevice.index')}}";
                            window.location = url;

                        }else{
                            // swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })
            
        });
    </script>
@endsection