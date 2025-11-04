<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Upload";
    }

    .custom-file-label::after {
        background-color: #01bfff;
        border-left: 1px solid #01bfff;
        color: #fff;
        font-weight: 500;
        padding: 0.2rem 1rem !important;
        font-size: 13px !important;
        line-height: 23px;
    }

    .upload_label {
        background: #f5f8fa;
        color: #213b61;

    }

    .card-footer {
        background-color: white;
    }

</style>

@php

$data = isset($data) && !empty($data) ? $data : [];

$issue_no_pk = $data ? $data->issue_no_pk : '';
$issue_name = $data ? $data->issue_name : '';
$issue_descriptions = $data ? $data->issue_descriptions : '';
$issue_date = $data ? date('d-m-Y', strtotime($data->issue_date)) : '';
$issue_person_name = $data ? $data->issue_person_name : '';
$issue_document = $data ? $data->issue_document : '';
@endphp
<div class="card">
    <div class="card-body p-2 border-bottom">
        <form action="{{ route('ticket.store') }}" method="post" id="team_create_id" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $issue_no_pk }}">
            <input type="hidden" name="image" value="{{ $issue_document }}">
            <div class="form-row align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="issue_name">Issue Name</label>
                        <input type="text" class="form-control form-control-sm m-0" required name="issue_name"
                            value="{{ $issue_name }}" placeholder="Issue Name">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="issue_date">Issue Date</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" value="{{ date("d-m-Y") }}"  name="issue_date"
                            value="{{ $issue_date }}" placeholder="DD-MM-YYYY">
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        <label for="upload" class="col-form-label col-form-label-sm">Issue Screenshot </label>
                        <div class="input-group">
                            <div class="custom-file mt-1">
                                <input id="upload_img" type="file" class="custom-file-input " name="upload_img">
                                <label class="custom-file-label upload_label" for="upload_img">Please Upload Image</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <img id="show_img" class="img-thumbnail rounded show_img"
                        src="{{ !empty($issue_document) ? url('/images/uploads/issue/file/' . $issue_document) : url('/images/uploads/issue/not_found.jpg') }}"
                        style="width: 100px;height:80px; float: left;" alt="">
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="description">Description</label>
                        <textarea ntype="text" class="form-control form-control-sm m-0" name="description" placeholder="Write Description Here"
                            rows="5">{{ $issue_descriptions }}</textarea>
                    </div>
                </div>
            </div>
            @php
                $response_action = route('ticket.index');
            @endphp
            <div class="card-footer text-right">
                <button type="button" class="btn btn-success btn-md" id="save_update" onclick="saveUpdate(this)"
                    data-func="afterSaveModal" data-response-url="{{ $response_action }}"
                    title="Click here to save Patient Information"> Save
                </button>
            </div>
        </form>

    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $(".date_picker").attr("autocomplete", "off");

    function saveUpdate(element) {
        event.preventDefault();
        var formData = new FormData($('#team_create_id')[0]);
        var formAction = $(element).parents("form").attr("action");
        var formMethod = $(element).parents("form").attr("method");
        var formID = $(element).parents("form").attr("id");

        var customFunc = $("#save_update").attr("data-func");
        if (formValidation(formID) == false) {
            return;
        }
        if (confirm("Are you sure?")) {
            // $('#frm-pat-registration').unbind().submit(function(e) {
            // var formAction = $('#frm-pat-registration').attr("action");
            // var formMethod = $('#frm-pat-registration').attr("method");

            $.ajax({
                type: formMethod,
                url: formAction,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if (customFunc == "") {
                        if (isAModalOpen)
                            $('.modal').modal('hide');

                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>"
                        );
                    }
                    blockUI();
                },
                success: (data) => {
                    // var response_url = $("#save_update").attr(
                    //     "data-response-url") + "/" + data.insert_id;
                    // dynamicFunc.afterSaveModal(response_url,
                    //     "common-modal-sm", "Patient Card");
                    $('#' + formID).find("input, textarea").not('.keep_me').val(
                        "");
                    $('#' + formID).find("select").not('.keep_me').val("0");
                    $('.modal').modal('hide');
                    $(".data-table").DataTable().ajax.reload(null, false);
                    document.querySelector(".show_img").setAttribute("src","");

                },
                error: function(data) {

                },
                complete: function() {
                    alert("Data Save Success");
                    // if (page_type == 'edit')
                    //     dynamicFunc.afterSaveLoadList(
                    //         "{{ route('registration.loadList') }}");
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
            // });

        }

        e.stopImmediatePropagation();
    }
</script>

<script>
    $(document).ready(function(){

        $('#upload_img').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#show_img').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
