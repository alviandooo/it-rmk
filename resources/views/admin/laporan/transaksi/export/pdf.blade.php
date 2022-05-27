<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi Asett</title>
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
                LAPORAN TRANSAKSI ASET DEPARTEMEN IT <br>
                PT RMK ENERGY TBK <br>
                PERIODE TANGGAL {{TanggalIndo::tanggal_indo($tglawal)}} s/d {{TanggalIndo::tanggal_indo($tglakhir)}}
            </b></h4>
        </div>
        <hr style="border: 2px; color:#212529; border-color:black; margin-top:-3px;">
        <div style="margin-top: 10px;">
            <table class="table-item" style="width:100%; border:1px solid black;">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th><b>Tanggal</b></th>
                        <th><b>Nomor Aset</b></th>
                        <th><b>Kategori</b></th>
                        <th><b>Aset</b></th>
                        <th><b>Serie</b></th>
                        <th><b>NIK</b></th>
                        <th><b>User</b></th>
                        <th><b>Jabatan</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($final as $key => $d)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{TanggalIndo::tanggal_indo($d['tanggal'])}}</td>
                            <td>{{$d['kode_item']}}</td>
                            <td>{{$d['kategori']}}</td>
                            <td>{{$d['nama_item']}}</td>
                            <td>{{$d['serie_item']}}</td>
                            <td>{{$d['nip']}}</td>
                            <td>{{$d['nama']}}</td>
                            <td>{{$d['jabatan']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>