@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Kerusakan Aset</h2>
                    <p>{{Breadcrumbs::render('inventaris-kerusakan')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-kerusakan">Tambah</button>
                        <table id="dtkerusakan" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Tanggal</td>
                                    <td>Nomor Aset</td>
                                    <td>Kategori</td>
                                    <td>Serie Item</td>
                                    <td>Analisa Kerusakan</td>
                                    <td>Nama User</td>
                                    <td>Jabatan</td>
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
@include('admin.inventaris.kerusakan.form.form-add')
@include('admin.inventaris.kerusakan.form.form-edit')
@include('admin.inventaris.kerusakan.form.form-selesai')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dtk = $('#dtkerusakan').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order":[[1, 'desc']],
                "ajax": "{{route('kerusakan.all')}}",
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
                    {data:'kategori', name:"kategori"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'analisa_kerusakan', name:"analisa_kerusakan"},
                    {data:'nama', name:"nama"},
                    {data:'jabatan', name:"jabatan"},
                    {data:null, render:function(a,b,c,d){
                        if(c.status == '0'){
                            return '<span class="badge bg-warning" style="color:black">Proses</span>'
                        }else{
                            return '<span class="badge bg-success" style="color:black">Selesai</span>'
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        var url = "{{url('/admin/inventaris/kerusakan/pdf/')}}"+"/"+c.id;

                        if(c.status == '0'){
                            return '<a class="btn btn-sm btn-danger" target="_blank" href="'+url+'" >PDF</a><button class="btn btn-sm btn-warning" style="margin-left:5px" id="btn-edit-kerusakan">Edit</button><button class="btn btn-sm btn-success" style="margin-left:5px" id="btn-selesai">Selesai</button>';
                        }else{
                            return '<a class="btn btn-sm btn-danger" target="_blank" href="'+url+'" >PDF</a><button class="btn btn-sm btn-warning" style="margin-left:5px" id="btn-edit-kerusakan">Edit</button>';
                        }
                    }},
                ]
            });  

            $('#nip').select2({
                allowClear: true,
                dropdownParent: $("#modal-tambah-kerusakan"),
                placeholder: 'NIP Karyawan',
                minimumInputLength: 2,
            });

            $('#kode_item').select2({
                allowClear: true,
                dropdownParent: $("#modal-tambah-kerusakan"),
            });

            $('#kode_item-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-kerusakan"),
            });

            $('#nip-edit').select2({
                allowClear: true,
                dropdownParent: $("#modal-edit-kerusakan"),
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

            $('#btn-tambah-kerusakan').click(function () {
               $('#nip').val(" ").change();
               $('#kode_item').empty();
               $('#modal-tambah-kerusakan').modal('show'); 
            });

            $('#btn-simpan-kerusakan').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('kode_item', $('#kode_item').val());
                data.append('tanggal', tgl);
                data.append('nip', $('#nip').val());
                data.append('analisa_kerusakan', $('#analisa_kerusakan').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('kerusakan.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('kerusakan.index')}}";
                            window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#btn-ubah-kerusakan').click(function () {
                var tgl = new Date($('#tanggal-edit').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('id', $('#id-edit').val());
                data.append('kode_item', $('#kode_item-edit').val());
                data.append('tanggal', tgl);
                data.append('nip', $('#nip-edit').val());
                data.append('analisa_kerusakan', $('#analisa_kerusakan-edit').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('kerusakan.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
                            $('#modal-edit-kerusakan').modal('hide');
                            $('#dtkerusakan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            // var url = "{{route('kerusakan.index')}}";
                            // window.location = url;
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtkerusakan tbody').on('click', '#btn-edit-kerusakan', function () {
                var id = dtk.row($(this).parents('tr')).data().id;
                var url = "{{url('/admin/inventaris/kerusakan/edit/')}}"+"/"+id;

                $.ajax({
                    method: "GET",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#modal-edit-kerusakan').modal('show');
                        $('#id-edit').val(response.id);
                        $('#tanggal-edit').val(response.tanggal);
                        $('#kode_item-edit').val(response.kode_item).change();
                        $('#nip-edit').val(response.nip).change();
                        $('#analisa_kerusakan-edit').val(response.analisa_kerusakan);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#dtkerusakan tbody').on('click', '#btn-selesai', function () {
                var kode_item = dtk.row($(this).parents('tr')).data().id;
                $('#kode_item_kerusakan').val(kode_item);
                $('#select_kode_item_sp').val("").change();
                $('#modal-selesai-kerusakan').modal('show');
                var tbody1 = $('#table-item-servis tbody');
                $('#table-item-servis tbody tr').remove()
            });

            $('#btn-selesai-kerusakan').click(function () {

                if($('#select_kode_item_sp').val() == ""){

                    swal.fire({
                    title: "Selesai?",
                    icon: 'question',
                    text: "Anda yakin tidak ingin menambahkan item?",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                    
                    }).then(function (e) {
                        if(e.value == true){
                            var data = new FormData();
                            data.append('_token',"{{ csrf_token() }}");
                            data.append('kerusakan_id', $('#kode_item_kerusakan').val());

                            // post data
                            $.ajax({
                                method: "POST",
                                url: "{{route('itemperbaikan.selesaiperbaikan')}}",
                                processData: false,
                                contentType: false,
                                data: data,
                                success: function(response) {
                                    if(response.status == 200){
                                        $('#modal-selesai-kerusakan').modal('hide');
                                        $('#dtkerusakan').DataTable().ajax.reload();
                                        swal.fire('Berhasil!',response.text, "success");
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
                    
                }else{
                    var myData = [];
                    $('.baris').each(function(){
                        myData.push({
                            kode_item: $(this).find('.value').val(),
                            stok: $(this).find('.value2').val(),
                            jumlah: $(this).find('.value3').val(),
                        });
                    });

                    var data = new FormData();
                    data.append('_token',"{{ csrf_token() }}");
                    data.append('kerusakan_id', $('#kode_item_kerusakan').val());
                    data.append('item_service',  JSON.stringify(myData));
                    
                    // post data
                    $.ajax({
                        method: "POST",
                        url: "{{route('itemperbaikan.selesaiperbaikan')}}",
                        processData: false,
                        contentType: false,
                        data: data,
                        success: function(response) {
                            if(response.status == 200){
                                $('#modal-selesai-kerusakan').modal('hide');
                                $('#dtkerusakan').DataTable().ajax.reload();
                                swal.fire('Berhasil!',response.text, "success");
                            }else{
                                swal.fire('Gagal!',response.text, "error");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                }

                

            });
        });

        $(document).ready(function () {

            $('#btn-tambah-sp').click(function () {

                // var no = 0;
                //             var tbody1 = $('#table-item-servis tbody');
                //             var fieldHTML1 = '<tr><td><input type="text" name="nip_approver[]" class="form-control" readonly value="-"></td>'+
                //                             '<td><input type="text" class="form-control" readonly value="-"></td>'+
                //                             '<td><input type="text" class="form-control" readonly value="-"></td>'+
                //                             '<td><input type="text" class="form-control" readonly value="-"></td>'+
                //                             '<td><input type="text" class="form-control" readonly value="-"></td>'+
                //                             '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>';

                //             $(tbody1).append(fieldHTML1)

                // var nip = $('#approve_id').val();
                // if (nip == '') {
                //     swal.fire('Error!',"Approver tidak boleh kosong!", "error");
                // }else{

                    var text = $('#select_kode_item_sp').val();
                    var kode = text.replace(/\//g, "-");
                    var url = "{{url('/admin/item')}}"+"/"+kode;

                    $.ajax({
                        method: "get",
                        url: url,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var no = 0;
                            var tbody1 = $('#table-item-servis tbody');
                            var fieldHTML1 = '<tr class="baris"><td><input type="text" name="kode_item[]" class="form-control value" readonly value="'+response.kode_item+'"></td>'+
                                            '<td><input type="text" class="form-control " readonly value="'+response.nama_item+'"></td>'+
                                            '<td><input type="text" class="form-control " readonly value="'+response.merk+'"></td>'+
                                            '<td><input type="text" class="form-control value2" readonly name="stok[]" value="'+response.jumlah+'"></td>'+
                                            '<td><input type="number" class="form-control value3"  name="jumlah[]" value="1"></td>'+
                                            '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>';
                            $(tbody1).append(fieldHTML1)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                
                // }
            })


            var tbody = $('#table-item-servis tbody');

            $(tbody).on('click', '.hapus_button', function(e){
                e.preventDefault();
                $(this).parent().parent('tr').remove(); //Remove field html

            });

        });
    </script>
@endsection