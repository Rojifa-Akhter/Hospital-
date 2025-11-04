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
                                                    <table class="" style="width:  100%">
                                                        <tr>
                                                            <td style="width:30px">
                                                                    @if ( $po_hospital_details->logo !="")
                                                                    <img class="hospital-logo"
                                                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                                                    width="60" alt="">
                                                                    @endif


                                                            </td>
                                                            <td style="text-align:center;">
                                                                <span> <strong>   {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                                                    </strong></span> <br>
                                                                <span style=""> Wages & Allowance Details <br>
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

                                                                {{-- <img src="data:image/png;base64, {{ $barcode_no }} "
                                                                    style="width: 100%" /> --}}


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
                                            <tr class="table-tr">
                                                <td style="margin-left: 5px">
                                                    <div style="padding-left: 2px"> Loan </div>
                                                </td>
                                                <td style="text-align: right;"> {{ $data->loan_deduct_amount }}</td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td>
                                                    <div style="padding-left: 2px"> Total Payable </div>
                                                </td>
                                                <td style="text-align: right;"> {{ number_format(isset($salary) ? $salary : 0, 2) }}</td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td colspan="2">
                                                    <div style="margin-top: 95px; text-align: right;">
                                                        <span style="border-top: 1px solid black ; "> Acknlowdgement &
                                                            Date </span>
                                                    </div>

                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </td>



                                <td>
                                    <div style="width: 430px; height: 331px; margin-left: 15px">
                                        <table style="  width: 100%; border-collapse:collapse;" cellpadding="1"
                                            cellspacing="0" border="1">
                                            <tr class="table-tr">
                                                <td colspan="3">
                                                    <table class="" style="width:  100%">
                                                        <tr>
                                                            <td style="width:40px">
                                                                 @if ( $po_hospital_details->logo !="")
                                                                    <img class="hospital-logo"
                                                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                                                    width="60" alt="">
                                                                    @endif
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <span> <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                                                    </strong></span> <br>
                                                                <span> Wages & Allowance Details <br>
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
                                                                    } elseif ($divid[1] == 10) {
                                                                    echo 'October';
                                                                    } elseif ($divid[1] == 11) {
                                                                    echo 'November';
                                                                    } elseif ($divid[1] == 12) {
                                                                    echo 'December';
                                                                    }
                                                                    echo ' - ' . $divid[0];
                                                                    ?>
                                                                </span><br>

                                                            </td>
                                                            <td style=" text-align:right; width:60px">

                                                                {{-- <img src="data:image/png;base64, {{ $barcode_no }} "
                                                                    style="width:60px" /> --}}


                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>

                                            <tr class="table-tr">
                                                <td colspan="3">
                                                    <table style="width:  100%">
                                                        <tr class="table-tr">
                                                            <td style="width: 50px"> Card No</td>
                                                            <td> : {{ $data->card_no }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Name</td>
                                                            <td> : {{ $data->full_name }}</td>
                                                        </tr>

                                                        <tr class="table-tr">
                                                            <td> Designation</td>
                                                            <td> : {{ $data->designation_name }}</td>
                                                        </tr>


                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td>
                                                    <table style="width:  100%">
                                                        <tr class="table-tr">
                                                            <td>Basic</td>
                                                            <td style="text-align: right;"> {{ $data->basic_salary }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>House</td>
                                                            <td style="text-align: right;"> {{ $data->house_rent }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Medical</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->medical_allowance }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Conveyance</td>
                                                            <td style="text-align: right;"> {{ $data->conveyance_allowance }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>D/A</td>
                                                            <td style="text-align: right;"> {{ $data->ta_da_allowance }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Other Allowance</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->other_allowance }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Gross Wages</td>
                                                            <td style="text-align: right;"> {{ $data->gross_salary }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Attendance Bonus</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->attendance_bonus }}</td>
                                                        </tr>

                                                        <tr class="table-tr">
                                                            <td>Working Days</td>
                                                            <td style="text-align: right;"> {{ $data->working_days }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Attendance days</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->attendance_days }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Leave days</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->leave_days }}</td>
                                                        </tr>


                                                    </table>
                                                </td>


                                                <td>
                                                    <table style="width:  100%; ">
                                                        <tr class="table-tr">
                                                            <td>Absent days</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->absent_days }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Late days / Min</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->late_days }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>OT Hour</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->overtime_hours }}
                                                                <?php
                                                                // $min=$data->overtime_hours;
                                                                //$hours = intdiv($min, 60).':'. ($min % 60);
                                                                // echo $hours;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>OT rate</td>
                                                            <td style="text-align: right;">{{ $data->overtime_rate }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>OT amt</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->overtime_amount }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Absent Deduction</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->att_deduct_amount }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Disciplinary Action</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->disciplinary_action }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Savings fund</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->personal_savings_amount }}</td>
                                                        </tr>


                                                    </table>
                                                </td>
                                                <td>
                                                    <table style="width:  100%">
                                                        <tr class="table-tr">
                                                            <td> Residence fee </td>
                                                            <td style="text-align: right;">
                                                                {{ $data->residence_fee }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Loan</td>
                                                            <td style="text-align: right;">
                                                                {{ $data->loan_deduct_amount }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Total Payable</td>
                                                            <td style="text-align: right;">
                                                                {{ number_format(isset($salary) ? $salary : 0, 2) }}
                                                            </td>
                                                        </tr>

                                                        <tr class="table-tr">
                                                            <td colspan="2">
                                                                <div style="margin-top: 70px ; text-align: right;">

                                                                    <span style="border-top: 1px solid black">
                                                                        Authorized Signature </span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
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
