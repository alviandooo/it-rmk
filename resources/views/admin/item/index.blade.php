@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Item Aset</h2>
                    <p>{{Breadcrumbs::render('item')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="row">
                            <div class="col-md-1">
                                <button class="btn btn-primary" style="margin-bottom: 15px" id="btn-tambah-item">Tambah</button>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="kategori" class="single-select">
                                    <option value="0" selected>SEMUA</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{$k->id}}">{{$k->kategori}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table id="dtitem" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td hidden></td>
                                    <td>Kode Item</td>
                                    <td>Kategori</td>
                                    <td>Nama</td>
                                    <td>Serie</td>
                                    <td>Merk</td>
                                    <td>Status</td>
                                    <td>Kondisi</td>
                                    <td>Created_at</td>
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

@include('admin.item.form.form-add')
@include('admin.item.form.form-edit')
@endsection

@section('script')
    <script>
        $(document).ready(function () {

            var dti = $('#dtitem').DataTable({
                "language": {
                    "processing": '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="" style="margin-left:5px;margin-top:5px;">Loading...</span>'
                },
                "processing": true,
                "serverSide": true,
                "order": [[ 8, "desc" ]],
                "ajax": "{{route('item.getAll')}}",
                "columns": [
                    {data:'id', name:"id", visible:false},
                    {data:'kode_item', name:"kode_item"},
                    {data:'kategori.kategori', name:"kategori.kategori"},
                    {data:'nama_item', name:"nama_item"},
                    {data:'serie_item', name:"serie_item"},
                    {data:'merk', name:"merk"},
                    {data:null, render:function(a,b,c,d){
                        if (c.jumlah == '0') {
                            return '<span style="background-color:#FFC107; padding: 5px; border-radius:5px;">Kosong</span>';
                        }else{
                            if (c.status_item == "1") {
                                return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Ada</span>';
                            }else{
                                return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Digunakan</span>';
                            }
                        }
                    }},
                    {data:null, render:function(a,b,c,d){
                        if(c.kategori_id == '6'){
                            return '-';
                        }else{
                            if (c.status_fisik == "1") {
                                return '<span style="background-color:#15CA20; padding: 5px; border-radius:5px;">Baik</span>';
                            }else if(c.status_fisik == "3"){
                                return '<span style="background-color:#FFC107; padding: 5px; border-radius:5px;">Perbaikan</span>';
                            }else{
                                return '<span style="background-color:#DC3545; padding: 5px; border-radius:5px;">Rusak</span>';
                            }
                        }
                    }},
                    {data:'created_at', name:"created_at"},
                    {data:null, render:function(a,b,c,d){
                        if({{Auth::user()->role}}  == '0'){
                            return '<a href="{{url('/admin/item/edit/')}}'+'/'+c.id+'" class="btn btn-warning btn-sm">Edit</a><a href="{{url('/qrcode/')}}'+'/'+c.id+'" target="_blank" style="margin-left:5px;" class="btn btn-sm btn-success">QRCode</a><a href="#" id="btn-hapus-item" style="margin-left:5px;" class="btn btn-sm btn-danger">Hapus</a>'
                        }else{
                            return '<a href="{{url('/admin/item/edit/')}}'+'/'+c.id+'" class="btn btn-warning btn-sm">Edit</a><a href="{{url('/qrcode/')}}'+'/'+c.id+'" target="_blank" style="margin-left:5px;" class="btn btn-sm btn-success">QRCode</a>'
                        }   
                    }},
                ]
            });  

            $('#kategori').change(function () {
                var val = this.value;
                if (val == 0 ) {
                    dti.ajax.url( "{{route('item.getAll')}}" ).load();
                }else if(val == 1){
                    dti.ajax.url( "{{route('item.datalaptop')}}" ).load();
                }else if(val == 2){
                    dti.ajax.url( "{{route('item.dataprinter')}}" ).load();
                }else if(val == 3){
                    dti.ajax.url( "{{route('item.datapc')}}" ).load();
                }else if(val == 4){
                    dti.ajax.url( "{{route('item.datand')}}" ).load();
                }else if(val == 5){
                    dti.ajax.url( "{{route('item.dataperipheral')}}" ).load();
                }else if(val == 6){
                    dti.ajax.url( "{{route('item.dataconsumable')}}" ).load();
                }

                $('#dtitem').DataTable().ajax.reload();

            })

            $('#btn-tambah-item').click(function () {
                //generate kode item
                // $.ajax({
                //     method: "get",
                //     url: "{{route('item.kode')}}",
                //     processData: false,
                //     contentType: false,
                //     success: function(response) {
                //         $('#modal-tambah-item').modal('show');
                //         $('#kode_item').val(response);
                //     },
                //     error: function(jqXHR, textStatus, errorThrown) {
                        
                //     }
                // });
                $('#modal-tambah-item').modal('show');
                
            });

            $('#dtitem tbody').on('click','#btn-hapus-item',function () {
                var id = dti.row($(this).parents('tr')).data().id;
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
                        console.log(id);
                        $.ajax({
                            method: "POST",
                            url: "{{route('item.destroy')}}",
                            processData: false,
                            contentType: false,
                            data: data,
                            success: function(response) {
                                console.log(response);
                                if(response.status == 200){
                                    $('#dtitem').DataTable().ajax.reload();
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

            $('#btn-simpan-item').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");
                
                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal_item', tgl);
                data.append('kode_item', $('#kode_item').val());
                data.append('kategori_id', $('#select2kategori').val());
                data.append('satuan_id', $('#select2satuan').val());
                data.append('nama_item', $('#nama_item').val());
                data.append('merk', $('#merk_item').val());
                data.append('serie_item', $('#serie_item').val());
                data.append('deskripsi', $('#deskripsi_item').val());
                data.append('sap_item_number', $('#sap_item').val());
                data.append('keterangan', $('#keterangan').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('item.store')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 201){
                            // $('#dtjabatan').DataTable().ajax.reload();
                            swal.fire('Berhasil!',response.text, "success");
                            var url = "{{route('item.index')}}";
                            window.location = url;

                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

            $('#select2kategori').select2({
                dropdownParent: $('#modal-tambah-item'),
            });

            $('#select2satuan').select2({
                dropdownParent: $('#modal-tambah-item'),
            });

        });
    </script>
@endsection