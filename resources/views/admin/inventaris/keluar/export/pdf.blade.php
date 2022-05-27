<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Berita Acara Penyerahan Aset</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap3/css/bootstrap.css')}}">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .page-break {
            page-break-after: always;
        }
        .nav {
            list-style-type: none;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .nav li {
            display: inline-block;
            font-size: 15px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .table-item  tr td{
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center">
            <h3><b>BERITA ACARA SERAH TERIMA</b></h3>
            <h4 style="margin-top:-10px;"><b>PT RMK ENERGY TBK</b></h4>
            {{-- <ul class="nav">
                <li>
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineCheckbox1">PUSAT</label>
                </li>
                <li>
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                    <label class="form-check-label" for="inlineCheckbox2">SITE</label>
                </li>
            </ul> --}}
        </div>
        <hr style="border: 2px; color:#212529; border-color:black">

        <div class="row" style="text-align: center">
            Nomor Dokumen : {{$data->no_dokumen}}
        </div>

        <div class="row" style="margin-left:20px;margin-right:20px;">
            <p>Pada
                @php
                    echo $tanggal;
                @endphp 
                telah dilakukan serah terima dari :</p>
            <table style="width: 60%;" >
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{$datakaryawan->nama}}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{$datakaryawan->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{$datakaryawan->jabatan->jabatan}}</td>
                </tr>
                <tr >
                    <td style="padding-top: 15px;padding-bottom: 15px;">Kepada :</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{$datapenerima->nama}}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{$datapenerima->nip}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{$datapenerima->jabatan->jabatan}}</td>
                </tr>
            </table>
        </div>

        <div  style="margin-left:20px;margin-right:20px;margin-top:20px;">
            <p>Adapun hal-hal yang diserahterimakan adalah berupa Inventaris IT, sebagai berikut :</p>
            <table class="table-item" style=" width:100%; font-size:10pt; border-collapse:collapse">
                <tr>
                    <td><b>No</b></td>
                    <td><b>Inventaris</b></td>
                    <td><b>Kategori</b></td>
                    <td><b>Merk</b></td>
                    <td><b>Serie</b></td>
                    <td><b>Spesifikasi</b></td>
                </tr>
                    <tr>
                        <td>1</td>
                        <td>{{$data->kode_item}}</td>
                        <td>{{$data->item->kategori->kategori}}</td>
                        <td>{{$data->item->merk}}</td>
                        <td>{{$data->item->serie_item}}</td>
                        <td>{{$data->item->deskripsi}}</td>
                    </tr>
            </table>
            <p style="line-height: 1.4;">Demikian serah terima ini dilakukan dengan sebenar-benarnya. <br>
            Untuk selanjutnya semua hal yang diserahterimakan tersebut diatas menjadi TANGGUNG JAWAB yang menerima 
            dan pengembalian inventory dilakukan setelah mengundurkan diri / sudah tidak aktif bekerja di PT RMK ENERGY TBK.</p>
        </div>
        <br>
        {{-- page break --}}
        {{-- <div class="page-break"></div> --}}
        <div class="row" style="margin-top: 0px;">
            {{-- <ul class="nav">
                <li style="">
                    <div class="col-md-4" style="text-align: center; margin-left:0px; ">
                        <p>Diserahkan Oleh</p>
                        <img style="width: 80px; margin-top:0px;margin-bottom:10px;" src="data:image/png;base64, {!! $qrcode !!}">
                        <p style="margin-top:-10px;">{{$datakaryawan->nama}}</p>
                        <p style="margin-top: -12px">{{$datakaryawan->jabatan->jabatan}}</p>
                    </div>
                </li>
                <li style="">
                    <div class="col-md-4" style="text-align: center; ">
                        <p style="margin-top:-5px">Mengetahui <br> <b style="color: grey">Penyerahan</b></p>
                        <br><br><br><br>
                        <p>Atasan Langsung</p>
                    </div>
                </li>
                <li style="">
                    <div class="col-md-4" style="text-align: center; ">
                        <p style="padding-bottom: 12px;">Penerima</p>
                        <br><br><br>
                        <p>{{$datapenerima->nama}}</p>
                        <p style="margin-top: -12px;word-wrap: break-word">{{$datapenerima->jabatan->jabatan}}</p>
                    </div>
                </li>
            </ul> --}}

            <table style="border: 0px; border-collapse: collapse; width: 100%; text-align:center">
                <tr>
                    <td>
                        <p>Diserahkan Oleh</p>
                        <img style="width: 80px; margin-top:0px;margin-bottom:10px;" src="data:image/png;base64, {!! $qrcode !!}">
                        <p style="margin-top:-10px;">{{$datakaryawan->nama}}</p>
                        <p style="margin-top: -12px">{{$datakaryawan->jabatan->jabatan}}</p>
                    </td>
                    <td>
                        <p style="margin-top:-5px">Mengetahui <br> <b style="color: grey">Penyerahan</b></p>
                        <br><br><br><br>
                        <p>Atasan Langsung</p>
                    </td>
                    <td>
                        <p style="padding-bottom: 12px;">Penerima</p>
                        <br><br><br>
                        <p>{{$datapenerima->nama}}</p>
                        <p style="margin-top: -12px;word-wrap: break-word">{{$datapenerima->jabatan->jabatan}}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row">
            <p><b>Note :</b><br>
                Apabila rincian yang diserahterimakan terlalu banyak, maka harus dilampirkan.
            </p>
        </div>
    </div>
    
</body>
</html>
