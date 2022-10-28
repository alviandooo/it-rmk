<table class="table" style="font-size:7pt;  padding:10px; width:100%">
    <tr>
        <td colspan="8" style="text-align: center"><b>DATA NETWORK DEVICE AREA {{$data['area']->nama_area_lokasi}}</b></td>
    </tr>
    <tr>
        <td colspan="8"></td>
    </tr>
    <tr>
        <td style="border:1px solid black; text-align:center;"><b>No</b></td>
        <td style="border:1px solid black; text-align:center;"><b>LOKASI</b></td>
        <td style="border:1px solid black; text-align:center;"><b>NO ASET</b></td>
        <td style="border:1px solid black; text-align:center;word-wrap: break-word;"><b>NAMA DEVICE</b></td>
        <td style="border:1px solid black; text-align:center;"><b>IP</b></td>
        <td style="border:1px solid black; text-align:center;"><b>USERNAME</b></td>
        <td style="border:1px solid black; text-align:center;"><b>PASSWORD</b></td>
        <td style="border:1px solid black; text-align:center;"><b>SSID</b></td>
    </tr>
    @foreach ($data['data'] as $key => $d)
        <tr>
            <td style="border:1px solid black; text-align:center;">{{$key + 1}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->lokasi_network_device->nama_lokasi}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->item->kode_item}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->item->nama_item}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->ip}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->username}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->password}}</td>
            <td style="border:1px solid black; text-align:center;">{{$d->ssid}}</td>
        </tr>
    @endforeach
    
</table>