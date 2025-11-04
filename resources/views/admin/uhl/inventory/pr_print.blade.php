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

    header {
            position: fixed;
            top: 0;
            height: 2cm;
            /* border-bottom: 1px solid; */
            padding: 0 1cm;
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

    .singature {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 6.7cm;
        text-align: center;
        font-size: 9px;
        bottom: -100px;
        padding-top: 10px;
    }

    body {
            margin-top: 2.5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
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

@if(!empty($po_hospital_details))
    <header style="">
        <table style="">
            <tr>
                <td style="width: 15%;">
                    @if (!empty($po_hospital_details->logo))
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size: 25px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                        <b>P.R ID
                            :</b>&nbsp;<span> {{ @$req_mst->inv_requisition_po_no_pk }}</span>
                    </div>

                </td>
            </tr>
        </table>
    </header>
    {{-- <br>
    <br>
    <hr/> --}}
    @endif

<div class="container-fluid" style="padding-bottom: 124px;">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">

                        {{-- <div class="form-heading  border-bottom " style="">
                            <div id="logo" style="display:inline-block !important; ">
                            @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
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
                        </div> --}}


                        <div class="heading text-center border-bottom mb-10">
                            <h2>PURCHASE REQUSITION</h2>
                        </div>


                        <div class="" style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
                            <div class="patient-information d-flex align-items-center">
                                <div class="text-left">
                                    <ul style="list-style: none; padding-left: 0;">
                                        <li><b>P.R By
                                                :</b>&nbsp;<span> {{ @$req_mst->user_fullname }}</span>
                                        </li>

                                        <li><b>Department
                                                :</b>&nbsp;<span>{{ @$req_mst->from_store }}</span>
                                        </li>


                                    </ul>
                                </div>
                                <div class="text-right">
                                    <ul style="list-style: none; padding-left: 0;">

                                        <li>
                                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                                        </li>
                                        <li><b>P.R ID
                                                :</b>&nbsp;<span> {{ @$req_mst->inv_requisition_po_no_pk }}</span>
                                        </li>
                                        <li><b>P.R STATUS
                                                :</b>&nbsp;<span> {{ @$req_mst->req_po_save_option }}</span>
                                        </li>
                                        <li><b>Date of P.R:</b>&nbsp;<span>
                                                {{ @$req_mst->req_at != '' ? date('d/m/Y H:i a', strtotime(@$req_mst->req_at)) : '' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>



                        <div class="form-body" style="margin-top: 10px">

                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th class="text-center">#SL</th>
                                        @if (isset($my_requsition_items) &&
                                        $my_requsition_items[0]['user_fullname'] != null &&
                                        $my_requsition_items[0]['from_store'] != '')
                                        <th class="text-center">Indent By</th>
                                        @endif
                                        <th class="text-left">Item Name</th>
                                        <th class="text-left">Product Spec.</th>
                                        <th style="text-align: center;">Uom </th>                                   
                                        <th style="text-align: center;">	L 3 M C  </th> 
                                        <th style="text-align: center;">Current Stock </th>                                          
                                        <th class="text-center">P.R Qty.</th>
                                        <th class="text-right">Rate</th>
                                        <th class="text-right">Total</th>                                  
                                        <th class="text-left"> Remarks</th>

                                    </tr>
                                </thead>
                                @php
                                $total_qty = 0;
                                $total_rate = 0;
                                $total_vat = 0;
                                $total_price = 0;

                                @endphp
                               
                                <tbody>
                                    <?php $total = 0; ?>
                                    @if (isset($my_requsition_items))
                                    @foreach ($my_requsition_items as $value)

                                    @php

                                    $total_qty += $value['req_quantity'];
                                    // $total_rate += !empty($value['dollar_rate']) ? ($value['lpp'] !=null ? $value['lpp'] / $value['dollar_rate'] : $value['item_purchase_price'] / $value['dollar_rate']) :($value['lpp'] !=null ? $value['lpp'] :  $value['item_purchase_price']);
                                    $total_vat += $value['vat_percent'];
                                    // $total_price += $value['req_quantity'] * (!empty($value['dollar_rate']) ?($value['lpp'] !=null ?  $value['lpp'] / $value['dollar_rate'] :  $value['item_purchase_price'] / $value['dollar_rate']) : ($value['lpp'] !=null ? $value['lpp'] : $value['item_purchase_price']));
                                    $total_price += $value['req_quantity'] * (!empty($value['dollar_rate']) ?($value['item_purchase_price'] !=null ?  ($value['item_purchase_price'] ) / $value['dollar_rate'] : ($value['item_purchase_price'] ) / $value['dollar_rate']) : ($value['item_purchase_price'] !=null ? ($value['item_purchase_price']) :($value['item_purchase_price'] )));

                                    
                                    $total_rate += !empty($value['dollar_rate']) ? ($value['item_purchase_price'] !=null ? ($value['item_purchase_price'] ) / $value['dollar_rate'] : ($value['item_purchase_price'] ) / $value['dollar_rate']) :($value['item_purchase_price'] !=null ? $value['item_purchase_price'] :  $value['item_purchase_price'] );
                                    $total_vat_count = $total_vat / count($my_requsition_items);

                                    @endphp
                                    <tr>
                                        <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                                        @if ($value['user_fullname'] != null && $value['from_store'] != '')
                                        <td class="text-left">{{ $value['user_fullname'] }} <br>
                                            <strong>
                                                ({{ $value['inv_requisition_no_fk'] }})
                                            </strong>
                                        </td>
                                        @endif
                                        <td class="text-left">{{ $value['item_name'] }}</td>
                                        <td class="text-left">
                                            {{ $value['item_remarks'] != '0' ? ucwords($value['item_remarks']) : '' }}
                                        </td>
                                        <td style="text-align: center;">{{ $value['req_uom_name'] }}</td>   
                                        <td style="text-align: center;">{{number_format($value['three_month_avg_qty'],2)}}</td>
                                        <td style="text-align: center;">{{ $value['current_stock'] }}</td>
                                        <td class="text-center">{{ $value['req_quantity'] }} </td>
                                        <td class="text-right">
                                            @if ($value['currency_sign'] == 'USD')
                                            $
                                            @elseif($value['currency_sign'] == 'EUR')
                                            €
                                            @endif
                                            
                                            {{ !empty($value['dollar_rate']) ? ($value['item_purchase_price'] !=null ? number_format(($value['item_purchase_price'] ) / $value['dollar_rate'], 3) :number_format($value['item_purchase_price'] / $value['dollar_rate'], 3)) :( $value['item_purchase_price'] !=null ? number_format(($value['item_purchase_price'] ), 3) :number_format($value['item_purchase_price'] , 3))}}


                                        </td>
                                        <td class="text-right">
                                            @if ($value['currency_sign'] == 'USD')
                                            $
                                            @elseif($value['currency_sign'] == 'EUR')
                                            €
                                            @endif
                                            {{ !empty($value['dollar_rate']) ?($value['item_purchase_price'] !=null ? number_format($value['req_quantity'] * (($value['item_purchase_price'] ) / $value['dollar_rate']), 3): number_format($value['req_quantity'] * (($value['item_purchase_price'] ) / $value['dollar_rate']), 3)) : ($value['item_purchase_price'] !=null  ? number_format($value['req_quantity'] * ($value['item_purchase_price'] ),3) :number_format($value['req_quantity'] *($value['item_purchase_price'] ),3)) }}
                                        </td>

                                      

                                        <td class="text-left">
                                            {{ $value['multiple_remarks'] != '0' ? ucwords($value['multiple_remarks']) : '' }}
                                        </td>

                                      

                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>

                                <tfoot>
                                    @php
                                    $calls = 9;
                                    $calls2 = 10;
                                    if (isset($my_requsition_items) && $my_requsition_items[0]['user_fullname'] != null && $my_requsition_items[0]['from_store'] != '') {
                                    $calls = 9;
                                    $calls2 = 10;
                                    } else {
                                    $calls = 8;
                                    $calls2 = 9;
                                    }

                                    @endphp

                                    <tr>
                                        <td colspan="{{ $calls }}" style="text-align: right;">
                                            <strong>Total =</strong>
                                        </td>
                                        <!-- <td style="text-align: right;"><strong>
                                                @if ($my_requsition_items[0]['currency_sign'] == 'USD')
                                                $
                                                @elseif($my_requsition_items[0]['currency_sign'] == 'EUR')
                                                €
                                                @endif
                                                {{ number_format($total_rate, 3) }}
                                            </strong>
                                        </td> -->
                                        <td style="text-align: right;"><strong>
                                                @if ($my_requsition_items[0]['currency_sign'] == 'USD')
                                                $
                                                @elseif($my_requsition_items[0]['currency_sign'] == 'EUR')
                                                €
                                                @endif{{ number_format($total_price, 3) }}
                                            </strong></td>
                                        <td></td>
                                       
                                    </tr>
                                  
                                </tfoot>

                            </table>                          
                           
                        </div>
                      <div>  <strong>P.R Remarks : </strong>{{ isset($my_requsition_items) ?  ucwords($my_requsition_items[0]['req_po_remarks']) : '' }}
                    </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
</div>
@php
$margin_top = File::exists(public_path('images/uploads/doctor_images/director_sign.png')) ? 'margin-top:10px' : 'margin-top:10px';

@endphp
<!-- <div class="singature">
    @if (in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
        @if (strpos($req_mst->approval_status_text, 'REJECTED') >= 1 || strpos($req_mst->approval_status_text, 'HOLD') >= 1)
        @else
            @php
                $approval_exp = explode('/', $req_mst->approval_level_status_text);
            @endphp
            @if ($req_mst->approval_level_status_text != '' && $approval_exp[0] == $approval_exp[1])
                <table style="width: 100%; border:none ">
                    <tr>
                        <td colspan="2"> <span style="padding:5px; "><strong> 1st Approval </strong> </td>
                        <td colspan="2" class="text-right" style="padding-right:20px; "> <span><strong> 2nd Approval
                                </strong></span></td>
                    </tr>
                </table>
            @elseif($req_mst->approval_level_status_text != '' && $approval_exp[0] == 1)
                <table style="width: 100%; border:none ">
                    <tr>
                        <td colspan="2"> <span style="padding:5px; "><strong> 1st Approval </strong></td>
                        <td colspan="2" class="text-right" style="padding-right:20px; ">
                        </td>
                    </tr>
                </table>
            @endif
        @endif
    @endif
    <table style="width: 100%; border:none ; <?= $margin_top ?>">
        <tr style=" ">
            <td style="text-align:left; border:none " colspan="2">

                @if (in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
                    @if (strpos($req_mst->approval_status_text, 'REJECTED') >= 1 || strpos($req_mst->approval_status_text, 'HOLD') >= 1)
                    @else
                        @php
                            $approval_exp = explode('/', $req_mst->approval_level_status_text);
                        @endphp
                        @if ($req_mst->approval_level_status_text != '' && $approval_exp[0] == $approval_exp[1])
                            @if (File::exists(public_path('images/uploads/doctor_images/director_sign.png')))
                                <img src="{{ public_path('images/uploads/doctor_images/director_sign.png') }}"
                                    width='80px' style="padding: 0px  !important; margin:0px !important">
                                <br>
                            @endif
                            <span style="padding:5px; border-top: black solid 1px;"> <strong> Ardra Kurien <br> Chief
                                    Executive Officer</strong> </span>
                        @elseif($req_mst->approval_level_status_text != '' && $approval_exp[0] == 1)
                            @if (File::exists(public_path('images/uploads/doctor_images/director_sign.png')))
                                <img src="{{ public_path('images/uploads/doctor_images/director_sign.png') }}"
                                    width='80px' style="padding: 0px  !important; margin:0px !important">
                                <br>
                            @endif
                            <span style="padding:5px; border-top: black solid 1px;"> <strong> Ardra Kurien <br> Chief
                                    Executive Officer</strong> </span>
                        @endif
                    @endif
                @else
                    <span style="padding:5px; border-top: black solid 1px;"> Signature & Date </span>

                @endif

            </td>

            <td style="text-align:right; border:none" colspan="2">

                @if (in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
                    @if (strpos($req_mst->approval_status_text, 'REJECTED') >= 1 || strpos($req_mst->approval_status_text, 'HOLD') >= 1)
                    @else
                        @php
                            $approval_exp = explode('/', $req_mst->approval_level_status_text);
                        @endphp
                        @if ($req_mst->approval_level_status_text != '' && $approval_exp[0] == $approval_exp[1])
                            @if (File::exists(public_path('images/uploads/doctor_images/ceo_sign.png')))
                                <img src="{{ public_path('images/uploads/doctor_images/ceo_sign.png') }}"
                                    width='60px' style="padding: 0px  !important; margin:0px !important">&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <br>
                            @endif
                            <span style=" border-top: black solid 1px; float:right"><strong> Zulfiker Rahaman
                                </strong></span> <br>
                            <span style="padding:5px;  display:block; margin-left:100px"><strong> Director &nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;</strong></span>


                        @endif
                    @endif
                @else
                    <span style="padding:5px; border-top: black solid 1px;"> Signature & Date
                    </span>
                @endif
            </td>
        </tr>
    </table>

</div> -->
<div class="singature">
    <table style="width: 100%; border:none ;">
 
        <tr style="">
            @if(!empty($signature_data))
            @foreach($signature_data as $key => $value)
                @php
                    $approval=$value->level_status_text !="" ? explode('-',$value->level_status_text) : '';
                @endphp
                @if($key ==0 && $approval !="" && $approval[1] == "APPROVED")
                <td style="text-align:left; border:none; " >
                    @if($value->doctor_signature_image !="")
                    <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                    @endif
                    <span style=" border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> 
                    <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                </td>
                @endif
                @if($key ==1 &&  $approval !="" && $approval[1] == "APPROVED")
                <td style="text-align:right; border:none; text-align:center;">
                    @if($value->doctor_signature_image !="")
                    <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                    @endif
                    <span style="padding-left:5px; border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                </td>
                @endif
                @if($key ==2 &&  $approval !="" && $approval[1] == "APPROVED")
                <td style="text-align:center; border:none" >
                    @if($value->doctor_signature_image !="")
                    <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                    @endif
                    <span style="padding:5px; border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                </td>
                @endif
                @if($key ==3 &&  $approval !="" && $approval[1] == "APPROVED")
                <td style="text-align:center; border:none" >
                    @if($value->doctor_signature_image !="")
                    <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                    @endif
                    <span style="padding:5px; border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                </td>
                @endif
            @endforeach
            @endif
        </tr>
    </table>
    @if(Session::get('user.ses_hospital_code') == 'DMHL')
        <p style="margin-top: 30px;">
            <strong>[This is system generated approved document. Signature is not required.]</strong>
        </p>
    @endif
</div>
<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>

    {{-- <div class="" style=" border-top: 1px solid black;">
        <span>Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time:
            {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span>Powered By: NEXTGEN IT</span>
    </div> --}}
</footer>