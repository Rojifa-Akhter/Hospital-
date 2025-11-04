<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Radiology Lebel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: 0;
            size: 7.5cm 3.8cm; /* Width x Height */
        }

        @font-face {
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            src: url("font url"); /* Specify your font URL */
        }

        body {
            margin: 0.2cm;
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        header {
            border-bottom: 1px solid #007FD2;
            color: #007FD2;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        header img {
            width: 60px;
            margin-bottom: 0;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .header-title {
            font-size: 12px;
            font-weight: bold;
        }

        main {
            padding: 0 10px;
        }

        .card {
            border: 1px solid #000;
            padding: 5px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 2px 5px;
            vertical-align: top;
        }

        .footer {
            text-align: center;
            font-size: 8px;
            padding-top: 5px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body onload="window.print()">
    @if (is_array($appointment))
        @foreach ($appointment as $value)
            <div class="card">
                <header>
                   @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                    @endif
                    <div class="header-text">
                        <div class="header-title">
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </div>
                        <div>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                        </div>
                    </div>
                </header>
                <main>
                    <section id="patient-info">
                        <table>
                            <tr>
                                <td><strong>Invoice ID:</strong></td>
                                <td>{{ !empty($value->invoice_code) ? $value->invoice_code : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Patient Name:</strong></td>
                                <td>{{ !empty($value->patient_name) ? $value->patient_name : '' }}</td>
                            </tr>
                            @if (!empty($value->accession_id))
                                <tr>
                                    <td><strong>Admission ID:</strong></td>
                                    <td>{{ $value->accession_id }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Referred By:</strong></td>
                                <td>Dr. Rahat Alam, MBBS (Dhaka)</td>
                            </tr>
                            <tr>
                                <td><strong>Age:</strong></td>
                                <td>{{ $value->pat_age }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender:</strong></td>
                                <td>{{ !empty($value->gender_txt) ? $value->gender_txt : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td>{{ !empty($value->present_addr) ? $value->present_addr : '' }}</td>
                            </tr>
                        </table>
                    </section>
                    <div class="footer">
                        <table>
                            <tr>
                                <td><strong>Delivery Date:</strong></td>
                                <td>{{ !empty($value->img_app_dttm) ? date('d/m/Y', strtotime($value->img_app_dttm)) : '' }}</td>
                            </tr>
                            <?php
                            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                            $date = $dt->format('d/m/Y g:i A');
                            ?>
                            <tr>
                                <td><strong>Print On:</strong></td>
                                <td>{{ $date }}</td>
                            </tr>
                        </table>
                    </div>
                </main>
            </div>
            @if ($loop->iteration != count($appointment))
                <div class="page-break"></div>
            @endif
        @endforeach
    @else
        <!-- Single appointment case (if needed) -->
        <div class="card">
            <header>
               @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                    @endif
                <div class="header-text">
                    <div class="header-title">
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </div>
                    <div>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                    </div>
                </div>
            </header>
            <main>
                <section id="patient-info">
                    <table>
                        <tr>
                            <td><strong>Invoice No.:</strong></td>
                            <td>{{ !empty($appointment->invoice_code) ? $appointment->invoice_code : '' }}</td>
                        </tr>
                        @if (!empty($appointment->admission_no_pk))
                            <tr>
                                <td><strong>Admission ID:</strong></td>
                                <td>{{ $appointment->admission_no_pk }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>UHID:</strong></td>
                            <td>{{ !empty($appointment->patient_code) ? $appointment->patient_code : '' }}</td>
                        </tr>
                         <tr>
                            <td><strong>Patient Name:</strong></td>
                            <td>{{ !empty($appointment->patient_name) ? $appointment->patient_name : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Consultant:</strong></td>
                            <td>                                 
                                @if(!empty($appointment->ref_doc_name) && strtoupper(trim($appointment->ref_doc_name)) !="SELF")
                                    {{ $appointment->ref_doc_name }}
                                @elseif(!empty($appointment->first_ref_doc_name))
                                    {{ $appointment->first_ref_doc_name }}
                                @elseif(!empty($appointment->second_ref_doc_name))
                                    {{ $appointment->second_ref_doc_name }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Service Name:</strong></td>
                            <td>{{ !empty($appointment->item_name) ? $appointment->item_name : '' }}</td>
                        </tr>
                        @if (!empty($appointment->pat_age))
                            <tr>
                                <td><strong>Age:</strong></td>
                                <td>{{ $appointment->pat_age }}</td>
                            </tr>
                        @endif
                        @if (!empty($appointment->gender_txt))
                            <tr>
                                <td><strong>Gender:</strong></td>
                                <td>{{ $appointment->gender_txt }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Mobile No.:</strong></td>
                            <td>{{ !empty($appointment->patient_mobile) ? $appointment->patient_mobile : 'N/A' }}</td>
                        </tr>
                        <?php
                        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                        $date = $dt->format('d/m/Y g:i A');
                        ?>
                        <tr>
                            <td><strong>Print:</strong></td>
                            <td>{{ Session::get('user.ses_user_name') }} &nbsp;&nbsp;{{ $date }}</td>
                        </tr>
                    </table>
                </section>
            </main>
        </div>
    @endif
</body>

<script>
    window.onafterprint = function() {
        // window.close(); // Close the window after printing
    }
</script>
</html>
