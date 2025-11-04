<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<style>
    .sorting {
        background-image: none !important;
    }

    input.form-control {
        margin-bottom: 0px !important;
    }

    select.form-control {
        margin-bottom: 0px !important;
    }

    .input-group-text {
        padding: 6px 10px;
        border: 0;
        border-radius: 0px;
    }

    .search_product input.form-control {
        border-radius: 0 !important;
    }

    .product-qty {
        position: relative;
    }

    .product-qty input.form-control {
        padding: .375rem 1.5rem !important;
        text-align: center;
    }
    .item-header th{
        border: 1px white solid;
    }

    .product-qty .quantity-left-minus {
        position: absolute;
        top: 50%;
        left: 11%;
        transform: translate(-50%, -50%);
        font-size: 11px;
        color: red;
        width: 24px;
        line-height: 25px;
        border-right: 1px solid #dee2e6;
        text-align: center;
        cursor: pointer;
    }

    .product-qty .quantity-right-plus {
        position: absolute;
        top: 50%;
        right: -11%;
        transform: translate(-50%, -50%);
        font-size: 10px;
        color: green;
        width: 25px;
        line-height: 25px;
        border-left: 1px solid #dee2e6;
        text-align: center;
        cursor: pointer;
    }

    .product {
        margin: 5px 0;
        transition: all 0.3s;
        cursor: pointer;
        z-index: 9999;
        -webkit-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.2);
    }

    .product:hover {
        transform: scale(1.05);
    }

    .product-img {
        width: 65px;
        margin: auto;
    }

    .product-details span {
        font-size: 10px;
    }

    .card {
        border: 0px !important;
    }

    .w-5 {
        width: 5% !important;
    }

    .w-95 {
        width: 95% !important;
    }

    .list-group-item {
        padding: .3rem;
    }

    .amount {
        font-size: 24px;
    }

    .display-5 {
        font-size: 1.4rem;
    }

    .list-group-item {
        background: none;
        border-top: 1px solid #ffffff !important;
        border-bottom: 1px solid #e3e3e3;
    }

    .table td,
    .table th {
        padding: 2px 6px;
    }

    .list-group .form-control {
        background-color: #fff !important;
    }

    .borderless td,
    .borderless th {
        border: none;
    }
</style>
<div class="container-fluid">
    <form method="post" action="{{ route('pharmacy.store') }}" id="posBilling" onsubmit="">

        <div class="form-row" id="mypos">
            <div class="col-md-12">
                <div class="card shadow-sm" id="cust_info">
                    <div class="card-header">
                        <h5>Bill Entry</h5>
                    </div>
                    <div class="card-body p-2">
                        <div class="form-row">
                            <div class="form-check form-check-inline col-md-1 mr-0">
                                <input class="form-check-input patient_type keep_me walk_in" type="radio"
                                    name="customer_type_radio" id="walk_in_patient" value="1" checked="checked">
                                <label class="form-check-label" for="walk_in_patient">Walk In</label>
                            </div>
                            <div class="form-check form-check-inline col-md-1 mr-0">
                                <input class="form-check-input patient_type keep_me" type="radio"
                                    name="customer_type_radio" id="registered_pat" value="2">
                                <label class="form-check-label" for="registered_pat">Registered</label>
                            </div>
                            <div class="form-check form-check-inline col-md-1 mr-5">
                                <input class="form-check-input patient_type keep_me" type="radio"
                                    name="customer_type_radio" id="prescribed_pat" value="3">
                                <label class="form-check-label" for="prescribed_pat">Prescribed</label>&nbsp;<button
                                    type="button" class="button button5"
                                    style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                </button>
                            </div>                          
                                <div class="form-check form-check-inline col-md-1 mr-5">
                                    <input class="form-check-input patient_type keep_me" type="radio"
                                        name="customer_type_radio" id="admitted_pat" value="4">
                                    <label class="form-check-label" for="admitted_pat">Admitted</label>
                                    &nbsp;<button type="button" class="button admissionButton"
                                        style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                    </button>
                                </div>
                                <div class="form-check form-check-inline col-md-1 mr-5">
                                    <input class="form-check-input patient_type keep_me" type="radio"
                                        name="customer_type_radio" id="emergency_pat" value="5">
                                    <label class="form-check-label" for="emergency_pat">Emergency</label>
                                    &nbsp;<button type="button" class="button admissionButton"
                                        style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                    </button>
                                </div>
                                <div class="form-check form-check-inline col-md-1 mr-5">
                                    <input class="form-check-input patient_type keep_me" type="radio"
                                        name="customer_type_radio" id="daycare_pat" value="6">
                                    <label class="form-check-label" for="daycare_pat">Daycare</label>
                                    &nbsp;<button type="button" class="button admissionButton"
                                        style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                    </button>
                                </div>
                                <div class="form-check form-check-inline col-md-1 mr-0">
                                    <input class="form-check-input patient_type keep_me" type="radio"
                                        name="customer_type_radio" id="ot_pat" value="7">
                                    <label class="form-check-label" for="ot_pat">OT</label>
                                    &nbsp;<button type="button" class="button admissionButton"
                                        style="border-radius: 50%; background-color: red;  border: none; color: white;">0
                                    </button>
                                </div>
                                <div class="form-check form-check-inline col-md-1 mr-0">
                                <label class="form-check-label " for="service_point">Service Point</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2 mr-0">
                                   
                                    <select class="form-control keep_me " id="service_point" name="service_point" onchange="servicePoint(this)" required>
                                        <option value="">Select One</option>
                                        @if (!empty($service_point))
                                            @foreach ($service_point as $value)
                                                @if ($value->default_ind == 1)
                                                    <option selected value="{{ $value->serviceunit_no_pk }}"
                                                        data-posind="{{ $value->hs_pos_ind }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @else
                                                    <option data-posind="{{ $value->hs_pos_ind }}"
                                                        value="{{ $value->serviceunit_no_pk }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                           
                        </div>
                        <!-- <div class="float-right mt-1">
                            <div class="form-check form-check-inline form-row ">
                                <label class="form-check-label col-md-5" for="service_point">Service Point</label>
                                <select class="form-control keep_me col-md-7" id="service_point" name="service_point"
                                    required>
                                    <option value="">Select One</option>
                                    @if (!empty($service_point))
                                        @foreach ($service_point as $value)
                                            @if ($value->default_ind == 1)
                                                <option selected value="{{ $value->serviceunit_no_pk }}"
                                                    data-posind="{{ $value->hs_pos_ind }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @else
                                                <option data-posind="{{ $value->hs_pos_ind }}"
                                                    value="{{ $value->serviceunit_no_pk }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div> -->


                    </div>
                    <input type="hidden" name="hospital_code" id="hospital_code"
                        value="{{ Session::get('user.ses_hospital_code') }}" class="keep_me">
                    <div class="walk_in_customer  pb-3 ml-3 w-100">
                        <label for="customer_name">Name : &nbsp;</label>
                        <input type="text" class="" id="customer_name" name="customer_name"
                            placeholder=" Enter name">
                        <label for="walk_in_phone">Mobile No : &nbsp;</label>
                        <input type="text" class="number_only" id="walk_in_phone" name="walk_in_phone"
                            placeholder=" Enter phone number">
                        <label for="customer_addr">Address : &nbsp;</label>
                        <input type="text" class="" id="customer_addr" name="customer_addr"
                            placeholder=" Enter Address">

                    </div>
                    <div class="patient_id_div d-none pb-3">
                        <div class="form-row">
                            <div class="col-md-6 p-3">
                                @php

                                    if (in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'IMPALA', 'AMCSH'])) {
                                        $placeholder_text = 'Search Name/Id/Mobile';
                                    } else {
                                        $placeholder_text = 'Search Patient by Phone No';
                                    }
                                @endphp
                                <input type="text" class="form-control " id="patient_id" name="patient_id"
                                    placeholder="{{ $placeholder_text }}">
                                <input type="hidden" class="keep_me" name="page_type" value="2">
                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                            </div>
                            <div class="col-md-6 p-3">
                                <input type="text" class="form-control " id="pat_id" name="pat_id"
                                    placeholder="Search Patient by Patient Id">

                            </div>
                        </div>

                    </div>
                    <div class="prescription_id_div d-none pb-3">
                        <input type="text" class="form-control  " id="prescription_id"
                            placeholder="Search Patient by Prescription Number">
                        <input type="hidden"  id="hdn_prescription_id" name="hdn_prescription_id" value="{{isset($press_id) ? $press_id :''}}">
                    </div>
                    <div class="admission_id_div d-none pb-3">
                        <input type="text" class="form-control " id="admission_id" name="admission_id"
                            placeholder="Search Patient By Admission Id">
                        <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id" />
                    </div>
                    <div class="card-body p-2 border-top bg-light-blue " id="selected_patient">
                        <div class="form-row">
                            <div class="col-md-12" id="patient_info">

                            </div>
                        </div>
                        <div id="patient_total_available_due_div" class="d-none">
                            <div id="patient_total_available_due">

                            </div>
                        </div>
                    </div>
                    <div class="card-body p-2 border-top">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="input-group d-flex clearfix">
                                    <div class="input-group-prepend w-5">
                                        <span class="input-group-text" id="item_typehead"><i class="fa fa-barcode"
                                                style="font-size: 24px;"></i></span>
                                    </div>

                                    <div class="w-95">
                                        <input type="text" class="form-control item_typehead input_dissabled"
                                            placeholder="Search Item by Barcode No/Item Code/ Item Name" id="item_name"
                                            aria-label="item_typehead" aria-describedby="item_typehead">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2" id="item_table_con">
                                <div class="text-right">
                                    <input type="hidden" class="keep_me" name="item_dis_ind" id="item_dis_ind"
                                        value="1" onclick="itemDiscount(this)" >
                                    <!-- <label for="item_dis_ind">Item Discount</label> <input type="radio"
                                        name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_perc"
                                        value="1" checked='checked'> (%) <input type="radio"
                                        name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_amt"
                                        disabled='disabled' value="2">
                                    (Amt) -->
                                </div>
                                <table id="item_table" class="table mb-0"
                                    style="width:100%; border-collapse: collapse;">
                                    <thead>
                                        <tr class="bg-primary item-header">
                                            <th class="text-center w-5">#</th>
                                            <th class="text-left">Item Description</th>
                                            <!-- <th class="text-right w-5">W. Rate</th> -->
                                            <th class="text-right w-5">Rate</th>
                                            <th class="text-right w-5">Quantity</th>

                                            <th class=" w-10 text-right">Stock QTY</th>
                                            <th class=" w-5">UOM</th>
                                            <!-- <th class=" w-10">Status</th> -->
                                            <!-- <th class="text-right w-5">Urgent Fee</th> -->
                                            <th class="text-right w-10">Discount (%)</th>
                                            <th class="text-right w-10">Discount Amt.</th>
                                            <th class="text-right w-10">Sub Total</th>
                                            <th class="text-center w-5"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="billing_table-body">
                              
                                    </tbody>
                                </table>

                            </div>
                           
                        </div>
                    </div>
                </div>             
            </div>      
            <div class="col-xs-12 col-sm- 12 col-md-12 col-lg-12 col-xl-12">
                <div class="row ">
                    <div class="col-xs-12 col-sm- 12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card shadow-sm mt-1" id="amount_info">
                            <div class="card-body p-1">
                                <div class="right_side">
                                    <div class="form-row">
                                    @php
                                        $discount_apply=Session::get('user.ses_hospital_code')=="KPJ" ? '' :'d-none';
                                    @endphp
                                        <div class="col-md-4 mt-2 all_discount <?= $discount_apply?>">
                                            <div class="form-row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <label class="input-group-text"
                                                                    for="cmb_discount">Discount&nbsp;&nbsp;</label>
                                                            </div>
                                                            <select class="custom-select keep_me" id="cmb_discount"
                                                                name="cmb_discount">
                                                                <option value="0">Discount Type</option>


                                                                @if (!empty($disctype))
                                                                    @foreach ($disctype as $key => $dtype)
                                                                        <option value="{{ $key }}"
                                                                            {{ $key == 'GENERAL' ? 'selected' : '' }}>
                                                                            {{ $dtype }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 percent_hospital">
                                                    <div class="input-group  mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">%</span>
                                                        </div>
                                                        @if (strtoupper(Session::get('user.ses_hospital_code')) != 'MCARE')
                                                            <input type="text"
                                                                class="form-control text-right number_only hospital_disc"
                                                                id="discount_percent_hospital"
                                                                name="discount_percent_hospital"
                                                                placeholder="Hospital"
                                                                onkeyup="billingEngine.posCalculateTotalV2(this)"
                                                                value="" />
                                                        @else
                                                            <input type="text"
                                                                class="form-control text-right number_only hospital_disc"
                                                                id="discount_percent_hospital"
                                                                name="discount_percent_hospital" placeholder="General"
                                                                onkeyup="billingEngine.posCalculateTotal(this)"
                                                                value="" />
                                                        @endif
                                                        <!-- onkeyup="billingEngine.posCalculateTotal(this)" -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6 percent_hospital">
                                                    <input type="text"
                                                        class="form-control text-right number_only hospital_disc"
                                                        id="discount_amount_hospital" name="discount_amount_hospital"
                                                        placeholder="Amount" onkeyup="calculateTotalDis(this)"
                                                        value="">
                                                </div>

                                                <div class="form-group col-md-6 d-none percent_doctor">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">%</span>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control text-right number_only doctor_disc"
                                                            id="discount_percent_doctor"
                                                            name="discount_percent_doctor" placeholder="Doctor"
                                                            value="" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 d-none percent_doctor">
                                                    <input type="text"
                                                        class="form-control text-right number_only doctor_disc"
                                                        id="discount_amount_doctor" name="discount_amount_doctor"
                                                        placeholder="Amount" onkeyup="calculateTotalDis(this)"
                                                        value="">
                                                </div>
                                            </div>

                                            <li
                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                <h6 class="float-left mr-2 mb-0">Discount&nbsp;By&nbsp;&nbsp;:</h6>
                                                <input type="text" name="" placeholder="Discount By"
                                                    id="dis_doctor_code" class="form-control">
                                                <input type="hidden" name="hdn_dis_doctor_id"
                                                    id="hdn_dis_doctor_id">
                                            </li>

                                            <li
                                                class="list-group-item d-flex align-items-center justify-content-between">
                                                <h6 class="float-left mr-2 mb-0"> Request&nbsp;By&nbsp;&nbsp;:</h6>
                                                <input type="text" name="dis_requ_by"
                                                    placeholder="Discount Request By" id="dis_requ_by"
                                                    class="form-control">
                                            </li>
                                        </div>

                                        <div class=" clearfix table-responsive mt-2 col-md-12">
                                            <table class="table table-hover fixed_header table-bordered pay_list">
                                                <thead>
                                                    <tr>
                                                        <th>Mode</th>
                                                        <th style="text-align: right;">Amount</th>
                                                        <th>Type (Card/Mbank)</th>
                                                        <th>Bank</th>
                                                        <th>Transaction ID</th>
                                                        <th>Card No</th>
                                                        <th colspan="2">Holder Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                                <tfoot id="tfoot">

                                                </tfoot>
                                            </table>
                                        </div>

                                        <div class="col-md-4 mt-2">
                                            <div class="clearfix">
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group bg-none w-100" data-toggle="buttons"
                                                        aria-label="First group">

                                                        @if (!empty($paymodes))

                                                            @foreach ($paymodes as $key => $paymode)
                                                                <label class="btn btn-outline-primary payMode bg-none <?= $key == 'CS' ? 'active' : ' '?>">
                                                                    <input type="radio" name="pay_mode"
                                                                        id="option" class="keep_me"
                                                                        value="{{ $key }}"
                                                                        {{ $key == 'CS' ? 'checked' : ' ' }}>
                                                                    {{ $paymode }}
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row border-top mt-1">
                                                <div class="col-md-12">
                                                    <div class="" id="cash">
                                                        <div class="mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control cash_amount number_only "
                                                                name="cash_amount" id="cash_amount" value=""
                                                                placeholder="Paid Amount"
                                                                onkeyup="billingEngine.calculatePayment(this)">
                                                        </div>
                                                        <div class="mb-2 mt-2">
                                                            <input type="text" class="form-control number_only"
                                                                id='cash_bd_amount' placeholder="Given Amount"
                                                                onkeyup="billingEngine.calculatePayment(this)">
                                                        </div>

                                                        <div class="mb-2 mt-2">
                                                            <input type="text" id="change_amount"
                                                                class="form-control number_only"
                                                                placeholder="Change Amount">
                                                        </div>



                                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="cash_amount" id="cash_add"  onclick="addFuntion(this)">Add</span> -->
                                                        <div style="border: 1px solid black"
                                                            class=" float-right mt-2 text-white bg-success">
                                                            <button type="button" onkedown="addFuntion(this)"
                                                                onclick="addFuntion(this)" value=""
                                                                name="cash_amount" id="cash_add"
                                                                class="bg-success admit_dissable">Add </button>
                                                        </div>

                                                    </div>
                                                    <div id="payment_method_cheque" class="d-none">
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control check_amount number_only"
                                                                name="check_amount" id="check_amount"
                                                                checked="checked" value=""
                                                                placeholder="Amount">
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">


                                                            <select class="form-control select2 payment_method_1"
                                                                id="bank_name" name="bank_name">
                                                                <option value="">Bank name</option>
                                                                @if ($bank_name)
                                                                    @foreach ($bank_name as $value)
                                                                        <option value="{{ $value }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <!-- <input type="text" class="form-control payment_method_1 " name="bank_name" id="bank_name" checked="checked" value="" placeholder="Bank Name"> -->
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control payment_method_1
															"
                                                                name="holder_name" id="holder_name" checked="checked"
                                                                value="" placeholder="Holder Name">
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control payment_method_1" name="check_no"
                                                                id="check_no" checked="checked" value=""
                                                                maxlength="16" placeholder="Cheque No">
                                                        </div>
                                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="check_amount" id="check_add" onclick="addFuntion(this)" >Add</span> -->
                                                        <div style="border: 1px solid black"
                                                            class=" float-right mt-2 text-white bg-success">
                                                            <button type="button" onkedown="addFuntion(this)"
                                                                onclick="addFuntion(this)" value=""
                                                                name="check_amount" id="check_add"
                                                                class="admit_dissable  bg-success">Add </button>
                                                        </div>


                                                    </div>
                                                    <div class="d-none" id="payment_method_card">
                                                        <select class="form-control" id="card_type" name="card_type">
                                                            <option value="">Card Type</option>
                                                            @if (!empty($card_type))
                                                                @foreach ($card_type as $key => $item)
                                                                    <option value="{{$item}}">{{$item}}</option>
                                                                @endforeach                                                              
                                                            @endif

                                                        </select>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control card_amount number_only"
                                                                name="card_amount" id="card_amount" checked="checked"
                                                                value="" placeholder="Amount">
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <select class="form-control select2 payment_method_1"
                                                                id="bank_name_card" name="bank_name_card">
                                                                <option value="">Bank name</option>
                                                                @if ($bank_name)
                                                                    @foreach ($bank_name as $value)
                                                                        <option value="{{ $value }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <!-- <input type="text" class="form-control payment_method_1 " name="bank_name_card" id="bank_name_card" checked="checked" value="" placeholder="Bank Name"> -->
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control payment_method_1
															"
                                                                name="holder_name" id="card_holder_name"
                                                                checked="checked" value=""
                                                                placeholder="Holder Name">
                                                        </div>

                                                        <div class="card-field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control payment_method_2 " name="card_no"
                                                                id="card_no" value=""
                                                                placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                                        </div>
                                                        <!-- <span class="btn btn-md btn-success float-right mt-2" name="card_amount" id="card_add" onclick="addFuntion(this)">Add</span> -->
                                                        <div style="border: 1px solid black"
                                                            class=" float-right mt-2 text-white bg-success">
                                                            <button type="button" onkedown="addFuntion(this)"
                                                                onclick="addFuntion(this)" value=""
                                                                name="card_amount" id="card_add"
                                                                class="bg-success admit_dissable">Add </button>
                                                        </div>
                                                    </div>
                                                    <div class="d-none" id="payment_method_bkash">


                                                        <select class="form-control" id="mBanking_type"
                                                            name="mBanking_type">
                                                            <option value="">Mobile Banking Name</option>
                                                            <option value="bKash">bKash</option>
                                                            <option value="nogod">Nogod</option>
                                                            <option value="rocket">Rocket</option>
                                                        </select>

                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control mBank_amount number_only"
                                                                name="mBank_amount" id="mBank_amount"
                                                                checked="checked" value=""
                                                                placeholder="Amount">
                                                        </div>
                                                        <div class="cheque_field mb-2 mt-2">
                                                            <input type="text"
                                                                class="form-control payment_method_1 "
                                                                name="bkash_txn_id" id="bkash_txn_id"
                                                                checked="checked" value=""
                                                                placeholder="Transection ID">
                                                        </div>

                                                        <div style="border: 1px solid black"
                                                            class=" float-right mt-2 text-white bg-success">
                                                            <button type="button" onkedown="addFuntion(this)"
                                                                onclick="addFuntion(this)" value=""
                                                                name="bkash_amount" id="bkash_add"
                                                                class="bg-success admit_dissable">Add </button>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="hidden" name="hdn_patient_id1" value=""
                                                        readonly="readonly">
                                                    @php
                                                        $bill_id = '';
                                                        $page_type = 2;
                                                    // $response_url = route('pos-invoice', $bill_id); 
                                                    $response_url = route('bill-invoice-pos-print-v2', $bill_id); 
                                                    if(Session::get('user.ses_hospital_code')=="UNICO") {
                                                        $url = route('med-item-from-prescription'); 
                                                    }else{
                                                        $url = route('billing.pharmacy-billing-v2'); 
                                                    }
                                                    

                                                    @endphp
                                                    <button class="btn btn-md btn-success"
                                                        data-response_action="{{ $response_url }}"  data-url="{{ $url }}"
                                                        onclick="billingEngine.createPosBillV2(this)">Save</button>
                                                    <span class="btn btn-md btn-info"
                                                        onclick="billingEngine.resetPosForm()">Clear</span>
                                                    <a href="{{ route('home') }}" class="btn btn-danger btn-md"
                                                        rel="tab"
                                                        title="Click here to go back to Dashboard">Exit</a>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="col-md-8 mt-2">
                                            <ul
                                                class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                                <li class="list-group-item">
                                                    <h5 class="float-left mr-2">Total Amount</h5>
                                                    <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                        id="item_total"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                                </li>
                                                <li class="list-group-item d-none">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <span class="mr-2 float-left d-none">Service Charge</span>
                                                            <div class="float-left d-none">
                                                                <input type="text" class="form-control mb-0"
                                                                    id="s_charge" name="s_charge" value=""
                                                                    placeholder="0.00" readonly="readonly"
                                                                    onkeyup='billingEngine.posCalculateTotal(this)'
                                                                    style="width: 70px; text-align: right;">
                                                            </div>
                                                        </div>
                                                        <!-- <input type="hidden"class="form-control float-right number_only"id="urgent_fee" name="total_urgent_fee" placeholder="0.00" style="width:70px; text-align: right;"> -->
                                                        <div class="col-md-6 text-right">
                                                            <span class="mr-2">Urgent Fee</span>
                                                            <div class="float-right">
                                                                <input type="text"
                                                                    class="form-control float-right number_only"
                                                                    id="urgent_fee" name="total_urgent_fee"
                                                                    placeholder="0.00"
                                                                    style="width:70px; text-align: right;"
                                                                    onkeyup="urgentFee(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="form-row">
                                                        <div class="col-md-6">
                                                            <span class="mr-2 float-left d-none">VAT/Tax</span>
                                                            <div class="float-left">
                                                                <input type="text" class="form-control mb-0 d-none"
                                                                    id="item_vat" name="item_vat" value=""
                                                                    placeholder="0.00"
                                                                    onkeyup='billingEngine.posCalculateTotal(this)'
                                                                    style="width: 70px; text-align: right;">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <span class="mr-2">Discount</span>
                                                            <div class="float-right">
                                                                <input type="text"
                                                                    class="form-control float-right number_only"
                                                                    id="total_discount_amount"
                                                                    name="total_discount_amount" value=""
                                                                    readonly="readonly" placeholder="0.00"
                                                                    style="width:70px; text-align: right;"
                                                                    maxlength="8">

                                                                <input type="text"
                                                                    class="form-control float-right number_only"
                                                                    id="discount_percent" name="discount_percent"
                                                                    placeholder="%" readonly="readonly"
                                                                    style="width:50px; text-align: right;"
                                                                    onkeyup="" value="0"> (%)
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="float-right">
                                                        <input type="text" id="total_payable" name="total_payable"
                                                            class="form-control number_only"
                                                            style="width: 70px; text-align: right;" placeholder=""
                                                            onkeyup="" readonly="readonly"
                                                            value="{{ isset($total_p) ? $total_p : 0.0 }}">
                                                    </div>
                                                    <span class="float-right mr-2">Payable Amount</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="float-right">
                                                        <input type="text" id="dis_adj_amt" name="dis_adj_amt"
                                                            class="form-control number_only"
                                                            style="width: 70px; text-align: right;" placeholder=""
                                                            onkeyup="" readonly="readonly" value="">
                                                    </div>
                                                    <span class="float-right mr-2">Discount Adj. Amt</span>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="float-right">
                                                        <input type="text" id="pay_amount" name="total_payment"
                                                            class="form-control number_only"
                                                            style="width: 70px; text-align: right;" placeholder=""
                                                            readonly="readonly"
                                                            onkeyup="billingEngine.calculatePayment(this)"
                                                            value="">
                                                    </div>
                                                    <span class="float-right mr-2">Payment Amount</span>
                                                </li>
                                                {{-- <li class="list-group-item">
										<div class="float-right">
											<input  id="given_amount" name="given_amount" type="text" class="form-control" style="width: 70px; text-align: right;" placeholder=""   readonly="readonly"  onkeyup="billingEngine.calculatePayment(this)">
										</div>
										<span class="float-right mr-2">Given Amount</span>

									</li>
									<li class="list-group-item">
										<div class="float-right">
											<input type="text" class="form-control number_only" id="change_amount" name="change_amount" placeholder="00.00" disabled="disabled" style="width: 70px; text-align: right;" >
										</div>
										<span class="float-right mr-2">Change Amount</span>
									</li> --}}

                                                <li class="list-group-item">
                                                    <input type="hidden" class="form-control mb-0" id="total_due"
                                                        name="total_due">

                                                    <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                        id="total_due_data"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                                    <h5 class="float-right mr-2">Due</h5>
                                                </li>

                                            </ul>
                                        </div>
                                     
                                        <input type="hidden" value="" id="given_amount" name="given_amount">
                                        <input type="hidden"  id="item_from_prescription" name="item_from_prescription" value="{{isset($press_code) ? $press_code :''}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </form>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#dis_doctor_code', 'hdn_dis_doctor_id');
    $(document).on('keyup', '#discount_percent_hospital', function(e) {
    console.log('discount_percent_hospital')
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();            
            calculateDisTotalHospital(this);
        }
    });

    $(document).on('keyup', '#discount_percent_doctor', function(e) {
        console.log('discount_percent_hospital__2')
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateDisTotalDoctor(this);
        }
    });

 

    function calculateDisTotalHospital(thisElement) {
        var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        if ((h_amt + d_amt) > itemT_pay) {
            $("#discount_percent_hospital").val('');
            $("#discount_amount_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_doctor").val('');
            $("#total_discount_amount").val('');
            alert("Invalid Discount");
            calculateDisTotal(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });

                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val(item_total.toFixed(2));
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = ((item_total * discount_percent_hospital) / 100).toFixed(2);
                if (discount_amt_hospital == 0) {
                    discount_amt_hospital = "";
                } else {
                    discount_amt_hospital;
                }
                $("#discount_amount_hospital").val(discount_amt_hospital);

                var discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                if (discount_percent_doctor <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val('');
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var amount_of_discount = discount_percent_doctor + discount_percent_hospital; //need
                if (amount_of_discount <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    $("#discount_percent_doctor").val('');
                    $('#discount_amount_hospital').val('');
                    $('#discount_amount_doctor').val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }
                var discount_amt_doctor = ((item_total * discount_percent_doctor) / 100).toFixed(2);

                var discount_percent = $("#discount_percent").val() * 1;
                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total = (item_total * discount_percent) / 100;
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total);
                if (discount_percent_hospital != 0 || discount_percent_doctor != 0)
                    $("#discount_percent").val((discount_percent_hospital + discount_percent_doctor));
                else
                    $("#discount_percent").val('');
                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount = (discount_amt_doctor + discount_amt_hospital);
                    if (total_discount_amount == 0) {
                        total_discount_amount = '';
                    }
                    if ((discount_percent_hospital + discount_percent_doctor) == 0) {
                        $("#discount_percent").val('');
                    } else {
                        $("#discount_percent").val(discount_percent_hospital + discount_percent_doctor);
                    }
                    $("#total_discount_amount").val(total_discount_amount);
                    after_disc_amt = (item_total - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = (item_total * discount_percent) / 100;
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

              



                var item_vat = $("#item_vat").val() * 1;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                var adj_dis_amt = $('#dis_adj_amt').val() != "" ? parseFloat($('#dis_adj_amt').val()) : 0;

                $("#total_due_data").html(Math.abs((total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(2));
                $("#cash_amount").val((Math.floor(total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(2));
                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }


    function calculateDisTotalDoctor(thisElement) {
        var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        if ((h_amt + d_amt) > itemT_pay) {
            $("#discount_percent_hospital").val('');
            $("#discount_amount_hospital").val('');
            $("#discount_percent_doctor").val('');
            $("#discount_amount_doctor").val('');
            $("#total_discount_amount").val('');
            alert("Invalid Discount");
            calculateDisTotal(thisElement);
        } else {
            var item_total = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });
                item_total = Math.round(item_total);
                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val(item_total.toFixed(2));
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = ((item_total * discount_percent_hospital) / 100).toFixed(2);
                // if (discount_amt_hospital == 0) {
                // 	discount_amt_hospital = "";
                // } else {
                // 	discount_amt_hospital;
                // }
                // $("#discount_amount_hospital").val(discount_amt_hospital);
                discount_percent_doctor = $("#discount_percent_doctor").val() * 1;

                if (discount_percent_doctor <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_doctor").val('');
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }

                var amount_of_discount = parseFloat(discount_percent_doctor + discount_percent_hospital); //need

                if (amount_of_discount <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    $("#discount_percent_doctor").val('');
                    $('#discount_amount_hospital').val('');
                    $('#discount_amount_doctor').val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                    discount_percent_doctor = $("#discount_percent_doctor").val() * 1;
                }

                var discount_amt_doctor = ((item_total * discount_percent_doctor) / 100).toFixed(2);
                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }

                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = parseFloat(discount_percent_hospital +
                    discount_percent_doctor); //$("#discount_percent").val() * 1;
                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }
                var discount_amt_total = (item_total * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total);
                if (discount_percent_hospital != 0 || discount_percent_doctor != 0)
                    $("#discount_percent").val((discount_percent_hospital + discount_percent_doctor));
                else
                    $("#discount_percent").val('');
                var after_disc_amt = 0;
                var total_discount_amount = 0;
                if (discount_percent == 0) {
                    total_discount_amount = (discount_amt_doctor + discount_amt_hospital);
                    if (total_discount_amount == 0) {
                        total_discount_amount = '';
                    }
                    if ((discount_percent_hospital + discount_percent_doctor) == 0) {
                        $("#discount_percent").val('');
                    } else {
                        $("#discount_percent").val(discount_percent_hospital + discount_percent_doctor);
                    }
                    $("#total_discount_amount").val(total_discount_amount);
                    after_disc_amt = (item_total - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = (item_total * discount_percent) / 100;
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }



                $("#billing_table-body tr").each(function() {                    
                    var itemId= $(this).find('.item_id').val();
                    var item_amt=parseFloat($(this).find(".item_total_amt").val());
                    var discount_amt_ratio=(item_amt/item_total)* discount_amt_total;
                    $(this).find('.item_dis_amt').val(discount_amt_ratio.toFixed(2));
                    $(this).find('.item_dis').val(discount_percent_hospital + discount_percent_doctor);
                    $(this).find('#exp_item_total'+itemId).html(item_amt - discount_amt_ratio);

                });

                var item_vat = $("#item_vat").val() * 1;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                var adj_dis_amt = $('#dis_adj_amt').val() != "" ? parseFloat($('#dis_adj_amt').val()) : 0;

                var adj_amt = (total_payable - Math.floor(total_payable));
                if ($('#hospital_code').val() == 'JKMH') {
                    if (adj_amt > .5) {
                        var pay_amount = $('#pay_amount').val() * 1;
                        var minus_adj_discount = total_payable - (Math.round(total_payable));
                        $('#dis_adj_amt').val(minus_adj_discount.toFixed(2));
                        $("#total_due_data").html(((Math.floor(total_payable) + 1) - pay_amount).toFixed(2));
                        $("#cash_amount").val(((Math.floor(total_payable) + 1) - pay_amount).toFixed(2));
                    } else {
                        $('#dis_adj_amt').val(adj_amt.toFixed(2));
                        var pay_amount = $('#pay_amount').val() * 1;

                        $("#total_due_data").html((Math.floor(total_payable) - pay_amount).toFixed(2));
                        $("#cash_amount").val((Math.floor(total_payable) - pay_amount).toFixed(2));
                    }
                } else {
                    $("#cash_amount").val((Math.floor(total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(2));
                    $("#total_due_data").html(Math.abs((total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(
                        2));
                }



                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }



    function removeTableRowPayment(thisElement) {

        if (confirm("Are you sure?")) {
            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var total_payment_amt = $('#total_payment_amt').val() - amount;
            var pay_amounts = $('#pay_amount').val() - amount;
            $('#total_payment_amt').val(total_payment_amt.toFixed(2));
            $('#pay_amount').val(pay_amounts);
            var adj_dis_amt = $('#dis_adj_amt').val() != "" ? parseFloat($('#dis_adj_amt').val()) : 0;
            var total_amount = $("#total_payable").val() * 1;
            var pay_amount = pay_amounts * 1;
            if (total_amount > 0) {
                $("#total_due_data").html(Math.abs((total_amount - adj_dis_amt) - pay_amount).toFixed(2));
                var given_amount = $("#given_amount").val() * 1;

                if (pay_amount > 0) {
                    if (given_amount > 0)
                        $("#change_amount").val(given_amount - pay_amount);
                    else
                        $("#change_amount").val("");
                } else {
                    $("#change_amount").val("");
                }
            }
            $(thisElement).parents("tr").remove();
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            // $("#cash_amount").val((Math.floor(total_payable - adj_dis_amt) - pay_amount).toFixed(2));
        }

        if ($("#tbody tr").length < 1) {

            $("#tfoot").html("");
        }

        return;
    }

    function addFuntion(element) {

         let activeLabel = $(".payMode.active").find("#option").val();
            console.log(activeLabel )
             let   multiCash=false;
            if (activeLabel == 'CS') {
                $('.CS').each(function(index, element) {
                // "this" refers to the current element
                if ($(this).val()=='CASH') {
                    alert('Already given Amount On Cash.');
                    multiCash=true;
                }
                console.log(index, $(this).val());  
            });
        }
        if (multiCash == true) {
            return false;
        }
        var due_amount = $('#total_due_data').html();


        var tfoot =
            "<tr><td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

        $("#tfoot").html(tfoot);
        var amt = 0;
        if (activeLabel == 'CS') {
            var amount = $(element).parents('div').find("#cash_amount").val();
            var method_mode = 'CASH';
            var bank_name = "";
            var b_type = "";
            var trans_id = "";
            var card_no = "";
            var acc_holder_name = "";
        }

        if (activeLabel == 'Mbanking') {
            if ($('#mBanking_type').val() != "" && $('#bkash_txn_id').val() != "") {
                var amount = $("#mBank_amount").val();
                var method_mode = 'Mbanking';
                var bank_name = "";
                var b_type = $('#mBanking_type').val();
                var trans_id = $('#bkash_txn_id').val();
                var card_no = "";
                var acc_holder_name = "";
            } else {
                if ($('#mBanking_type').val() == "") {
                    alert('Enter Mbanking  Type');
                } else if ($('#bkash_txn_id').val() == "") {
                    alert('Enter Transection  ID');
                }
                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;

            }
        }

        if (activeLabel == 'CQ') {
            if ($('#bank_name').val() != "" && $('#check_no').val() != "" && $('#holder_name').val() != "") {
                var method_mode = 'CHEQUE';
                var amount = $("#check_amount").val();
                var bank_name = $('#bank_name').val();
                var b_type = "";
                var trans_id = "";
                var card_no = $('#check_no').val();
                var acc_holder_name = $('#holder_name').val();
            } else {
                if ($('#bank_name').val() == "") {
                    alert('Enter Bank  Name');
                } else if ($('#holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#check_no').val() == "") {
                    alert('Enter Cheque  No');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        if (activeLabel == 'CARD') {
            if ($('#bank_name_card').val() != "" && $('#card_no').val() != "" && $('#card_holder_name').val() != "" &&
                $('#card_type').val() != "") {
                var method_mode = 'CARD';
                var amount = $("#card_amount").val();
                var bank_name = $('#bank_name_card').val();
                var b_type = $('#card_type').val();
                var trans_id = "";
                var card_no = $('#card_no').val();
                var acc_holder_name = $('#card_holder_name').val();
            } else {
                if ($('#bank_name_card').val() == "") {
                    alert('Enter Bank  Name');
                } else if ($('#card_no').val() == "") {
                    alert('Enter Card  No');
                } else if ($('#card_holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#card_type').val() == "") {
                    alert('Enter Card  Type');
                }

                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        var table_row =
            "<tr><td ><input id='' class='method_mode "+activeLabel+"' readonly='readonly' type='text' name='pay_method_mode[]' value='" +
            method_mode +
            "' style='border: 0; width: 80px; text-align: right'></td><td><input class='total_amt' readonly='readonly' type='text' name='total_amt[]' value='" +
            amount +
            "' style='border: 0; width: 80px; text-align: right'></td><td><input class='' type='text' name='mBank_types[]' value='" +
            b_type +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='pay_bank_name[]' value='" +
            bank_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='trans_id_no[]' value='" +
            trans_id +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='card_number[]' value='" +
            card_no +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='acc_holder_name[]' value='" +
            acc_holder_name +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td> <td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger remove'  data-id='' onclick='removeTableRowPayment(this)' data-url='' title='Cancel '><i class='fas fa-times'></i></span></td></tr>";

        if ($("#tbody tr").length >= 1 && parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(due_amount)) {

            $("#tbody").append(table_row);
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
        } else {
            if (amount > 0 && parseFloat(amount) <= parseFloat(due_amount)) {
                $("#tbody").html(table_row);
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find(':input').val("");
                $('#payment_method_card').children().find(':input').val("");
                $('#payment_method_cheque').children().find(':input').val("");
            } else {
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find('#mBank_amount').val("");
                $('#payment_method_card').children().find('#card_amount').val("");
                $('#payment_method_cheque').children().find('#check_amount').val("");
                $('#cash_bd_amount').val("");
                alert(" Invalid Amount");
                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }

                return;
            }
        }

        $("input[class='total_amt']").each(function() {
            if ($(this).val() != '') {
                amt += parseFloat($(this).val());

                $('#total_payment_amt').val(amt.toFixed(2));
                $('#pay_amount').val(amt.toFixed(2));
            }
        });


        var total_amount = $("#total_payable").val() * 1;
        var total_urgent_fee_amount = $("#urgent_fee").val() != '' ? parseFloat($("#urgent_fee").val()) * 1 : 0;
        var pay_amount = amt * 1;
        var adj_amt = $('#dis_adj_amt').val();

        if (adj_amt < 0 && $('#hospital_code').val() == 'JKMH') {
            $("#total_due_data").html(Math.abs((Math.floor(total_amount) + 1) - pay_amount).toFixed(2));
        } else {
            console.log('bellal___________________' + Math.abs(Math.floor(total_amount) - pay_amount).toFixed(2))
            $("#total_due_data").html(Math.abs(Math.floor(total_amount) - pay_amount).toFixed(2));
        }

        if (total_amount >= pay_amount) {
        } else {
            if (adj_amt < 0 && $('#hospital_code').val() == 'JKMH') {
                $("#change_amount").val(pay_amount - (Math.floor(total_amount) + 1));
            } else {
                $("#change_amount").val(pay_amount - Math.floor(total_amount));
            }
        }

    }


    function urgentFee(Element) {
        var total_urgent_fee = $(Element).val() != '' ? parseFloat($(Element).val()) : 0;
        var item_total = $('#item_total').html() != '' ? parseFloat($('#item_total').html()) : 0;
        var total_dis = $('#total_discount_amount').val() != '' ? parseFloat($('#total_discount_amount').val()) : 0;
        var pay_amount = $('#pay_amount').val() != '' ? parseFloat($('#pay_amount').val()) : 0;
        var payable = (item_total + total_urgent_fee) - total_dis;
        var due = payable - pay_amount;
        var adj_amt = (payable - floor(payable));
        $('#total_payable').val(payable.toFixed(2));
        $('#dis_adj_amt').val(adj_amt.toFixed(2));
        $('#total_due_data').html(floor(due).toFixed(2));
        console.log(total_urgent_fee);
    }


    $(function() {
        $("#patient_type").focus();
        $('.select2').select2();

        $(document).on("click", "#option", function() {
            var paymentType = $(this).val();
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            if (paymentType == "CARD") {
                $("#payment_method_card").removeClass("d-none");
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").addClass("d-none");
            } else if (paymentType == "CQ") {
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_cheque").removeClass("d-none");
                $("#cash").addClass("d-none");

            } else if (paymentType == "Mbanking") {
                $("#payment_method_bkash").removeClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").addClass("d-none");
            } else if (paymentType == "CS") {
                $("#payment_method_bkash").addClass("d-none");
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#cash").removeClass("d-none");
            } else {
                $("#payment_method_card").addClass("d-none");
                $("#payment_method_cheque").addClass("d-none");
                $("#payment_method_bkash").addClass("d-none");

            }
        });


        $(document).on('change', '#cmb_discount', function() {
            var type = $(this).find(":selected").val();
            $("#discount_percent_doctor").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $("#percent_hospital").val("");
            $("#percent_doctor").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_amount_doctor").val("");
            if (type == "GENERAL") {
                $("#discount_percent_doctor").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }
            if (type == "DOCTOR") {
                $("#discount_percent_hospital").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").removeClass('d-none');
            }
            if (type == "BOTH") {
                $("#discount_percent_hospital").val("");
                $("#total_discount_amount").val("");
                $("#discount_percent").val("");
                $("#percent_hospital").val("");
                $("#percent_doctor").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_amount_doctor").val("");
                $(".percent_hospital").removeClass('d-none');
                $(".percent_doctor").removeClass('d-none');
            }

            if (type == "0") {
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }

            billingEngine.posCalculateTotalV2(this);
        });

        $('.patient_entry').on('hidden.bs.modal', function(e) {})
        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

        $(document).on("click", "#resetForm", function(e) {
            $("#frmBilling").find("input").val('');
        });

        $(document).on("change", "#su_no_fk", function(e) {
            $("#hdn_su_no_fk").val($("#su_no_fk").val());
        });
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });

    $(document).ready(function() {
        $("#select_pos_items").addClass('d-none');
        $("#cmbCategory").select2();

        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");

        var quantitiy = 0;
        $('.quantity-right-plus').on("click", function(e) {
            e.preventDefault();
            var quantity = parseInt($('.input-number').val());
            $(this).siblings('.input-number').val(quantity + 1);
        });

        $('.quantity-left-minus').on("click", function(e) {
            e.preventDefault();
            var quantity = parseInt($('.input-number').val());

            if (quantity > 0) {
                $(this).siblings('.input-number').val(quantity - 1);
            }
        });

        $(document).on("change", ".patient_type", function() {
            var patient_type = $(this).val();
            $('#patient_info').html("");
            
            if (patient_type == 1) {
                $(".patient_id_div , .admission_id_div , .prescription_id_div").addClass("d-none");
                $("#patient_id #admission_id #prescription_id").val("");
                $(".walk_in_customer").removeClass("d-none");
                $('.input_dissabled').prop('disabled', false);
                $('#hdn_patient_id').val('');
                $('#hdn_admission_id').val('')
                $('#hdn_patient_id').val('')
            }
            if (patient_type == 2) {
                $(".prescription_id_div, .admission_id_div,.walk_in_customer").addClass("d-none");
                $("#prescription_id, #admission_id").val("");
                $(".patient_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('')
                $('#hdn_patient_id').val('')
            }
            if (patient_type == 3) {
                $(".patient_id_div, .admission_id_div,.walk_in_customer").addClass("d-none");
                $("#patient_id, #admission_id").val("");
                $(".prescription_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('')
                $('#hdn_patient_id').val('')
            }
            if (patient_type == 4) {
                $(".patient_id_div, .prescription_id_div,.walk_in_customer").addClass("d-none");
                $("#patient_id, #prescription_id").val("");
                $(".admission_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('');
                $('#hdn_patient_id').val('');
                $('.input_dissabled').prop('disabled', true);
                if ($('#hospital_code').val() == 'IMPERIAL') {
                    $('.admit_dissable').prop('disabled', true);
                }
                 
            } else {
                $('.input_dissabled').prop('disabled', false);
                $('#hdn_admission_id').val('')
                    $('#hdn_patient_id').val('')
                if ($('#hospital_code').val() == 'IMPERIAL') {                 
                    $('.admit_dissable').prop('disabled', false);
                }

            }

            if (patient_type == 5) {
                $(".patient_id_div, .prescription_id_div,.walk_in_customer").addClass("d-none");
                $("#patient_id, #prescription_id").val("");
                $(".admission_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('')
                $('#hdn_patient_id').val('')
                $('.input_dissabled').prop('disabled', true);
                if ($('#hospital_code').val() == 'IMPERIAL') {
                    $('.admit_dissable').prop('disabled', true);
                }
            } 

            if (patient_type == 6) {
                $(".patient_id_div, .prescription_id_div,.walk_in_customer").addClass("d-none");
                $("#patient_id, #prescription_id").val("");
                $(".admission_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('');
                $('#hdn_patient_id').val('')
                $('.input_dissabled').prop('disabled', true);
                if ($('#hospital_code').val() == 'IMPERIAL') {
                    $('.admit_dissable').prop('disabled', true);
                }
            } 

            if (patient_type == 7) {
                $(".patient_id_div, .prescription_id_div,.walk_in_customer").addClass("d-none");
                $("#patient_id, #prescription_id").val("");
                $(".admission_id_div").removeClass("d-none");
                $('#hdn_admission_id').val('');
                $('#hdn_patient_id').val('')
                $('.input_dissabled').prop('disabled', true);
                if ($('#hospital_code').val() == 'IMPERIAL') {
                    $('.admit_dissable').prop('disabled', true);
                }
            } 

        });
    });

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        $('#tbody').html('');
        $('#tfoot').html('');
        $('#cash_amount').val('');
        $('#pay_amount').val(0);
        if ($("input[type=radio][name='item_dis_radio']:checked")) {
            billingEngine.posCalculateTotalItemWise(this);
        } else {
            billingEngine.posCalculateTotal(this);
        }
        enterItemDis('#item_dis');

    }

    function selectItem(item, obj) {
        if ($("#billing_table-body tr").length > 0) {
            var reter = 0;
            $(".hdn_item_qnty").each(function() {
                if ($(this).val() == "" || $(this).val() <= 0) {
                    alert("Enter Qty");
                    $(this).focus();
                    event.preventDefault();
                    reter = 1;
                }
            });
            if (reter == 1) {
                return false;
            }

        }
        console.log(item+'____************');
        var total = 0;
        var item_id = $('#item_rate_' + item.item_id).val();
        var uom_name = item.uom_name != null ? item.uom_name : "";
        var urgent_fee_amt = item.urgent_fee_amt != null ? item.urgent_fee_amt : 0;
        var default_discount = item.default_discount != null ? item.default_discount : 0;
        console.log(item.current_stock);
        var current_stock = item.current_stock ? item.current_stock : 0;
        var sl = $("#billing_table-body tr").length + 1;
        var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
        qty_edit = qty_edit.replace(':id', 1);
        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
        edit_action = edit_action.replace(':id', 1);

        var expiriable_ind = item.expireable;
        var expiry_date = expiriable_ind == 1 ?
            "<span Class='btn btn-sm btn-warning open-modal ' data-id=''    title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :
            "";
        var exp_checkbox = item.dealer_sales_price != null && item.dealer_sales_price > 0 ?
            "<input type='checkbox' name='wholesale_" + item.item_id +
            "[]' id='wholesale' onclick='wholesalePrice(this)' value='" + item.dealer_sales_price + "'>&nbsp; " + item
            .dealer_sales_price + "" : '';
        console.log(exp_checkbox);
        var service_no=$('#service_point').val();
        var generic_item_url = "{{ route('get-generic-item', [':generic_id',':service_id',':item_id']) }}"
            generic_item_url = generic_item_url.replace(':generic_id', item.generic_no_fk)
            generic_item_url = generic_item_url.replace(':service_id',service_no)
            generic_item_url = generic_item_url.replace(':item_id',item.item_id)
        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + ($("#billing_table-body tr").length *
                1 + 1) + "<input class='item_id item_id_"+item.item_id+"' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" + item
            .item_id + "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" + item.item_name +
            "'><input class='' type='hidden' name='delivery_date[]' value=''><input class='' type='hidden' name='item_delivery_status[]' value=''> <input class='' type='hidden' name='item_delivery_status[]' value=''><input type='hidden' id='hdn_item_urgent_fee' class='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' value='" +
            urgent_fee_amt +
            "' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
            .item_type + "'> </td>  <td class='text-left pb-2'><strong>" + item.item_code + " - </strong> " + item
            .item_name + " " + item.supplier_name + "<br><span id='exp_show_" + item.item_id +
            "'><input type='hidden' name='txt_expire_date[]' value='" + item.item_id + '_' + 0 +
            "'><input type='hidden' name='txt_batch[]' value='" + item.item_id + '_' + 0 + '_' + default_discount +
            "'><input type='hidden' name='batch_qty[]' value=''><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item.item_id+"'> <input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item.item_id+"' value=''> </span></td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
            item.item_id + "' value='" + item.item_rate +
            "' onkeyup='itemRateEdit(this)'><input type='hidden' class='form-control mb-0 text-right' name='item_rate_" +
            item.item_id + "[]' id='item_rate_" +
            item.item_id + "' value='" + item.item_rate +
            "'><input type='hidden' class='form-control mb-0 text-right' name='' id='item_rate_pre_" + item.item_id +
            "' value='" + item.item_rate + "'>" +
            "<input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" + item
            .item_id + "' item_rate='" + item.item_rate + "' value='" + item.item_id + '_' + item.item_rate +
            "' readonly='readonly' ><input type='hidden' class='form-control mb-0 text-right' name='' id='hdn_item_rate_pre_" +
            item.item_id + "' item_rate_pre='" + item.item_rate + "' value='" + item.item_id + '_' + item.item_rate +
            "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this); enterItemDis(this); itemFocus(this);showExpDateV1(this)' onfocusout='' id='hdn_item_qnty_" +
            item.item_id + "' name='hdn_item_qnty_" + item.item_id +
            "[]' value=''  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right' readonly='readonly' id='current_qty_" +
            item.item_id + "' value='" + current_stock + "'></td><td class=''>" + uom_name +
            "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" + item.uom_no_fk +
            "'></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
            default_discount +
            "' onkeyup='enterItemDis(this)' /></td><td class='text-right'><input type='text' name='item_dis_amt[]' onkeyup='enterItemDis(this)' id='item_dis_amt'  class='form-control mb-0 text-right item_dis_amt number_only' value=''/></td>"+
            "<td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
            item.item_id + "' value='" + total + "' ><span id='exp_item_total" + item.item_id + "'>" + total +
            "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='" +
                generic_item_url +
                "' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span><input type='hidden' name='uregent_fee[]' id='urgent_fee_" + item.item_id +
            "' class='form-control mb-0 text-right urgent_fee number_only' value='0' /></td></tr>";

            // urgent fee 

            // <td class=''><select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select></td><td class='text-right'><input type='text' name='uregent_fee[]' id='urgent_fee_" +
            // item.item_id +
            // "' class='form-control mb-0 text-right urgent_fee number_only' value=''  onkeyup='calculateUrgentFeeKeyUp(this)'/></td>


        $("#billing_table-body tr").each(function() {
            var items_id = $(this).children('td').find('.item_id').val();
            if (item.item_id == items_id) {
                alert("This item is already selected");
                table_row = '';
                return;
            }
        })
        if (sl > 1) {

            $("#billing_table-body").append(table_row);

            $('#hdn_item_qnty_' + item.item_id).focus();

        } else {

            $("#billing_table-body").html(table_row);

            $('#hdn_item_qnty_' + item.item_id).focus();
        }
        $('.item_typehead ').typeahead('val', '');
        $("#item_count").html($("#billing_table-body tr").length);
        $('.date_picker').datepicker();
        event.stopImmediatePropagation();

        patientTotalDue(item.patient_id, 0);
    };

    function itemFocus(element) {
        console.log($(element).val() + "this value");
        if ($(element).val() == '') {
            $(element).focus();
        } else {
            var code = event.keyCode || event.which;
            if (code == 13) {
                $('.item_typehead').focus();
                console.log(code + "code");
            }
        }
    }


    function wholesalePrice(Element) {
        if ($(Element).is(':checked')) {
            var id = $(Element).parent('td').parent('tr').find('#hdn_item_id').val();
            var wholesale_price = $(Element).val();
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + id).val();
            var default_discount = $(Element).parent('td').parent('tr').find("#item_dis").val();
            $('#item_rate_' + id).val(wholesale_price);
            $('#hdn_item_rate_' + id).val(id + '_' + wholesale_price);
            $('#hdn_item_rate_' + id).attr('item_rate', wholesale_price);
            var item_id = id;
            var hdn_expiry = "<input type='hidden' name='txt_expire_date[]' value='" + item_id + '_' + 0 +
                "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + 0 + '_' + default_discount +
                "'><input type='hidden' name='batch_qty[]' value=''> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item_id+"'><input type='hidden' name='internal_batch_no[]'  class='internal_batch' id='internal_batch_no_"+item_id+"' value=''>";
            $("#exp_show_" + item_id).html("");
            $("#exp_show_" + item_id).html(hdn_expiry);
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + item_id).val();
            var item_qnty = $(Element).parent('td').parent('tr').find("#hdn_item_qnty_" + item_id).val() * 1;
            console.log(stock_qty + '_' + item_qnty);

            if (stock_qty >= item_qnty) {
                var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
                $("#hdn_item_total_qnty_" + item_id).val(item_qnty * item_rate);
                $("#exp_item_total" + item_id).html("");
                $("#exp_item_total" + item_id).html(item_qnty * item_rate);

            } else {
                alert("Stock not available");
                var item_qnty = $("#hdn_item_qnty_" + item_id).val(0);
                calculateItemTotal(Element)
                return;
            }
            billingEngine.posCalculateTotal(this);

        } else {
            var id = $(Element).parent('td').parent('tr').find('#hdn_item_id').val();
            var wholesale_price = $(Element).val();
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + id).val();
            var item_rate_pre = $(Element).parent('td').parent('tr').find("#item_rate_pre_" + id).val();
            var hdn_item_rate_pre = $(Element).parent('td').parent('tr').find("#hdn_item_rate_" + id).val();
            var default_discount = $(Element).parent('td').parent('tr').find("#item_dis").val();
            $('#item_rate_' + id).val(item_rate_pre);
            $('#hdn_item_rate_' + id).val(id + '_' + hdn_item_rate_pre);
            $('#hdn_item_rate_' + id).attr('item_rate', item_rate_pre);
            var item_id = id;
            var hdn_expiry = "<input type='hidden' name='txt_expire_date[]' value='" + item_id + '_' + 0 +
                "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + 0 + '_' + default_discount +
                "'><input type='hidden' name='batch_qty[]' value=''> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item_id+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item_id+"' value=''>";
            $("#exp_show_" + item_id).html("");
            $("#exp_show_" + item_id).html(hdn_expiry);
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + item_id).val();
            var item_qnty = $(Element).parent('td').parent('tr').find("#hdn_item_qnty_" + item_id).val() * 1;
            console.log(stock_qty + '_' + item_qnty);
            if (stock_qty >= item_qnty) {
                var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
                $("#hdn_item_total_qnty_" + item_id).val(item_qnty * item_rate);
                $("#exp_item_total" + item_id).html("");
                $("#exp_item_total" + item_id).html(item_qnty * item_rate);

            } else {
                alert("Stock not available");
                var item_qnty = $("#hdn_item_qnty_" + item_id).val(0);
                calculateItemTotal(thisElement)
                return;
            }
            billingEngine.posCalculateTotal(this);
        }
    }

    function calculateItemTotal(thisElement) {
        console.log('tetsub');
        var item_id = $(thisElement).parents("tr").find(".item_id").val();
        var default_discount = $(thisElement).parent('td').parent('tr').find("#item_dis").val();
        var hdn_expiry = "<input type='hidden' name='txt_expire_date[]' value='" + item_id + '_' + 0 +
            "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + 0 + '_' + default_discount +
            "'><input type='hidden' name='batch_qty[]' value=''> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item_id+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item_id+"' value=''>";
        $("#exp_show_" + item_id).html("");
        $("#exp_show_" + item_id).html(hdn_expiry);
        var stock_qty = $("#current_qty_" + item_id).val();
        var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
        console.log($('#current_qty_' + item_id + '_' + item_qnty).val());

        if (stock_qty >= item_qnty) {
            var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
            $("#hdn_item_total_qnty_" + item_id).val((item_qnty * item_rate).toFixed(2));
            $("#exp_item_total" + item_id).html("");
            $("#exp_item_total" + item_id).html((item_qnty * item_rate).toFixed(2));

        } else {
            var hos_ind = $("#service_point").find(':selected').attr('data-posind');
            if (hos_ind == 1) {
                var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
                $("#hdn_item_total_qnty_" + item_id).val((item_qnty * item_rate).toFixed(2));
                $("#exp_item_total" + item_id).html("");
                $("#exp_item_total" + item_id).html((item_qnty * item_rate).toFixed(2));

            } else {
                var item_qnty = $("#hdn_item_qnty_" + item_id).val(0);
                calculateItemTotal(thisElement)
                return;
            }

        }

    }

    function salesQty(e) {
        var item_id = $(e).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();
        $("#hdn_item_qnty_" + item_id).val(sales_qty);
        return sales_qty;
    }

    // function showExpDate(element) {
    //     var item_id = $(element).parents("tr").find(".item_id").val();
    //     var sales_qty = $("#hdn_item_qnty_" + item_id).val();
    //     var default_discount = $(element).parent('td').parent('tr').find("#item_dis").val();
    //     if (sales_qty > 0) {
    //         var qty = sales_qty;
    //         var su_unit_no = $('#service_point').val();
    //         $.ajax({
    //             data: {
    //                 item_id: item_id,
    //                 qty: qty,
    //                 su_unit_no: su_unit_no
    //             },
    //             url: "{{ route('billing.pos-expire-show') }}",
    //             type: "post",
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success: function(data) {
    //                 var values = JSON.parse(data);
    //                 console.log(values +"_____________pos-expire-show____"+sales_qty);
    //                 if (values != "") {
    //                     var eventstring = new String();
    //                     eventstring = data.toString().replace(/"/g, "");

    //                     var expi = eventstring.split('|');

    //                     let exp = expi;
    //                     exp = exp.filter(item => item);

    //                     var exp_length = exp.length;

    //                     var exp_data = '';
    //                     var eventstr = '';
    //                     var i;
    //                     var add_qty = 0;
    //                     for (i = 0; i < exp_length; i++) {
    //                         eventstr = exp[i].split(',');
    //                         exp_data +=
    //                             "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" + exp[
    //                                 i] + "</span><input type='hidden' name='txt_expire_date[]' value='" +
    //                             item_id + '_' + eventstr[1] +
    //                             "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' +
    //                             eventstr[0] + '_' + default_discount +
    //                             "'><input type='hidden' name='batch_qty[]' value='" +
    //                             item_id + '_' + eventstr[2] + "'>";
    //                         var total_expi_qty = parseFloat(eventstr[2]);
    //                         add_qty += total_expi_qty;
    //                     }
    //                     var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
    //                     edit_action = edit_action.replace(':id', add_qty + ':' + item_id + '^' +
    //                         eventstring);
    //                     var edit =
    //                         "<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" +
    //                         edit_action +
    //                         "' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit' onclick='showExpDate(this)'><i class='fa fa-pencil-alt'></i></span>";
    //                     $('#exp_show_' + item_id).html(exp_data + edit);
    //                     $('#hdn_item_qnty_' + item_id).val(add_qty);
    //                     if ($("input[type=radio][name='item_dis_radio']:checked")) {
    //                         billingEngine.posCalculateTotalItemWise(this);
    //                     } else {
    //                         billingEngine.posCalculateTotal(this);
    //                     }

    //                 } else {
    //                     alert("Batch not found");
    //                     return;
    //                 }

    //             },
    //             complete: function() {

    //             },
    //             error: function(data) {
    //                 var errors = jQuery.parseJSON(data.responseText).errors;
    //                 error_messages = "";
    //                 for (messages in errors) {
    //                     var field_name = $("#" + messages).siblings("label").html();
    //                     error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
    //                         messages] + "</div>";
    //                 }
    //                 $('.common-modal-notify-error').modal('show');
    //                 $('.common-modal-notify-error .modal-title').html("Validation Error");
    //                 $('.common-modal-notify-error .modal-body').html(error_messages);

    //                 $.unblockUI();
    //             }
    //         }).done(function() {
    //             $.unblockUI();
    //         });
    //     } else {
    //         alert("Enter Sales Quantity")
    //         event.stopImmediatePropagation();
    //     }
    // }
    function showExpDateV1(element) {
        if ($('#hospital_code').val()=="UNICO" || $('#hospital_code').val() =="DMHL" || $('#hospital_code').val() =="KPJ") {
            var item_id = $(element).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();
        var default_discount = $(element).parent('td').parent('tr').find("#item_dis").val();
        if (sales_qty > 0) {
            var qty = sales_qty;
            var su_unit_no = $('#service_point').val();
            $.ajax({
                data: {
                    item_id: item_id,
                    qty: qty,
                    su_unit_no: su_unit_no
                },
                url: "{{ route('billing.pos-expire-show') }}",
                type: "post",
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {
                    var values = JSON.parse(data);
                    console.log(values +"_____________pos-expire-show____"+sales_qty);
                    if (values != "") {
                        var eventstring = new String();
                        eventstring = data.toString().replace(/"/g, "");
                        var expi = eventstring.split('|');
                        let exp = expi;
                        exp = exp.filter(item => item);
                        var exp_length = exp.length;
                        var exp_data = '';
                        var eventstr = '';
                        var i;
                        var add_qty = 0;
                        let sales_price=0;
                        for (i = 0; i < exp_length; i++) {
                            eventstr = exp[i].split(',');
                            sales_price +=parseFloat(eventstr[4]) * parseFloat(eventstr[2]);
                            exp_data +=
                                "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" + exp[
                                    i] + "</span><input type='hidden' name='txt_expire_date[]' value='" +
                                item_id + '_' + eventstr[1] +
                                "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' +
                                eventstr[0] + '_' + default_discount +
                                "'><input type='hidden' name='batch_qty[]' value='" +
                                item_id + '_' + eventstr[2] + "'><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item_id+"' value='"+eventstr[4]+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item_id+"' value='"+eventstr[3]+"'>";
                            var total_expi_qty = parseFloat(eventstr[2]);
                            add_qty += total_expi_qty;

                        }
                        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
                        edit_action = edit_action.replace(':id', add_qty + ':' + item_id + '^' +
                            eventstring);
                        var edit ='';
                            // "<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" +
                            // edit_action +
                            // "' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit' onclick='showExpDate(this)'><i class='fa fa-pencil-alt'></i></span>";

                        if (sales_price > 0) {
                            let sales_price_avg=(sales_price/add_qty).toFixed(2);
                            $('#item_ratee_' + item_id).val(sales_price_avg);
                            $('#item_rate_' + item_id).val(sales_price_avg);
                            $('#item_rate_pre_' + item_id).val(sales_price_avg);
                            $('#hdn_item_rate_' + item_id).val(item_id+'_'+sales_price_avg);
                            $('#hdn_item_rate_' + item_id).attr('item_rate',sales_price_avg);
                            $('#hdn_item_rate_pre_' + item_id).val(item_id+'_'+sales_price_avg);
                            $('#hdn_item_rate_pre_' + item_id).attr('item_rate_pre',sales_price_avg);
                        }
                       
                       
                        $('#hdn_item_qnty_' + item_id).val(add_qty);
                        // if ($("input[type=radio][name='item_dis_radio']:checked")) {
                              
                              billingEngine.posCalculateTotalItemWise($('#hdn_item_qnty_' + item_id));                          
                              calculateItemTotal( $('#hdn_item_qnty_' + item_id));
                              enterItemDis( $('#hdn_item_qnty_' + item_id)); 
                        //   }
                        //   else {
                        //     calculateItemTotal( $('#hdn_item_qnty_' + item_id));
                        //     billingEngine.posCalculateTotal( $('#hdn_item_qnty_' + item_id));
                        //     enterItemDis( $('#hdn_item_qnty_' + item_id)); 
                           
                        //   }
                        $('#exp_show_' + item_id).html(exp_data + edit);
                       

                        // if ($("input[type=radio][name='item_dis_radio']:checked")) {
                        //     billingEngine.posCalculateTotalItemWise(this);
                        // } else {
                        //     billingEngine.posCalculateTotal(this);
                        // }

                    } else {
                        // alert("Batch not found");
                        return;
                    }

                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                // $.unblockUI();
            });
        } else {
            // alert("Enter Sales Quantity")
            event.stopImmediatePropagation();
            }
        }     
    }

    function selectedPatient(item, obj) {

        if (item.length != 0) {
            $("#billing_table-body").html("");
            $('.admissionButton').html(0);
            $('.admissionButton').attr('title', "");
            if ($('#hospital_code').val() != "EWMCH") {
                console.log(item)
                $.ajax({
                    url: "{{ route('item-info-autocomplete-admission-pos') }}",
                    type: 'POST',
                    data: {
                        admission_no_pk: item.admission_no_pk
                    },
                    dataType: 'json',
                    success: function(data) {
                        jQuery.each(data, function(index, item) {
                            var total = 0;
                            var item_id = $('#item_rate_' + item.item_no_fk).val();
                            var uom_name = item.uom_name != null ? item.uom_name : "";

                            var current_stock = item.current_stock ? item.current_stock : 0;
                            var default_discount = item.default_discount != null ? item
                                .default_discount :
                                0;
                            var sl = $("#billing_table-body tr").length + 1;
                            var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
                            qty_edit = qty_edit.replace(':id', 1);
                            var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
                            edit_action = edit_action.replace(':id', 1);

                            var expiriable_ind = item.expireable;
                            var expiry_date = expiriable_ind == 1 ?
                                "<span Class='btn btn-sm btn-warning open-modal ' data-id=''    title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :
                                "";
                            var exp_checkbox = item.dealer_sales_price != null && item
                                .dealer_sales_price >
                                0 ? "<input type='checkbox' name='wholesale_" + item.item_no_fk +
                                "[]' id='wholesale' onclick='wholesalePrice(this)' value='" + item
                                .dealer_sales_price + "'>&nbsp; " + item.dealer_sales_price + "" :
                                '';

                            var table_row =
                                "<tr><td class='text-center bg-light' style='width:2%'>" + ($(
                                    "#billing_table-body tr").length * 1 + 1) +
                                "<input class='item_id' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +
                                item.item_no_fk +
                                "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                                item.item_name +
                                "'><input class='' type='hidden' name='delivery_date[]' value=''><input class='' type='hidden' name='item_delivery_status[]' value=''> <input class='' type='hidden' name='item_delivery_status[]' value=''><input type='hidden' id='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                                item.item_type + "'> </td>  <td class='text-left pb-2'><strong>" +
                                item
                                .item_code + " - </strong> " + item.item_name +
                                " <br><span id='exp_show_" +
                                item.item_no_fk +
                                "'><input type='hidden' name='txt_expire_date[]' value='" + item
                                .item_no_fk + '_' + 0 +
                                "'><input type='hidden' name='txt_batch[]' value='" + item
                                .item_no_fk +
                                '_' + 0 + '_' + default_discount +
                                "'><input type='hidden' name='batch_qty[]' value=''>  <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+item
                                .item_no_fk+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item.item_no_fk+"' value=''></span></td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
                                item.item_no_fk + "' value='" + item.sales_price +
                                "' onkeyup='itemRateEdit(this)'><input type='hidden' class='form-control mb-0 text-right' name='item_rate_" +
                                item.item_no_fk + "[]' id='item_rate_" +
                                item.item_no_fk + "' value='" + item.sales_price +
                                "'><input type='hidden' class='form-control mb-0 text-right' name='' id='item_rate_pre_" +
                                item.item_no_fk + "' value='" + item.sales_price + "'>" +
                                "<input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                                item.item_no_fk + "' item_rate='" + item.sales_price + "' value='" +
                                item
                                .item_no_fk + '_' + item.sales_price +
                                "' readonly='readonly' ><input type='hidden' class='form-control mb-0 text-right' name='' id='hdn_item_rate_pre_" +
                                item.item_no_fk + "' item_rate_pre='" + item.sales_price +
                                "' value='" +
                                item.item_no_fk + '_' + item.sales_price +
                                "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right ' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this) ; enterItemDis(this);showExpDateV1(this)' onfocusout='' id='hdn_item_qnty_" +
                                item.item_no_fk + "' name='hdn_item_qnty_" + item.item_no_fk +
                                "[]' value='0'  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right' readonly='readonly' id='current_qty_" +
                                item.item_no_fk + "' value='" + current_stock +
                                "'></td><td class=''>" +
                                uom_name +
                                "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" +
                                item.uom_no_fk +
                                "'></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
                                default_discount +
                                "' onkeyup='enterItemDis(this)' /><td class='text-right'><input type='text' name='item_dis_amt[]' onkeyup='enterItemDis(this)' id='item_dis_amt'  class='form-control mb-0 text-right item_dis_amt number_only' value=''/></td>"  +
                                "</td><td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                                item.item_no_fk + "' value='" + total +
                                "' ><span id='exp_item_total" + item
                                .item_no_fk + "'>" + total +
                                "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><input type='hidden' name='uregent_fee[]' id='urgent_fee_" + item.item_id +"' class='form-control mb-0 text-right urgent_fee number_only' value='0' /></td></tr>";

                                 //urgent fee remove 
                                 
                                //  <td class=''><select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select></td><td class='text-right'><input type='text' name='uregent_fee[]' id='urgent_fee_" +
                                // item.item_id +
                                // "' class='form-control mb-0 text-right urgent_fee number_only' value=''  onkeyup='calculateUrgentFeeKeyUp(this)'/></td>

                            if (item.item_no_fk != 0) {
                                $("#billing_table-body").append(table_row);
                            }
                        });
                        var item_n = "";
                        var written_item = 0;
                        jQuery.each(data, function(index, item) {
                            var table_row =
                                "<input class='item_id' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +
                                item.item_no_fk + "' >";
                            if (item.item_no_fk == 0) {
                                written_item += 1;
                                if (written_item > 1) {
                                    item_n += ' , ' + item.item_name;
                                } else {
                                    item_n += item.item_name;
                                }
                                //  item_n += item.item_name+' , ';
                                $('.admissionButton').html(written_item);
                                $('.admissionButton').attr('title', item_n);
                            }
                        });
                        // billingEngine.posCalculateTotal(this);
                        $('.item_typehead ').typeahead('val', '');
                        $("#item_count").html($("#billing_table-body tr").length);
                        $('.date_picker').datepicker();
                        event.stopImmediatePropagation();
                    }
                });
            }
            $("#patient_id").val("");
            $("#hdn_admission_id").val(item.admission_no_pk != null ? item.admission_no_pk : '');
            $("#hdn_patient_id").val(item.patient_id);
            var phone_no = item.doctphone_mobileor_mobile ? "  <strong>Phone : </strong>" + item
                .doctphone_mobileor_mobile : "";
            var name = item.patient_name ? "  <strong>Name : </strong>" + item.patient_name : "";
            var PID = item.patient_code ? "<strong>PID : </strong>" + item.patient_code : "";


            var admission_no_pk = item.admission_no_pk ? "<strong> Admission Id : </strong>" + item.admission_no_pk :
                "";
            var bed_name = item.new_bed_name ? "<strong> Bed Name : </strong>" + item.new_bed_name : "";
            var new_ward_name = item.new_ward_name ? "<strong> Ward Name : </strong>" + item.new_ward_name : "";
            var new_su_name = item.new_su_name ? "<strong> Department Name : </strong>" + item.new_su_name : "";
            var patient_information = PID + name + admission_no_pk + phone_no + bed_name + new_ward_name + new_su_name;


            console.log("sds 2116" , item);

                    
            if(item.lock_ind === "1" || item.lock_ind === 1){
                alert('Patient Bill is Locked!');
                $("#hdn_admission_id").val('');
                $("#admission_id").val('');
                $("#hdn_patient_id").val('');
                $("#patient_info").html('');
                $('.input_dissabled').prop('disabled', true);
                return false;
            }
        

            if (item.dis_ind == 1) {
                alert('Patient is already Discharged !')
                $("#hdn_admission_id").val('');
                $("#admission_id").val('');
                $('.input_dissabled').prop('disabled', true);
                $("#patient_info").html('');
            } else {
                console.log($('#hospital_code').val())
                $("#patient_info").html(patient_information);
                $('.input_dissabled').prop('disabled', false);
            }
        } else {
            $("#hdn_patient_id").val('');
            $("#patient_info").html(`<h4 style="color:red">No Data Found</h4>`);
            $("#hdn_patient_id").val('');
            $('#patient_id').typeahead('val', '');
            $('#item_type_no_pk').val('');
            $('#discount_percent_hospital').val(0);
            $('#admission_id').typeahead('val', '');
            $("#patient_id").removeAttr("required");
            $("#hdn_admission_id").val('');
            $("#patient_itemType_dis_ind").val('');
            $("#billing_table-body").html('');
            $(".payment_history").children('#tbody').html('');
            $(".payment_history").children('#tfoot').html('');
        }

    }

    function prescriptionPatientInfo(item, obj) {
      
        if (item.length != 0) {
            $("#billing_table-body").html("");
            $('.button5').html(0);
            $('.button5').attr('title', "");
            
            $.ajax({
                url: "{{ route('item-info-autocomplete-prescription-pos-v2') }}",
                type: 'POST',
                data: {
                    prescription_no_pk: item.prescription_no_pk,
                    service_point: $('#service_point').val()
                },
                dataType: 'json',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {                  
                    
                    jQuery.each(data, function(index, item) {
                        console.log(item);
                        var total = 0;
                        var item_id = $('#item_rate_' + item.item_no_fk).val();
                        var uom_name = item.uom_name != null ? item.uom_name : "";

                        var current_stock = item.current_stock ? item.current_stock : 0;
                        var default_discount = item.disc_aplicable ==0 || item.disc_aplicable ==null ? (item.default_discount_pct??0) :0;
                        var sl = $("#billing_table-body tr").length + 1;
                        var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
                        qty_edit = qty_edit.replace(':id', 1);
                        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
                        edit_action = edit_action.replace(':id', 1);

                        var expiriable_ind = item.expireable;
                        var expiry_date = expiriable_ind == 1 ?
                            "<span Class='btn btn-sm btn-warning open-modal ' data-id='' title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :
                            "";
                        var exp_checkbox = item.dealer_sales_price != null && item
                            .dealer_sales_price >
                            0 ? "<input type='checkbox' name='wholesale_" + item.item_no_fk +
                            "[]' id='wholesale' onclick='wholesalePrice(this)' value='" + item
                            .dealer_sales_price + "'>&nbsp; " + item.dealer_sales_price + "" : '';
                        var service_no=$('#service_point').val();
                        var generic_item_url ="{{route('get-generic-item',[':generic_id',':service_id',':item_id'])}}"    
                            generic_item_url = generic_item_url.replace(':generic_id',item.generic_no_fk)
                            generic_item_url = generic_item_url.replace(':service_id',service_no)
                            generic_item_url = generic_item_url.replace(':item_id',item.item_no_fk)
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + (
                                $(
                                    "#billing_table-body tr").length * 1 + 1) +
                            "<input class='item_id item_id_"+item.item_no_fk+"' type='hidden' name='hdn_item_id[]'  id='hdn_item_id' value='" +
                            item.item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            item.item_name +
                            "'><input class='' type='hidden' name='delivery_date[]' value=''><input class='' type='hidden' name='item_delivery_status[]' value=''> <input class='' type='hidden' name='item_delivery_status[]' value=''><input type='hidden' id='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            item.item_type + "'> </td>  <td class='text-left pb-2'><strong>" + item
                            .item_code + " - </strong> " + item.item_name +
                            " <br><span id='exp_show_" +
                            item.item_no_fk +
                            "'><input type='hidden' name='txt_expire_date[]' value='" + item
                            .item_no_fk + '_' + 0 +
                            "'><input type='hidden' name='txt_batch[]' value='" + item.item_no_fk +
                            '_' + 0 + '_' + default_discount +
                            "'><input type='hidden' name='batch_qty[]' value=''><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item.item_no_fk+"'> <input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item.item_no_fk+"' value=''> </span></td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
                            item.item_no_fk + "' value='" + item.sales_price +
                            "' onkeyup='itemRateEdit(this)'><input type='hidden' class='form-control mb-0 text-right' name='item_rate_" +
                            item.item_no_fk + "[]' id='item_rate_" +
                            item.item_no_fk + "' value='" + item.sales_price +
                            "'><input type='hidden' class='form-control mb-0 text-right' name='' id='item_rate_pre_" +
                            item.item_no_fk + "' value='" + item.sales_price + "'>" +
                            "<input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            item.item_no_fk + "' item_rate='" + item.sales_price + "' value='" +
                            item
                            .item_no_fk + '_' + item.sales_price +
                            "' readonly='readonly' ><input type='hidden' class='form-control mb-0 text-right' name='' id='hdn_item_rate_pre_" +
                            item.item_no_fk + "' item_rate_pre='" + item.sales_price + "' value='" +
                            item.item_no_fk + '_' + item.sales_price +
                            "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right ' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this) ; enterItemDis(this);showExpDateV1(this)' onfocusout='' id='hdn_item_qnty_" +
                            item.item_no_fk + "' name='hdn_item_qnty_" + item.item_no_fk +
                            "[]' value='0'  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right' readonly='readonly' id='current_qty_" +
                            item.item_no_fk + "' value='" + current_stock + "'></td><td class=''>" +
                            uom_name +
                            "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" +
                            item.uom_no_fk +
                            "'></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
                            default_discount +
                            "' onkeyup='enterItemDis(this)'/></td><td class='text-right'><input type='text' name='item_dis_amt[]' onkeyup='enterItemDis(this)' id='item_dis_amt'  class='form-control mb-0 text-right item_dis_amt number_only' value=''/></td>"+
                            "<td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.item_no_fk + "' value='" + total + "' ><span id='exp_item_total" +
                            item
                            .item_no_fk + "'>" + total +
                            "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='"+generic_item_url+"' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span><input type='hidden' name='uregent_fee[]' id='urgent_fee_" + item.item_no_fk +"' class='form-control mb-0 text-right urgent_fee number_only' value='0' /></td></tr>";

                              // remove urgent fee 
                              
                            //   <td class=''><select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select></td><td class='text-right'><input type='text' name='uregent_fee[]' id='urgent_fee_" +
                            // item.item_id +
                            // "' class='form-control mb-0 text-right urgent_fee number_only' value=''  onkeyup='calculateUrgentFeeKeyUp(this)'/></td>

                        if (item.item_no_fk != 0) {
                            $("#billing_table-body").append(table_row);
                        }
                    });
                    var item_n = "";
                    var written_item = 0;
                    jQuery.each(data, function(index, item) {
                        var table_row =
                            "<input class='item_id' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +
                            item.item_no_fk + "' >";
                        if (item.item_no_fk == 0) {
                            written_item += 1;
                            if (written_item > 1) {
                                item_n += ' , ' + item.item_name;
                            } else {
                                item_n += item.item_name;
                            }
                            $('.button5').html(written_item);
                            $('.button5').attr('title', item_n);
                        }
                    });
                    console.log(item)
                    $('.item_typehead').typeahead('val', '');
                    $('#hdn_prescription_id').val(item.prescription_no_pk);
                    $('#hdn_admission_id').val(item.admission_no_fk);
                    $("#item_count").html($("#billing_table-body tr").length);
                    $('.date_picker').datepicker();
                    event.stopImmediatePropagation();
                }
            }).done(function() {
                $.unblockUI();
            });

            var patientNumber = item.phone_mobile ? ", <strong>Phone : </strong>" + item.phone_mobile : "";
            var patient_information = "<strong>Patient Code: " + item.patient_code + ", </strong>" +
                "<strong>Prescription ID: " + item.prescription_uid + " ,Name: " + item.patient_name +
                ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + patientNumber;
            $("#patient_info").html(patient_information);
            $('#patient_id').typeahead('val', '');
            $('#admission_id').typeahead('val', '');
            $("#patient_id").removeAttr("required");
            $("#hdn_admission_id").val('');
            $("#hdn_patient_id").val(item.patient_id);
        } else {
            $("#patient_info").html(`<h4 style="color:red">No Data Found</h4>`);

            $("#doctor_ref2_info").html("");
            $("#hdn_second_refer").val("");
            $("#doctor_ref1_info").html("");
            $("#hdn_first_refer").val("");
            $("#doctor_info").html("");
            $("#hdn_doctor_id").val("");

            $("#hdn_patient_id").val('');
            $('#patient_id').typeahead('val', '');
            $('#item_type_no_pk').val('');
            $('#discount_percent_hospital').val(0);
            $('#admission_id').typeahead('val', '');
            $("#patient_id").removeAttr("required");
            $("#hdn_admission_id").val('');
            $("#patient_itemType_dis_ind").val('');
            $("#billing_table-body").html('');
            $(".payment_history").children('#tbody').html('');
            $(".payment_history").children('#tfoot').html('');
        }
    }

    $(document).on('keypress', '#pat_id', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Prevent default form submission behavior
            PatIdAutocomplete($(this).val(), selectedPatient);
            $(this).focus();
            e.stopImmediatePropagation();
        }
    });


    function PatIdAutocomplete(query, callback) {
        $.ajax({
            url: "{{ route('patient-id-info-autocomplete') }}",
            type: 'POST',
            data: {
                search_data: query
            },
            dataType: 'json',
            success: function(item, obj) {
                console.log(item + '________result')
                callback(item, obj);
            }
        });
    }
    $(document).on('keypress', '#admission_id', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            admissionId($(this).val(), selectedPatient);
            $(this).focus();
            e.stopImmediatePropagation();
        }
    });


    function admissionId(query, callback) {
        $.ajax({
            url: "{{ route('admission-info-get-data') }}",
            type: 'POST',
            data: {
                search_data: query
            },
            dataType: 'json',
            success: function(item, obj) {
                callback(item, obj);
                console.log(item + '________result')
            }
        });
    }
    $(document).on('keypress', '#prescription_id', function(e) {
        if (e.which === 13) {         
            e.preventDefault(); 
            prescriptionData($(this).val(), prescriptionPatientInfo);
            $(this).focus();
            e.stopImmediatePropagation();
        }
    });

    $(document).ready(function(){       
       if ($('#item_from_prescription').val() != "") {
           prescriptionData($('#item_from_prescription').val(), prescriptionPatientInfo);
           $('#prescription_id').val($('#item_from_prescription').val())
           $('#prescribed_pat').prop('checked', true);
           $(".patient_id_div, .admission_id_div,.walk_in_customer").addClass("d-none");
           $("#patient_id, #admission_id").val("");
           $(".prescription_id_div").removeClass("d-none");
           $('#hdn_admission_id').val('')
           $('#hdn_patient_id').val('')
          
       }
   
   })

    function prescriptionData(query, callback) {
        $.ajax({
            url: "{{ route('prescription-info-get-data') }}",
            type: 'POST',
            data: {
                search_data: query
            },
            dataType: 'json',            
            success: function(item, obj) {
                callback(item, obj);
                console.log(item)
            },
        });
    }
    openPatientAutocompleteForBilling('#patient_id', 'patient_name', selectedPatient);
    $(document).ready(function() {       
        openItemAutocompleteWithStockV2(".item_typehead", "MED,LIQ,TAB,SUR,INV", "", "", selectItem,'',$('#service_point :selected').val(),$('#hdn_patient_id').val());
   
    });
    function servicePoint(params) {
        store_id($(params).val());
        $('#billing_table-body').html('');
        if ($('#prescription_id').val() !="") {
            prescriptionData($('#item_from_prescription').val(), prescriptionPatientInfo);
        }
      

    }
    function store_id(store_id){
        $(".item_typehead").each(function() {
                $(this).typeahead('destroy'); // Custom method to remove typeahead
                $(this).off(); // Remove all event handlers
                $(this).val(''); // Clear the input value
                $(this).parent().find('.tt-menu').remove(); // Remove the dropdown menu
            });
        openItemAutocompleteWithStockV2(".item_typehead", "MED,LIQ,TAB,SUR", "", "", selectItem,'',store_id,$('#hdn_patient_id').val());
        $("#item_name").parent('span').siblings('span').remove();
    }
   



    function get_sub_category(element) {
        var item_code = $(element).attr('data-id');

        $.ajax({
            data: {
                item_code: item_code
            },
            url: "{{ route('billing.get-pos-items-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#item_list").html(data);

            },
            complete: function() {

            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] +
                        "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
        });

    }

    var elem = document.getElementById("mypos");
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    function calculateTotalDis(thisElement) {

        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        var urgent_fee = $("#urgent_fee").val() != "" ? parseFloat($("#urgent_fee").val()) : 0;
        var t_amt = h_amt + d_amt;

        if (parseFloat(t_amt) > parseFloat($("#item_total").html())) {
            alert("Discount invalid");
            $("#discount_amount_hospital").val("");
            $("#discount_percent_hospital").val("");
            $("#discount_percent_doctor").val("");
            $("#discount_percent").val("");
            $("#discount_amount_doctor").val("");
            $("#total_discount_amount").val("");
            return calculateTotalDis(thisElement);

        } else {

            var item_total = 0;
            var delivery_status = 0;
            if ($("#billing_table-body tr").length > 0) {

                $("#billing_table-body tr").each(function() {
                    item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                });
                item_total = Math.round(item_total);
                $("#item_total").html(item_total.toFixed(2));
                $("#total_payable").val((item_total + urgent_fee).toFixed(2));

                var discount_percent_hospital = ($("#discount_amount_hospital").val() != "") ? parseFloat($(
                    "#discount_amount_hospital").val()) : 0;
                var discount_amt_hospital = (discount_percent_hospital);
                var item_total_amount = $("#item_total").html();

                var discount_percent_hospital_dis = (discount_percent_hospital > 0) ? (discount_percent_hospital * 100 /
                    parseFloat(item_total_amount)) : "";

                $("#discount_percent_hospital").val(discount_percent_hospital_dis ? discount_percent_hospital_dis
                    .toFixed(2) : "");
                var discount_percent_doctor = ($("#discount_amount_doctor").val() != "") ? parseFloat($(
                    "#discount_amount_doctor").val()) : 0;
                var discount_amt_doctor = (discount_percent_doctor);
                var item_total_amount = $("#item_total").html();

                var discount_percent_doctor_dis = (discount_percent_doctor > 0) ? (discount_percent_doctor * 100 /
                    parseFloat(item_total_amount)) : "";

                $("#discount_percent_doctor").val(discount_percent_doctor_dis ? discount_percent_doctor_dis.toFixed(2) :
                    "");
                var discount_percent = ($(thisElement).val() != "") ? $(thisElement).val() : 0;
                var discount_amt_total = (discount_percent);
                var after_disc_amt = 0;
                var total_discount_amount = 0;
                var total_discount_amount_per = 0;
                var h_perc = discount_percent_hospital_dis == "" ? 0 : discount_percent_hospital_dis;
                var doc_perc = discount_percent_doctor_dis == "" ? 0 : discount_percent_doctor_dis;
                if (discount_percent == 0) {
                    total_discount_amount = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    if ((h_perc + doc_perc) == 0) {
                        $("#discount_percent").val("");
                    } else {
                        total_discount_amount_per = parseFloat(h_perc) + parseFloat(doc_perc);

                        $("#discount_percent").val(total_discount_amount_per.toFixed(2));
                    }

                    $("#total_discount_amount").val(total_discount_amount.toFixed(2));

                    after_disc_amt = (item_total - total_discount_amount);
                } else {

                    discount_percent = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    total_discount_amount_per = parseFloat(h_perc) + parseFloat(doc_perc);

                    $("#discount_percent").val(total_discount_amount_per.toFixed(2));

                    discount_amt_total = discount_percent;
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }
                $("#billing_table-body tr").each(function() {
                    
                    var itemId= $(this).find('.item_id').val();
                    var item_amt=parseFloat($(this).find(".item_total_amt").val());
                    var discount_amt_ratio=(item_amt/item_total)* discount_amt_total;
                    $(this).find('.item_dis_amt').val(discount_amt_ratio.toFixed(2));
                    $(this).find('.item_dis').val(total_discount_amount_per.toFixed(2));
                    $(this).find('#exp_item_total'+itemId).html((item_amt - discount_amt_ratio).toFixed(2));

                });
                
                var item_vat = $("#item_vat").val() * 1;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge + urgent_fee));
                var pay_amount = $('#pay_amount').val() * 1;
                var adj_amt = (total_payable - Math.floor(total_payable));
                if ($('#hospital_code').val() == 'EWMCH') {
                    if (adj_amt > .5) {

                        var pay_amount = $('#pay_amount').val() * 1;
                        var minus_adj_discount = total_payable - (Math.round(total_payable));
                        $('#dis_adj_amt').val(minus_adj_discount.toFixed(2));
                        $("#total_due_data").html(((Math.floor(total_payable) + 1) - pay_amount).toFixed(2));
                        $("#cash_amount").val(((Math.floor(total_payable) + 1) - pay_amount).toFixed(2));
                    } else {
                        $('#dis_adj_amt').val(adj_amt.toFixed(2));
                        var pay_amount = $('#pay_amount').val() * 1;

                        $("#total_due_data").html((Math.floor(total_payable) - pay_amount).toFixed(2));
                        $("#cash_amount").val((Math.floor(total_payable) - pay_amount).toFixed(2));
                    }
                } else {
                    $('#dis_adj_amt').val(adj_amt.toFixed(2));
                    var pay_amount = $('#pay_amount').val() * 1;

                    $("#total_due_data").html((Math.floor(total_payable) - pay_amount).toFixed(2));
                    $("#cash_amount").val((Math.floor(total_payable) - pay_amount).toFixed(2));
                }
                $("#total_payable").val(total_payable.toFixed(2));

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0.00);
                $('#pay_amount').val(0.00);
                $('#given_amount').val(0.00);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    function calculateUrgentFee(element) {
        var urgent_fee = $(element).parents("tr").children('td').find(".hdn_item_urgent_fee").val();
        if (urgent_fee == 'null') {
            urgent_fee = 0;
        }

        var item_id = $(element).parents("tr").children('td').find(".item_id").val();
        // var item_price = $('#hdn_item_rate_' + item_id).val();
        console.log(urgent_fee, item_id);
        var total = 0;
        if ($(element).val() == 2) {
            total = parseFloat(urgent_fee);
            $('#urgent_fee_' + item_id).val(total);
        } else {
            $('#urgent_fee_' + item_id).val(0);
        }
        if ($("input[type=radio][name='item_dis_radio']:checked")) {
            billingEngine.posCalculateTotalItemWise(this);
        } else {
            billingEngine.posCalculateTotal(this);
        }

        // billingEngine.calculatePayment(this);
    }

    function calculateUrgentFeeKeyUp(element) {

        if ($("input[type=radio][name='item_dis_radio']:checked")) {
            billingEngine.posCalculateTotalItemWise(this);
        } else {
            billingEngine.posCalculateTotal(this);
        }
        // billingEngine.calculatePayment(this);
    }

    function itemDiscount(element) {
        if ($(element).is(':checked')) {

            // $("input[name='item_dis_radio']").removeAttr('disabled', 'disabled');
            $('#cmb_discount').attr('disabled', 'disabled');
            $('#discount_percent_hospital').attr('disabled', 'disabled');
            $('#discount_amount_hospital').attr('disabled', 'disabled');
            $('#dis_doctor_code').attr('disabled', 'disabled');
            $('#dis_requ_by').attr('disabled', 'disabled');
           

        } else {
            // $("input[name='item_dis_radio']").prop('checked', false);
            // $("input[name='item_dis_radio']").attr('disabled', 'disabled');
            $('#cmb_discount').removeAttr('disabled', 'disabled');
            $('#discount_percent_hospital').removeAttr('disabled', 'disabled');
            $('#discount_amount_hospital').removeAttr('disabled', 'disabled');
            $('#dis_doctor_code').removeAttr('disabled', 'disabled');
            $('#dis_requ_by').removeAttr('disabled', 'disabled');
            // $('.item_dis').attr('disabled', 'disabled');
            $('.item_dis').val('');
            $('.item_dis_amt').val('');
            if ($("#billing_table-body tr").length > 0) {           
                $("#billing_table-body tr").each(function() {
                    var item_id=  $(this).children('td').find(".item_id").val();
                    var item_sub_total= $(this).children('td').find(".item_total_amt").val();
                    $(this).children('td').find("#exp_item_total"+item_id).html(item_sub_total);
                });
            }
            
        }
    }
    $(document).on('click', 'input[name="item_dis_radio"]', function() {
        if ($("input[name='item_dis_radio']").is(':checked')) {
            $('.item_dis').removeAttr('disabled', 'disabled');
        }
    })

    function enterItemDis(element) {
        if ($("#billing_table-body tr").length > 0) {
            var t_amt = 0;
            var t_dis = 0;
            var amt = 0;
            var persent = 0;
           
            $("#billing_table-body tr").each(function() {
                var dis_amt = $(this).children('td').find(".item_dis").val() != "" ? parseFloat($(this)
                    .children('td').find(".item_dis").val()) : 0;                
                var item_dis_value = dis_amt; 
                var item_id = $(this).children('td').find('#hdn_item_id')
                    .val(); 
                var item_rate = $(this).children('td').find('#item_rate_' + item_id).val() != "" ? parseFloat($(
                        this).children('td').find('#item_rate_' + item_id).val()) :
                    0; 
                var item_qty = $(this).children('td').find('#hdn_item_qnty_' + item_id).val() != "" ?
                    parseFloat($(this).children('td').find('#hdn_item_qnty_' + item_id).val()) :
                    0; 
                // if ($("input[type=radio][name='item_dis_radio']:checked")) {
                    var dis_type = $("input[type=radio][name='item_dis_radio']:checked").attr('id');
                    if ($(element).attr('id') == 'item_dis') {

                        amt = parseFloat((((item_rate * item_qty) * item_dis_value) / 100).toFixed(2));
                        persent = item_dis_value;
                        $(this).children('td').find(".item_dis_amt").val(amt);                      
                        var item_sub_total= $(this).children('td').find(".item_total_amt").val();                       
                        $(this).children('td').find("#exp_item_total"+item_id).html(item_sub_total- amt);

                    } else if($(element).attr('id') == 'item_dis_amt') {

                        amt =   parseFloat($(this).children('td').find(".item_dis_amt").val()).toFixed(2);
                        persent = (amt / (item_rate * item_qty)) * 100;                        
                        $(this).children('td').find(".item_dis").val(persent);                      
                        var item_sub_total= $(this).children('td').find(".item_total_amt").val();
                        console.log(persent, item_sub_total+'_____discount amount percent');
                        $(this).children('td').find("#exp_item_total"+item_id).html(item_sub_total- amt);

                    }else{

                        amt = parseFloat((((item_rate * item_qty) * item_dis_value) / 100).toFixed(2));
                        persent = item_dis_value;
                        $(this).children('td').find(".item_dis_amt").val(amt);                      
                        var item_sub_total= $(this).children('td').find(".item_total_amt").val();                       
                        $(this).children('td').find("#exp_item_total"+item_id).html(item_sub_total- amt);

                    }
                // }
                t_amt += amt;
                t_dis += persent;
                let getExternalBatch=$(element).parents('td').parents('tr').find('#exp_show_' + item_id).children("input[name='txt_batch[]']").val();
                let externalBatchExpload=getExternalBatch !=null ? getExternalBatch.split('_'): null;
                let externalBatch=externalBatchExpload !=null ? externalBatchExpload[1]:0;

                $(element).parents('td').parents('tr').find('#exp_show_' + item_id).children(

                    "input[name='txt_batch[]']").val(item_id + '_' + externalBatch+ '_' + dis_amt);
                $('#total_discount_amount').val(t_amt.toFixed(2));

                billingEngine.posCalculateTotalItemWise(this);
            });
        }
    }
    $(document).on('click', '#item_dis_ind', function() {
        if ($(this).not(':checked')) {
            $('#item_dis').val('');
            enterItemDis($('#item_dis'));
        }
    })
    $(document).on('change', '.item_dis_radio', function() {
        $('#item_dis').val('');
        enterItemDis($('#item_dis'));
    })

    $(document).ready(function() {
        // $('#cmb_discount').attr('disabled', 'disabled');
        // $('#discount_percent_hospital').attr('disabled', 'disabled');
        // $('#discount_amount_hospital').attr('disabled', 'disabled');
        // $('#dis_doctor_code').attr('disabled', 'disabled');
        // $('#dis_requ_by').attr('disabled', 'disabled');
        function itemFocus(element) {
            var code = event.keyCode || event.which;
            if (code == 13) {
                $('.item_typehead').focus();
                console.log(code + "code");
            }

        }
    })
    function patientTotalDue(patient_id, admission_no_pk) {

        console.log(admission_no_pk);
        $.ajax({
            url: "{{ route('billing.patient-total-due-calculcation') }}",
            type: 'POST',
            data: {
                patient_id: patient_id,
                admission_no_pk: admission_no_pk
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // $.blockUI();
                console.log('test');
                console.log(data);
                $("#patient_total_available_due_div").removeClass('d-none');
                $("#patient_total_available_due").html(data);
            },
            complete: function(data) {
                $.unblockUI();
            }
        });
    }

    function itemRateEdit(element) {
        var rate = $(element).val();
        var id = $(element).parents('td').parents('tr').find('#hdn_item_id').val();
        console.log(rate, id);
        $(element).parents('td').find('#item_rate_' + id).val(rate);
        $(element).parents('td').find('#item_rate_pre_' + id).val(rate);
        $(element).parents('td').find('#hdn_item_rate_' + id).val(id + '_' + rate);
        $(element).parents('td').find('#hdn_item_rate_' + id).attr('item_rate', rate);
        $(element).parents('td').find('#hdn_item_rate_pre_' + id).attr('item_rate_pre', rate);
        $(element).parents('td').find('#hdn_item_rate_pre_' + id).val(rate);
        $(element).parents('td').parents('tr').find('#hdn_item_qnty_' + id).val(0);

        calculateItemTotal($(element).parents('td').parents('tr').find('#hdn_item_qnty_' + id));
        billingEngine.posCalculateTotal($(element).parents('td').parents('tr').find('#hdn_item_qnty_' + id));
        enterItemDis($(element).parents('td').parents('tr').find('#hdn_item_qnty_' + id));
        itemFocus($(element).parents('td').parents('tr').find('#hdn_item_qnty_' + id))

    }

  
</script>
