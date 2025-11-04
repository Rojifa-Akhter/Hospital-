<!-- <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}"> -->
<div class="table-responsive border-top border-right">
    <div>
        From Date = {{ $form_date != '' ? date('d/m/Y', strtotime($form_date)) : '' }} , To Date =
        {{ $to_date != '' ? date('d/m/Y', strtotime($to_date)) : '' }}

        <a href="{{ route('item-wise-financial-item-dtl-pdf', [$form_date, $to_date, $item_no_fk]) }}" target="_blank" class="btn btn-md btn-primary mt-1 print mb-2"
            style="float: right;">Export PDF</a>
    </div>
    <table class="table table-bordered table-hover mb-0 data-table">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Invoice Date</th>
                <th class="text-center" scope="col">Invoice </th>
                <th class="text-left" scope="col">Item Name</th>
                <th class="text-center" scope="col"> Item Rate</th>
                <th class="text-center" scope="col"> Qty</th>
                <th class="text-right" scope="col">Dis.</th>
                <th class="text-right" scope="col">S. Charge</th>
                <th class="text-right" scope="col">Net Payable Amt.</th>
                <th class="text-right" scope="col">Receive Amt.</th>
                {{-- <th scope="col" class="text-right">Dues Amt.</th> --}}

            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @if (!empty($data))
                @foreach ($data as $row)
                    @php
                        $service_charge = $row->service_charge != null ? $row->service_charge / $row->current_item_qty : 0;
                        $net_payable = ($row->item_rate - $service_charge) * $row->current_item_qty + $row->service_charge - $row->disc_amount;
                        $due = $net_payable - $row->ledgerdtl_amt_payment;
                    @endphp
                    @if ($row->current_item_qty > 0)
                        <tr>
                            <td class="text-center ">{{ $i++ }}</td>
                            <td class="text-left">
                                {{ $row->invoice_date != '' ? date('d/m/Y', strtotime($row->invoice_date)) : '' }} </td>
                            <td>{{ $row->invoice_no_pk }}</td>
                            <td class="text-left">{{ $row->item_name }} </td>
                            <td class="text-right">{{ number_format($row->item_rate - $service_charge, 2, '.', '') }}
                            </td>
                            <td class="text-center">{{ $row->current_item_qty }} </td>
                            <td class="text-right">{{ number_format($row->disc_amount, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->service_charge, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($net_payable, 2, '.', '') }}</td>
                            <td class="text-right">{{ number_format($row->ledgerdtl_amt_payment, 2, '.', '') }}</td>
                            {{-- <td class="text-right ">{{ number_format($due, 2, '.', '') }}</td> --}}

                        </tr>
                    @endif
                @endforeach
            @endif

        </tbody>

    </table>
</div>

<!-- <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script> -->
<script>
    $('.select2').select2();
    $('.data-table').DataTable({
        "ordering": false,
        // "bPaginate": true,
        "bLengthChange": false,
        "bAutoWidth": false,

    });
</script>
