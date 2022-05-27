<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Stok Aset Departemen IT</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.css')}}">

    <style>
        body {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
        }
        .table-item  tr td, th{
            border: 1px solid black;
            font-size: 9pt;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center">
            @if ($d['jenis_data'] == '1')
                <h4><b>
                    LAPORAN PENERIMAAN STOK ASET DEPARTEMEN IT <br>
                    PT RMK ENERGY TBK <br>
                    PERIODE TANGGAL {{TanggalIndo::tanggal_indo($tglawal)}} s/d {{TanggalIndo::tanggal_indo($tglakhir)}}
                </b></h4>
            @else
                <h4><b>
                    LAPORAN STOK ASET DEPARTEMEN IT <br>
                    PT RMK ENERGY TBK <br>
                </b></h4>
            @endif
        </div>
        <hr style="border: 2px; color:#212529; border-color:black; margin-top:-3px;">
        <div style="margin-top: 10px;">
            <table class="table-item" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Aset</th>
                        <th>Nama</th>
                        <th>Serie</th>
                        <th>Merk</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($d['total'] != '0')
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($d['dataperkategori'] as $key => $data)
                            <tr>
                                <td colspan="7"><b>{{$key}} - {{$d['totalkategori'][$key]}} Items</b></td>
                            </tr>
                            @foreach ($data as $key => $dt)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$dt->kode_item}}</td>
                                    <td>{{$dt->item->nama_item}}</td>
                                    <td>{{$dt->item->serie_item}}</td>
                                    <td>{{$dt->item->merk}}</td>
                                    <td>{{($dt->item->status_fisik == '1' ? 'BAIK' : 'RUSAK' )}}</td>
                                    <td>{{($dt->item->status_item == '1' ? 'READY' : 'DIGUNAKAN')}}</td>
                                    <td>{{$dt->jumlah}}</td>
                                    </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7"><b>DATA TIDAK DITEMUKAN!</b></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>