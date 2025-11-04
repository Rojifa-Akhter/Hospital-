<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            {{-- <th class="text-center">Date</th> --}}
            <th class="text-center">Department Name</th>
            <th class="text-center">Total Patients</th>
            <th class="text-center">Sales</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Due</th>
            <th class="text-center">Payment</th>
        </tr>

    </thead>
    <tbody>

        @php
            $sl = 1;
            $total_sales = $total_payment = $total_discount = $total_patient = $total_due = 0;
            
        @endphp
        @if (!empty($dept_detail_data))
            @foreach ($dept_detail_data as $value)
            <?php 

            $due = $value->sales -($value->discount + $value->payment);


?>
                <tr>
                    <td class="text-center">{{ $sl++ }} </td>
                    <td class="text-left">{{ $value->department_name }}</td>
                    <td class="text-center">{{ $value->no_of_invoice }}</td>
                    <td class="text-right">{{ number_format($value->sales) }}</td>
                    <td class="text-right">{{ number_format($value->discount) }}</td>
                    <td class="text-right">{{ number_format($due) }}</td>
                    <td class="text-right">{{ number_format($value->payment) }}</td>
                   
                </tr>
                @php
                    $total_sales += $value->sales;
                    $total_payment += $value->payment;
                    $total_discount += $value->discount;
                    $total_patient += $value->no_of_invoice;
                    $total_due += $due;
                @endphp
            @endforeach
        @endif

        <tr>
            <td colspan="2" class="text-right"> <strong>Total = </strong> </td>
            <td class="text-center"> <strong>{{ $total_patient }} </strong> </td>
            <td class="text-right"> <strong>{{ $total_sales }} </strong>
            <td class="text-right"> <strong>{{ $total_discount }} </strong>
            </td> <td class="text-right"> <strong>{{ $total_due }} </strong>
            </td>
            <td class="text-right"> <strong>{{ $total_payment }} </strong></td>
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
