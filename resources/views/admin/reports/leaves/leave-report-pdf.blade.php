<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
// ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
->first();
$hospital = DB::table('wsec_hospital')
    ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
    ->first();
$months = ['jan', 'feb', 'mar', 'apr', 'may', 'june', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report</title>
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
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
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
                                    {{-- <img src="data:image/png;base64, {{ $barcode_no }} " width="100" /> --}}
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Leave Balance Report</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <td class="table-td" scope="col"><strong>SL</strong></td>
                <td class="table-td" scope="col"><strong>Name of Employee</strong></td>
                <td class="table-td" scope="col"><strong>Designation</strong></td>
                <td class="table-td" scope="col"><strong>ID No</strong></td>
                <td class="table-td" scope="col"><strong>Date</strong></td>
                <td class="table-td" scope="col"><strong>Current</strong></td>
                <td class="table-td" scope="col"><strong>Tenure of Services</strong></td>
                <td class="table-td" scope="col"><strong>Leave Balance</strong></td>
                <td class="table-td" scope="col"><strong>Leave Type</strong></td>
                <td class="table-td" scope="col"><strong>Entitled Leave</strong></td>
                <td class="table-td" scope="col"><strong>Total Availed Leave</strong></td>
                <td class="table-td" scope="col"><strong>Balance</strong></td>
                @foreach ($months as $month)
                    <td class="table-td" scope="col"><strong>{{ Str::ucfirst($month) }}</strong></td>
                @endforeach
            </tr>
        </thead>
        <tbody class="tr_border">
            @foreach ($leaves as $index => $item)
                        @php
                            $tenureOfService = 'N/A';
                            if(isset($item->join_date)) {
                                $date = Carbon\Carbon::parse($item->join_date);
                                $now = Carbon\Carbon::now();
                                $tenureOfService = $date->diff($now)->format('%y Years %m Months %d Days');
                            }
                        @endphp

                        @foreach ($item->availed_info as $key => $availed_info)
                            <tr class="tr_border">
                                @if($key == 0)
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ ++$index }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ $item->full_name }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ $item->designation_name ?? 'N/A' }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ $item->card_no }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ isset($item->join_date) ? date('M d, Y', strtotime($item->join_date)) : 'N/A' }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ date('M d, Y', strtotime(now())) }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ $tenureOfService }}</td>
                                    <td class="table-td" style="text-align: center;" scope="col" rowspan="{{ count($item->availed_info) }}">{{ $item->total_balance - $item->total_leave }}</td>
                                @endif
                                <td class="table-td" style="text-align: center;" scope="col">{{ $availed_info->leave_code }}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{ $availed_info->no_of_days }}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{ $availed_info->leave }}</td>
                                <td class="table-td" style="text-align: center;" scope="col">{{ $availed_info->no_of_days - $availed_info->leave }}</td>
                                @foreach ($months as $month)
                                    <td class="table-td" style="text-align: center;" scope="col">{{ $availed_info->$month }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
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
