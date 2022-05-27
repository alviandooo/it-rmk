<table>
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>Nomor Aset</b></th>
            <th><b>Nama</b></th>
            <th><b>Serie</b></th>
            <th><b>Merk</b></th>
            <th><b>Kondisi</b></th>
            <th><b>Status</b></th>
            <th><b>Jumlah</b></th>
        </tr>
    </thead>
    <tbody>
    @if ($d['total'] != '0')
        @php
            $no = 1;
        @endphp
        @foreach ($d['dataperkategori'] as $key => $data)
            <tr>
                <td colspan="7"><b>{{$key}} - {{$d['totalkategori'][$key]}} Items</b></td>
            </tr>
            @foreach ($data as $key => $dt)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$dt->kode_item}}</td>
                    <td>{{$dt->item->nama_item}}</td>
                    <td>{{$dt->item->serie_item}}</td>
                    <td>{{$dt->item->merk}}</td>
                    <td>{{($dt->item->status_fisik == '1' ? 'BAIK' : 'RUSAK' )}}</td>
                    <td>{{($dt->item->status_item == '1' ? 'READY' : 'DIGUNAKAN')}}</td>
                    <td>{{$dt->jumlah}}</td>
                    </tr>
            @endforeach
        @endforeach
    @else
        <tr>
            <td colspan="7"><b>DATA TIDAK DITEMUKAN!</b></td>
        </tr>
    @endif
    </tbody>
</table>