<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Date</th> --}}
            {{-- <th class="text-center">Department Name</th> --}}
            <th class="text-center">Item Name</th>
            <th class="text-center">Total Qty.</th>
            <th class="text-center">IPD Qty.</th>
            <th class="text-center">OPD Qty.</th>
            <th class="text-center">Emergency Qty.</th>
        </tr>

    </thead>
    <tbody>

        @php
            $sl = 1;
            $total_item = $opd_item = $ipd_item = $emergency_item = $total_due = 0;
            
        @endphp
        @if (!empty($dept_detail_data))
            @foreach ($dept_detail_data as $value)
                <tr>
                    <td class="text-center">{{ $sl++ }} </td>
                    <td class="text-left">{{ $value->item_name }}</td>
                    <td class="text-center">{{ $value->net_item_qty }}</td>
                    <td class="text-center">{{ $value->opd_item_qty }}</td>
                    <td class="text-center">{{ $value->ipd_item_qty }}</td>
                    <td class="text-center">{{ $value->emrg_item_qty }}</td>

                </tr>
                @php
                    $total_item += $value->net_item_qty;
                    $opd_item += $value->opd_item_qty;
                    $ipd_item += $value->ipd_item_qty;
                    $emergency_item += $value->emrg_item_qty;
                @endphp
            @endforeach
        @endif

        <tr>
            <td colspan="2" class="text-right"> <strong>Total = </strong> </td>
            <td class="text-center"> <strong>{{ $total_item }} </strong> </td>
            <td class="text-center"> <strong>{{ $opd_item }} </strong>
            <td class="text-center"> <strong>{{ $ipd_item }} </strong>
            </td>
            <td class="text-center"> <strong>{{ $emergency_item }} </strong>
            </td>
        </tr>
    </tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
