@php

$data = isset($data) && !empty($data) ? $data : [];

$leave_no_pk = $data ? $data->leave_no_pk : '';

@endphp
<div class="card">
    <div class="card-body p-2 border-bottom">
        <form action="{{ route('leavelist.hr.app') }}" method="POST" enctype="multipart/form-data" id="dep_app_form">
            @csrf
            <input type="hidden" name="approved_dept_ind" value="{{ $leave_no_pk }}">
            <input type="hidden" name="dep_app_id" value="1">
            <div class="form-row align-items-center justify-content-center">
                <div class="col-md-12">

                    <label class="col-form-label col-form-label-sm" for="dep_approval_note">Approval notes</label>
                    <textarea ntype="text" class="form-control form-control-sm m-0" name="dep_approval_note"
                        placeholder="Write Description Here" rows="5"></textarea>

                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-success btn-md" id="save_update" onclick="saveUpdateDataHr(this)"
                                data-func="afterSaveModal"> Approve</button>
                        </div>

                </div>
            </div>
        </form>

        <form action="{{ route('leavelist.hr.rej') }}" method="POST" enctype="multipart/form-data" id="dep_rej_form">
            @csrf
            <input type="hidden" name="approved_dept_ind" value="{{ $leave_no_pk }}">
            <input type="hidden" name="dep_rej_id" value="2">
            <div class="form-row align-items-center justify-content-center">
                <div class="col-md-12">

                    <label class="col-form-label col-form-label-sm" for="dep_reject_note">Reject notes</label>
                    <textarea ntype="text" class="form-control form-control-sm m-0" name="dep_reject_note"
                        placeholder="Write Description Here" rows="5"></textarea>

                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-danger btn-md" id="save_update" onclick="saveUpdateDataHr(this)"
                                data-func="afterSaveModal"> Reject</button>
                        </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function saveUpdateDataHr(element) {
        event.preventDefault();
        var formAction = $(element).parents("form").attr("action");
        var formID = $(element).parents("form").attr("id");
        var formData = new FormData($('#'+formID)[0]);
        var formMethod = $(element).parents("form").attr("method");

        if (formValidation(formID) == false) {
            return;
        }
        if (confirm("Are you sure?")) {
            $.ajax({
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: (data) => {
                    $('#' + formID).find("input, textarea").not('.keep_me').val(
                        "");
                    $('#' + formID).find("select").not('.keep_me').val("0");
                    $('.modal').modal('hide');
                    $(".data-table").DataTable().ajax.reload(null, false);
                },
                error: function(data) {

                },
                complete: function() {
                    alert("Data Save Success");
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText)
                        .errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings(
                                "label")
                            .html();
                        error_messages +=
                            "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html(
                        "Validation Error");
                    $('.common-modal-notify-error .modal-body').html(
                        error_messages);
                    finished = false;
                    $.unblockUI();
                }
            });

        }
    }
</script>
