<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Test Name</th>
            <th class="text-center">Collected</th>
            <th class="text-center">Received</th>
            <th class="text-center">Verified</th>
            <th class="text-center">Finalized</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data) && count($data) > 0)
            <div style="display: none">
                {{ $collect_quantity_final = 0 }}
                {{ $received_qty_final = 0 }}
                {{ $verified_qty_final = 0 }}
                {{ $finalized_qty_final = 0 }}
            </div>
            @foreach ($data as $key => $dt)
                <div style="display: none">
                    {{ $collect_quantity_total = 0 }}
                    {{ $received_qty_total = 0 }}
                    {{ $verified_qty_total = 0 }}
                    {{ $finalized_qty_total = 0 }}
                </div>
                <tr>
                    <td colspan="6" class="text-left bg-light-blue">
                        <strong>
                            {{ $key }}

                        </strong>
                    </td>
                </tr>
                @foreach ($dt as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-center">
                            {{ !empty($value->collect_quantity) ? $value->collect_quantity : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($value->received_qty) ? $value->received_qty : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($value->verified_qty) ? $value->verified_qty : 'N/A' }}</td>
                        <td class="text-center">{{ !empty($value->finalized_qty) ? $value->finalized_qty : 'N/A' }}
                        </td>

                        <div style="display: none">
                            {{ $collect_quantity_total += !empty($value->collect_quantity) ? $value->collect_quantity : 0 }}
                        </div>
                        <div style="display: none">
                            {{ $received_qty_total += !empty($value->received_qty) ? $value->received_qty : 0 }}</div>
                        <div style="display: none">
                            {{ $verified_qty_total += !empty($value->verified_qty) ? $value->verified_qty : 0 }}</div>
                        <div style="display: none">
                            {{ $finalized_qty_total += !empty($value->finalized_qty) ? $value->finalized_qty : 0 }}
                        </div>
                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="2">Sub Total =</th>
                    <th class="text-center bg-light-blue">{{ $collect_quantity_total }}</th>
                    <th class="text-center bg-light-blue">{{ $received_qty_total }}</th>
                    <th class="text-center bg-light-blue">{{ $verified_qty_total }}</th>
                    <th class="text-center bg-light-blue">{{ $finalized_qty_total }}</th>
                </tr>

                <div style="display: none">{{ $collect_quantity_final += $collect_quantity_total }}</div>
                <div style="display: none">{{ $received_qty_final += $received_qty_total }}</div>
                <div style="display: none">{{ $verified_qty_final += $verified_qty_total }}</div>
                <div style="display: none">{{ $finalized_qty_final += $finalized_qty_total }}</div>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        @if (!empty($data) && count($data) > 0)
            <tr>
                <th class="text-right" colspan="2">Total =</th>
                <th class="text-center bg-light-blue">{{ $collect_quantity_final }}</th>
                <th class="text-center bg-light-blue">{{ $received_qty_final }}</th>
                <th class="text-center bg-light-blue">{{ $verified_qty_final }}</th>
                <th class="text-center bg-light-blue">{{ $finalized_qty_final }}</th>
            </tr>
        @endif
    </tfoot>
</table>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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
