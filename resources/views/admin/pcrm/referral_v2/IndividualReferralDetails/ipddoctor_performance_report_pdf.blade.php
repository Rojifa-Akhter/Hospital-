<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (!empty($type) != 'DEPT')
            OPD Doctor Performance
        @else
            Department Wise Performance
        @endif Summary
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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


        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 20%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <img src="data:image/png;base64, {{ $barcode_no }} " width="200" height="40" />
                    </div>

                </td>
            </tr>
        </table>
    </header>
    <div style="width: 100%;">
        <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
            <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">
                @if (!empty($type) != 'DEPT')
                    IPD Doctor Performance
                @else
                    IPD Department Wise Performance
                @endif Summary

            </span>
        </div>
    </div>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">

                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> MANAGER </span>
                </td>
            </tr>
        </table>
    </div>

    <footer class="">
        <div class="footer ">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
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


    <main class="">
        <div class="wrapper">


            <table>
                @if ($department != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> department </th>
                        <td style="text-align: left ;border:none"> : {{ $department }}</td>
                    </tr>
                @endif
                @if ($from_date != '' && $to_date != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> From date </th>
                        <td style="text-align: left ;border:none"> : {{ $from_date }}, <strong> To date
                            </strong> : {{ $to_date }}</td>
                    </tr>
                @elseif ($from_date != '')
                    <tr>
                        <th style="text-align: left ;border:none;padding:5px;width:100px"> Date</th>
                        <td style="text-align: left ;border:none"> : {{ $from_date }}</td>
                    </tr>
                @endif

            </table>



            <section id="lp-items ">
                <div class="container ">


                    <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-center">SL#</th>
                                <th class="text-center">Doctor Name</th>
                                <th class="text-center">Department</th>
                                <th class="text-center">No Of IPD Patient</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_no_of_patient = 0;
                        @endphp
                            @if (!empty($doctorPerformanceSummary))

                                @foreach ($doctorPerformanceSummary as $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->primary_doctor_name }}</td>
                                        <td class="text-center">{{ $data->dept }}</td>
                                        <td class="text-center" style="text-align: center;">{{ $data->no_of_patient }}</td>
                                    </tr>
                                    <div style="display: none">{{ $total_no_of_patient += $data->no_of_patient }}</div>
                                @endforeach

                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-right" colspan="3" style="text-align: right;">Total =</th>
                                <th class="text-center bg-light-blue">{{ $total_no_of_patient }}</th>
                            </tr>
                        </tfoot>


                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
