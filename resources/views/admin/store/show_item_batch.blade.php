<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<?php
$date = date('d-m-Y');
?>
<div class="row">


    <div class="col-sm-12 col-lg-12 col-xl-12">
        <table width="100%">
            <tr>
                <td>Item Name : <strong> {{ $item_name->item_name }} </strong></td>
                <td style="text-align: right;">Receive qty : <strong> {{ $qty }} </strong></td>

            </tr>
        </table>
        <form action="{{ route('loan.store') }}" method="post" id="loan-form">
            @csrf
            <input type="hidden" name="item_id" id="hd_item_id" value="{{ $item_id }}">
            <input type="hidden" id="sales_qty" name="sales_qty" value="{{ $qty }}">
            <input type="hidden" id="hidn_item_price" name="hidn_item_price" value="{{ $item_prices }}">
            <input type="hidden" id="hidn_item_uom_no_fk" name="hidn_item_uom_no_fk" value="{{ $item_uom_no }}">
            <input type="hidden" id="hidn_item_conversion" name="hidn_item_conversion" value="{{ $item_conversion }}">



            <table id="myTable">
                <thead>
                    <tr>
                        <td>Batch No</td>
                        <td class="w-25">Exp. Date</td>
                        <td class="w-15">QTY</td>
                        <!-- <td class="w-15">Sales QTY</td> -->
                        <td class="text-right">Action</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control form-control-sm m-0 " id="batch_no" name="batch_no"
                                onkeyup="chheckChar(this)" placeholder="Batch No" value="" />
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="exp_date"
                                name="exp_date" placeholder="dd-mm-yyyy" value="" />
                        </td>
                        <td>

                            <input type="text" class="form-control form-control-sm number_only text-right" id="qty"
                                name="qty" value="" placeholder="Enter QTY">
                        </td>
                        </td>
                        <!-- <td>
              <input type="text" class="form-control form-control-sm number_only text-right" id="qty" name="sales_qty" value="" placeholder="Sales QTY">
            </td> -->
                        <td class="text-right"><button class="btn btn-sm btn-info" type="button"
                                onclick="expAdd()">Add</button></td>
                    </tr>
                </thead>
                <tbody id="tbody_exp">
                    <input type="hidden" id="item_id" name="" value="{{ $item_id }}">
                    @if (!empty($exp))
                        @php
                            $expiry = array_filter($exp);

                            $expiry_count = count($expiry);

                            $i = 0;
                        @endphp

                        @for ($i = 0; $i < $expiry_count; $i++)
                            @php $exp_data=explode(',' , $expiry[$i]); @endphp <tr class="data_class" data-batch_name='{{ $exp_data[0] }}'
                                data-exp_date='{{ $exp_data[1] }}' data-qty='{{ $exp_data[2] }}'
                                data-item_prices='{{ $exp_data[3] }}' data-uom='{{ $exp_data[4] }}'data-conversion='{{ $exp_data[5] }}'>
                                <td><input type='text' style='border:none;' name='edit_batch_name[]'
                                        id='edit_batch_name' readonly='readonly' value='{{ $exp_data[0] }}'></td>
                                <td><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'
                                        class='w-100' style='border: none;' value='{{ $exp_data[1] }}'></td>

                                <!-- <td><input type='text' name='edit_qty[]' id='edit_qty' class='text-right w-100 edit_qty' style='border: none;' value='{{ $exp_data[2] }}'></td> -->
                                <td><input type='text' name='edit_sales_qty[]' id='edit_sales_qty'
                                        class='text-right w-100 edit_sales_qty' style='border: none;'
                                        value='{{ $exp_data[2] }}'></td>
                                <td class='text-right'><span class='btn btn-sm btn-danger' data-id=''
                                        onclick='removeTableRowOnly(this)' data-url=''
                                        title='Cancel this appointment'><i class='fas fa-times'></i></span><input
                                        type="hidden" name="item_prices[]" value="{{ $item_prices }}"></td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>

            <div class="text-left mt-5">
                <button type="button" class="btn btn-md btn-success" data-dismiss="modal" onclick="saveData(this)">
                    Save
                </button>
                <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    function chheckChar(Element) {
        var data = $(Element).val();
        $(Element)
            .val()
            .split('')
            .forEach(function(c) {
                if (c == "_") {
                    alert("Invalid Charater. Do not enter ( _ ) Charater");
                    $(Element).val("");
                }
            });


    }




    //   function changeBatch(element) {
    //     var batch_id = $(element).val();
    //     if (batch_id != "") {
    //       $.ajax({
    //         data: {
    //           batch_id: batch_id
    //         },
    //         url: "{{ route('billing.show-batch-no-dropdown') }}",
    //         type: "post",
    //         beforeSend: function() {
    //           blockUI();
    //         },
    //         success: function(data) {

    //           var result = jQuery.parseJSON(data);

    //           if (result != "") {
    //             var exp_date = result.expiry_date;
    //             var qty = result.recieve_qty;

    //             $('#exp_date').val(exp_date);
    //             $('#qty').val(qty);

    //           } else {
    //             $('#exp_date').val('');
    //             $('#qty').val('');
    //           }


    //           $.unblockUI();

    //         },
    //         complete: function() {
    //           $.unblockUI();
    //         },
    //         error: function(data) {

    //           $.unblockUI();
    //         }
    //       })
    //     } else {
    //       $('#exp_date').val('');
    //       $('#qty').val('');
    //       return;
    //     }
    //   }

    function expAdd() {

        var item_id = $('#hd_item_id').val();
        var batch_name = $('#batch_no').val();
        var exp_date = $('#exp_date').val();
        var qty = $('#qty').val();
        var item_p = $('#hidn_item_price').val();
        var item_uom_no_fk = $('#hidn_item_uom_no_fk').val();
        var item_conversion = $('#hidn_item_conversion').val();
        if (qty != "") {
            $('#myTable tr:last').after("<tr class='data_class' data-batch_name='" + batch_name + "' data-exp_date='" +
                exp_date + "' data-qty='" + qty + "' data-item_prices='" + item_p +
                "' data-uom='"+item_uom_no_fk+"'data-conversion='"+item_conversion+"'><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='" +
                batch_name +
                "'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100 date_picker' style='border: none;' value='" +
                exp_date +
                "'></td><td  ><input type='text' name='edit_qty[]' id='edit_sales_qty'  class='text-right w-100 edit_sales_qty' style='border: none;' value='" +
                qty +
                "'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><input type='hidden' name='item_prices[]' value='" +
                item_p + "'><input type='hidden' id='item_uoms_"+item_id+"' name='item_uoms[]' class='item_uoms' value='" +
                item_uom_no_fk + "'><input type='hidden' id='conversion_"+item_id+"' name='conversion[]' class='conversion' value='" +
                item_conversion + "'></td></tr>");

            $('#batch_no').val('');
            $('#exp_date').val('');
            $('#qty').val('');
        } else {
            alert("Invalid value ");
            return;
        }

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        // billingEngine.calculateTotal(this);
        // billingEngine.calculatePayment(this);
        return;
    }
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');


    function saveData(element) {
        let total_qty = 0;
        let sales_qty = $('#sales_qty').val();

        $('.data_class').each(function(tr) {
            let qty = parseFloat($(this).children("td").find(".edit_sales_qty").val());
            // parseFloat($(this).attr('data-qty'));
            var s_qty = parseFloat(qty);
            total_qty += s_qty;

        });


        if (0 < total_qty) {
            var Data = $('#tbody_exp').children('tr');
            let batch_name = [];
            $('.data_class').each(function(tr) {
                // batch_name +=$(this).attr('data-batch_name')+"_"+$(this).attr('data-exp_date')+"_"+$(this).attr('data-qty')+'^';
                batch_name += $(this).attr('data-batch_name') + "_" + $(this).attr('data-exp_date') + "_" + $(
                    this).children("td").find(".edit_sales_qty").val() + "_" + $(this).attr(
                    'data-item_prices') +"_" + $(this).attr('data-uom')+"_"+$(this).attr('data-conversion')+ '^';
            });


            $.ajax({
                data: {
                    batch_name: batch_name
                },
                url: "{{ route('inventory.save-item-expiry-date') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    var item_id = $('#hd_item_id').val();
                    var free_qty = $('#free_quantities_'+item_id).val() !="" ?  $('#free_quantities_'+item_id).val() : 0;
                    var eventstring = new String();
                    eventstring = data.toString().replace(/"/g, "");
                    eventstring = data.toString().replace("[", " ").replace("]", " ").replace(/"/g, "");

                    var exp = eventstring.split(',');

                    var edit_reple = '';
                    edit_reple = eventstring.replace(/,/g, '|');
                    var exp_length = exp.length;
                    var exp_data = '';
                    var exp_rep = '';
                    var eventstr = '';
                    var i;
                    var add_qty = 0;
                    var edit_action = '{{ route('inventory.item-batch-edit', ':id') }}';
                    edit_action = edit_action.replace(':id', sales_qty + ':' + item_id + '^' + edit_reple);
                    for (i = 0; i < exp_length; i++) {
                        eventstr = exp[i].split('_');
                        console.log(eventstr+"bellal hossain");
                        exp_data += "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" +
                            exp[i].toString().replace("_", ",").replace("_", ",") +
                            "</span><input type='hidden' name='txt_expire_date[]' value='" + '' + item_id +
                            '_' + eventstr[1] + "'><input type='hidden' name='txt_batch[]' value='" +
                            item_id + '_' + eventstr[0] +
                            "'><input type='hidden' name='batch_qty[]' value='" + item_id + '_' + eventstr[2] + "'><input type='hidden' id='item_prices_" + item_id +"' name='item_prices[]' value='" + item_id + '_' + eventstr[3] + "'><input type='hidden' id='item_uoms_"+item_id+"' name='item_uoms[]' value='" +item_id + '_' + eventstr[4] + "'><input type='hidden' id='conversion_"+item_id+"' name='conversion[]' value='" + item_id + '_' + eventstr[5] + "'>";
                        var total_expi_qty = parseFloat(eventstr[2]);
                        add_qty += total_expi_qty;
                    }


                    var edit =
                        "<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" +
                        edit_action +
                        "' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit'><i class='fa fa-pencil-alt'></i></span>";

                    eventstr = exp[0].split('_');
                    // console.log(eventstr[3]);
                    var total_price = eventstr[3];

                    $('#exp_itemShow_' + item_id).html(exp_data + edit);
                    $('#item_quantities_' + item_id).val(add_qty - free_qty);
                    $('#hdn_in_total_' + item_id).val((parseFloat(add_qty - free_qty) * parseFloat(total_price))
                        .toFixed(2));
                        console.log("Bellal"+$('#item_rate_container_' + item_id).html());
                    $('#item_rate_container_' + item_id).html("");



                    $('.modal-dialog').modal('hide');

                    $.unblockUI();

                },
                complete: function() {
                    $.unblockUI();
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
            })
        } else {
            alert("Invalid quantity");
            event.stopImmediatePropagation();
        }
    }
</script>
