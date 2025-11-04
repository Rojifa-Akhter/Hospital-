<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .tt-input2 {
        background-color: #eceff2 !important;
    }

    select[disabled],
    input[disabled] {
        opacity: 0.5 !important;
    }

</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Stock Misc. Consumption/Issue</h5>
            <small>Store /Stock Misc. Consumption/Issue</small>
        </div>
        <div class="col-md-3 mt-2">
            <div id="top-action">

                {{-- <a rel="tab" href="{{ url('inventory/item-received-worklist') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Item Recieve
                    List</a> --}}

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-plus"></i> Stock Misc. Consumption/Issue </h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('store_stock_consumption') }}" id="stock_adjustment"
                        method="post">
                        @csrf
                        <input type="hidden" name="receive_type" value="chalan">


                        <div class="row ">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center align-items-center">
                                    <div class="col-md-1">
                                        <label class="col-form-label col-form-label-sm" style="margin-top: 11px;"
                                            for="store_name">Issue From
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm">&nbsp;</label>

                                            <select class="form-control select2" id="store_from" name="store_from">
                                                <option value="">Select Store</option>
                                                
                                                @if (isset($my_stores) && !empty($my_stores))
                                                    @foreach ($my_stores as $store)
                                                        <option value="{{ $store->su_no_fk }}">{{ $store->serviceunit_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <label class="col-form-label col-form-label-sm" style="margin-top: 11px;"
                                            for="store_name">Issue To
                                        </label>
                                    </div>
                                    <div class="col-md-1 from-group">
                                        <label class="col-form-label col-form-label-sm">Store</label>&nbsp
                                        <input type="radio" title="Event" id="store_radio" name="issue_type" checked>
                                        <select class="form-control select2" id="store_to" name="store_to">
                                            <option value="">Select Store</option>
                                            @if (!empty($all_stores))
                                                @foreach ($all_stores as $store)
                                                    <option value="{{ $store->serviceunit_no_pk }}">{{ $store->serviceunit_name }}
                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-md-2 from-group">
                                        <label class="col-form-label col-form-label-sm">Events</label>&nbsp
                                        <input type="radio" title="Event" id="events_radio" name="issue_type">
                                        <select class="form-control select2" id="events" name="events" disabled>
                                            <option value="">Select Event</option>
                                            @if (!empty($event))
                                                @foreach ($event as $key => $value)
                                                    <option value="{{ $key }}_{{ $value }}">
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-2 from-group">
                                        <label class="col-form-label col-form-label-sm">Others Name</label>
                                        <input type="text" class="form-control" id="others_name" name="others_name"
                                            value="" disabled>
                                    </div>
                                    <div class="form-group  col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="date">Patient </label>
                                        <input type="radio" title="Event" id="patient_radio" name="issue_type">
                                        <input type="text" class="form-control form-control-sm m-0 " id="paitent_info"
                                            name="paitent_info" value="" autocomplete="" disabled>
                                        <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="">
                                    </div>
                                    <div class="form-group  col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="date">Employee </label>
                                        <input type="radio" title="Event" id="doctor_radio" name="issue_type">
                                        <input type="text" class="form-control" id="doctor_code" name="doctor_code"
                                            placeholder="" disabled
                                            title="Search by Code/ Name/ Mobile/ Specialization">
                                        <input type="hidden" class="form-control" id="hdn_doctor_id"
                                            name="hdn_doctor_id" value="">
                                    </div>
                                    <div class="form-group  col-md-1">
                                        <label class="col-form-label col-form-label-sm" for="date">Referance </label>
                                        <input type="text" class="form-control form-control-sm m-0 " id="referance"
                                            name="referance" value="" autocomplete="">
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row justify-content-center d-flex">
                                    <div class="form-group  col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="date">Date <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="date" name="date" value="" autocomplete="off" placeholder="yyyy-mm-dd">
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="col-form-label col-form-label-sm" for="item_name">Item
                                            Name</label>
                                        <input type="hidden" name="item_id_hidden" id="item_id_hidden">
                                        <input type="hidden" class="form-control form-control-sm m-0" id="item_code"
                                            name="item_code" value="">
                                        <input type="hidden" class="form-control form-control-sm m-0"
                                            id="item_expireable_ind" name="item_expireable_ind" value="">
                                        <input type="text" class="form-control form-control-sm m-0" id="item_name"
                                            name="item_name" value="" placeholder="Item Name">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_uom">Item
                                            UoM</label>
                                        <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
                                        <input type="text" class="form-control form-control-sm m-0" id="item_uom"
                                            name="item_uom" value="" placeholder="Item UoM">
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="item_quantity">Item
                                            Quantity</label>
                                        <input type="text"
                                            class="form-control form-control-sm m-0 text-right number_only"
                                            id="item_quantity" name="item_quantity" value=""
                                            placeholder="Item Quantity">
                                    </div>


                                    <div class="form-group col-md-2">
                                        <button type="button" id="add_item_btn"
                                            class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-plus"></i>
                                            Add
                                            Item</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive mt-3">
                                <table class="table  table-striped table-bordered table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center ">SL</th>
                                            <th class="text-center">Item Code</th>
                                            {{-- <th class="text-center">Barcode</th> --}}
                                            <th class="text-center">Item Name</th>
                                            <th class="text-center">UoM</th>
                                            {{-- <th class="text-center ">Rate</th> --}}
                                            <th class="text-center ">Item Quantity</th>
                                            {{-- <th class="text-right width-100">Amount</th> --}}
                                            <th class="text-center ">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="adjust_worklist">

                                    </tbody>
                                </table>
                            </div>
                        </div>



                        <div class="row">
                            @php
                                $response_action = route('stock_consumption');
                            @endphp
                            <div class="col-12 text-right">

                                <button type="submit"
                                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                    class="btn btn-success btn-md"><i class="fa fa-save"></i> Save
                                </button>


                                <button type="reset" class="btn btn-info btn-md"
                                    title="Click here to Clear form data">Clear
                                </button>

                                <a href="#" class="btn btn-danger btn-md" rel="tab"
                                    title="Click here to go back to Dashboard">Exit</a>

                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("#store_radio").on('click', function() {
        $('#paitent_info').prop("disabled", true);
        $('#store_to').prop("disabled", false);
        $("#paitent_info").removeClass('tt-input1');
        $('#events').prop("disabled", true);
        $('#others_name').prop("disabled", true);
        $('#doctor_code').prop("disabled", true);

        $("#events").val('');
        $("#others_name").val('');
        $("#hdn_patient_id").val('');
        $("#hdn_doctor_id").val('');
        $("#doctor_code").val('');
    });
    $("#events_radio").on('click', function() {
        $('#paitent_info').prop("disabled", true);
        $("#paitent_info").removeClass('tt-input1');
        $('#store_to').prop("disabled", true);
        $('#doctor_code').prop("disabled", true);
        $('#events').prop("disabled", false);
        $('#others_name').prop("disabled", false);
        $("#store_to").val('');
        $("#hdn_patient_id").val('');
        $("#doctor_code").val('');
        $("#hdn_doctor_id").val('');

    });
    $("#patient_radio").on('click', function() {
        $('#paitent_info').prop("disabled", false);
        $("#paitent_info").addClass('tt-input1');
        $('#store_to').prop("disabled", true);
        $('#doctor_code').prop("disabled", true);
        $('#events').prop("disabled", true);
        $('#others_name').prop("disabled", true);
        $("#others_name").val('');
        $("#events").val('');
        $("#store_to").val('');
        $("#doctor_code").val('');
        $("#hdn_doctor_id").val('');
    });
    $("#doctor_radio").on('click', function() {
        $('#doctor_code').prop("disabled", false);
        $("#doctor_code").addClass('tt-input1');
        $('#paitent_info').prop("disabled", true);
        $('#store_to').prop("disabled", true);
        $('#events').prop("disabled", true);
        $('#others_name').prop("disabled", true);
        $("#others_name").val('');
        $("#events").val('');
        $("#store_to").val('');
        $("#hdn_doctor_id").val('');
    });

    function showExpDate(element) {
        var item_id = $(element).parents("tr").find(".item_id").val();
        var sales_qty = $("#hdn_item_qnty_" + item_id).val();
        // var sales_qty = salesQty(element);


        if (sales_qty > 0) {
            var qty = sales_qty;
            var su_unit_no = $('#store_from').val();
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
                    console.log(values);
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
                                "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" +
                                exp[
                                    i] +
                                "</span><input type='hidden' name='txt_expire_date[]' value='" +
                                item_id + '_' + eventstr[1] +
                                "'><input type='hidden' name='txt_batch[]' value='" + item_id +
                                '_' +
                                eventstr[0] +
                                "'><input type='hidden' name='batch_qty[]' value='" +
                                item_id + '_' + eventstr[2] + "'>";
                            var total_expi_qty = parseFloat(eventstr[2]);
                            add_qty += total_expi_qty;

                        }
                        var edit_action = '{{ route('billing.pos-expire-edit', ':id') }}';
                        edit_action = edit_action.replace(':id', add_qty + ':' + item_id + '^' +
                            eventstring);

                        var edit =
                            "<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" +
                            edit_action +
                            "' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit' onclick='showExpDate(this)'><i class='fa fa-pencil-alt'></i></span>";
                        $('#exp_show_' + item_id).html(exp_data + edit);
                        $('#hdn_item_qnty_' + item_id).val(add_qty);


                    } else {
                        alert("Batch not found");
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
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[
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



    $(document).ready(function() {

        $("#item_quantity").blur(function() {
            var item_price = $("#item_price").val();
            var item_quantity = $('#item_quantity').val();

            var in_total = Number(item_price) * Number(item_quantity);
            $("#in_total").val(in_total);
        });


        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();

        });

        // openItemAutocomplete('#item_name');

        openReceiveItemAutocomplete('#item_name', '','item_name', function(item, obj) {

            console.log(item.uom_no_fk);
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            $('#item_code').val(item.item_code);
            $('#item_expireable_ind').val(item.expireable);

            $('#item_price').val(item.purchase_price);
            $('#sales_price').val(item.item_rate);
            // $('#item_id').val(item.item_id);
            obj.stopImmediatePropagation();
        });

        function clearqty(element) {
            var item_id = $(element).attr('data-id');
            $("#exp_show_" + item_id).html("");
        }

        $(document).on('click', '#add_item_btn', function(e) {
            e.preventDefault()


            var pvms_no = $('#pvms_no').val();
            var item_name = $('#item_name').val();
            var item_id = $('#item_id').val();
            var item_code = $('#item_code').val();

            var item_id = $('#item_id_hidden').val();
            var item_uom_name = $('#item_uom').val();
            var item_uom_no = $('#item_uom_hidden').val();
            var item_quantity = $('#item_quantity').val();
            var item_price = $('#item_price').val();
            var sales_price = $('#sales_price').val();
            var purchase_price = $('#purchase_price').val();
            var in_total = $('#in_total').val();
            var item_expireable_ind = $('#item_expireable_ind').val();
            $('textbox').removeAttr('readonly').val('Changed Value');


            if (item_id == '' || item_name == '') {
                alert('Item name cannot be blank.')
                return false
                e.stopImmediatePropagation();
            }
            var same_item = false
            $('input[class=same-item-id]').each(function(index, elem) {
                if ($(elem).val() == item_id) {
                    same_item = true
                    return false
                }
            })
            if (same_item == true) {
                alert('You have already taken this item.')
                $('#pvms_no').val('');
                $('#item_id').val('');
                $('#item_code').val('');
                $('#item_name').val('');
                $('#item_id_hidden').val('');
                $('#item_uom').val('');
                $('#item_uom_hidden').val('');
                $('#item_quantity').val('');
                $('#item_price').val('');
                $('#sales_price').val('');
                $('#in_total').val('');
                e.stopImmediatePropagation();
                return false
            }
            var expiry_date = item_expireable_ind == 1 ?
                "<span Class='btn btn-sm btn-warning open-modal ' data-id=''    title='Batch' onclick='showExpDate(this)'><i class='fas fa-circle' ></i></span>" :
                "";

            var row = '<tr>' +
                '<td class="sl-td">0</td>' +
                '<td class="text-center"> <input type="hidden" class="item_id"  name="item_id[]" value="' +
                item_id +
                '">' + item_code +
                '</td>' +
                '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="' +
                item_id +
                '">' + item_name + ' <br><span id="exp_show_' + item_id +
                '"><input type="hidden" name="txt_expire_date[]" value="' + item_id + '_' + 0 +
                '"><input type="hidden" name="txt_batch[]" value="' + item_id + '_' + 0 +
                '"><input type="hidden" name="batch_qty[]" value="">  </span> </td>' +
                '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="' +
                item_uom_no + '">' +
                item_uom_name + '</td>' +
                '<td class="text-center"> <input type="text text-right" onkeyup="clearqty(this)" data-id="' +
                item_id + '" id="hdn_item_qnty_' + item_id +
                '"   name="item_quantities[]" value="' +
                item_quantity + '">&nbsp;' + expiry_date + '</td>' +
                '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>' +
                '</tr>';



            $('#adjust_worklist').append(row);

            $('#pvms_no').val('');
            $('#item_name').val('');
            $('#item_id').val('');
            $('#item_code').val('');
            $('#item_id_hidden').val('');
            $('#item_uom').val('');
            $('#item_uom_hidden').val('');
            $('#item_quantity').val('');
            $('#item_price').val(0);
            $('#sales_price').val(0);
            $('#in_total').val(0);

            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            });

            e.stopImmediatePropagation();

        });

        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            $('.sl-td').each(function(index, elem) {
                $(elem).text(index + 1);
            })
            e.stopImmediatePropagation();
        });

    });
    $("#store_to").on("change", function(e) {
        $("#events").val('');
        $("#others_name").val('');
        $("#hdn_patient_id").val('');
    });
    $("#events").on("change", function(e) {
        $("#store_to").val('');
        $("#hdn_patient_id").val('');
        var event_arr = $(this).val();
        var event_dts = event_arr.split('_');
        $("#others_name").val(event_dts[1]);

    });

    function calculateTotal(element, price) {
        var total = price * $(element).val();
        $(element).parent().next().find(".item_list").html(total);
    }
    openPatientAutocomplete('#paitent_info', 'patient_name', function(item, obj) {
        $("#others_name").val('');
        $("#events").val('');
        $("#store_to").val('');
        obj.stopImmediatePropagation();
    });
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'employee_ind', '1', function(item, obj) {
        $("#others_name").val('');
        $("#events").val('');
        $("#store_to").val('');
        obj.stopImmediatePropagation();
    });
</script>
