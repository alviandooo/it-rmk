@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Form Permintaan Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-permintaan-edit')}}</p>
                </div>
            </div>
        </div>
        @if (session('status'))
            <div class="alert {{session('code') == 201 ? 'alert-success' : 'alert-danger'}} alert-dismissible fade show" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="card">
                <div class="card-body">
                        <form action="{{route('permintaan.update')}}" method="POST" id="form-update-permintaan">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" id="id" name="id" value="{{ Request::segment(4)}}">
                                    <div class="form-group">
                                        <label for="">Nomor Request Order : </label>
                                        <input name="ro_no" type="text" class="form-control" id="ro_no" readonly value="{{$data->ro_no}}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Nama Perusahaan : </label>
                                        <input name="nama_perusahaan" type="text" class="form-control" value="{{$data->nama_perusahaan}}">
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tanggal : </label>
                                        <input name="tanggal" type="date" class="datepicker form-control" value="{{$data->tanggal}}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Lokasi Kerja : </label>
                                        <input name="lokasi_kerja" type="text" class="form-control" value="{{$data->lokasi_kerja}}">
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tanggal Di Butuhkan : </label>
                                        <input name="tanggal_butuh" type="date" class="datepicker form-control" value="{{$data->tanggal_butuh}}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="status_permintaan">Status Permintaan : </label>
                                        <select name="status_urgent" id="" class="form-control">  
                                            <option {{$data->status_urgent == '1' ? 'selected' : ''}} value="1">Low</option>
                                            <option {{$data->status_urgent == '2' ? 'selected' : ''}} value="2">Medium</option>
                                            <option {{$data->status_urgent == '3' ? 'selected' : ''}} value="3">High</option>
                                            <option {{$data->status_urgent == '4' ? 'selected' : ''}} value="4">Critical</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="col-md-1">
                                            <a class="btn btn-success mb-2" href="" target="_blank" id="btn-excel">Excel</a>
                                        </div>
                                    <div class="border" style="padding :15px; display:block; overflow-x:scroll;">
                                        {{-- <a href="javascript:void(0);" class="btn btn-primary btn-sm" id="btn-tambah">Tambah</a> --}}
                                        <table class="table table-bordered mb-0" style="" id="table-permintaan-aset" style="width: 100%">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th hidden>id</th>
                                                    <td style="width:10px;">No</td>
                                                    <th>Part Name</th>
                                                    <th>Part Number</th>
                                                    <th>SAP Item Number</th>
                                                    {{-- <th>Component</th> --}}
                                                    <th>Qty Request</th>
                                                    <th>Qty Req to MR</th>
                                                    <th>UOM</th>
                                                    <th>Status</th>
                                                    <th>Remarks</th>
                                                    <th style="width: 15px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->item_permintaan as $key => $ip)
                                                    <tr>
                                                        <td hidden>{{$ip->id}}</td>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{strtoupper($ip->part_name)}}</td>
                                                        <td>{{strtoupper($ip->part_number)}}</td>
                                                        <td>{{$ip->sap_item_number}}</td>
                                                        {{-- <td>{{$ip->component}}</td> --}}
                                                        <td>{{$ip->qty_request}}</td>
                                                        <td>{{$ip->qty_request_mr}}</td>
                                                        <td>{{$ip->satuan->satuan}}</td>
                                                        <td class="text-center">
                                                            @if ($ip->status_item_permintaan == '0' )
                                                            
                                                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="badge bg-warning" style="color:black">PROCESS</span>
                                                                </a>
                                                                <ul class="dropdown-menu bg-transparant">
                                                                    <li class=""><a class="dropdown-item btn-status-complete" href="#">COMPLETE</a>
                                                                    </li>
                                                                    <li class=""><a class="dropdown-item btn-status-pending" href="#">PENDING</a>
                                                                    </li>
                                                                </ul>
                                                                {{-- <span class="badge bg-warning" ><a href="#" class="status_permintaan" style="color:black">PROCESS</a></span> --}}
                                                            @elseif($ip->status_item_permintaan == '1' )
                                                                {{-- <span class="badge bg-success" ><a href="#" class="status_permintaan" style="color:black">COMPLETE</a></span> --}}

                                                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="badge bg-success" style="color:black">COMPLETE</span>
                                                                </a>
                                                                <ul class="dropdown-menu bg-transparant">
                                                                    <li class=""><a class="dropdown-item btn-status-process" href="#">PROCESS</a>
                                                                    </li>
                                                                    <li class=""><a class="dropdown-item btn-status-pending" href="#">PENDING</a>
                                                                    </li>
                                                                </ul>
                                                            @elseif($ip->status_item_permintaan == '2' )
                                                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="badge bg-danger" style="">PENDING</span>
                                                                </a>
                                                                <ul class="dropdown-menu bg-transparant">
                                                                    <li class=""><a class="dropdown-item btn-status-process" href="#">PROCESS</a>
                                                                    </li>
                                                                    <li class=""><a class="dropdown-item btn-status-complete" href="#">COMPLETE</a>
                                                                    </li>
                                                                </ul>
                                                                {{-- <span class="badge bg-danger" ><a href="#" class="status_permintaan" style="color:black">PENDING</a></span> --}}
                                                            @endif
                                                        </td>
                                                        <td>{{strtoupper($ip->remarks)}}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                                <button type="button" class="btn btn-sm btn-warning button-edit"><i class="bx bx-edit me-0"></i></button>
                                                                <button type="button" class="btn btn-sm btn-danger button-hapus"><i class="bx bx-trash me-0"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="col">
                                    <ul>
                                        <li style="margin-bottom:5px;"><button class="btn btn-sm btn-warning" style="pointer-events: none;"><i class="bx bx-edit me-0"></i></button> : Edit Item</li>
                                        <li><button class="btn btn-sm btn-danger" style="pointer-events: none;"><i class="bx bx-trash me-0"></i></button> : Hapus Item</li>
                                    </ul>
                                </div>
                                <div class="col form-group">
                                    <button style="float: right" id="btn-update-permintaan" type="button" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                            
                        </form>

                 </div>
            </div>
        </div>
        

    </div>
</div>
@include('admin.permintaan.form.form-edit')
@endsection

@section('script')
    <script>
        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        if (isMobile) {
            // console.log("mobile");
        }else{
            // console.log("bukan");
        }
        $(document).ready(function () {

            var nomor_request_order = $('#ro_no').val();
            var url_excel = "{{url('/admin/permintaan/excel/item')}}"+"/"+nomor_request_order.replace(/\//g, "-");
            $('#btn-excel').attr("href", url_excel)

            var dtpa = $('#table-permintaan-aset').DataTable({});

            // var tambahButton = $('#btn-tambah');
            var tbody = $('#table-permintaan-aset tbody');
            // var fieldHTML2 = '<tr><td><textarea name="partname[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><textarea name="partnumber[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><textarea name="sap_item_number[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><textarea name="component[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><textarea name="qty_request[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><textarea name="qty_req_to_mr[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td><select name="uom[]" id="" class="form-control form-control-sm" style="width: 100%;">@foreach ($satuan as $s)<option value="{{$s->id}}">{{$s->satuan}}</option> @endforeach</select></td>'+
            //                 '<td><textarea name="remark[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
            //                 '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>'
                            
            // $(tambahButton).click(function () {
            //    $(tbody).append(fieldHTML2) 
            // });

            // $(tbody).on('click', '.hapus_button', function(e){
            //     e.preventDefault();
            //     $(this).parent().parent('tr').remove(); //Remove field html
            // });

            

            $(tbody).on('click', '.btn-status-process', function(e){
                e.preventDefault();
                // console.log($(this).parent().parent().parent().siblings()[0].innerHTML + " - 0");
                var id = $(this).parent().parent().parent().siblings()[0].innerHTML;
                var url = "{{url('/admin/item-permintaan/update/')}}"+"/"+id+"/0";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan/edit/')}}"+"/"+"{{Request::segment(4)}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $(tbody).on('click', '.btn-status-complete', function(e){
                e.preventDefault();
                // console.log($(this).parent().parent().parent().siblings()[0].innerHTML + " - 1");
                var id = $(this).parent().parent().parent().siblings()[0].innerHTML;
                var url = "{{url('/admin/item-permintaan/update/')}}"+"/"+id+"/1";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan/edit/')}}"+"/"+"{{Request::segment(4)}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $(tbody).on('click', '.btn-status-pending', function(e){
                e.preventDefault();
                // console.log($(this).parent().parent().parent().siblings()[0].innerHTML + " - 2");
                var id = $(this).parent().parent().parent().siblings()[0].innerHTML;
                var url = "{{url('/admin/item-permintaan/update/')}}"+"/"+id+"/2";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan/edit/')}}"+"/"+"{{Request::segment(4)}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#table-permintaan-aset tbody').on('click', '.button-edit', function(e){
                
                //ajax edit data dengan modal
                // var id = $(this).parent().siblings()[0].innerHTML;
                var id = dtpa.row($(this).parents('tr')).data()[0];
                var url = "{{ url('/admin/item-permintaan/edit/')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-item-permintaan').modal('show');
                        $('#id-edit').val(response.id);
                        $('#partname-edit').val(response.part_name);
                        $('#partnumber-edit').val(response.part_number);
                        $('#sap_item_number-edit').val(response.sap_item_number);
                        $('#component-edit').val(response.component);
                        $('#qty_request-edit').val(response.qty_request);
                        $('#qty_request_mr-edit').val(response.qty_request_mr);
                        $('#uom-edit').val(response.uom);
                        $('#remarks-edit').val(response.remarks);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#table-permintaan-aset tbody').on('click','.button-hapus', function (e) {

                // var id = $(this).parent().siblings()[0].innerHTML;
                var id = dtpa.row($(this).parents('tr')).data()[0];

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
                            url: "{{route('itempermintaan.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    swal.fire('Berhasil!',response.text, "success");
                                    var url = "{{url('/admin/permintaan/edit/')}}"+"/"+"{{Request::segment(4)}}";
                                    window.location = url;
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    
                                }
                            });
                    }else{

                    }

                }) 
            })

            $('#btn-update-permintaan').click(function () {
                Swal.fire({
                    title: 'Mohon Tunggu!',
                    html: 'Data sedang diubah...',
                    // timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })

                $('#form-update-permintaan').submit();
            })

            $('#btn-ubah-item-permintaan').click(function () {
                Swal.fire({
                    title: 'Mohon Tunggu!',
                    html: 'Data sedang diubah...',
                    // timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#id-edit').val());
                data.append('part_name', $('#partname-edit').val());
                data.append('part_number', $('#partnumber-edit').val());
                data.append('sap_item_number', $('#sap_item_number-edit').val());
                data.append('component', $('#component-edit').val());
                data.append('qty_request', $('#qty_request-edit').val());
                data.append('qty_request_mr', $('#qty_request_mr-edit').val());
                data.append('uom', $('#uom-edit').val());
                data.append('remarks', $('#remarks-edit').val());
                
                $.ajax({
                    method: "POST",
                    url: "{{route('itempermintaan.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{url('/admin/permintaan/edit/')}}"+"/"+"{{Request::segment(4)}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

        });
    </script>
@endsection