@include('admin.components.pdf_header')
<div style="width: 100%;">
    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Employee Bonus
            Report</span>
    </div>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">


        <span class="report-date"><strong>Bonus Effected On Year: </strong> {{ $year }}
{{--            </br> <strong> Month: </strong>--}}
{{--            @php--}}
{{--                if ($month == '01') {--}}
{{--                    echo 'January';--}}
{{--                } elseif ($month == '02') {--}}
{{--                    echo 'February';--}}
{{--                } elseif ($month == '03') {--}}
{{--                    echo 'March';--}}
{{--                } elseif ($month == '04') {--}}
{{--                    echo 'April';--}}
{{--                } elseif ($month == '05') {--}}
{{--                    echo 'May';--}}
{{--                } elseif ($month == '06') {--}}
{{--                    echo 'June';--}}
{{--                } elseif ($month == '07') {--}}
{{--                    echo 'July';--}}
{{--                } elseif ($month == '08') {--}}
{{--                    echo 'August';--}}
{{--                } elseif ($month == '09') {--}}
{{--                    echo 'September';--}}
{{--                } elseif ($month == '10') {--}}
{{--                    echo 'October';--}}
{{--                } elseif ($month == '11') {--}}
{{--                    echo 'November';--}}
{{--                } elseif ($month == '12') {--}}
{{--                    echo 'December';--}}
{{--                }--}}
{{--            @endphp--}}

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

<footer>
    <div class="footer">
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
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>

<main>
    <div class="wrapper">

        <section id="lp-items">
            <div class="container">
                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead style="">
                    <tr class="table-tr" style="background-color: #E3E3E3; ">
                        <th class=" table-td" rowspan="2"> <strong>SL# </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Card No </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Name </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Join Date </strong></th>
                        <th class=" table-td" rowspan="2"> <strong>Present Date </strong></th>
                        <th class=" table-td" colspan="2"> <strong>Duration </strong></th>
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
                        $listSl = 0; @endphp
                    @if (!empty($emp_data))
                        @foreach ($emp_data as $dept => $dept_data)
                            @php
                                $dep = 0;
                                $bonus_data = 0;
                            @endphp

                            @foreach ($dept_data as $desig => $data)

                                @php
                                    $des = 0;
                                    $listSl++;
                                    $dep++;

                                @endphp
                                @if ($dep == 1)

                                    <tr class="">
                                        <td class="border-0" colspan="11">
                                            <strong> Department = </strong>{{ $dept }}
                                            <strong> Total Employee = </strong>
                                            {{ isset($count_depart_emp[$dept]) ? $count_depart_emp[$dept] : '0' }}
{{--                                            <strong> Total Salary = </strong>--}}
{{--                                            {{ isset($total_salary[$dept]) ? number_format($total_salary[$dept], 2) : '0' }}--}}
                                            <strong> Total Gross Salary = </strong>
                                            {{ isset($total_gros_salary[$dept]) ? number_format($total_gros_salary[$dept], 2) : '0' }}

                                        </td>
                                    </tr>
                                @endif
                                <tr class="table-tr">
                                    <td class="table-td" style="text-align: center;" style="text-align: center;"
                                        scope="col"><strong>{{ $listSl }}</strong></td>
                                    <td class="table-td" style="text-align: left;">{{ $data->card_no }} </td>
                                    <td class="table-td" style="text-align: left;">{{ $data->full_name }}
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
                                    <td class="table-td" style="text-align: left;" > </td>


                                </tr>

                                <?php $bonus_data += $bonus; ?>

                            @endforeach
                            <tr>
                                <td colspan="9" style="text-align: right">
                                    <strong>Total Bonus =</strong>

                                </td>
                                <td style="text-align: right">
                                   <strong>{{$bonus_data}}</strong>
                                </td>
                                <td >

                                </td>
                            </tr>

                        @endforeach

                    @endif
                    </tbody>


                </table>
            </div>
        </section>
    </div>
</main>


</body>

</html>
