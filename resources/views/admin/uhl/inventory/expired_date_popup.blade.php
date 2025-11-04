<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<div class="container-fluid">

    <form id="dateUpdate" action="{{ route('v1.expired-date-update') }}" method="post">
        @csrf
        <input type="hidden" name="internal_exp_id" value="{{$data->internal_batch_no_uq}}">
        <input type="hidden" name="item_no_fk" value="{{$data->item_no_fk}}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <label id="update_expiry_date">Expiry Date</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="update_expiry_date" name="update_expiry_date" value="{{$data->expiry_date !='' ? date('d-m-Y',strtotime($data->expiry_date)) : ''}}" placeholder="dd-mm-yyyy" autocomplete="off">
                        <label id="batch_no">Batch No</label>
                        <input type="text" class="form-control form-control-sm m-0 " id="batch_no" name="batch_no" value="{{$data->batch_no !='' ? $data->batch_no  : ''}}"  autocomplete="off">
                        <label id="sales_price">Sales Price</label>
                        <input type="text" class="form-control form-control-sm m-0 " id="sales_price" name="sales_price" value="{{$data->sales_price !='' ? $data->sales_price  : ''}}"  autocomplete="off">
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