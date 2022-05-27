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
                LAPORAN DATA ASET NETWORK DEVICE DEPARTEMEN IT <br>
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
                        <th><b>IP</b></th>
                        <th><b>Lokasi</b></th>
                        {{-- <th><b>Area</b></th> --}}
                    </tr>
                </thead>
                <tbody>
                    {{$no = 0}}
                    @foreach ($datafinal as $key => $a)
                        <tr>
                            <td colspan="8"><b>{{$key == '-' ? 'ASET READY' : 'AREA '.strtoupper($key)}}</b></td>
                        </tr>
                        @foreach ($a as $key1=>$value )
                            <tr>
                                <td>{{$no+1}}</td>
                                <td>{{$value['kode_item']}}</td>
                                <td>{{$value['nama']}}</td>
                                <td>{{$value['serie']}}</td>
                                <td>{{$value['merk']}}</td>
                                <td>{{$value['ip']}}</td>
                                <td>{{$value['lokasi']}}</td>
                                {{-- <td>Area</td> --}}
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