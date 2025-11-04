<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bonus Report</title>
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
            <td style="width: 15%;">
                <img class="hospital-logo" src="{{ asset('images/kbmh.jpg') }}" width="60" alt="">
            </td>
            <td style="text-align:center;">
                <span style="font-size: 15px;"> <strong> Khwaja Badrudduja Modern Hospital </strong></span> <br>
                Address: <span> Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur.</span><br>
                Phone No: <span> 01776-606262</span>
            </td>
            <td style=" text-align:right; width: 15%; ">
                <div style="">
                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                </div>

            </td>
        </tr>
    </table>
</header>
<div style="width: 100%;">
    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
               <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Bank Wise Bonus Report</span>
    </div>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


               <span class="report-date"><strong>Bonus Effected On Year: </strong>
                   @php
                       if ($month == '01') {
                           echo 'January';
                       } elseif ($month == '02') {
                           echo 'February';
                       } elseif ($month == '03') {
                           echo 'March';
                       } elseif ($month == '04') {
                           echo 'April';
                       } elseif ($month == '05') {
                           echo 'May';
                       } elseif ($month == '06') {
                           echo 'June';
                       } elseif ($month == '07') {
                           echo 'July';
                       } elseif ($month == '08') {
                           echo 'August';
                       } elseif ($month == '09') {
                           echo 'September';
                       } elseif ($month == '10') {
                           echo 'October';
                       } elseif ($month == '11') {
                           echo 'November';
                       } elseif ($month == '12') {
                           echo 'December';
                       }
                   @endphp
                   {{ $year }}

               </span>
    </div>
</div>

<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                       <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                       </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> MANAGING DIRECTOR </span>
            </td>
        </tr>
    </table>
</div>

<footer class="">
    <div class="footer ">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y H:m:s');
                            @endphp
                            {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                        </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>


<main class="">
    <div class="wrapper">

        <section id="lp-items ">
            <div class="container ">
                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead style="">
                    <tr class="table-tr" style="background-color: #E3E3E3; ">
                        <th class=" table-td" rowspan="2"> <strong>SL# </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Card No </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Name </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Join Date </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Present Date </strong></th>
                        <th class=" table-td" colspan="2"> <strong>Duration </strong></th>
{{--                        <th class="text-center" rowspan="2">Payable Amount</th>--}}
                        <th class=" table-td" rowspan="2"> <strong>Gross Salary </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Bonus Percentage </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Bonus(Tk) </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Signature </strong></th>
                    </tr>
                    <tr class="table-tr" style="background-color: #E3E3E3;">
                        <td class="table-td" style="text-align: center"> <strong>Year </strong></td>
                        <td class="table-td" style="text-align: center"> <strong>Month </strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $listSl = 0;$all_bonus_data = 0; $b = 0; @endphp



                    @if (!empty($emp_data))
                        @foreach ($emp_data as $bank => $bank_data)

                            @php
                                $ban = 0;
                                $all_bonus_data = 0;
                                 $bonus_data =0;
                            @endphp

                            @foreach ($bank_data as $dept => $dept_data)


                                @foreach ($dept_data as $desig => $data1)
                                    <?php
                                    $this_month = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                                    $start_month = \Carbon\Carbon::parse(date('Y-m-d',strtotime($data1->join_date)))->floorMonth(); // returns 2019-06-01
                                    $diff = $start_month->diffInMonths($this_month);  // returns 1

                                    ?>
                                    @if($diff < 3)
                                        <?php $bonus = ($data1->gross_salary) * 10/100; ?>
                                    @elseif($diff == 3 || $diff < 6)
                                        <?php $bonus = ($data1->gross_salary) * 30/100; ?>
                                    @elseif($diff == 6 || $diff < 12)
                                        <?php $bonus =  ($data1->gross_salary) * 40/100; ?>
                                    @else
                                        <?php $bonus = ($data1->gross_salary) * 50/100; ?>
                                    @endif
                                    <?php
                                    $bonus_data += $bonus;
                                    $all_bonus_data += $bonus; ?>

                                @endforeach
                            @endforeach



                            @foreach ($bank_data as $dept => $dept_data)

                                @php
                                    $dep = 0;
                                    $total_salary = 0;
                                    $bonus_data = 0;
                                    $total_gross_salary = 0;


                                @endphp





                                @foreach ($dept_data as $desig => $data)
                                    @php
                                        $total_salary += $data->payable_amount;
                                        $total_gross_salary += $data->gross_salary;
                                        $des = 0;

                                        $listSl++;
                                        $ban++;
                                        $dep++;
                                    @endphp
                                    @if ($ban == 1)




                                        <tr class="page-break">
                                            <td class="border-0" colspan="11" style="text-align: center;">
                                                <strong> Bank Name = </strong>{{ $bank }}
                                                <strong> Total Employee = </strong>
                                                {{ isset($count_depart_emp_bank_wise[$bank]) ? $count_depart_emp_bank_wise[$bank] : '0' }}
                                                 <strong> Total Bonus salary = </strong>
                                                {{ isset($all_bonus_data) ? number_format($all_bonus_data, 2) : '0' }}



                                            </td>
                                        </tr>
                                    @endif

                                    @if ($dep == 1)

                                        <tr class="">
                                            <td class="border-0" colspan="11">
                                                <strong> Department = </strong>{{ $dept }}
                                                <strong> Total Employee = </strong>
                                                <?php echo count($bank_data[$dept]); ?>

                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="table-tr" >
                                        <td class="table-td" style="text-align: center;"
                                            style="text-align: center;" scope="col">
                                            <strong>{{ $listSl }}</strong>
                                        </td>
                                        <td class="table-td" style="text-align: left;">{{ $data->card_no }}
                                        </td>
                                        <td class="table-td" style="text-align: left;">
                                            {{ $data->full_name }}
                                            <br><strong>{{ $data->designation_name }}</strong>
                                        </td>

                                        <td class="table-td" style="text-align: left;">
                                            {{date('d/m/Y',strtotime($data->join_date))}}</td>

                                        <td class="table-td" style="text-align: left;">
                                            {{date('d/m/Y')}}</td>

                                        <td class="table-td" style="text-align: left;">
                                            <?php
                                            $this_month1 = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                                            $start_month1 = \Carbon\Carbon::parse(date('Y-m-d',strtotime($data->join_date)))->floorMonth(); // returns 2019-06-01
                                            $diffYear = $start_month1->diffInYears($this_month1);  // returns 1

                                            ?>
                                            {{ $diffYear }}
                                        </td>
                                        <td class="text-left" style="text-align: left;">
                                            <?php
                                            $this_month = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                                            $start_month = \Carbon\Carbon::parse(date('Y-m-d',strtotime($data->join_date)))->floorMonth(); // returns 2019-06-01
                                            $diff = $start_month->diffInMonths($this_month);  // returns 1

                                            $diffMonth = $diff % 12;
                                            ?>
                                            {{ $diffMonth }}

                                        </td>
{{--                                        <td class="text-right"> {{ $data->payable_amount}} </td>--}}
                                        <td class="table-td" style="text-align: right;">{{ $data->gross_salary }} </td>
                                        <td class="text-left" style="text-align: center;">
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
                                        <td class="text-left" style="text-align: right;">
                                            @if($diff < 3)
                                                <?php $bonus = ($data->gross_salary) * 10/100; ?>
                                                {{$bonus}}
                                            @elseif($diff == 3 || $diff < 6)
                                                <?php $bonus = ($data->gross_salary) * 30/100; ?>
                                                {{$bonus}}
                                            @elseif($diff == 6 || $diff < 12)
                                                <?php $bonus =  ($data->gross_salary) * 40/100; ?>
                                                {{$bonus}}
                                            @else
                                                <?php $bonus = ($data->gross_salary) * 50/100; ?>
                                                {{$bonus}}
                                            @endif
                                        </td>
                                        <td class="text-left" style="text-align: right; " ></td>


                                    </tr>
                                    <?php $bonus_data += $bonus; $all_bonus_data += $bonus; ?>

                                @endforeach
                                <tr>
                                    <td colspan="9" align="right">
                                <td  align="right">

                                        <strong> Total Bonus: </strong><?php echo
                                        number_format($bonus_data, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                            @php Cache::put('total_bonus',$all_bonus_data); @endphp
                        @endforeach

                    @endif

                    </tbody>


                </table>
            </div>
        </section>
    </div>
</main>


<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                       <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                       </span>
            </td>
            <td style=" ">
                       <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                       </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> MANAGING DIRECTOR </span>
            </td>
        </tr>
    </table>
</div>

<footer class="">
    <div class="footer ">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                            @php
                                date_default_timezone_set('Asia/Dhaka');
                                $date = date('d/m/Y H:m:s');
                            @endphp
                            {{ $date }}
                        </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                        </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
</body>

</html>
