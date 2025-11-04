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
    <title>Corporate Performance Report</title>
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
                    Corporate Performance Report
                </span>
            </div>
            <div style=" text-align:center;  width:100%; margin-bottom:10px" class="mb-2">


                <span class="report-date"><strong>From Date: {{ $from_date }}</strong> - <span
                        class="report-date"><strong>To Date: {{ $to_date }}</strong>
                    </span>
            </div>
            <section id="lp-items">
                <div class="container">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center" scope="col">SL</th>
                                {{-- <th class="text-center" scope="col" style="width:62px;">Date</th> --}}
                                <th class="text-center" scope="col">Employee Name</th>
                                <th class="text-center" scope="col">Corporate Code</th>
                                <th class="text-center" scope="col">Corporate Name</th>
                                <th class="text-center" scope="col">OPD Consultation</th>
                                <th class="text-center" scope="col">IPD Admission</th>
                                <th class="text-center" scope="col">OT Execution</th>
                                <th class="text-center" scope="col">Procedure</th>
                                <th class="text-center" scope="col">Total Investigation</th>
                                <th class="text-center" scope="col">Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_consultation = $total_ipd_service = $total_ot_excution = $total_predure = $total_investigation = 0;
                            @endphp
                            @if (!empty($data))
                                @foreach ($data as $key => $row)
                                    <tr>
                                        <td class="text-left global-uhl-table-bg">{{ $loop->iteration }}</td>
                                        <td class="text-left global-uhl-table-bg">
                                            {{ !empty($row->signatory_name) ? $row->signatory_name : '' }}</td>
                                        <td class="text-left global-uhl-table-bg">
                                            {{ !empty($row->ccm_client_code) ? $row->ccm_client_code : '' }}</td>
                                        <td class="text-left global-uhl-table-bg">
                                            {{ !empty($row->ccm_client_name) ? $row->ccm_client_name : '' }}</td>
                                        <td class="text-center global-uhl-table-bg" style="text-align: center;">
                                            {{ !empty($row->consultation) ? $row->consultation : 0 }}</td>
                                        <td class="text-center global-uhl-table-bg" style="text-align: center;">
                                            {{ !empty($row->ipd_service) ? $row->ipd_service : 0 }}
                                        </td>
                                        <td class="text-center global-uhl-table-bg" style="text-align: center;">
                                            {{ !empty($row->ot_excution) ? $row->ot_excution : 0 }}
                                        </td>
                                        <td class="text-center global-uhl-table-bg" style="text-align: center;">{{ !empty($row->predure) ? $row->predure : 0 }}</td>
                                        <td class="text-center global-uhl-table-bg" style="text-align: center;">
                                            {{ !empty($row->investigation) ? $row->investigation : 0 }}</td>
                                        <td></td>

                                        <div style="display: none">{{ $total_consultation += $row->consultation }}</div>
                                        <div style="display: none">{{ $total_ipd_service += $row->ipd_service }}</div>
                                        <div style="display: none">{{ $total_ot_excution += $row->ot_excution }}</div>
                                        <div style="display: none">{{ $total_predure += $row->predure }}</div>
                                        <div style="display: none">{{ $total_investigation += $row->investigation }}</div>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th class="text-center" scope="col" colspan="15">No Data Available</th>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" scope="col" colspan="4" style="text-align: right;">Total = </th>
                                <th scope="col" class="text-center global-uhl-table-bg" style="text-align: center;">
                                    {{ $total_consultation }}
                                </th>
                                <th scope="col" class="text-center global-uhl-table-bg" style="text-align: center;">
                                    {{ $total_ipd_service }}
                                </th>
                                <th scope="col" class="text-center global-uhl-table-bg" style="text-align: center;">
                                    {{ $total_ot_excution }}
                                </th>
                                <th scope="col" class="text-center global-uhl-table-bg" style="text-align: center;">
                                    {{ $total_predure }}
                                </th>
                                <th scope="col" class="text-center global-uhl-table-bg" style="text-align: center;">
                                    {{ $total_investigation }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
