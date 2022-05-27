<table>
    <thead>
        <tr>
            <th>NO</th>
            <th><b>Tanggal</b></th>
            <th><b>Nomor Aset</b></th>
            <th><b>Nama Device</b></th>
            <th><b>Nomor Device</b></th>
            <th><b>Model</b></th>
            <th><b>Merk</b></th>
            <th><b>IP</b></th>
            <th><b>Lokasi</b></th>
        </tr>
    </thead>
    <tbody>
        @if ($data->count() != '0')
            @php
            $no = 1;
        @endphp
        @foreach ($data as $key => $value)
            <tr>
                <td colspan="9"><b>{{$key}}</b></td>
            </tr>
            @foreach ($value as $key => $dt)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{TanggalIndo::tanggal_indo($dt->tanggal)}}</td>
                    <td>{{$dt->item->kode_item}}</td>
                    <td>{{$dt->item->nama_item}}</td>
                    <td>{{$dt->device_no}}</td>
                    <td>{{$dt->item->serie_item}}</td>
                    <td>{{$dt->item->merk}}</td>
                    <td>{{$dt->ip}}</td>
                    <td>{{$dt->lokasi_network_device->nama_lokasi}}</td>
                </tr>
            @endforeach
        @endforeach
        @endif
    </tbody>
</table>