<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Transfusion Order</title>
    <style>
        .border-left-0 { border-left: none !important; }
        .border-right-0 { border-right: none !important; }
        thead { background-color: white; }
        .fs-12 { font-size: 16px; }
        .table { border-collapse: collapse; width: 100%; }
        .table-bordered { border: 1px solid #333; }
        td, th { font-size: 15px; border: 1px solid #333; padding: 6px; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .header>tbody>tr>td, .header>thead>tr>td { border: none; }
        body { margin-bottom: 0.6cm; margin-left: 1cm; }
        .footer-table { position: bottom; bottom: 0px; width: 95%; margin-top: 10px; }
        td { page-break-inside: avoid }
    </style>
</head>

<body onload="window.print()">

    {{-- Header Section --}}
    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP No:</b> {{ $admission_info->admission_no_pk ?? '' }}</li>
                        <li><img src="data:image/png;base64, {{ $invoice_barcode ?? '' }}"></li>
                        <li>
                            <b>Name:</b> {{ $patient_info->patient_name ?? '' }} &nbsp;
                            <b>Age:</b> {{ $patient_info->age ?? '' }} &nbsp;
                            <b>Gender:</b> {{ $patient_info->gender_txt ?? '' }} &nbsp;
                            <b>Bed:</b> {{ $admission_info->bed_name ?? '' }}
                        </li>
                        <li><b>Con. Number:</b> {{ $patient_info->mobile1 ?? '' }}</li>
                        <li><b>Consultant Name:</b> {{ $admission_info->primary_doctor_name ?? '' }}</li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b> {{ $patient_info->patient_code ?? '' }}</li>
                        <li><img src="data:image/png;base64, {{ $pat_barcode ?? '' }}"></li>
                        <li><b>Phone:</b> {{ $patient_info->mobile1 ?? '' }}</li>
                        <li><b>IP Date:</b> {{ date('d/m/Y h:i a', strtotime($admission_info->admission_date ?? now())) }}</li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of Discharge:</b> {{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</li>
                        @endif
                    </ul>
                </td>
            </tr>
        </thead>
    </table>

    <table class="table table-bordered">
        <tr>
            <th colspan="6" class="text-center">BLOOD TRANSFUSION ORDER</th>
        </tr>

        {{-- Basic Info --}}
        <tr>
            <td colspan="6">
                <label for="">(To be filled In by Physician) </label> <br>
                <b>Blood group & Rh type:</b> {{ $order_form->blood_group ?? '' }} <br>
                <b>Blood bag Number:</b> {{ $order_form->blood_bag_number ?? '' }} <br>
                <b>Component:</b> {{ $order_form->component ?? '' }} <br>
                <b>Date & Time of Collection:</b> {{ !empty($order_form->collection_datetime) ? date('d/m/Y h:i a', strtotime($order_form->collection_datetime)) : '' }} <br>
                <b>Date & Time of Transfusion:</b> {{ !empty($order_form->transfusion_datetime) ? date('d/m/Y h:i a', strtotime($order_form->transfusion_datetime)) : '' }} <br>
                <b>Expiry Date:</b> {{ !empty($order_form->expiry_date) ? date('d/m/Y', strtotime($order_form->expiry_date)) : '' }} <br>
            </td>
        </tr>

        {{-- Instruction --}}
        <tr>
            <td colspan="6">
                <p>
                    Please transfuse 1 unit of PRBC / Whole blood / FFP / Platelet / Cryoprecipitate I/V at the rate of 10-15 drops/min & watch for 15 minutes for any hypersensitivity reaction.
                    If no transfusion reaction occurs then transfuse at 25 drops/min & continue till end.
                </p>
            </td>
        </tr>

        {{-- Blood Components Table --}}
        <tr>
            <th colspan="2">Blood or blood component</th>
            <th colspan="2">Start Transfusion</th>
            <th colspan="2">Complete Transfusion</th>
        </tr>
        <tr><td colspan="2">Whole Blood</td><td colspan="2">Within 30 minutes</td><td colspan="2">Within 4 Hours</td></tr>
        <tr><td colspan="2">Red Cell</td><td colspan="2">Within 30 minutes</td><td colspan="2">Within 4 Hours</td></tr>
        <tr><td colspan="2">Platelet Concentrate</td><td colspan="2">Immediately</td><td colspan="2">Within 20 minutes</td></tr>
        <tr><td colspan="2">Fresh Frozen Plasma</td><td colspan="2">Immediately</td><td colspan="2">Within 20 minutes</td></tr>
        <tr><td colspan="2">Cryoprecipitate</td><td colspan="2">Immediately</td><td colspan="2">Within 20 minutes</td></tr>

        {{-- Reaction Instructions --}}
        <tr>
            <td colspan="6">
                <p>
                    Please look for symptoms and signs of transfusion reaction (chills, fever, respiratory distress, chest pain, back pain, nausea, rash, itching, hematuria).
                </p>
                <p>
                    If any adverse event develops during transfusion:
                    <ol>
                        <li>Stop transfusion</li>
                        <li>Follow SOS order in MAR</li>
                        <li>Inform duty doctor</li>
                        <li>Maintain venous access with new set + 0.9% NS (don’t discard old set, don’t flush original line)</li>
                        <li>Monitor & record vitals</li>
                        <li>Report event as per guidelines</li>
                    </ol>
                </p>
            </td>
        </tr>

        {{-- Doctor Details --}}
        <tr>
            <th>Doctor</th>
            <th>Name</th>
            <th>Signature</th>
            <th>Emp. ID</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <tr>
            <td></td>
            <td>{{ $order_form->doctor_name ?? '' }}</td>
            <td>{{ $order_form->doctor_signature ?? '' }}</td>
            <td>{{ $order_form->doctor_emp_id ?? '' }}</td>
            <td>{{ !empty($order_form->doctor_date) ? date('d/m/Y', strtotime($order_form->doctor_date)) : '' }}</td>
            <td>{{ $order_form->doctor_time ?? '' }}</td>
        </tr>
    </table>

    {{-- Footer --}}
    <section class="footer-table">
        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">
                        <strong>Staff ID:</strong> {{ $userInfo->user_code ?? '' }},
                        <strong>Printing Date & Time:</strong> {{ date('d/m/Y h:ia') }}
                    </td>
                    <td style="text-align:right;border:none;width:30%">
                        <strong>Powered By: NEXTGEN IT</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

</body>
</html>
