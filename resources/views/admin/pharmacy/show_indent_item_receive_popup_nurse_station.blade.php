<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<?php $date = date('d-m-Y'); ?>
<div class="row">


    <div class="col-sm-12 col-lg-12 col-xl-12">
        <table width="100%">
            <tr>
                <td>Item Name : <strong> {{ $item_name->item_name }} </strong></td>
                <td style="text-align: right;">Receive qty : <strong> {{ $qty }} </strong></td>

            </tr>
        </table>

        <select name="auto_batch" id="auto_batch" onchange="auto_batch(this)" class="select2 form-control">
            <option value="">select</option>
            @if (isset($recive_qty) && !empty($recive_qty))
                @foreach ($recive_qty  as $value )
                        <option value="{{$value->batch_no.'_'.date("d-m-Y" , strtotime($value->expiry_date))}}">{{$value->batch_no .' ( '. date("d-m-Y" ,strtotime($value->expiry_date)) .' ) ' }}</option>
                @endforeach
            @endif
        </select>
        <form action="{{ route('update_item_issue_nurse_station') }}" method="post" id="show-indent-item-pop-up">
            {{-- update_indent --}}

            @csrf
            <input type="hidden" name="item_id" id="hd_item_id" value="{{ $item_id }}">
            <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
            <input type="hidden" id="sales_qty" name="sales_qty" value="{{ $qty }}">
            <input type="hidden" id="hidn_item_price" name="item_price" value="{{ $item_name->purchase_price }}">
            <input type="hidden" id="hidn_item_uom" name="item_uom" value="{{ $item_name->uom_no_fk }}">
            <input type="hidden" id="in_itemtype_no_fk" name="in_itemtype_no_fk" value="{{ $item_name->itemtype_no_fk }}">
            <input type="hidden" id="hidn_item_uom" name="to_store_id" value="{{ $to_store_id }}">
            <input type="hidden" id="hidn_item_uom" name="from_store_id" value="{{ $from_store_id }}">
            <input type="hidden" id="hidn_item_uom" name="indent" value="{{ $indent }}">
            <input type="hidden" id="item_name" name="item_name" value="{{ $item_name->item_name}}">



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
                                placeholder="Batch No" value="" readonly />
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm m-0 date_picker" id="exp_date"
                                name="exp_date" placeholder="dd-mm-yyyy" value="" readonly />
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
                            $expiry = $exp;
                            $expiry_count = count($expiry);

                            $i = 0;
                        @endphp

                        @for ($i = 0; $i < $expiry_count; $i++)
                            @php $exp_data=explode(',' , $expiry[$i]); @endphp <tr class="data_class" data-batch_name='{{ $exp_data[0] }}'
                                data-exp_date='{{ $exp_data[1] }}' data-qty='{{ $exp_data[2] }}'
                                data-item_prices='{{ $exp_data[3] }}'>
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
            <div class="p-10">
                <label for="patient_id"><strong>Transit By </strong> <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="" id="patient_id" required>
                <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id" value="">
            </div>

            @php
                if ($type == 1) {

                    $response_action =route('item_issue_worklist_nurse_station');
                    // Session::get('current_route');
                    // dd($response_action);
                } else {

                    $response_action = route('pharmacy_indent_worklist');
                }

            @endphp
            <div class="text-left mt-5">
                <button type="button" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', reloadPage)">
                    Save
                </button>
                {{-- onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> --}}
                <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
                <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
            </div>


        </form>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $('.select2').select2();

    function auto_batch(element) {
        var value=$(element).find(':selected').val();
        var spl_batch_date=value.split('_');
        $('#batch_no').val(spl_batch_date[0]);
        $('#exp_date').val(spl_batch_date[1]);
        console.log(value);
    }
    function reloadPage() {
        var url='{{ route("serach_worklist_nurse_station") }}';

        console.log(url+'_bellal');
        generateSearch( "", 'worklist-search',url , 'iuw' );
    }
    openDoctorAutocomplete('#patient_id', 'hdn_doctor_id', 'employee_ind', '1');
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

        var batch_name = $('#batch_no').val();
        var exp_date = $('#exp_date').val();
        var qty = $('#qty').val();
        var item_p = $('#hidn_item_price').val();
        if (qty != "") {
            $('#myTable tr:last').after("<tr class='data_class' data-batch_name='" + batch_name + "' data-exp_date='" +
                exp_date + "' data-qty='" + qty + "' data-item_prices='" + item_p +
                "'><td ><input type='text' style='border:none;' name='item_batch_name[]' id='edit_batch_name' readonly='readonly'  value='" +
                batch_name +
                "'></td><td ><input type='text' name='exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100 date_picker' style='border: none;' value='" +
                exp_date +
                "'></td><td  ><input type='text' name='item_qty[]' id='edit_sales_qty'  class='text-right w-100 edit_sales_qty' style='border: none;' value='" +
                qty +
                "'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><input type='hidden' name='item_prices[]' value='" +
                item_p + "'></td></tr>");

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
                    'data-item_prices') + '^';
            });


            $.ajax({
                data: {
                    batch_name: batch_name
                },
                url: "{{ route('update_item_issue_nurse_station') }}",
                // url: "{{ route('inventory.save-item-expiry-date') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    var item_id = $('#hd_item_id').val();

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
                        exp_data += "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" +
                            exp[i].toString().replace("_", ",").replace("_", ",") +
                            "</span><input type='hidden' name='txt_expire_date[]' value='" + '' + item_id +
                            '_' + eventstr[1] + "'><input type='hidden' name='txt_batch[]' value='" +
                            item_id + '_' + eventstr[0] +
                            "'><input type='hidden' name='batch_qty[]' value='" + item_id + '_' + eventstr[
                                2] + "'><input type='hidden' id='item_prices_" + item_id +
                            "' name='item_prices[]' value='" + item_id + '_' + eventstr[3] + "'>";
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
                    $('#item_quantities_' + item_id).val(add_qty);
                    $('#hdn_in_total_' + item_id).val(parseFloat(add_qty) * parseFloat(total_price));
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
