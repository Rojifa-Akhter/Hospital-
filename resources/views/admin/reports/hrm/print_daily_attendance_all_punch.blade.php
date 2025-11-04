<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
// ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
->first();
?>
@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Daily Attendance Report</title>
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
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 5%; border:none;">
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
                                <div style="text-align: center; margin-top:2px"> <strong>Daily Attendance All Punch</strong> </div>
                                <div style="text-align: center;">
                                    <strong style="margin-right: 5px;">From {{ $from_date ? date("d-m-Y", strtotime($from_date)) : '' }} To {{ $to_date ? date("d-m-Y", strtotime($to_date)) : '' }}</strong>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="tr_border">
                <th style="text-align: center">#SL</th>
                <th style="text-align: center">Atten.Date</th>
                <th style="text-align: center">Punch Time</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @if (!empty($value))
            @foreach ($value as $employeeData)
            @php
                $employeeInfo = reset($employeeData);
            @endphp
            <tr class="tr_border">
                <th style="border: none;" colspan="3"><span style="margin-right:5px">Card: {{ $employeeInfo->card_no }} </span><span style="margin-right:5px">Name: {{ $employeeInfo->full_name }} </span><span>Department: {{ $employeeInfo->serviceunit_name }}</span></th>
                {{-- <th style="border: none; width:20%" ></th>
                <th style="border: none; width:70%" ></th> --}}
                {{-- <th style="border: none" colspan="3">Designation: {{ $employeeInfo->designation_name }}</th> --}}
            </tr>
            @foreach ($employeeData as $data)
                <tr class="tr_border">
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: center">{{ date('d/m/Y', strtotime($data->check_date)) }}</td>
                    <td style="text-align: center">{{ $data->checktimes }}</td>
                   
                </tr>
            @endforeach
            @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="12">
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
