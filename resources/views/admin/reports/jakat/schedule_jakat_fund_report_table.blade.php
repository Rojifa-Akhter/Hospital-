<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table data_table_sup_po table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">Name of the Patient</th>
            <th class="text-left">Religion</th>
            <th class="text-left">Address</th>
            <th class="text-center">Reg No</th>
            <th class="text-center">Type</th>
            <th class="text-center">Date</th>
            <th class="text-right">Bill Amount</th>
            <th class="text-right">Zakat Fund</th>
            {{-- <th class="text-center">Delivery Date</th>
			<th class="text-center">Last Payment Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Actions</th> --}}

        </tr>

    </thead>
    <tbody>
        @php
            $total_sales = $zakat_fund = 0;
        @endphp
        @if (!empty($jakat))

            @foreach ($jakat as $row)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $row->patient_name }}</td>
                    <td class="text-left">{{ $row->religion_txt }}</td>
                    <td class="text-left">{{ $row->present_addr }}</td>
                    <td class="text-center">{{ $row->patient_code }}</td>
                    <td class="text-center">
                        @if ($row->module_code == 'OPD')
                            Outdoor
                        @elseif($row->module_code == 'IPD')
                            Indoor
                        @elseif($row->module_code == 'PHR')
                            Pharmacy
                        @elseif($row->module_code == 'PHR-I')
                            Pharmacy
                        @endif

                    </td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($row->invoice_date)) }}</td>
                    <td class="text-right">{{ number_format($row->sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->zakatfund, 2) }}</td>
                    {{-- <td class="text-center">{{ $data->delivery_date }}</td>
			<td class="text-center">{{ date('d/m/Y', strtotime($data->po_last_paid_date)) }}</td>
			<td class="text-left">{{ $data->po_status }}</td> --}}
                    {{-- <td class="text-left">
				<form method="GET" action="{{ route('inventory.purchase_order_print', $data->purchaseorder_no_pk) }}"
					data-response-action="">
					@csrf
					<button class="btn btn-sm btn-primary text-left" type='submit' target="_blank">PO Pdf
					</button>
				</form>
				<button class="btn btn-sm btn-primary open-modal" data-id="{{$data->purchaseorder_no_pk}}" data-action="{{route('pcrm.po-no',$data->purchaseorder_no_pk)}}" data-modal="common-modal-sm" data-title="Supplier Wise PO Payment Report" data-dismiss="modal" aria-label="Close">Payment
				</button>
			</td> --}}

                </tr>
                @php
                    $total_sales += $row->sales;
                    $zakat_fund += $row->zakatfund;
                    // $total_dis += $row->discount;
                    // $total_net_payable += $row->net_sales;
                    // $total_paid += $row->collection;
                    // $total_due += $row->due;
                    // $total_refund += $row->refund;
                    // $total_net_col += $row->net_collection;
                @endphp
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" scope="col" colspan="7">Total = </th>
            {{-- <th class="text-right" scope="col" colspan="7">Total = </th> --}}

            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_sales, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($zakat_fund, 2, '.', '') }}</th>
            {{-- <th scope="col" class="text-right bg-light-blue">{{ number_format($total_dis, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_payable, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_paid, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_refund, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_col, 2, '.', '') }}</th> --}}
        </tr>
    </tfoot>
</table>


<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data_table_sup_po').DataTable({
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
