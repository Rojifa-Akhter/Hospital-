<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .list-group-item {
        padding: .1rem;
    }

    .list-group-item {
        background: none;
        border-top: 1px solid #ffffff !important;
        border-bottom: 1px solid #e3e3e3;
    }
</style>
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">
                    IPD  Bill Payment</h5>
                <small>Pharmacy / IPD  Bill Payment</small>
            </div>
            <!-- 			<div class="col-md-2 mt-3">
    <a class="btn bg-navy text-white btn-md" href="" rel="tab"><i class="far fa-calendar"></i> New Appointment</a>
   </div> -->
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="get" action="{{ route('pos-pdf-bill-list-ipd') }}" target="_blank">
                    @csrf
                    <input type="hidden" id="page-view-type" name="page_view_type">
                    <div class="form-group form-row ">
                        {{-- <div class="col-sm-2">
                            <label for="app_date">Invoice ID</label>
                            <input type="text" class="form-control " name="invoice_id" id="app_date"
                                autocomlete="off" placeholder="Invoice ID" />
                        </div> --}}
                        <div class="col-sm-2">
                            <label for="date_from">From Date</label>
                            <input type="text" class="form-control date_picker" name="date_from" id="date_from"
                                autocomlete="off" placeholder="From Date" value="" />
                        </div>
                        <div class="col-sm-2">
                            <label for="date_to">To Date</label>
                            <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                autocomlete="off" placeholder="To Date" value="" />
                        </div>
                        {{-- <div class="col-sm-2">
                            <label for="date_to">From Time</label>
                            <input class=" form-control form-control-sm m-0 timepicker " id="from_time" name="from_time"
                                placeholder="from time" value="" />
                        </div>
                        <div class="col-sm-2">
                            <label for="date_to">To Time</label>
                            <input class=" form-control form-control-sm m-0 timepicker " id="to_time" name="to_time"
                                placeholder="to time" value="" />
                        </div>

                        <div class="col-sm-2">
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-sm-2">
                            <label for="patient_id">Phone No (Walking) </label>
                            <input type="text" class="form-control" id="walking_phone" name="walking_phone"
                                placeholder="walking customar mobile number"
                                title="Search By walking customar mobile number" />

                        </div> --}}

                        {{-- <div class="col-sm-2">
							<label for="prescription_id">Prescription</label>
							<input type="text" class="form-control" id="prescription_id" name="prescription_id" placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
						</div> --}}

                        <div class="col-sm-2">
                            <label for="admission_id">Admission</label>
                            <input type="text" class="form-control" id="admission_id" name="admission_id"
                                placeholder="Admission Code" title="Admission Code" />



                            <input type="hidden" class="form-control" id="hdn_admission_id"
                                name="admission_patient_id" />
                        </div>

                        <div class="col-sm-6 mt-4">



                            {{-- <input type="checkbox" id="all_paid" name="all_paid" value="1" />
                            <label for="all_paid">All Bill </label>


                            <input type="checkbox" id="full_paid" name="full_paid" value="1" />
                            <label for="full_paid">Full Paid </label>

                            <input type="checkbox" id="due_bill" name="due_bill" value="1" />
                            <label for="due_bill">Due Bill</label> --}}
                            &nbsp;<button type="button" class="btn btn-success btn-sm"
                                id="btnSearchReport">Search</button>
                            {{-- &nbsp;<button type="submit" class="btn btn-success btn-sm" id="">PDF</button>
                            &nbsp;<button type="reset" class="btn btn-success btn-sm" id="">reset</button> --}}

                    </div>

                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body" id="pat_info">

            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Billing List</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive" id="pos_billing_list_include_ipd">

                            @include('admin.billing.pharmacy.pos_billing_list_include_ipd_payment')

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script>
    $("body").addClass("sidebar-collapse");
    openDoctorAutocomplete('#doctor_code_dis', 'hdn_doctor_id_dis');
    openInvoiceAutocomplete("#app_date");
    openAdmissionAutocomplete('#admission_id', 'patient_name', admissionPatientInfo);

    function admissionPatientInfo(item, obj) {
        var pat_id = 'ID : ' + item.patient_code + ' ,';
        var admission_id = 'Admission Id : <strong>' + item.admission_no_pk + '</strong> , ';
        var pat_name = 'Name : ' + item.patient_name + ' ,';
        var pat_age = 'Age : ' + item.age + ' ,';
        var pat_gender = 'Gender : ' + item.gender + ' ,';
        var pat_phone = 'Phone No : ' + item.phone_mobile + ' ,';
        var pat_bed = 'Bed : ' + item.bed_name;
        var all_info = pat_id + admission_id + pat_name + pat_age + pat_gender + pat_phone + pat_bed;
        //  $('#admission_id').val('');
        //  $('#admission_id').val(admission_id);
        $('#pat_info').html(all_info);
        // console.log(item);
    }
    //  , admissionPatientInfo
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
        $(".date_picker").attr("autocomplete", "off");


        $('body').on('focus', ".timepicker", function() {
            $(this).timepicker({
                // showInputs: false,
                // showMeridian: false,
                // setTime: null

            });
        });
    });

    openPatientAutocomplete('#patient_id');


    $(document).on("click", "#btnSearchReport", function(e) {

        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        if ($('#admission_id').val() =="") {
            alert('Enter Admission Id');
            return;
        }
        $.ajax({
            data: {
                invoice_id: $('input[name="invoice_id"]').val(),
                hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                walking_phone: $('input[name="walking_phone"]').val(),
                admission_id: $('input[name="admission_patient_id"]').val(),
                date_to: $('input[name="date_to"]').val(),
                date_from: $('input[name="date_from"]').val(),
                from_time: $('input[name="from_time"]').val(),
                to_time: $('input[name="to_time"]').val(),
                full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',
            },
            url: "{{ route('pos-search-bill-list-ipd-payment') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pos_billing_list_include_ipd").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function afterPaymentSearch(){
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        if ($('#admission_id').val() =="") {
            alert('Enter Admission Id');
            return;
        }
        $.ajax({
            data: {
                invoice_id: $('input[name="invoice_id"]').val(),
                hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                walking_phone: $('input[name="walking_phone"]').val(),
                admission_id: $('input[name="admission_patient_id"]').val(),
                date_to: $('input[name="date_to"]').val(),
                date_from: $('input[name="date_from"]').val(),
                from_time: $('input[name="from_time"]').val(),
                to_time: $('input[name="to_time"]').val(),
                full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',
            },
            url: "{{ route('pos-search-bill-list-ipd-payment') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pos_billing_list_include_ipd").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    $(document).on('click', '#all_checked', function() {
        if ($(this).is(':checked')) {

            // $('.select_all').attr('checked', true);

            var sales_amt = $('.sales_amt');
            var dis_amt = $('.discount_amt');
            var collection_amt = $('.collection_amt');
            //    console.log( sales_amt)
            var total_salse = 0;
            var total_dis = 0;
            var total_collection = 0;
            var advance_amt=$('#advance_payment').val() !="" ? parseFloat($('#advance_payment').val() ): 0;
            for (index = 0; index < sales_amt.length; index++) {
                // console.log($(sales_amt[index]).parents('td').parents('tr').find('.select_all').attr('disabled') );
                if ($(sales_amt[index]).parents('td').parents('tr').find('.select_all').attr('disabled') !="disabled") {
                   $(sales_amt[index]).parents('td').parents('tr').find('.select_all').attr('checked', true);
                total_salse += parseFloat(sales_amt[index].attributes.value.value);
                }
            }
            for (index2 = 0; index2 < dis_amt.length; index2++) {
                if ($(sales_amt[index2]).parents('td').parents('tr').find('.select_all').attr('disabled') !="disabled") {
                total_dis += parseFloat(Math.round(dis_amt[index2].attributes.value.value));
                }
            }
            for (index3 = 0; index3 < collection_amt.length; index3++) {
                if ($(sales_amt[index3]).parents('td').parents('tr').find('.select_all').attr('disabled') !="disabled") {
                total_collection += parseFloat(Math.round(collection_amt[index3].attributes.value.value));
                }
            }
            // total_collection += advance_amt ;
            console.log(total_salse ,total_dis , total_collection ,advance_amt)
            $('#net_payable').html(Math.round(total_salse));
            $('#paid_amount').val(Math.round(total_salse));
            $('#total_amt_dis').val(Math.round(total_salse));
            $('#discounted_amount').val(Math.round(total_dis));
            $('#initial_payment').val(Math.round(total_collection));
            $('#due_payment').val(Math.round((total_salse - total_dis) - (total_collection ))); //+ advance_amt
            $('#total_due_con').html(Math.round((total_salse - total_dis) - (total_collection ))); //+ advance_amt
            $('#total_due').val(Math.round((total_salse - total_dis) - (total_collection ))); //+ advance_amt
            console.log(total_salse ,total_collection , advance_amt);
            
            // parents('td').parents('tr').

        } else {
            $('#net_payable').html(0);
            $('#paid_amount').val(0);
            $('#total_amt_dis').val(0);
            $('#discounted_amount').val(0);
            $('#initial_payment').val(0);
            $('#due_payment').val(0);
            $('#total_due_con').html(0);
            $('#total_due').val(0);
            //    $('#discount_percent').val(0);
            //    $('.number_only').val(0);
            //    $('input').val(0);

            var formID = $("#frmSearch").attr("id");
            var formMethod = $("#frmSearch").attr("method");

            $.ajax({
                data: {
                    invoice_id: $('input[name="invoice_id"]').val(),
                    hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                    walking_phone: $('input[name="walking_phone"]').val(),
                    admission_id: $('input[name="admission_patient_id"]').val(),
                    date_to: $('input[name="date_to"]').val(),
                    date_from: $('input[name="date_from"]').val(),
                    from_time: $('input[name="from_time"]').val(),
                    to_time: $('input[name="to_time"]').val(),
                    full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                    due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                    all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',
                },
                url: "{{ route('pos-search-bill-list-ipd-payment') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#pos_billing_list_include_ipd").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            $('.select_all').attr('checked', false);
        }
    })

    function checkSingle(element) {
        if ($(element).is(':checked')) {
            // $('.select_all').attr('checked',true);
            var sales_amt = $('.sales_amt');
            var dis_amt = $('.discount_amt');
            var collection_amt = $('.collection_amt');

            var total_salse = 0;
            var total_dis = 0;
            var total_collection = 0;
            for (index = 0; index < sales_amt.length; index++) {
                // console.log(sales_amt[index])
                if ($(sales_amt[index]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_salse += parseFloat(sales_amt[index].attributes.value.value);
                }
            }
            var i= 0;
            for (index2 = 0; index2 < dis_amt.length; index2++) {
                
                if ($(dis_amt[index2]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_dis += parseFloat(Math.round(dis_amt[index2].attributes.value.value));
                }
            }
            for (index3 = 0; index3 < collection_amt.length; index3++) {
                if ($(collection_amt[index3]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_collection += parseFloat(Math.round(collection_amt[index3].attributes.value.value));
                }
            }
            $('#net_payable').html(Math.round(total_salse));
            $('#paid_amount').val(Math.round(total_salse));
            $('#total_amt_dis').val(Math.round(total_salse));
            $('#discounted_amount').val(Math.round(total_dis));
            $('#initial_payment').val(Math.round(total_collection));
            $('#due_payment').val(Math.round((total_salse - total_dis) - total_collection));
            $('#total_due_con').html(Math.round((total_salse - total_dis) - total_collection));
            $('#total_due').val(Math.round((total_salse - total_dis) - total_collection));
            // console.log(total_salse, total_dis, total_collection)
            // parents('td').parents('tr').

        } else {
            var sales_amt = $('.sales_amt');
            var dis_amt = $('.discount_amt');
            var collection_amt = $('.collection_amt');

            var total_salse = 0;
            var total_dis = 0;
            var total_collection = 0;
            for (index = 0; index < sales_amt.length; index++) {
                console.log(sales_amt[index])
                if ($(sales_amt[index]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_salse += parseFloat(sales_amt[index].attributes.value.value);
                }
            }
           var i=0;
            for (index2 = 0; index2 < dis_amt.length; index2++) {
                console.log(dis_amt[index2])
                if ($(dis_amt[index2]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_dis += parseFloat(Math.round(dis_amt[index2].attributes.value.value));
                    console.log(total_dis +'_dis_amt12312222')
                }
            }
            for (index3 = 0; index3 < collection_amt.length; index3++) {
                if ($(collection_amt[index3]).parents('td').parents('tr').find('.select_all').is(':checked')) {
                    total_collection += parseFloat(Math.round(collection_amt[index3].attributes.value.value));
                }
            }
            $('#net_payable').html(Math.round(total_salse));
            $('#paid_amount').val(Math.round(total_salse));
            $('#total_amt_dis').val(Math.round(total_salse));
            $('#discounted_amount').val(Math.round(total_dis));
            $('#initial_payment').val(Math.round(total_collection));
            $('#due_payment').val(Math.round((total_salse - total_dis) - total_collection));
            $('#total_due_con').html(Math.round((total_salse - total_dis) - total_collection));
            $('#total_due').val(Math.round((total_salse - total_dis) - total_collection));
        }
    }

    // payment and discount policy start


    $(document).on('keyup', '#discount_percent', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calCulateDiscountHospital(this.value);
        }
    });

    $(document).on('keyup', '#discount_percent_doctors', function(e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode != 9) {
            e.preventDefault();

            calCulateDiscountDoctor(this.value);
        }
    });

    function resetDueBillForm() {
        $("#due_collection").find("input, textarea").not('.keep_me').val("");
        $("#due_collection").find("select").not('.keep_me').val("0");
        $("#net_payable").html("00.00");
        $("#total_due_con").html("00.00");
        $("#total_due_data").html("00.00");
        $("#item_total").html("00.00");
        $("#total_due_con").html("00.00");
        $(" #tfoot, #tbody, #patient_info, #doctor_info, .item_list ").html('');
    }

    function removeTableRowPayment(thisElement) {

        if (confirm("Are you sure?")) {
            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var total_payment_amt = $('#total_payment_amt').val() - amount;
            var pay_amounts = $('#pay_amount').val() - amount;
            $('#total_payment_amt').val(total_payment_amt);
            $('#pay_amount').val(pay_amounts.toFixed(2));
            var total_amount = $("#total_payable").val() * 1;
            var pay_amount = pay_amounts * 1;


            if (pay_amount == '') {
                pay_amount = 0;
            }
            var discount_amt = $("#discount_amt").val();
            var discount_amt_doc = $("#discount_amt").val();
            if (discount_amt == '' || discount_amt_doc == '') {
                discount_amt = 0;
                discount_amt_doc = 0;
            }
            var due_payment = $("#due_payment").val();
            var paid = $("#initial_payment").val();
            var total_paid = parseFloat(paid) + parseFloat(pay_amount);
            $("#total_paid_amount").val(total_paid.toFixed(2));
            var total_due = parseFloat(due_payment) - (parseFloat(discount_amt) + parseFloat(discount_amt) + parseFloat(
                pay_amount));

            $("#total_due_con").html(total_due.toFixed(2));

            $(thisElement).parents("tr").remove();
            calCulateDiscount(this);
            calCulatePayment(this);
        }
        if (total_due >= 0) {
            $("#final_due").html(" ");
            $("#final_due").html("Final Due");
        } else {
            $("#final_due").html(" ");
            $("#final_due").html("Refund");
        }

        if ($("#tbody tr").length < 1) {

            $("#tfoot").html("");
        }
        calCulateDiscount(this);
        calCulatePayment(this);
        return;

    }

    function addFuntion(element) {
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
                if ($('#card_type').val() == "") {
                    alert('Enter Card  Type');
                } else if ($('#bank_name_card').val() == "") {
                    alert('Enter  Bank  Name');
                } else if ($('#card_holder_name').val() == "") {
                    alert('Enter Holder  Name');
                } else if ($('#card_no').val() == "") {
                    alert('Enter Card  No');
                }


                if ($("#tbody tr").length < 1) {
                    $("#tfoot").html("");
                }
                return;
            }

        }

        var table_row = "<tr><td ><input class='' type='text' name='pay_method_mode[]' value='" + method_mode +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='total_amt' type='text' name='total_amt[]' value='" +
            amount +
            "' style='border: 0; width: 80px; text-align: right' readonly='readonly'></td><td><input class='' type='text' name='mBank_types[]' value='" +
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
        var due_amt = $('#due_payment').html() != "" ? $('#due_payment').html() : 0;
        var net_payable = $('#paid_amount').val();
        var discounted_amount = $('#discounted_amount').val() != "" ? $('#discounted_amount').val() : 0;
        var total_discount = $('#total_discount').val() ? $('#total_discount').val() : 0;
        var initial_payment = $('#initial_payment').val() ? $('#initial_payment').val() : 0;
        var total_payment = $('#total_paid_amount').val() ? $('#total_paid_amount').val() : 0;
        // var current_pay=$('#total_payment_amt').val() ? $('#total_payment_amt').val() : 0;
        var dis_diff = total_discount == 0 ? 0 : Math.abs(parseFloat(total_discount) - parseFloat(discounted_amount));
        var paid_diff = total_payment == 0 ? 0 : Math.abs(parseFloat(total_payment) - parseFloat(initial_payment));

        var pay_paid_due = parseFloat(net_payable) - (parseFloat(initial_payment) + parseFloat(paid_diff) + parseFloat(
            discounted_amount) + parseFloat(dis_diff));


        if ($("#tbody tr").length >= 1 && parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(pay_paid_due)) {


            $("#tbody").append(table_row);
            $('#cash').children().find(':input').val("");
            $('#payment_method_bkash').children().find(':input').val("");
            $('#payment_method_card').children().find(':input').val("");
            $('#payment_method_cheque').children().find(':input').val("");
            $('#cash_bd_amount').val("");
        } else {
            console.log(amount, pay_paid_due.toFixed(2) + '_' + 'due_amt');
            if (parseFloat(amount) > 0 && parseFloat(amount) <= parseFloat(pay_paid_due.toFixed(2))) {

                $("#tbody").html(table_row);
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find(':input').val("");
                $('#payment_method_card').children().find(':input').val("");
                $('#payment_method_cheque').children().find(':input').val("");
                $('#cash_bd_amount').val("");
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

                $('#total_payment_amt').val(amt);
                $('#pay_amount').val(amt.toFixed(2));
            }
        });

        // alert(amt);
        // 		var total_amount = $("#due_payment").val() * 1;
        // 		var pay_amount = amt * 1;
        // 		$("#total_due_data").html((total_amount - pay_amount).toFixed(2));
        // 		if (total_amount>= pay_amount) {
        // 			$("#cash_amount").val(pay_amount);
        // 		}else{
        // 			$("#change_amount").val(pay_amount-total_amount);
        // 			$("#cash_amount").val(total_amount);

        // 		}



        var pay_amount = $("#pay_amount").val()


        if (pay_amount == '') {
            pay_amount = 0;
        }
        var discount_amt = ($("#discount_amt").val() != "") ? $("#discount_amt").val() : 0;
        var discount_amt_doc = ($("#discount_amt_doctor").val() != "") ? $("#discount_amt_doctor").val() : 0;
        if (discount_amt == '') {
            discount_amt = 0;
        }
        var due_payment = $("#due_payment").val();
        var paid = $("#initial_payment").val();
        var total_paid = parseFloat(paid) + parseFloat(pay_amount);
        $("#total_paid_amount").val(total_paid.toFixed(2));
        var total_due = parseFloat(due_payment) - pay_amount - (parseFloat(discount_amt) + parseFloat(
            discount_amt_doc));


        $("#total_due_con").html(Math.abs(total_due.toFixed(2)));

        if (total_due >= 0) {
            $("#final_due").html("");
            $("#final_due").html("Final Due");
        } else {
            $("#final_due").html("");
            $("#final_due").html("Refund");
        }
    }




    $(document).on("click", "#option", function() {
        var paymentType = $(this).val();
        $('#cash').children().find(':input').val("");
        $('#payment_method_bkash').children().find(':input').val("");
        $('#payment_method_card').children().find(':input').val("");
        $('#payment_method_cheque').children().find(':input').val("");
        if (paymentType == "CARD") {
            $("#payment_method_card").removeClass("d-none");
            $("#payment_method_cheque").addClass("d-none");
            $("#payment_method_bkash").addClass("d-none");
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
        } else {
            $("#cash").removeClass("d-none");
            $("#payment_method_card").addClass("d-none");
            $("#payment_method_cheque").addClass("d-none");
            $("#payment_method_bkash").addClass("d-none");


        }
    });

    function cancel_box(element) {
        var invoice = $(element).attr("data-invoice-id");
        var item_qty = $(element).attr("data-item-qty");
        if ($(element).is(':checked')) {
            $("#cancel_checkbox_" + invoice).removeAttr("disabled");
            $("#cancel_checkbox_" + invoice).val(item_qty);

        } else {
            $("#cancel_checkbox_" + invoice).val("");
            $("#cancel_checkbox_" + invoice).attr("disabled", "");
        }
    }


    function calCulateDiscountHospital(value) {
        var discount_percent = $("#discount_percent").val();
        var discount_percent_doctor = $("#discount_percent_doctors").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val() ? $("#due_payment").val() : 0;
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var discount_percent_doc = $("#discount_amt_doctor").val();
        var total_due_con = $("#total_due_con").val() ? $("#total_due_con").val() : 0;

        discount_percent = (discount_percent != "") ? ((parseFloat(due_payment_cal) * parseFloat(discount_percent)) /
            100).toFixed(2) : "";
        discount_percent = Math.round(discount_percent, 2);
        $("#discount_amt").val(discount_percent);

        // discount_percent_doc= (discount_percent_doctor != "") ? ((parseFloat(due_payment_cal)*parseFloat(discount_percent_doctor))/100).toFixed(2) : "";
        // $("#discount_amt_doctor").val(discount_percent_doc);

        var total_dis = 0;
        var h_perc = discount_percent != "" ? parseFloat(discount_percent) : 0;
        var doc_perc = discount_percent_doc != "" ? parseFloat(discount_percent_doc) : 0;
        if (h_perc + doc_perc != 0) {
            total_dis = h_perc + doc_perc;
        }
        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        console.log(discounted_amount, total_dis, total_discount, h_perc)
        if (discount_percent == "" && discount_percent_doctor == "") {
            $("#total_discount").val("");
        } else {

            $("#total_discount").val(parseFloat(total_discount).toFixed(2));
        }
        if (cash_refund > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }


        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao 2', total_discount, due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            calCulateDiscountHospital(value);
        } else {

            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
            if (due_payment >= 0) {
                $("#final_due").html("");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html("");
                $("#final_due").html("Refund");
            }
        }
        event.stopImmediatePropagation();
    }


    function calCulateDiscountDoctor(value) {
        var discount_percent = $("#discount_amt").val();
        var discount_percent_doctor = $("#discount_percent_doctors").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val() ? $("#due_payment").val() : 0;
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var discount_percent_doc = $("#discount_percent_doctors").val();

        // discount_percent= (discount_percent != "") ? ((parseFloat(due_payment_cal)*parseFloat(discount_percent))/100).toFixed(2) : "";
        // $("#discount_amt").val(discount_percent);

        discount_percent_doc = (discount_percent_doctor != "") ? ((parseFloat(due_payment_cal) * parseFloat(
            discount_percent_doctor)) / 100).toFixed(2) : "";
        $("#discount_amt_doctor").val(discount_percent_doc);
        var total_dis = 0;
        var h_perc = discount_percent != "" ? parseFloat(discount_percent) : 0;
        var doc_perc = discount_percent_doc != "" ? parseFloat(discount_percent_doc) : 0;
        if (h_perc + doc_perc != 0) {
            total_dis = h_perc + doc_perc;
        }
        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        if (discount_percent == "" && discount_percent_doctor == "") {
            $("#total_discount").val("");
        } else {

            $("#total_discount").val(parseFloat(total_discount).toFixed(2));
        }
        if (cash_refund > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }
        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao 3', total_discount, due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_percent_doctors").val("");
            alert("Discount invalid");
            calCulateDiscountDoctor(value);
        } else {
            console.log(due_payment);
            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));

            if (due_payment >= 0) {
                $("#final_due").html("");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html("");
                $("#final_due").html("Refund");
            }
        }
        event.stopImmediatePropagation();
    }

    function calCulatePayment(value) {




        var discount_percent = $("#discount_amt").val();
        var discount_percent_doctor = $("#discount_amt_doctor").val();
        var discount_amt = $("#discount_amt").val();
        var due_payment_cal = $("#total_amt_dis").val();
        var due_payment = $("#due_payment").val();
        var cash_refund = ($("#cash_refund").val() != "") ? $("#cash_refund").val() : 0;
        var discounted_amount = $("#discounted_amount").val();
        var initial_payment = $("#initial_payment").val();
        var pay_amt = ($("#pay_amount").val() != "") ? $("#pay_amount").val() : 0;
        var item_total_amount = $("#net_payable").html();


        discount_percent = (discount_percent != "") ? discount_percent : 0;
        var dis_amt_hos = (discount_percent > 0) ? (discount_percent * 100 / parseFloat(item_total_amount)) : "";

        $("#discount_percent").val(dis_amt_hos ? dis_amt_hos.toFixed(2) : 0);

        var discount_percent_doc = (discount_percent_doctor != "") ? discount_percent_doctor : 0;
        var dis_amt_hos = (discount_percent_doc > 0) ? (discount_percent_doc * 100 / parseFloat(item_total_amount)) :
            "";
        $("#discount_percent_doctors").val(dis_amt_hos ? dis_amt_hos.toFixed(2) : 0);
        // alert(discount_percent_doc);
        // $("#discount_amt_doctor").val(discount_percent_doc.toFixed(2));
        var total_dis = 0;
        if (parseFloat(discount_percent) + parseFloat(discount_percent_doc) != 0) {
            total_dis = parseFloat(discount_percent) + parseFloat(discount_percent_doc);
        }


        var total_discount = parseFloat(discounted_amount) + parseFloat(total_dis);
        $("#total_discount").val(total_discount.toFixed(2));
        if (parseFloat(cash_refund) > 0) {
            due_payment = (parseFloat(due_payment)) - (total_dis + parseFloat(pay_amt) + parseFloat(cash_refund));
        } else {
            due_payment = (parseFloat(due_payment) + parseFloat(cash_refund)) - (total_dis + parseFloat(pay_amt));
        }


        if (due_payment_cal < total_discount) {
            console.log('shuvo mara khao', total_discount, due_payment_cal)
            $("#discount_amt").val("");
            $("#discount_percent").val("");
            $("#total_discount").val("");
            $("#discount_percent_doctors").val("");
            $("#discount_amt_doctor").val("");
            $("#discount_amt").val("");
            alert("Discount invalid");
            calCulatePayment(value);


        } else {

            $("#total_due_con").html(Math.abs(due_payment.toFixed(2)));
            if (due_payment >= 0) {
                $("#final_due").html(" ");
                $("#final_due").html("Final Due");
            } else {
                $("#final_due").html(" ");
                $("#final_due").html("Refund");
            }

        }
        event.stopImmediatePropagation();

    }

    function calculateChangeAmt(thisElement) {
        var pay_amount = $("#cash_bd_amount").val() * 1;
        var total_amount = $("#cash_amount").val() * 1;


        if (total_amount >= pay_amount) {


            $("#change_amount").val("");
        } else {
            if (total_amount > 0) {
                $("#change_amount").val((pay_amount - total_amount));
            } else {
                $("#change_amount").val("");
            }

            // $("#cash_amount").val(total_amount.toFixed(2));

        }
    }

    function calCulateGivenAmount(value) {
        var pay_amount = $("#pay_amount").val();
        var change_amount = value - pay_amount;

        if (change_amount > 0) {
            $("#change_amount").val(change_amount.toFixed(2));
        }

    }


    $(document).on('change', '#cmb_discount_due', function() {
        var type = $(this).find(":selected").val();
        $("#discount_percent_doctors").val("");
        $("#total_discount_amount").val("");
        $("#discount_percent").val("");
        $("#discount_percent_doctors").val("");
        $("#discount_amt").val("");
        $("#discount_amt_doctor").val("");
        // $("#discount_amount_doctor").val("");
        if (type == "GENERAL") {
            $("#discount_percent_doctors").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $(".percent_hospital").removeClass('d-none');
            $(".percent_doctor").addClass('d-none');
        }
        if (type == "DOCTOR") {
            $("#discount_percent_hospital").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");

            $(".percent_hospital").addClass('d-none');
            $(".percent_doctor").removeClass('d-none');
        }
        if (type == "BOTH") {
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $(".percent_hospital").removeClass('d-none');
            $(".percent_doctor").removeClass('d-none');
        }

        if (type == "0") {
            $(".percent_hospital").addClass('d-none');
            $(".percent_doctor").addClass('d-none');
        }

        // calCulatePayment(this);
    });


    // payment and discount policy end
</script>
