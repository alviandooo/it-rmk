<table>
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
        @foreach ($aset as $key => $a)
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