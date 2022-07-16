@extends('layouts.masterbaru')
@section('style')
    {{-- chart --}}
@endsection
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Site</h2>
                    <p>{{Breadcrumbs::render('site')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" id="btn-tambah-site">Tambah</button>
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover" id="dts" style="width: 100%">
                            <thead>
                                <tr>
                                    <td>Kode</td>
                                    <td>Nama Perusahaan</td>
                                    <td>Lokasi</td>
                                    <td>Alamat</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@include('admin.site.form.form-add')
@include('admin.site.form.form-edit')
@endsection
@section("script")

    <script>
        $(document).ready(function () {
            var dtsi = $('#dts').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                // "order": [[ 7, "desc" ]],
                "ajax": "{{route('site.getAll')}}",
                "columns": [
                    {data:'kode_perusahaan', name:"kode_perusahaan"},
                    {data:'nama_perusahaan', name:"nama_perusahaan"},
                    {data:'lokasi_perusahaan', name:"lokasi_perusahaan"},
                    {data:'alamat_perusahaan', name:"alamat_perusahaan"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-site">Edit</button><button style="margin-left:5px;" class="btn btn-sm btn-danger" id="btn-hapus-site">Hapus</button>'
                    }},
                    
                ]
            });

            $('#btn-tambah-site').click(function () {
                $('#modal-tambah-site').modal('show');
            })

            $('#btn-simpan-site').click(function () {
                // $('#modal-tambah-site').modal('hide');

                kode = $('#kode').val();
                nama_perusahaan = $('#nama_perusahaan').val();
                lokasi = $('#lokasi').val();
                alamat = $('#alamat').val();

                if(kode == ""){
                    swal.fire('Error!', "Kode tidak boleh kosong!", "error");
                }else if(nama_perusahaan == ""){
                    swal.fire('Error!', "No Nama Perusahaan tidak boleh kosong!", "error");
                }else if(lokasi == ""){
                    swal.fire('Error!', "No Lokasi tidak boleh kosong!", "error");
                }else if(alamat == ""){
                    swal.fire('Error!', "No Alamat tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode_perusahaan', kode);
                data.append('nama_perusahaan', nama_perusahaan);
                data.append('lokasi_perusahaan', lokasi);
                data.append('alamat_perusahaan', alamat);

                $.ajax({
                    method: "POST",
                    url: "{{route('site.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('site.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

            })

            $('#btn-ubah-site').click(function () {

                kode = $('#kode-edit').val();
                nama_perusahaan = $('#nama_perusahaan-edit').val();
                lokasi = $('#lokasi-edit').val();
                alamat = $('#alamat-edit').val();
                id = $('#id-edit').val();

                if(kode == ""){
                    swal.fire('Error!', "Kode tidak boleh kosong!", "error");
                }else if(nama_perusahaan == ""){
                    swal.fire('Error!', "No Nama Perusahaan tidak boleh kosong!", "error");
                }else if(lokasi == ""){
                    swal.fire('Error!', "No Lokasi tidak boleh kosong!", "error");
                }else if(alamat == ""){
                    swal.fire('Error!', "No Alamat tidak boleh kosong!", "error");
                }

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode_perusahaan', kode);
                data.append('nama_perusahaan', nama_perusahaan);
                data.append('lokasi_perusahaan', lokasi);
                data.append('alamat_perusahaan', alamat);
                data.append('id', id);

                $.ajax({
                    method: "POST",
                    url: "{{route('site.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('site.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

            })

            $('#dts tbody').on('click','#btn-edit-site', function () {
                var id = dtsi.row($(this).parents('tr')).data().id;
                var url = "{{url('/admin/site/edit')}}"+"/"+id
                $.ajax({
                    method: "GET",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            $('#id-edit').val(response.data.id)
                            $('#kode-edit').val(response.data.kode_perusahaan)
                            $('#nama_perusahaan-edit').val(response.data.nama_perusahaan)
                            $('#lokasi-edit').val(response.data.lokasi_perusahaan)
                            $('#alamat-edit').val(response.data.alamat_perusahaan)
                            $('#modal-edit-site').modal('show');

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
                

            })

            $('#dts tbody').on('click','#btn-hapus-site', function () {
                var id = dtsi.row($(this).parents('tr')).data().id;

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', id);

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
                            url: "{{route('site.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    // $('#dtjabatan').DataTable().ajax.reload();
                                    swal.fire('Berhasil!',response.text, "success");
                                    var url = "{{route('site.index')}}";
                                    window.location = url;

                                }else{
                                    swal.fire('Gagal!',response.text, "error");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    
                            }
                        });
                    }else{

                    }

                }) 

            })
        });
        
    </script>
@endsection