<style>
    .custom-select {
        height: 100% !important;
        line-height: 1 !important;
    }

    .myDiv {
        display: none;
    }

    .keep_me {
        margin-right: 5px;
    }

    .list-group-item {
        background: none;
        border-top: 1px solid #ffffff !important;
        border-bottom: 1px solid #e3e3e3;
    }

    .list-group-item {
        padding: .3rem;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form method="POST" action="{{ route('ambulance.store-ambulance-billing') }}" id="ambulance_billing_id">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row bg-white align-items-center justify-content-between border-bottom sticky-top shadow-sm">
                    <div class="col-md-8">
                        <h5 class="mt-2 mb-0">Ambulance</h5>
                        <small>Ambulance / Ambulance Billing</small>
                    </div>
                    <div class="col-md-4 text-right">
                        <a target="_blank" class="badge badge-primary cursor-pointer" href="#">Due Collection</a>
                        <a target="_blank" class="badge badge-primary cursor-pointer" href="#"> Billing
                            Cancellation</a>
                    </div>
                </div>
                <input type="hidden" name="email" id="email" />
                <input type="hidden" name="gender_text" id="gender_text" />

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-3">
                                <div class="form-row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="trip_patient_type"
                                                id="WalkIn" value="WalkIn" checked>
                                            <label class="custom-control-label" for="WalkIn">Walk-In</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="trip_patient_type"
                                                id="Registered" value="Registered">
                                            <label class="custom-control-label" for="Registered">Registered</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="trip_patient_type"
                                                id="Admitted" value="option3">
                                            <label class="custom-control-label" for="Admitted">Admitted</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="reg_num" class="col-form-label">Patient
                                                Name/Code/Mobile</label>
                                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                                placeholder="Search Here" />
                                            <input type="hidden" class="form-control" id="hdn_patient_id"
                                                name="hdn_patient_id" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="admission_num" class="col-form-label">Admission Number</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="admission_num" name="admission_num" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="patient_name" class="col-form-label">Name</label>

                                            <input type="text" class="form-control form-control-sm" id="patient_name"
                                                name="patient_name" placeholder="" value="" required autocomplete="off"/>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="address" class="col-form-label">Address</label>

                                            <input type="text" class="form-control form-control-sm" id="address"
                                                name="address" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <label for="adress" class="col-form-label">Age</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend w-100">
                                                <input type="number" class="form-control form-control-sm pat_info"
                                                    id="pat_age_y" name="pat_age_y" value="" placeholder="YY"
                                                    style="width: 35%;" required>
                                                <input type="number" class="form-control form-control-sm pat_info"
                                                    id="pat_age_m" name="pat_age_m" value="" placeholder="MM"
                                                    style="width: 33%;" max="12">
                                                <input type="number" class="form-control form-control-sm pat_info"
                                                    id="pat_age_d" name="pat_age_d" value="" placeholder="DD"
                                                    style="width: 32%;" max="31">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="pat_dob" class="col-form-label">DOB</label>
                                            <input type="text"
                                                class="form-control form-control-sm date_picker pat_info"
                                                id="patient_dob" name="pat_dob" value="" autocomplete="off"
                                                placeholder="mm/dd/yyyy" disabled>
                                                <input type="hidden" id="patient_dob_hidden" name="patient_dob_hidden">
                                            {{-- <div id="label_dob"></div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gender" class="col-form-label">Gender</label>
                                            <select class="form-control form-control-sm" id="gender"
                                                name="gender">
                                                <option value="">Select Gender</option>
                                                @if (isset($gender))
                                                    @foreach ($gender as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="phone_mobile" class="col-form-label">Phone</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="phone_mobile" name="phone_mobile" placeholder=""
                                                value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-3">

                                <div class="billing_table mt-2">
                                    <div class="form-group col-md-12 p-0">
                                        <div class="form-row">
                                            <label class="col-1" for="item_code" style="margin-top: 3px;">Service
                                                Item</label>

                                            <div class="col-3">
                                                <input type="text" class="form-control item_typehead" id="item_code"
                                                    name="item_code" placeholder="Item Code" />
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control item_typehead" id="item_name"
                                                    name="item_name" placeholder="Item Name" />
                                            </div>

                                            {{-- <label class="col-2 text-right" for="item_code"
                                                style="margin-top: 3px;">Service
                                                Dept.</label>

                                            <div class="col-2">
                                                <select name="" class="form-control select2" id="service_unit">
                                                    <option value="">Select</option>
                                                    @if (!empty($service_unit))
                                                        @foreach ($service_unit as $service)
                                                            <option value="{{ $service->serviceunit_no_pk }}">
                                                                {{ $service->serviceunit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <input type="hidden" id="hdn_su_no_fk" value=""> --}}


                                        </div>
                                    </div>

                                    <table id="billing_table" class="table table-hover fixed_header mt-2">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="min-width-30 text-left" scope="col"></th>
                                                <th class="min-width-80 text-left" scope="col">Provider</th>
                                                <th class="min-width-80 text-left" scope="col">Department</th>
                                                <th class="min-width-100 text-left" scope="col">Item Name</th>
                                                <th class="min-width-100 text-left" scope="col">Item Code</th>
                                                <th class="min-width-60 text-right" scope="col">Rate</th>
                                                <th class="min-width-30 text-center" scope="col"></th>
                                            </tr>
                                        </thead>

                                        <tbody id="billing_table-body">
                                        </tbody>
                                        <tfoot id="tfoot_auto">

                                        </tfoot>
                                    </table>
                                </div>

                                <div class="form-row">
                                    {{-- <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="amb_ser" class="col-form-label">Ambulence Service</label>

                                            <input type="text" class="form-control form-control-sm item_typehead"
                                                id="amb_ser_item" name="amb_ser_item" placeholder=""
                                                value="" />
                                            <input type="hidden" id="hdn_item_id" name="hdn_item_id" value="">
                                        </div>
                                    </div> --}}

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="driver_name" class="col-form-label">Driver Name</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="driver_name" name="driver_name" placeholder="" value="" />
                                            <input type="hidden" name="hdn_driver_id" id="hdn_driver_id"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="start_from_location" class="col-form-label">From</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="start_from_location" name="start_from_location" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="ended_to_location" class="col-form-label">To</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="ended_to_location" name="ended_to_location" placeholder=""
                                                value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12 mt-4">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="rateInd"
                                                id="Fixed" value="Fixed" checked>
                                            <label class="custom-control-label" for="Fixed">Fixed</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline ml-5">
                                            <input class="custom-control-input" type="radio" name="rateInd"
                                                id="Distance" value="Distance">
                                            <label class="custom-control-label" for="Distance">Distance</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="distance_km" class="col-form-label">KM</label>

                                            <input type="text" class="form-control form-control-sm"
                                                id="distance_km" name="distance_km" placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="amb_fee" class="col-form-label">Ambulance Fee</label>

                                            <input type="text" class="form-control form-control-sm" id="amb_fee"
                                                name="amb_fee" placeholder="" value=""
                                                onkeyup="handleAmbulanceFee()" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="remarks" class="col-form-label">Remarks</label>
                                            <textarea class="form-control form-control-sm" name="remarks" id="remarks" rows="3"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-3">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-row">
                                            <div class="col-md-12 col-12">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text"
                                                            for="inputGroupSelect01">Discount</label>
                                                    </div>
                                                    <select class="custom-select" id="inputGroupSelect01">
                                                        <option selected>General</option>
                                                        {{-- <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option> --}}
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">%</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="discount_percentage" name=""
                                                        placeholder="Enter Percentage"
                                                        onkeyup="handleDiscountCalPercentage()" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="discount_amount" name="" placeholder="Enter Amount"
                                                    onkeyup="handleDiscountCalAmt()" />
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="discount_by" class="col-sm-4 col-form-label">Discount
                                                        By</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="discount_by" name="discount_by" placeholder=""
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="req_by" class="col-sm-4 col-form-label">Request
                                                        By</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="req_by" name="req_by" placeholder=""
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="remarks2"
                                                        class="col-sm-4 col-form-label">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="remarks2" name="remarks2" placeholder=""
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="re_del_date" class="col-sm-4 col-form-label">Report
                                                        Delivery Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            id="re_del_date" name="re_del_date" placeholder=""
                                                            value="" placeholder="dd-mm-yyyy" />
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- tab -->

                                        <div class="form-row mt-2">
                                            <div class="col-md-12">
                                                <div class="btn-toolbar" role="toolbar"
                                                    aria-label="Toolbar with button groups">
                                                    <div class="btn-group bg-none w-100" data-toggle="buttons"
                                                        aria-label="First group">
                                                        @if (!empty($paymodes))
                                                            @foreach ($paymodes as $key => $paymode)
                                                                <label class="btn btn-outline-primary bg-none ">
                                                                    <input type="radio" name="pay_mode"
                                                                        id="option" class=""
                                                                        value="{{ $key }}"
                                                                        {{ $key == 'CS' ? 'checked' : ' ' }} />
                                                                    {{ $paymode }}
                                                                </label>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 border-top mt-2">
                                                <div class="" id="cash">
                                                    <div class="mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control cash_amount number_only "
                                                            name="cash_amount" id="cash_amount" value=""
                                                            placeholder="Paid Amount">
                                                    </div>
                                                    <div class="mb-2 mt-2">
                                                        <input type="text" class="form-control number_only"
                                                            id='cash_bd_amount' placeholder="Given Amount">
                                                    </div>

                                                    <div class="mb-2 mt-2">
                                                        <input type="text" id="change_amount"
                                                            class="form-control number_only"
                                                            placeholder="Change Amount">
                                                    </div>



                                                    <!-- <button type="button" name="cash_amount" id="cash_add"  onclick="addFuntion(this)">Add</button> -->

                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success pament_btn">
                                                        <button type="button" class="bg-success"
                                                            onclick="handleAdd()">Add </button>
                                                    </div>

                                                </div>
                                                <div id="payment_method_cheque" class="d-none">
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control check_amount number_only"
                                                            name="check_amount" id="check_amount" checked="checked"
                                                            value="" placeholder="Amount">
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
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control payment_method_1
                                                    "
                                                            name="holder_name" id="holder_name" checked="checked"
                                                            value="" placeholder="Holder Name">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1"
                                                            name="check_no" id="check_no" checked="checked"
                                                            value="" maxlength="16" placeholder="Cheque No">
                                                    </div>
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success pament_btn">
                                                        <button type="button" onclick="handleAdd()"
                                                            value=""class="bg-success">Add </button>
                                                    </div>

                                                </div>
                                                <div class="d-none" id="payment_method_card">
                                                    <select class="form-control" id="card_type" name="card_type">
                                                        <option value="">Card Type</option>
                                                        <option value="visa">Visa</option>
                                                        <option value="master">Master</option>
                                                        <option value="City Maxx">City Maxx</option>

                                                    </select>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text"
                                                            class="form-control card_amount number_only"
                                                            name="card_amount" id="card_amount" checked="checked"
                                                            value="" placeholder="Amount">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <select class="form-control select2 bank_name_card"
                                                            id="bank_name_card" name="bank_name_card">
                                                            <option value="">Bank name</option>
                                                            @if ($bank_name)
                                                                @foreach ($bank_name as $value)
                                                                    <option value="{{ $value }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
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
                                                        <input type="text" class="form-control payment_method_2 "
                                                            name="card_no" id="card_no" value=""
                                                            placeholder="Card No (minimum 4 digits)" minlength="4" maxlength="20">
                                                    </div>
                                                    <div class="card-field mb-2 mt-2">
                                                        <input type="text" class="form-control card_invoice_no "
                                                            name="card_invoice_no" id="card_invoice_no"
                                                            value="" placeholder=" Card Invoice No ">
                                                    </div>
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="card_amount" id="card_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success pament_btn">
                                                        <button type="button" value="" name="card_amount"
                                                            id="card_add" class="  bg-success">
                                                            Add </button>
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
                                                            name="mBank_amount" id="mBank_amount" checked="checked"
                                                            value="" placeholder="Amount">
                                                    </div>
                                                    <div class="cheque_field mb-2 mt-2">
                                                        <input type="text" class="form-control payment_method_1 "
                                                            name="bkash_txn_id" id="bkash_txn_id" checked="checked"
                                                            value="" placeholder="Transection ID">
                                                    </div>
                                                    <!-- <span class="btn btn-md btn-success float-right mt-2" name="bkash_amount" id="bkash_add" onclick="addFuntion(this)">Add</span> -->
                                                    <div style="border: 1px solid black"
                                                        class=" float-right mt-2 text-white bg-success pament_btn">
                                                        <button type="button" onclick="handleAdd()"
                                                            class="bg-success">Add </button>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-md-12 mt-2">
                                                @php
                                                    $response_url_page = route('ambulance.ambulance-billing');
                                                @endphp
                                                <button type="button" class="btn btn-md btn-success"
                                                    {{-- data-response_action="{{ $response_url }}" --}} data-response-url="{{ $response_url_page }}"
                                                    onclick="billingEngine.createAmbulanceBill(this)">Save</button>
                                            </div>
                                        </div>
                                        <!-- tab -->
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped table-bordered table-hover"
                                                    style="min-height: 214px;">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center">Mode</th>
                                                            <th class="text-right">Amount</th>
                                                            <th class="text-center">Type (Card/Mbank)</th>
                                                            <th class="text-center">Patient Detail</th>
                                                            <th class="text-center">Bank</th>
                                                            <th class="text-center">Transaction ID</th>
                                                            <th class="text-center">Card No</th>
                                                            <th class="text-center">Invoice No</th>
                                                            <th class="text-center">Holder Name</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul
                                                    class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                                    <li class="list-group-item">
                                                        <h5 class="float-left mr-2">Total Amount</h5>
                                                        <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                            id="item_total">0</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <span class="mr-2 float-left d-none">Service
                                                                    Charge</span>
                                                                <div class="float-left d-none">
                                                                    <input type="text" class="form-control mb-0"
                                                                        id="s_charge" name="s_charge" value=""
                                                                        placeholder="0.00" readonly="readonly"
                                                                        style="width: 70px; text-align: right;" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <span class="mr-2">Urgent Fee</span>
                                                                <div class="float-right">
                                                                    <input type="text"
                                                                        class="form-control float-right number_only"
                                                                        id="urgent_fee" name="urgent_fee"
                                                                        placeholder="0.00"
                                                                        style="width: 70px; text-align: right;"
                                                                        readonly="readonly" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <div class="form-row">
                                                            <div class="col-md-12 text-right">
                                                                <span class="mr-2">Service Charge</span>
                                                                <div class="float-right">
                                                                    <input type="text"
                                                                        class="form-control float-right mb-0 number_only"
                                                                        id="service_charge" name="service_charge"
                                                                        value="" placeholder="0.00"
                                                                        style="width: 70px; text-align: right;"
                                                                        readonly="readonly" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="form-row">
                                                            <div class="col-md-12 text-right">
                                                                <span class="mr-2">VAT/Tax</span>
                                                                <div class="float-right">
                                                                    <input type="text"
                                                                        class="form-control float-right mb-0 number_only"
                                                                        id="item_vat" name="item_vat" value=""
                                                                        placeholder="0.00"
                                                                        style="width: 70px; text-align: right;"
                                                                        readonly="readonly" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="form-row">
                                                            <div class="col-md-12 text-right">
                                                                <span class="mr-2">Discount</span>
                                                                <div class="float-right">
                                                                    <input type="text"
                                                                        class="form-control float-right number_only"
                                                                        id="total_discount_amount"
                                                                        name="total_discount_amount" value=""
                                                                        readonly="readonly" placeholder="0.00"
                                                                        style="width: 70px; text-align: right;" />

                                                                    <input type="text"
                                                                        class="form-control float-right number_only"
                                                                        id="discount_percent" name="discount_percent"
                                                                        placeholder="%" readonly="readonly"
                                                                        style="width: 50px; text-align: right;"
                                                                        value="%" />
                                                                    (%)
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class="list-group-item">
                                                        <div class="float-right">
                                                            <input type="text" id="total_payable"
                                                                name="total_payable" class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="0.00" readonly="readonly"
                                                                value="" />
                                                        </div>
                                                        <span class="float-right mr-2">Payable Amount</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="float-right">
                                                            <input type="text" id="pay_amount"
                                                                name="total_payment" class="form-control number_only"
                                                                style="width: 70px; text-align: right;"
                                                                placeholder="0.00" readonly="readonly"
                                                                value="0" />
                                                        </div>
                                                        <span class="float-right mr-2">Payment Amount</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input type="hidden" class="form-control mb-0"
                                                            id="total_due" name="total_due" />

                                                        <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                            id="total_due_data">0.00</span>
                                                        <h5 class="float-right mr-2">Due</h5>
                                                    </li>
                                                </ul>
                                                <input type="hidden" value="{{ $item_type_lists }}" id="item_type_list"
                                                name="item_type_list">
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    openDoctorAutocomplete('#driver_name', 'hdn_driver_id');
    openPatientAutocompleteForBilling('#patient_id', 'patient_name', patientInfo);
    openBillingItemAutocomplete("#amb_ser_item", "", item_type_void = "MED", "", "hdn_item_id");
    // openBillingItemAutocomplete(".item_typehead", , item_type ="GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",'', selectItem );
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

    function handleAdd() {
        let cash_amount = parseFloat($('#cash_amount').val());
        let total_payable = parseFloat($('#total_payable').val());

        if (isNaN(cash_amount) || isNaN(total_payable) || cash_amount > total_payable) {
            alert("Invalid Amount");
            return false;
        } else {
            $('#pay_amount').val(cash_amount.toFixed(2));
            $('#total_due_data').text((total_payable - cash_amount).toFixed(2));
        }
        // (!isNaN(amb_fee)) ? $('#total_due_data').text((amb_fee - cal_dis_amt).toFixed(2)): "";

    }

    function handleAmbulanceFee() {
        let amb_fee = $('#amb_fee').val();
        $('#item_total').text(amb_fee);
        $('#total_payable').val(amb_fee);
        $('#total_due_data').text(amb_fee);
    }

    function handleDiscountCalPercentage() {

        let discount_percentage = parseFloat($('#discount_percentage').val());
        let pay_amount = !isNaN(parseFloat($('#pay_amount').val())) ? parseFloat($('#pay_amount').val()) : 0;
        let amb_fee = parseFloat($('#amb_fee').val());
        let cal_dis_amt = ((amb_fee * discount_percentage) / 100).toFixed(2);
        (!isNaN(amb_fee)) ? $('#discount_amount').val(cal_dis_amt): "";
        (!isNaN(amb_fee)) ? $('#total_discount_amount').val(cal_dis_amt): "";
        (!isNaN(amb_fee)) ? $('#total_payable').val((amb_fee - cal_dis_amt).toFixed(2)): "";
        (!isNaN(amb_fee)) ? $('#total_due_data').text((amb_fee - cal_dis_amt - pay_amount).toFixed(2)): "";

    }

    function handleDiscountCalAmt() {
        setTimeout(function() {
            let discount_percentage = parseFloat($('#discount_percentage').val());
            let pay_amount = !isNaN(parseFloat($('#pay_amount').val())) ? parseFloat($('#pay_amount').val()) :
            0;
            let discount_amount = parseFloat($('#discount_amount').val());
            let amb_fee = parseFloat($('#amb_fee').val());
            let cal_dis_percentage = ((discount_amount / amb_fee) * 100).toFixed(2);
            (!isNaN(amb_fee) && amb_fee != 0) ? $('#discount_percentage').val(cal_dis_percentage): "";
            let cal_dis_amt = ((amb_fee * discount_percentage) / 100).toFixed(2);
            (!isNaN(amb_fee)) ? $('#total_discount_amount').val(cal_dis_amt): "";
            (!isNaN(amb_fee)) ? $('#total_payable').val((amb_fee - cal_dis_amt).toFixed(2)): "";
            (!isNaN(amb_fee)) ? $('#total_due_data').text((amb_fee - cal_dis_amt - pay_amount).toFixed(2)): "";
        }, 500);

    }

    function patientInfo(item, obj) {
        console.log(item);
        if (item.length != 0) {
            if (item.dob != "" && item.dob != "undefined" && item.dob != null) {
                let dateArray = item.dob.split('-');
                let dateFormat = dateArray[1] + '/' + dateArray[0] + '/' + dateArray[2];
                $("#patient_dob").val(dateFormat != null ? dateFormat : "");
                $("#patient_dob_hidden").val(dateFormat != null ? dateFormat : "");
            }

            if (item.gender_no_fk != "" && item.gender_no_fk != "undefined" && item.gender_no_fk != null) {
                let dropdown = document.getElementById("gender");
                console.log("dropdown", dropdown.options);
                let valueToSelect = item.gender_no_fk;
                for (let i = 0; i < dropdown.options.length; i++) {
                    const option = dropdown.options[i];
                    if (option.value === valueToSelect) {
                        dropdown.selectedIndex = i;
                        break;
                    }
                }
            }

            $("#patient_name").val(item.patient_name != null ? item.patient_name : "");
            $("#phone_mobile").val(item.phone_mobile != null ? item.phone_mobile : "");
            $("#address").val(item.present_addr != null ? item.present_addr : "");
            $("#pat_age_y").val(item.age_yy != null ? item.age_yy : "");
            $("#pat_age_m").val(item.age_mm != null ? item.age_mm : "");
            $("#pat_age_d").val(item.age_dd != null ? item.age_dd : "");
            $("#gender_text").val(item.gender != null ? item.gender : "");
            $("#email").val(item.email != null ? item.email : "");
        }
    }
    openBillingItemAutocomplete(".item_typehead", item_type = "AMBULANCE", item_type_void = "MED", selectItem);
    function selectItem(item, obj) {
        // console.log('ITEM_', item);
        // if ($('#hdn_patient_id').val() == "") {
        //     alert("Select Patient");
        //     return;
        // }
        $.ajax({
            data: {
                item_id: item.item_id,
                ccm_client_no_pk: item.ccm_client_no_pk,
                patient_type: item.patient_type_code
            },
            url: "{{ route('get-auto-items-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {

                // parents item
                var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                var vat_amt = (item.item_rate * vat_pers) / 100;
                var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                var total = parseFloat(item.item_rate) + vat_amt;
                var sl = $("#billing_table-body tr").length + 1;
                var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                var change_rate_color = item.manual_item_rate_ind == 1 ? "background-color: white" :
                    "background-color: #F8F8FF";
                var service_charge_pcr = item.service_charge_prc;
                var ipd_charge = item.ipd_charge;
                var provider_id_sl = $("#billing_table-body tr").length + 1;
                var table_row =
                        "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                        item.item_id +
                        "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                        item.item_name +
                        "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
                        .item_type +
                        "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                        item
                        .urgent_fee_amt +
                        "'></td><td><div class='form-group '><input  type='text' class='form-control provider' id='provider_" +
                        provider_id_sl +
                        "' name='provider[]' ><input  type='hidden' class='form-control hdn_provider' id='hdn_provider_' name='hdn_provider[]' value=''> </div></td><td style='width:12%'>" +
                        item.item_dept +
                        "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                        "' ></td><td class='text-left'>"+ item.item_name + "</td><td class='text-left'>" + item.item_code + "</td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                        change_rate_color +
                        "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id +
                        "' value='" + (item.item_rate - ipd_charge) +
                        "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                        item.manual_item_rate_ind +
                        "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                        item.item_id + "' value='" + item.item_rate +
                        "' readonly='readonly' ><td class='text-center qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                        item.disc_aplicable + "' id='hdn_item_total_qnty_" + item.item_id + "' value='" +
                        total +
                        "' disabled='disabled' > <input type='hidden' class='ipd_charge' id='ipd_charge' data-charge_prc='" +
                        service_charge_pcr + "'  name='ipd_charge[]' value='" +
                        ipd_charge +
                        "' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";

                $("#billing_table-body tr").each(function() {
                    var items_id = $(this).children('td').find('.item_id').val();
                    if (item.item_id == items_id) {
                        // alert("This item is already selected");
                        table_row = '';
                        return;
                    }

                })
                if ($("#billing_table-body tr").length >= 1) {
                    $("#billing_table-body").prepend(table_row);
                    // $("#mainTable tr:first").after(row);
                    openDoctorAutocompleteV1('#provider_' + provider_id_sl, '.hdn_provider');

                } else {
                    $("#billing_table-body").html(table_row);
                    openDoctorAutocompleteV1('#provider_' + provider_id_sl, '.hdn_provider');
                }

                //auto item

                var total_auto = 0;
                $.each(data, function(key, value) {
                    var vat_pers_auto = value.vat_percent != null ? parseFloat(value.vat_percent) :
                        0;
                    var vat_amt_auto = (parseFloat(value.sales_price) * vat_pers_auto) / 100;
                    var dis_amt = patient_itemType_dis_ind == 1 ? (parseFloat(value.sales_price) *
                        dis_pers) / 100 : 0;
                    total_auto = value.sales_price != null ? parseFloat(value.sales_price) +
                        vat_amt_auto : 0;
                    var ipd_charge = 0;
                    provider_id_sl = provider_id_sl + 1;
                    var table_row_auto =
                            "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                            value.auto_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            value.item_name +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            value.item_type +
                            "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            value.urgent_fee_amt +
                            "'></td><td><div class='form-group '><input  type='text' class='form-control provider' id='provider_" +
                            provider_id_sl +
                            "' name='provider[]' ><input  type='hidden' class='form-control hdn_provider' id='hdn_provider_' name='hdn_provider[]' value=''> </div></td><td style='width:12%'>" +
                            value
                            .serviceunit_name +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + value
                            .serviceunit_name + "' ></td><td class='text-left'>" + value.item_name +
                            "</td><td class='text-left'>" + value
                            .item_code + "</td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            value.auto_item_no_fk + "' value='" + (value.sales_price - ipd_charge) +
                            "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            value.manual_item_rate_ind +
                            "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' ><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";

                    $("#billing_table-body tr").each(function() {
                        var items_id_auto = $(this).children('td').find('.item_id').val();
                        if (value.auto_item_no_fk == items_id_auto) {
                            // alert("This item is already selected");
                            table_row_auto = '';
                            return;
                        }
                    })
                    if ($("#billing_table-body tr").length >= 1) {
                        $("#billing_table-body").append(table_row_auto);
                        openDoctorAutocompleteV1('#provider_' + provider_id_sl, '.hdn_provider');

                    } else {
                        $("#billing_table-body").html(table_row_auto);
                        openDoctorAutocompleteV1('#provider_' + provider_id_sl, '.hdn_provider');

                    }


                });
            },
            complete: function(data) {
                $.unblockUI();

                $('#item_code').typeahead('val', '');
                $('#item_name').typeahead('val', '');
                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });
                billingEngine.calculateTotal(this);
                // serviceChargeCalculation();
                // billingEngine.calculatePayment(thisElement);
                // calculateDisTotalHospital(this);

            }
        });


    }
    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
            $('#tbody').html('');
            $('#tfoot').html('');
            $('#pay_amount').val(0);
        }
        billingEngine.calculateTotal(this);
        // billingEngine.calculatePayment(this);
        return;
    }


    //date calculation start

    $(document).ready(function() {
        $(".date_picker").datepicker({}).on("change", function() {
            $.ajax({
                url: "{{ route('registration.calculateagebydate') }}",
                method: "post",
                data: {
                    patient_dob: $('#patient_dob').val()
                },
                success: function(res) {
                    //alert(res.new_year + "," +res.new_month +",")
                    $('#pat_age_m').val(res.new_month);
                    $('#pat_age_y').val(res.new_year)
                    $('#pat_age_d').val(res.new_day)
                }
            })
        });

        var timer;

        $('body').on('keyup', '#pat_age_y', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: _this.val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                })
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_m', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: _this.val(),
                        age_day: $('#pat_age_d').val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })


        $('body').on('keyup', '#pat_age_d', function() {
            clearTimeout(timer);
            var _this = $(this);
            timer = setTimeout(function(event) {
                $.ajax({
                    url: "{{ route('registration.calculateage') }}",
                    method: "post",
                    data: {
                        age_year: $('#pat_age_y').val(),
                        age_month: $('#pat_age_m').val(),
                        age_day: _this.val()
                    },
                    success: function(res) {
                        $('#patient_dob').val(res.patient_age);
                        $('#label_dob').text(res.patient_age);
                    }
                });
            }, 1000);
        })
    })

    function removeRequired() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();

        if ((pat_age_d != '' && pat_age_d > 0) || (pat_age_m != '' && pat_age_m > 0) || (pat_age_d != '' && pat_age_d >
                0)) {
            $('#pat_age_y').removeAttr('required')
        } else {
            $('#pat_age_y').attr('required', true)
        }
    }

    function convertTZ(date, tzString) {
        return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {
            timeZone: tzString
        }));
    }

    function get_dob_by_age() {
        var pat_age_y = $('#pat_age_y').val();
        var pat_age_m = $('#pat_age_m').val();
        var pat_age_d = $('#pat_age_d').val();



        var date = new Date();
        var today = convertTZ(date, "Asia/Dhaka");

        var pat_age_year = 0;
        var pat_age_month = pat_age_m;
        var pat_age_days = pat_age_d;

        if ((pat_age_m > 0) && pat_age_d == '' && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30)) / 365);
        } else if (pat_age_m == '' && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365)) / 365);
        } else if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d > 0 && pat_age_y == '') {
            pat_age_year = (((parseInt(pat_age_month) * 30) + parseInt(pat_age_days)) / 365)
        } else if (pat_age_m == '' && pat_age_d > 0 && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + parseInt(pat_age_d)) / 365);
        } else if (pat_age_m > 0 && pat_age_d == '' && pat_age_y > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30)) / 365);
        } else if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            pat_age_year = ((parseInt(pat_age_y * 365) + (parseInt(pat_age_m) * 30) + parseInt(pat_age_d)) / 365);
        } else {
            pat_age_year = pat_age_y;
        }

        console.log('patient age year 2 ', pat_age_year);

        var age = today.getFullYear() -
            pat_age_year; //today.getFullYear() - Math.round((parseInt(pat_age_y*365)+(parseInt(pat_age_m)*30)+parseInt(pat_age_d))/365);
        var m = (today.getMonth() + 1) - pat_age_m;
        var d = today.getDate() - pat_age_d;
        var month = 0;
        var date = 0;
        var pre_month = (today.getMonth());
        var add_days = 0;
        if (pre_month == 1) {
            add_days = 31;
        } else if (pre_month == 2) {
            add_days = 28;
        } else if (pre_month == 3) {
            add_days = 31;
        } else if (pre_month == 4) {
            add_days = 30;
        } else if (pre_month == 5) {
            add_days = 31;
        } else if (pre_month == 6) {
            add_days = 30;
        } else if (pre_month == 7) {
            add_days = 31;
        } else if (pre_month == 8) {
            add_days = 31;
        } else if (pre_month == 9) {
            add_days = 30;
        } else if (pre_month == 10) {
            add_days = 31;
        } else if (pre_month == 11) {
            add_days = 30;
        } else if (pre_month == 12) {
            add_days = 31;
        }
        if (today.getDate() < pat_age_d) {
            date = (today.getDate() + add_days) - pat_age_d;
        } else {
            var dates = today.getDate() - pat_age_d;
            if (dates == 0) {
                date = ((today.getDate() + add_days) - pat_age_d);
            } else {
                date = (today.getDate() - pat_age_d);
            }
        }

        if ((today.getMonth() + 1) < pat_age_m) {
            months = (today.getMonth() + 12 + 1) - pat_age_m;
            if (date == 0) {
                month = (today.getMonth() + 12 + 1) - (pat_age_m);
                if (month == 0) {
                    month += 1;
                }
            } else {
                month = (today.getMonth() + 12 + 1) - pat_age_m;
                if (month == 0) {
                    month += 1;
                }
            }
        } else {
            if (date == 0) {
                month = (today.getMonth() + 1) - (pat_age_m);
                if ((today.getMonth() + 1) > pat_age_m) {
                    month = (today.getMonth() + 12 + 1) - pat_age_m;
                }
                if (month == 0) {
                    month += 1;
                }
            } else {
                month = (today.getMonth() + 1) - pat_age_m;
                if ((today.getMonth() + 1) > pat_age_m) {
                    month = (today.getMonth() + 1) - pat_age_m;
                }
                if (month == 0) {
                    month = (today.getMonth() + 1 + 12) - pat_age_m;
                }
            }
        }
        if (m < 0 || (m === 0 && today.getDate() < pat_age_d)) {
            age--;
        }
        if (month != 0 && today.getDate() < pat_age_d) {
            month--;
        }

        var age_year = today.getFullYear() - pat_age_year;

        if (pat_age_y == '' && pat_age_m == '' && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear();
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y == '' && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if (pat_age_y > 0 && pat_age_m > 0 && pat_age_d > 0) {
            var decimal_year = age_year.toString().split(".");
            var decimal_year_fraction = decimal_year[1].substr(0, 1);



            if (decimal_year_fraction >= 4) {
                age_year = today.getFullYear() - pat_age_y;
            }

            //console.log('patient age year ', age_year);
        }

        if ((pat_age_y.length || pat_age_m.length || pat_age_d.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //$("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);
        }
        if ((pat_age_y.length && pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_y.length) > 0) {

            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
        }
        if ((pat_age_m.length) > 0) {

            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }
        if ((pat_age_d.length) > 0) {
            if (pat_age_d == 30 && (pre_month == 4 || pre_month == 6 || pre_month == 9 || pre_month == 11)) {
                date = 01;
            }
            $("#patient_dob").val(('0' + date).slice(-2) + "-" + ('0' + month).slice(-2) + "-" + Math.round(age_year));
            //            $("#patient_dob").val(('0' + d).slice(-2) + "-" + ('0' + m).slice(-2)+ "-" + age);


        }

        $("#patient_dob").datepicker("destroy");

    }

    function dob(event, element) {
        var code = event.keyCode || event.which;

        if (code != '9') {

            $('.date_picker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });

            var dateString = $(element).val();
            if (dateString.indexOf('.')) {
                var dob = dateString.split(".");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            }
            if (dateString.indexOf('/')) {
                var dob = dateString.split("/");
                dateString = dob[0] + "-" + dob[1] + "-" + dob[2];
            } else {
                dateString = $(element).val();
            }


            var dob = dateString.split("-");
            var date = new Date();
            var now = convertTZ(date, "Asia/Jakarta");
            var today = new Date(now.getYear(), now.getMonth(), now.getDate());
            var yearNow = now.getFullYear();
            var monthNow = 1 + now.getMonth();
            var dateNow = now.getDate();
            var yearDob = dob[2];
            var monthDob = dob[1];
            var dateDob = dob[0];
            var age = {};
            var ageString = "";
            var yearString = "";
            var monthString = "";
            var dayString = "";
            yearAge = yearNow - yearDob;

            if ((parseFloat(monthNow)) > monthDob) {
                var monthAge = (parseFloat(monthNow)) - monthDob;

            } else if ((parseFloat(monthNow)) == monthDob && yearNow == yearDob) {
                yearAge--;
                var monthAge = null; //(parseFloat(monthNow)) - monthDob;
            } else {
                yearAge--;
                var monthAge = (12 + parseFloat(monthNow)) - monthDob;

            }
            if (dateNow > dateDob) {
                var dateAge = dateNow - dateDob;
            } else {
                monthAge--;

                var pre_month = parseFloat(monthNow);
                var add_days = 0;
                if (pre_month == 1) {
                    add_days = 31;
                } else if (pre_month == 2) {
                    add_days = 28;
                } else if (pre_month == 3) {
                    add_days = 31;
                } else if (pre_month == 4) {
                    add_days = 30;
                } else if (pre_month == 5) {
                    add_days = 31;
                } else if (pre_month == 6) {
                    add_days = 30;
                } else if (pre_month == 7) {
                    add_days = 31;
                } else if (pre_month == 8) {
                    add_days = 31;
                } else if (pre_month == 9) {
                    add_days = 30;
                } else if (pre_month == 10) {
                    add_days = 31;
                } else if (pre_month == 11) {
                    add_days = 30;
                } else if (pre_month == 12) {
                    add_days = 31;
                }
                var dateAge = (parseFloat(add_days) + parseFloat(dateNow)) - dateDob;
            }
            age = {
                years: yearAge,
                months: monthAge,
                days: dateAge
            };


            var m = now.getMonth() - monthDob;
            if (m < 0 || (m === 0 && today.getDate() < dateDob)) {
                yearAge--;
            }


            if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0))
                ageString = age.years + "-" + age.months + "-" + age.days;
        }
        console.log('date picker age ', age)
        if ((age.years < 0) && (age.months >= 0) && (age.days >= 0)) {

            ageString = null + "-" + age.months + "-" + age.days;
        }

        if ((age.years == 0) && (age.months == 11) && (age.days == 31)) {

            ageString = 1 + "-" + null + "-" + null;
        }

        if ((age.months == 12)) {

            ageString = 1 + "-" + null + "-" + age.days;
        }
        var pieces = ageString.split("-");
        $("#pat_age_y").val(pieces[0]);
        $("#pat_age_m").val(pieces[1]);
        $("#pat_age_d").val(pieces[2]);
    }
    //date calculation end

</script>
