<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Radiology Appointment Print</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            width: 80mm;
            margin: 0;
            padding: 10px;
            background-color: #fff;
        }

        .card {
            border: 2px solid #000;
            padding: 10px;
            background: #fff;
            color: #000;
        }

        header {
            text-align: center;
            margin-bottom: 10px;
        }

        .hospital-name {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }

        .hospital-address {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        .hospital-card {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        .barcode-container {
            margin-top: 10px;
            margin-bottom: 15px;
            text-align: center;
        }

        .barcode-container img {
            width: 100%;
            /* Set barcode width to 100% of its container */
            max-width: 100%;
            /* Ensures the image doesn’t overflow its container */
            height: auto;
            border: 1px solid #000;
            /* Optional: Add border around the barcode */
        }

        .barcode-code {
            margin-top: 5px;
            font-size: 14px;
            /* Adjust the font size if needed */
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table td {
            padding: 8px;
            border-bottom: 2px solid #000;
        }

        table td:first-child {
            font-weight: bold;
            color: #000;
            width: 35%;
        }

        .circle {
            font-size: 18px;
            line-height: 18px;
            height: 40px;
            width: 40px;
            border: 2px solid #000;
            text-align: center;
            border-radius: 50%;
            background: #f0f0f0;
            margin: 5px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer {
            margin-top: 10px;
            border-top: 2px solid #000;
            padding-top: 5px;
            text-align: left;
        }

        .footer td {
            padding: 5px;
            font-weight: bold;
            color: #000;
        }
    </style>
</head>

<body>

    <div class="card">
        <header>
            <div class="hospital-name">
                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
            </div>
            @if ($po_hospital_details->hospital_code != 'KBMH')
                {{-- <div class="hospital-address">
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </div> --}}
                <div class="hospital-card">Radiology Appointment Card</div>
            @endif
            <div class="barcode-container">
                <img src="data:image/png;base64, {{ $app_barcode }}" alt="Barcode" />
                <div class="barcode-code">{{ $appointment->invoice_code }}</div>
            </div>
        </header>

        <main>
            <section id="patient-info">
                <table>
                    <tr>
                        <td>Name</td>
                        <td>{{ !empty($appointment->patient_name) ? $appointment->patient_name : '' }}</td>
                        <td rowspan="5" class="circle">
                            {{ !empty($appointment->img_app_sl_no) ? $appointment->img_app_sl_no : '' }}</td>
                    </tr>
                    <tr>
                        <td>Patient. ID</td>
                        <td>{{ !empty($appointment->patient_code) ? $appointment->patient_code : '' }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ !empty($appointment->present_addr) ? $appointment->present_addr : '' }}</td>
                    </tr>
                    <tr>
                        <td>Room</td>
                        <td>{{ !empty($appointment->room_name) ? $appointment->room_name : '' }}</td>
                    </tr>
                    <tr>
                        <td>Inv.</td>
                        <td>{{ !empty($appointment->item_name) ? $appointment->item_name : '' }}</td>
                    </tr>
                </table>
            </section>

            <div class="footer">
                <table>
                    <tr>
                        <td>App. Date</td>
                        <td>
                            {{ !empty($appointment->img_app_dttm) ? date('d/m/Y', strtotime($appointment->img_app_dttm)) : '' }}
                            {{ !empty($appointment->shed_str_time) ? date('H:i A', strtotime($appointment->shed_str_time)) : '' }}
                        </td>
                    </tr>
                    <?php
                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                    $date = $dt->format('g:i A');
                    ?>
                    <tr>
                        <td>Print On</td>
                        <td>{{ $date }}</td>
                    </tr>
                </table>
            </div>
        </main>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };

        window.onafterprint = function() {
            window.close(); // Close the window after printing
        }
    </script>
</body>

</html>
