@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Detail Data Item</h2>
                    <p>{{Breadcrumbs::render('item-detail')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="form-inline">
                            <input type="hidden" id="id" value="{{$data->id}}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kode Item :</label>
                                        <input type="text" class="form-control" id="kode_item" readonly value="{{$data->kode_item}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tanggal :</label>
                                        <input type="date" class="form-control datepicker" id="tanggal" value="{{$data->tanggal}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    {{-- select2 kategori item --}}
                                    <div class="form-group">
                                        <label for="">Kategori</label>
                                        <select name="" id="select2kategori" class="form-control" >
                                            @foreach ($kategori as $k)
                                                <option value="{{$k->id}}" {{$k->id == $data->kategori_id ? 'selected' : ''}}>{{$k->kategori}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nama Item :</label>
                                        <input type="text" class="form-control" id="nama_item" value="{{$data->nama_item}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Merk :</label>
                                        <input type="text" class="form-control" id="merk_item" value={{$data->merk}}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Serie Item :</label>
                                        <input type="text" class="form-control" id="serie_item" value={{$data->serie_item}}>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    {{-- select2 satuan item --}}
                                    <div class="form-group">
                                        <label for="">Satuan</label>
                                        <select name="" id="select2satuan" class="form-control">
                                            @foreach ($satuan as $s)
                                                <option value="{{$s->id}}">{{$s->satuan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nomor SAP Item :</label>
                                        <input type="text" class="form-control" id="sap_item" value="{{$data->sap_item_number}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kondisi :</label>
                                        <select name="" class="form-control" id="kondisi">
                                            <option value="1" {{$data->status_fisik == '1' ? 'selected' : ''}}>Baik</option>
                                            <option value="2" {{$data->status_fisik == '2' ? 'selected' : ''}}>Rusak</option>
                                            <option value="3" {{$data->status_fisik == '3' ? 'selected' : ''}}>Perbaikan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Deskripsi Spesifikasi :</label>
                                        <textarea name="" id="deskripsi_item" cols="30" rows="3" class="form-control">{{$data->deskripsi}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Keterangan :</label>
                                        <textarea name="" id="keterangan" cols="30" rows="3" class="form-control">{{$data->keterangan}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Status :</label>
                                        <select name="" class="form-control" id="status_item">
                                            <option value="1" {{$data->status_item == '1' ? 'selected' : ''}}>Ready</option>
                                            <option value="2" {{$data->status_item == '2' ? 'selected' : ''}}>N/A</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" style="float: right; padding-right:10px;">
                                <button style="width: 100%;" class="btn btn-primary" id="btn-simpan-item">Simpan</button>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>

            <div class="card" style="">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dtriwayatnetwork" class="table table-stripped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>Lokasi</th>
                                    <th>Created_at</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
            $('.datepicker').pickadate({
                selectMonths: true,
                selectYears: true
            })

            $('#dtriwayatnetwork').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [[ 2, "desc" ]],
                "ajax": "{{route('item.riwayatkode', Request::segment(4))}}",
                "columns": [
                    {data:'ip', name:"ip"},
                    {data:'lokasi_network_device.nama_lokasi', name:"lokasi_network_device.nama_lokasi"},
                    {data:'created_at', name:"created_at"},
                ]
            });

            $('#select2kategori').select2({});
            $('#select2satuan').select2({});
            $('#kondisi').select2({});
            $('#status_item').select2({});

            $('#btn-simpan-item').click(function () {
                var tgl = new Date($('#tanggal').val()).toLocaleDateString("ID").replace(/\//g, "-");

                var data = new FormData();
                data.append('_token',"{{ csrf_token() }}");
                data.append('tanggal', tgl);
                data.append('kode_item', $('#kode_item').val());
                data.append('kategori_id', $('#select2kategori').val());
                data.append('satuan_id', $('#select2satuan').val());
                data.append('nama_item', $('#nama_item').val());
                data.append('merk', $('#merk_item').val());
                data.append('serie_item', $('#serie_item').val());
                data.append('deskripsi', $('#deskripsi_item').val());
                data.append('sap_item_number', $('#sap_item').val());
                data.append('keterangan', $('#keterangan').val());
                data.append('status_fisik', $('#kondisi').val());
                data.append('status_item', $('#status_item').val());
                data.append('id', $('#id').val());

                $.ajax({
                    method: "POST",
                    url: "{{route('item.update')}}",
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(response) {
                        if(response.status == 200){
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

        });
    </script>
@endsection