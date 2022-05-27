<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pengguna Aset Departemen IT</title>
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
                LAPORAN PENGGUNA ASET DEPARTEMEN IT <br>
                PT RMK ENERGY TBK <br>
            </b></h4>
        </div>
        <hr style="border: 2px; color:#212529; border-color:black; margin-top:-3px;">
        <div style="margin-top: 10px;">
            <table class="table-item" style="width:100%">
                <thead>
                    <tr>
                        <th>NO</th>
                        {{-- <th>USER</th> --}}
                        {{-- <th>JABATAN</th> --}}
                        <th>NO ASET</th>
                        <th>KATEGORI</th>
                        <th>MERK</th>
                        <th>SERIE</th>
                        <th>DESKRIPSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group as $key => $val)
                        <tr>
                            <td colspan="6" style="text-align: left;"><b style=" margin-left:10px;">{{$key}}</b></td>
                        </tr>
                        @foreach ($val as $key1 => $v )
                            <tr>
                                <td>{{$key1+1}}</td>
                                <td>{{$v['kode_item']}}</td>
                                <td>{{$v['kategori']}}</td>
                                <td>{{$v['merk']}}</td>
                                <td>{{$v['serie_item']}}</td>
                                <td>{{$v['deskripsi']}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            <br>
            <table>
                <tr>
                    <td>Total User</td>
                    <td>:</td>
                    <td>{{count($group)}}</td>
                    <td>Users</td>
                </tr>
                <tr>
                    <td>Total Device</td>
                    <td>:</td>
                    <td>{{$totalitem}}</td>
                    <td>Devices</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>