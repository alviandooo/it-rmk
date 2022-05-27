<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Material Request</title>
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
                LAPORAN MATERIAL REQUEST DEPARTEMEN IT <br>
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
                        <th>TANGGAL</th>
                        <th>NOMOR MR</th>
                        <th>LEVEL</th>
                        <th>STATUS</th>
                        <th>NAMA ITEM</th>
                        <th>QUANTITY REQUEST</th>
                        <th>UOM</th>
                        <th>STATUS ITEM</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datatemp as $key => $dp )
                            <tr>
                                <td {{$dp->item_permintaan->count() == '1' ? '' : 'rowspan='.$dp->item_permintaan->count()}} >{{$key+1}}</td>
                                <td {{$dp->item_permintaan->count() == '1' ? '' : 'rowspan='.$dp->item_permintaan->count()}} >{{TanggalIndo::tanggal_indo($dp->tanggal)}}</td>
                                <td {{$dp->item_permintaan->count() == '1' ? '' : 'rowspan='.$dp->item_permintaan->count()}} >{{$dp->ro_no}}</td>
                                <td {{$dp->item_permintaan->count() == '1' ? '' : 'rowspan='.$dp->item_permintaan->count()}} >{{$dp->status_urgent}}</td>
                                <td {{$dp->item_permintaan->count() == '1' ? '' : 'rowspan='.$dp->item_permintaan->count()}} >{{$dp->status_permintaan}}</td>
                                <td>{{$dp->item_permintaan[0]->part_name}}</td>
                                <td>{{$dp->item_permintaan[0]->qty_request}}</td>
                                <td>{{$dp->item_permintaan[0]->satuan->satuan}}</td>
                                <td>{{($dp->item_permintaan[0]->status_item_permintaan == '0' ? 'PROCESS' : ($dp->item_permintaan[0]->status_item_permintaan == '1' ? 'COMPLETE' : ($dp->item_permintaan[0]->status_item_permintaan == '2' ? 'PENDING' : 'INCOMPLETE')))}}</td>

                            </tr>
                        @for ($i = 1; $i < ($dp->item_permintaan->count()); $i++)
                            <tr style="">
                                <td>{{$dp->item_permintaan[$i]->part_name}}</td>
                                <td>{{$dp->item_permintaan[$i]->qty_request}}</td>
                                <td>{{$dp->item_permintaan[$i]->satuan->satuan}}</td>
                                <td>{{($dp->item_permintaan[$i]->status_item_permintaan == '0' ? 'PROCESS' : ($dp->item_permintaan[$i]->status_item_permintaan == '1' ? 'COMPLETE' : ($dp->item_permintaan[$i]->status_item_permintaan == '2' ? 'PENDING' : 'INCOMPLETE')))}}</td>
                            </tr>                        
                        @endfor
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>