<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
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

    .table td, .table th {
        padding: 2px 6px;
    }

    .list-group .form-control {
        background-color: #fff !important;
    }

    .btn-outline-secondary:not(:disabled):not(.disabled).active {
        color: #fff !important;
        background-color: #60c57f !important;
        border-color: #60c57f !important;
    }

    .btn-outline-secondary.focus {
        box-shadow: inherit;
    }

    .btn-outline-secondary input,
    .btn-outline-primary input {
        outline: 0;
    }

    .btn-outline-secondary {
        color: #37394d;
        border-color: #37394d;
        outline: 0;
    }

    .btn-outline-secondary:hover {
        color: #fff;
        background-color: #37394d;
        border-color: #37394d;
        outline: 0;
    }

    .patient-img {
        width: 65px;
        margin-left: auto;
    }

    .privious-history .card-body {
        height: 107px;
        overflow-y: scroll;
        margin-right: -5px;
    }

    .list-group-item {
        padding: .1rem;
    }
</style>

<div class="container-fluid">
     <form action="{{ route('store_pos_cancelation') }}" id="pos_billing_cancelation" method="post" >@csrf
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center py-2">
        <div class="col-md-4">
            <h5 class="mb-0">POS Cancellation</h5>
            <small>Billing / POS Cancellation</small>
        </div>
        <div class="form-group col-md-4 text-right font-weight-bold font-size-12">
            <div class="form-row">
                <div class="col-md-4">
                    <label for="service_point">Service Point </label>
                </div>
                <div class="col-md-8">
                    <select class="form-group form-control keep_me" id="service_point" name="service_point" required>
                        <option value="">Select One</option>
                        @if(!empty($service_point))
                        @foreach($service_point as $value)
                        @if ($value->default_ind == 1) 
                        <option selected value="{{ $value->serviceunit_no_pk }}"> {{ $value->serviceunit_name }}</option>   
                        @else
                        <option value="{{ $value->serviceunit_no_pk }}"> {{ $value->serviceunit_name }}</option>
                        @endif  
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
   
        <div class="form-row justify-content-center">
            <div class="col-md-5">
              <div class="card shadow-sm mb-3">
                <div class="card-body d-flex align-items-center px-2 py-2 justify-content-between">
                    <div class="d-flex align-items-center">
                        <strong class="mr-2">Voucher / Mobile No</strong>
                        <div class="">
                            <input type="text" class="form-control mb-0" id="voucher_no" name="voucher_no" value="" placeholder="Voucher / Mobile No" style="width: 100%;">
                        </div>
                    </div>
                    <div class="">
                        <input type="hidden" name="admission_no" id="admission_no">
                        <button type="button" id="details" class="btn btn-md btn-success mx-1">Search</button>
                        <button type="reset" class="btn btn-md btn-danger mx-1"  onclick="billingEngine.resetBillForm()">Clear</button>
                    </div>
                </div>
                <input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
                <input type="hidden" id="hospital_code" name="hospital_code"
                        value="{{ Session::get('user.ses_hospital_code') }}">
            </div>
        </div>
    </div>
    <div id="patient_data_cancel">
        @include('admin.billing.pharmacy.cust_info_pos_cancel_histry_item_list')
    </div>
</form>

</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    // openInvoiceAutocomplete("#voucher_no");
    openPosInvoiceAutocomplete("#voucher_no");
    function reload(){
       
       location.reload();
   }
   $(document).on('click', '#details', function () {
    var voucher_no = $("#hdn_invoice_id").val();
    var admission_no = $("#admission_no").val();
    var hospital_code = $("#hospital_code").val();
    console.log(hospital_code);
    if(hospital_code != 'KPJ'){
        if (admission_no !='') {
            alert('The IPD patient invoice cannot be canceled from here. Please follow the IPD process.');
            return false;
        }
    }
    $.ajax({
        async: true,
        data: {voucher_no: voucher_no},
        url: "{{ route('billing.get-billing-pos-cancel-invoice-list') }}",
        type: "get",
        beforeSend: function () {
            blockUI();
        },
        success: function (data) {
            $("#patient_data_cancel").html(data);
            openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1');
        },
        error: function (xhr) {
            var msg = "Something went wrong.";

            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } 
            else if (xhr.responseText) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) msg = response.message;
                } catch (e) {
                    msg = xhr.responseText;
                }
            }

            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Error");
            $('.common-modal-notify-error .modal-body').html(msg);

            $.unblockUI();
        },
        complete: function () {
            $.unblockUI();
        }
    }).done(function () {
        $.unblockUI();
    });



});
   $(document).on('change', '#cmb_discount', function () {
    var type = $(this).find(":selected").val();
    if (type == "GENERAL") {
        $("#discount_percent_doctor").val(0);
        $("#total_discount_amount").val(0);
        $("#discount_percent").val(0);
        $(".percent_hospital").removeClass('d-none');
        $(".percent_doctor").addClass('d-none');
    }
    if (type == "DOCTOR") {
        $("#discount_percent_hospital").val(0);
        $("#total_discount_amount").val(0);
        $("#discount_percent").val(0);

        $(".percent_hospital").addClass('d-none');
        $(".percent_doctor").removeClass('d-none');
    }
    if (type == "BOTH") {
        $("#total_discount_amount").val(0);
        $("#discount_percent").val(0);
        $(".percent_hospital").removeClass('d-none');
        $(".percent_doctor").removeClass('d-none');
    }
});


</script>
