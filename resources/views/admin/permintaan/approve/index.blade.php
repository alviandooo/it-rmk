@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Approval Permintaan Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-permintaan-approve')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtpermintaan" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Tanggal Permintaan</td>
                                    <td>Nomor RO</td>
                                    <td>Lokasi Kerja</td>
                                    <td>Status Item</td>
                                    <td>Approvement</td>
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
@include('admin.permintaan.form.export')
@include('admin.permintaan.form.sign')
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            var dtp = $('#dtpermintaan').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order":[[1, 'desc']],
                "ajax": "{{route('permintaan.getAllApprove')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'ro_no', data:'ro_no'},
                    {data:'lokasi_kerja', name:"lokasi_kerja"},
                    {data:null, render:function(a,b,c,d){
                        if(c.status_permintaan == '0'){
                            return '<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                                    '<span class="badge bg-warning" style="color:black">PROCESS</span></a>'+
                                                                '<ul class="dropdown-menu bg-transparant">'+
                                                                    '<li class=""><a class="dropdown-item btn-status-complete" href="#">COMPLETE</a></li>'+
                                                                    '<li class=""><a class="dropdown-item btn-status-pending" href="#">PENDING</a></li></ul>'
                        }else if(c.status_permintaan == '1'){
                            // return '<a href="#"><span class="badge bg-success" style="color:black">COMPLETE</span></a>'
                            return '<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                                    '<span class="badge bg-success" style="color:black">COMPLETE</span></a>'+
                                                                '<ul class="dropdown-menu bg-transparant">'+
                                                                    '<li class=""><a class="dropdown-item btn-status-process" href="#">PROCESS</a></li>'+
                                                                    '<li class=""><a class="dropdown-item btn-status-pending" href="#">PENDING</a></li></ul>'
                        }else if(c.status_permintaan == '3'){
                            // return '<a href="#"><span class="badge bg-info" style="color:black">INCOMPLETE</span></a>'
                            return '<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                                    '<span class="badge bg-info" style="color:black">INCOMPLETE</span></a>'+
                                                                '<ul class="dropdown-menu bg-transparant">'+
                                                                    '<li class=""><a class="dropdown-item btn-status-complete" href="#">COMPLETE</a></li>'+
                                                                    '<li class=""><a class="dropdown-item btn-status-pending" href="#">PENDING</a></li></ul>'
                        }else if(c.status_permintaan == '2'){
                            // return '<a href="#"><span class="badge bg-danger" style="color:black">PENDING</span></a>'
                            return '<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">'+
                                                                    '<span class="badge bg-danger" style="">PENDING</span></a>'+
                                                                '<ul class="dropdown-menu bg-transparant">'+
                                                                    '<li class=""><a class="dropdown-item btn-status-process" href="#">PROCESS</a></li>'+
                                                                    '<li class=""><a class="dropdown-item btn-status-complete" href="#">COMPLETE</a></li></ul>'
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if(c.status_approval != "-"){
                            return '<span class="badge bg-secondary">waiting</span>';
                        }else{
                            return '<span class="badge bg-success">approved</span>';
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                    //     var url = "{{url('/admin/permintaan/edit/')}}"+"/"+c.id
                    //     if(c.status_approval == "0"){
                    //         // return '<a href="'+url+'"class="btn btn-sm btn-warning">Edit</a><button class="btn btn-sm btn-danger" id="btn-pdf" style="margin-left:5px;">PDF</button><button class="btn btn-sm btn-success" id="btn-sign" style="margin-left:5px;">Sign</button>'
                    //         return '<a href="'+url+'"class="btn btn-sm btn-warning">Detail</a><button class="btn btn-sm btn-danger" id="btn-pdf" style="margin-left:5px;">PDF</button>'
                    //     }else if(c.status_approval != '4'){
                    //         return '<button class="btn btn-sm btn-danger" id="btn-pdf" style="margin-left:5px;">PDF</button><button class="btn btn-sm btn-success" id="btn-approve" style="margin-left:5px;">Approve</button>'
                    //     }
                            var urutan_dokumen = c.status_approval;
                            var urutan_approval = c.approval[0].urutan;

                            var url = "{{url('/admin/permintaan/edit/')}}"+"/"+c.id
                            if((c.approval[0].status_approve == '0') && (urutan_approval == urutan_dokumen)){
                                return '<button class="btn btn-sm btn-success" id="btn-approve" style="margin-right:5px;">Approve</button><a href="'+url+'"class="btn btn-sm btn-warning">Detail</a>'
                            }else{
                                return '<a href="'+url+'"class="btn btn-sm btn-warning">Detail</a>'
                            }
                    }},
                ]
            }); 

            $('#dtpermintaan tbody').on('click', '#btn-approve', function(e){
                e.preventDefault();
                var ro = dtp.row($(this).parents('tr')).data().ro_no;
                var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('ro',ro);
                    data.append('nip',{{Auth::user()->nip}});

                swal.fire({
                    title: "Approve?",
                    icon: 'question',
                    text: "Anda yakin ingin menyetujui dokumen?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                    
                }).then(function (e) {
                    if(e.value == true){
                        Swal.fire({
                            title: 'Mohon ditunggu!',
                            html: 'Data sedang dibackup...',
                            // timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        })
                        
                        $.ajax({
                            method: "POST",
                            url: "{{route('permintaan.updatestatusapprove')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    $('#dtpermintaan').DataTable().ajax.reload();
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

            $('#dtpermintaan tbody').on('click', '.btn-status-pending', function(e){
                e.preventDefault();
                var ro = dtp.row($(this).parents('tr')).data().ro_no;
                var url = "{{url('/admin/permintaan/update')}}"+"/"+ro+"/2";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan')}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtpermintaan tbody').on('click', '.btn-status-process', function(e){
                e.preventDefault();
                var ro = dtp.row($(this).parents('tr')).data().ro_no;
                var url = "{{url('/admin/permintaan/update')}}"+"/"+ro+"/0";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan')}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtpermintaan tbody').on('click', '.btn-status-complete', function(e){
                e.preventDefault();
                // console.log($(this).parent().parent().parent().siblings()[0].innerHTML + " - 0");
                // var id = $(this).parent().parent().parent().siblings()[0].innerHTML;
                var ro = dtp.row($(this).parents('tr')).data().ro_no;
                var url = "{{url('/admin/permintaan/update')}}"+"/"+ro+"/1";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan')}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#nip-it').select2({
                allowClear: true,
                dropdownParent: $("#modal-export-permintaan"),
                placeholder: 'NIP Karyawan',
            });

            $('#dtpermintaan tbody').on('click','#btn-pdf', function () {
                var id = dtp.row($(this).parents('tr')).data().id;
                $('#modal-export-permintaan').modal('show');
                $('#id-pdf').val(id);
            });

            $('#dtpermintaan tbody').on('click','#btn-sign', function () {
                var id = dtp.row($(this).parents('tr')).data().id;
                $('#modal-sign-permintaan').modal('show');
                // $('#id-pdf').val(id);
            });
        
        });
    </script>

@endsection