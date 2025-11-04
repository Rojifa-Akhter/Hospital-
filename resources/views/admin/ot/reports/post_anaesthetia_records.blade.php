<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Post Anaesthesia Records">
    <title>POST ANAESTHETIA RECORDS</title>
    <style>
        @page {
            margin: .5cm .6cm;
        }

        body {
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 10px;
            margin: 0.5cm 0.3cm 2cm 0.3cm;
        }

        /* Add space between list items */
        ol li {
            margin-bottom: 10px; /* Adjust space as needed */
            font-size: 16px;
            padding-left: 5px; /* Optional: Add some padding for better readability */
        }

        /* Ensure strong text is bold */
        h2 {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="Hospital Logo">
                </td>
                <td style="text-align:center; border:none;">
                    <span style="font-size: 15px;"><strong>{{ $po_hospital_details->hospital_name ?? '' }}</strong></span><br>
                    Address: <span>{{ $po_hospital_details->addrress1 ?? '' }}</span><br>
                    Phone No: <span>{{ $po_hospital_details->telephone1 ?? '' }}</span>
                </td>
                <td style="text-align:right; width: 15%; border:none;">
                    <img src="data:image/png;base64, {{ $barcode_no }}" width="100" alt="Barcode">
                </td>
            </tr>
        </table>
    </header>

    <div style="text-align: center; padding: 5px;">
        <h2>POST ANAESTHETIA RECORDS</h2>
    </div>

    <ol>
        <li><strong>Position:</strong> Supine / Lateral- Right or left / Head Elevated / Others</li>
        <li><strong>Oxygen:</strong> (Nasal canula/Mask/Others): Flow @ L/min till ………hr</li>
        <li><strong>Nothing per oral (NPO):</strong> till……….hr</li>
        <li><strong>Monitor:</strong> Pulse, Blood pressure, Respiratory rate, SpO2, Temp, Surgical drain (if any), Nasogastric suction (if any), Sanitary pad (if any) at intervals.</li>
        <li><strong>Record:</strong> Vital signs at 1-hour intervals.</li>
        <li><strong>Care of anesthetized area.</strong></li>
        <li><strong>Encourage change of posture as soon as possible.</strong></li>
        <li><strong>Analgesia:</strong></li>
        <li><strong>Fluid:</strong></li>
        <li><strong>Special Instructions:</strong></li>
        <li><strong>Shift to:</strong> Cabin / Ward / Post-operative ward / HDU / ICU / Discharge</li>
        <li><strong>Anesthesiologists:</strong></li>
        <li><strong>Surgeons:</strong> Date:</li>
    </ol>

    <footer>
        <div class="signature_">
            <!-- Signature details can go here -->
        </div>
    </footer>

    <script>
        window.print();
        window.onafterprint = function () {
            window.close(); // Close the window after printing
        };
    </script>
</body>
</html>
