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
    <title>Hospital {{ $dept }} Report</title>
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
        th {
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
                     Daily Hospital Statement Report
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
                            <th class="text-center">Department</th>
                            <th class="text-center">OPD</th>
                            <th class="text-center">IPD</th>
                            <th class="text-center">OT</th>
                            {{-- <th class="text-center">Emergency</th> --}}
                            <th class="text-center">Physiotherapy</th>
                            <th class="text-center">Pathology</th>
                            <th class="text-center">Radiology</th>
                            {{-- <th class="text-center">X-Ray</th> --}}
                            <th class="text-center">ETT</th>
                            <th class="text-center">Endoscopy/Colonoscopy</th>
                            <th class="text-center">Echo</th>
                            <th class="text-center">Dyalysis</th>
                            <th class="text-center">Dressing</th>
                        </tr>
                        <tbody> <?php
                        $total_opd  = 0;
                        $total_ipd_adm  = 0;
                        $total_ot  = 0;
                        $total_procedu_re  = 0;
                        $total_pathology  = 0;
                        $total_x_ray  = 0;
                        $total_usg  = 0;
                        $total_endoscopy  = 0;
                        $total_echo  = 0;
                        $total_dyalysis  = 0;
                        $total_ett  = 0;
                        $total_radiogy  = 0;
                        $total_dressing  = 0;

                        ?>
                            @if (!empty($report_data))
                                @foreach ($report_data as $dt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ !empty($dt->su_name)?ucfirst($dt->su_name):'' }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->opd)?$dt->opd:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->ipd_adm)?$dt->ipd_adm:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->ot)?$dt->ot:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->procedu_re)?$dt->procedu_re:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->pathology)?$dt->pathology:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->radiology)?$dt->radiology:0 }}</td>
                                        {{-- <td style="text-align:center;">{{ !empty($dt->x_ray)?$dt->x_ray:0 }}</td> --}}
                                        <td style="text-align:center;">{{ !empty($dt->tot_ett)?$dt->tot_ett:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->endoscopy)?$dt->endoscopy:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->echo)?$dt->echo:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->dyalysis)?$dt->dyalysis:0 }}</td>
                                        <td style="text-align:center;">{{ !empty($dt->dressing)?$dt->dressing:0 }}</td>
                                    </tr>

                                    <div style="display: none">{{ $total_opd += $dt->opd }}</div>
                                    <div style="display: none">{{ $total_ipd_adm += $dt->ipd_adm }}</div>
                                    <div style="display: none">{{ $total_ot += $dt->ot }}</div>
                                    <div style="display: none">{{ $total_procedu_re += $dt->procedu_re }}</div>
                                    <div style="display: none">{{ $total_pathology += $dt->pathology }}</div>
                                    {{-- <div style="display: none">{{ $total_x_ray += $dt->x_ray }}</div> --}}
                                    <div style="display: none">{{ $total_ett += $dt->tot_ett }}</div>
                                    <div style="display: none">{{ $total_endoscopy += $dt->endoscopy }}</div>
                                    <div style="display: none">{{ $total_echo += $dt->echo }}</div>
                                    <div style="display: none">{{ $total_dyalysis += $dt->dyalysis }}</div>
                                    <div style="display: none">{{ $total_radiogy += $dt->radiology }}</div>
                                    <div style="display: none">{{ $total_dressing += $dt->dressing }}</div>

                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="2" style="text-align:right;">Total =</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_opd }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_ipd_adm }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_ot }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_procedu_re }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_pathology }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_radiogy }}</th>
                                {{-- <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_x_ray }}</th> --}}
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_ett }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_endoscopy }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_echo }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_dyalysis }}</th>
                                <th class="text-left bg-light-blue" style="text-align:center;">{{ $total_dressing }}</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
    </main>


</body>

</html>
