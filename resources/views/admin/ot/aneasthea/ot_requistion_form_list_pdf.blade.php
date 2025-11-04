<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #222;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 10px;
            border-top: 1px solid #222;
            padding-top: 5px;
            text-align: center;
        }

        .title-section {
            margin-top: 60px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }

        .sub-heading {
            margin-top: 8px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead th {
            border: 1px solid #000;
            padding: 6px;
            background-color: #f9f9f9;
            text-align: center;
            font-size: 10px;
        }

        tbody td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 10px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-muted {
            color: #777;
        }

        hr.dotted {
            border: none;
            border-top: 1px dotted #333;
            margin: 10px 0;
        }

        .signature {
            margin-top: 30px;
            width: 100%;
            text-align: center;
            font-size: 10px;
        }

        .signature td {
            padding-top: 40px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <footer>
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>
        <div>
            Print: {{ Session::get('user.user_code') }} | {{ date('d-m-Y') }} {{ $date }} |
            Powered by: NEXTGEN IT
        </div>
    </footer>

    <div class="title-section">
        Operation Requisition Form
    </div>

    <hr class="dotted">

    <div class="sub-heading">
        Operation Requisition (Department): {{ $dept }} &nbsp; | &nbsp; Category of Surgical Urgency: {{ $urgency }}
    </div>

    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Patient Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Diagnosis</th>
                <th>Proposed Operation</th>
                <th>Est. Duration</th>
                <th>Surgeon's Remarks</th>
                <th>Department</th>
                <th>Surgical Urgency</th>
                <th>Nurse In charge</th>
                <th>Surgeon In charge</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $row->patient_name }}</td>
                    <td class="text-center">{{ $row->age }}</td>
                    <td class="text-center">{{ $row->gender_txt }}</td>
                    <td>{{ $row->diagnosis }}</td>
                    <td>{{ $row->purpose_off_reff }}</td>
                    <td class="text-center">{{ $row->estimated_duration_surge }}</td>
                    <td>{{ $row->specefic_req_n_remarks }}</td>
                    <td>{{ $row->req_dept_name }}</td>
                    <td>{{ $row->urgency_details }}</td>
                    <td>{{ $row->nurse_name }}</td>
                    <td>{{ $row->surgen_name }}</td>
                    <td class="text-center">
                        @if (!empty($row->user_name))
                            <div><strong>{{ $row->user_name }}</strong></div>
                            <div><small>{{ $row->req_given_date }}</small></div>
                        @else
                            <span class="text-muted">Pending</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <table width="100%">
            <tr>
                <td style="border:none !important;">Nurse In charge</td>
                <td style="border:none !important;">Surgeon In charge</td>
            </tr>
        </table>
    </div>

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
