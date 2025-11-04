<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lp Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
        @page {
            margin: .2cm .2cm;
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
            margin-top: .5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: .5cm;
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

    </style>
</head>

<body>



<main class="mt-5" style="">
    <div class="wrapper">

        <section id="lp-items">
            <div class="container" style="">

                @if (isset($data))

                    <table style=" width: 100%;">
                        <tr>
                            <td>
                                <div style="width: 300px; height: 331px">
                                    <table style=" width: 100%; border-collapse:collapse;" cellpadding="1"
                                           cellspacing="0" border="1">
                                        <tr class="table-tr">
                                            <td colspan="2">
                                                <!--  <div style="text-align: center;" >
                       Khwaja Badrudduja Modern Hospital.  Pay Slip <br>
                       Wages & allowance Details Dec 2020
                   </div> -->


                                                <table class="" style="width:  100%">
                                                    <tr>
                                                        <td style="width:30px">
                                                            <img class="hospital-logo"
                                                                 src="{{ asset('images/kbmh.jpg') }}"
                                                                 style="width: 100%" alt="">
                                                        </td>
                                                        <td style="text-align:center;">
                                                                <span> <strong> Khwaja Badrudduja Modern Hospital
                                                                    </strong></span> <br>
                                                            <span style=""> Employee Bonus Details <br>
                                                                    <?php
                                                                $year_month = $data->salary_yyyymm;

                                                                $divid = str_split($year_month, 4);
                                                                if ($divid[1] == '01') {
                                                                    echo 'January';
                                                                } elseif ($divid[1] == '02') {
                                                                    echo 'February';
                                                                } elseif ($divid[1] == '03') {
                                                                    echo 'March';
                                                                } elseif ($divid[1] == '04') {
                                                                    echo 'April';
                                                                } elseif ($divid[1] == '05') {
                                                                    echo 'May';
                                                                } elseif ($divid[1] == '06') {
                                                                    echo 'June';
                                                                } elseif ($divid[1] == '07') {
                                                                    echo 'July';
                                                                } elseif ($divid[1] == '08') {
                                                                    echo 'August';
                                                                } elseif ($divid[1] == '09') {
                                                                    echo 'September';
                                                                } elseif ($divid[1] == '10') {
                                                                    echo 'October';
                                                                } elseif ($divid[1] == '11') {
                                                                    echo 'November';
                                                                } elseif ($divid[1] == '12') {
                                                                    echo 'December';
                                                                }
                                                                echo ' - ' . $divid[0];
                                                                ?>
                                                                </span><br>

                                                        </td>
                                                        <td style=" text-align:right; width:30px">

                                                            <img src="data:image/png;base64, {{ $barcode_no }} "
                                                                 style="width: 100%" />


                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="table-tr">
                                            <td colspan="2">
                                                <table style="width:  100%">
                                                    <tr class="table-tr">
                                                        <td style="width: 50px">Card No</td>
                                                        <td> : {{ $data->card_no }}</td>
                                                    </tr>
                                                    <tr class="table-tr">
                                                        <td>Name</td>
                                                        <td> : {{ $data->full_name }}</td>
                                                    </tr>
                                                    <tr class="table-tr">
                                                        <td>Designation</td>
                                                        <td> : {{ $data->designation_name }}</td>
                                                    </tr>


                                                </table>
                                            </td>
                                        </tr>
{{--                                        <tr class="table-tr">--}}
{{--                                            <td style="margin-left: 5px">--}}
{{--                                                <div style="padding-left: 2px"> Loan </div>--}}
{{--                                            </td>--}}
{{--                                            <td style="text-align: right;"> {{ $data->loan_deduct_amount }}</td>--}}
{{--                                        </tr>--}}
                                        <tr class="table-tr">
                                            <td>
                                                <div style="padding-left: 2px"> Gross Salary </div>
                                            </td>
                                            <td style="text-align: right;"> {{ $data->gross_salary }}</td>
                                        </tr>
                                        <tr class="table-tr">
                                            <td>
                                                <div style="padding-left: 2px"> Join Date </div>
                                            </td>
                                            <td style="text-align: right;"> {{ date('d/m/Y',strtotime($data->join_date)) }}</td>
                                        </tr>
                                        <tr class="table-tr">
                                            <td>
                                                <div style="padding-left: 2px"> Bonus Percentage </div>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $this_month = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                                                $start_month = \Carbon\Carbon::parse(date('Y-m-d',strtotime($data->join_date)))->floorMonth(); // returns 2019-06-01
                                                $diff = $start_month->diffInMonths($this_month);  // returns 1
//                                                $diffMonth = $diff % 12;
//                                                {{dd($diff);}}

                                                ?>

                                                    @if($diff < 3)
                                                        {{ '10%' }}
                                                    @elseif($diff == 3 || $diff < 6)
                                                        {{ '30%' }}
                                                    @elseif($diff == 6 || $diff < 12)
                                                        {{ '40%' }}
                                                    @else
                                                        {{ '50%' }}

                                                    @endif


                                            </td>

                                        </tr>
                                        <tr class="table-tr">
                                            <td>
                                                <div style="padding-left: 2px"> Bonus(Tk) </div>
                                            </td>
                                            <td style="text-align: right;">
                                                @if($diff < 3)
                                                    {{ ($data->gross_salary) * 10/100 }}
                                                @elseif($diff == 3 || $diff < 6)
                                                    {{ ($data->gross_salary) * 30/100 }}
                                                @elseif($diff == 6 || $diff < 12)
                                                    {{ ($data->gross_salary) * 40/100 }}
                                                @else
                                                    {{ ($data->gross_salary) * 50/100 }}

                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="table-tr">
                                            <td colspan="2">
                                                <div style="margin-top: 55px; text-align: right;">
                                                        <span style="border-top: 1px solid black ; "> Acknlowdgement &
                                                            Date </span>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr class="table-tr" style="border-top: 1px solid black ; ">
                                            <td colspan="2">
                                                <div style="padding-left: 2px;text-align: right"> Powered By - NextGenIt Ltd </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                        </tr>
                    </table>
                @endif
            </div>
        </section>
    </div>
</main>
