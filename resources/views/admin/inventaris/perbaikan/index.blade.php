@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Perbaikan Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-perbaikan')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    {{-- <a class="btn btn-primary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tambah
                    </a>
                    <ul class="dropdown-menu bg-transparant">
                        <li class=""><a class="dropdown-item " id="btn-perbaikan" href="#">Perbaikan</a>
                        </li>
                        <li class=""><a class="dropdown-item " id="btn-upgrade" href="#">Upgrade</a>
                        </li>
                    </ul> --}}
                    <button id="btn-upgrade" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-header" style="text-align: center">
                    <h5>Data Service Aset</h5> 
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-itemkeluar">Tambah</button> --}}
                        <table id="dtitemperbaikan" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td style="width:25px;">Tgl Perbaikan</td>
                                    <td>No Aset</td>
                                    <td>NIP</td>
                                    <td>User</td>
                                    <td>Jabatan</td>
                                    <td>Nama Aset</td>
                                    <td>Seri</td>
                                    <td>Kategori</td>
                                    <td>Jenis</td>
                                    <td>Deskripsi</td>
                                    <td>Keterangan</td>
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
     
        <div class="card">
            <div class="card-header" style="text-align: center">
                <h5>Data Upgrade Aset</h5> 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-itemkeluar">Tambah</button> --}}
                    <table id="dtitemupgrade" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                        <thead>
                            <tr>
                                <td style="width:25px;">Tgl Upgrade</td>
                                <td>No Aset</td>
                                <td>Nama Aset</td>
                                <td>Seri</td>
                                <td>Kategori</td>
                                <td>Jenis</td>
                                <td>No Item Upgrade</td>
                                <td>Nama</td>
                                <td>Seri</td>
                                <td>Jumlah</td>
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
@include('admin.inventaris.perbaikan.form.form-add')
@include('admin.inventaris.perbaikan.form.form-add-upgrade')
@include('admin.inventaris.perbaikan.form.form-edit')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dtip = $('#dtitemperbaikan').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order":[[1, 'desc']],
                "ajax": "{{route('itemperbaikan.getAll')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal_perbaikan).getDate(); 
                        var bln = bulan[new Date(c.tanggal_perbaikan).getMonth()];
                        var tahun = new Date(c.tanggal_perbaikan).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'kode_item', name:"kode_item"},
                    {data:'nip', name:"nip"},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'kategori', name:"kategori"},
                    {data:null, render:function(a,b,c,d){
                        if(c.jenis_perbaikan == "2"){
                            return 'Perbaikan';
                        }else{
                            return 'Upgrade';
                        }
                    }},
                    {data:'deskripsi', name:"deskripsi"},
                    {data:'keterangan', name:"keterangan"},
                    {data:null, render:function(a,b,c,d){
                        return '<button class="btn btn-sm btn-warning" id="btn-edit-perbaikan">Edit</button><button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-perbaikan">Hapus</button>'
                    }},
                ]
            }); 
            
            var dtiu = $('#dtitemupgrade').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order":[[1, 'desc']],
                "ajax": "{{route('itemupgrade.getAll')}}",
                "columns": [
                    {data:null, render:function(a,b,c,d){
                        var bulan = ['Januari', 'Februari', 'Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        var tgl = new Date(c.tanggal).getDate(); 
                        var bln = bulan[new Date(c.tanggal).getMonth()];
                        var tahun = new Date(c.tanggal).getYear();
                        var thn = (tahun < 1000) ? tahun + 1900 : tahun;
                        return tgl+" "+bln+" "+thn;
                    }},
                    {data:'kode_item', name:"kode_item"},
                    {data:'item.nama_item', name:"item.nama_item"},
                    {data:'item.serie_item', name:"item.serie_item"},
                    {data:'item.kategori.kategori', name:"item.kategori.kategori"},
                    {data:null, render:function(a,b,c,d){
                        return "UPGRADE";
                    }},
                    {data:'kode_item_upgrade', name:"kode_item_upgrade"},
                    {data:null, render:function(a,b,c,d){
                        return c.item_part[0].nama_item
                    }},
                    {data:null, render:function(a,b,c,d){
                        return c.item_part[0].serie_item
                    }},
                    {data:'jumlah', name:"jumlah"},
                    {data:null, render:function(a,b,c,d){
                        return '<button style="margin-left:7px;" class="btn btn-sm btn-danger" id="btn-hapus-upgrade">Hapus</button>'
                    }},

                    
                ]
            }); 

            $('#nip').select2({
                allowClear: true,
                dropdownParent: $("#modal-tambah-perbaikan"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#nip-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-perbaikan"),
            });

            $('#kode_item').select2({
                dropdownParent: $('#modal-tambah-perbaikan'),
            });

            $('#kode_item-edit').select2({
                dropdownParent: $('#modal-edit-perbaikan'),
            });

            $('#btn-tambah-itemkeluar').click(function () {
                $('#modal-tambah-perbaikan').modal('show');
            });

            $('#btn-perbaikan').click(function () {
                $('#modal-tambah-perbaikan').modal('show');
            });

            $('#btn-upgrade').click(function () {
                $('#modal-tambah-upgrade').modal('show');
            });

            $('#btn-more').click(function () {
                var id = $('#upgrade_kode_item_upgrade').val();
                var url = "{{ url('/admin/item/')}}"+"/"+id+"/data";
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#tbody').append('<tr class="row-body"><td><input type="text" name="kode_item_upgrade[]" class="form-control kode_item_upgrade[]" readonly value="'+response.kode_item+'""></td><td><input type="text" class="form-control" readonly value="'+response.nama_item+'"></td><td><input type="text" class="form-control" readonly value="'+response.serie_item+'"></td><td><input type="number" class="form-control" name="jumlah_item_upgrade[]" value="1"></td></tr>')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
                
            })

            $('#btn-tutup-modal-upgrade').click(function () {
                $('.row-body').remove();
                $('#modal-tambah-upgrade').modal('hide');
            })

            $('#btn-reset-modal-upgrade').click(function () {
                $('.row-body').remove();
            })

            $('#dtitemperbaikan tbody').on('click','#btn-edit-perbaikan', function () {
                var id = dtip.row($(this).parents('tr')).data().id;
                var url = "{{ url('/admin/inventaris/edit/')}}"+"/"+id;
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        
                        $('#modal-edit-perbaikan').modal('show');
                        $('#id-edit').val(response.id);
                        $('#tanggal_perbaikan-edit').val(response.tanggal_perbaikan);
                        $('#kode_item-edit').val(response.kode_item).change();
                        $('#nip-edit').val(response.nip).change();
                        $('#jenis_perbaikan-edit').val(response.jenis_perbaikan).change();
                        $('#deskripsi-edit').val(response.deskripsi);
                        $('#keterangan-edit').val(response.keterangan);

                        // $('#kategori_item-edit').val(response.kategori);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-perbaikan').click(function () {
                var tgl = new Date($('#tanggal_perbaikan-edit').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#id-edit').val());
                data.append('tanggal_perbaikan', tgl);
                data.append('kode_item', $('#kode_item-edit').val());
                data.append('nip', $('#nip-edit').val());
                data.append('jenis_perbaikan', $('#jenis_perbaikan-edit').val());
                data.append('deskripsi', $('#deskripsi-edit').val());
                data.append('keterangan', $('#keterangan-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('itemperbaikan.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#dtitemperbaikan').DataTable().ajax.reload();
                            $('#modal-edit-perbaikan').modal('hide');
                            swal.fire('Berhasil!',response.text, "success");

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-simpan-perbaikan').click(function () {
                var tglp = new Date($('#tanggal_perbaikan').val()).toLocaleDateString("ID").replace(/\//g, "-");
                
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal_perbaikan', tglp);
                data.append('tanggal_selesai', tglp);
                data.append('nip', $('#nip').val());
                data.append('kode_item', $('#kode_item').val());
                data.append('jenis_perbaikan', $('#jenis_perbaikan').val());
                data.append('deskripsi', $('#deskripsi').val());
                data.append('keterangan', $('#keterangan').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('itemperbaikan.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtitemkeluar').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('itemperbaikan.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-simpan-upgrade').click(function () {
                var tglu = new Date($('#tanggal_upgrade').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var kode_item_upgrade = $('input[name^=kode_item_upgrade]').map(function(idx, elem) {
                    return $(elem).val();
                }).get();

                var jumlah = $('input[name^=jumlah_item_upgrade]').map(function(idx, elem) {
                    return $(elem).val();
                }).get();

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal', tglu);
                data.append('kode_item', $('#upgrade_kode_item').val());
                data.append('kode_item_upgrade', kode_item_upgrade);
                data.append('jumlah', jumlah);

                $.ajax({
                    method: "POST",
                    url: "{{route('itemupgrade.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtitemkeluar').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('itemperbaikan.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtitemperbaikan tbody').on('click','#btn-hapus-perbaikan', function () {
                var id = dtip.row($(this).parents('tr')).data().id;
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
                            url: "{{route('itemperbaikan.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtitemperbaikan').DataTable().ajax.reload();
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

            $('#dtitemupgrade tbody').on('click','#btn-hapus-upgrade', function () {
                var id = dtiu.row($(this).parents('tr')).data().id;
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
                            url: "{{route('itemupgrade.delete')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtitemupgrade').DataTable().ajax.reload();
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