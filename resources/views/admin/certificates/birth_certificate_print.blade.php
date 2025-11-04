<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Birth Certificate</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/invoice.css" media="all" />
    <style type="text/css">
        @page {
            margin-top: 0cm;
            margin-bottom: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            margin-top: 3.9cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
            margin-bottom: 2cm;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: 1.1cm;
            vertical-align: text-bottom;
            padding-top: 10px;
            /* text-align: center; */
            font-size: 9px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
        }

        .footer_2 {

            position: fixed;

            z-index: 999999999;

            bottom: 0cm;

            left: 1cm;

            right: 1cm;

            height: 7cm;

            vertical-align: text-top !important;

            padding-bottom: 15px;



            /* text-align: center; */

            /* font-size: 9px; */

        }

        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            border-bottom: none !important;

            /* left: 0;
            right: 0;
            height: 2.5cm;
            font-size: 9px; */
            /*top: -10px;*/
            /* border-top: 1px solid black;
            padding-top: 10px;
            z-index: 999999999; */
        }

        table tr th {
            border: 0px;
            background-color: white;
            color: #222;
        }

        table tr td {
            border: 0px;
        }

        table {
            border: 0px;
        }
    </style>
</head>
<?php
$data = json_decode(json_encode($report_data->certificate_json),true);
 $strA = $data;
$arrDt = explode(":", $strA);
?>

<body  onload="window.print()">
    <header>
        <div style="width:800px; height:500px; padding:20px; text-align:center; border: 10px solid #787878">
            <div style="width:750px; height:450px; padding:20px; text-align:center; border: 5px solid #787878">
                <div>

                    <table width="100%" style="padding: 0px; margin:0px">
                        <tr>
                            <td style="text-align:left" width="30%"> <img style=""
                                    src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                                <br>
                                {{ $report_header->patient_code }}
                            </td>
                            <td style="text-align: center">
                                {{-- <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/header_image2022_06_16_06_05.png') }}"
                                    width="150px" alt=""> --}}


                                    <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="50px"
                                    alt="">
                                <br>
                                <span style="font-size:30px; font-weight:bold;font-family:Goudy Old Style;">Birth
                                    Certificate</span>
                            </td>
                            <td style="text-align: right" width="30%">
                                <img style="" src="data:image/png;base64, {{ $admission_id }} "
                                    style="width: 120px; " /> <br>
                                {{ $report_header->admission_uid }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div style="width:880px; height:250px; padding:20px;">
            <div style="width:750px; height:400px; padding:0px 20px 0px 20px;">
                <div>
                    <table width="100%" style="padding: 0px; margin:0px">
                        {{-- <tr style="line-height:50px; font-size:18px;">
                            <td style="text-align:left" width="100%" colspan="2">
                                Ref:-
                            </td>
                        </tr> --}}

                        <tr style="line-height:50px; font-size:18px;">
                            <td style="text-align:left;width:50%;">
                                <span>This is to certify that Mrs <b><?php print_r($arrDt[7]); ?></b></span>
                            </td>
                            <td style="text-align:left;width:50%;">
                                <span>Age <b><?php print_r($arrDt[9]); ?></b></span>
                            </td>
                        </tr>

                        <tr style="line-height:50px; font-size:18px;">
                            <td style="text-align:left;width:50%;">
                                <span>W/O <b><?php print_r($arrDt[8]); ?></b></span>
                            </td>
                            <td style="text-align:left;width:50%;">
                                <span>Address <b><?php print_r($arrDt[10]); ?></b></span>
                            </td>
                        </tr>

                        <tr style="line-height:50px; font-size:18px;">
                            <td style="text-align:left;width:50%;">
                                <span>Gave birth a  <b>{{ $report_header->gender_txt }}</b> child on <b><?php print_r($arrDt[12]); ?></b></span>
                            </td>
                            <td style="text-align:left;width:50%;">
                                <span>at <b><?php print_r($arrDt[13]); ?>:<?php print_r($arrDt[14]); ?></b></span>
                            </td>
                        </tr>
                        <tr style="line-height:50px; font-size:18px;">
                            <td style="text-align:left;width:50%;" colspan="2">
                                <span>Baby's Name  <b><?php print_r($arrDt[11]); ?></b></span>
                            </td>
                        </tr>

                        <tr style="line-height:30px; font-size:18px;">
                            <td style="text-align:center;width:50%;">
                                <span>Superintendent</span>
                            </td>
                            <td style="text-align:center;width:50%;">
                                <span>Medical Officer</span>
                            </td>
                        </tr>

                        <tr style="line-height:30px; font-size:18px;">
                            <td style="text-align:center;width:50%;">
                                <span> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</span>
                            </td>
                            <td style="text-align:center;width:50%;">
                                <span> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</span>
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>
    </main>


</body>

</html>
