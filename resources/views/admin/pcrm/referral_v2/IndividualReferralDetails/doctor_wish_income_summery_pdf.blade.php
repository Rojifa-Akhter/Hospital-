
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
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
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
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>



    @if($print_type == 'PDF')
        <header>
            <table style="width: 100%; border:none;" class="signature">
                <tr>
                    <td style="width: 15%; border:none;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
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
        </header>

        <div class="signature_">
            <table style="width: 100%; border:none;">
                <tr style=" ">
                    <td style="text-align:left; border:none;">
                        <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                        </span>
                    </td>
                    <td style="text-align:right; border:none;">
                        <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                    </td>
                </tr>
            </table>
        </div>

        <footer style="position: fixed;">
            <div class="footer">
                <div class="container">
                    <table style="width: 100%; padding:3px; margin: 0;border:none;">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>

                        </tr>
                    </table>
                </div>
            </div>
        </footer>
    @endif




                    <div style="text-align: center; padding:5px">
                        <strong> Doctor Wise Income Summary </strong>
                    </div>
                    <table width="100%">
                        <tbody>
                            <tr>
                                @if ($from_date != '' && $to_date != '')
                                    <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                                    <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                                        </strong> : {{ $to_date }}</td>
                                @elseif ($from_date != '')
                                    <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                                    <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>



                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th class="text-center">SL#</th>
                                <th class="text-center" width='150px'>Name</th>
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
                                <th class="text-right">Share Amount(%)</th>
                            </tr>


                        </thead>
                        <tbody>
                            @if (!empty($doctor_income))
                                @php
                                    $all_total_appointment = 0;
                                    $all_patient_new_paid = 0;
                                    $all_patient_free = 0;
                                    $all_patient_followup_free = 0;
                                    $all_total_patient_paid = 0;
                                    $all_sur_amt_count = 0;
                                    $all_sur_amt = 0;
                                    $all_ipd_service_amt_count = 0;
                                    $all_ipd_service_amt = 0;
                                    $all_total_ipd_amt = 0;
                                    $all_lab_amt = 0;
                                    $all_rad_amt = 0;
                                    $all_other_amt = 0;
                                    $all_gross_amt = 0;
                                    $no_of_patient_visit_count = 0;
                                    $visit_amount = 0;
                                    $total_admission_no = 0;
                                    $pathology_amt_count = 0;
                                    $radiology_amt_count = 0;
                                    $total_share_amt = 0;
                                    $prcedure_amout_count = 0;
                                    $procedure_amount = 0;
                                    $sl = 1;
                                @endphp

                                @foreach($doctor_income as $data)
                                    @php
                                        $visit_amt = ($data->ipd_docvisit_amt ?? 0) - ($data->ipd_docvisit_discount ?? 0);
                                        $total_ipd_amt = floatVal($visit_amt) + floatVal($data->ipd_service_amt) - floatVal($data->ipd_discount_amt);
                                        $gross_amt = ($data->total_patient_paid ?? 0) + ($data->procedure_amount ?? 0) + ($data->sur_amt ?? 0) + $total_ipd_amt + ($data->lab_amt ?? 0) + ($data->rad_amt ?? 0) + ($data->all_other_amt ?? 0) - ($data->rad_discount_amt ?? 0) - ($data->lab_discount_amt ?? 0) - ($data->others_discount_amt ?? 0) - ($data->sur_discount_amt ?? 0) - ($data->procedure_amout_discount ?? 0);
                                    @endphp
                                    <tr>
                                        <td style="text-align:center">{{ $sl++ }}</td>
                                        <td style="text-align:left" width="5%">{{ $data->full_name }}</td>
                                        <td style="text-align:center">{{ $data->total_appointment ?? 0 }}</td>
                                        <td style="text-align:center">{{ $data->patient_new_paid ?? 0 }}</td>
                                        <td style="text-align:center">{{ $data->patient_followup_free ?? 0 }}</td>
                                        <td style="text-align:center">{{ $data->patient_free ?? 0 }}</td>
                                        <td style="text-align:right">{{ number_format($data->total_patient_paid, 2) }}</td>
                                        <td style="text-align:center">{{ number_format($data->sur_amt_count, 0) }}</td>
                                        <td style="text-align:right">{{ number_format($data->sur_amt - $data->sur_discount_amt, 2) }}</td>
                                        <td style="text-align:center"> {{ number_format($data->prcedure_amout_count, 0) }}</td>
                                        <td style="text-align:right">{{ number_format($data->procedure_amount - $data->procedure_amout_discount, 2) }}</td>
                                        <td class="text-center" style="text-align:center"> {{ number_format($data->total_admission_no, 0) }}</td>
                                        <td class="text-center" style="text-align:center">{{ $data->ipd_docvisit_amt_count ?? 0 }}</td>
                                        <td style="text-align:right">{{ number_format($visit_amt, 2) }}</td>
                                        <td style="text-align:right">{{ number_format($total_ipd_amt, 2) }}</td>
                                        <td class="text-right" style="text-align:center"> {{ number_format($data->pathology_amt_count, 0) }}</td>
                                        <td style="text-align:right"> {{ number_format($data->lab_amt - $data->lab_discount_amt, 2) }}</td>
                                        <td class="text-center" style="text-align:center"> {{ number_format($data->radiology_amt_count, 0) }}</td>
                                        <td style="text-align:right">{{ number_format($data->rad_amt - $data->rad_discount_amt, 2) }}</td>
                                        <td style="text-align:right"> {{ number_format($data->all_other_amt - $data->others_discount_amt, 2) }}</td>
                                        <td style="text-align:right">{{ number_format($gross_amt, 2) }}</td>
                                        @php
                                            $pr_amount = ($percentage * $gross_amt) / 100;
                                        @endphp
                                        <td style="text-align:right">{{ number_format($pr_amount, 2) }}</td>
                                    </tr>
                                    @php
                                        $all_total_appointment += $data->total_appointment;
                                        $all_patient_new_paid += $data->patient_new_paid;
                                        $all_patient_free += $data->patient_free;
                                        $all_patient_followup_free += $data->patient_followup_free;
                                        $all_total_patient_paid += $data->total_patient_paid;
                                        $all_sur_amt_count += $data->sur_amt_count;
                                        $all_sur_amt += $data->sur_amt - ($data->sur_discount_amt ?? 0);
                                        $all_ipd_service_amt_count += $data->ipd_service_amt_count;
                                        $all_ipd_service_amt += $data->ipd_service_amt - ($data->ipd_discount_amt ?? 0);
                                        $all_total_ipd_amt += $total_ipd_amt;
                                        $visit_amount += $visit_amt;
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
                                        $total_share_amt += $pr_amount;
                                    @endphp
                                @endforeach

                                <tr>
                                    <td style="text-align:right" colspan="2"> <strong> Total</strong></td>
                                    <td style="text-align:center"> <strong> {{ $all_total_appointment }}</strong></td>
                                    <td style="text-align:center"> <strong> {{ $all_patient_new_paid }}</strong></td>
                                    <td style="text-align:center"> <strong>{{ $all_patient_followup_free }}</strong></td>
                                    <td style="text-align:center"> <strong> {{ $all_patient_free }}</strong></td>
                                    <td style="text-align:right"> <strong> {{ number_format($all_total_patient_paid, 2) }}</strong></td>
                                    <td style="text-align:center"> <strong>{{ number_format($all_sur_amt_count, 0) }}</strong></td>
                                    <td style="text-align:right"> <strong>{{ number_format($all_sur_amt, 2) }}</strong></td>
                                    <td style="text-align:center"> <strong>{{ number_format($prcedure_amout_count, 0) }}</strong></td>
                                    <td style="text-align:right"> <strong>{{ number_format($procedure_amount, 2) }}</strong></td>
                                    <td class="text-center" style="text-align:center"> <strong>{{ number_format($total_admission_no, 0) }}</strong></td>
                                    <td style="text-align:center"> <strong>{{ number_format($no_of_patient_visit_count, 0) }}</strong></td>
                                    <td style="text-align:left"> <strong>{{ number_format($visit_amount, 2) }}</strong></td>
                                    <td style="text-align:right"> <strong>{{ number_format($all_total_ipd_amt, 2) }}</strong></td>
                                    <td class="text-center" style="text-align:center"> <strong>{{ number_format($pathology_amt_count, 0) }}</strong></td>
                                    <td style="text-align:right"> <strong> {{ number_format($all_lab_amt, 2) }}</strong></td>
                                    <td class="text-right" style="text-align:center"><strong>{{ number_format($radiology_amt_count, 0) }}</strong> </td>
                                    <td style="text-align:right"> <strong>{{ number_format($all_rad_amt, 2) }}</strong></td>
                                    <td style="text-align:right"> <strong> {{ number_format($all_other_amt, 2) }}</strong></td>
                                    <td style="text-align:right"> <strong> {{ number_format($all_gross_amt, 2) }}</strong></td>
                                    <td style="text-align:right"> <strong> {{ number_format($total_share_amt, 2) }}</strong></td>
                                </tr>
                            @endif

                        </tbody>

                    </table>

