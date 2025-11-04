<table
class="table table-bordered table-hover table-striped">
<thead class="global-uhl-table-bg">
    <tr>
        <th>SL</th>
        <th>P.R No</th>
        <th class="text-left">P.R Date</th>
        <th class="text-left">Item No</th>
        <th class="text-left">Name</th>
        <th class="text-left">Indent By Name & Department</th>
        <th>Indent No</th>
        <th>P.R By Name & Department</th>
        <th>Indent Qty</th>
    </tr>

</thead>
<tbody>

    @if (!empty($items))
        @foreach ($items as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-center"> {{ $row->inv_requisition_po_no_pk ? $row->inv_requisition_po_no_pk : '' }}</td>
                <td> {{$row->req_at !="" ? date('d/m/Y',strtotime($row->req_at)) :''}}</td>
                <td>{{ $row->req_item_no_fk ? $row->req_item_no_fk : 0 }}</td>
                <td>{{ $row->item_name ? $row->item_name : '' }}</td>
                <td>    
                    {{ $row->indent_req_by_name ? $row->indent_req_by_name : '' }}
                    {{ $row->indent_from_store ? $row->indent_from_store : ''}}
                </td>
                <td class="text-center">{{ $row->inv_requisition_no_pk ? $row->inv_requisition_no_pk : '' }}</td>
                <td class="text-center">
                    {{ $row->req_by_name ? $row->req_by_name : '' }}
                    {{ $row->from_store ? $row->from_store : '' }}
                </td>
                <td class="text-center">{{ $row->req_quantity ? $row->req_quantity : 0 }}</td>
            </tr>
        @endforeach
    @endif

</tbody>
</table>
