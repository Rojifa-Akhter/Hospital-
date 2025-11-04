<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            margin-top: 3cm;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 10px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            border-top: 2px solid #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #222;
            padding: 8px;
            text-align: left;
            width: 50%;
        }

        th {
            background-color: #f2f2f2;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }

        .section {
            margin-bottom: 30px;
        }

        .note {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <header>
        <h1>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
        <div>
            <h4>ANAESTHETIC REFERRAL REPORT</h4>
            {{ date('d/m/Y') }}
        </div>
    </header>

    <footer>
        Page Footer
    </footer>

    <div class="section">
        <strong>Patient Information</strong><br>
        <table>
            <tr>
                <td><strong>Name of Patient:</strong>
                    {{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}</td>
                <td><strong>Patient ID:</strong>
                    {{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}</td>
            </tr>
            <tr>
                <td><strong>Age:</strong> {{ isset($pat_info->age) ? $pat_info->age : '' }}</td>
                <td><strong>Sex:</strong> {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Weight:</strong> {{ isset($reffered_info->weight) ? $reffered_info->weight : '' }}</td>
                {{-- <td><strong>Department:</strong>
                    {{ isset($reffered_info->admitted_department) ? $reffered_info->admitted_department : '' }}</td> --}}
            </tr>
            {{-- <tr>
                <td><strong>Ward:</strong> {{ isset($reffered_info->ward_name) ? $reffered_info->ward_name : '' }}</td>
                <td><strong>Bed:</strong> {{ isset($reffered_info->bed_name) ? $reffered_info->bed_name : '' }}</td>
            </tr> --}}
            <tr>
                <td><strong>Date:</strong>
                    {{ isset($reffered_info->ot_planned_date) ? date('d/m/Y', strtotime($reffered_info->ot_planned_date)) : '' }}</td>
                <td><strong>Name of Treating Doctor:</strong>
                    {{ isset($reffered_info->ot_referred_doctor) ? $reffered_info->ot_referred_doctor : '' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Purpose Of Referral:</strong>
                    {{ isset($reffered_info->purpose_of_referral) ? $reffered_info->purpose_of_referral : '' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>History:</strong> <?php echo isset($reffered_info->history) ? $reffered_info->history : ''; ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Positive Findings:</strong> <?php echo isset($reffered_info->positive_findings) ? $reffered_info->positive_findings : ''; ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Diagnosis:</strong> <?php echo isset($reffered_info->diagnosis) ? $reffered_info->diagnosis : ''; ?></td>
            </tr>
            <tr>
                <td><strong>Operation Planned:</strong>
                    {{ isset($reffered_info->ot_planned) ? $reffered_info->ot_planned : '' }}</td>
                <td><strong>Date of Operation Planned:</strong>
                    {{ isset($reffered_info->ot_planned_date) ? date('d/m/Y', strtotime($reffered_info->ot_planned_date)) : '' }}
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Signature:</strong> <?php // Add signature logic here
                ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h1>
            <strong>Reply to Referring Doctor</strong>
        </h1><br>

        <p>Dear Dr. [Doctor's Name],</p>
        <p><?php echo isset($reffered_info->doc_reply_text) ? $reffered_info->doc_reply_text : 'Thank you for the referral.'; ?>
        </p>
        <p>Thank you.</p>
        <p>Yours sincerely,</p>
        <p>[Your Name]<br>[Your Position]<br>[Your Contact Information]</p>
    </div>

    {{-- Uncomment below to enable print functionality --}}
    <script>
        window.print();
        window.onafterprint = function() {
            window.close(); // Close the window after printing
        }
    </script>
</body>

</html>
