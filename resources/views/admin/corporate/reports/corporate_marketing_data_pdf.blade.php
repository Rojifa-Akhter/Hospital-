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
    <title>Marketing Team Performance Report</title>
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
                    Marketing Team Performance Report
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
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th class="table-td" scope="col" rowspan="2" style="text-align: center;">SL#</th>

                                <th class="table-td" scope="col" rowspan="2" style="text-align: center;">Client Name</th>
                                <th class="table-td" scope="col" rowspan="2" style="text-align: center;">Address</th>
                                <th class="table-td" scope="col" rowspan="2" style="text-align: center;">Entry Date</th>
                                <th class="table-td" scope="col" colspan="12" style="text-align: center;">Total Sales</th>
                            </tr>
                            <tr>
                                <td class="table-td" scope="col" style="text-align: center;">January</td>
                                <td class="table-td" scope="col" style="text-align: center;">February</td>
                                <td class="table-td" scope="col" style="text-align: center;">March</td>
                                <td class="table-td" scope="col" style="text-align: center;">April</td>
                                <td class="table-td" scope="col" style="text-align: center;">May</td>
                                <td class="table-td" scope="col" style="text-align: center;">June</td>
                                <td class="table-td" scope="col" style="text-align: center;">July</td>
                                <td class="table-td" scope="col" style="text-align: center;">August</td>
                                <td class="table-td" scope="col" style="text-align: center;">September</td>
                                <td class="table-td" scope="col" style="text-align: center;">October</td>
                                <td class="table-td" scope="col" style="text-align: center;">November</td>
                                <td class="table-td" scope="col" style="text-align: center;">December</td>
                            </tr>
                        </thead>
                        <tbody>
                            <div style="display: none">
                                {{ $s_jan = 0 }}
                                {{ $s_feb = 0 }}
                                {{ $s_mar = 0 }}
                                {{ $s_april = 0 }}
                                {{ $s_may = 0 }}
                                {{ $s_jun = 0 }}
                                {{ $s_jul = 0 }}
                                {{ $s_aug = 0 }}
                                {{ $s_sep = 0 }}
                                {{ $s_oct = 0 }}
                                {{ $s_nov = 0 }}
                                {{ $s_dec = 0 }}
                            </div>
                            @if (!empty($data))

                                @foreach ($data as $cdata)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>


                                        <td class="text-left">
                                            {{ !empty($cdata->ccm_client_name) ? ucfirst($cdata->ccm_client_name) : '' }}
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($cdata->client_address) ? ucfirst($cdata->client_address) : '' }}
                                        </td> <td class="text-left">
                                            {{ date('d/m/Y', strtotime($cdata->au_entry_at)) }}
                                        </td>

                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->jan) ? number_format($cdata->jan, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->feb) ? number_format($cdata->feb, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->mar) ? number_format($cdata->mar, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->april) ? number_format($cdata->april, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->may) ? number_format($cdata->may, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->jun) ? number_format($cdata->jun, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->jul) ? number_format($cdata->jul, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->aug) ? number_format($cdata->aug, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->sep) ? number_format($cdata->sep, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->oct) ? number_format($cdata->oct, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->nov) ? number_format($cdata->nov, 2) : 0 }}</td>
                                        <td class="text-right" style="text-align:right;">
                                            {{ !empty($cdata->dec) ? number_format($cdata->dec, 2) : 0 }}</td>

                                    </tr>

                                    <div style="display: none">{{ $s_jan += $cdata->jan }}</div>
                                    <div style="display: none">{{ $s_feb += $cdata->feb }}</div>
                                    <div style="display: none">{{ $s_mar += $cdata->mar }}</div>
                                    <div style="display: none">{{ $s_april += $cdata->april }}</div>
                                    <div style="display: none">{{ $s_may += $cdata->may }}</div>
                                    <div style="display: none">{{ $s_jun += $cdata->jun }}</div>
                                    <div style="display: none">{{ $s_jul += $cdata->jul }}</div>
                                    <div style="display: none">{{ $s_aug += $cdata->aug }}</div>
                                    <div style="display: none">{{ $s_sep += $cdata->sep }}</div>
                                    <div style="display: none">{{ $s_oct += $cdata->oct }}</div>
                                    <div style="display: none">{{ $s_nov += $cdata->nov }}</div>
                                    <div style="display: none">{{ $s_dec += $cdata->dec }}</div>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="4" style="text-align:right;">Total =</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_jan, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_feb, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_mar, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_april, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_may, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_jun, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_jul, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_aug, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_sep, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_oct, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_nov, 2) }}</th>
                                <th class="text-right bg-light-blue" style="text-align:right;">
                                    {{ number_format($s_dec, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
