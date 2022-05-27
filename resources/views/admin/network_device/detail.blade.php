@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <h2>Data Network Device Area {{ucwords(strtolower($area->nama_area_lokasi))}}</h2>
                    <p>{{Breadcrumbs::render('network-device-area', ucwords(strtolower($area->nama_area_lokasi)))}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-md-1">
                                <p style="margin-top:10px;"><b>LOKASI :</b></p> 
                            </div>
                            <div class="col-md-2" style="margin-top:7px;">
                                <select  name="" id="select_lokasi" class="form-control-sm form-control">
                                    <option value="-" selected>SEMUA</option>
                                    @foreach ($lokasi as $l )
                                        <option value="{{$l->id}}">{{$l->nama_lokasi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <table id="dtnd" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>TANGGAL</td>
                                    <td>LOKASI</td>
                                    <td>NO ASET</td>
                                    <td>NAMA DEVICE</td>
                                    {{-- <td>NOMOR DEVICE</td> --}}
                                    <td>MODEL</td>
                                    <td>MERK</td>
                                    <td>IP</td>
                                    <td>USERNAME</td>
                                    <td>PASSWORD</td>
                                    <td>SSID</td>
                                    <td>SSID PASSWORD</td>
                                    
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
@include('admin.network_device.form.form-edit')
@endsection
@section('script')
    <script>
        $(document).ready(function () {

            $('#kode_item-edit').select2({
                dropdownParent: $('#modal-edit'),
            });

            $('#lokasi_device-edit').select2({
                dropdownParent: $('#modal-edit'),
            });

            $('#select_lokasi').select2({
            });

            var dtnd = $('#dtnd').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('networkdevice.detaildatabyarea', Request::segment(3))}}",
                "order": [[1, 'desc']],
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {orderable:true, data:'tanggal', render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'lokasi_network_device.nama_lokasi', name:"lokasi_network_device.nama_lokasi"},

                    {data:'kode_item', render:function(a,b,c,d){
                        var kode = c.kode_item
                        var k = kode.replace(/\//g, '-')
                        var url = "{{url('/admin/network-device/item/')}}"+"/"+k
                        return '<a href="'+url+'">'+c.kode_item+'</a>'
                    }},
                    {data:'item.nama_item', name:"item.nama_item"},
                    // {data:'device_no', name:"device_no"},
                    {data:'item.serie_item', name:"item.serie_item"},
                    {data:'item.merk', name:"item.merk"},
                    {data:'ip', name:"ip"},
                    {data:'username', name:"username"},
                    {data:'password', name:"password"},
                    {data:'ssid', name:"ssid"},
                    {data:'ssid_password', name:"ssid_password"},

                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit">Edit</button>'
                    }},
                ]
            });

            $('#select_lokasi').change(function () {
                if(this.value == '-'){
                    var url = "{{route('networkdevice.detaildatabyarea', Request::segment(3))}}";
                }else{
                    var lokasi_id = this.value;
                    var area_id = "{{Request::segment(3)}}";
                    var url = "{{ url('/admin/network-device')}}"+"/"+area_id+"/"+lokasi_id+"/detail-area/data";
                }
                dtnd.ajax.url( url ).load();
            })

            $('#dtnd tbody').on('click', '#btn-edit', function () {
                var id = dtnd.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/network-device/edit')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit').modal('show');
                        $('#id-edit').val(response.id);
                        $('#tanggal-edit').val(response.tanggal);
                        $('#alias-edit').val(response.alias);
                        $('#kode_item-edit').val(response.kode_item).change();
                        $('#device_no-edit').val(response.device_no);
                        $('#ip-edit').val(response.ip);
                        $('#username-edit').val(response.username);
                        $('#password-edit').val(response.password);
                        $('#ssid-edit').val(response.ssid);
                        $('#ssid_password-edit').val(response.ssid_password);
                        $('#lokasi_device-edit').val(response.lokasi_network_device_id).change();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

                $('#btn-update').click(function () {
                    var tgl = new Date($('#tanggal-edit').val()).toLocaleDateString("ID").replace(/\//g, "-");

                    var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('id', $('#id-edit').val());
                    data.append('tanggal', tgl);
                    data.append('kode_item', $('#kode_item-edit').val());
                    data.append('device_no', $('#device_no-edit').val());
                    data.append('alias', $('#alias-edit').val().toUpperCase());
                    data.append('ip', $('#ip-edit').val());
                    data.append('username', $('#username-edit').val());
                    data.append('password', $('#password-edit').val());
                    data.append('ssid', $('#ssid-edit').val());
                    data.append('ssid_password', $('#ssid_password-edit').val());
                    data.append('lokasi_network_device_id', $('#lokasi_device-edit').val());

                    $.ajax({
                        method: "POST",
                        url: "{{route('networkdevice.update')}}",
                        processData: false,
                        contentType: false,
                        data: data,
                        success: function(response) {
                            if(response.status == 200){
                                $('#modal-edit').modal('hide');
                                $('#dtnd').DataTable().ajax.reload();
                                swal.fire('Berhasil!',response.text, "success");

                            }else{
                                swal.fire('Gagal!',response.text, "error");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                });
               
            });

        });
    </script>
@endsection