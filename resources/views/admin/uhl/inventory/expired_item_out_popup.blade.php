<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<div class="container-fluid">

    <form id="dateUpdate" action="{{ route('v1.expired-item-out-update') }}" method="post">
        @csrf
        <input type="hidden" name="internal_exp_id[]" value="{{$data->internal_batch_no_uq}}">
        <input type="hidden" name="item_id[]" value="{{$data->item_no_fk}}">
        <input type="hidden" name="store_id" value="{{$data->stock_su_no_fk}}">
        <input type="hidden" name="batch[]" value="{{isset($batch)&& $batch !=0 ? $batch :''}}">
        <input type="hidden" name="exp_date[]" value="{{ isset($exp_date)&& $exp_date !=0? $exp_date :''}}">
        <input type="hidden" name="p_price[]" value="{{isset($p_price) && $p_price !=0 ? $p_price :''}}">
        <input type="hidden" name="uom_no_pk[]" value="{{isset($uom_no)&& $uom_no !=0? $uom_no:''}}">
        <input type="hidden" name="hdn_qty[]" id="hdn_qty" value="{{isset($qty)&& $qty !=0? $qty:''}}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table width="100%">
                            <tr>
                                <td><label id="update_expiry_date">Item Name</label></td>
                                <td>{{$data->item_name}}</td>
                            </tr>
                            <tr>
                                <td><label id="update_expiry_date">Internal Batch No</label></td>
                                <td>{{$data->internal_batch_no_uq}}</td>
                            </tr>
                            <tr>
                                <td> <label id="update_expiry_date">Qty.</label></td>
                                <td><input type="text" class="form-control form-control-sm m-0" id="qty" name="qty[]" value="{{$qty}}" autocomplete="off" onkeyup="setQty(this)"></td>
                            </tr>
                            <tr>
                                <td> <label id="update_expiry_date">Remarks</label></td>
                                <td><input type="text" class="form-control form-control-sm m-0" id="remarks" name="remarks[]" value="" autocomplete="off"></td>
                            </tr>

                        </table>


                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="btnSaveUpdateCustom(this)">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    

    function setQty(element) {
        console.log($(element).val() ,parseFloat($('#hdn_qty').val()) );
        if (parseFloat($('#hdn_qty').val()) < parseFloat($(element).val()) || parseFloat($(element).val()) ==0) {
            alert('Invalid Qty.');
            $(element).val($('#hdn_qty').val());
            return false;
        }
    }

    function btnSaveUpdateCustom(
        thisElement,
        customFunc = "",
        responesUrl = "",
        modalClass = "",
        modalTitle = "",
        callback = "",
        callbackparam = ""
    ) {
        event.preventDefault();

        if ($('#qty').val()=='' ||$('#qty').val()==0 ) {
            alert('Enter Qty.');
            return false;
        }
        var formID = $(thisElement)
            .parents("form")
            .attr("id");

        var formAction = $(thisElement)
            .parents("form")
            .attr("action");
        var formMethod = $(thisElement)
            .parents("form")
            .attr("method");

        if (formValidation(formID) == false) {
            return false;
        }
        

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function() {
                    if (customFunc == "") {
                        if (isAModalOpen) $(".modal").modal("hide");
                    }
                    blockUI();
                },
                success: function(data) {

                    $("#" + formID)
                        .find("input, textarea")
                        .not(".keep_me")
                        .val("");
                    $("#" + formID)
                        .find("select")
                        .not(".keep_me")
                        .val("0");
                    $("#doctor_info").html("");
                    $("#doctor_ref1_info").html("");
                    $("#doctor_ref2_info").html("");
                    billingEngine.resetBillForm();
                    searchData($('#btnSearch'));
                    storeWishPrint($('#search_item'))
                },
                complete: function() {},
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText);
                    error_messages = "";
                    for (messages in errors) {
                        console.log(typeof errors[messages]);
                        if (typeof errors[messages] == "object") {

                        } else {
                            var field_name = $("#" + messages)
                                .siblings("label")
                                .html();
                            error_messages +=
                                "<div class='alert alert-danger' role='alert'>" +
                                errors[messages] +
                                "</div>";
                        }
                    }

                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        "Validation Error"
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        error_messages
                    );

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();

                if (callback != "") callback(callbackparam);
            });
        }

        event.stopImmediatePropagation();
    }
</script>