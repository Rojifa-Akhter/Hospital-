<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ANAESTHETIC referral Report</title>
    <style>
        @page {
            margin-top: 2.8cm;
            margin-bottom: 2cm !important;
            margin-left: 1cm;
            margin-right: 0.8cm;
        }

        body {
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 1.5cm;
            font-size: 13px;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            color: #000000;
        }

        header {
            position: fixed;
            top: 0cm;
            text-align: center;
            height: 2.5cm;
            /* border-bottom: 1px solid; */
            width: 100%
                /* color: #007FD2; */
        }

        header h1 {
            font-size: 20px;
            margin: 5px 0;
            color: #003366;
        }

        header h4 {
            font-size: 14px;
            margin: 0;
            color: #555;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .section {
            margin: 20px 0;
        }

        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            font-size: 16px;
            margin-bottom: 10px;
            color: #003366;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .reply {
            margin-top: 30px;
        }

        .reply p {
            margin: 6px 0;
        }

        .signature {
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <header>
        {{-- <h1>{{ $po_hospital_details->hospital_name ?? 'Hospital Name' }}</h1> --}}
        <h4>ANAESTHETIC REFERRAL REPORT</h4>
    </header>

    <footer>
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp
        Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed By:
        {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]
    </footer>

    <main>
        <div class="section">
            <h2>Patient Information</h2>
            <table>
                <tr>
                    <th>Name of Patient</th>
                    <td>{{ $patient_info->patient_name ?? '' }}</td>
                    <th>UHID</th>
                    <td>{{ $patient_info->patient_code ?? '' }}</td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td>{{ $patient_info->pat_age ?? '' }}</td>
                    <th>Sex</th>
                    <td>{{ $patient_info->gender_txt ?? '' }}</td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td>{{ $patient_info->weight ?? '' }}</td>
                    <th>Date</th>
                    <td>{{ date('d/m/Y', strtotime($patient_info->reff_date)) }}  </td>
                </tr>
                <tr>
                    <th>Referring Doctor & Department</th>
                    <td colspan="3">Referred to Anesthesia Department</td>
                </tr>
                <tr>
                    <th>Diagnosis</th>
                    <td colspan="3">{{ $patient_info->diagnosis ?? '' }}</td>
                </tr>
                <tr>
                    <th>Positive Findings</th>
                    <td colspan="3">{{ $patient_info->positive_findings ?? '' }}</td>
                </tr>
                <tr>
                    <th>Planned Procedure with Date</th>
                    <td colspan="3">{{ $patient_info->plane_proc_withdate ?? '' }}</td>
                </tr>
                <tr>
                    <th>Estimated Duration of Surgery</th>
                    <td colspan="3">{{ $patient_info->estimated_duration_surge ?? '' }}</td>
                </tr>
                <tr>
                    <th>Specific Requirement / Remarks</th>
                    <td colspan="3">{{ $patient_info->specefic_req_n_remarks ?? '' }}</td>
                </tr>
                <tr>
                    <th>Signature</th>
                    <td colspan="3">{{ $patient_info->full_name ?? '' }}</td>
                </tr>
            </table>
        </div>

        <div class="section reply">
  <h2>Reply to Referring Doctor</h2>
  <p><strong>To:</strong> Dr. {{ $patient_info->full_name }}</p>

  <p>
    Thank you for your referral regarding the patient
    <strong>{{ $patient_info->patient_name }}</strong> (Patient ID:
    {{ $patient_info->patient_code }}).
  </p>

  @if(isset($patient_info->reply_type) && $patient_info->reply_type === 'REJECT')
    <p>
      After careful review, we regret to inform you that the patient is <strong>not fit</strong>
      for the planned procedure at this time.
      {{ $patient_info->reply_letter }}
    </p>
  @else
    <p>
      {{ $patient_info->reply_letter ?? 'After evaluation, the patient is found fit for the planned
      procedure...' }}
    </p>
  @endif

  <p>If you have any further questions or require additional information, please get in touch.</p>

  <br>
  <p>Thank you.</p>
  <p>Yours sincerely,</p>
  <p><strong>{{ $patient_info->andr_name }}</strong></p>
  <p><em>{{ $patient_info->dept }}</em></p>
</div>

    </main>

    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>

</body>

</html>
