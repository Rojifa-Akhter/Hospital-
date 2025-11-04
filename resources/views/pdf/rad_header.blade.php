<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            margin: 0;
            padding: 0;
        }
        .header-table, .patient-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo {
            width: 70px;
        }
        .barcode-img {
            width: 120px;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        .info-table td {
            padding: 2px 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Top Header: Hospital Logo & Info -->
    <table class="header-table">
        <!-- <tr>
            <td width="20%">
                @if(isset($po_hospital_details->logo))
                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" class="header-logo" />
                @endif
            </td>
            <td style="text-align:center;">
                <strong>{{ $po_hospital_details->hospital_name ?? '' }}</strong><br>
                {{ $po_hospital_details->addrress1 ?? '' }}<br>
                Phone: {{ $po_hospital_details->telephone1 ?? '' }}
            </td>
            <td width="20%"></td>
        </tr> -->
    </table>

    <!-- Patient Info Section -->
    <div class="patient-info" style="margin-top:10px;">
        <table class="patient-info-table">
            <tr>
                <td width="30%">
                    <div><img class="barcode-img" src="data:image/png;base64,{{ $app_barcode }}" /></div>
                    <div><strong>Report ID:</strong> {{ $radiology_appointment_data->rad_report_no_pk }}</div>
                </td>
                <td style="text-align:center;">
                    <h2 class="section-title">{{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT</h2>
                </td>
                <td width="30%" style="text-align:right;">
                    <div><img class="barcode-img" src="data:image/png;base64,{{ $invoice_barcode }}" /></div>
                    <div><strong>Invoice ID:</strong> {{ $radiology_appointment_data->invoice_code }}</div>
                </td>
            </tr>
        </table>

        <table class="info-table" style="width:100%; border:1px solid #999; border-radius:10px;">
            <tr>
                <td><strong>Patient Name</strong></td>
                <td>:</td>
                <td>{{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }} {{ $patient_info->patient_name ?? '' }}</td>
                <td><strong>Patient ID</strong></td>
                <td>:</td>
                <td>{{ $radiology_appointment_data->patient_no_fk ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Age</strong></td>
                <td>:</td>
                <td>{{ $patient_info->pat_age ?? '' }}</td>
                <td><strong>Accession ID</strong></td>
                <td>:</td>
                <td>{{ $radiology_appointment_data->accession_id ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Gender</strong></td>
                <td>:</td>
                <td>{{ $patient_info->gender_txt ?? '' }}</td>
                <td><strong>Report Date</strong></td>
                <td>:</td>
                <td>{{ !empty($radiology_appointment_data->finalize_keyed_time) ? date('d/m/Y H:i A', strtotime($radiology_appointment_data->finalize_keyed_time)) : 'Not Finalized Yet' }}</td>
            </tr>
            <tr>
                <td><strong>Ref By</strong></td>
                <td>:</td>
                <td colspan="4">{{ $radiology_appointment_data->ref_doc_name ?? '' }}</td>
            </tr>
            @if (!empty($patient_info->passport_no))
            <tr>
                <td><strong>Passport No</strong></td>
                <td>:</td>
                <td colspan="4">{{ $patient_info->passport_no ?? '' }}</td>
            </tr>
            @endif
        </table>
    </div>
</body>
</html>
