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
    <form method="post" action="{{ route('pharmacy-indent.store') }}" id="posBilling" onsubmit="">

        <div id="mypos">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm" id="cust_info">
                        <div class="card-header">
                            <h5>Bill Entry</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="row">
                                <div class="col-5">
                                    <div class="admission_id_div  pb-3">
                                        <input type="text" class="form-control " id="admission_id" name="admission_id" readonly placeholder="Search Patient By Admission Id" value="{{ isset( $admission_id) ?  $admission_id->admission_no_fk :''  }}">
                                        <input type="hidden" class="form-control" id="hdn_admission_id" name="hdn_admission_id" />
                                        <input type="hidden" class="form-control" id="hdn_prescription_id" name="hdn_prescription_id" value="{{ isset( $admission_id) ?  $admission_id->pres_no_fk :''  }}" />
                                        <input class="form-check-input patient_type keep_me" type="hidden"
                                            name="customer_type_radio" id="admitted_pat" value="4" checked>

                                        <input type="hidden" class="keep_me" name="page_type" value="2">
                                        <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="pb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-check-label" for="service_point">Service Point</label>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control keep_me " id="service_point" name="service_point" onchange="servicePoint(this)" required>
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
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="pb-3">
                                        <div class="row">                                         
                                            <div class="col-12">
                                                <select class="form-control keep_me " id="module" name="module"  required style="font-weight: bold">
                                                    @if (isset($module) && !empty($module))
                                                        @foreach ($module as $value)                                                          
                                                                <option selected value="{{ $value->module_code }}" @if($value->module_code=="PHR-I") selected @endif>{{ $value->module_name }}</option>                                                           
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>                                 
                                    </div>
                                </div>
                            </div>




                        </div>
                        <input type="hidden" name="hospital_code" id="hospital_code" value="{{ Session::get('user.ses_hospital_code') }}" class="keep_me">



                        

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
                                                placeholder="Search Item by Barcode No/Item Code/ Item Name"
                                                aria-label="item_typehead" aria-describedby="item_typehead">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-2" id="item_table_con">
                                    <div class="text-right">
                                        <input type="checkbox" class="keep_me" name="item_dis_ind" id="item_dis_ind"
                                            value="1" onclick="itemDiscount(this)" value="1"
                                            checked='checked'>
                                        <label for="item_dis_ind">Item Discount</label> <input type="radio"
                                            name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_perc"
                                            value="1" checked='checked'> (%) <input type="radio"
                                            name="item_dis_radio" class="item_dis_radio keep_me" id="item_dis_amt"
                                            disabled='disabled' value="2">
                                        (Amt)
                                    </div>
                                    <table id="item_table" class="table mb-0"
                                        style="width:100%; border-collapse: collapse;">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center" style="width:3%">#</th>
                                                <th class="text-left" style="width: 18%">Item Description</th>
                                                <th class="text-right" style="width:8%">W. Rate</th>
                                                <th class="text-right" style="width:10%">Rate</th>
                                                <th class="text-right" style="width:5%">Quantity</th>
                                                <th class="text-right" style="width:8%">Stock QTY</th>
                                                <th class="text-center" style="width:7%">UOM</th>
                                                <th class="text-center" style="width:7%">Status</th>
                                                <th class="text-right" style="width:9%">Urgent Fee</th>
                                                <th class="text-right" style="width:5%">Dis.</th>
                                                <th class="text-center" style="width:5%">Batch</th>
                                                <th class="text-right" style="width:10%">Sub Total</th>
                                                <th class="text-center "style="width:4%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billing_table-body">
                                            {{-- <tr>
                                                <td colspan="13" class="text-center text-danger">Your cart is empty</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>

                                </div>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mt-1" id="amount_info">
                        <div class="card-body">
                            <div class="float-end">
                                <div class="row">
                                    <div class="col-2">

                                    </div>
                                    <div class="col-md-4 mt-2 all_discount">
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
                                                            onkeyup="billingEngine.posCalculateTotal(this)"
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
                                                    <!-- onkeyup="billingEngine.posCalculateTotal(this)" onkeyup="billingEngine.posCalculateTotal(this)"  -->
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

                                    

                                    <div class="col-md-6 mt-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <ul class="list-group bg-light-blue list-group-flush bg-light-blue rounded mb-2 border">
                                                    <li class="list-group-item">
                                                        <h5 class="float-left mr-2">Total Amount</h5>
                                                        <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                            id="item_total"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                                    </li>
                                                    <li class="list-group-item">
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

                                                            <input type="hidden" id="pay_amount" name="total_payment"
                                                                class="form-control number_only"
                                                                style="width: 70px; text-align: right;" placeholder=""
                                                                readonly="readonly"
                                                                onkeyup="billingEngine.calculatePayment(this)"
                                                                value="0">
                                                       
                                                            {{-- <span class="float-right mr-2">Payment Amount</span> --}}
                                                    </li>
                                                    
        

                                                    <li class="list-group-item">
                                                        <input type="hidden" class="form-control mb-0" id="total_due"
                                                            name="total_due">

                                                        <span class="float-right btn btn-outline-danger bg-none btn-md"
                                                            id="total_due_data"> <?php echo isset($total_p) ? $total_p : 0.0; ?></span>
                                                        <h5 class="float-right mr-2">Due</h5>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        
                                        

                                        <div class="row border-top mt-1">
                                            <div class="col-12 mt-2">
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="text-right">
                                                            <input type="hidden" value="" id="given_amount" name="given_amount">
                                                            <input type="hidden" name="hdn_patient_id1" value="" readonly="readonly">  

                                                            <input type="hidden"  id="med_req_id" name="med_req_id" value="{{isset($med_req_id) ? $med_req_id :''}}">
                                                            <a href="{{ route('home') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                                                            
                                                            <span class="btn btn-md btn-info" onclick="billingEngine.resetPosForm()">Clear</span>

                                                            @php
                                                                $bill_id = '';
                                                                $page_type = 2;
                                                                $response_url = route('pos-invoice', $bill_id); 
                                                                $save_disabled=$admission_id =="" ? "disabled" :'disabled';
                                                            @endphp
                                                            
                                                            <button class="btn btn-md btn-success"
                                                                data-response_action="{{ $response_url }}"
                                                                data-redirect_indent_action = "{{route('v2.ipd.get-indent-pharmacy')}}"
                                                                onclick="billingEngine.createPosIndentBill(this)"  disabled="disabled" id="saveBtn" >Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

   
 
    openDoctorAutocomplete('#dis_doctor_code', 'hdn_dis_doctor_id');
    $(document).on('keyup', '#discount_percent_hospital', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calculateDisTotalHospital(this);
        }
    });

    $(document).on('keyup', '#discount_percent_doctor', function(e) {
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
            // alert("Invalid Discount");
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
                // if (discount_amt_doctor == 0) {
                // 	discount_amt_doctor = "";
                // } else {
                // 	discount_amt_doctor;
                // }
                // $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = $("#discount_percent").val() * 1;
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
                // $("#billing_table-body tr").html('');
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
                // $("#billing_table-body tr").html('');
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
        var due_amount = $('#total_due_data').html();


        var tfoot =
            "<tr><td  class='text-left'  >Total:</td> <td > <input type='text' name='total_payment_amt' id='total_payment_amt' class='text-right' style='border: 0;width: 80px;' readonly='readonly'></td><td colspan='6'></td></tr>"

        $("#tfoot").html(tfoot);
        var amt = 0;
        if ($(element).attr('id') == 'cash_add') {
            var amount = $(element).parents('div').find("#cash_amount").val();
            var method_mode = 'CASH';
            var bank_name = "";
            var b_type = "";
            var trans_id = "";
            var card_no = "";
            var acc_holder_name = "";
        }

        if ($(element).attr('id') == 'bkash_add') {
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

        if ($(element).attr('id') == 'check_add') {
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

        if ($(element).attr('id') == 'card_add') {
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
            "<tr><td ><input id='' class='method_mode' readonly='readonly' type='text' name='pay_method_mode[]' value='" +
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
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td> <td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger remove'  data-id='' onclick='removeTableRowPayment(this)' data-url='' title='Cancel '><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='" +
                generic_item_url +
                "' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span></td></tr>";

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
            $("#total_due_data").html(Math.abs(Math.floor(total_amount) - pay_amount).toFixed(2));
        }

        if (total_amount >= pay_amount) {
            // $("#cash_amount").val(pay_amount);
        } else {
            if (adj_amt < 0 && $('#hospital_code').val() == 'JKMH') {
                $("#change_amount").val(pay_amount - (Math.floor(total_amount) + 1));
            } else {
                $("#change_amount").val(pay_amount - Math.floor(total_amount));
            }

            // $("#cash_amount").val(total_amount);
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

            billingEngine.posCalculateTotal(this);
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
        // qty validation
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
        //validation end
        var total = 0;
        var item_id = $('#item_rate_' + item.item_id).val();
        var uom_name = item.uom_name != null ? item.uom_name : "";
        var urgent_fee_amt = item.urgent_fee_amt != null ? item.urgent_fee_amt : 0;
        var default_discount = item.default_discount != null ? item.default_discount : 0;
        var current_stock = item.current_stock ? item.current_stock : 0;
        if(current_stock == 0){
            alert('Stock Not Available!');
            return false;
        }
        var sl = $("#billing_table-body tr").length + 1;
        var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
        qty_edit = qty_edit.replace(':id', 1);
        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
        edit_action = edit_action.replace(':id', 1);
        var service_no=$('#service_point').val();
        var generic_item_url = "{{ route('get-generic-item-v2', [':generic_id',':service_id',':item_id']) }}"
            generic_item_url = generic_item_url.replace(':generic_id', item.generic_no_fk)
            generic_item_url = generic_item_url.replace(':service_id',service_no)
            generic_item_url = generic_item_url.replace(':item_id',item.item_id)

        var expiriable_ind = item.expireable;
        var expiry_date ='';// expiriable_ind == 1 ? "<span Class='btn btn-sm btn-warning open-modal ' data-id=''    title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :"";
        var exp_checkbox = item.dealer_sales_price != null && item.dealer_sales_price > 0 ?
            "<input type='checkbox' name='wholesale_" + item.item_id +
            "[]' id='wholesale' onclick='wholesalePrice(this)' value='" + item.dealer_sales_price + "'>&nbsp; " + item
            .dealer_sales_price + "" : '';

        // $("#billing_table-body #first").remove();
        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + ($("#billing_table-body tr").length *
                1 + 1) + "<input class='rx_no' type='hidden' name='rx_no[]' id='rx_no' value='' > <input class='prescription_no_fk' type='hidden' name='prescription_no_fk[]' id='prescription_no_fk' value='' > <input class='item_id item_id_"+item.item_id+"' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" + item
            .item_id + "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" + item.item_name +
            "'><input class='' type='hidden' name='delivery_date[]' value=''><input type='hidden' id='hdn_item_urgent_fee' class='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' value='" +
            urgent_fee_amt +
            "' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
            .item_type + "'> </td>  <td class='text-left pb-2'><strong>" + item.item_code + " - </strong> " + item
            .item_name + " " + item.supplier_name + "<br><span id='exp_show_" + item.item_id +
            "'><input type='hidden' name='txt_expire_date[]' value='" + item.item_id + '_' + 0 +
            "'><input type='hidden' name='txt_batch[]' value='" + item.item_id + '_' + 0 + '_' + default_discount +
            "'><input type='hidden' name='batch_qty[]' value=''><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item.item_id +"' value='"+item.item_rate+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+ item.item_id+"' value=''>  </span></td><td class='text-right qnty-width'>" +
            exp_checkbox +
            " </td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
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
            "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this); enterItemDis(this); itemFocus(this);showExpDateV1(this)'  id='hdn_item_qnty_" +
            item.item_id + "' name='hdn_item_qnty_" + item.item_id +
            "[]' value=''  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right current_qty' readonly='readonly' id='current_qty_" +
            item.item_id + "' value='" + current_stock + "'></td><td class=''>" + uom_name +
            "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" + item.uom_no_fk +
            "'></td><td class=''><select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select></td><td class='text-right'><input type='text' name='uregent_fee[]' id='urgent_fee_" +
            item.item_id +
            "' class='form-control mb-0 text-right urgent_fee number_only' value=''  onkeyup='calculateUrgentFeeKeyUp(this)'/></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
            default_discount +
            "' onkeyup='enterItemDis(this)' /></td><td>" + expiry_date +
            "</td ><td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
            item.item_id + "' value='" + total + "' ><span id='exp_item_total" + item.item_id + "'>" + total +
            "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='" +
                generic_item_url +
                "' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span></td></tr>";



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

        if ($(element).val() == '') {
            $(element).focus();
        } else {
            var code = event.keyCode || event.which;
            if (code == 13) {
                $('.item_typehead').focus();

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
                "'><input type='hidden' name='batch_qty[]' value=''><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item_id +"' value='"+wholesale_price+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+ item_id+"' value=''> ";
            $("#exp_show_" + item_id).html("");
            $("#exp_show_" + item_id).html(hdn_expiry);
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + item_id).val();
            var item_qnty = $(Element).parent('td').parent('tr').find("#hdn_item_qnty_" + item_id).val() * 1;


            if (stock_qty >= item_qnty) {

                // var current_qty = $('#current_qty_'+item_id).val();
                // var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
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
            // var hdn_item_rate_attr_pre=$(Element).parent('td').parent('tr').find("#hdn_item_rate_" + id).val();
            $('#item_rate_' + id).val(item_rate_pre);
            $('#hdn_item_rate_' + id).val(id + '_' + hdn_item_rate_pre);
            $('#hdn_item_rate_' + id).attr('item_rate', item_rate_pre);
            // alert(stock_qty);


            var item_id = id;
            var hdn_expiry = "<input type='hidden' name='txt_expire_date[]' value='" + item_id + '_' + 0 +
                "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + 0 + '_' + default_discount +
                "'><input type='hidden' name='batch_qty[]' value=''> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item_id +"' value='"+wholesale_price+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+ item_id+"' value=''>";
            $("#exp_show_" + item_id).html("");
            $("#exp_show_" + item_id).html(hdn_expiry);
            var stock_qty = $(Element).parent('td').parent('tr').find("#current_qty_" + item_id).val();
            var item_qnty = $(Element).parent('td').parent('tr').find("#hdn_item_qnty_" + item_id).val() * 1;


            if (stock_qty >= item_qnty) {

                // var current_qty = $('#current_qty_'+item_id).val();
                // var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
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


        // var item_id = $(thisElement).parents("tr").find(".item_id").val();
        var item_id = $(thisElement).parents("tr").find(".item_id")[0].value;
        var default_discount = $(thisElement).parent('td').parent('tr').find("#item_dis").val();
        var hdn_expiry = "<input type='hidden' name='txt_expire_date[]' value='" + item_id + '_' + 0 +
            "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + 0 + '_' + default_discount +
            "'><input type='hidden' name='batch_qty[]' value=''> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item_id +"' value='"+parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+item_id+"' value=''>";
        $("#exp_show_" + item_id).html("");
        $("#exp_show_" + item_id).html(hdn_expiry);

        var stock_qty = $("#current_qty_" + item_id).val();
        var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;


        if (stock_qty >= item_qnty) {

            // var current_qty = $('#current_qty_'+item_id).val();
            // var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
            var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
            $("#hdn_item_total_qnty_" + item_id).val((item_qnty * item_rate).toFixed(2));
            $("#exp_item_total" + item_id).html("");
            $("#exp_item_total" + item_id).html((item_qnty * item_rate).toFixed(2));

        } else {
            // alert("Stock not available");
            var hos_ind = $("#service_point").find(':selected').attr('data-posind');
            //alert(hos_ind);
            if (hos_ind == 1) {
                var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
                $("#hdn_item_total_qnty_" + item_id).val((item_qnty * item_rate).toFixed(2));
                $("#exp_item_total" + item_id).html("");
                $("#exp_item_total" + item_id).html((item_qnty * item_rate).toFixed(2));

            } else {
                // TODO:: Please know the scenario when it will come to this block. And uncomment the codebase
                // alert("======================");
                // var item_qnty = $("#hdn_item_qnty_" + item_id).val(0);
                // calculateItemTotal(thisElement)
                // return;
            }

        }

    }

    function salesQty(e) {
        var item_id = $(e).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();

        $("#hdn_item_qnty_" + item_id).val(sales_qty);
        // var edit_action = '{{ route('billing.pos-expire-edit', ':id') }}';
        // edit_action = edit_action.replace(':id', sales_qty + ':' + item_id + '^' + eventstring);

        return sales_qty;
    }

    function showExpDate(element) {
        var item_id = $(element).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();
        var default_discount = $(element).parent('td').parent('tr').find("#item_dis").val();
        // var sales_qty = salesQty(element);
        if (sales_qty > 0) {
            var qty = sales_qty;
            var su_unit_no = $('#service_point').val();
            // $('#batch_check_' + item_id).prop('checked', false);

            $.ajax({
                data: {
                    item_id: item_id,
                    qty: qty,
                    su_unit_no: su_unit_no
                },
                url: "{{ route('billing.pos-expire-show') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    var values = JSON.parse(data);
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

                        for (i = 0; i < exp_length; i++) {

                            eventstr = exp[i].split(',');
                            exp_data +=
                                "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" + exp[
                                    i] + "</span><input type='hidden' name='txt_expire_date[]' value='" +
                                item_id + '_' + eventstr[1] +
                                "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' +
                                eventstr[0] + '_' + default_discount +
                                "'><input type='hidden' name='batch_qty[]' value='" +
                                item_id + '_' + eventstr[2] + "'> <input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item_id +"' value='"+item.sales_price+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+ item_id+"' value=''>";
                            var total_expi_qty = parseFloat(eventstr[2]);
                            add_qty += total_expi_qty;

                        }
                        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
                        edit_action = edit_action.replace(':id', add_qty + ':' + item_id + '^' +
                            eventstring);

                        var edit ='';//"<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" +edit_action +"' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit' onclick='showExpDate(this)'><i class='fa fa-pencil-alt'></i></span>";
                        $('#exp_show_' + item_id).html(exp_data + edit);
                        $('#hdn_item_qnty_' + item_id).val(add_qty);
                        if ($("input[type=radio][name='item_dis_radio']:checked")) {
                            billingEngine.posCalculateTotalItemWise(this);
                        } else {
                            billingEngine.posCalculateTotal(this);
                        }

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
                $.unblockUI();
            });
        } else {
            alert("Enter Sales Quantity")
            event.stopImmediatePropagation();
        }
    }
    // function showExpDateV1(element) {
    //     if ($('#hospital_code').val()=="UNICO") {
    //         var item_id = $(element).parents("tr").find(".item_id").val();
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
    //                     // alert("Batch not found");
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
    //     }     
    // }
    function showExpDateV1(element) {
       
        if ($('#hospital_code').val()=="UNICO" || $('#hospital_code').val() =="DMHL") {
            var item_id = $(element).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();
        var default_discount = $(element).parent('td').parent('tr').find("#item_dis").val();
       

        if (sales_qty > 0) {
              var stockQty = $(element).parent('td').parent('tr').find(".current_qty").val();
                // if (stockQty <= 0) {
                //     alert('Empty Stock Qty.');
                //     $("#hdn_item_qnty_" + item_id).val('');
                //     return false;
                // }
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
            // $("#billing_table-body").html("");
            $('.admissionButton').html(0);
            $('.admissionButton').attr('title', "");
            $("#patient_id").val("");
            $("#hdn_admission_id").val(item.admission_no_pk);
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

            if (item.dis_ind == 1) {
                alert('Patient is already Discharged !')
                $("#hdn_admission_id").val('');
                $("#admission_id").val('');
                $('.input_dissabled').prop('disabled', true);
                $("#patient_info").html('');
            } else {
                $("#patient_info").html(patient_information);
                $('.input_dissabled').prop('disabled', false);
            }
            // patientTotalDue(item.patient_id, item.admission_no_pk);
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
        let patInfo=$("#patient_info").html().trim();
        let admission_id=$("#admission_id").val().trim();
       console.log(patInfo,admission_id)
        if (patInfo !='' && admission_id !='') {
            $('#saveBtn').prop('disabled', false);
        }

    }
    prescriptionPatientInfo();
    function prescriptionPatientInfo() {

            var med_req_id = $("#med_req_id").val();
            $("#billing_table-body").html("");
            $('.button5').html(0);
            $('.button5').attr('title', "");
            $.ajax({
                url: "{{ route('item-info-autocomplete-prescription-pos-indent') }}",
                type: 'POST',
                data: {med_req_id:med_req_id},
                dataType: 'json',
                success: function(data) {
                    jQuery.each(data, function(index, item) {
                        var total = 0;
                        var item_id = $('#item_rate_' + item.item_no_fk).val();
                        var uom_name = item.uom_name != null ? item.uom_name : "";
                        var current_stock = item.current_stock && item.current_stock > 0 ? item.current_stock : 0;
                       
                        var default_discount = item.disc_aplicable ==0 || item.disc_aplicable !='' ? item.default_discount_pct : 0;

                        default_discount = default_discount == 0 || current_stock <= 0 ? 0 : default_discount;
                        var sl = $("#billing_table-body tr").length + 1;

                        var qty_edit = "{{ route('billing.pos-qty-edit', ':id') }}";
                            qty_edit = qty_edit.replace(':id', 1);

                        var edit_action = "{{ route('billing.pos-expire-edit', ':id') }}";
                            edit_action = edit_action.replace(':id', 1);

                        var service_no=$('#service_point').val();   
                        var generic_item_url="{{route('get-generic-item-v2',[':generic_id',':service_id',':item_id'])}}"    
                            generic_item_url = generic_item_url.replace(':generic_id',item.generic_no_fk)
                            generic_item_url = generic_item_url.replace(':service_id',service_no)
                            generic_item_url = generic_item_url.replace(':item_id',item.item_no_fk)


                        var expiriable_ind = item.expireable;
                        var expiry_date ='';// expiriable_ind == 1 ? "<span Class='btn btn-sm btn-warning open-modal ' data-id='' title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" : "";
                        var exp_checkbox = item.dealer_sales_price != null && item.dealer_sales_price > 0 ? "<input type='checkbox' name='wholesale_" + item.item_no_fk +"[]' id='wholesale' onclick='wholesalePrice(this)' value='" + item.dealer_sales_price + "'>&nbsp; " + item.dealer_sales_price + "" : '';

                      
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" + (
                            $("#billing_table-body tr").length * 1 + 1) + "<input class='rx_no' type='hidden' name='rx_no[]' id='rx_no' value='" +item.rx_no +"' > <input class='prescription_no_fk' type='hidden' name='prescription_no_fk[]' id='prescription_no_fk' value='" +item.prescription_no_fk +"' > <input class='item_id item_id_"+item.item_no_fk+"' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +item.item_no_fk +"' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +item.item_name +"'><input class='' type='hidden' name='delivery_date[]' value=''><input type='hidden' id='hdn_item_urgent_fee' name='hdn_item_urgent_fee[]' readonly='readonly' /> <input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item.item_type + "'> </td>  <td class='text-left pb-2'><strong>" + item.item_code + " - </strong> " + item.item_name + " <br><span id='exp_show_" + item.item_no_fk + "'><input type='hidden' name='txt_expire_date[]' value='" + item.item_no_fk + '_' + 0 +"'><input type='hidden' name='txt_batch[]' value='" + item.item_no_fk +'_' + 0 + '_' + default_discount + "'><input type='hidden' name='batch_qty[]' value=''><input type='hidden' name='batch_wise_sales_price[]' id='batch_wise_sales_price_"+ item.item_no_fk +"' value='"+item.sales_price+"'><input type='hidden' name='internal_batch_no[]' class='internal_batch' id='internal_batch_no_"+ item.item_no_fk+"' value=''>  </span></td><td class='text-right qnty-width'>" + exp_checkbox +
                            " </td><td class='text-right qnty-width'><input type='text' class='form-control mb-0 text-right number_only'  name='item_ratee[]' id='item_ratee_" +
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
                            "' readonly='readonly' ></td><td class=' qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='calculateItemTotal(this);billingEngine.posCalculateTotal(this) ; enterItemDis(this);showExpDateV1(this)'  id='hdn_item_qnty_" +
                            item.item_no_fk + "' name='hdn_item_qnty_" + item.item_no_fk +
                            "[]' value='"+ item.titem_qty +"'  ></td><td class='text-right'><input type='text' class='form-control mb-0 text-right current_qty' readonly='readonly' id='current_qty_" +
                            item.item_no_fk + "' value='" + current_stock + "'></td><td class=''>" +
                            uom_name +
                            "<input type='hidden' name='uom_no_fk' id='uom_no_fk' value='" +
                            item.uom_no_fk +
                            "'></td><td class=''><select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select></td><td class='text-right'><input type='text' name='uregent_fee[]' id='urgent_fee_" +
                            item.item_id +
                            "' class='form-control mb-0 text-right urgent_fee number_only' value=''  onkeyup='calculateUrgentFeeKeyUp(this)'/></td><td class='text-right'><input type='text' name='item_dis[]' id='item_dis'  class='form-control mb-0 text-right item_dis number_only' value='" +
                            default_discount +
                            "' onkeyup='enterItemDis(this)' /></td><td>" + expiry_date +
                            "</td><td class='text-right qnty-width'><input type='hidden' class='form-control mb-0 text-right item_total_amt' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.item_no_fk + "' value='" + total + "' ><span id='exp_item_total" +
                            item
                            .item_no_fk + "'>" + total +
                            "</span></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><span class='btn btn-sm btn-primary ml-2 open-modal' data-action='" +generic_item_url+"' data-modal='common-modal-md' data-title='Alternative Medicine' title='Medicine'><i class='fa fa-store'></i></span></td></tr>";
                          
                            $("#billing_table-body").append(table_row);
                            showExpDateV1("#hdn_item_qnty_" + item.item_no_fk);
                            calculateItemTotal("#hdn_item_qnty_" + item.item_no_fk);
                            billingEngine.posCalculateTotal("#hdn_item_qnty_" + item.item_no_fk); 
                            enterItemDis("#hdn_item_qnty_" + item.item_no_fk); 
                         
                    });


                    var item_n = "";
                    var written_item = 0;
                    jQuery.each(data, function(index, item) {
                        var table_row ="<input class='item_id' type='hidden' name='hdn_item_id[]' id='hdn_item_id' value='" +item.item_no_fk + "' >";
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

                    // billingEngine.posCalculateTotal(this);
                    $('.item_typehead').typeahead('val', '');
                    $("#item_count").html($("#billing_table-body tr").length);
                    $('.date_picker').datepicker();
                    event.stopImmediatePropagation();
                }
            });
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
                callback(item, obj);
            }
        });
    }

    $(document).on('keypress', '#admission_id', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Prevent default form submission behavior
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
            }
        });
    }


   openPatientAutocompleteForBilling('#patient_id', 'patient_name', selectedPatient);
    
   $(document).ready(function() {
        openItemAutocompleteWithStockSubStoreWise(".item_typehead", "MED,LIQ,TAB,INV,CONSUM", "", "", selectItem,'',$('#service_point :selected').val());
   });
   
   function servicePoint(params) {
       store_id($(params).val());
       if ($('#med_req_id').val() !="") {
            prescriptionData($('#med_req_id').val(), prescriptionPatientInfo);
        }
   }

   function store_id(store_id){
       $(".item_typehead").each(function() {
               $(this).typeahead('destroy'); // Custom method to remove typeahead
               $(this).off(); // Remove all event handlers
               $(this).val(''); // Clear the input value
               $(this).parent().find('.tt-menu').remove(); // Remove the dropdown menu
           });
           openItemAutocompleteWithStockSubStoreWise(".item_typehead", "MED,LIQ,TAB,INV,CONSUM", "", "", selectItem,'',store_id);
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
            // var urgent_fee = 0;
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

                $("#discount_percent_hospital").val(discount_percent_hospital_dis ? discount_percent_hospital_dis.toFixed(2) : "");


                var discount_percent_doctor = ($("#discount_amount_doctor").val() != "") ? parseFloat($(
                    "#discount_amount_doctor").val()) : 0;
                var discount_amt_doctor = (discount_percent_doctor);
                var item_total_amount = $("#item_total").html();

                var discount_percent_doctor_dis = (discount_percent_doctor > 0) ? (discount_percent_doctor * 100 /
                    parseFloat(item_total_amount)) : "";

                $("#discount_percent_doctor").val(discount_percent_doctor_dis ? discount_percent_doctor_dis.toFixed(2) :
                    "");
                // $("#discount_amount_doctor").val(discount_amt_doctor.toFixed(2));
                // var discount_amt_doctor = ($(thisElement).val() != "") ? $(thisElement).val() : 0;

                var discount_percent = ($(thisElement).val() != "") ? $(thisElement).val() : 0;
                var discount_amt_total = (discount_percent);

                // $("#total_discount_amount").val(discount_amt_total);
                // var discount_amt_total = ($(thisElement).val() != "") ? $(thisElement).val() : 0;

                // if(discount_percent_hospital != 0 ||  discount_percent_doctor != 0)
                // 	$("#discount_percent").val(0);


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

                    discount_amt_total = (discount_percent);

                    // alert(discount_amt_total);
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_total - discount_amt_total;
                }

                var item_vat = $("#item_vat").val() * 1;

                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;

                // var adj_dis_amt = $('#dis_adj_amt').val() != "" ? parseFloat($('#dis_adj_amt').val()) : 0;
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
                // $("#pay_amount").val(total_payable.toFixed(2));




                // $("#cash_amount").val((Math.floor(total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(2));
                // $("#total_due_data").html(Math.abs((total_payable.toFixed(2) - adj_dis_amt) - pay_amount).toFixed(2));

            } else {
                // $("#billing_table-body tr").html('');
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

            $("input[name='item_dis_radio']").removeAttr('disabled', 'disabled');
            $('#cmb_discount').attr('disabled', 'disabled');
            $('#discount_percent_hospital').attr('disabled', 'disabled');
            $('#discount_amount_hospital').attr('disabled', 'disabled');
            $('#dis_doctor_code').attr('disabled', 'disabled');
            $('#dis_requ_by').attr('disabled', 'disabled');


        } else {
            $("input[name='item_dis_radio']").prop('checked', false);
            $("input[name='item_dis_radio']").attr('disabled', 'disabled');
            $('#cmb_discount').removeAttr('disabled', 'disabled');
            $('#discount_percent_hospital').removeAttr('disabled', 'disabled');
            $('#discount_amount_hospital').removeAttr('disabled', 'disabled');
            $('#dis_doctor_code').removeAttr('disabled', 'disabled');
            $('#dis_requ_by').removeAttr('disabled', 'disabled');
            $('.item_dis').attr('disabled', 'disabled');
            $('.item_dis').val('');
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
                // dis += dis_amt;

                var item_dis_value = dis_amt; //$(element).val() != '' ? parseFloat($(element).val()) : 0;
                var item_id = $(this).children('td').find('#hdn_item_id')
                    .val(); //$(element).parent().siblings().find('#hdn_item_id').val();
                var item_rate = $(this).children('td').find('#item_rate_' + item_id).val() != "" ? parseFloat($(
                        this).children('td').find('#item_rate_' + item_id).val()) :
                    0; //$(element).parent().siblings().find('#item_rate_' + item_id).val() != "" ? parseFloat($(element).parent().siblings().find('#item_rate_' + item_id).val()) : 0;
                var titem_qty = $(this).children('td').find('#hdn_item_qnty_' + item_id).val() != "" ?
                    parseFloat($(this).children('td').find('#hdn_item_qnty_' + item_id).val()) :
                    0; //$(element).parent().siblings().find('#hdn_item_qnty_' + item_id).val() != "" ?parseFloat($(element).parent().siblings().find('#hdn_item_qnty_' + item_id).val()) : 0;


                if ($("input[type=radio][name='item_dis_radio']:checked")) {
                    var dis_type = $("input[type=radio][name='item_dis_radio']:checked").attr('id');
                    if (dis_type == 'item_dis_perc') {
                        amt = ((item_rate * titem_qty) * item_dis_value) / 100;
                        persent = item_dis_value;
                    } else {
                        amt = item_dis_value;
                        persent = (item_dis_value / (item_rate * titem_qty)) * 100;
                    }
                }
                t_amt += amt;
                t_dis += persent;
                let getExternalBatch=$(element).parents('td').parents('tr').find('#exp_show_' + item_id).children("input[name='txt_batch[]']").val();
                let externalBatchExpload=getExternalBatch !=null ? getExternalBatch.split('_'): null;
                let externalBatch=externalBatchExpload !=null ? externalBatchExpload[1]:0;
                $(element).parents('td').parents('tr').find('#exp_show_' + item_id).children(
                    "input[name='txt_batch[]']").val(item_id + '_' + externalBatch + '_' + dis_amt);
                // alert(dis_data);
                // $('#discount_percent').val(t_dis.toFixed(2));
                $('#total_discount_amount').val(t_amt.toFixed(2));
                billingEngine.posCalculateTotalItemWise(this);
            });


        }
    }

    $(document).on('click', '#item_dis_ind', function() {
        // alert($('#item_dis').val());
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
        $('#cmb_discount').attr('disabled', 'disabled');
        $('#discount_percent_hospital').attr('disabled', 'disabled');
        $('#discount_amount_hospital').attr('disabled', 'disabled');
        $('#dis_doctor_code').attr('disabled', 'disabled');
        $('#dis_requ_by').attr('disabled', 'disabled');
        function itemFocus(element) {
            var code = event.keyCode || event.which;
            if (code == 13) {
                $('.item_typehead').focus();
            }

        }
    })

    function patientTotalDue(patient_id, admission_no_pk) {

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

    $(document).ready(function(){
        if($("#admission_id").val() != ''){
            var e = $.Event('keypress');
            e.which = 13;
            $('#admission_id').trigger(e);
        }
    })
   
</script>
