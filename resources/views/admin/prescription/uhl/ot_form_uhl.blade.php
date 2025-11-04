<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OT Booking Form</title>
    <style>
        @page {
            margin: 0cm 1cm;
            margin-bottom: 80px;
            margin-top: 3.0cm;

        }

        @font-face {
            font-family: 'IBM Plex Sans';
            src: url("{{ storage_path('fonts/IBMPlexSans-Regular.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Kalpurush';
            src: url("{{ storage_path('fonts/kalpurush.ttf') }}") format('truetype');
        }

        /** Define the header rules **/
        header {
            text-align: center;
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            /* border-bottom: 2px solid; */
            /* color: #007FD2; */
        }

        /* body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 60px 40px 40px 40px ;

            color: #000;
        }

        h1, h2, h3, h4 {
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        } */
          body {
            margin-left: 1cm;
            margin-right: .8cm;
            /* margin-bottom: 7.5cm; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 13px;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            padding: 0;
        }

        .header h2 {
            font-size: 18px;
            margin-top: 8px;
        }

        .section-title {
            background-color: #e2e3e5;
            padding: 6px 10px;
            font-weight: bold;
            margin-top: 25px;
            font-size: 13px;
            border-left: 5px solid #6c757d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .no-border td {
            border: none;
            padding: 4px 8px;
        }

        .checkbox-group span {
            display: inline-block;
            margin-right: 12px;
        }

        .note-box {
            border: 1px dashed #bbb;
            background-color: #fcfcfc;
            padding: 10px;
            margin-top: 6px;
            font-style: italic;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        {{-- <h1>{{ $company_details->hospital_name ?? 'Hospital Name' }}</h1> --}}
        <h2 style="text-align: center">OT Booking Form</h2>
    </div>

    <!-- Patient Info -->
    <div class="section-title">Patient Information</div>
    <table class="no-border">
        <tr>
            <td><strong>UHID:</strong> {{ $uhid }}</td>
            <td><strong>IP No:</strong> {{ $ip_no }}</td>
        </tr>
        <tr>
            <td><strong>Patient Name:</strong> {{ $patient_name }}</td>
            <td><strong>Ward / Bed:</strong> {{ $ward_bed }}</td>
        </tr>
        <tr>
            <td><strong>Sex:</strong> {{ $gender_txt }}</td>
            <td><strong>Age:</strong> {{ $age }}</td>
        </tr>
        <tr>
            <td><strong>Guardian By:</strong> {{ $booking_by }}</td>
            <td><strong>Contact No:</strong> {{ $contact_no }}</td>
        </tr>
    </table>

    <!-- Surgery Info -->
    <div class="section-title">Surgery Details</div>
    <table class="no-border">
        <tr>
            <td><strong>Surgery Date:</strong>
                {{ !empty($surgery_date) ? date('d/m/Y', strtotime($surgery_date)) : '' }}</td>
            <td><strong>Surgery Name:</strong> {{ $item_name }}</td>
        </tr>
        {{-- <tr>
            <td><strong>Speciality:</strong> {{ $speciality }}</td>
            <td><strong>OT No:</strong> {{ $ot_no }}</td>
        </tr> --}}
        <tr>
            <td><strong>Room Name:</strong> {{ $room_name }}</td>
            <td><strong>Primary Doctor:</strong> {{ $primary_doctor }}</td>
        </tr>
        <tr>
            <td><strong>Surgeon:</strong> {{ $surgeon_name }}</td>
            <td><strong>Anesthesiologist:</strong> {{ $anest_name }}</td>
        </tr>
    </table>

    <!-- Schedule -->
    <div class="section-title">Schedule & Status</div>
    <table class="no-border">
        <tr>
            <td><strong>Start Time:</strong> {{ !empty($start_time) ? date('h:i A', strtotime($start_time)) : '' }}
            </td>
            <td><strong>End Time:</strong> {{ !empty($end_time) ? date('h:i A', strtotime($end_time)) : '' }}</td>
        </tr>
        <tr>
            <td><strong>Priority:</strong> {{ $priority }}</td>
            <td>
                <strong>Status:</strong>
                <span class="checkbox-group">
                    <span>[{{ $status_display ? '✔' : ' ' }}] Display</span>
                    <span>[{{ $status_done ? '✔' : ' ' }}] Done</span>
                    <span>[{{ $status_cancel ? '✔' : ' ' }}] Cancel</span>
                </span>
            </td>
        </tr>
    </table>

    <!-- OR Room -->
    @if (!empty($or_room) && count(array_filter($or_room, fn($r) => !empty(array_filter($r)))))
        <div class="section-title">OR Room Details</div>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Department</th>
                    <th>Building</th>
                    <th>Floor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($or_room as $index => $room)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $room['room_name'] ?? '' }}</td>
                        <td>{{ $room['room_type'] ?? '' }}</td>
                        <td>{{ $room['department'] ?? '' }}</td>
                        <td>{{ $room['building'] ?? '' }}</td>
                        <td>{{ $room['floor'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Surgery Team -->
    @if (!empty($surgery_team) && count(array_filter($surgery_team, fn($r) => !empty(array_filter($r)))))
        <div class="section-title">Surgery Team</div>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Doctor Name</th>
                    <th>Role</th>
                    <th>Speciality</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surgery_team as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $member['doctor_name'] }}</td>
                        <td>{{ $member['role'] }}</td>
                        <td>{{ $member['speciality'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Anesthesia Team -->
    @if (!empty($anesthesia) && count(array_filter($anesthesia, fn($r) => !empty(array_filter($r)))))
        <div class="section-title">Anesthesia Team</div>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Member Name</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anesthesia as $index => $ana)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ana['member_name'] }}</td>
                        <td>{{ $ana['role'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- indent -->
   @if (!empty($indent))
  <div class="section-title">Indent Products</div>
  <table class="table table-sm table-bordered">
    <thead>
      <tr>
        <th>SL</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Unit</th>
        <th>Remarks</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($indent as $index => $product)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $product['product_name'] }}</td>
          <td>{{ $product['quantity'] }}</td>
          <td>{{ $product['unit'] }}</td>
          <td>{{ $product['remarks'] }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif


    <!-- Medicines -->
     @if (!empty($medicine))
        <div class="section-title">Medicines</div>
        <table>
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Medicine Name</th>
                    <th>Route</th>
                    <th>Dosage</th>
                    <th>Duration</th>
                    <th>Quantity</th>
                    <th>Instruction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medicine as $index => $med)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $med['medicine_item'] }}</td>
                        <td>{{ $med['route'] }}</td>
                        <td>{{ $med['dose'] }}</td>
                        <td>{{ $med['duration']['value'] ?? '' }} {{ $med['duration']['unit'] ?? '' }}</td>
                        <td>{{ $med['quantity'] }}</td>
                        <td>{{ $med['instruction'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <!-- Notes -->
    @if (!empty($preparation_note))
        <div class="section-title">Preparation Note</div>
        <div class="note-box">{{ $preparation_note }}</div>
    @endif

    @if (!empty($radiology_note))
        <div class="section-title">Radiology Instructions</div>
        <div class="note-box">{{ $radiology_note }}</div>
    @endif

    <div class="footer">
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>
        Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed
        By: {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]
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
