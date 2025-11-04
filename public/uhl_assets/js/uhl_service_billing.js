function setQty(element) {
        var qty = $(element).val() != "" ? parseFloat($(element).val()) : 0;
        var item_id = $(element).parents("tr").find(".item_id").val();
        var item_price = parseFloat($('#item_rate_' + item_id).val()) * qty;
        var vat = parseFloat($('#vat_pers_' + item_id).val()) * qty;
        var total = 0;
        $('#hdn_item_total_qnty_' + item_id).val(item_price + vat);
        // $('#item_vat').val(vat);
        console.log(qty, vat);
        // $('#item_rate_' + item_id).val(item_price);
        // $('#hdn_item_rate_' + item_id).val(item_price + vat);

        billingEngine.calculateTotal(this);
        // billingEngine.calculatePayment(this);

        // alert(qty)
    }
    // billingEngine.calculatePayment();
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
        // var itemT_pay = (parseFloat($("#item_total").html() - parseFloat($("#pay_amount").val())));
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
            var item_gross_amt = 0;
            var total_qty = 0;
            var vat = 0;
            var default_dis = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var total_vat_amt = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;
                    vat += $(this).find(".vat_pers").val() * 1;
                    default_dis += parseFloat($(this).find(".auto_discount").val() * parseFloat(total_qty));
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });
                $("#item_vat").val(vat);

                total_vat_amt = $("#item_vat").val() != '' ? $("#item_vat").val() : 0;
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val((item_gross_amt).toFixed(2));
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = (((item_total - total_vat_amt) * discount_percent_hospital) / 100).toFixed(
                    2);

                console.log(item_total, total_vat_amt, discount_percent_hospital, discount_amt_hospital + '_amt');
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
                var discount_amt_doctor = (((item_total - total_vat_amt) * discount_percent_doctor) / 100).toFixed(2);
                // if (discount_amt_doctor == 0) {
                // 	discount_amt_doctor = "";
                // } else {
                // 	discount_amt_doctor;
                // }
                // $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = parseFloat(discount_percent_hospital +
                    discount_percent_doctor) //$("#discount_percent").val() * 1;
                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }

                var discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }
                $("#total_discount_amount").val(discount_amt_total + default_dis);
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
                    $("#total_discount_amount").val(total_discount_amount + default_dis);
                    after_disc_amt = ((item_gross_amt - total_vat_amt) - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                    $("#total_discount_amount").val(discount_amt_total + default_dis);
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = (item_gross_amt - total_vat_amt) - discount_amt_total;
                }
                var item_vat = $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));
                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
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
            var total_qty = 0;
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var default_dis = 0;
            var total_vat_amt = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    total_qty = $(this).find(".hdn_item_qnty").val() * 1;
                    default_dis += parseFloat($(this).find(".auto_discount").val() * parseFloat(total_qty));
                    // item_total += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }
                });

                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                total_vat_amt = $("#item_vat").val() != '' ? $("#item_vat").val() : 0;
                var discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                if (discount_percent_hospital <= 100) {} else {
                    alert("Invalid Discount Percentange");
                    $("#discount_percent_hospital").val('');
                    discount_percent_hospital = $("#discount_percent_hospital").val() * 1;
                }
                var discount_amt_hospital = (((item_total - total_vat_amt) * discount_percent_hospital) / 100).toFixed(
                    2);
                // if (discount_amt_hospital == 0) {
                // 	discount_amt_hospital = "";
                // } else {
                // 	discount_amt_hospital;
                // }
                // $("#discount_amount_hospital").val(discount_amt_hospital);

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
                var discount_amt_doctor = (((item_total - total_vat_amt) * discount_percent_doctor) / 100).toFixed(2);
                if (discount_amt_doctor == 0) {
                    discount_amt_doctor = "";
                } else {
                    discount_amt_doctor;
                }
                $("#discount_amount_doctor").val(discount_amt_doctor);

                var discount_percent = parseFloat(discount_percent_hospital) +
                    parseFloat(discount_percent_doctor) //$("#discount_percent").val() * 1;

                if (discount_percent <= 100) {} else {
                    $("#discount_percent").val('');
                    discount_percent = $("#discount_percent").val() * 1;
                }

                var discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;

                //Discount TOtal Calculation
                if (discount_amt_total == 0) {
                    discount_amt_total = '';
                } else {
                    discount_amt_total.toFixed(2);
                }

                $("#total_discount_amount").val(parseFloat(discount_amt_total) + parseFloat(default_dis));
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
                    $("#total_discount_amount").val(parseFloat(total_discount_amount) + parseFloat(default_dis));

                    after_disc_amt = ((item_gross_amt - total_vat_amt) - total_discount_amount);
                } else {
                    discount_percent = $("#discount_percent").val() * 1;
                    discount_amt_total = ((item_total - total_vat_amt) * discount_percent) / 100;
                    $("#total_discount_amount").val(parseFloat(discount_amt_total) + parseFloat(default_dis));
                    console.log(discount_percent, discount_amt_total, default_dis + '_bellal_dis');
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = (item_gross_amt - total_vat_amt) - discount_amt_total;
                }
                var item_vat = $("#item_vat").val() != "" ? $("#item_vat").val() * 1 : 0;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                // $("#pay_amount").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));
                billingEngine.calculatePayment(thisElement);

            } else {
                $("#billing_table-body tr").html('');
                $('#total_payable').val(0);
                $('#pay_amount').val(0);
                $('#given_amount').val(0);
                $("#item_total").html(0.00);
                $("#change_amount").val(0.00);
                // $("#discount_percent_hospital").val("");
                $("#discount_amount_hospital").val("");
                $("#discount_percent_doctor").val("");
                $("#discount_amount_doctor").val("");
                // alert("You did not selected any Item.");
                return;
            }
            event.stopImmediatePropagation();
        }
    }

    $(document).on('focusout', '#dis_doctor_code', function() {
        if ($('#hdn_dis_doctor_id').val() == "") {

            $('#dis_doctor_code').val("");
            $('pre').html("");

        }

    })
    openDoctorAutocomplete('#dis_doctor_code', 'hdn_dis_doctor_id');

    function removeTableRowPayment(thisElement) {

        if (confirm("Are you sure?")) {
            var amount = $(thisElement).parents('tr').children('td').find('.total_amt').val();
            var total_payment_amt = $('#total_payment_amt').val() - amount;
            var pay_amounts = $('#pay_amount').val() - amount;
            $('#total_payment_amt').val(total_payment_amt);
            $('#pay_amount').val(pay_amounts);
            var total_amount = $("#total_payable").val() * 1;
            var pay_amount = pay_amounts * 1;
            if (total_amount > 0) {
                $("#total_due_data").html((total_amount - pay_amount).toFixed(2));

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

        var table_row = "<tr><td ><input class='' readonly='readonly' type='text' name='pay_method_mode[]' value='" +
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


        } else {
            if (amount > 0 && parseFloat(amount) <= parseFloat(due_amount)) {

                $("#tbody").html(table_row);

            } else {
                $('#cash').children().find(':input').val("");
                $('#payment_method_bkash').children().find('#mBank_amount').val("");
                $('#payment_method_card').children().find('#card_amount').val("");
                $('#payment_method_cheque').children().find('#check_amount').val("");
                $('#cash_bd_amount').val("");
                alert("Invalid Amount");

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
                $('#pay_amount').val(amt);
            }
        });




        var total_amount = $("#total_payable").val() * 1;
        var pay_amount = amt * 1;
        $("#total_due_data").html((total_amount - pay_amount).toFixed(2));
        if (total_amount >= pay_amount) {
            // $("#cash_amount").val(pay_amount);
        } else {
            $("#change_amount").val(pay_amount - total_amount);
            // $("#cash_amount").val(total_amount);

        }
        $('#cash').children().find(':input').val("");
        $('#payment_method_bkash').children().find(':input').val("");
        $('#payment_method_card').children().find(':input').val("");
        $('#payment_method_cheque').children().find(':input').val("");

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
            var defult_dis = $('#item_type_no_pk').val();
            $("#discount_percent_doctor").val("");
            $("#total_discount_amount").val("");
            $("#discount_percent").val("");
            $("#percent_hospital").val("");
            $("#percent_doctor").val("");
            $("#discount_amount_hospital").val("");
            $("#discount_amount_doctor").val("");
            $("#discount_percent_hospital").val("");
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
                $('#discount_percent_hospital').val(defult_dis);
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
                $('#discount_percent_hospital').val(defult_dis);
            }

            if (type == "0") {
                $(".percent_hospital").addClass('d-none');
                $(".percent_doctor").addClass('d-none');
            }

            billingEngine.calculateTotal(this);
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
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });



    });

    function selectItem(item, obj) {
        console.log('ITEM_', item);
        if ($('#hdn_patient_id').val() == "") {
            alert("Select Patient");
            return;
        }
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
                var default_discount_percent = item.default_discount != null ? parseFloat(item
                    .default_discount) : 0;
                var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.item_rate *
                    default_discount_percent) / 100 : 0;
                var total = parseFloat(item.item_rate) + vat_amt;
                console.log('dis_' + default_discount_percent, default_discount_amt,
                    patient_itemType_dis_ind)
                var sl = $("#billing_table-body tr").length + 1;
                var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                var change_rate_color = item.manual_item_rate_ind == 1 ? "background-color: white" :
                    "background-color: #F8F8FF";

                var ipd_charge = item.ipd_charge;
                if (default_discount_amt >0) {
                    $('#discount_percent_hospital').val(0);
                    $('#discount_amount_hospital').val(0);
                }

                if (item.itemtype_code == 'LAB' || item.itemtype_code == 'RAD') {
                    var table_row =
                    "<tr><td>1</td><td>CLICNIC SERVICE FEE - GENARAL & LAP SURGERY 2 </td><td><div class='form-group '><input class='form-control' id='provider_' name='provider_'> </div></td><td class='text-center' style='width: 80px;'><div class='form-group '><input type='text' class='form-control form-control-sm text-center number_only' placeholder='0'></div></td><td class='text-right'>1200.00</td><td class='text-right'>0.00</td><td class='text-right'>1200.00</td><td class='text-right'>0.00</td><td><a href='#'><i class='fas fa-times-circle'></i></a></td></tr>";
                        // "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                        // item.item_id +
                        // "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                        // item.item_name +
                        // "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
                        // .item_type +
                        // "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                        // item
                        // .urgent_fee_amt + "'> </td><td style='width:12%'>" + item.item_dept +
                        // "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                        // "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item
                        // .item_name +
                        // "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                        // change_rate_color +
                        // "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id +
                        // "' value='" + item.item_rate +
                        // "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                        // item.manual_item_rate_ind +
                        // "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                        // item.item_id + "' value='" + item.item_rate +
                        // "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                        // item.item_id + "' value='" + vat_amt +
                        // "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                        // item.item_id +
                        // "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                        // item.item_id + "' value='" + default_discount_amt +
                        // "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' data-manual_item_dis_ind='1'  ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                        // item.item_id +
                        // "' name='hdn_item_qnty[]'  value='1'  ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                        // item.disc_aplicable + "' id='hdn_item_total_qnty_" + item.item_id + "' value='" +
                        // total +
                        // "' disabled='disabled' > <input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";
                } else {
                    var table_row =
                        "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                        item.item_id +
                        "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                        item.item_name +
                        "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" + item
                        .item_type +
                        "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                        item
                        .urgent_fee_amt + "'></td><td style='width:12%'>" + item.item_dept +
                        "<input type='hidden' name='hdn_item_dept_id[]' value='" + item.item_dept +
                        "' ></td><td class='text-left'><strong>" + item.item_code + " - </strong> " + item
                        .item_name +
                        "</td><td class='text-center' style='width:12%'> <input type='hidden' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center'> <input type='hidden' name='item_delivery_status[]' class='form-control' style='margin-bottom:0px!important'> </td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                        change_rate_color +
                        "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" + item.item_id +
                        "' value='" + item.item_rate +
                        "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                        item.manual_item_rate_ind +
                        "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                        item.item_id + "' value='" + item.item_rate +
                        "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                        item.item_id +
                        "' value='" + vat_amt +
                        "' readonly='readonly' ></td> <td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                        item.item_id +
                        "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                        item.item_id + "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                        default_discount_amt +
                        "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                        item.item_id +
                        "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                        item.disc_aplicable + "' id='hdn_item_total_qnty_" +
                        item.item_id + "' value='" + total +
                        "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";
                };
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

                } else {
                    $("#billing_table-body").html(table_row);
                }

                //auto item

                var total_auto = 0;
                $.each(data, function(key, value) {
                    var vat_pers_auto = value.vat_percent != null ? parseFloat(value.vat_percent) :
                        0;
                    var vat_amt_auto = (parseFloat(value.sales_price) * vat_pers_auto) / 100;
                    var dis_pers = value.default_discount != null ? parseFloat(value
                        .default_discount) : 0;
                    var dis_amt = patient_itemType_dis_ind == 1 ? (parseFloat(value.sales_price) *
                        dis_pers) / 100 : 0;
                    total_auto = value.sales_price != null ? parseFloat(value.sales_price) +
                        vat_amt_auto : 0;
                    var ipd_charge=0;

                    // var vat_amt_auto = 0; //value.sales_price;
                    if (value.itemtype_code == 'LAB' || value.itemtype_code == 'RAD') {
                        var table_row_auto =
                            "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                            value.auto_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            value.item_name +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            value.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            value.urgent_fee_amt + "'> </td><td style='width:12%'>" + value
                            .serviceunit_name +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + value
                            .serviceunit_name +
                            "' ></td><td class='text-left'><strong>" + value.item_code +
                            " - </strong> " + value.item_name +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            value.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            value.auto_item_no_fk + "' value='" + vat_amt_auto +
                            "' readonly='readonly' ></td> <td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            dis_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            value.auto_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                            value.discount_applicable_ind + "' id='hdn_item_total_qnty_" +
                            value.auto_item_no_fk + "' value='" + total_auto +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";
                    } else {
                        var table_row_auto =
                            "<tr><td class='text-center bg-light' style='width:2%'><input class='item_id' type='hidden' name='hdn_item_id[]' value='" +
                            value.auto_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            value.item_name +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            value.item_type +
                            "'>  <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            value.urgent_fee_amt + "'></td><td style='width:12%'>" + value
                            .serviceunit_name +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + value
                            .serviceunit_name + "' ></td><td class='text-left'><strong>" + value
                            .item_code + " - </strong> " + value.item_name +
                            "</td><td class='text-center' style='width:12%'> <input type='hidden' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center'> <input type='hidden' name='item_delivery_status[]' class='form-control' style='margin-bottom:0px!important'> </td><td class='text-center qnty-width'><input type='text'  style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            value.manual_item_rate_ind +
                            "'><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            value.auto_item_no_fk + "' value='" + value.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            value.auto_item_no_fk + "' value='" + vat_amt_auto +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            dis_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            value.auto_item_no_fk +
                            "' name='hdn_item_qnty[]' value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' data-dis-ind='" +
                            value.discount_applicable_ind + "' id='hdn_item_total_qnty_" +
                            value.auto_item_no_fk + "' value='" + total_auto +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>";
                    };
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

                    } else {
                        $("#billing_table-body").html(table_row_auto);

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
                // billingEngine.calculatePayment(thisElement);
                // calculateDisTotalHospital(this);

            }
        });
    }

    function calculateUrgentFee(element) {
        var item_id = $(element).parents("tr").find(".item_id").val();

        var item_qty = $('#hdn_item_qnty_' + item_id).val();
        var vat = parseFloat($(element).parents("tr").find(".vat_pers").val()) * item_qty;
        var urgent_fee = $(element).parents("tr").find(".hdn_item_urgent_fee").val();
        if (urgent_fee == 'null') {
            urgent_fee = 0;
        }
        if (vat == 'null') {
            vat = 0;
        }


        var item_price = parseFloat($('#hdn_item_rate_' + item_id).val());

        var total = 0;
        if ($(element).val() == 2) {
            total = parseFloat(urgent_fee * item_qty) + (parseFloat(item_price) * item_qty) + parseFloat(vat);
            $('#hdn_item_total_qnty_' + item_id).val(total);
            $('#item_rate_' + item_id).val(parseFloat(urgent_fee * item_qty) + parseFloat(item_price));
        } else {
            $('#hdn_item_total_qnty_' + item_id).val((parseFloat(item_price) * item_qty) + parseFloat(vat));
            $('#item_rate_' + item_id).val(parseFloat(item_price));
        }
        billingEngine.calculateTotal(this);
        billingEngine.calculatePayment(this);
    }

    function calculateItemRate(element) {

        var manual_item_rate_ind = $(element).data('manual_item_rate_ind');

        if (manual_item_rate_ind == 1) {
            var item_id = $(element).parents("tr").find(".item_id").val();
            var item_price = $(element).val();
            $(element).attr('readonly', false);


            var total = 0;
            $('#hdn_item_total_qnty_' + item_id).val(item_price);
            $('#item_rate_' + item_id).val(item_price);
            $('#hdn_item_rate_' + item_id).val(item_price);

            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);
        }
    }

    function calculateItemDiscount(element) {

        var manual_item_rate_ind = $(element).data('manual_item_dis_ind');
        var persent = $(element).data('dis');
        var item_id = $(element).parents("tr").find(".item_id").val();
        if (persent == "PERC") {

            var price = $(element).parents("tr").find("#item_rate_" + item_id).val();
            var perc_val = $(element).val() != "" ? $(element).val() : 0;
            var dis_amt = price * perc_val / 100;

            $(element).parents("tr").find("#auto_discount_" + item_id).val(dis_amt.toFixed(2));
            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);

        } else if (persent == "AMT") {
            $(element).parents("tr").find("#auto_discount_perc_" + item_id).val(0);
            console.log(dis_amt + '_bellal2')
            billingEngine.calculateTotal(this);
            billingEngine.calculatePayment(this);
        }

        // if (manual_item_rate_ind == 1) {
        // var item_id = $(element).parents("tr").find(".item_id").val();
        // var item_price = $(element).val() !="" ?  $(element).val(): 0 ;
        // $(element).attr('readonly', false);
        // var total = 0;
        // $('#hdn_item_total_qnty_' + item_id).val(item_price);
        // $('#item_rate_' + item_id).val(item_price);
        // $('#hdn_item_rate_' + item_id).val(item_price);
        // }
    }

    function patientInfo(item, obj) {
        //console.log(item, 'bellal');
        var admission_is = item.admission_no_pk == null ? "" : "<h4 class='name_'>Admission Id: " + item.admission_no_pk +
            "</h4>,";

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var present_addr = item.present_addr == null ? "" : "<p class='adress_'>"+ item.present_addr + "</p>";
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";
        var patient_information = admission_is + "<h4 class='name_'>UHID: " + item.patient_code + " </h4><h4 class='name_'> " +
            item.patient_name + "(" + item.patient_type_code + ")</h4>" + " <h4 class='subheading'>Gender : " + item.gender +
            ", Age : " + item.age +"</h4><h4 class='subheading'> Phone : " + item.phone_mobile+"</h4>"+present_addr;
            //  + corporate_name + contact_person + contact_mobile;
           if (item.patient_photo !=null) {
            var source ='../images/uploads/patient_images/thumb/'+item.patient_photo;
            console.log(source);          
            $('#pat_photo').attr('src', source);
           }
       
        

        var doctorPhone = item.doc_phone == null ? "" : "<strong>Phone : </strong>" + item.doc_phone;
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(1st)</div>";



        var firstRefPhone = item.first_ref_phone_no == null ? "" : "<strong>Phone : </strong>" + item
            .first_ref_phone_no;
        var first_ref_name = item.first_ref_name != "" ? "Name:" + (item.first_ref_name) + "," : "";
        var first_ref_info =
            "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.first_ref_code + " : </strong>" + first_ref_name + firstRefPhone + " " + "(2nd)</div>";


        var second_ref_Phone = item.second_ref_phone_no == null ? "" : " <strong>Phone : </strong>" + item
            .second_ref_phone_no;
        var second_ref_name = item.second_ref_name != "" ? "Name:" + (item.second_ref_name) + "," : "";
        var second_ref_info =
            "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.second_ref_code + " : </strong>" + second_ref_name + second_ref_Phone + " " + "(3rd)</div>";



        $("#doctor_ref2_info").html(item.second_referral_no_fk != null ? second_ref_info : "");
        $("#hdn_second_refer").val(item.second_referral_no_fk != null ? item.second_referral_no_fk : "");
        $("#doctor_ref1_info").html(item.first_referral_no_fk != null ? first_ref_info : "");
        $("#hdn_first_refer").val(item.first_referral_no_fk != null ? item.first_referral_no_fk : "");
        $("#doctor_info").html(item.doctor_no_fk != null ? doctor_info : "");
        $("#hdn_doctor_id").val(item.doctor_no_fk != null ? item.doctor_no_fk : "");

        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        billingEngine.calculateTotal(this);
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_pk);
        patientTotalDue(item.patient_id);
    }

    //     function patientFunc(id){
    //     openBillingItemAutocomplete(".item_typehead", item_type =
    //     "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //     item_type_void = "MED", selectItem,"",id);
    // }


    // console.log(patientFunc()+'pat_name');

    function prescriptionPatientInfo(item, obj) {
        console.log(item)
        $("#billing_table-body").html("");
        $('.button5').html(0);
        $('.button5').attr('title', "");
        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        console.log(item.item_level_disc_ind + '_bellal');
        $.ajax({
            url: "{{ route('item-info-autocomplete-prescription') }}",
            type: 'POST',
            data: {
                prescription_no_pk: item.prescription_no_pk,
                corporate_no: item.ccm_client_no_pk,
                patient_type: item.patient_type_code,
                admission_id: item.admission_no_fk
            },
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                jQuery.each(data, function(index, item) {
                    // var total = item.sales_price;
                    var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (item.sales_price * vat_pers) / 100;
                    var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();

                    var default_discount_percent = item.default_discount != null ? parseFloat(item
                        .default_discount) : 0;
                    var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.sales_price *
                        default_discount_percent) / 100 : 0;
                    var total = parseFloat(item.sales_price) + vat_amt;

                    var sl = $("#billing_table-body tr").length + 1;
                    var change_rate_color = item.manual_item_rate_ind == 1 ?
                        "background-color: white" : "background-color: #F8F8FF";
                    var department = item.serviceunit_name != null ? item.serviceunit_name : "";

                    var ipd_charge = item.ipd_charge;
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'SUR' || item.lookupdata_uid == 'PTET' || item
                        .lookupdata_uid == 'PTTE') {
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" +
                            sl +
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            item.prescrition_data +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            item.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            item.urgent_fee_amt + "'> </td><td style='width:12%'>" + department +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + department +
                            "' ></td><td class='text-left'><strong>" + item.item_code +
                            " - </strong> " + item.prescrition_data +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            item.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class=' vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            item.lookupdata_item_no_fk + "' value='" + vat_amt +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            default_discount_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            item.lookupdata_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' data-dis-ind='" +
                            item.discount_cal +
                            "' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.lookupdata_item_no_fk + "' value='" + total +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";


                    }

                    if (item.lookupdata_item_no_fk != 0) {
                        $("#billing_table-body").append(table_row);

                    }


                    $('#item_code').typeahead('val', '');
                    $('#item_name').typeahead('val', '');
                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true
                    });

                });


                var item_n = "";
                var written_item = 0;
                jQuery.each(data, function(index, item) {
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'PTET' || item.lookupdata_uid == 'PTTE') {
                        var table_row =
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk + "' >";
                        var lookupdata_item_no_fk = item.lookupdata_item_no_fk;
                    }
                    if (lookupdata_item_no_fk == 0) {
                        written_item += 1;

                        if (written_item > 1) {
                            item_n += ' , ' + item.prescrition_data;
                        } else {
                            item_n += item.prescrition_data;
                        }

                        // item_n += item.prescrition_data + ' , ';
                        $('.button5').html(written_item);
                        $('.button5').attr('title', item_n);
                    }
                    console.log(written_item);
                });
                // billingEngine.calculateTotal(this);
            },
            complete: function(data) {
                $.unblockUI();
                billingEngine.calculateTotal(this);
            }
        });

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var phone = item.phone_mobile != null ? ", <strong>Phone : </strong>" + item.phone_mobile : "";
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";
        var patient_information = "<strong>Patient Code: " + item.patient_code + ", </strong>" +
            "<strong>Prescription ID: " + item.prescription_uid + " ,Name: " + item.patient_name + "(" + item
            .patient_type_code + ")" +
            ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + phone +
            corporate_name + contact_person + contact_mobile;
        //var patient_information = "<strong>" + item.patient_code + " : </strong>" + item.patient_name + ",<strong>Phone : </strong>" +patientNumber;
        console.log(item);
        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');
        $("#hdn_patient_id").val(item.patient_id);


        // doctor info
        if (item.doctor_person_no_fk != null) {
            var name = item.doctor_name != "" ? "Name:" + (item.doctor_name) + "," : "";
            var doctor_info =
                "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
                "Code:" + item.person_code + " : </strong>" + name + " " + "(1st)</div>";
            $("#doctor_info").html(doctor_info);
            $('#hdn_doctor_id').val(item.doctor_person_no_fk);
            $('#doctor_code').typeahead('val', '');
        }

        //first referral info
        if (item.first_referral_no_fk != null) {
            var first_ref_name = item.first_ref_doc_name != "" ? "Name:" + (item.first_ref_doc_name) + "," :
                "";
            var first_ref =
                "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.first_ref_person_code + " : </strong>" + first_ref_name + " " + "(2nd)</div>";
            $("#doctor_ref1_info").html(first_ref);
            $('#hdn_first_refer').val(item.first_referral_no_fk);
            $('#first_refer').typeahead('val', '');
        }
        //second referral info
        if (item.second_referral_no_fk != null) {
            var second_ref_name = item.sec_ref_doc_name != "" ? "Name:" + (item.sec_ref_doc_name) + "," : "";
            var second_ref =
                "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.sec_ref_person_code + " : </strong>" + second_ref_name + " " + "(3rd)</div>";
            $("#doctor_ref2_info").html(second_ref);
            $('#hdn_second_refer').val(item.second_referral_no_fk);
            $('#second_refer').typeahead('val', '');
        }
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_fk);
        patientTotalDue(item.patient_id);
    }

    function admissionPatientInfo(item, obj) {
        //console.log('LLU',item)
        $("#billing_table-body").html("");
        $('.buttonAdmission').html(0);
        $('.buttonAdmission').attr('title', "");

        $('#item_type_no_pk').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $('#discount_percent_hospital').val(item.item_level_disc_ind == 1 ? 0 : item.maximum_percent);
        $("#patient_itemType_dis_ind").val(item.item_level_disc_ind);
        $.ajax({
            url: "{{ route('item-info-autocomplete-admission') }}",
            type: 'POST',
            data: {
                admission_no_pk: item.admission_no_pk,
                corporate_id: item.ccm_client_no_pk,
                $patient_type: item.patient_type_code
            },
            dataType: 'json',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // $.blockUI();
                jQuery.each(data, function(index, item) {
                    // var total = item.sales_price;
                    var vat_pers = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (item.sales_price * vat_pers) / 100;
                    var total = parseFloat(item.sales_price) + vat_amt;
                    var patient_itemType_dis_ind = $("#patient_itemType_dis_ind").val();
                    var default_discount_percent = item.default_discount != null ? parseFloat(item
                        .default_discount) : 0;
                    var default_discount_amt = patient_itemType_dis_ind == 1 ? (item.sales_price *
                        default_discount_percent) / 100 : 0;
                    console.log('admi_dis_' + patient_itemType_dis_ind + ',' +
                        default_discount_amt + ',' + item.default_discount);
                    var sl = $("#billing_table-body tr").length + 1;
                    var change_rate_color = item.manual_item_rate_ind == 1 ?
                        "background-color: white" : "background-color: #F8F8FF";
                    var department = item.serviceunit_name != null ? item.serviceunit_name : "";
                    var ipd_charge = item.ipd_charge;

                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'SUR' || item.lookupdata_uid == 'PTET' || item
                        .lookupdata_uid == 'PTTE') {
                        var table_row = "<tr><td class='text-center bg-light' style='width:2%'>" +
                            sl +
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk +
                            "' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='" +
                            item.prescrition_data +
                            "'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='" +
                            item.item_type +
                            "'> <input class='hdn_item_urgent_fee' type='hidden' name='hdn_item_urgent_fee[]' value='" +
                            item.urgent_fee_amt + "'> </td><td style='width:12%'>" + department +
                            "<input type='hidden' name='hdn_item_dept_id[]' value='" + department +
                            "' ></td><td class='text-left'><strong>" + item.item_code +
                            " - </strong> " + item.prescrition_data +
                            "</td><td class='text-center' style='width:12%'> <input type='text' name='delivery_date[]' class='date_picker form-control mb-0 text-right' placeholder='dd-mm-yyyy'></td><td class='text-center' style='width:12%'> <select name='item_delivery_status[]' class='form-control item_delivery_status' onchange='calculateUrgentFee(this)' style='margin-bottom:0px!important' ><option value='1'>Routine</option> <option value='2'>Urgent</option> </select> </td><td class='text-center qnty-width'><input type='text' style='font-weight: bold; " +
                            change_rate_color +
                            "' class='w-100 mb-0 text-right' name='item_rate[]' id='item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' onkeyup='calculateItemRate(this)' onclick='calculateItemRate(this)' data-manual_item_rate_ind='" +
                            item.manual_item_rate_ind +
                            "' readonly='readonly'  ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_" +
                            item.lookupdata_item_no_fk + "' value='" + item.sales_price +
                            "' readonly='readonly' ><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='vat_pers form-control mb-0 text-right' name='vat_pers[]' id='vat_pers_" +
                            item.item_id + "' value='" + vat_amt +
                            "' readonly='readonly' ></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount_perc form-control mb-0 text-right' name='' id='auto_discount_perc_" +
                            item.item_id +
                            "' value='' data-dis='PERC' onkeyup='calculateItemDiscount(this)'></td><td class='text-right qnty-width'><input type='text' style='font-weight: bold;' class='auto_discount form-control mb-0 text-right' name='auto_discount[]' id='auto_discount_" +
                            item.item_id +
                            "' data-dis='AMT' onkeyup='calculateItemDiscount(this)' value='" +
                            default_discount_amt +
                            "' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right hdn_item_qnty' onkeyup='setQty(this)' id='hdn_item_qnty_" +
                            item.lookupdata_item_no_fk +
                            "' name='hdn_item_qnty[]'  value='1' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_" +
                            item.lookupdata_item_no_fk + "' value='" + total + "' data-dis-ind='" +
                            item.discount_cal +
                            "' disabled='disabled' ><input type='hidden' id='ipd_charge' name='ipd_charge[]' value='"+ipd_charge+"' /></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span></td></tr>";


                    }

                    if (item.lookupdata_item_no_fk != 0) {
                        $("#billing_table-body").append(table_row);

                    }


                    $('#item_code').typeahead('val', '');
                    $('#item_name').typeahead('val', '');
                    $('.date_picker').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        clearBtn: true
                    });

                });


                var item_n = "";
                var written_item = 0;
                jQuery.each(data, function(index, item) {
                    if (item.lookupdata_uid == 'LAB' || item.lookupdata_uid == 'RAD' || item
                        .lookupdata_uid == 'PTET' || item.lookupdata_uid == 'PTTE') {
                        var table_row =
                            "<input class='item_id' type='hidden'  name='hdn_item_id[]' value='" +
                            item.lookupdata_item_no_fk + "' >";
                        var lookupdata_item_no_fk = item.lookupdata_item_no_fk;
                    }
                    if (lookupdata_item_no_fk == 0) {
                        written_item += 1;

                        if (written_item > 1) {
                            item_n += ' , ' + item.prescrition_data;
                        } else {
                            item_n += item.prescrition_data;
                        }

                        // item_n += item.prescrition_data + ' , ';
                        $('.buttonAdmission').html(written_item);
                        $('.buttonAdmission').attr('title', item_n);


                    }

                });

            },
            complete: function(data) {
                $.unblockUI();
                billingEngine.calculateTotal(this);
            }
        });

        // patient info

        var patientNumber = item.phone_mobile == null ? "" : item.phone_mobile;
        var phone = item.phone_mobile ? ", <strong>Phone : </strong>" + item.phone_mobile : "";
        var prescription_uid = item.prescription_uid != null ? "<strong>Prescription ID:</strong> " + item
            .prescription_uid + ',' : '';
        var admission_id = item.admission_no_pk != null ? item.admission_no_pk : "";
        var corporate_name = item.ccm_client_name ? ', <strong>Corporate name : </strong>' + item.ccm_client_name : "";
        var contact_person = item.contact_person ? ', <strong>Contact person : </strong>' + item.contact_person : "";
        var contact_mobile = item.contact_mobile ? ', <strong>Contact person : </strong>' + item.contact_mobile : "";

        var patient_information = "<strong>Patient Code: " + item.patient_code + ", </strong>" + prescription_uid +
            "<strong>Admission ID:</strong>" + admission_id + "  ,Name: " + item.patient_name + "(" + item
            .patient_type_code + ")" +
            ", <strong>Gender : </strong>" + item.gender + ", <strong>Age : </strong>" + item.age + phone +
            corporate_name + contact_person + contact_mobile;
        $("#patient_info").html(patient_information);
        $('#patient_id').typeahead('val', '');
        $('#admission_id').typeahead('val', '');
        $("#patient_id").removeAttr("required");
        $("#hdn_admission_id").val('');

        // doctor info
        if (item.primary_doctor_no_fk != null) {
            var name = item.primary_doctor_name != "" ? "Name:" + (item.primary_doctor_name) + "" : "";
            var doctor_info =
                "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
                "Code:" + item.primary_doctor_code + " : </strong>" + name + " " + "(1st)</div>";
            $("#doctor_info").html(doctor_info);
            $('#hdn_doctor_id').val(item.primary_doctor_no_fk);
            $('#doctor_code').typeahead('val', '');
        }
       // console.log(doctor_info, "llu",item.primary_doctor_no_fk);
        //first referral info
        if (item.first_ref_doc_person_no_fk != null) {
            var first_ref_name = item.first_ref_doctor_name != "" ? "Name:" + (item.first_ref_doctor_name) +
                "," : "";
            var first_ref =
                "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.first_ref_doc_person_code + " : </strong>" + first_ref_name + " " + "(2nd)</div>";
            $("#doctor_ref1_info").html(first_ref);
            $('#hdn_first_refer').val(item.first_ref_doc_person_no_fk);
            $('#first_refer').typeahead('val', '');
        }
        //second referral info
        if (item.second_ref_doc_person_no_fk != null) {
            var second_ref_name = item.second_ref_doctor_name != "" ? "Name:" + (item.second_ref_doctor_name) +
                "," : "";
            var second_ref =
                "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
                "Code:" + item.second_ref_doc_person_code + " : </strong>" + second_ref_name + " " + "(3rd)</div>";
            $("#doctor_ref2_info").html(second_ref);
            $('#hdn_second_refer').val(item.second_ref_doc_person_no_fk);
            $('#second_refer').typeahead('val', '');
        }
        patientFunc(item.ccm_client_no_pk, item.patient_type_code, item.admission_no_pk);

        patientTotalDue(item.patient_id);
    }

    // function titleCase(str) {
    //     return str.replace(/\w\S*/g, function(txt) {
    //         return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    //     });
    // }

    function doctorInfo(item, obj) {



        var doctorPhone = item.phone_mobile == null ? "" : "<strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + item.full_name + "," : "";
        // var name = item.full_name != "" ? "Name:" + titleCase(item.full_name) + "," : "";

        var doctor_info =
            "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(1st)</div>";
        //var doctor_info = "<strong>Patient Code: " + item.person_code + " : </strong>Name: " + item.full_name + ", <strong>Gender : </strong>" + item.gender_txt + ", <strong>Age : </strong>" + item.person_age + ", <strong>Phone : </strong>" + item.phone_mobile;
        $("#doctor_info").html(doctor_info);
        $('#doctor_code').typeahead('val', '');
        $("#doctor_code").removeAttr("required");
    }



    function doctorInfoFirstRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "" : "<strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(2nd)</div>";
        $("#doctor_ref1_info").html(doctor_info);
        $('#first_refer').typeahead('val', '');

    }

    function doctorInfoSecondRef(item, obj) {
        var doctorPhone = item.phone_mobile == null ? "" : " <strong>Phone : </strong>" + item.phone_mobile;
        var speci = item.specialization != "" || item.specialization != null ? item.specialization : "";
        var name = item.full_name != "" ? "Name:" + (item.full_name) + "," : "";
        var doctor_info =
            "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>" +
            "Code:" + item.person_code + " : </strong>" + name + doctorPhone + " " + "(3rd)</div>";
        $("#doctor_ref2_info").html(doctor_info);
        $('#second_refer').typeahead('val', '');

    }

    function deleteDoc(element) {
        var id = $(element).parent('div').attr('id');

        $('#doctorRef').remove();
        $('#hdn_doctor_id').val("");
    }

    function deleteFirstRef(element) {
        var id = $(element).parent('div').attr('id');

        $('#firstRef').remove();
        $('#hdn_first_refer').val("");
    }

    function deleteSecRef(element) {
        var id = $(element).parent('div').attr('id');
        $('#secondRef').remove();
        $('#hdn_second_refer').val("");
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


    function calculateTotalDis(thisElement) {

        var h_amt = $("#discount_amount_hospital").val() != "" ? parseFloat($("#discount_amount_hospital").val()) : 0;
        var d_amt = $("#discount_amount_doctor").val() != "" ? parseFloat($("#discount_amount_doctor").val()) : 0;
        var t_amt = h_amt + d_amt;
        total_payable
        // parseFloat($("#item_total").html())
        if (parseFloat(t_amt) > (parseFloat($("#item_total").html() - parseFloat($('#pay_amount').val())))) {
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
            var item_gross_amt = 0;
            var delivery_status = 0;
            var urgent_fee = 0;
            var vat = 0;
            var total_qty = 0;
            if ($("#billing_table-body tr").length > 0) {
                $("#billing_table-body tr").each(function() {
                    if ($(this).find(".item_total_amt").attr('data-dis-ind') == 0) {
                        item_total += $(this).find(".item_total_amt").val() * 1;
                    }
                    total_qty += $(this).find(".hdn_item_qnty").val() * 1;
                    item_gross_amt += $(this).find(".item_total_amt").val() * 1;
                    delivery_status = $(this).find(".item_delivery_status").val();
                    vat += parseFloat($(this).find(".vat_pers").val() * parseFloat(total_qty));
                    if (delivery_status == 2) {
                        if ($(this).find(".hdn_item_urgent_fee").val() != 'null') {
                            urgent_fee += parseFloat($(this).find(".hdn_item_urgent_fee").val());
                        }
                    }

                });
                $("#item_total").html(item_gross_amt.toFixed(2));
                $("#total_payable").val(item_gross_amt.toFixed(2));
                $("#item_vat").val((vat).toFixed(2));
                total_vat_amt = $("#item_vat").val() != '' ? parseFloat($("#item_vat").val()) : 0;

                var discount_percent_hospital = ($("#discount_amount_hospital").val() != "") ? parseFloat($(
                    "#discount_amount_hospital").val()) : 0;
                var discount_amt_hospital = (discount_percent_hospital);
                var item_total_amount = (item_total - total_vat_amt); //$("#item_total").html();
                var discount_percent_hospital_dis = (discount_percent_hospital > 0) ? (discount_percent_hospital * 100 /
                    parseFloat(item_total_amount)) : "";
                console.log(discount_percent_hospital, item_total_amount + 'discount_per')
                $("#discount_percent_hospital").val(discount_percent_hospital_dis ? discount_percent_hospital_dis
                    .toFixed(2) : 0);
                var discount_percent_doctor = ($("#discount_amount_doctor").val() != "") ? parseFloat($(
                    "#discount_amount_doctor").val()) : 0;
                var discount_amt_doctor = (discount_percent_doctor);
                var item_total_amount = (item_total - total_vat_amt); //$("#item_total").html();
                var discount_percent_doctor_dis = (discount_percent_doctor > 0) ? (discount_percent_doctor * 100 /
                    parseFloat(item_total_amount)) : "";
                $("#discount_percent_doctor").val(discount_percent_doctor_dis ? discount_percent_doctor_dis.toFixed(2) :
                    0);
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
                    after_disc_amt = (item_gross_amt - total_discount_amount);
                } else {
                    discount_percent = (parseFloat(discount_amt_doctor) + parseFloat(discount_amt_hospital));
                    total_discount_amount_per = parseFloat(h_perc) + parseFloat(doc_perc);
                    $("#discount_percent").val(total_discount_amount_per.toFixed(2));
                    discount_amt_total = (discount_percent);
                    $("#total_discount_amount").val(discount_amt_total.toFixed(2));
                    total_discount_amount = discount_amt_total;
                    after_disc_amt = item_gross_amt - discount_amt_total;
                }

                var item_vat = 0; //$("#item_vat").val() * 1;
                $("#urgent_fee").val(urgent_fee);
                var s_charge = $("#s_charge").val() * 1;
                var total_payable = ((after_disc_amt + item_vat + s_charge));
                $("#total_payable").val(total_payable.toFixed(2));
                var pay_amount = $('#pay_amount').val() * 1;
                $("#total_due_data").html((total_payable - pay_amount).toFixed(2));

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

    function default_dis(element) {
        var dis_ind = $(element).val();
        if ($(element).is(':checked')) {
            $('#cmb_discount').attr('disabled', true);
            $('#discount_percent_hospital').attr('readonly', true);
            $('#discount_amount_hospital').attr('disabled', true);
            $('#discount_percent_doctor').attr('disabled', true);
            $('#discount_amount_doctor').attr('disabled', true);

            $('#discount_percent_hospital').val(0);
            $('#discount_amount_hospital').val(0);
            $('#discount_percent_doctor').val(0);
            $('#discount_amount_doctor').val(0);
        } else {
            $('#cmb_discount').attr('disabled', false);
            $('#discount_percent_hospital').attr('readonly', false);
            $('#discount_amount_hospital').attr('disabled', false);
            $('#discount_percent_doctor').attr('disabled', false);
            $('#discount_amount_doctor').attr('disabled', false);
            $('.auto_discount').val(0);
            $('.auto_discount_perc').val(0);
            $(element).attr('disabled', true);
            billingEngine.calculateTotal(this);
        }
    }
    openPatientAutocomplete('#patient_id', 'patient_name', patientInfo);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2', doctorInfo);
    openDoctorAutocomplete('#first_refer', 'hdn_first_refer', 'referral_agent_ind', '1,2', doctorInfoFirstRef);
    openDoctorAutocomplete('#second_refer', 'hdn_second_refer', 'referral_agent_ind', '1,2', doctorInfoSecondRef);
    // openBillingItemAutocomplete(".item_typehead", item_type =
    //     "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //     item_type_void = "MED", selectItem,"", patientFunc());
    openAdmissionAutocomplete('#admission_id', 'hdn_admission_id', admissionPatientInfo);
    openPrescriptionAutocomplete('#prescription_id', 'hdn_prescription_id', prescriptionPatientInfo);



    $(document).ready(function() {

            $('#patient_id').focus();
        $('#auto_dis_ind').attr('disabled', false);
        $('#cmb_discount').attr('disabled', true);
        $('#discount_percent_hospital').attr('readonly', true);
        $('#discount_amount_hospital').attr('disabled', true);

        var corporate_id = $('#corporate_no_hdn').val();
        var patient_type_code = $('#patient_type_code').val();
        var admission_id = $('#hdn_admission_id_2').val();
        console.log(admission_id + '_admission_id');
        if (corporate_id != null) {
            // $('.patient_entry').addClass('d-none');
            openBillingItemAutocomplete(".item_typehead", item_type =
                "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT",
                item_type_void = "MED", selectItem, "", corporate_id, "", admission_id);
            $("#item_name").parent('span').siblings('span').remove();
            $("#item_code").parent('span').siblings('span').remove();
        }

        calculateDisTotalHospital();


    });

    function patientFunc(id, type, admission_id) {
        console.log(admission_id + '_addmission');
        openBillingItemAutocomplete(".item_typehead", item_type =
            "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM,OT",
            item_type_void = "MED", selectItem, "", id, type, admission_id);
        $("#item_name").parent('span').siblings('span').remove();
        $("#item_code").parent('span').siblings('span').remove();
    }
    // $(document).ready(function() {
    //     var corporate_id = $('#corporate_no_hdn').val();
    //     if (corporate_id != null) {
    //         $('.patient_entry').addClass('d-none');

    //         openBillingItemAutocomplete(".item_typehead", item_type =
    //             "GENERIC,SERVICE,LAB,RAD,IPD,BED,SUR,AMB,FOOD,PTET,PTTE,OPD,COMS,ADM",
    //             item_type_void = "MED", selectItem, "", corporate_id);
    //         console.log(corporate_id + 'corporate_id');
    //     }

    // })
    function patientTotalDue(patient_id) {
        $.ajax({
            url: "{{ route('billing.patient-total-due-calculcation') }}",
            type: 'POST',
            data: {
                patient_id: patient_id
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                // $.blockUI();
                console.log(data);
                $("#patient_total_available_due_div").removeClass('d-none');
                $("#patient_total_available_due_div").html(data);
            },
            complete: function(data) {
                $.unblockUI();
            }
        });
    }
