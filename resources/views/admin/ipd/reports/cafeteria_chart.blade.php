<style>
    .custom_inline_input {
        border: 0px;
        outline: 0;
        background-color: transparent;
        border-bottom: 1px dotted #222;
        /*display: block;*/
    }
  header {
            font-size: 16px;
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
        font-size: 10px;
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
        text-align: center !important;
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
                    <header>
                        <table style="width: 100%; border:none;" class="signature">

                             <tr>
                                <td style="width: 15%; border:none;">
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                                        alt="">
                                </td>
                                <td style="text-align:center; border:none;">
                                    <span style="font-size: 15px;"> <strong>
                                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                        </strong></span>
                                    <br>
                                    Address:
                                    <span>
                                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                    Phone No:
                                    <span>
                                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                                </td>
                            </tr>
                        </table>
                    </header>








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
                                                src="data:image/png;base64, {{ $admission_barcode }} " />
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
                                            <img style="" src="data:image/png;base64, {{ $pat_barcode }} " />
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
                                <h2>Cafeteria Chart</h2>
                            </div>
                            <table class="table table-bordered mt-3" cellspacing="0" cellpading="0">

                                <thead>
                                    <tr class="">
                                        <th class="text-center">SL</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Breakfast (Tk)</th>
                                        <th class="text-center">Morning Snacks (Tk)</th>
                                        <th class="text-center">Lunch (Tk)</th>
                                        <th class="text-center">Evening Snacks (Tk)</th>
                                        <th class="text-center">Dinner (Tk)</th>
                                        <th class="text-center">Night Snacks (Tk)</th>
                                        <th class="text-center">Total (Tk)</th>

                                        @php
                                            $total_date = 0;
                                        @endphp
                                        {{-- @dd($medication_chart); --}}


                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd(array_unique($medication, SORT_REGULAR)) --}}
                                    @php
                                        $date_medicine = [];
                                        $final_total = 0;
                                    @endphp
                                    @if (count($ipd_arr) > 0)
                                        @foreach ($ipd_arr as $key => $data)
                                            @php
                                                //$medi = explode("~", $key1);
                                            @endphp
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td style="text-align: center"> {{ $key }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Breakfast']) ? $data['Breakfast'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Morning Snacks']) ? $data['Morning Snacks'] : '' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Lunch']) ? $data['Lunch'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Evening Snacks']) ? $data['Evening Snacks'] : '' }}
                                                </td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Dinner']) ? $data['Dinner'] : '' }}</td>
                                                <td style="text-align: center">
                                                    {{ isset($data['Night Snacks']) ? $data['Night Snacks'] : '' }}
                                                </td>
                                                @php
                                                    $breakfast = isset($data['Breakfast']) ? $data['Breakfast'] : 0;
                                                    $monrning_snacks = isset($data['Morning Snacks']) ? $data['Morning Snacks'] : 0;
                                                    $Lunch = isset($data['Lunch']) ? $data['Lunch'] : 0;
                                                    $Evening_Snacks = isset($data['Evening Snacks']) ? $data['Evening Snacks'] : 0;
                                                    $Dinner = isset($data['Dinner']) ? $data['Dinner'] : 0;
                                                    $Night_Snacks = isset($data['Night Snacks']) ? $data['Night Snacks'] : 0;

                                                    $total = $breakfast + $monrning_snacks + $Lunch + $Evening_Snacks + $Dinner + $Night_Snacks;
                                                    $final_total += $total;
                                                @endphp
                                                <td style="text-align: center">
                                                    {{ $total }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center"> No Data Found </td>
                                        </tr>
                                    @endif


                                </tbody>
                                <tr>
                                    <th class="text-right" style="text-align: right;" colspan="8">Total =</th>

                                    <th class="bg-light-blue" style="text-align: center;">
                                        {{ $final_total }}</th>
                                </tr>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <!-- <hr style="border: 0.5px solid #000000"> -->
    <!-- <div class="">
        <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }} &nbsp;
            <span style="float:right">Powered By: NEXTGEN IT</span>
    </div> -->
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="">
        <span style="float:left;">Prepared By: {{ @$userInfo->user_fullname }}</span> &nbsp; <span
            style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
