<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Code</th>
            <th class="text-center">Supplier Name</th>
            <th class="text-center">Total PO</th>
            <th class="text-center">Total Item</th>
            <th class="text-center">Total PO Amount</th>
            <th class="text-center">Total PO Discount</th>
            <th class="text-center">Regular Payment Amount</th>
            <th class="text-center">Advance Payment Amount</th>
            <th class="text-center">Total Deduct</th>
            <th class="text-center">Net Payment</th>
            <th class="text-center">Action</th>
        </tr>

    </thead>
    <tbody>

        @if (!empty($ledger))
        @foreach ($ledger as $data)
        @if($data->supplier_no_fk)
        @php
        $netPayment = $data->regular_payment_amount + $data->advance_payment_amount - $data->total_deduct;
        @endphp

        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $data->supplier_uid }}</td>
            <td class="text-left">{{ $data->supplier_name }}</td>
            <td class="text-left">{{ $data->no_of_po }}</td>
            {{-- <td class="text-center">{{date('d/m/Y',strtotime($data->))}}</td> --}}
            <td class="text-center">{{ $data->no_of_item }}</td>
            <td class="text-left">{{ $data->total_po_amount }}</td>
            <td class="text-center">{{ $data->total_po_discount }}</td>
            <td class="text-center">{{ $data->regular_payment_amount }}</td>
            <td class="text-left">{{ $data->advance_payment_amount }}</td>
            <td class="text-center">{{ $data->total_deduct }}</td>
            <td class="text-center">{{ $netPayment }}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-primary open-modal" data-id="{{$data->supplier_no_fk}}" data-action="{{route('pcrm.supplier-id',$data->supplier_no_fk)}}" data-modal="common-modal-md" data-title="Supplier Wise PO Report">Details
                </button>
            </td>
        </tr>
        @endif
        @endforeach
        @endif
    </tbody>
</table>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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

