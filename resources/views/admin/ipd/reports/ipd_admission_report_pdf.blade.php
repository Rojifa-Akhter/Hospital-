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
    <title>OPD Admission Report</title>
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
                    OPD Admission Report
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
                        <thead class="sticky_header">
                            <tr class="bg-light-blue">
                                <th class="text-center" style="width: 20px;">SL#</th>
                                <th class="text-center">Patient ID</th>
                                <th class="text-center">Prescription Date</th>
                                <th class="text-center">Patient Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Doctor</th>
                                <th class="text-center">Intervention</th>
                        </thead>
                        <br>
                        <tbody>
                            @if (!empty($report_dt))
                                @foreach ($report_dt as $key => $data)
                                    <tr>
                                        <td colspan="8" style="text-align: left">
                                            <strong>{{ strtoupper($key) }}</strong></td>
                                    </tr>
                                    @foreach ($data as $dt)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                {{ !empty($dt->patient_code) ? $dt->patient_code : '' }}</td>
                                            <td class="text-center">
                                                {{ !empty($dt->prescription_date) ? date('d/m/Y', strtotime($dt->prescription_date)) : '' }}
                                            </td>
                                            <td class="text-left">
                                                <strong>{{ !empty($dt->patient_name) ? ucfirst($dt->patient_name) : '' }}</strong>
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($dt->gender_txt) ? $dt->gender_txt : '' }}</td>
                                            <td class="text-center">{{ !empty($dt->mobile1) ? $dt->mobile1 : '' }}</td>
                                            <td class="text-center">
                                                <strong>{{ !empty($dt->doctor_name) ? $dt->doctor_name : '' }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <div><strong>{{ !empty($dt->disposal) ? $dt->disposal : '' }}</strong>
                                                </div>
                                                @if (empty($dt->admission_no_fk))
                                                    @if ($dt->disposal == 'Admission')
                                                        <div><strong><span class="badge badge-warning">Not
                                                                    Admitted</span></strong></div>
                                                    @endif
                                                @else
                                                    <div><strong><span
                                                                class="badge badge-success">Admitted</span></strong>
                                                    </div>
                                                    <div><strong><span class="badge badge-success">Admission ID:
                                                                {{ !empty($dt->admission_no_fk) ? $dt->admission_no_fk : '' }}</span></strong>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th class="text-right" colspan="2" style="text-align: right">Total =</th>
                                <th class="text-center bg-light-blue" style="text-align: center">{{ $final_qty }}</th>
                                <th class="text-right bg-light-blue" style="text-align: right;">{{ number_format($final_price, 2) }}</th>
                            </tr>
                        </tfoot> --}}

                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
