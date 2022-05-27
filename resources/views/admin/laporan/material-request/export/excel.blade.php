<table>
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