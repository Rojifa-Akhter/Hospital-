<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
@include('admin.components.pdf_header_bonus')
@if ($type == 'pdf')
    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px; ">
                        Prepared By<div style="line-height:0.5;">(Human Resources Dept.)</div>
                    </span>
                </td>
                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px">
                        Reviewed By HOD<div style="line-height:0.5;">(Human Resources Dept.)</div>
                    </span>
                </td>
                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px">
                        Checked By<div style="line-height:0.5;">(Finance & Accounts Dept.)</div>
                    </span>
                </td>
                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px">
                        Reviewed By HOD<div style="line-height:0.5;">(Finance & Accounts Dept.)</div>
                    </span>
                </td>

                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px">
                        Recommended By<div style="line-height:0.5;">Chief Executive Officer(CEO)</div>
                    </span>
                </td>

                <td style="text-align:center;border-top: black solid 1px;">
                    <span style="padding:10px;font-size:8px">
                        Approved By<div style="line-height:0.5;">Managing Director(MD)</div>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <footer style="position: fixed;">
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
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
@endif
<main>
    <div class="wrapper">
        <div style=" text-align:center; margin-bottom:5px;" class="mb-2">
            @if ($type == 'pdf')
                <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">Festival Bonus -
                    {{ $festival }}, {{ $year }}</span>
            @else
                <span class="report-name"
                    style="width:70%; border:solid black 1px; padding:10px; font-size:14px;  "><strong>Festival Bonus -
                        {{ $festival }}, {{ $year }}</strong></span>
            @endif
        </div>
        <section id="lp-items">
            <div class="container">
                <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">

                    <thead>
                        <tr class="table-tr" style="background-color: #E3E3E3;">
                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>SL</strong>
                            </th>

                            <th class="text-left" style="text-align: center;" scope="col">
                                <strong>Emp. ID</strong>
                            </th>
                            <th class="text-left" style="text-align: left; " scope="col">
                                <strong>Emp. Name</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Designation</strong>
                            </th>
                            <th class="text-left" style="text-align: left; width:70px;" scope="col">
                                <strong>DOJ</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Department </strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Unit </strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Employment Nature</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Religion</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Basic</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Gross Salary</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Service Length</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Bonus Percent</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Bonus Amt.</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Account No.</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Bank Name</strong>
                            </th>
                            <th class="text-left" style="text-align: left;" scope="col">
                                <strong>Remarks</strong>
                            </th>
                        </tr>
                    </thead>
                    @php
                        $total_basic = 0;
                        $total_gross = 0;
                        $total_bonus = 0;
                        $total_percent = 0;
                    @endphp
                    @if (isset($bonusData))
                        @foreach ($bonusData as $data)
                            <tr class="table-tr">
                                <td class="text-left" style="text-align: center;" scope="col">
                                    <strong>{{ $loop->iteration }}</strong>
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $data->person_code }}
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $data->full_name }}
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->designation }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->department }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $data->unit }}
                                </td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->nature_of_emp }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $data->religion }}
                                </td>
                                <td class="text-left" style="text-align: right;" scope="col">
                                    {{ $data->basic_salary }}</td>
                                <td class="text-left" style="text-align: right;" scope="col">
                                    {{ $data->gross_salary }}</td>
                                <td class="text-left" style="text-align: center;" scope="col">
                                    {{ $data->service_length }}</td>
                                <td class="text-left" style="text-align: center;" scope="col">
                                    {{ $data->bonus_per }}</td>
                                <td class="text-left" style="text-align: right;" scope="col">
                                    {{ $data->bonus_amt }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->bank_acc_no }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">
                                    {{ $data->bank_name }}</td>
                                <td class="text-left" style="text-align: left;" scope="col">{{ $data->remarks }}
                                </td>
                            </tr>
                            @php
                                $bonus_perc_num = (int) str_replace('%', '', $data->bonus_per);
                                $total_basic = $total_basic + $data->basic_salary;
                                $total_gross = $total_gross + $data->gross_salary;
                                $total_bonus = $total_bonus + $data->bonus_amt;
                                $total_percent = $total_percent + $bonus_perc_num;
                            @endphp
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="9" style="text-align:right; font-weight:bold">Total =</td>
                        <td style="text-align:right">{{ $total_basic }}</td>
                        <td style="text-align:right">{{ $total_gross }}</td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right"></td>
                        <td style="text-align:right">{{ $total_bonus }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                @if ($type != 'pdf')
                    <div class="signature_" style="text-align:center">
                        <table style="width: 100%;">
                            <tr style=" ">
                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px; ">
                                        Prepared By<div style="line-height:0.5;">(Human Resources Dept.)</div>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px">
                                        Reviewed By HOD<div style="line-height:0.5;">(Human Resources Dept.)</div>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px">
                                        Checked By<div style="line-height:0.5;">(Finance & Accounts Dept.)</div>
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px">
                                        Reviewed By HOD<div style="line-height:0.5;">(Finance & Accounts Dept.)</div>
                                    </span>
                                </td>

                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px">
                                        Recommended By<div style="line-height:0.5;">Chief Executive Officer(CEO)</div>
                                    </span>
                                </td>

                                <td style="text-align:center;">
                                    <span style="padding:10px;font-size:8px">
                                        Approved By<div style="line-height:0.5;">Managing Director(MD)</div>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>
</main>
</body>

</html>
