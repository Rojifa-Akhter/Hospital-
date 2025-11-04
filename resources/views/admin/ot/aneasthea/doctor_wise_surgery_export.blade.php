<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

         table.ot-schedule {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    table.ot-schedule th,
    table.ot-schedule td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
        vertical-align: top;
    }
    table.ot-schedule th {
        background-color: #d0e0f0;
        font-weight: bold;
        text-align: center;
    }
    table.ot-schedule tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="13" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong></span>
                                <br>
                                Address:
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                Phone No:
                                <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Doctor Wise Surgery Report</strong> </div>
                </td>
            </tr>
            <tr>
            <th>Sl</th>
            <th>IP No.</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Department</th>
            <th>Item Code</th>
            <th>Doctor</th>
            <th>Anesthesiologist</th>
            <th>Surgery Name</th>
            <th>Ward</th>
            <th>Under Package</th>
            <th>Net Amt</th>
            <th>Completed Date</th>
        </tr>
        </thead>
        <tbody class="tr_border">
            @php $sl = 1; @endphp
            @foreach ($data as $row)
            <tr>
                <td class="border-1 bg-light text-left ">{{ $sl++ }}</td>
                <td class="border-1 bg-light text-left ">{{ $row[1] ?? '' }}</td> {{-- IP No. --}}
                <td class="border-1 bg-light text-left ">{{ $row[2] ?? '' }}</td> {{-- Patient Name --}}
                <td class="border-1 bg-light text-left ">{{ $row[3] ?? '' }}</td> {{-- Age --}}
                <td class="border-1 bg-light text-left ">{{ $row[4] ?? '' }}</td> {{-- Department --}}
                <td class="border-1 bg-light text-left ">{{ $row[5] ?? '' }}</td> {{-- Item Code --}}
                <td class="border-1 bg-light text-left ">{{ $row[6] ?? '' }}</td> {{-- Doctor --}}
                <td class="border-1 bg-light text-left ">{{ $row[7] ?? '' }}</td> {{-- Anesthesiologist Name --}}
                <td  class="border-1 bg-light text-left ">{{ $row[8] ?? '' }}</td> {{-- Surgery Name --}}
                <td class="border-1 bg-light text-left ">{{ $row[9] ?? '' }}</td> {{-- Ward --}}
                <td class="border-1 bg-light text-left ">{{ $row[10] ?? '' }}</td> {{-- Under Package --}}
                <td class="border-1 bg-light text-left ">{{ $row[11] ?? '' }}</td> {{-- Net Amount --}}
                <td class="border-1 bg-light text-left ">
                    {{ !empty($row[12]) ? \Carbon\Carbon::parse($row[12])->format('d/m/Y') : '' }}
                </td> {{-- Completed Date --}}
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="13">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>