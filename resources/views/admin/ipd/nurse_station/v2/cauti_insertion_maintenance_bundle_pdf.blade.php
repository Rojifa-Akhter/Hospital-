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

    {{-- CAUTI Form Table --}}
    <table class="table table-bordered">
        <tr>
            <th colspan="14" class="text-center">CAUTI Insertion & Maintenance Bundle</th>
        </tr>
        <tr>
            <th>Diagnosis</th>
            <td colspan="5" class="text-left">{{ $form->diagnosis ?? '' }}</td>
            <th>Location & Inserted By</th>
            <td colspan="5" class="text-left">{{ $form->location_inserted_by ?? '' }}</td>
        </tr>
        <tr>
            <th>FC Inserted On</th>
            <td colspan="5" class="text-left">{{ $form->fc_inserted_on ?? '' }}</td>
            <th>Indication on Insert</th>
            <td colspan="5" class="text-left">{{ $form->indication_on_insert ?? '' }}</td>
        </tr>
        <tr>
            <th>FC Removed On</th>
            <td colspan="5" class="text-left">{{ $form->fc_removed_on ?? '' }}</td>
            <th>Indication on Remove</th>
            <td colspan="5" class="text-left">{{ $form->indication_on_remove ?? '' }}</td>
        </tr>
    </table>

    <table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="border:1px solid #333;">Justification for urinary catheter insertion is documented</th>
            <th style="border:1px solid #333;">Use complete PPE Including gown for insertion</th>
            <th style="border:1px solid #333;">Aseptic Technique maintained</th>
            <th style="border:1px solid #333;">Closed drainage system with sampling port used</th>
            <th style="border:1px solid #333;">Drainage bag above floor below bladder</th>
            <th style="border:1px solid #333;">Catheter and tube kink-free</th>
            <th style="border:1px solid #333;">Catheter secured in inner thigh</th>
            <th style="border:1px solid #333;">Performed meatal hygiene daily / SOS</th>
            <th style="border:1px solid #333;">Urinary bag &lt; 2/3rd filled</th>
            <th style="border:1px solid #333;">Sample obtained after cleaning port</th>
            <th style="border:1px solid #333;">Sign of Assigned Staff with Emp ID</th>
            <th style="border:1px solid #333;">Verified by Emp ID</th>
            <th style="border:1px solid #333;">Remarks</th>
        </tr>
    </thead>
    <tbody>
        @php
            $rows_count = max(
                count(explode(',', $form->row1_status ?? '')),
                count(explode(',', $form->row2_status ?? '')),
                1
            );
        @endphp
        @for($i=0; $i<$rows_count; $i++)
            <tr>
                @for($j=1; $j<=10; $j++)
                    @php
                        $status_array = !empty($form->{'row'.$j.'_status'}) ? explode(',', $form->{'row'.$j.'_status'}) : [];
                    @endphp
                    <td style="border:1px solid #333;">{{ $status_array[$i] ?? '' }}</td>
                @endfor
                <td style="border:1px solid #333;">{{ $form->row11_text ?? '' }}</td>
                <td style="border:1px solid #333;">{{ $form->row12_text ?? '' }}</td>
                <td style="border:1px solid #333;">{{ $form->remarks ?? '' }}</td>
            </tr>
        @endfor
    </tbody>
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
