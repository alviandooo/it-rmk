<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Data Network Device</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.css')}}">

    <style>
        @page{
            margin-top: 25px;
            margin-right: 5px;
            margin-left: 5px;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin:0px;
        }
        /* .page-break {
            page-break-after: always;
        }
        .table-item  tr td{
            border: 1px solid black;
            text-align: center;
        } */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table, th, td {
            border: 1px solid black;
        }

        .noborder{
            border: 0px;
        }

        .st{
            font-size: 10pt;
        }

        td{
            margin: 0px
        }

    </style>
</head>
<body>

    <div class="container">
        <div style="text-align: center">
            <h4>DATA NETWORK DEVICE AREA {{$data["area"]->nama_area_lokasi}}</h4>
        </div>
        <div class="" style="text-align: center;">
            <table class="table" style="font-size:7pt;  padding:10px; width:100%">
                <tr>
                    <td  style="border:1px solid black; text-align:center;"><b>No</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>LOKASI</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>NO ASET</b></td>
                    <td  style="border:1px solid black; text-align:center;word-wrap: break-word;"><b>NAMA DEVICE</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>IP</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>USERNAME</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>PASSWORD</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>SSID</b></td>
                </tr>
                @foreach ($data['data'] as $key => $d)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$d->lokasi_network_device->nama_lokasi}}</td>
                        <td>{{$d->item->kode_item}}</td>
                        <td>{{$d->item->nama_item}}</td>
                        <td>{{$d->ip}}</td>
                        <td>{{$d->username}}</td>
                        <td>{{$d->password}}</td>
                        <td>{{$d->ssid}}</td>
                    </tr>
                @endforeach
                
            </table>
            
        </div>
    </div>
    
</body>
</html>
