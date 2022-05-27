<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Aset Departemen IT</title>
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

        th{
            padding: 5px;
        }

        td{
            padding: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center">
            <h4><b>
                LAPORAN DATA ASET {{isset($kategori) ? strtoupper($kategori) : ''}} DEPARTEMEN IT <br>
                PT RMK ENERGY TBK <br>
            </b></h4>
        </div>
        <hr style="border: 2px; color:#212529; border-color:black; margin-top:-3px;">
        <div style="margin-top: 10px;">
            <table class="table-item" style="width:100%">
                <thead>
                    <tr>
                        <th><b>No</b></th>
                        <th><b>Nomor Aset</b></th>
                        <th><b>Nama</b></th>
                        <th><b>Serie</b></th>
                        <th><b>Merk</b></th>
                        <th><b>Kondisi</b></th>
                        <th><b>Status</b></th>
                        <th><b>User</b></th>
                        <th><b>Jabatan</b></th>
                    </tr>
                </thead>
                <tbody>
                    {{$no = 1}}
                    @foreach ($datafinal as $key => $l)
                        <tr>
                            <td colspan="10"><b>{{$key == '1' ? 'ASET READY' : 'ASET DIGUNAKAN'}}</b></td>
                        </tr>
                        @foreach ($l as $value )
                        <tr>
                            <td>{{$no}}</td>
                            <td>{{$value['kode_item']}}</td>
                            <td>{{$value['nama']}}</td>
                            <td>{{$value['serie']}}</td>
                            <td>{{$value['merk']}}</td>
                            <td>{{$value['kondisi'] == '1' ? 'Baik' : 'Rusak'}}</td>
                            <td>{{$value['status'] == '1' ? 'Ready' : 'Digunakan'}}</td>
                            <td>{{$value['user']}}</td>
                            <td>{{$value['jabatan']}}</td>
                        </tr>
                        {{$no++}}
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>