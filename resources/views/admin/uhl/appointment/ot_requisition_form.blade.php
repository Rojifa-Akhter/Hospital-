@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();

    $code = $po_hospital_details->hospital_code ?? '';
    $body_font_size = $code == 'GMC' ? 14 : 11;
    $footer_bottom = $code == 'GMC' ? 25 : 10;
    $signature_bottom = $code == 'GMC' ? 2.6 : 1.6;
    $body_top = $code == 'GMC' ? 3.8 : 3;
    $footer_border = $code == 'GMC' ? 'none' : '1px solid #000';

    $slot = $slot_details;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OT Requisition Form</title>
    <style>
        @page {
            margin: 0.8cm;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: {{ $body_font_size }}px;
            margin: {{ $body_top }}cm 0.5cm 2.5cm 0.5cm;
        }

        header,
        footer {
            position: fixed;
            left: 0.5cm;
            right: 0.5cm;
        }

        header {
            top: 0;
            height: 2.5cm;
            border-bottom: 1px solid #000;
            text-align: center;
        }

        footer {
            bottom: {{ $footer_bottom }}px;
            font-size: 9px;
            text-align: center;
            border-top: {{ $footer_border }};
            padding: 4px 0;
        }

        .hospital-name {
            font-size: 18px;
            font-weight: bold;
        }

        .hospital-details {
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .barcode-wrapper {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .barcode {
            width: 48%;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: #f8f8f8;
        }

        .barcode img {
            max-width: 120px;
        }

        .section-title {
            background-color: #f0f0f0;
            text-align: left;
            padding: 6px 10px;
            margin-top: 20px;
            font-weight: bold;
            font-size: 13px;
            border-left: 4px solid #007bff;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-size: 12px;
        }

        .info-table th {
            width: 20%;
            text-align: left;
            background-color: #f5f5f5;
        }

        .info-table tr:nth-child(even) {
            background-color: #fbfbfb;
        }

        .sig {
            text-align: center;
            margin-top: 50px;
        }

        .sig-line {
            display: inline-block;
            width: 200px;
            border-top: 1px solid #000;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <header>
        <div class="hospital-name">{{ $po_hospital_details->hospital_name }}</div>
        <div class="hospital-details">{{ $po_hospital_details->addrress1 }} | {{ $po_hospital_details->telephone1 }}
        </div>
    </header>

    <footer>
        Print Date: {{ now()->timezone('Asia/Dhaka')->format('d/m/Y h:i A') }} |
        Powered by H360 [NextGenIT]
    </footer>

    <main>
        <div class="title">OT Requisition Form</div>

        <div class="barcode-wrapper">
            <div class="barcode">
                <img src="data:image/png;base64,{{ $barcode_pat_no }}" alt="Patient Barcode">
                <div><strong>Patient Code:</strong> {{ $slot->patient_code }}</div>
            </div>
            @if ($slot->admission_uid)
                <div class="barcode">
                    <img src="data:image/png;base64,{{ $barcode_admission_no }}" alt="Admission Barcode">
                    <div><strong>Admission UID:</strong> {{ $slot->admission_uid }}</div>
                </div>
            @endif
        </div>

        <div class="section-title">Requisition Details</div>
        <table class="info-table">
            <tr>
                <th>OT Slot No</th>
                <td>{{ $slot->ot_slot_no_pk }}</td>
                <th>Availability</th>
                <td>{{ $slot->available_ind == '1' ? 'Available' : 'Booked' }}</td>
            </tr>
            <tr>
                <th>Slot SL</th>
                <td>{{ $slot->slot_sl ?? '-' }}</td>
                <th>Scheduled Date</th>
                <td>{{ \Carbon\Carbon::parse($slot->schedule_dt)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Start Time</th>
                <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                <th>End Time</th>
                <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>Patient Name</th>
                <td colspan="3">{{ $slot->patient_name }}</td>
            </tr>
            <tr>
                <th>Procedure/Surgery</th>
                <td colspan="3">{{ $slot->item_name }}</td>
            </tr>
        </table>
        @if (isset($admission))
            <div class="section-title">Admission Information</div>
            <table class="info-table">
                <tr>
                    <th>Admission UID</th>
                    <td>{{ $admission->admission_uid }}</td>
                    <th>Admission No</th>
                    <td>{{ $admission->admission_no_fk }}</td>
                </tr>
                <tr>
                    <th>Ward / Bed</th>
                    <td>{{ $admission->ward_name }} / {{ $admission->bed_name }}</td>
                    <th>Service Unit</th>
                    <td>{{ $admission->new_serivce_unit_name }}</td>
                </tr>
                <tr>
                    <th>Primary Doctor</th>
                    <td>{{ $admission->primary_doctor_name }}</td>
                    <th>Doctor ID</th>
                    <td>{{ $admission->primary_doctor_no_fk }}</td>
                </tr>
                <tr>
                    <th>Contact No</th>
                    <td>{{ $admission->contact_number }}</td>
                    <th>Accompanied By</th>
                    <td>{{ $admission->accompanied_by ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Age / Gender</th>
                    <td>{{ $admission->age }} / {{ $admission->gender_txt }}</td>
                    <th>OT Room</th>
                    <td>{{ $admission->room_name }}</td>
                </tr>
                {{-- <tr>
                    <th>Scheduled Date</th>
                    <td>{{ \Carbon\Carbon::parse($admission->schedule_dt)->format('d/m/Y') }}</td>
                    <th>Availability</th>
                    <td>{{ $admission->available_ind == '1' ? 'Available' : 'Booked' }}</td>
                </tr> --}}
                {{-- <tr>
                    <th>Start – End Time</th>
                    <td colspan="3">{{ \Carbon\Carbon::parse($admission->start_time)->format('h:i A') }} –
                        {{ \Carbon\Carbon::parse($admission->end_time)->format('h:i A') }}</td>
                </tr> --}}
                <tr>
                    <th>OT Req No</th>
                    <td>{{ $admission->ot_req_no_pk }}</td>
                    <th>Procedure/Item</th>
                    <td>{{ $admission->item_name }}</td>
                </tr>
            </table>
        @endif

        <div class="sig">
            <div class="sig-line"></div>
            <br>
            <strong>Surgeon Signature & Date</strong>
        </div>
    </main>

</body>

</html>
<script>
    window.onload = function() {
        window.print();
    };

    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
