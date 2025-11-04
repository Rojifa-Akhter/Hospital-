<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
{{-- <button class="btn btn-warning btn-md float-right mb-1" >Print</button> --}}


<?php
if ($type != 'DEPT') {
    $doctor_id = !empty($doc_data) ? $doc_data[0]->person_no_fk : '';
    $date = date('Y-m-d', strtotime($to_date)); # code...
} else {
    $service_id = $su_pt;
    $date_dt = date('Y-m-d', strtotime($date));
}
?>

<table class="table data-table table-bordered table-hover table-striped data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            @if ($po_hospital_details->hospital_code == 'GMC')
                <th class="text-left">Patient Name</th>
            @endif
            @if ($po_hospital_details->hospital_code == 'JKMH')
                <th class="text-left">Invoice No</th>
            @endif
            <th class="text-left">Service Type</th>
            <th class="text-center">Quantity</th>
            <th class="text-left">Item Name </th>
            @if (!empty($income_details))
                <th class="text-right">Sales</th>
                <th class="text-right">Discount</th>
                <th class="text-right">Net Sales</th>
            @else
                <th class="text-right">Amount</th>
            @endif

        </tr>


    </thead>
    <tbody>
        @if ($type != 'DEPT')
            @php
                $i = 0;
                $total = 0;
                $total_sales = $total_discount = $total_net_sales = 0;
            @endphp
            @if (!empty($income_patient_details))
                @foreach ($income_patient_details as $data)
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>
                        <td class="text-left">{{ $data->service_type }} Patient</td>
                        <td class="text-center">{{ $data->invoice_no_pk ?? 0 }}</td>
                        <td class="text-left">Consultantion </td>
                        <td class="text-right"> {{ number_format($data->ledger_amt_sales - $data->ledger_amt_discount, 2) }}</td>
                    </tr>
                @endforeach
            @endif

            @if (!empty($income_details))

                @foreach ($income_details as $data)
                    @if ($data->sur_type == 'OPD')
                        @if ($data->income > 0)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <td class="text-left">{{ $data->patient_name }}</td>
                                @endif
                                @if ($po_hospital_details->hospital_code == 'JKMH')
                                    <td class="text-left">{{ $data->invoice_no }}</td>
                                @endif
                                <td class="text-left">{{ $data->sur_type }}</td>
                                <td class="text-center">{{ $data->qty ?? 0 }}</td>
                                <td class="text-left">{{ $data->item_name ?? 0 }}</td>
                                <td class="text-right">{{ number_format($data->sales, 2) }}</td>
                                <td class="text-right">{{ number_format($data->discount, 2) }}</td>
                                <td class="text-right">{{ number_format($data->net_sales, 2) }}</td>
                            </tr>
                            @php
                                $total_sales += $data->sales;
                                $total_discount = $data->discount;
                                $total_net_sales += $data->net_sales;
                            @endphp
                        @endif
                    @else
                        @if ($data->income != 0)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                @if ($po_hospital_details->hospital_code == 'GMC')
                                    <td class="text-left">{{ $data->patient_name }}</td>
                                @endif
                                @if ($po_hospital_details->hospital_code == 'JKMH')
                                    <td class="text-left">{{ $data->invoice_no }}</td>
                                @endif
                                <td class="text-left">{{ $data->sur_type }}</td>
                                <td class="text-center">{{ $data->qty ?? 0 }}</td>
                                <td class="text-left">{{ $data->item_name ?? 0 }}</td>
                                <td class="text-right">{{ number_format($data->sales, 2) }}</td>
                                <td class="text-right">{{ number_format($data->discount, 2) }}</td>
                                <td class="text-right">{{ number_format($data->net_sales, 2) }}</td>
                            </tr>
                            @php
                                $total_sales += $data->sales;
                                $total_discount = $data->discount;
                                $total_net_sales += $data->net_sales;
                            @endphp
                        @endif
                    @endif
                @endforeach
            @endif

            @if ($po_hospital_details->hospital_code == 'GMC')
                <?php $colspan = 6; ?>
            @else
                <?php $colspan = 5; ?>
            @endif
        @else
            <tr>
                <td colspan="7" class="text-left">{{ $su_name }}</td>
            </tr>
            @if (!empty($dept_data))
                @foreach ($dept_data as $row)
                <?php $total = 0; ?>
                    @foreach ($row as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $data->invoice_date != '' ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}</td>
                            <td class="text-left">{{ $data->patient_name }}</td>
                            <td class="text-left">{{ $data->item_type_name }}</td>
                            <td class="text-center">{{ $data->invoice_no_fk }}</td>
                            <td class="text-center">{{ !empty($data->item_name) ? ucfirst($data->item_name) : '' }}</td>
                            <td class="text-right">{{ number_format($data->ledgerdtl_amt_payment, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        @endif
    </tbody>
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
