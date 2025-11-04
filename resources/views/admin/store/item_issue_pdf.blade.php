<h4>Daily Medicine Issue to Pharmacy</h4>
Date of Report: {{ date('d/m/Y') }}
<table  border="1" width="100%">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Indent No</th>
            <th class="text-center">Indent Date</th>
            <th class="text-center">Indent By</th>
            <th class="text-center">Pharmacy Name</th>
            <th class="text-center">PVMS No</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Indent Qty</th>
            <th class="text-center">Issue Qty</th>
            <th class="text-center">Received Qty</th>
        </tr>
    </thead>
    <tbody>

    @if(!empty($issue_work_list))

        @foreach($issue_work_list as $indent_no => $iwls)
            @php $loopOne = $loop; @endphp
            @foreach($iwls as $iwl)

                <tr @if($loopOne->even) style="background-color: floralwhite" @endif>
                    <td class="text-left" @if(!$loop->last) style="border-bottom: none" @endif>
                        @if($loop->iteration == 1)
                            {{ $loopOne->iteration }}
                        @endif
                    </td>

                    <td  class="text-left" @if(!$loop->last) style="border-bottom: none" @endif>
                        @if($loop->iteration == 1)
                            {{ $iwl->requisition_uid?:'N/A' }}
                        @else
                            <span style="visibility: hidden">{{ $iwl->requisition_uid?:'N/A' }}</span>
                        @endif
                    </td>

                    <td class="text-left">{{ !empty($iwl->requisition_date)?date('d/m/Y', strtotime($iwl->requisition_date)):'N/A' }}</td>
                    <td class="text-left">{{ $iwl->req_by_name?:'N/A' }}</td>
                    <td class="text-left">{{ $iwl->from_store_name?:'N/A' }}</td>
                    <td class="text-left">{{ $iwl->pvmsno?:'N/A' }}</td>
                    <td class="text-left">{{ $iwl->item_name?:'N/A' }}</td>
                    <td class="text-center">{{ $iwl->balance_qty ?: 0 }}</td>
                    <td class="text-right">{{ $iwl->req_quantity?:0 }}</td>
                    <td class="text-right">{{ $iwl->issue_quantity?:0 }}</td>

                    <td class="text-right">{{ $iwl->recv_quantity?:0 }}</td>


                </tr>

            @endforeach

        @endforeach
    @endif


    </tbody>
</table>