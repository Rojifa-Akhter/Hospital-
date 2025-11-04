<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center" width='200px'>Doctor name & Code</th>

            <th class="text-right"> No. Of  {{ $request_type  =="OPD_C" ? 'Appointment' :$request_type }}</th>
            <th class="text-right">Total Sales</th>
            <th class="text-right">Total less </th>
            <th class="text-right">{{ $request_type }} Net Total</th>
            <th class="text-right">{{ $default }} % {{ $request_type }} Deduct </th>
            <th class="text-right">Commission {{ $default }} % </th>


        </tr>


    </thead>
    <tbody>

        @if (!empty($doctor_income))
            @php
                $all_total_appointment = 0;

                $all_sur_amt_count = 0;
                $all_sur_amt = 0;
                $sur_discount_amt = 0;
                $sur_net_amt = 0;
                $deduct = 0;
                $commision = 0;
                $sl = 1;
                $default  =   $default /100;
            @endphp

            @foreach ($doctor_income as $data)
                @php
                    $total_ipd_amt = ($data->sur_amt ?? 0) + ($data->ipd_service_amt ?? 0);
                    $gross_amt = ($data->total_patient_paid ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0);

                @endphp
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>

                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-right">
                        @php
                        $total_count=0;
                        @endphp
                        @if($request_type == "OT")
                        {{ $data->sur_amt_count }}
                     @php  $total_count=$data->sur_amt_count @endphp
                        @elseif($request_type == "LAB")
                        {{ $data->pathology_amt_count }}
                      @php   $total_count=$data->pathology_amt_count @endphp
                        @elseif($request_type == "RAD")
                        {{ $data->radiology_amt_count }}
                    @php  $total_count=$data->radiology_amt_count @endphp
                        @elseif($request_type == "IPD")
                        {{ $data->ipd_service_amt_count }}
                     @php  $total_count=$data->ipd_service_amt_count @endphp
                        @elseif($request_type == "OPD_C")
                        {{ $data->total_appointment }}
                       @php $total_count=$data->total_appointment @endphp
                        @endif
                    </td>
                    <td class="text-right">
                        @php
                        $paid_amt=0;
                        @endphp
                    @if($request_type == "OT")
                        {{ number_format($data->sur_amt, 0) }}
                      @php $paid_amt=$data->sur_amt @endphp
                        @elseif($request_type == "LAB")
                        {{ number_format($data->lab_amt, 0) }}
                       @php $paid_amt=$data->lab_amt @endphp
                        @elseif($request_type == "RAD")
                        {{ number_format($data->rad_amt, 0) }}
                     @php $paid_amt=$data->rad_amt @endphp
                        @elseif($request_type == "IPD")
                        {{ number_format($data->ipd_service_amt, 0) }}
                     @php  $paid_amt=$data->ipd_service_amt @endphp
                        @elseif($request_type == "OPD_C")
                        {{ number_format($data->total_patient_paid, 0) }}
                      @php  $paid_amt=$data->total_patient_paid @endphp
                        @endif
                </td>
                    <td class="text-right">
                        @php
                            $discount=0;
                        @endphp
                    @if($request_type == "OT")
                        {{ number_format($data->sur_discount_amt, 0) }}
                       @php $discount=$data->sur_discount_amt @endphp
                        @elseif($request_type == "LAB")
                        {{ number_format($data->lab_dis_amt, 0) }}
                       @php $discount=$data->lab_dis_amt @endphp
                        @elseif($request_type == "RAD")
                        {{ number_format($data->rad_dis_amt, 0) }}
                      @php $discount=$data->rad_dis_amt @endphp
                        @elseif($request_type == "IPD")
                        {{ number_format($data->ipd_discount_amt, 0) }}
                       @php $discount=$data->ipd_discount_amt @endphp
                        @elseif($request_type == "OPD_C")
                        {{ number_format($data->opd_discount_amt, 0) }}
                      @php $discount=$data->opd_discount_amt @endphp
                        @endif

                    </td>
                    @php
                    $sur_amt =$paid_amt -  $discount;
                    @endphp
                    <td class="text-right">
                        <!-- {{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }} -->
                        {{ number_format($paid_amt - $discount, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format(($sur_amt *$default), 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format(round(($sur_amt - ($sur_amt *$default)) *$default, 2)) }}
                    </td>

                </tr>
                @php
                    $all_total_appointment +=  $total_count;
                    $all_sur_amt_count +=$total_count;
                    $all_sur_amt += $paid_amt;
                    $sur_discount_amt +=  round($discount);
                    $sur_net_amt +=$sur_amt;
                    $deduct += $sur_amt *$default;
                    $commision += round(($sur_amt - ($sur_amt * $default)) *$default);
                @endphp
            @endforeach

            <tr>
                <td class="text-right" colspan="2"> <strong> Total</strong></td>

                <td class="text-right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>

                <td class="text-right"> <strong> {{ number_format($sur_discount_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($sur_net_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($deduct, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($commision, 2) }}</strong></td>


            </tr>
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
