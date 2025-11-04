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
    <title> IPD Bed Transfer Details</title>
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
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="7" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                    width="60" alt="">
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
                    <div style="text-align: center;"> <strong> IPD Bed Transfer Details</strong> </div>
                    @if (!empty($from_date))
                    <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">
                        <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                                class="report-date"><strong>To Date: {{ $to_date }}</strong></span>
                        </span>
                    </div>
                    @endif

                </td>
            </tr>
            <tr class="tr_border">
                <th class="bg-soft-green text-center">SL</th>
                <th class="bg-soft-green text-left" scope="col">Patient Name</th>
                <th class="bg-soft-green text-left" scope="col" style="word-wrap: break-word;">Ward Name</th>
                <th class="bg-soft-green text-left" scope="col" style="word-wrap: break-word;">Bed Name</th>
                <th class="bg-soft-green text-left" scope="col">Start Time</th>
                <th class="bg-soft-green text-left" scope="col">End Time</th>
                <th class="bg-soft-green text-left" scope="col">Stay Date & Time</th>
                <th class="bg-soft-green text-left" scope="col">Transfer/Added By</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @forelse($beds as $key => $item)
                <tr style="background-color: #aec4d5 !important;" class="text-white">
                    <td colspan="8">Admission ID: <strong>{{ $key }}</strong></td>
                </tr>
                @foreach ($item as $bed)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $bed->patient_name }}</td>
                        <td class="text-left">{{ $bed->ward_no_fk }} - {{ $bed->ward_name }}</td>
                        <td class="text-left">{{ $bed->bed_no_fk }} - {{ $bed->bed_name }}</td>
                        <td class="text-left"> {{ date('d/m/Y h:i:s a', strtotime($bed->start_time)) }}</td>
                        <td class="text-left">
                            @if ($bed->end_time)
                                {{ date('d/m/Y h:i:s a', strtotime($bed->end_time)) }}
                            @else
                                <span style="color: red; font-weight: bold;">Not Yet Discharged</span>
                            @endif
                        </td>
                        <td class="text-left">
                            @php
                                $startTime = \Carbon\Carbon::parse($bed->start_time);
                                $endTime = $bed->end_time ? \Carbon\Carbon::parse($bed->end_time) : \Carbon\Carbon::now();
                                $diff = $startTime->diff($endTime);
                            @endphp
                            {{ $diff->d }} Days, {{ $diff->h }} Hours, {{ $diff->i }} Minutes
                        </td>
                        <td class="text-center"><span
                                style="color: red; font-weight: bold;">{{ $bed->user_fullname }}</span></td>

                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" class="text-center text-danger">Data Not Found</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="7">
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
