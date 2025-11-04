<table class="table data-table table-bordered table-hover table-striped" id="dataTable">
    <thead class="bg-light-blue sticky">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center" width='200px'>Name</th>
            <th class="text-center">Total OPD Patient</th>
            <th class="text-right">OPD-New </th>
            <th class="text-right">OPD-Follow Up</th>
            <th class="text-right">OPD-Free</th>
            <th class="text-right">Total OPD Income</th>
            <th class="text-right"> No. Of OT</th>
            <th class="text-right">Total OT Income</th>
            <th class="text-right"> No. Of Procedure</th>
            <th class="text-right">Total Procedure Income</th>
            <th class="text-right"> No. Of Admitted Patient</th>
            <th class="text-right">No. Of Doctor Visit </th>
            <th class="text-right">Doctor Visit Amount</th>
            <th class="text-right">Total IPD Income</th>
            <th class="text-right">No. of Pathology </th>
            <th class="text-right">Total Pathology Income</th>
            <th class="text-right">No. of Radiology </th>
            <th class="text-right">Total Radiology Income</th>
            <th class="text-right">Others Income </th>
            <th class="text-right">Total Overall Income </th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_all_total_appointment = 0;
            $total_all_patient_new_paid = 0;
            $total_all_patient_free = 0;
            $total_all_patient_followup_free = 0;
            $total_all_total_patient_paid = 0;
            $total_all_sur_amt_count = 0;
            $total_all_sur_amt = 0;
            $total_visit_amount = 0;
            $total_all_ipd_service_amt_count = 0;
            $total_all_ipd_service_amt = 0;
            $total_all_total_ipd_amt = 0;
            $total_all_lab_amt = 0;
            $total_all_rad_amt = 0;
            $total_all_other_amt = 0;
            $total_all_gross_amt = 0;
            $total_total_admission_no = 0;
            $total_pathology_amt_count = 0;
            $total_radiology_amt_count = 0;
            $total_no_of_patient_visit_count = 0;
            
            $total_prcedure_amout_count = 0;
            $total_procedure_amount = 0;
        @endphp

        {{-- Internal Doctors --}}
        @if (isset($result) && count($result["internal_doctors"]) > 0)
            @php
                $all_total_appointment = 0;
                $all_patient_new_paid = 0;
                $all_patient_free = 0;
                $all_patient_followup_free = 0;
                $all_total_patient_paid = 0;
                $all_sur_amt_count = 0;
                $all_sur_amt = 0;
                $visit_amount = 0;
                $all_ipd_service_amt_count = 0;
                $all_ipd_service_amt = 0;
                $all_total_ipd_amt = 0;
                $all_lab_amt = 0;
                $all_rad_amt = 0;
                $all_other_amt = 0;
                $all_gross_amt = 0;
                $total_admission_no = 0;
                $pathology_amt_count = 0;
                $radiology_amt_count = 0;
                $no_of_patient_visit_count = 0;
                
                $prcedure_amout_count = 0;
                $procedure_amount = 0;
            @endphp

            <tr>
                <td colspan="22" class="text-left"><h4>Internal Doctors</h4></td>
            </tr>
            @foreach ($result['internal_doctors'] as $data)
                @php
                    $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                    $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt) - floatVal($data->ipd_discount_amt);
                    $gross_amt = ($data->total_patient_paid ?? 0) + ($data->procedure_amount ?? 0) + ($data->sur_amt ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0) - ($data->rad_discount_amt ?? 0) - ($data->lab_discount_amt ?? 0) - ($data->others_discount_amt ?? 0) - ($data->sur_discount_amt ?? 0) - ($data->procedure_amout_discount ?? 0);
                @endphp
                
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left"><div>{{ $data->full_name }}</div><div><strong>{{ '[' . $data->su_name . ']' }}</strong></div></td>
                    <td class="text-center">{{ $data->total_appointment ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_new_paid ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_followup_free ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_free ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->total_patient_paid, 2) }}</td>
                    <td class="text-right">{{ number_format($data->sur_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->prcedure_amout_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->procedure_amount - $data->procedure_amout_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($data->total_admission_no, 0) }}</td>
                    <td class="text-right">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                    <td class="text-right">{{ number_format($visit_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($total_ipd_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->pathology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->lab_amt - $data->lab_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->radiology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->rad_amt - $data->rad_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->all_other_amt - $data->others_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt, 2) }}</td>
                    <td class="text-right">
                        <span class="btn btn-sm btn-success open-modal btnView"
                            data-action="{{ route('doctor-wise-income-summary-details', [$data->person_no_pk, date('Y-m-d', strtotime($to_date)), date('Y-m-d', strtotime($from_date)), 'DOCTOR']) }}"
                            data-modal="common-modal-xl" data-title="Details">
                            <i class="fa fa-eye"></i>
                        </span>
                    </td>
                </tr>
                @php
                    $all_total_appointment += $data->total_appointment;
                    $all_patient_new_paid += $data->patient_new_paid;
                    $all_patient_free += $data->patient_free;
                    $all_patient_followup_free += $data->patient_followup_free;
                    $all_total_patient_paid += $data->total_patient_paid;
                    $all_sur_amt_count += $data->sur_amt_count;
                    $visit_amount += $visit_amt;
                    $all_sur_amt += $data->sur_amt - ($data->sur_discount_amt ?? 0);
                    $all_ipd_service_amt_count += $data->ipd_service_amt_count;
                    $all_total_ipd_amt += $total_ipd_amt;
                    $all_lab_amt += $data->lab_amt - ($data->lab_discount_amt ?? 0);
                    $all_rad_amt += $data->rad_amt - ($data->rad_discount_amt ?? 0);
                    $all_other_amt += $data->all_other_amt - ($data->others_discount_amt ?? 0);
                    $all_gross_amt += $gross_amt;
                    $total_admission_no += $data->total_admission_no;
                    $pathology_amt_count += $data->pathology_amt_count;
                    $radiology_amt_count += $data->radiology_amt_count;                   
                    $procedure_amount += $data->procedure_amount - $data->procedure_amout_discount;
                    $prcedure_amout_count += $data->prcedure_amout_count;
                    $no_of_patient_visit_count += $data->ipd_docvisit_amt_count;
                @endphp
            @endforeach

            <tr>
                <td class="text-right" colspan="2"> <strong> Sub Total (Internal Doctors)</strong></td>
                <td class="text-center"> <strong> {{ $all_total_appointment }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_followup_free }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_free }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($prcedure_amout_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($radiology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
                <td></td>
            </tr>

            @php
                $total_all_total_appointment += $all_total_appointment;
                $total_all_patient_new_paid += $all_patient_new_paid;
                $total_all_patient_free += $all_patient_free;
                $total_all_patient_followup_free += $all_patient_followup_free;
                $total_all_total_patient_paid += $all_total_patient_paid;
                $total_all_sur_amt_count += $all_sur_amt_count;
                $total_all_sur_amt += $all_sur_amt;
                $total_visit_amount += $visit_amount;
                $total_all_ipd_service_amt_count += $all_ipd_service_amt_count;
                $total_all_ipd_service_amt += $all_ipd_service_amt;
                $total_all_total_ipd_amt += $all_total_ipd_amt;
                $total_all_lab_amt += $all_lab_amt;
                $total_all_rad_amt += $all_rad_amt = 0;
                $total_all_other_amt += $all_other_amt = 0;
                $total_all_gross_amt += $all_gross_amt;
                $total_total_admission_no += $total_admission_no;
                $total_pathology_amt_count += $pathology_amt_count;
                $total_radiology_amt_count += $radiology_amt_count;
                $total_no_of_patient_visit_count += $no_of_patient_visit_count;
                
                $total_prcedure_amout_count += $prcedure_amout_count;
                $total_procedure_amount += $procedure_amount;
            @endphp
        @endif

        {{-- External Doctors --}}
        @if (isset($result) && count($result["external_doctors"]) > 0)
            @php
                $all_total_appointment = 0;
                $all_patient_new_paid = 0;
                $all_patient_free = 0;
                $all_patient_followup_free = 0;
                $all_total_patient_paid = 0;
                $all_sur_amt_count = 0;
                $all_sur_amt = 0;
                $visit_amount = 0;
                $all_ipd_service_amt_count = 0;
                $all_ipd_service_amt = 0;
                $all_total_ipd_amt = 0;
                $all_lab_amt = 0;
                $all_rad_amt = 0;
                $all_other_amt = 0;
                $all_gross_amt = 0;
                $total_admission_no = 0;
                $pathology_amt_count = 0;
                $radiology_amt_count = 0;
                $no_of_patient_visit_count = 0;
                
                $prcedure_amout_count = 0;
                $procedure_amount = 0;
            @endphp
            <tr>
                <td colspan="22" class="text-left"><h4>External Doctors</h4></td>
            </tr>
            @foreach ($result['external_doctors'] as $data)
                @php
                    $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                    $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt) - floatVal($data->ipd_discount_amt);
                    $gross_amt = ($data->total_patient_paid ?? 0) + ($data->procedure_amount ?? 0) + ($data->sur_amt ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0) - ($data->rad_discount_amt ?? 0) - ($data->lab_discount_amt ?? 0) - ($data->others_discount_amt ?? 0) - ($data->sur_discount_amt ?? 0) - ($data->procedure_amout_discount ?? 0);
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left"><div>{{ $data->full_name }}</div><div><strong>{{ '[' . $data->su_name . ']' }}</strong></div></td>
                    <td class="text-center">{{ $data->total_appointment ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_new_paid ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_followup_free ?? 0 }}</td>
                    <td class="text-center">{{ $data->patient_free ?? 0 }}</td>
                    <td class="text-right">{{ number_format($data->total_patient_paid, 2) }}</td>
                    <td class="text-right">{{ number_format($data->sur_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->prcedure_amout_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->procedure_amount - $data->procedure_amout_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($data->total_admission_no, 0) }}</td>
                    <td class="text-right">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                    <td class="text-right">{{ number_format($visit_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($total_ipd_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->pathology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->lab_amt - $data->lab_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->radiology_amt_count, 0) }}</td>
                    <td class="text-right">{{ number_format($data->rad_amt - $data->rad_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($data->all_other_amt - $data->others_discount_amt, 2) }}</td>
                    <td class="text-right">{{ number_format($gross_amt, 2) }}</td>
                    <td class="text-right">
                        <span class="btn btn-sm btn-success open-modal btnView"
                            data-action="{{ route('doctor-wise-income-summary-details', [$data->person_no_pk, date('Y-m-d', strtotime($to_date)), date('Y-m-d', strtotime($from_date)), 'DOCTOR']) }}"
                            data-modal="common-modal-xl" data-title="Details">
                            <i class="fa fa-eye"></i>
                        </span>
                    </td>
                </tr>
                @php
                    $all_total_appointment += $data->total_appointment;
                    $all_patient_new_paid += $data->patient_new_paid;
                    $all_patient_free += $data->patient_free;
                    $all_patient_followup_free += $data->patient_followup_free;
                    $all_total_patient_paid += $data->total_patient_paid;
                    $all_sur_amt_count += $data->sur_amt_count;
                    $visit_amount += $visit_amt;
                    $all_sur_amt += $data->sur_amt - ($data->sur_discount_amt ?? 0);
                    $all_ipd_service_amt_count += $data->ipd_service_amt_count;
                    $all_total_ipd_amt += $total_ipd_amt;
                    $all_lab_amt += $data->lab_amt - ($data->lab_discount_amt ?? 0);
                    $all_rad_amt += $data->rad_amt - ($data->rad_discount_amt ?? 0);
                    $all_other_amt += $data->all_other_amt - ($data->others_discount_amt ?? 0);
                    $all_gross_amt += $gross_amt;
                    $total_admission_no += $data->total_admission_no;
                    $pathology_amt_count += $data->pathology_amt_count;
                    $radiology_amt_count += $data->radiology_amt_count;                   
                    $procedure_amount += $data->procedure_amount - $data->procedure_amout_discount;
                    $prcedure_amout_count += $data->prcedure_amout_count;
                    $no_of_patient_visit_count += $data->ipd_docvisit_amt_count;
                @endphp
            @endforeach

            <tr>
                <td class="text-right" colspan="2"> <strong> Sub Total (External Doctors)</strong></td>
                <td class="text-center"> <strong> {{ $all_total_appointment }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_followup_free }}</strong></td>
                <td class="text-center"> <strong> {{ $all_patient_free }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($prcedure_amout_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($radiology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
                <td></td>
            </tr>

            @php
                $total_all_total_appointment += $all_total_appointment;
                $total_all_patient_new_paid += $all_patient_new_paid;
                $total_all_patient_free += $all_patient_free;
                $total_all_patient_followup_free += $all_patient_followup_free;
                $total_all_total_patient_paid += $all_total_patient_paid;
                $total_all_sur_amt_count += $all_sur_amt_count;
                $total_all_sur_amt += $all_sur_amt;
                $total_visit_amount += $visit_amount;
                $total_all_ipd_service_amt_count += $all_ipd_service_amt_count;
                $total_all_ipd_service_amt += $all_ipd_service_amt;
                $total_all_total_ipd_amt += $all_total_ipd_amt;
                $total_all_lab_amt += $all_lab_amt;
                $total_all_rad_amt += $all_rad_amt = 0;
                $total_all_other_amt += $all_other_amt = 0;
                $total_all_gross_amt += $all_gross_amt;
                $total_total_admission_no += $total_admission_no;
                $total_pathology_amt_count += $pathology_amt_count;
                $total_radiology_amt_count += $radiology_amt_count;
                $total_no_of_patient_visit_count += $no_of_patient_visit_count;
                
                $total_prcedure_amout_count += $prcedure_amout_count;
                $total_procedure_amount += $procedure_amount;
            @endphp

            <tr>
                <td class="text-right" colspan="2"> <strong> Total</strong></td>
                <td class="text-center"> <strong> {{ $total_all_total_appointment }}</strong></td>
                <td class="text-center"> <strong> {{ $total_all_patient_new_paid }}</strong></td>
                <td class="text-center"> <strong> {{ $total_all_patient_followup_free }}</strong></td>
                <td class="text-center"> <strong> {{ $total_all_patient_free }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_total_patient_paid, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_sur_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_sur_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_prcedure_amout_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_procedure_amount, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_total_admission_no, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_no_of_patient_visit_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_visit_amount, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_total_ipd_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_pathology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_lab_amt, 2) }}</strong></td>
                <td class="text-right"> <strong>{{ number_format($total_radiology_amt_count, 0) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_rad_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_other_amt, 2) }}</strong></td>
                <td class="text-right"> <strong> {{ number_format($total_all_gross_amt, 2) }}</strong></td>
                <td></td>
            </tr>
        @endif

        @if (!isset($result) || count($result["internal_doctors"]) == 0 && count($result["external_doctors"]) == 0)
        <tr>
            <td colspan="22" class="text-center"><strong>No Data found</strong></td>
        </tr>
        @endif
    </tbody>
</table>
