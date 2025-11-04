<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ANAESTHETIC Referral Report</title>
    <style>
        @page {
            margin: 2.8cm 0.8cm 2cm 1cm;
        }

        body {
            margin: 0.5cm;
            font-size: 13px;
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            text-align: center;
            height: 2.5cm;
            width: 100%;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ccc;
            background: #f9f9f9;
        }

        .section {
            margin: 20px 0;
        }

        .section h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            font-size: 16px;
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
            background: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <header>
        <h4>OT Booking Information</h4>
    </header>
    <footer>
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $time = $dt->format('g:i A');
        @endphp
        Printing Date: {{ date('d/m/Y H:i A') }}, {{ $time }}, Printed By: {{ Session::get('user.ses_user_name') }} ,
        Powered By – [NextGen]
    </footer>

    <main>
        <div class="section">
            <h2>Patient & Referral Details</h2>
            <table>
                <tr>
                    <th>Patient Name</th>
                    <td>{{ $patient_info->patient_name }}</td>
                    <th>UHID</th>
                    <td>{{ $patient_info->patient_code }}</td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td>{{ $patient_info->pat_age }}</td>
                    <th>Sex</th>
                    <td>{{ $patient_info->gender_txt }}</td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td>{{ $patient_info->weight }}</td>
                    <th>Date</th>
                    <td>{{ optional($patient_info)->reff_date ? date('d/m/Y H:i A', strtotime($patient_info->reff_date)) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Diagnosis</th>
                    <td colspan="3">{{ $booking_details->diagnosis }}</td>
                </tr>
                <tr>
                    <th>Purpose of Referral</th>
                    <td colspan="3">{{ $booking_details->purpose_off_reff }}</td>
                </tr>
                <tr>
                    <th>Estimated Duration</th>
                    <td colspan="3">{{ $booking_details->estimated_duration_surge }}</td>
                </tr>
                <tr>
                    <th>Specific Requirements</th>
                    <td colspan="3">{{ $booking_details->specefic_req_n_remarks }}</td>
                </tr>
                <tr>
                    <th>Referral Dept.</th>
                    <td colspan="3">{{ $booking_details->req_dept_name }}</td>
                </tr>
                <tr>
                    <th>Urgency</th>
                    <td colspan="3">{{ $booking_details->urgency_details }}</td>
                </tr>
                <tr>
                    <th>Surgeon</th>
                    <td>{{ $booking_details->surgen_name }}</td>
                    <th>Nurse</th>
                    <td>{{ $booking_details->nurse_name }}</td>
                </tr>
                <tr>
                    <th>Requested By</th>
                    <td colspan="3">{{ $booking_details->user_name }} on
                        {{ $booking_details->req_given_date ? date('d/m/Y H:i A', strtotime($booking_details->req_given_date)) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Reff Date</th>
                    <td colspan="3">
                        {{ $booking_details->reff_date ? date('d/m/Y H:i A', strtotime($booking_details->reff_date)) : '' }}
                    </td>
                </tr>
                <tr>
                    <th>Available?</th>
                    <td colspan="3">{{ $booking_details->available_ind ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>OT Slot Details</h2>
            <table>
                <tr>
                    <th>Shift No.</th>
                    <td>{{ $slot_details->shift_no ?? 'N/A' }}</td>
                    <th>Slot SL</th>
                    <td>{{ $slot_details->slot_sl ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Start Time</th>
                    <td>{{ $slot_details->start_time ? date('h:i A', strtotime($slot_details->start_time)) : 'N/A' }}
                    </td>
                    <th>End Time</th>
                    <td>{{ $slot_details->end_time ? date('h:i A', strtotime($slot_details->end_time)) : 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </main>

    <script>
        window.print();
        window.onafterprint = () => window.close();
    </script>
</body>

</html>


