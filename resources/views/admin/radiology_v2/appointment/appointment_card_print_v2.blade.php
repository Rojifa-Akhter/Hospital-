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

        .serial-number-bar {
            width: 100%;
            height: 20px;
            background-color: #f0f8ff; /* Light blue background */
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            line-height: 20px;
            border: 1px solid #000;
            margin-bottom: 10px;
        }

        .barcode-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .barcode-container img {
            max-width: 100%;
            height: auto;
        }

        .barcode-code {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }

        td:first-child {
            font-weight: bold;
            width: 30%;
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
        <div class="serial-number-bar">
            Serial No: {{ (int) $appointment->radt_app_sl ?? '' }}
        </div>

        <div class="barcode-container">
            <img src="data:image/png;base64, {{ $app_barcode }}" alt="Barcode" />
            <div class="barcode-code">{{ $invoice_data->invoice_code ?? '' }}</div>
        </div>

        <table>
            <tr>
                <td>Invoice ID:</td>
                <td>{{ $invoice_data->invoice_code ?? '' }}</td>
            </tr>
            <tr>
                <td>Address:</td>
                <td>{{ !empty($invoice_data->present_addr) ? $invoice_data->present_addr : '' }}</td>
            </tr>
            <tr>
                <td>Patient Name:</td>
                <td>{{ $appointment->patient_name ?? '' }}</td>
            </tr>
            <tr>
                <td>UHID:</td>
                <td>{{ $appointment->patient_code ?? '' }}</td>
            </tr>
            <tr>
                <td>Room:</td>
                <td>{{ $appointment->room_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Investigation:</td>
                <td>{{ $appointment->item_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Appointment Date:</td>
                <td>{{ isset($appointment->appoint_date) ? \Carbon\Carbon::parse($appointment->appoint_date)->format('d/m/Y') : '' }}</td>
            </tr>
            <tr>
                <td>Start Time:</td>
                <td>{{ isset($appointment->shed_str_time) ? \Carbon\Carbon::parse($appointment->shed_str_time)->format('h:i A') : '' }}</td>
            </tr>
            <tr>
                <td>End Time:</td>
                <td>{{ isset($appointment->shed_end_time) ? \Carbon\Carbon::parse($appointment->shed_end_time)->format('h:i A') : '' }}</td>
            </tr>
            <tr>
                <td>Pre-Requisition:</td>
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