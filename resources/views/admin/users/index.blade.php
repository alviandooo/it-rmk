@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Users</h2>
                    <p>{{Breadcrumbs::render('users')}}</p>
                </div>
            </div>
        </div>

        @if (Auth::user()->nip == '88888888')
            <div class="row col-md-6">
                <div class="card">
                    <div class="card-body" >
                        <div class="">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">NIP :</label>
                                            <select name="" id="nip" class="form-control" style="width:100%">
                                                @foreach ($datakaryawan as $dk)
                                                    <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="">Nama :</label>
                                            <input type="text" class="form-control form-control-sm" id="nama">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email :</label>
                                            <input type="text" class="form-control form-control-sm" id="email">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="">Password :</label>
                                            <input type="password" class="form-control form-control-sm" id="password">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-primary mt-2" style="float:right" id="btn-tambah-user">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtuser" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>NIP</td>
                                    <td>Nama</td>
                                    <td>Email</td>
                                    <td>Role</td>
                                    <td>Status</td>
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

@include('admin.users.form.form-edit')

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            var dtu = $('#dtuser').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "ajax": "{{route('user.all')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'nip', name:"nip"},
                    {data:'name', name:"name"},
                    {data:'email', name:"email"},
                    {data:'role', name:"role"},
                    {data:null, render:function(a,b,c,d){
                        if(c.status_aktif == '1'){
                            return 'Aktif'
                        }else{
                            return 'Nonaktif'
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if({{Auth::user()->role}}  == '0'){
                            return '<button class="btn btn-sm btn-warning" id="btn-edit-user">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-user">Hapus</button>'

                        }else{
                            return '<button class="btn btn-sm btn-warning" id="btn-edit-user">Edit</button>'

                        }

                    }},
                    
                ]
            });

            $('#nip').select2({
                allowClear: true,
                placeholder: 'NIP Karyawan',
                
            });

            $('#btn-tambah-user').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('name', $('#nama').val());
                data.append('email', $('#email').val());
                data.append('nip', $('#nip').val());
                data.append('password', $('#password').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('user.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('user.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtuser tbody').on('click','#btn-edit-user', function () {
                var id = dtu.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/user/edit/')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#password-edit').val("");
                        $('#modal-edit-user').modal('show');
                        $('#nama-edit').val(response.name);
                        $('#email-edit').val(response.email);
                        $('#id-edit').val(response.id);
                        $('#status_aktif-edit').val(response.status_aktif).change();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-user').click(function () {
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#id-edit').val());
                data.append('status_aktif', $('#status_aktif-edit').val());
                data.append('nama', $('#nama-edit').val());
                data.append('password', $('#password-edit').val());
                data.append('email', $('#email-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('user.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-edit-user').modal('hide');
                            $('#dtuser').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtuser tbody').on('click','#btn-hapus-user', function () {
                var id = dtu.row($(this).parents('tr')).data().id;
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
                            url: "{{route('user.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtuser').DataTable().ajax.reload();
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