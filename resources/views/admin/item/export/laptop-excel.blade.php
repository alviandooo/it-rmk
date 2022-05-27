<table>
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>Nomor Aset</b></th>
            <th><b>Kategori</b></th>
            <th><b>Nama</b></th>
            <th><b>Serie</b></th>
            <th><b>Merk</b></th>
            <th><b>Kondisi</b></th>
            <th><b>Status</b></th>
            <th><b>User</b></th>
            <th><b>Jabatan</b></th>
        </tr>
    </thead>
    <tbody>
        {{$no = 1}}
        @foreach ($laptop as $key => $l)
            <tr>
                <td colspan="10"><b>{{$key == '1' ? 'ASET READY' : 'ASET DIGUNAKAN'}}</b></td>
            </tr>
            @foreach ($l as $value )
            <tr>
                <td>{{$no}}</td>
                <td>{{$value['kode_item']}}</td>
                <td>{{$value['kategori']}}</td>
                <td>{{$value['nama']}}</td>
                <td>{{$value['serie']}}</td>
                <td>{{$value['merk']}}</td>
                <td>{{$value['kondisi'] == '1' ? 'Baik' : 'Rusak'}}</td>
                <td>{{$value['status'] == '1' ? 'Ready' : 'Digunakan'}}</td>
                <td>{{$value['user']}}</td>
                <td>{{$value['jabatan']}}</td>
            </tr>
            {{$no++}}
            @endforeach
        @endforeach
    </tbody>
</table>