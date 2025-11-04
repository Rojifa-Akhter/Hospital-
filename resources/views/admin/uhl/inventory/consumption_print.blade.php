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
                                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                        width="80px" />
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

                        <div class="heading text-center border-bottom mb-10">
                            <h2>CONSUMPTION REQUSITION</h2>
                        </div>


                        <div class=""
                            style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>Consumption By
                                                :</b>&nbsp;<span>
                                                {{ @$issu_requisition_list_mst->user_fullname }}</span>
                                        </li>

                                        <li><b>Department
                                                :</b>&nbsp;<span>{{ @$issu_requisition_list_mst->serviceunit_name }}</span>
                                        </li>
                                        @if (!empty($patient_info))
                                            <li>
                                                <b>Patient Name :</b>&nbsp;
                                                <span>{{ $patient_info->patient_name }}
                                                    ({{ $patient_info->patient_code }})</span>
                                            </li>
                                        @endif



                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">

                                        <li>
                                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                                        </li>
                                        <li><b>Consumption ID
                                                :</b>&nbsp;<span>
                                                {{ @$issu_requisition_list_mst->inv_consumption_no_pk }}</span>
                                        </li>

                                        <li><b>Date of Consumption:</b>&nbsp;<span>
                                                {{ @$issu_requisition_list_mst->inv_consumption_date != '' ? date('d/m/Y', strtotime(@$issu_requisition_list_mst->inv_consumption_date)) : '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>



                        <div class="form-body" style="margin-top: 10px">
                            @if (Session::get('user.ses_hospital_code') == 'DMHL')
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th class="text-left">Item Name</th>
                                            <th class="text-left">Consumption Uom</th>
                                            <th>Purchase Price</th>
                                            <th>Current Stock</th>
                                            <th class="text-left">Internal Batch</th>
                                            <th>Consumption Qty.</th>
                                            <th>Cost Price</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $totalValue = 0; ?>
                                        @if (isset($issu_requisition_list))
                                            @foreach ($issu_requisition_list as $value)
                                                <?php
                                                $valueTotal = $value->item_consumption_qty * $value->cost_price;
                                                $totalValue += $valueTotal;
                                                ?>
                                                <tr>
                                                    <td class="text-center bg-light">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $value->item_name }}</td>
                                                    <td class="text-left">{{ $value->uom }}</td>
                                                    <td class="text-right">{{ $value->purchase_price }}</td>
                                                    <td class="text-center">{{ $value->curr_stock }}</td>
                                                    <td class="text-left">
                                                        {{ $value->internal_batch_no != '0' ? ucwords($value->internal_batch_no) : '' }}
                                                    </td>
                                                    <td class="text-right">{{ $value->item_consumption_qty }}</td>
                                                    <td class="text-right">{{ $value->cost_price }}</td>
                                                    <td class="text-right">{{ $valueTotal }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" class="text-right"><b>Total:</b></td>
                                            <td class="text-right"><b>{{ $totalValue }}</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left"><b>Remarks:</b></td>
                                            <td class="" colspan="8">
                                                <b>{{ $issu_requisition_list_mst->consumption_remarks }}</b>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>SL</th>

                                            <th class="text-left">Item Name</th>
                                            <th class="text-left"> Consumption Uom</th>
                                            <th>Consumption Qty.</th>
                                            <th>Cost Price</th>
                                            <th>Purchase Price</th>
                                            <th>Current Stock</th>
                                            <th class="text-left">Internal Batch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $total = 0; ?>
                                        @if (isset($issu_requisition_list))
                                            @foreach ($issu_requisition_list as $value)
                                                <tr>
                                                    <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $value->item_name }}</td>
                                                    <td class="text-left">{{ $value->uom }}</td>

                                                    <td class="text-center">{{ $value->item_consumption_qty }} </td>
                                                    <td class="text-right">{{ $value->cost_price }}</td>
                                                    <td class="text-right">{{ $value->purchase_price }}</td>
                                                    <td class="text-center">{{ $value->curr_stock }}</td>
                                                    <td class="text-left">
                                                        {{ $value->internal_batch_no != '0' ? ucwords($value->internal_batch_no) : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>

                                </table>
                            @endif

                            <div class="">
                                <p><b>Remaks
                                        :</b>&nbsp;<span>{{ $issu_requisition_list_mst->consumption_remarks }}</span>
                                </p>
                            </div>
                            <br><br><br> <br><br><br> <br><br><br>



                        </div>


                    </div>


                </div>


            </div>


        </div>


    </div>
</div>

<div>
    <!-- <table style="width: 100%; border:none ">
        <tr>
            <td colspan="2">Department Head Approval </td>

            <td colspan="2" class="text-right">Managing Director Approval</td>
        </tr>
    </table>
    <table style="width: 100%; border:none ;margin-top:40px">
        <tr style=" ">
            <td style="text-align:left; border:none " colspan="2">

                <span style="padding:5px; border-top: black solid 1px;"> Signature & Date
                </span>

            </td>

            <td style="text-align:right; border:none" colspan="2">

                <span style="padding:5px; border-top: black solid 1px;"> Signature & Date
                </span>
            </td>
        </tr>
    </table> -->

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

    <div class="" style=" border-top: 1px solid black;">
        <span style="">Prepared By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing
            Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span style="float:right">Powered By: NEXTGEN IT</span>
    </div>
</footer>
