<html>

<head>

    <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <style>
        .board_member_img {
            border: 1px solid black;
            width: 50px;
        }
    </style>

    <style>
        .custom_inline_input {
            border: 0px;
            outline: 0;
            background-color: transparent;
            border-bottom: 1px dotted #222;
            /*display: block;*/
        }

        .custom_inline_input2 {
            width: 465px;
        }

        .w-30 {
            width: 30%
        }

        .w-50px {
            width: 50px
        }

        .w-100px {
            width: 100px
        }

        .v-align-top {
            vertical-align: top !important;
        }

        table tr {
            border-bottom: none;
        }

        .instraction-page>ul>li {
            margin-bottom: 20px;
        }
    </style>


    <style>
        /*  @page {
        margin: 1cm 0.3cm;
        /!*width: 450px;*!/
        padding:8px;
        }*/
        @page {
            /*margin-top: 150px;*/
            /*margin-bottom: 120px*/
        }

        .header {
            position: fixed;
            left: 0px;
            top: -140px;
            right: 0px;
            height: 100px;
            text-align: center;
        }

        /*#footer { position: fixed; left: 0px; bottom: 0; right: 0px; }*/

        footer {
            position: fixed;
            z-index: 999999999;

            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            /* border-top: 1px solid black; */
            padding-top: 10px;
        }

        body {
            /*margin-top: 5.5cm;*/
            margin-left: 0cm;
            margin-right: 0cm;

            /* margin-bottom: 0.9cm; */
            /*margin-bottom: 3.5cm;*/
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        }

        .bg-black {
            background-color: #222;
            color: #fff;
        }


        table {
            border-collapse: collapse;
            width: 100%;

        }

        table tr td,
        table tr th {
            font-size: 14px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
            /*border-width: thin;*/
        }

        .custom_inline_input {
            border: 0px;
            outline: 0;
            background-color: transparent;
            border-bottom: 1px dotted #222;
        }


        .border-0 {
            border: 0px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .w-100 {
            width: 100%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
        }

        .w-20 {
            width: 20%;
        }

        .w-25 {
            width: 25%;
        }

        .w-30 {
            width: 30%;
        }

        .w-50 {
            width: 50%;
        }

        .w-100 {
            width: 100%;
        }

        .mb-10 {
            margin-bottom: 10px;
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

        .mb-15 {
            margin-bottom: 15px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .pb-0 {
            padding-bottom: 0;
        }


        .logo {
            width: 80px;
            display: inline-block;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .hospital-names {
            margin-bottom: 0;
            font-size: 20px;
            padding-bottom: 0;
        }

        .hospital-logo-info .hospital_info .hospital-address {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }

        .hospital-logo-info .hospital_info .hospital-contact {
            font-weight: 500;
            display: block;
            line-height: 1.2;
            width: 480px;
        }

        .hospital_info {
            margin-left: 10px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .title {
            /*background-color: #444;*/
            /*display: inline-block;*/
            font-size: 14px;
            color: #000;
            padding: 5px 50px;
            border-radius: 3px;
            /*font-weight: bold;*/
        }

        .form-heading .title-name {
            font-size: 1.35rem;
            line-height: 1;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .form-heading h5 {
            font-size: 1rem;
            /*line-height: 1;*/
            margin-top: -10px;
            font-weight: 400;
        }

        .form-heading p {
            font-size: .8rem;
            margin-top: -10px;
        }

        .form-name {
            font-size: 16px;
        }

        .float-left {
            float: left;
        }

        .float-right {
            float: right;
        }

        .d-block {
            display: block;
        }

        .d-inline-block {
            display: inline-block;
        }

        .border-1 {
            border: 1px solid;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .signature {
            width: 100%;
            height: 30px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .border-right {
            border-right: 1px solid #222;
        }

        .form-check-inline {
            display: inline-block;
            align-items: center;
            padding-left: 0;
            margin-right: 0.2rem;
        }

        .form-check {
            position: relative;
        }

        .form-check-inline .form-check-input {
            position: static;
            margin-top: 5px;
            /*margin-right: 0.3125rem;*/
            margin-left: 0;
        }

        input[type=radio],
        input[type=checkbox] {
            box-sizing: border-box;
            padding: 0;
        }

        .v-align-top {
            vertical-align: top;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="form-row justify-content-center">
            <div class="col-md-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="form-content">
                            <!-- <div class="form-heading text-center border-bottom pb-3">
                            <div class="hospital-address">
                                <h1 class="mb-0 text-center">Khwaja Badrudduja Modern Hospital</h1> <br>
                                <p class="mb-0 text-center">Aziz Mansion, Shufipur, Kaliakair, Gazipur.</p> <br>
                                <p class="mb-0 text-center">Phone : 01776-606262, 01687-625565</p> <br>
                            </div>
                        </div> -->
                            <div class="form-heading  border-bottom pb-3" style="text-align:center">
                                {{-- <div id="logo" style="display:inline-block !important; ">
                                    @if (!empty($po_hospital_details->logo))
                                        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                            width="80px" />
                                    @endif
                                </div> --}}
                                <div class="hospital-address" style="display:inline-block !important; ">
                                    <h1 class="mb-0 ">
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </h1>
                                    <br>
                                    <p class="mb-0 ">
                                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                    </p>
                                    <br>

                                </div>
                            </div>

                            <div class="form-body">
                                <div class="heading text-center border-bottom mb-10">
                                    <h2>Daily Statement Report</h2>
                                    <h3>From : {{ $from_date != '' ? date('d/m/Y', strtotime($from_date)) : '' }} , To :
                                        {{ $to_date != '' ? date('d/m/Y', strtotime($to_date)) : '' }}</h3>

                                </div>
                                <table class="table data-table table-bordered ">
                                    <tr>
                                        <th style="text-align:center;" colspan="6">INDOOR PATIENT STATEMENT</th>
                                    </tr>
                                    <thead class="bg-primary">
                                        <tr>
                                            <td class="text-center" scope="col">#SL</td>
                                            <td class="text-left" scope="col">Word/Cabin</td>
                                            <!-- <td class="text-left" scope="col"> Name</td>			 -->
                                            <td class="text-left" scope="col">Previous</td>
                                            <td class="text-left" scope="col">Admission</td>
                                            <td style="width:17%" class="text-left" scope="col">Discharge</td>
                                            <td style="width:8%" class="text-left" scope="col">Present</td>
                                        </tr>
                                    </thead>
                                    @if (isset($group_records))
                                        @php
                                            $prev_pat = 0;
                                            $admission_pat = 0;
                                            $discharge_pat = 0;
                                            $total_pat = 0;
                                        @endphp
                                        @foreach ($group_records as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data['word'] }}</td>
                                                <td>
                                                    {{ $data['previous_patient'] + $data['discharge'] }}
                                                    @php
                                                        $prev_pat += $data['previous_patient'] + $data['discharge'];
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $data['admission'] }}
                                                    @php
                                                        $admission_pat += $data['admission'];
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $data['discharge'] }}
                                                    @php
                                                        $discharge_pat += $data['discharge'];
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ abs($data['previous_patient'] + $data['admission']) }}
                                                    @php
                                                        $total_pat += abs($data['previous_patient'] + $data['admission']);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Grand Total: </td>
                                            <td>{{ $prev_pat }}</td>
                                            <td>{{ $admission_pat }}</td>
                                            <td>{{ $discharge_pat }}</td>
                                            <td>{{ $total_pat }}</td>
                                        </tr>
                                    @endif
                                </table>

                                <table class="table data-table table-bordered " style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;" colspan="6">OUTDOOR PATIENT STATEMENT</th>
                                        </tr>
                                    </thead>

                                    <thead class="bg-primary">
                                        <tr>
                                            <td class="text-center" scope="col">#SL</td>
                                            <td class="text-left" scope="col">Department</td>
                                            <!-- <td class="text-left" scope="col"> Name</td>			 -->
                                            <td class="text-left" scope="col">New Patient</td>
                                            <td class="text-left" scope="col">Old Patient</td>
                                            <td style="width:17%" class="text-left" scope="col">Night Patient</td>
                                            <td style="width:8%" class="text-left" scope="col">Total Patient</td>
                                        </tr>
                                    </thead>
                                    @if (isset($opd_statement))
                                        @php
                                            $new_pat = 0;
                                            $old_pat = 0;
                                            $total_opd_pat = 0;
                                        @endphp
                                        @foreach ($opd_statement as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->department }}</td>
                                                <td>
                                                    {{ $data->new_patient }}
                                                    @php
                                                        $new_pat += $data->new_patient;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $data->old_patient }}
                                                    @php
                                                        $old_pat += $data->old_patient;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $data->night_patient }}
                                                    @php
                                                        //$discharge_pat += $data['discharge'];
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ abs($data->new_patient + $data->old_patient) }}
                                                    @php
                                                        $total_opd_pat += abs($data->new_patient + $data->old_patient);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Grand Total: </td>
                                            <td>{{ $new_pat }}</td>
                                            <td>{{ $old_pat }}</td>
                                            <td>{{ '0' }}</td>
                                            <td>{{ $total_opd_pat }}</td>
                                        </tr>
                                    @endif
                                </table>


                                <table class="table data-table table-bordered " style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;" colspan="4">DAILY INCOME STATEMENT</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <th class="text-center" scope="col">#SL</th>
                                        <th class="text-left" scope="col">Particulars</th>
                                        <!-- <td class="text-left" scope="col"> Name</td>			 -->
                                        <th class="text-left" scope="col">Head of Income</th>
                                        <th class="text-left" scope="col">Amount</th>
                                    </tr>
                                    @if (isset($daily_income_statement))
                                        @php
                                            $total_coll = 0;
                                            $sub_total = 0;
                                            $group_name = '';
                                            $g = 0;
                                            $c = 0;
                                            $t = 0;
                                        @endphp
                                        @foreach ($daily_group_income_statement as $data)
                                            <tr>
                                                <td colspan="2">{{ $data->item_type_head }}</td>
                                                <td colspan="2">
                                                    <table width="100%">
                                                        @foreach (collect($daily_income_statement)->where('item_type_head', $data->item_type_head) as $subdata)
                                                            <tr>
                                                                <td style="text-align: left;">
                                                                    {{ $subdata->serviceunit_name }}</td>
                                                                <td style="text-align: right;">
                                                                    {{ number_format($subdata->total_collection, 2) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <th>Sub Total: </th>
                                                            <th style="text-align: right;">
                                                                {{ number_format(round($data->total_collection), 2) }}</th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            @php
                                                $total_coll += $data->total_collection;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <th colspan="3" style="text-align: right">Grand Total: </th>
                                            <th style="text-align: right">{{ number_format(round($total_coll), 2) }}</th>
                                        </tr>
                                    @endif
                                </table>

                                <div width="100%">
                                    @if($hospital_info->hospital_code == 'JKMH')
                                    <table width="50%" class="table data-table table-bordered "
                                        style="margin-top: 20px;  ">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" colspan="4">Zakat / Others Fund</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>SL.</td>
                                            <td>Particulars</td>
                                            <td>Muslim</td>
                                            <td>Non Muslim</td>
                                        </tr>

                                        @php
                                            $z = 0;
                                            $mus_pat = 0;
                                            $non_pat = 0;
                                            $total_opd_pat = 0;
                                        @endphp

                                        {{-- <tr>
                                        <td>1</td>
                                        <td>{{ 'General A/C' }}</td>
                                        @if (isset($zakat_fund_muslim))
                                            @foreach ($zakat_fund_muslim as $mdata)
                                                <td>{{ $mdata->muslim }}</td>
                                                @php
                                                    $mus_pat += $mdata->muslim;

                                                @endphp
                                            @endforeach
                                        @else
                                            <td></td>
                                        @endif

                                        @if (isset($zakat_fund_non_muslim))
                                            @foreach ($zakat_fund_non_muslim as $ndata)
                                                <td>{{ $ndata->non_muslim }}</td>
                                                @php
                                                    $non_pat += $ndata->non_muslim;
                                                @endphp
                                            @endforeach
                                        @else
                                            <td></td>
                                        @endif
                                    </tr> --}}

                                        @if (!empty($zakat_fund_arr))
                                            @foreach ($zakat_fund_arr as $key => $zt)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ isset($zt['ISLAM']) ? $zt['ISLAM'] : '' }}</td>
                                                    <td>{{ isset($zt['OTHERS']) ? $zt['OTHERS'] : '' }}</td>
                                                    @php
                                                        $mus_pat = isset($zt['ISLAM']) ? $mus_pat + $zt['ISLAM'] : $mus_pat;
                                                        $non_pat = isset($zt['OTHERS']) ? $non_pat + $zt['OTHERS'] : $non_pat;
                                                    @endphp

                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <th colspan="3">Grand Total: </th>

                                            <th>{{ number_format(round($mus_pat + $non_pat), 2) }}</th>
                                        </tr>
                                    </table>
                                    @endif

                                    <table width="50%" class="table data-table table-bordered ">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" colspan="2">Bank Deposit</th>
                                            </tr>
                                        </thead>
                                        @if (isset($daily_income_statement))
                                            @php
                                                $total_coll = 0;
                                                $sub_total = 0;
                                                $group_name = '';
                                                $g = 0;
                                                $c = 0;
                                                $t = 0;
                                                // dd($daily_group_income_statement);
                                            @endphp
                                            @foreach ($daily_group_income_statement as $data)
                                                <tr>
                                                    <td>{{ $data->item_type_head }}</td>
                                                    <td style="text-align: right;">
                                                        {{ number_format(round($data->total_collection), 2) }}</td>
                                                </tr>
                                                @php
                                                    $total_coll += $data->total_collection;
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <th style="text-align: right">Grand Total: </th>
                                                <th style="text-align: right;">{{ number_format(round($total_coll), 2) }}
                                                </th>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>


        <div class="">
            <table style="width: 100%; border:none ">
                <tr style=" ">
                    <td style="text-align:left; border:none ">
                        <span style="padding:5px; border-top: black solid 1px;"> Prepared By</span>
                    </td>
                    <td style="text-align:left; border:none ">
                        <span style="padding:5px; border-top: black solid 1px;">Manager Accounts</span>
                    </td>

                    <td style="text-align:center; border:none">
                        <span style="padding:5px; border-top: black solid 1px;">DGM
                        </span>
                    </td>

                    <td style="text-align:right; border:none">
                        <span style="padding:5px; border-top: black solid 1px;">DMD
                        </span>
                    </td>
                    <td style="text-align:right; border:none">
                        <span style="padding:5px; border-top: black solid 1px;">Chairman
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>

        <div class="" style=" border-top: 1px solid black;">
            Powered By: Nextgen Innovation Ltd
        </div>
    </footer>
</body>

</html>
