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
                        <div class=""
                            style="border: 1px solid #dee2e6; height: 140px; padding: 10px; margin-top: 10px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Admission ID
                                                :</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                                        </li>
                                        <li>
                                            <img style=""
                                                {{-- src="data:image/png;base64, {{ $admission_barcode }} " --}}
                                            />
                                        </li>
                                        <li><b>Name
                                                :</b>&nbsp;<span>{{ isset($admission_info->patient_name) ? $admission_info->patient_name : '' }}</span>
                                        </li>
                                        <li><b>Age
                                                :</b>&nbsp;<span>{{ isset($admission_info->age) ? $admission_info->age : '' }}</span>
                                        </li>
                                        <li><b>Gender
                                                :</b>&nbsp;<span>{{ isset($admission_info->gender_txt) ? $admission_info->gender_txt : '' }}</span>
                                        </li>
                                        <li><b>Bed :</b>&nbsp;<span></span>
                                            {{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}
                                        </li>

                                        <li><b>Con. Number
                                                :</b>&nbsp;<span>{{ isset($admission_info->mobile1) ? $admission_info->mobile1 : '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Patient ID
                                                :</b>&nbsp;<span>{{ isset($admission_info->patient_code) ? $admission_info->patient_code : '' }}</span>
                                        </li>
                                        <li>
                                            {{-- <img style="" src="data:image/png;base64, {{ $pat_barcode }} " /> --}}
                                        </li>
                                        <li><b>Phone
                                                :</b>&nbsp;<span>{{ isset($admission_info->mobile1) ? $admission_info->mobile1 : '' }}</span>
                                        </li>
                                        <li><b>Date Of Admission
                                                :</b>&nbsp;<span>{{ date('d/m/Y', strtotime(@$admission_info->admission_date)) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <div class="heading text-center border-bottom mb-10">
                                <h2>Diet
                                    @if (Session::get('user.ses_hospital_code') == 'IMPERIAL')
                                        Report
                                    @else
                                        Chart
                                    @endif
                                </h2>
                            </div>
                            {{-- <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="">
                                        <th class="text-center">SL</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Breakfast</th>
                                        <th class="text-center">Lunch</th>
                                        <th class="text-center">Tea Time</th>
                                        <th class="text-center">Supper</th>
                                        <th class="text-center">Remakrs</th>
                                        @php
                                            $total_date = 0;
                                        @endphp
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $date_medicine = [];
                                    @endphp
                                    @if (count($ipd_arr) > 0)
                                        @foreach ($ipd_arr as $key => $data)
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td style="text-align: center"> {{ $key }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Morning']) ? $data['Morning'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Lunch']) ? $data['Lunch'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Tea Time']) ? $data['Tea Time'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Supper']) ? $data['Supper'] : '' }}</td>
                                                <td style="text-align: center"></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center"> No Data Found </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table> --}}
                            <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">
                                <thead>
                                    <tr class="">
                                        <th class="text-center" rowspan="2">SL</th>
                                        <th class="text-center" rowspan="2">Room No</th>
                                        <th class="text-center" rowspan="2">ID No</th>
                                        <th class="text-center" rowspan="2">Diagnosis</th>
                                        <th class="text-center" rowspan="2">Diet</th>
                                        <th class="text-center" colspan="3">Morning</th>
                                        <th class="text-center" colspan="2">Morning 10:00am</th>
                                        <th class="text-center" colspan="4">Noon 01:00pm</th>
                                        <th class="text-center">Afternoon 04:00pm</th>
                                        <th class="text-center" colspan="4">Night</th>
                                        <th class="text-center">Night 10:00pm</th>
                                    </tr>
                                    <tr class="">
                                        <th class="text-center">Bread</th>
                                        <th class="text-center">Vegetable</th>
                                        <th class="text-center">Egg</th>
                                        <th class="text-center">Fruits</th>
                                        <th class="text-center">Tea</th>
                                        <th class="text-center">Rice</th>
                                        <th class="text-center">Vegetable</th>
                                        <th class="text-center">Dal</th>
                                        <th class="text-center">Fish</th>
                                        <th class="text-center"></th>
                                        <th class="text-center">Bread/Rice</th>
                                        <th class="text-center">Vegetable</th>
                                        <th class="text-center">Dal</th>
                                        <th class="text-center">Chicken</th>
                                        <th class="text-center">Milk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
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
