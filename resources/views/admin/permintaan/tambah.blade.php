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
                    <p>{{Breadcrumbs::render('inventaris-permintaan-create')}}</p>
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
                    <div class="table-responsive">
                        
                        <form id="form-permintaan" action="{{route('permintaan.store')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nomor Request Order : </label>
                                        <input name="no_ro" type="text" class="form-control" readonly value="{{$ro}}">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Nama Perusahaan : </label>
                                        <input name="nama_perusahaan" type="text" class="form-control" value="PT RMK ENERGY TBK">
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tanggal : </label>
                                        <input name="tanggal" type="date" class="form-control datepicker">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Lokasi Kerja : </label>
                                        <input name="lokasi_kerja" type="text" class="form-control" value="PELABUHAN">
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tanggal Di Butuhkan : </label>
                                        <input name="tanggal_butuh" type="date" class="form-control datepicker">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="status_permintaan">Status Permintaan : </label>
                                        <select name="status_urgent" id="" class="form-control">  
                                            <option value="1">Low</option>
                                            <option value="2">Medium</option>
                                            <option value="3">High</option>
                                            <option value="4">Critical</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-1" style="margin-right:20px;">
                                            <a href="javascript:void(0);" class="btn btn-primary " id="btn-tambah">Tambah Item</a> 
                                        </div>
                                        <div class="col-md-1" >
                                            <select name="" id="jenis_barang" class="single-select">
                                                <option value="1">Item Baru</option>
                                                <option value="2">Item Stok</option>
                                            </select>
                                        </div>
                                    </div>
                                    <table class="table-bordered table mt-2" style="border-color: black" id="table-permintaan-aset" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:10px;">No</th>
                                                <th>SAP Item Number</th>
                                                <th>Part Name</th>
                                                <th>Part Number</th>
                                                <th>Component</th>
                                                <th>Qty Request</th>
                                                {{-- <th>Stock on Hand</th> --}}
                                                <th>Qty Req to MR</th>
                                                <th>UOM</th>
                                                <th>Remarks</th>
                                                <th style="width: 15px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <span style="margin-bottom:5px; font-size:9pt; color:red">*Tambah approver harus berdasarkan urutan : Diminta, Disetujui, Diketahui (3 Approver)</span>
                                        <div class="col-md-3">
                                            <select name="" class="single-select" style="float:left" id="approve_id">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($datakaryawan as $dk)
                                                    <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}}</option>        
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="javascript:void(0);" style="" class="btn btn-primary" id="btn-tambah-approve">Tambah Approver</a>
                                        </div>
                                    </div>
                                    <table class="table-bordered table mt-2" style="border-color: black" id="table-permintaan-approve" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:10px;">No</th>
                                                <th>NIP</th>
                                                <th>NAMA</th>
                                                <th>JABATAN</th>
                                                <th>DEPARTEMEN</th>
                                                <th style="width: 15px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                                            
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <button style="float: right" id="btn-simpan-permintaan" type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                 </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var no = 0;
            var tambahButton = $('#btn-tambah');
            var tbody = $('#table-permintaan-aset tbody');
            
            var fieldHTML3 = '<tr><td class="no"></td><td><select class="single-select1" name="sap_item_number[]">@foreach ( $item as $i) <option value="{{$i->sap_item_number}}">{{$i->sap_item_number}} - {{$i->nama_item}} - {{$i->merk}} - {{$i->serie_item}}</option> @endforeach</select></td><td><textarea name="partname[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="partnumber[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="component[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="qty_request[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="qty_req_to_mr[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><select name="uom[]" id="" class="form-control form-control-sm" style="width: 100%;">@foreach ($satuan as $s)<option value="{{$s->id}}">{{$s->satuan}}</option> @endforeach</select></td>'+
                            '<td><textarea name="remark[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>'

            var fieldHTML2 = '<tr><td class="no"></td><td><textarea name="sap_item_number[]" id="" class="form-control form-control-sm" cols="2" rows="2">-</textarea></td><td><textarea name="partname[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="partnumber[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="component[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="qty_request[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><textarea name="qty_req_to_mr[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td><select name="uom[]" id="" class="form-control form-control-sm" style="width: 100%;">@foreach ($satuan as $s)<option value="{{$s->id}}">{{$s->satuan}}</option> @endforeach</select></td>'+
                            '<td><textarea name="remark[]" id="" class="form-control form-control-sm" cols="2" rows="2"></textarea></td>'+
                            '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>'
                            
            $(tambahButton).click(function () {
                no = no+1;
                if ($('#jenis_barang').val() == '1') {
                    $(tbody).append(fieldHTML2)
                }else{
                    $(tbody).append(fieldHTML3)

                    $('.single-select1').select2({
                        theme: 'bootstrap4',
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                        placeholder: $(this).data('placeholder'),
                        allowClear: Boolean($(this).data('allow-clear')),
                    });
                }
               $('.no').attr('class','no'+no);
               $('.no'+no).text(no);
            });

            $(tbody).on('click', '.hapus_button', function(e){
                e.preventDefault();
                $(this).parent().parent('tr').remove(); //Remove field html
                no = no-1;

            });

        });

        $(document).ready(function () {

            $('#btn-simpan-permintaan').click(function () {
                $('#form-permintaan').submit();
                Swal.fire({
                    title: 'Mohon Tunggu!',
                    html: 'Data sedang disimpan...',
                    // timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })
            })

            $('#btn-tambah-approve').click(function () {
                var nip = $('#approve_id').val();
                if (nip == '') {
                    swal.fire('Error!',"Approver tidak boleh kosong!", "error");
                }else{

                    var host = location.hostname;
                    var protocol = location.protocol;
                    var port = location.port;

                    var url_new = protocol+"//"+host+":"+port;

                    var url = url_new+'/hr-rmk2/public/api/karyawan/'+nip;

                    $.ajax({
                        method: "get",
                        url: url,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var no = 0;
                            var tbody1 = $('#table-permintaan-approve tbody');
                            var fieldHTML1 = '<tr><td class="no">#</td><td><input type="text" name="nip_approver[]" class="form-control" readonly value="'+response[0].nip+'"></td>'+
                                            '<td><input type="text" class="form-control" readonly value="'+response[0].nama+'"></td>'+
                                            '<td><input type="text" class="form-control" readonly value="'+response[0].jabatan.jabatan+'"></td>'+
                                            '<td><input type="text" class="form-control" readonly value="'+response[0].departemen.departemen+'"></td>'+
                                            '<td style="text-align: center"><button class="btn btn-sm btn-danger hapus_button" id="">-</button></td></tr>';

                            $(tbody1).append(fieldHTML1)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                
                        }
                    });
                
                }
            })

            
            var tbody = $('#table-permintaan-approve tbody');

            $(tbody).on('click', '.hapus_button', function(e){
                e.preventDefault();
                $(this).parent().parent('tr').remove(); //Remove field html

            });

        });
    </script>
@endsection

@section('script')
<script>
    
</script>
@endsection