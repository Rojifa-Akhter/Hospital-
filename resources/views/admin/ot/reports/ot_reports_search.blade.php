<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Date</th>
            <th class="text-center">Department Name</th>
            <th class="text-center">Doctor Name</th>
            <th class="text-center">{{ $report_name }} Name</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Sales</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Payment</th>
        </tr>

    </thead>
    <tbody>

        @if (!empty($report_data))

            @php
                $t_quantity = $t_sales = $t_discount = $t_payment = 0;
            @endphp

            @foreach ($report_data as $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ date('d/m/y', strtotime($value->invoice_date)) }}</td>
                    <td class="text-left">{{ $value->item_serviceunit_name }}</td>
                    <td class="text-center">{{ $value->first_ref_doc_name }}</td>
                    <td class="text-center">{{ $value->item_name }}</td>
                    <td class="text-center">{{ $value->day_sum_item_qty }}</td>
                    <td class="text-right">{{ number_format($value->day_sum_invoicedtl_amt_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($value->day_sum_invoicedtl_amt_dis, 2) }}</td>
                    <td class="text-right">{{ number_format($value->day_sum_invoicedtl_amt_payment, 2) }}</td>
                </tr>

                @php

                    $t_quantity += $value->day_sum_item_qty;
                    $t_sales += $value->day_sum_invoicedtl_amt_sales;
                    $t_discount += $value->day_sum_invoicedtl_amt_dis;
                    $t_payment += $value->day_sum_invoicedtl_amt_payment;
                @endphp
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"> <strong>Total = </strong> </td>
            <td class="text-center"> <strong>{{ $t_quantity }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($t_sales,2) }} </strong>
            </td>
            <td class="text-right"> <strong>{{ number_format($t_discount,2) }} </strong>
            </td>
            <td class="text-right"> <strong>{{ number_format($t_payment,2) }} </strong> </td>
        </tr>
    </tfoot>
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
