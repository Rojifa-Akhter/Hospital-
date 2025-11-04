@if (!empty($due_data))
@php
    $total_sales = 0;
    $total_payment = 0;
    $total_discount = 0;
    $total_due = 0;
@endphp
@foreach ($due_data as $data)
    <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td class="text-center">{{ $data->invoice_no_pk }}</td>
        <td class="text-center">{{ $data->invoice_date ? date('d-m-Y', strtotime($data->invoice_date)) : '' }}</td>
        <td class="text-left">{{ $data->patient_name }}</td>
        <td class="text-right">{{ $data->sales }}</td>
        <td class="text-right">{{ $data->payment }}</td>
        <td class="text-right">{{ $data->discount }}</td>
        <td class="text-right">{{ $data->due }}</td>
    </tr>
    @php
        $total_sales += $data->sales;
        $total_payment += $data->payment;
        $total_discount += $data->discount;
        $total_due += $data->due;
    @endphp
@endforeach
{{-- <tr>
    <td colspan="4" class="text-right"><b>Total</b></td>
    <td class="text-right"><b>{{ $total_sales }}</b></td>
    <td class="text-right"><b>{{ $total_payment }}</b></td>
    <td class="text-right"><b>{{ $total_discount }}</b></td>
    <td class="text-right"><b>{{ $total_due }}</b></td>
</tr> --}}
@endif