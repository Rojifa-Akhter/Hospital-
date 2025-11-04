<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center" width='200px'>Doctor name & Code</th>

            <th class="text-center"> Designation</th>
            @for ($i = $start_time; $i < $start_time + $month_def; $i++)
                <th class="text-right">Sum of Total Sale - {{ date('F', mktime(0, 0, 0, $i, 10)) }}</th>
                <th class="text-right">Sum of Total Discount - {{ date('F', mktime(0, 0, 0, $i, 10)) }}</th>
            @endfor
            <th class="text-right">Total Sale </th>
            <th class="text-right">Total Discount </th>
            <th class="text-right">Net Sales</th>
            <th class="text-right">Profit Sharing ({{ $default }}% ) </th>


        </tr>


    </thead>
    <tbody>

        @if (!empty($doctor_income))
            @php
                $doctor_income_total = DB::select("select TO_CHAR (income_date, 'mm') income_month, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt, INITCAP(to_char(income_date,'Month')) income_date  from finc_doctor_income_dt_vw   $sql_cond  group by INITCAP(to_char(income_date,'Month')),TO_CHAR (income_date, 'mm') order by income_month asc ");

            @endphp
            @php
                $all_total_appointment = 0;

                $all_opd_discount_amt = 0;
                $all_sur_amt = 0;
                $sur_discount_amt = 0;
                $sur_net_amt = 0;
                $deduct = 0;
                $commision = 0;
                $sl = 1;
                $default = $default / 100;
                $all_total_patient_paid = 0;
                $all_opd_discount_amt = 0;

            @endphp

            @foreach ($doctor_income as $data)
                @php
                    $month_total = 0;
                    $total_patient_paid = 0; //($data->total_patient_paid ?? 0) + ($data->total_patient_paid ?? 0);
                    $opd_discount_amt = 0; // ($data->total_patient_paid ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0);
                    $sur_amt = 0; //$data->sur_amt - $data->sur_discount_amt;

                    $doctor_income_dt = DB::select("select  TO_CHAR (income_date, 'mm') income_month, person_no_pk, full_name, sum(total_patient_paid) total_patient_paid, sum(opd_discount_amt) opd_discount_amt, INITCAP(to_char(income_date,'Month')) income_date  from finc_doctor_income_dt_vw  where trunc(income_date) between to_date('$from_date','yyyy-mm-dd') and  to_date('$to_date','yyyy-mm-dd') and person_no_pk='$data->person_no_pk'  group by  person_no_pk, full_name,INITCAP(to_char(income_date,'Month')),  TO_CHAR (income_date, 'mm')  order by income_month asc");

                    //trunc(income_date) >=    trunc(income_date) <=
                    // dd($doctor_income_dt);
                    // dd( $doctor_income_dt);

                @endphp
                <tr>
                    <td class="text-center">{{ $sl++ }}</td>

                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-left">{{ $data->specialization }}</td>
                    @if (!empty($doctor_income_dt))
                        @foreach ($doctor_income_dt as $income)
                            @php
                                $total_patient_paid += $income->total_patient_paid; //($data->total_patient_paid ?? 0) + ($data->total_patient_paid ?? 0);
                                $opd_discount_amt += $income->opd_discount_amt;

                            @endphp
                            <td class="text-right">{{ number_format($income->total_patient_paid, 0) }}</td>
                            <td class="text-right">{{ number_format($income->opd_discount_amt, 2) }}</td>
                        @endforeach
                    @endif


                    <td class="text-right">{{ number_format($total_patient_paid, 2) }}</td>
                    <td class="text-right">{{ number_format($opd_discount_amt, 2) }}</td>
                    <td class="text-right">
                        {{ number_format($total_patient_paid - $opd_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format(($total_patient_paid - $opd_discount_amt) * $default, 2) }}
                    </td>

                </tr>
            @endforeach

            <tr>
                <td class="text-right" colspan="3"> <strong> Total</strong></td>
                @if (!empty($doctor_income_total))
                    @foreach ($doctor_income_total as $income1)
                        @php

                            $all_total_patient_paid += $income1->total_patient_paid;
                            $all_opd_discount_amt += $income1->opd_discount_amt;

                        @endphp
                        <td class="text-right"><strong>{{ number_format($income1->total_patient_paid, 0) }} </strong></td>
                        <td class="text-right"><strong>{{ number_format($income1->opd_discount_amt, 2) }} </strong></td>
                    @endforeach
                @endif


                <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_opd_discount_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_patient_paid-$all_opd_discount_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format((($all_total_patient_paid-$all_opd_discount_amt)* $default), 2) }}</strong></td>


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
