<table class="" style="">
    <thead>
        <tr>
            <th>NO</th>
            {{-- <th>USER</th> --}}
            {{-- <th>JABATAN</th> --}}
            <th>NO ASET</th>
            <th>KATEGORI</th>
            <th>SERIE</th>
            <th>MERK</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($group as $key => $val)
            <tr>
                <td colspan="6" style="text-align: left;"><b style=" margin-left:10px;">{{$key}}</b></td>
            </tr>
            @foreach ($val as $key1 => $v )
                <tr>
                    <td>{{$key1+1}}</td>
                    <td>{{$v['kode_item']}}</td>
                    <td>{{$v['kategori']}}</td>
                    <td>{{$v['serie_item']}}</td>
                    <td>{{$v['merk']}}</td>
                    <td>{{$v['deskripsi']}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>