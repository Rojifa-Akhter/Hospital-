@php

use Carbon\Carbon;

$po_hospital_details = DB::table('WSEC_HOSPITAL')
// ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
->first();

@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Performance Summary Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->

    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong></span>
                                <br>
                                Address:
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                Phone No:
                                <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Doctor Performance Summary Report</strong> </div>
                    <div style="text-align: center;">
                        <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="text-align: center">SL#</th>
                <th style="text-align: center" width='200px'>Name</th>
                <th style="text-align: center">Total OPD Patient</th>
                <th style="text-align: center">OPD-New </th>
                <th style="text-align: center">OPD-Follow Up</th>
                <th style="text-align: center">OPD-Free</th>
                <th style="text-align: center">Total OPD Income</th>
                <th style="text-align: center"> No. Of OT</th>
                <th style="text-align: center">Total OT Income</th>
                <th style="text-align: center"> No. Of Procedure</th>
                <th style="text-align: center">Total Procedure Income</th>
                <th style="text-align: center"> No. Of Admitted Patient</th>
                <th style="text-align: center">No. Of Doctor Visit </th>
                <th style="text-align: center">Doctor Visit Amount</th>
                <th style="text-align: center">Total IPD Income</th>
                <th style="text-align: center">No. of Pathology </th>
                <th style="text-align: center">Total Pathology Income</th>
                <th style="text-align: center">No. of Radiology </th>
                <th style="text-align: center">Total Radiology Income</th>
                <th style="text-align: center">Others Income </th>
                <th style="text-align: center">Total Overall Income </th>
            </tr>
        </thead>
        <tbody class="tr_border">
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
            @if (count($internal_doctors) > 0)
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
                    <td colspan="21" style="text-align: left"><h4>Internal Doctors</h4></td>
                </tr>
                @foreach ($internal_doctors as $data)
                    @php
                        $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                        $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt) - floatVal($data->ipd_discount_amt);
                        $gross_amt = ($data->total_patient_paid ?? 0) + ($data->procedure_amount ?? 0) + ($data->sur_amt ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0) - ($data->rad_discount_amt ?? 0) - ($data->lab_discount_amt ?? 0) - ($data->others_discount_amt ?? 0) - ($data->sur_discount_amt ?? 0) - ($data->procedure_amout_discount ?? 0);
                    @endphp
                    
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td style="text-align: left"><div>{{ $data->full_name }}</div><div><strong>{{ '[' . $data->su_name . ']' }}</strong></div></td>
                        <td style="text-align: center">{{ $data->total_appointment ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_new_paid ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_followup_free ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_free ?? 0 }}</td>
                        <td style="text-align: right">{{ number_format($data->total_patient_paid, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->sur_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->prcedure_amout_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->procedure_amount - $data->procedure_amout_discount, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->total_admission_no, 0) }}</td>
                        <td style="text-align: right">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                        <td style="text-align: right">{{ number_format($visit_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($total_ipd_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->pathology_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->lab_amt - $data->lab_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->radiology_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->rad_amt - $data->rad_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->all_other_amt - $data->others_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($gross_amt, 2) }}</td>
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
                    <td style="text-align: right" colspan="2"> <strong> Total (Internal Doctors)</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_total_appointment }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_followup_free }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_free }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($prcedure_amout_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($radiology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
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
            {{-- @if (count($external_doctors) > 0)
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
                    <td colspan="21" style="text-align: left"><h4>External Doctors</h4></td>
                </tr>
                @foreach ($external_doctors as $data)
                    @php
                        $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                        $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt) - floatVal($data->ipd_discount_amt);
                        $gross_amt = ($data->total_patient_paid ?? 0) + ($data->procedure_amount ?? 0) + ($data->sur_amt ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0) - ($data->rad_discount_amt ?? 0) - ($data->lab_discount_amt ?? 0) - ($data->others_discount_amt ?? 0) - ($data->sur_discount_amt ?? 0) - ($data->procedure_amout_discount ?? 0);
                    @endphp
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td style="text-align: left"><div>{{ $data->full_name }}</div><div><strong>{{ '[' . $data->su_name . ']' }}</strong></div></td>
                        <td style="text-align: center">{{ $data->total_appointment ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_new_paid ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_followup_free ?? 0 }}</td>
                        <td style="text-align: center">{{ $data->patient_free ?? 0 }}</td>
                        <td style="text-align: right">{{ number_format($data->total_patient_paid, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->sur_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->prcedure_amout_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->procedure_amount - $data->procedure_amout_discount, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->total_admission_no, 0) }}</td>
                        <td style="text-align: right">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                        <td style="text-align: right">{{ number_format($visit_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($total_ipd_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->pathology_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->lab_amt - $data->lab_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->radiology_amt_count, 0) }}</td>
                        <td style="text-align: right">{{ number_format($data->rad_amt - $data->rad_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($data->all_other_amt - $data->others_discount_amt, 2) }}</td>
                        <td style="text-align: right">{{ number_format($gross_amt, 2) }}</td>
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
                    <td style="text-align: right" colspan="2"> <strong> Sub Total (External Doctors)</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_total_appointment }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_followup_free }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $all_patient_free }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_sur_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($prcedure_amout_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($radiology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
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
                    <td style="text-align: right" colspan="2"> <strong> Total</strong></td>
                    <td style="text-align: center"> <strong> {{ $total_all_total_appointment }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $total_all_patient_new_paid }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $total_all_patient_followup_free }}</strong></td>
                    <td style="text-align: center"> <strong> {{ $total_all_patient_free }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_total_patient_paid, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_sur_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_sur_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_prcedure_amout_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_procedure_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($total_total_admission_no, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_no_of_patient_visit_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_visit_amount, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_total_ipd_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($total_pathology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_lab_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong>{{ number_format($total_radiology_amt_count, 0) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_rad_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_other_amt, 2) }}</strong></td>
                    <td style="text-align: right"> <strong> {{ number_format($total_all_gross_amt, 2) }}</strong></td>
                </tr>
            @endif --}}

        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    @php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    @endphp
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
