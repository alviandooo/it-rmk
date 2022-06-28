<table>
    <thead >
        <tr>
            <td style="width:10px;">No</td>
            <th>Part Name</th>
            <th>Part Number</th>
            <th>SAP Item Number</th>
            {{-- <th>Component</th> --}}
            <th>Qty Request</th>
            <th>Qty Req to MR</th>
            <th>UOM</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datatemp as $key => $ip)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{strtoupper($ip->part_name)}}</td>
                <td>{{strtoupper($ip->part_number)}}</td>
                <td>{{$ip->sap_item_number}}</td>
                {{-- <td>{{$ip->component}}</td> --}}
                <td>{{$ip->qty_request}}</td>
                <td>{{$ip->qty_request_mr}}</td>
                <td>{{$ip->satuan->satuan}}</td>
                <td class="text-center">
                    @if ($ip->status_item_permintaan == '0' )
                        PROCESS
                    @elseif($ip->status_item_permintaan == '1' )
                        COMPLETE
                    @elseif($ip->status_item_permintaan == '2' )
                        PENDING
                    @endif
                </td>
                <td>{{strtoupper($ip->remarks)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>