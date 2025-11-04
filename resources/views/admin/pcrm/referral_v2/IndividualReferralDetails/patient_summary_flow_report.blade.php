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
        border-top: 1px solid black;
        padding-top: 10px;
    }

    body {
        /*margin-top: 5.5cm;*/
        margin-left: 0cm;
        margin-right: 0cm;
        /*margin-bottom: 3.5cm;*/
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 7px;
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
        font-size: 9px;
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

    td,
    th {
        padding: 0;
    }
</style>

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
                        <div class="form-heading  border-bottom pb-3" style="">
                            <div id="logo" style="display:inline-block !important; ">
                                @if (!empty($po_hospital_details->logo))
                                    {{-- <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        width="80px" /> --}}
                                @endif
                            </div>
                            <div class="hospital-address" style="display:inline-block !important; ">
                                <h1 class="mb-0 ">
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h1>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                </p>
                                <br>
                                <p class="mb-0 ">
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                                </p>
                                <br>
                            </div>
                        </div>

                        <div class="form-body">
                            <div class="heading text-center border-bottom">
                                <h2>1. Patient Flow Summary</h2>
                            </div>

                            <div class="heading text-left border-bottom mb-10">
                                <h2>A. Outpatient-OPD</h2>
                            </div>
                            <table class="table table-bordered mt-1" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="text-center" colspan="4">Today</th>
                                        <th class="text-center" colspan="4">Cumulative Total {{ $result['from_date'] }} to till {{ $result['to_date'] }}</th>
                                    </tr>
                                    <tr class="">
                                        <th class="text-center">New Consultant Patients</th>
                                        <th class="text-center">Follow-up -Fee (Within 7 Days)</th>
                                        <th class="text-center">Follow-up -Paid (Within 14 Days)</th>
                                        <th class="text-center">Total Patients</th>
                                        <th class="text-center">Total New Consultant Patients</th>
                                        <th class="text-center">Follow-up -Fee (Within 7 Days)</th>
                                        <th class="text-center">Follow-up -Paid (Within 14 Days)</th>
                                        <th class="text-center">Total Patients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($result['opd']))
                                        @foreach($result['opd'] as $opd)
                                            <tr>
                                                <td class="text-center">{{ $opd->today_newpat }}</td>
                                                <td class="text-center">{{ $opd->today_free }}</td>
                                                <td class="text-center">{{ $opd->today_follow }}</td>
                                                <td class="text-center">{{ $opd->today_patient }}</td>
                                                <td class="text-center">{{ $opd->total_new }}</td>
                                                <td class="text-center">{{ $opd->total_free }}</td>
                                                <td class="text-center">{{ $opd->total_followup }}</td>
                                                <td class="text-center">{{ $opd->total_patient }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="heading text-left border-bottom mb-10">
                                <h2>B. Inpatient-IPD</h2>
                            </div>
                            <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="text-center" colspan="5">Today</th>
                                        <th class="text-center" colspan="3">Cumulative Total {{ $result['from_date'] }} to till {{ $result['to_date'] }}</th>
                                    </tr>
                                    <tr class="">
                                        <th class="text-center">Opening Patient</th>
                                        <th class="text-center">New Admission</th>
                                        <th class="text-center">Discharges</th>
                                        <th class="text-center">Total Patients</th>
                                        <th class="text-center">Refer From Emergency</th>
                                        <th class="text-center">Total Admission</th>
                                        <th class="text-center">Total Discharges</th>
                                        <th class="text-center">Current Patients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($result['ipd']))
                                        @foreach($result['ipd'] as $ipd)
                                            <tr>
                                                <td class="text-center">{{ $ipd->pre_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->todayadmitted_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->todaydis_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->curr_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->reff2ipd ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->total_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->dis_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $ipd->curr_patient ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="heading text-left border-bottom mb-10">
                                <h2>C. Emergency Patient</h2>
                            </div>
                            <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="text-center" colspan="5">Today</th>
                                        <th class="text-center" colspan="3">Cumulative Total {{ $result['from_date'] }} to till {{ $result['to_date'] }}</th>
                                    </tr>
                                    <tr class="">
                                        <th class="text-center">Opening Patient</th>
                                        <th class="text-center">New Admission</th>
                                        <th class="text-center">Discharges</th>
                                        <th class="text-center">Total Patients</th>
                                        <th class="text-center">Refer To IPD</th>
                                        <th class="text-center">Total Admission</th>
                                        <th class="text-center">Total Discharges</th>
                                        <th class="text-center">Current Patients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($result['emergency']))
                                        @foreach($result['emergency'] as $emr)
                                            <tr>
                                                <td class="text-center">{{ $emr->pre_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->todayadmitted_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->todaydis_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->curr_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->refffromipd ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->total_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->dis_patient ?? 0 }}</td>
                                                <td class="text-center">{{ $emr->curr_patient ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="heading text-center border-bottom mb-10">
                                <h2>2. Net Collection Summary</h2>
                            </div>
                            <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="bg-red">
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Opening Balance</th>
                                        <th class="text-center">Daily Collection(BDT.)</th>
                                        <th class="text-center">Cumulative Collection (BDT.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_ob = $total_today_collection = $total_total_collection = 0;
                                    @endphp

                                    @if(isset($result['netSales']))
                                        @foreach($result['netSales'] as $netSales)
                                            @php
                                                $total_ob += $netSales->ob;
                                                $total_today_collection += $netSales->today_collection;
                                                $total_total_collection += $netSales->total_collection
                                            @endphp
                                            <tr>
                                                <td class="text-left">{{ $netSales->module_name }}</td>
                                                <td class="text-right">{{ $netSales->ob }}</td>
                                                <td class="text-right">{{ $netSales->today_collection }}</td>
                                                <td class="text-right">{{ $netSales->total_collection }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    <tr style="font-weight: bold;">
                                        <td class="text-center">Total</td>
                                        <td class="text-right">{{ $total_ob }}</td>
                                        <td class="text-right">{{ $total_today_collection }}</td>
                                        <td class="text-right">{{ $total_total_collection }}</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <div class="">
        <span style="float:left;">Prepared By: {{ @$userInfo->user_fullname }}</span> &nbsp;
        <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }}</span> &nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
