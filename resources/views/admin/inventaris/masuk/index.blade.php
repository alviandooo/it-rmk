@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Pengembalian Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-masuk')}}</p>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive ">
                        {{-- <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-masuk">Tambah</button> --}}
                        <a class="btn btn-primary" style="margin-bottom: 15px" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tambah
                        </a>
                        <ul class="dropdown-menu bg-transparant">
                            <li class=""><a class="dropdown-item " id="btn-tambah-masuk" href="#">Device</a>
                            </li>
                            <li class=""><a class="dropdown-item " id="btn-tambah-masuk-consumable" href="#">Consumable</a>
                            </li>
                        </ul>
                        <table id="dtmasuk" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Tgl Kembali</td>
                                    <td>Kode Item</td>
                                    <td>Nama Karyawan</td>
                                    <td>Jabatan</td>
                                    <td>Departemen</td>
                                    <td>Nama Aset</td>
                                    <td>Merek</td>
                                    <td>Serie Aset</td>
                                    <td>Kategori</td>
                                    <td>Deskripsi</td>
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

@include('admin.inventaris.masuk.form.form-add')
@include('admin.inventaris.masuk.form.form-add-consumable')
@include('admin.inventaris.masuk.form.form-add-gambar')
@include('admin.inventaris.masuk.form.form-show-gambar')
@include('admin.inventaris.masuk.form.form-edit')
@include('admin.inventaris.masuk.form.export')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dtm = $('#dtmasuk').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order":[[1, 'desc']],

                "ajax": "{{route('itemmasuk.all')}}",
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
                    {data:'kode_item', name:"kode_item"},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:'departemen', name:"departemen"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'merk', name:"merk"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'kategori', name:"kategori"},
                    {data:'deskripsi', name:"deskripsi"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-danger" id="btn-pdf">PDF</button><button class="btn btn-sm btn-warning" style="margin-left:5px" id="btn-edit-masuk">Edit</button>'
                    }},
                    {data:null, render:function(a,b,c,d){
                        if (c.gambar != '-') {
                            // return c.gambar;
                            var url = "{{asset('assets/images/device_in')}}"+"/"+c.gambar;
                            return '<a id="gambar"  href="#"><img src="'+url+'" style="width:50px;"></a>';
                        }else{
                            return '<button class="btn btn-sm btn-primary" id="btn-tambah-gambar" ><span style="padding-left:5px;"><i class="bx bx-camera"></i></span></button>'
                        }
                    }},
                ]
            });  

            $('#nip-it').select2({
                allowClear: true,
                dropdownParent: $("#modal-export-masuk"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#nip-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-masuk"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#dtmasuk tbody').on('click','#gambar', function () {
                var gambar = dtm.row($(this).parents('tr')).data().gambar;

                var url = "{{asset('assets/images/device_in')}}"+"/"+gambar;
                $("#gambar-show").attr("src", url);
                $('#modal-show-gambar').modal('show');
            })

            $('#dtmasuk tbody').on('click','#btn-tambah-gambar', function () {
                var id = dtm.row($(this).parents('tr')).data().id;
                $('#id').val(id);
                $('.gambar').val('');
                $('#modal-tambah-gambar').modal('show');
            })

            $('#btn-batal-upload').click(function () {
                $('.gambar').val('');
                $('#modal-tambah-gambar').modal('hide');
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
                    url: "{{route('itemmasuk.uploadgambar')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('.gambar').val('');
                            $('#modal-tambah-gambar').modal('hide');
                            $('#dtmasuk').DataTable().ajax.reload();
                            swal.fire('Berhasil!', "File Berhasil diupload!", "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#dtmasuk tbody').on('click','#btn-pdf', function () {
                var id = dtm.row($(this).parents('tr')).data().id;
                $('#modal-export-masuk').modal('show');
                $('#id-pdf').val(id);
            });

            $('#dtmasuk tbody').on('click','#btn-edit-masuk', function () {
                var id = dtm.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/inventaris/masuk/edit/')}}"+"/"+id;

                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-masuk').modal('show');
                        $('#id-edit').val(response.id);
                        $('#kode_item-edit').val(response.kode_item).change();
                        $('#nip-edit').val(response.nip).change();
                        $('#tanggal-edit').val(response.tanggal);
                        $('#kondisi-edit').val(response.status_item);
                        $('#deskripsi-edit').val(response.deskripsi);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-itemmasuk').click(function () {
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
                    url: "{{route('itemmasuk.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#dtmasuk').DataTable().ajax.reload();
                            $('#modal-edit-masuk').modal('hide');
                            swal.fire('Berhasil!',response.text, "success");
                            

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });
        
            $('#btn-tambah-masuk').click(function () {
                $('#modal-tambah-masuk').modal('show');
            });

            $('#btn-tambah-masuk-consumable').click(function () {
                $('#modal-tambah-masuk-consumable').modal('show');
            });

            $('#btn-simpan-itemmasuk').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");

                if($('#nip2lengkap').val() == ""){
                    swal.fire('Gagal!', "Nama tidak boleh kosong!", "error");
                }else{

                    var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('kode_item', $('#kode_item').val());
                    data.append('tanggal', tgl);
                    data.append('nip', $('#nip2lengkap').val());
                    data.append('status_item', $('#kondisi').val());
                    data.append('deskripsi', $('#deskripsi').val());
    
                    $.ajax({
                        method: "POST",
                        url: "{{route('itemmasuk.store')}}",
                        processData: false,
                        contentType: false,
                        data: data,
                        success: function(response) {
                            if(response.status == 201){
                                // $('#dtjabatan').DataTable().ajax.reload();
                                swal.fire('Berhasil!',response.text, "success");
                                var url = "{{route('itemmasuk.index')}}";
                                window.location = url;
    
                            }else{
                                swal.fire('Gagal!',response.text, "error");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                }

            });

            $('#btn-simpan-itemmasuk-consumable').click(function () {
                var tgl = new Date($('#tanggal_consumable').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode_item', $('#kode_item_consumable').val());
                data.append('tanggal', tgl);
                data.append('nip', $('#nip_consumable').val());
                data.append('status_item', $('#kondisi_consumable').val());
                data.append('deskripsi', $('#deskripsi_consumable').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('itemmasuk.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('itemmasuk.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#nip').change(function name(params) {
                // setting option item sesuai nik pengguna
                var nik = this.value
                var url = "{{url('/admin/inventaris/kerusakan')}}" +"/"+nik+"/item";
                $.ajax({
                    method: "GET",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#kode_item').empty();
                        $.each(response.data, function (key, item) {
                            $('#kode_item').append($('<option value="' +item.kode_item+ '">' +item.kode_item+ " - " +item.nama_item+ " - " +item.merk+ " - " +item.serie_item+ '</option>'));                           
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });

            })

            $('#kode_item').select2({
                dropdownParent: $('#modal-tambah-masuk'),
            });

            $('#kode_item-edit').select2({
                dropdownParent: $('#modal-edit-masuk'),
            });

            $('#kode_item').change(function () {
                var kode =this.value;
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode', kode);

                $.ajax({
                    method: "post",
                    url: "{{route('itemmasuk.getitemkeluar')}}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                       $('#nip2').css('display','block');
                       $('#nip2lengkap').val(response.nip);
                       $('#nama').css('display','block');
                       $('#namakaryawan').val(response.nama);
                       $('#nip1').css('display','none');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            })

            $('#nip').select2({
                allowClear: true,
                dropdownParent: $("#modal-tambah-masuk"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

        });
    </script>
@endsection