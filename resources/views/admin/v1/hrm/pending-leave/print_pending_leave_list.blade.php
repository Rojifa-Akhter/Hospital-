

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
    <title>Pending Leave Report</title>
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


<table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
    <thead class="thead-success">
        <tr>
            <td colspan="12" style="">
                <table style="width: 100%; border:none;" class="signature">
                    <tr>
                        {{-- <td style="width: 15%; border:none;">
                            <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                        </td> --}}
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
                     
                    </tr>
                </table>
                <div style="text-align: center;"> <strong>Pending Leave Report</strong> </div>
                <div style="text-align: center;">
                    <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                </div>
            </td>
        </tr>
        <tr class="tr_border">
            <th style="text-align:center">SL#</th>
            <th  style="text-align:left">Code</th>
            <th  style="text-align:left">Name</th>
            <th  style="text-align:left">Department</th>
            <th  style="text-align:left">Designation</th>
            <th  style="text-align:left">Leave Type</th>
            <th  style="text-align:left">From Date</th>
            <th  style="text-align:left">To Date</th> 
        </tr>
    </thead>
    <tbody class="tr_border">
        @if (!empty($pendingLeavedata))
            @foreach ($pendingLeavedata as $data)
                <tr>
                    <td >{{ $loop->iteration }}</td>
                    <td style="text-align:left">{{ $data->card_no }}</td>
                    <td style="text-align:left">{{ $data->full_name }}</td>
                    <td style="text-align:left">{{ $data->department }}</td>
                    <td style="text-align:left">{{ $data->designation_name }}</td>
                    <td style="text-align:left">{{ $data->leave_type_name }}</td>
                    <td style="text-align:left">{{ date('d/m/Y', strtotime($data->from_date))}}</td>
                    <td style="text-align:left">{{ date('d/m/Y', strtotime($data->to_dates)) }}</td>
                </tr>
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
                        <td style="font-size: 9px;  border:none; text-align:right;"><strong>Powered By - H360 [NextGen]
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
    setTimeout(function() {
            window.close();
        }, 1000);
</script>