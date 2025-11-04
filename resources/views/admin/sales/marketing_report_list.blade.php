@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Name</th>
            <th class="text-center">OPD</th>
            <th class="text-center">IPD</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            @php
                $opd_final = 0;
                $ipd_final = 0;
                $grand_final = 0;
            @endphp
            @foreach ($data as $key => $dt)
                <tr>
                    <td colspan="5" class="text-left font-weight-bold">
                        {{ $key }}
                    </td>
                </tr>

                @php
                    $opd_total = 0;
                    $ipd_total = 0;
                    $grand_total = 0;
                @endphp
                @foreach ($dt as $value)
                    @php
                        $opd = !empty($value->opd) ? $value->opd : 0;
                        $ipd = !empty($value->ipd) ? $value->ipd : 0;
                        $total = $opd + $ipd;

                        $opd_total += $opd;
                        $ipd_total += $ipd;
                        $grand_total += $total;

                        // Accumulate final totals
                        $opd_final += $opd;
                        $ipd_final += $ipd;
                        $grand_final += $total;
                    @endphp

                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->full_name }}</td>
                        <td class="text-center">{{ $opd }}</td>
                        <td class="text-center">{{ $ipd }}</td>
                        <td class="text-center">{{ $total }}</td>
                    </tr>
                @endforeach

                <tr class="bg-light-gray">
                    <td class="font-weight-bold text-right" colspan="2">Sub Total =</td>
                    <td class="text-center">{{ $opd_total }}</td>
                    <td class="text-center">{{ $ipd_total }}</td>
                    <td class="text-center">{{ $grand_total }}</td>
                </tr>
            @endforeach

            <tr class="bg-light-gray">
                <td class="font-weight-bold text-right" colspan="2">Total =</td>
                <td class="text-center">{{ $opd_final }}</td>
                <td class="text-center">{{ $ipd_final }}</td>
                <td class="text-center">{{ $grand_final }}</td>
            </tr>
        @else
            <tr>
                <td colspan="5" class="text-center">No data available</td>
            </tr>
        @endif
    </tbody>
</table>

<h2 class="text-center">Financial Part</h2>
{{-- Financial Part --}}

<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-light-blue">
            <th class="text-center">SL#</th>
            <th class="text-center">Name</th>
            <th class="text-center">Total Patient</th>
            
            <th class="text-center">Per Patient</th>
            <th class="text-center">Sales</th>
            <th class="text-center">Discount</th>
            <th class="text-center">Collection</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            @php
                $sales_final = 0;
                $discount_final = 0;
                $collection_final = 0;
                $patient_final = 0;
            @endphp
            @foreach ($data as $key => $dt)
                <tr>
                    <td colspan="7" class="text-left font-weight-bold">
                        {{ $key }}
                    </td>
                </tr>

                @php
                    $sales_total = 0;
                    $discount_total = 0;
                    $collection_total = 0;
                    $grand_patient = 0;
                @endphp
                @foreach ($dt as $value)
                    @php
                        $opd = !empty($value->opd) ? $value->opd : 0;
                        $ipd = !empty($value->ipd) ? $value->ipd : 0;
                        $sales = !empty($value->sales) ? $value->sales : 0;
                        $discount = !empty($value->discount) ? $value->discount : 0;
                        $collection = !empty($value->payment) ? $value->payment : 0;

                        $total_patient = $opd + $ipd;

                        $grand_patient += $total_patient;
                        $sales_total += $sales;
                        $discount_total += $discount;
                        $collection_total += $collection;

                    @endphp

                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->full_name }}</td>
                        <td class="text-center">{{ $total_patient }}</td> 
                        <td class="text-right">{{ number_format($sales / $total_patient) }}</td>
                                              
                        <td class="text-right">{{ number_format($sales) }}</td>
                        <td class="text-right">{{ number_format($discount) }}</td>
                        <td class="text-right">{{ number_format($collection) }}</td>
                    </tr>
                @endforeach

                <tr class="bg-light-gray">
                    <td class="font-weight-bold text-right" colspan="2">Sub Total =</td>
                    <td class="text-center">{{ $grand_patient }}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{ number_format($sales_total) }}</td>
                   
                    <td class="text-right">{{ number_format($discount_total) }}</td>
                    <td class="text-right">{{ number_format($collection_total) }}</td>
                </tr>

                @php
                    // Accumulate final totals for financials
                    $patient_final += $grand_patient;
                    $sales_final += $sales_total;
                    $discount_final += $discount_total;
                    $collection_final += $collection_total;
                @endphp
            @endforeach

            <tr class="bg-light-gray">
                <td class="font-weight-bold text-right" colspan="2">Total =</td>
                <td class="text-center">{{ $patient_final }}</td> {{-- This should be updated correctly --}}
                <td class="text-right"></td>
                <td class="text-right">{{ number_format($sales_final) }}</td>
               
                <td class="text-right">{{ number_format($discount_final) }}</td>
                <td class="text-right">{{ number_format($collection_final) }}</td>
            </tr>
        @else
            <tr>
                <td colspan="7" class="text-center">No data available</td>
            </tr>
        @endif
    </tbody>
</table>
