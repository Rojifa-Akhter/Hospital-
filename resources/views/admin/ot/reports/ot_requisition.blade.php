<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OT Requisition Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 9px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 0.5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 10px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
            width: 100%
        }

        td {
            border: 1px solid #222;
            padding: 7px;
            font-size: 12px;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border: 1px solid #222;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div style="text-align: center; padding:5px">
        {{-- <header>
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
                            <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                        </div>
    
                    </td>
                </tr>
            </table>
        </header> --}}

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
                            <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                        </div>
    
                    </td>
                </tr>
            </table>
        <strong>
            <h2>OT Requisition Report</h2>
        </strong>
        {{-- <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span class="report-date"><strong>To
                    Date: {{ $to_date }}</strong>
            </span> --}}
    </div>
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="bg-light-blue sticky">
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-center" >Req. ID</th>
                <th class="text-center">Admission ID</th>
                <th class="text-right">Patient Name</th>
                <th class="text-right">Gender</th>
                <th class="text-right">Age</th>
                <th class="text-right"> Dept.</th>
                <th class="text-right">Ward/Cabin </th>
                <th class="text-right">Diagnosis</th>
                <th class="text-right">Proposed operation</th>
                <th class="text-right">Estimated Time of Operation</th>
                <th class="text-right">Surgeons Remark</th>
                <th class="text-right">Actions </th>
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
            @if (isset($result) && count($result['internal_doctors']) > 0)
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
                    <td colspan="14" class="text-left">
                        <h4>Internal Doctors</h4>
                    </td>
                </tr>
                @foreach ($result['internal_doctors'] as $data)
                    @php
                        $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                        $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt);
                        $gross_amt =
                            ($data->total_patient_paid ?? 0) +
                            ($data->procedure_amount ?? 0) +
                            ($data->sur_amt ?? 0) +
                            $total_ipd_amt +
                            ($data->lab_amt ?? 0) +
                            ($data->rad_amt ?? 0) +
                            ($data->all_other_amt ?? 0);
                    @endphp

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">
                            <div>{{ $data->full_name }}</div>
                            <div><strong>{{ '[' . $data->su_name . ']' }}</strong></div>
                        </td>
                        <td class="text-center">{{ $data->total_appointment ?? 0 }}</td>
                        <td class="text-right">{{ number_format($data->total_patient_paid, 2) }}</td>
                        <td class="text-right">{{ number_format($data->sur_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->procedure_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($data->total_admission_no, 0) }}</td>
                        <td class="text-right">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                        <td class="text-right">{{ number_format($visit_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($total_ipd_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->lab_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->rad_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->all_other_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($gross_amt, 2) }}</td>
                    </tr>
                    @php
                        $all_total_appointment += $data->total_appointment;
                        $all_patient_free += $data->patient_free;
                        $all_total_patient_paid += $data->total_patient_paid;
                        $visit_amount += $visit_amt;
                        $all_sur_amt += $data->sur_amt;
                        $all_total_ipd_amt += $total_ipd_amt;
                        $all_lab_amt += $data->lab_amt;
                        $all_rad_amt += $data->rad_amt;
                        $all_other_amt += $data->all_other_amt;
                        $all_gross_amt += $gross_amt;
                        $total_admission_no += $data->total_admission_no;
                        $procedure_amount += $data->procedure_amount;
                    @endphp
                @endforeach

                <tr>
                    <td class="text-right" colspan="2"> <strong> Sub Total (Internal Doctors)</strong></td>
                    <td class="text-center"> <strong> {{ $all_total_appointment }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
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
                    $total_no_of_patient_visit_count += $no_of_patient_visit_count;
                    $total_procedure_amount += $procedure_amount;
                @endphp
            @endif

            {{-- External Doctors --}}
            @if (isset($result) && count($result['external_doctors']) > 0)
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
                    <td colspan="22" class="text-left">
                        <h4>External Doctors</h4>
                    </td>
                </tr>
                @foreach ($result['external_doctors'] as $data)
                    @php
                        $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                        $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt);
                        $gross_amt =
                            ($data->total_patient_paid ?? 0) +
                            ($data->procedure_amount ?? 0) +
                            ($data->sur_amt ?? 0) +
                            $total_ipd_amt +
                            ($data->lab_amt ?? 0) +
                            ($data->rad_amt ?? 0) +
                            ($data->all_other_amt ?? 0);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">
                            <div>{{ $data->full_name }}</div>
                            <div><strong>{{ '[' . $data->su_name . ']' }}</strong></div>
                        </td>
                        <td class="text-center">{{ $data->total_appointment ?? 0 }}</td>
                        <td class="text-center">{{ $data->patient_free ?? 0 }}</td>
                        <td class="text-right">{{ number_format($data->total_patient_paid, 2) }}</td>
                        <td class="text-right">{{ number_format($data->sur_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->procedure_amount, 2) }}</td>
                        <td class="text-right">{{ number_format($data->total_admission_no, 0) }}</td>
                        <td class="text-right">{{ number_format($visit_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($total_ipd_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->lab_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->rad_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($data->all_other_amt, 2) }}</td>
                        <td class="text-right">{{ number_format($gross_amt, 2) }}</td>
                    </tr>
                    @php
                        $all_total_appointment += $data->total_appointment;
                        $all_patient_free += $data->patient_free;
                        $all_total_patient_paid += $data->total_patient_paid;
                        $visit_amount += $visit_amt;
                        $all_sur_amt += $data->sur_amt;
                        $all_total_ipd_amt += $total_ipd_amt;
                        $all_lab_amt += $data->lab_amt;
                        $all_rad_amt += $data->rad_amt;
                        $all_other_amt += $data->all_other_amt;
                        $all_gross_amt += $gross_amt;
                        $total_admission_no += $data->total_admission_no;
                        $procedure_amount += $data->procedure_amount;
                    @endphp
                @endforeach

                <tr>
                    <td class="text-right" colspan="2"> <strong> Sub Total (External Doctors)</strong></td>
                    <td class="text-center"> <strong> {{ $all_total_appointment }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_sur_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($procedure_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($visit_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_rad_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
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
                    $total_no_of_patient_visit_count += $no_of_patient_visit_count;

                    $total_procedure_amount += $procedure_amount;
                @endphp

                <tr>
                    <td class="text-right" colspan="2"> <strong> Total</strong></td>
                    <td class="text-center"> <strong> {{ $total_all_total_appointment }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_total_patient_paid, 2) }}</strong>
                    </td>
                    <td class="text-right"> <strong> {{ number_format($total_all_sur_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_procedure_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong>{{ number_format($total_total_admission_no, 0) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_no_of_patient_visit_count, 0) }}</strong>
                    </td>
                    <td class="text-right"> <strong> {{ number_format($total_visit_amount, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_total_ipd_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_lab_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_rad_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_other_amt, 2) }}</strong></td>
                    <td class="text-right"> <strong> {{ number_format($total_all_gross_amt, 2) }}</strong></td>
                </tr>
            @endif

            @if (!isset($result) || (count($result['internal_doctors']) == 0 && count($result['external_doctors']) == 0))
                <tr>
                    <td colspan="14" class="text-center"><strong>No Data found</strong></td>
                </tr>
            @endif
        </tbody>
    </table>

    <table style="margin-top: 40px;border: 0px solid transparent; border-spacing: 30px;" cellspacing = "2">
        <thead>
            <tr>
                <th colspan="2" class="text-center"
                    style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;">
                    ( Department )</th>
            </tr>
        </thead>
    </table>

    <table style="margin-top: 40px;border: 0px solid transparent; border-spacing: 30px;" cellspacing = "2">
        <thead>
            <tr>
                <th colspan="2" class="text-center"
                    style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;">
                    Nurse Incharge</th>
                <th colspan="2" class="text-center"
                    style="border-top:1px dashed #333; border-bottom: 0px solid transparent;    border-right: 0px solid transparent;
        border-left: 0px solid transparent;">
                    Surgeon Incharge</th>
            </tr>
        </thead>
    </table>


</body>

</html>
<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
