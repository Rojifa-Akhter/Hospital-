<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Radiology Appointment Print</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #000;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        header,
        footer {
            position: fixed;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
            line-height: 1.5cm;
        }

        header {
            top: 0;
        }

        footer {
            bottom: 0;
            font-size: 10px;
        }

        main {
            margin-top: 3cm;
            margin-bottom: 2cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }

        .serial-number {
            background-color: #f0f8ff;
            /* Light blue background */
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <header>
        <strong>{{ $hospital->hospital_name ?? 'Hospital Name' }}</strong><br>
        Address: {{ $hospital->addrress1 ?? 'Address' }} | Phone: {{ $hospital->telephone1 ?? 'Phone' }}
    </header>

    <footer>
        Printed by: {{ Session::get('user.ses_user_name') }} |
        Printing Date & Time: {{ now()->format('d/m/Y h:i a') }} |
        Powered by: NEXTGEN IT
    </footer>

    <main>
        <table>
            <tr>
                <td colspan="2" class="serial-number">
                    Serial No: {{ (int) $appointment->radt_app_sl ?? '' }}
                </td>
            </tr>
            <tr>
                <td><strong>Patient Name:</strong></td>
                <td>{{ $appointment->patient_name ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>UHID:</strong></td>
                <td>{{ $appointment->patient_code ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Room:</strong></td>
                <td>{{ $appointment->room_name ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Investigation:</strong></td>
                <td>{{ $appointment->item_name ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Appointment Date:</strong></td>
                <td>{{ isset($appointment->appoint_date) ? \Carbon\Carbon::parse($appointment->appoint_date)->format('d/m/Y') : '' }}
                </td>
            </tr>
            <tr>
                <td><strong>Start Time:</strong></td>
                <td>{{ isset($appointment->shed_str_time) ? \Carbon\Carbon::parse($appointment->shed_str_time)->format('h:i A') : '' }}
                </td>
            </tr>
            <tr>
                <td><strong>End Time:</strong></td>
                <td>{{ isset($appointment->shed_end_time) ? \Carbon\Carbon::parse($appointment->shed_end_time)->format('h:i A') : '' }}
                </td>
            </tr>
            <tr>
                <td><strong>Pre-Requisition:</strong></td>
                <td>{{ $appointment->pre_requisition ?? '' }}</td>
            </tr>
        </table>
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
