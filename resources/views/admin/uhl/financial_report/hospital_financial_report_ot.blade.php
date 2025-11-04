@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hospital Financial Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        /** Define the header rules **/
        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        tfoot tr td {
            font-weight: bold;
        }

        th {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        table {
            border: 1px solid #222;
            border-spacing: 0;
        }

        td {
            border-bottom: 1px solid #222;
            border-right: 1px solid #222;
        }

        table td:last-child {
            border-right: 0px solid transparent;
        }

        th {
            border-top: 1px solid #222;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
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
    </header>

    <div class="signature_">
        <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
            <tr class="table-tr">
                <td style="text-align:left; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Employee Signature
                    </span>
                </td>
                <td style="text-align:right; border:none;">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table>
    </div>



    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0;border:none;">
                    <tr>
                        <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                <?php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('g:i A');
                                ?>
                                {{ date('d/m/Y') }} {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360 [NextGen]
                            </strong></td>

                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <main>
        <div class="wrapper">
            <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                    OT Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>

            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-spacing: 0;" cellpadding="1">
                        <tr class="bg-light-blue">

                            <th class="text-center">SL</th>
                            {{-- <th class="text-center">Date</th> --}}
                            <th class="text-center">Department</th>
                            <th class="text-center">Total Invoice Of The OT</th>
                            <th class="text-center">Major OT</th>
                            <th class="text-center">Minor OT</th>
                            {{-- <th class="text-center">Dressing</th>
                            <th class="text-center">Corporate</th>
                            <th class="text-center">Academic/Free</th> --}}
                            @if (session('user.financial_ind') == 1)
                                <th class="text-center">Sales</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Collection</th>
                            @endif
                        </tr>
                        <tbody> <?php
                        $total_patient = $total_major_ot = $total_minor_ot = $total_dressing = $general_quantity = $corporate_pt = $student_pt = $total_sales = $total_dis = $total_payment = $final_academic_qty = $final_academic_amt = $final_corporate_qty = $final_corporate_amt = $final_qty = $final_amt = 0;
                        ?>
                            @if (!empty($report_data))
                                @foreach ($report_data as $dt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        {{-- <td>{{ date('d/m/y', strtotime( $dt->invoice_date)) }}</td> --}}
                                        <td style="text-align: center">{{ $dt->department }}</td>
                                        <td style="text-align: center">{{ $dt->total_qty }}</td>
                                        <td style="text-align: center">{{ $dt->major }}</td>
                                        <td style="text-align: center">{{ $dt->minor }}</td>
                                        {{-- <td>{{ 0 }}</td>
                                        <td>{{ 0 }}</td>
                                        <td>{{ 0 }}</td> --}}
                                        @if (session('user.financial_ind') == 1)
                                            <td style="text-align:right;">{{ number_format($dt->sales, 2) }}</td>
                                            <td style="text-align:right;">{{ number_format($dt->discount, 2) }}</td>
                                            <td style="text-align:right;">{{ number_format($dt->payment, 2) }}</td>
                                        @endif

                                    </tr>

                                    <div style="display: none">{{ $total_patient += $dt->total_qty }}</div>
                                    <div style="display: none">{{ $total_major_ot += $dt->major }}</div>
                                    <div style="display: none">{{ $total_minor_ot += $dt->minor }}</div>
                                    <div style="display: none">{{ $total_dressing += 0 }}</div>
                                    <div style="display: none">{{ $general_quantity += 0 }}
                                    </div>
                                    <div style="display: none">{{ $corporate_pt += 0 }}</div>
                                    <div style="display: none">{{ $student_pt += 0 }}</div>
                                    <div style="display: none">{{ $total_sales += $dt->sales }}</div>
                                    <div style="display: none">{{ $total_dis += $dt->discount }}</div>
                                    <div style="display: none">{{ $total_payment += $dt->payment }}</div>

                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="2" style="text-align:right;">Sub Total =</th>

                                <th class="text-left bg-light-blue" style="text-align:cener;">{{ $total_patient }}</th>
                                <th class="text-left bg-light-blue" style="text-align:cener;">{{ $total_major_ot }}
                                </th>
                                <th class="text-left bg-light-blue" style="text-align:cener;">{{ $total_minor_ot }}
                                </th>
                                {{-- <th class="text-left bg-light-blue" style="text-align:left;">{{ 0 }}</th>
                                <th class="text-left bg-light-blue" style="text-align:left;">{{ 0 }}</th>
                                <th class="text-left bg-light-blue" style="text-align:left;">{{ 0 }}</th> --}}
                                @if (session('user.financial_ind') == 1)
                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_sales, 2) }}</th>
                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_dis, 2) }}</th>

                                    <th class="text-left bg-light-blue" style="text-align:right;">
                                        {{ number_format($total_payment, 2) }}</th>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
