<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Instalasi Network Device</title>
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
            <h4><b>
                LAPORAN INSTALASI NETWORK DEVICE DEPARTEMEN IT <br>
                PT RMK ENERGY TBK <br>
                PERIODE TANGGAL {{TanggalIndo::tanggal_indo($tglawal)}} s/d {{TanggalIndo::tanggal_indo($tglakhir)}}
            </b></h4>
        </div>
        <hr style="border: 2px; color:#212529; border-color:black; margin-top:-3px;">
        <div style="margin-top: 10px;">
            <table class="table-item" style="width:100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Tanggal</th>
                        <th>Nomor Aset</th>
                        <th>Nama Device</th>
                        <th>Nomor Device</th>
                        <th>Model</th>
                        <th>Merk</th>
                        <th>IP</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data->count() != '0')
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $key => $value)
                            <tr>
                                <td colspan="9"><b>{{$key}}</b></td>
                            </tr>
                            @foreach ($value as $dt)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{TanggalIndo::tanggal_indo($dt->tanggal)}}</td>
                                    <td>{{$dt->item->kode_item}}</td>
                                    <td>{{$dt->item->nama_item}}</td>
                                    <td>{{$dt->device_no}}</td>
                                    <td>{{$dt->item->serie_item}}</td>
                                    <td>{{$dt->item->merk}}</td>
                                    <td>{{$dt->ip}}</td>
                                    <td>{{$dt->lokasi_network_device->nama_lokasi}}</td>
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