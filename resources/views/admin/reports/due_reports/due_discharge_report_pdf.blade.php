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
    <title>Due Patient Discharge Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    
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

        .tr_border td, .tr_border th {
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
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> <strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span><br>
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
                    <div style="text-align: center;"> <strong> Due Patient Discharge Report</strong> </div>
                    <div style="text-align: center;">
                        <strong style="margin-right: 5px;">From {{ $from_date ? $from_date : '' }} To {{ $to_date ? $to_date : '' }}</strong>
                    </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="bg-soft-green text-center">SL#</th>
                <th style="text-align: center;" scope="col">Admission ID</th>
                <th style="text-align: center;" scope="col">Admission Date</th>
                <th style="text-align: left;" scope="col">Patient Name</th>
                <th style="text-align: center;" scope="col">Discharge Date</th>
                <th style="text-align: right;">Sales</th>
                <th style="text-align: right;">Payment</th>
                <th style="text-align: right;">Discount</th>
                <th style="text-align: right;">Due</th>
            </tr>
        </thead>
        <tbody class="tr_border">
            @if(!empty($due_patient_data))
            @php
                $total_sales = 0;
                $total_payment = 0;
                $total_discount = 0;
                $total_due = 0;
            @endphp
            @foreach($due_patient_data as $key=>$row)
            <tr class="tr_border">
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;"><strong>{{ $row->admission_no_pk }}</strong></td>
                <td style="text-align: center;">{{ $row->admission_date ? date('d-m-Y', strtotime($row->admission_date)) : '' }}</td>
                <td style="text-align: left;">{{ $row->patient_name }}</td>
                <td style="text-align: center;">{{ $row->dis_date ? date('d-m-Y', strtotime($row->dis_date)) : '' }}</td>
                <td style="text-align: right;">{{ $row->sales }}</td>
                <td style="text-align: right;">{{ $row->payment }}</td>
                <td style="text-align: right;">{{$row->discount}}</td>
                <td style="text-align: right;">{{ $row->due }}</td>
            </tr>
            @php
                $total_sales += $row->sales;
                $total_payment += $row->payment;
                $total_discount += $row->discount;
                $total_due += $row->due;
            @endphp
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right;"><b>Total</b></td>
                <td style="text-align: right;"><b>{{ $total_sales }}</b></td>
                <td style="text-align: right;"><b>{{ $total_payment }}</b></td>
                <td style="text-align: right;"><b>{{ $total_discount }}</b></td>
                <td style="text-align: right;"><b>{{ $total_due }}</b></td>
            </tr>
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
