@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Penyerahan Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-keluar')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-itemkeluar">Tambah</button>
                        <table id="dtitemkeluar" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Tgl Terima</td>
                                    <td>No Aset</td>
                                    <td>NIP</td>
                                    <td>Penerima</td>
                                    <td>Jabatan</td>
                                    <td>Nama Aset</td>
                                    <td>Seri</td>
                                    <td>Kategori</td>
                                    <td>Kondisi</td>
                                    <td>Actions</td>
                                    <td>BA</td>
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
@include('admin.inventaris.keluar.form.form-add')
@include('admin.inventaris.keluar.form.form-add-gambar')
@include('admin.inventaris.keluar.form.form-show-gambar')
@include('admin.inventaris.keluar.form.form-edit')
@include('admin.inventaris.keluar.form.export')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dti = $('#dtitemkeluar').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('itemkeluar.all')}}",
                "order":[[1, 'asc']],
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
                    {data:null, render:function(a,b,c,d){
                        return c.kode_item;
                        // kode = c.kode_item;
                        // var url = "{{url ('/admin/item/riwayat-aset/')}}" + "/" + kode.split('/').join('-');
                        // return '<a style="color:black; text-decoration:underline;" href="'+url+'" id="btn-riwayat-kode">'+c.kode_item+'</a>'
                    }},
                    {data:null, render:function(a,b,c,d){
                        return c.nip
                        // var url1 = "{{url ('/admin/item/riwayat-nip/')}}" + "/" + c.nip;
                        // return '<a style="color:black; text-decoration:underline" href="'+url1+'">'+c.nip+'</a>'
                    }},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'kategori', name:"kategori"},
                    {data:null, render:function(a,b,c,d){
                        if (c.kategori == 'CONSUMABLE') {
                            return '-'
                        }else{
                            if(c.status_item == '1'){
                                return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Baik</span>';
                            }else{
                                return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Rusak</span>';
                            }

                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-danger" id="btn-pdf-serah-terima">PDF</button><button class="btn btn-sm btn-warning" style="margin-left:5px" id="btn-edit-keluar">Edit</button>';
                    }},
                    {data:null, render:function(a,b,c,d){
                        if (c.gambar != '-') {
                            // return c.gambar;
                            var url = "{{asset('assets/images/device_out')}}"+"/"+c.gambar;
                            return '<a id="gambar"  href="#"><img src="'+url+'" style="width:20px;transform: rotate(90deg); margin-left:10px;"></a>';
                        }else{
                            return '<button class="btn btn-sm btn-primary" id="btn-tambah-gambar" ><span style="padding-left:5px;"><i class="bx bx-camera"></i></span></button>'
                        }
                    }},
                ]
            });  

            $('#nip').select2({
                allowClear: true,
                dropdownParent: $("#modal-tambah-keluar"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#nip-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-keluar"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });
            
            $('#kode_item-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-keluar"),
            });

            $('#nip-it').select2({
                allowClear: true,
                dropdownParent: $("#modal-export-keluar"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#kode_item').select2({
                dropdownParent: $('#modal-tambah-keluar'),
            });

            $('#btn-tambah-itemkeluar').click(function () {
                $('#modal-tambah-keluar').modal('show');
            });

            $('#dtitemkeluar tbody').on('click','#gambar', function () {
                var id = dti.row($(this).parents('tr')).data().id;
                var gambar = dti.row($(this).parents('tr')).data().gambar;

                var url = "{{asset('assets/images/device_out')}}"+"/"+gambar;
                $("#gambar-show").attr("src", url);
                $('#id-show-gambar').val(id);
                $('#modal-show-gambar').modal('show');
            })

            $('#dtitemkeluar tbody').on('click','#btn-tambah-gambar', function () {
                var id = dti.row($(this).parents('tr')).data().id;
                $('#id').val(id);
                $('.gambar').val('');
                $('#modal-tambah-gambar').modal('show');
            })

            $('#btn-batal-upload').click(function () {
                $('.gambar').val('');
                $('#modal-tambah-gambar').modal('hide');
            })

            $('#btn-ubah-gambar').click(function () {
                $('#modal-show-gambar').modal('hide');
                var id = $('#id-show-gambar').val();
                $('#id').val(id);
                $('.gambar').val('');
                $('#modal-tambah-gambar').modal('show');
            })

            $('#btn-hapus-gambar').click(function () {
                var id = $('#id-show-gambar').val();
                
                var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('id',id);
                swal.fire({
                    title: "Hapus?",
                    icon: 'question',
                    text: "Anda yakin ingin menghapus gambar?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                    
                }).then(function (e) {
                    if(e.value == true){
                        $.ajax({
                            method: "POST",
                            url: "{{route('itemkeluar.deletegambar')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                if(response.status == 200){
                                    $('#modal-show-gambar').modal('hide');
                                    $('#dtitemkeluar').DataTable().ajax.reload();
                                    swal.fire('Berhasil!',response.text, "success");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                    
                                }
                            });
                    }else{

                    }

                }) 
            })

            $('#btn-upload-gambar').click(function () {
                Swal.fire({
                    title: 'Mohon Tunggu!',
                    html: 'Gambar sedang diupload',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        
                    },
                })

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('gambar', $('.gambar').prop('files')[0]);
                data.append('id', $('#id').val());
                $.ajax({
                    method: "POST",
                    url: "{{route('itemkeluar.uploadgambar')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('.gambar').val('');
                            $('#modal-tambah-gambar').modal('hide');
                            $('#dtitemkeluar').DataTable().ajax.reload();
                            swal.fire('Berhasil!', "File Berhasil diupload!", "success");
                            // var url = "{{route('itemkeluar.index')}}";
                            // window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#dtitemkeluar tbody').on('click','#btn-pdf-serah-terima', function () {
                var id = dti.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/kategori/edit/')}}"+"/"+id;

                $('#modal-export-keluar').modal('show');
                $('#id-pdf').val(id);

            });

            $('#btn-simpan-item').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal', tgl);
                data.append('nip', $('#nip').val());
                data.append('kode_item', $('#kode_item').val());
                data.append('status_item', $('#kondisi').val());
                data.append('deskripsi', $('#deskripsi_item').val());
                $.ajax({
                    method: "POST",
                    url: "{{route('itemkeluar.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            $('#dtitemkeluar').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('itemkeluar.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtitemkeluar tbody').on('click','#btn-edit-keluar', function () {
                var id = dti.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/inventaris/keluar/edit/')}}"+"/"+id;

                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-keluar').modal('show');
                        $('#id-edit').val(response.id);
                        $('#kode_item-edit').val(response.kode_item).change();
                        $('#nip-edit').val(response.nip).trigger('change');
                        $('#tanggal-edit').val(response.tanggal);
                        $('#kondisi-edit').val(response.status_item);
                        $('#deskripsi-edit').val(response.deskripsi);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

            });

            $('#btn-ubah-itemkeluar').click(function () {
                var tgl = new Date($('#tanggal-edit').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#id-edit').val());
                data.append('kode_item', $('#kode_item-edit').val());
                data.append('tanggal', tgl);
                data.append('nip', $('#nip-edit').val());
                data.append('status_item', $('#kondisi-edit').val());
                data.append('deskripsi', $('#deskripsi-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('itemkeluar.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#dtitemkeluar').DataTable().ajax.reload();
                            $('#modal-edit-keluar').modal('hide');
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
    </script>
@endsection