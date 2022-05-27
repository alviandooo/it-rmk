<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Berita Acara Kerusakan Barang</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.css')}}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .page-break {
            page-break-after: always;
        }
        .table-item  tr td{
            border: 1px solid black;
            /* text-align: center; */
            padding-left: 10px;
        }
        .text-left{
            text-align: left;
        }

    </style>
</head>
<body>
    <?php

    function hariIndo ($hariInggris) {
      switch ($hariInggris) {
        case 'Sunday':
          return 'Minggu';
        case 'Monday':
          return 'Senin';
        case 'Tuesday':
          return 'Selasa';
        case 'Wednesday':
          return 'Rabu';
        case 'Thursday':
          return 'Kamis';
        case 'Friday':
          return 'Jumat';
        case 'Saturday':
          return 'Sabtu';
        default:
          return 'hari tidak valid';
      }
    }

    function bulanIndo($intblninggris)
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $bulan[$intblninggris-1];
    }

    function rentangTanggal($date1, $date2)
    {
        // $date1 = '2016-06-01';
        // $date2 = '2020-08-08';
        $diff = abs(strtotime($date2)-strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        return $years.' Tahun'.' '.$months.' Bulan'.' '.$days.' Hari';
    }
    ?>

    <div class="container">
        <div class="" style="text-align: center">
            <table class="" style="border: 1px solid black; width:100%;  border-collapse:collapse">
                <tr style="border: 1px solid black; width:100%">
                    <td style="border: 1px solid black; width:15%; text-align: center" rowspan="2">
                        <img src="{{ public_path('assets/images/LOGORMKE.png') }}" alt="" style="width: 50px; margin-top:7px;">
                    </td>
                    <td style="border: 1px solid black;padding-left:10px; text-align:center; font-size:10pt">
                        <b>PT. RMK ENERGY TBK - MUSI 2 PALEMBANG</b>
                    </td>
                    <td style=" width:30%; padding-left: 5px;">
                        DIVISI / BAGIAN :
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px; font-size: 11pt; border:1px solid black; text-align: center">
                        <b>BERITA ACARA KERUSAKAN BARANG</b>
                    </td>
                    <td style="border-bottom:1px solid black;text-align: center">{{$final[0]['departemen']}}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table style="width: 100%;padding:20px;" class="">
                            <tr>
                                <td style="text-align: justify; padding-left:30px;" colspan="4">
                                    Pada hari {{hariIndo(date_format(date_create($final[0]['tanggal']), 'l'))}} tanggal {{date_format(date_create($final[0]['tanggal']), 'd')}} bulan {{bulanIndo(date_format(date_create($final[0]['tanggal']), 'm'))}} {{date_format(date_create($final[0]['tanggal']), 'Y')}}
                                    menerangkan bahwa peralatan / tools tsb dibawah ini :
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width: 28%px;  padding:5px;">
                                    Nomor Aset
                                </td>
                                <td style="width: 20px;">:</td>
                                <td colspan="2">{{$final[0]['kode_item']}}</td>
                            </tr>
                            <tr>
                                <td style="padding:5px;">
                                    Nama Item
                                </td>
                                <td>:</td>
                                <td colspan="2">{{strtoupper($final[0]['nama_item'])}}</td>
                            </tr>
                            <tr>
                                <td style="padding:5px;">
                                    Merk
                                </td>
                                <td>:</td>
                                <td colspan="2">{{strtoupper($final[0]['merk'])}} {{strtoupper($final[0]['serie_item'])}}</td>
                            </tr>
                            <tr>
                                <td style="padding:5px;">
                                    Tgl Terima Terakhir
                                </td>
                                <td>:</td>
                                <td colspan="2">
                                    @if ($final[0]['tanggal_terima'] != '-')
                                        {{date_format(date_create($final[0]['tanggal_terima']), "d/m/Y")}}</td>
                                    @else
                                        -
                                    @endif
                            </tr>
                            <tr>
                                <td style="padding:5px;">
                                    Masa Pemakaian
                                </td>
                                <td>:</td>
                                <td colspan="2">{{rentangTanggal($final[0]['tanggal_terima'], $final[0]['tanggal'])}}</td>
                            </tr>
                            <tr>
                                <td style="padding:5px;">
                                    Analisa Kerusakan
                                </td>
                                <td>:</td>
                                <td colspan="2">{{strtoupper($final[0]['analisa_kerusakan'])}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p style="padding-left: 50px;">
                            Demikian berita acara ini dibuat dengan sebenarnya agar dapat diketahui bersama terima kasih.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p style="padding-left: 20px;">
                            Palembang, {{TanggalIndo::tanggal_indo($final[0]['tanggal'])}}
                            {{-- Palembang, {{date_format(date_create($final[0]['tanggal']), 'd')}} / {{date_format(date_create($final[0]['tanggal']), 'm')}} / {{date_format(date_create($final[0]['tanggal']), 'Y')}} --}}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table style="width: 100%;padding-left:15px;" class="" >
                            <tr>
                                <td style="border-right-color:white;padding-top:10px;padding-right:10px;">
                                    <p>Diajukan Oleh,</p>
                                    <br>
                                    <br>
                                    <p>{{$final[0]['nama']}} <br> {{$final[0]['jabatan']}}</p>
                                </td>
                                <td style="padding-top: 10px;">
                                    <p>Diketahui Oleh,</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p>SPV Departemen</p>
                                </td>
                                <td  style="padding-top: 10px;">
                                    <p>Diperiksa Oleh,</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p>IT Staff</p>
                                </td>
                                <td  style="padding-top: 10px;">
                                    <p>Diketahui Oleh,</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p>SPV Logistic</p>
                                </td>
                            </tr>
    
                            <tr>
                                
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

            <hr style="margin-top: 35px; border: 1px dotted black">

            <table style="width: 100%;padding:20px;margin-top:35px;border:1px solid black" class="">
                <tr>
                    <td style="text-align: justify; padding-left:30px;" colspan="4">
                        Pada hari {{hariIndo(date_format(date_create($final[0]['tanggal']), 'l'))}} tanggal {{date_format(date_create($final[0]['tanggal']), 'd')}} bulan {{bulanIndo(date_format(date_create($final[0]['tanggal']), 'm'))}} {{date_format(date_create($final[0]['tanggal']), 'Y')}}
                        menerangkan bahwa peralatan / tools tsb dibawah ini :
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 28%px;  padding:5px;">
                        Nomor Aset
                    </td>
                    <td style="width: 20px;">:</td>
                    <td colspan="2">{{$final[0]['kode_item']}}</td>
                </tr>
                <tr>
                    <td style="padding:5px;">
                        Nama Item
                    </td>
                    <td>:</td>
                    <td colspan="2">{{strtoupper($final[0]['nama_item'])}}</td>
                </tr>
                <tr>
                    <td style="padding:5px;">
                        Merk
                    </td>
                    <td>:</td>
                    <td colspan="2">{{strtoupper($final[0]['merk'])}} {{strtoupper($final[0]['serie_item'])}}</td>
                </tr>
                <tr>
                    <td style="padding:5px;">
                        Tgl Terima Terakhir
                    </td>
                    <td>:</td>
                    <td colspan="2">
                        @if ($final[0]['tanggal_terima'] != '-')
                            {{date_format(date_create($final[0]['tanggal_terima']), "d/m/Y")}}</td>
                        @else
                            -
                        @endif
                </tr>
                <tr>
                    <td style="padding:5px;">
                        Masa Pemakaian
                    </td>
                    <td>:</td>
                    <td colspan="2">{{rentangTanggal($final[0]['tanggal_terima'], $final[0]['tanggal'])}}</td>
                </tr>
                <tr>
                    <td style="padding:5px;">
                        Analisa Kerusakan
                    </td>
                    <td>:</td>
                    <td colspan="2">{{strtoupper($final[0]['analisa_kerusakan'])}}</td>
                </tr>
            </table>
        </div>
    </div>
    
</body>
</html>
