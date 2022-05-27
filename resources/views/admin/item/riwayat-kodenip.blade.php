@extends('layouts.masterbaru')
@section('css')

@endsection

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Riwayat Item</h2>
                    <p>{{Breadcrumbs::render('kategori-laptop')}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <button class="btn btn-sm btn-primary" style="margin-bottom: 15px" id="btn-tambah-item">Tambah</button> --}}
                        <table id="dtriwayatnip" class="table table-stripped table-hover" style="background-color: #fff; border-radius:5px; width:100%">
                            <thead>
                                <tr>
                                    <td>Nomor Aset</td>
                                    <td>Tanggal</td>
                                    <td>Jenis</td>
                                    <td>NIP</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                        <tr>
                                            <td>
                                                {{$value['kode_item']}}
                                            </td>
                                            <td>
                                                {{TanggalIndo::tanggal_indo($value['tanggal'])}}
                                            </td>
                                            <td>
                                                {{strtoupper($value['jenis'])}}
                                            </td>
                                            <td>
                                                <a href="#" style="color: black" id="" class="btn-nip">{{$value['nip']}}</a>
                                            </td>
                                        </tr>
                                @endforeach                                
                            </tbody>
                        </table>

                    </div>
                 </div>
            </div>
        </div>

    </div>
</div>
@include('admin.item.form.form-nip')
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            var dti = $('#dtriwayatnip').DataTable({
                "order":[[1, 'asc']],
            });  

            $('#dtriwayatnip tbody').on('click','.btn-nip', function () {
                var nip = this.text; 
                var url = "http://localhost/hr-rmk2/public/api/karyawan"+"/"+nip
                $.ajax({
                    method: "get",
                    url: url,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        $('#modal-nip').modal('show');
                        $('#nama').val(response[0].nama);
                        $('#jabatan').val(response[0].jabatan.jabatan);
                        $('#departemen').val(response[0].departemen.departemen);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                            
                    }
                });
            });

        });
    </script>
@endsection