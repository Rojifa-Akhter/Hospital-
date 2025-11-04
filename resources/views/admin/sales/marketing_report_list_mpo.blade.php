@php
    // Fetch hospital data based on session hospital number
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-primary text-white">
            <th class="text-center" style="width: 5%;">SL#</th>
            <th class="text-center" style="width: 35%;">Name</th>
            <th class="text-center" style="width: 15%;">OPD</th>
            <th class="text-center" style="width: 15%;">IPD</th>
            <th class="text-center" style="width: 15%;">Total</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            @php
                // Initialize final totals for the entire dataset
                $opd_final = 0;
                $ipd_final = 0;
                $grand_final = 0;
            @endphp

            @foreach ($data as $key => $dtp)
                <!-- Group Name Row -->
                <tr class="table-info">
                    <td colspan="5" class="font-weight-bold text-left">{{ $key }}</td>
                </tr>

                @php
                    // Initialize $key-wise totals for this group
                    $opd_key_total = 0;
                    $ipd_key_total = 0;
                    $grand_key_total = 0;
                @endphp

                @foreach ($dtp as $agent => $dt)
                    <!-- Agent Name Row -->
                    <tr class="table-secondary">
                        <td colspan="5" class="text-left font-weight-bold">{{ $agent }}</td>
                    </tr>

                    @php
                        // Initialize $agent-wise totals for this agent
                        $opd_agent_total = 0;
                        $ipd_agent_total = 0;
                        $grand_agent_total = 0;
                    @endphp

                    @foreach ($dt as $value)
                        @php
                            // If no value, default to zero
                            $opd = !empty($value->opd) ? $value->opd : 0;
                            $ipd = !empty($value->ipd) ? $value->ipd : 0;
                            $total = $opd + $ipd;

                            // Accumulating agent-wise totals
                            $opd_agent_total += $opd;
                            $ipd_agent_total += $ipd;
                            $grand_agent_total += $total;

                            // Accumulating group (key)-wise totals
                            $opd_key_total += $opd;
                            $ipd_key_total += $ipd;
                            $grand_key_total += $total;

                            // Accumulating final totals (for the entire dataset)
                            $opd_final += $opd;
                            $ipd_final += $ipd;
                            $grand_final += $total;
                        @endphp

                        <!-- Displaying individual record -->
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $value->mpo_name }}</td>
                            <td class="text-center">{{ $opd }}</td>
                            <td class="text-center">{{ $ipd }}</td>
                            <td class="text-center">{{ $total }}</td>
                        </tr>
                    @endforeach

                    <!-- Agent-wise Subtotal -->
                    <tr class="table-light">
                        <td colspan="2" class="font-weight-bold text-right">Agent Subtotal:</td>
                        <td class="text-center">{{ $opd_agent_total }}</td>
                        <td class="text-center">{{ $ipd_agent_total }}</td>
                        <td class="text-center">{{ $grand_agent_total }}</td>
                    </tr>
                @endforeach

                <!-- Key-wise Subtotal -->
                <tr class="table-light">
                    <td colspan="2" class="font-weight-bold text-right">Group Subtotal ({{ $key }}):</td>
                    <td class="text-center">{{ $opd_key_total }}</td>
                    <td class="text-center">{{ $ipd_key_total }}</td>
                    <td class="text-center">{{ $grand_key_total }}</td>
                </tr>
            @endforeach

            <!-- Grand Total -->
            <tr class="table-dark text-white">
                <td colspan="2" class="font-weight-bold text-right">Grand Total:</td>
                <td class="text-center">{{ $opd_final }}</td>
                <td class="text-center">{{ $ipd_final }}</td>
                <td class="text-center">{{ $grand_final }}</td>
            </tr>
        @else
            <!-- If no data is available -->
            <tr>
                <td colspan="5" class="text-center text-danger">No data available</td>
            </tr>
        @endif
    </tbody>
</table>

<h2 class="text-center mt-4">Financial Summary</h2>
{{-- Placeholder for any additional financial section --}}
<table class="table table-bordered table-striped mb-0 data-table">
    <thead class="sticky_header">
        <tr class="bg-primary text-white">
            <th class="text-center" style="width: 5%;">SL#</th>
            <th class="text-center" style="width: 25%;">Name</th>
            <th class="text-center" style="width: 15%;">Total Patient</th>
            <th class="text-center" style="width: 15%;">Per Patient</th>
            <th class="text-center" style="width: 15%;">Sales</th>
            <th class="text-center" style="width: 15%;">Discount</th>
            <th class="text-center" style="width: 15%;">Collection</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            @php
                // Initialize final totals for the entire dataset
                $total_patient = 0;
                $total_sales = 0;
                $total_discount = 0;
                $total_collection = 0;
            @endphp

            @foreach ($data as $key => $dtp)
                <!-- Group Name Row -->
                <tr class="table-info">
                    <td colspan="7" class="font-weight-bold text-left">{{ $key }}</td>
                </tr>

                @php
                    // Initialize $key-wise totals for this group
                    $key_total_patient = 0;
                    $key_total_sales = 0;
                    $key_total_discount = 0;
                    $key_total_collection = 0;
                @endphp

                @foreach ($dtp as $agent => $dt)
                    <!-- Agent Name Row -->
                    <tr class="table-secondary">
                        <td colspan="7" class="text-left font-weight-bold">{{ $agent }}</td>
                    </tr>

                    @php
                        // Initialize $agent-wise totals for this agent
                        $agent_total_patient = 0;
                        $agent_total_sales = 0;
                        $agent_total_discount = 0;
                        $agent_total_collection = 0;
                    @endphp

                    @foreach ($dt as $value)
                        @php
                            // Defaulting to zero if no value exists
                            $opd = !empty($value->opd) ? $value->opd : 0;
                            $ipd = !empty($value->ipd) ? $value->ipd : 0;
                            $patient_count = $opd + $ipd; // Calculating the patient count (opd + ipd)
                            $sales = !empty($value->sales) ? $value->sales : 0;
                            $discount = !empty($value->discount) ? $value->discount : 0;
                            // Ensure collection is coming from the right field (check if payment is the correct field)
                            $collection = !empty($value->payment) ? $value->payment : 0;

                            // Debugging - Check if payment is actually set correctly
                            // dd($value->payment, $collection);

                            // Accumulating agent-wise totals
                            $agent_total_patient += $patient_count;
                            $agent_total_sales += $sales;
                            $agent_total_discount += $discount;
                            $agent_total_collection += $collection;

                            // Accumulating group (key)-wise totals
                            $key_total_patient += $patient_count;
                            $key_total_sales += $sales;
                            $key_total_discount += $discount;
                            $key_total_collection += $collection;

                            // Accumulating final totals (for the entire dataset)
                            $total_patient += $patient_count;
                            $total_sales += $sales;
                            $total_discount += $discount;
                            $total_collection += $collection;
                        @endphp


                        <!-- Displaying individual record -->
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $value->mpo_name }}</td>
                            <td class="text-center">{{ $patient_count }}</td>

                            <td class="text-center">
                                @if ($patient_count > 0)
                                    {{ number_format($sales / $patient_count, 2) }}
                                @else
                                    0.00
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($sales) }}</td>
                            <td class="text-center">{{ number_format($discount) }}</td>
                            <td class="text-center">{{ number_format($collection) }}</td>
                        </tr>
                    @endforeach

                    <!-- Agent-wise Subtotal -->
                    <tr class="table-light">
                        <td colspan="2" class="font-weight-bold text-right">Agent Subtotal:</td>
                        <td class="text-center">{{ $agent_total_patient }}</td>
                        <td class="text-center"></td>
                        <td class="text-center">{{ number_format($agent_total_sales) }}</td>
                        <td class="text-center">{{ number_format($agent_total_discount) }}</td>
                        <td class="text-center">{{ number_format($agent_total_collection) }}</td>
                    </tr>
                @endforeach

                <!-- Key-wise Subtotal -->
                <tr class="table-light">
                    <td colspan="2" class="font-weight-bold text-right">Group Subtotal ({{ $key }}):</td>
                    <td class="text-center">{{ $key_total_patient }}</td>
                    <td class="text-center"></td>
                    <td class="text-center">{{ number_format($key_total_sales) }}</td>
                    <td class="text-center">{{ number_format($key_total_discount) }}</td>
                    <td class="text-center">{{ number_format($key_total_collection) }}</td>
                </tr>
            @endforeach

            <!-- Grand Total -->
            <tr class="table-dark text-white">
                <td colspan="2" class="font-weight-bold text-right">Grand Total:</td>
                <td class="text-center">{{ $total_patient }}</td>
                <td class="text-center"></td>
                <td class="text-center">{{ number_format($total_sales) }}</td>
                <td class="text-center">{{ number_format($total_discount) }}</td>
                <td class="text-center">{{ number_format($total_collection) }}</td>
            </tr>
        @else
            <!-- If no data is available -->
            <tr>
                <td colspan="7" class="text-center text-danger">No data available</td>
            </tr>
        @endif
    </tbody>
</table>
