<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Form Permintaan</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.css')}}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
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

    </style>
</head>
<body>

    <div class="container">
        <div class="" style="text-align: center; border: 1px solid black" >
            <table class="table-data" style="width:100%;">
                <tr class="noborder st" >
                    <td class="noborder st" colspan="6" style="border:1px solid black;"><span style="text-align: left;"><img src="{{ public_path("assets/images/LOGO-RMKE.jpg") }}" alt="" style=" margin-top:7px; margin-left:3px"  width="40px;"></span> <span style=" tex-weight:bold;"><b style="margin-left:36%; margin-bottom:10%; font-size:12pt">REQUEST ORDER</b></span> </td>
                </tr>
                <tr class="noborder st" >
                    <td class="noborder st" style="padding-left: 15px; padding-bottom: 3px; width: 150px; padding-top:10px;">Nama Perusahaan</td><td class="noborder st" style="width: 20px; padding-top:10px;">:</td><td class="noborder st" style="text-align:left; padding-top:10px;">{{$data->nama_perusahaan}}</td><td class="noborder st" style="width: 100px; padding-top:10px;">Tanggal</td><td class="noborder st" style="padding-top:10px;">:</td><td class="noborder st" style="padding-top:10px;">{{strtoupper(TanggalIndo::tanggal_indo($data->tanggal))}}</td>
                </tr>
                <tr class="noborder st">
                    <td class="noborder st" style="padding-left: 15px; padding-bottom: 3px; ">Tanggal Di Butuhkan </td><td class="noborder st" style="width: 20px;">:</td><td class="noborder st">{{strtoupper(TanggalIndo::tanggal_indo($data->tanggal_butuh))}}</td><td class="noborder st">RO. No</td><td class="noborder st" style="width: 20px;">:</td><td class="noborder st">{{$data->ro_no}}</td>
                </tr>
                <tr class="noborder st">
                    <td class="noborder st" style="padding-left: 15px; padding-bottom: 3px; ">Lokasi Kerja</td><td class="noborder st" style="width: 20px;">:</td><td class="noborder st">{{$data->lokasi_kerja}}</td><td class="noborder st">Status</td><td class="noborder">:</td><td class="noborder">@if($data->status_urgent == "1") LOW @elseif ($data->status_urgent == "2") MEDIUM @elseif ($data->status_urgent == "3") HIGH @else CRITICAL @endif</td>
                </tr>

            </table>
            <table class="table" style="font-size:8pt;  padding:10px; width:100%">
                <tr>
                    <td  style="border:1px solid black; text-align:center;"><b>No</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>Part Name</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>Part Number</b></td>
                    <td  style="border:1px solid black; text-align:center; width:3%"><b>Item Number SAP</b></td>
                    {{-- <td  style="border:1px solid black"><b>Component</b></td> --}}
                    <td  style="border:1px solid black; text-align:center;"><b>QTY Request</b></td>
                    {{-- <td  style="border:1px solid black">Stock On Hand</b></td> --}}
                    <td  style="border:1px solid black; text-align:center; "><b>QTY Request to MR</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>UOM</b></td>
                    <td  style="border:1px solid black; text-align:center;"><b>Remarks</b></td>
                </tr>
                @foreach ($item_permintaan as $key => $d)
                    <tr>
                        <td  style="border:1px solid black; width:2%; text-align:center;">{{$key+1}}</td>
                        <td  style="border:1px solid black; width:5%; padding:5px;">{{strtoupper($d->part_name)}}</td>
                        <td  style="border:1px solid black; width:5%; padding:5px;">{{strtoupper($d->part_number)}}</td>
                        <td  style="border:1px solid black; width:6%;text-align:center;">{{$d->sap_item_number}}</td>
                        {{-- <td  style="border:1px solid black; width:4%;">{{$d->component}}</td> --}}
                        <td  style="border:1px solid black; width:3%;text-align:center;">{{$d->qty_request}}</td>
                        <td  style="border:1px solid black; width:3%;text-align:center;">{{$d->qty_request_mr}}</td>
                        <td  style="border:1px solid black; width:3%;text-align:center;">{{$d->satuan->satuan}}</td>
                        <td  style="border:1px solid black; width:6%; word-wrap: break-word; text-align:left; padding:5px">{{strtoupper($d->remarks)}}</td>
                    </tr>
                @endforeach
            </table>
            <table style="width: 100%;" class="noborder">
                <tr class="noborder">
                    <td class="noborder" style="padding-left: 15px; padding-top:20px;">
                        <p style="font-size:10pt">Diminta Oleh,</p>
                            @if ($data->approval[0]['status_approve'] == '1')
                                <img style="width: 85px; margin-left:0px;margin-top:5px" src="data:image/png;base64, {!! $approve[0]['qrcode'] !!}">
                            @else
                                <br>
                                <br>
                                <br>
                            @endif
                        <p style="margin-top:-10px; font-size:10pt"><b>{{ucwords(strtolower($approve[0]['nama']))}}</b><br>
                        {{ucwords(strtolower($approve[0]['jabatan']))}}</p>
                    </td>
                    <td class="noborder" style="padding-top:20px; padding-left:80px">
                        <p style="font-size:10pt">Disetujui Oleh,</p>
                        @if ($data->approval[1]['status_approve'] == '1')
                            <img style="width: 85px; margin-left:0px;margin-top:5px" src="data:image/png;base64, {!! $approve[1]['qrcode'] !!}">
                        @else
                        <br>
                        <br>
                        <br>
                        <br>
                        @endif
                        <p style="margin-top:-10px; font-size:10pt"><b>{{ucwords(strtolower($approve[1]['nama']))}}</b><br>
                        {{ucwords(strtolower($approve[1]['jabatan']))}}</p>
                    </td>
                    <td class="noborder" style="padding-top:20px;">
                        <p style="font-size:10pt">Diketahui Oleh,</p>
                        <br>
                        <br>
                        <br>
                        <p style="font-size:10pt"><b>{{ucwords(strtolower($approve[2]['nama']))}}</b><br>
                        {{ucwords(strtolower($approve[2]['jabatan']))}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>
