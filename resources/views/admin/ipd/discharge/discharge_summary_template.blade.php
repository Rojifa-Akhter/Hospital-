<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">


<style>
    .redactor_box {
        margin-bottom: 0px;
    }



    .card {
        border: 1px solid rgb(164 224 255);
    }

    .pat_hospital_info {
        margin-right: 20px;
    }

    .discharge_template_list .card-body {
        height: 100px;
        overflow-y: auto;
    }
</style>

<div class="container-fluid">
    

   
    <form action="{{ route('ipd.store-discharge-summary-template') }}" method="post" id="dischargeTempForm">@csrf
        <div class="form-row">
<input type="hidden" name="temp_id" value="{{$admission_details->dis_template_no_pk}}">
        <div class="col-md-12">
                    <div class="card-body p-2">
                    <strong>Template Name</strong>
                        <input type="text" class="form-control" id="template_name" name="template_name" value="{{$admission_details->dis_template_name}}">
                    </div>               
            </div>

            <div id="summary_data">
                @include('admin.ipd.discharge.discharge_summary_data')
            </div>

            <div class="card mb-3">
                @php
                $response_action = route('ipd.discharge-template');
                @endphp
                <div class="card-body p-2 text-right">


                    <button type="button" class="btn btn-success btn-sm" onclick="disBtnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"><i class="fa fa-save"></i> Save </button>

                    <button type="button" class="btn btn-info btn-sm" title="Click here to Clear form data" onclick="resetDisForm()">Clear</button>
                    <button type="button" class="btn btn-danger btn-sm" title="Exit" data-dismiss="modal" onclick="resetDisForm()">Exit</button>
                    <!-- <a href="#" class="btn btn-danger btn-sm" rel="tab" title="Click here to go back to Dashboard">Exit</a> -->
                </div>
            </div>
            </div>
    </form>

</div>

<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script>
    function resetDisForm() {
        // $("#frmBilling").find("textarea").not('.keep_me').val("");
        // $("#frmBilling").find("select").not('.keep_me').val("0");
        // $("#net_payable").html("00.00");
        // $("#total_due_con").html("00.00");
        // $("#total_due_data").html("00.00");
        // $("#item_total").html("00.00");
        $("p").html("");
        $("#summary_data").find("textarea, input, select").val("");

        //$("#frmBilling").find("input").val('');
        //$("#frmBilling").find("select").val(0);
        $("tfoot").html('');

        // $("#data-append").find("tr").not('.keep_me').html('');
        // $("#data-append-to").find("tr").not('.keep_me').html('');
    }

    function template(Element) {
        let id = $(Element).attr("data-tempId");
        let app_id = $(Element).attr("data-appId");
        $(".cursor-pointer").removeClass("bg-success");
        $(Element).addClass("bg-success");

        $.ajax({

            data: {
                id: id,
                app_id: app_id
            },
            url: "{{ route('ipd.ipd-discharge-summary-temp')}}",
            type: "post",

            beforeSend: function() {

                blockUI();
            },
            success: function(data) {
                $("#summary_data").html(data);
                loadEditor("discharge_note");
                loadEditor("pre_ot");
                loadEditor("post_ot");
                loadEditor("advice");
                loadEditor("first_baby_note");
                loadEditor("second_baby_note");
                openBillingItemAutocomplete(".item_typehead", "MED,GENERIC", "", selectMedItem);
                openBillingItemAutocomplete(".item_investigation_typehead", item_type = "", item_type_void = "MED,GENERIC",
                    selectInvestigationItem);

                openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_surgeon', 'hdn_pre_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#pre_ot_anaesthetist', 'hdn_pre_ot_anaesthetist', 'doctor_ind', '1');
                openDoctorAutocomplete('#post_ot_anaesthesia', 'hdn_post_ot_anaesthesia', 'doctor_ind', '1');
                openDoctorAutocomplete('#post_ot_surgeon', 'hdn_post_ot_surgeon', 'doctor_ind', '1');
                openDoctorAutocomplete('#post_ot_anaesthetist', 'hdn_post_ot_anaesthetist', 'doctor_ind', '1');
                $('.date_picker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    clearBtn: true
                });
                $('body').on('focus', ".timepicker", function() {
                    $(this).timepicker({
                        // showInputs: false,
                        // showMeridian: false,
                        // setTime: null

                    });
                });


            },
            complete: function() {
                $.unblockUI();
            },
        })
        event.stopImmediatePropagation();

    }

    $('body').on('focus', ".timepicker", function() {
        $(this).timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });
    });

    function disBtnSaveUpdate(thisElement, customFunc = '', responesUrl = '', modalClass = '', modalTitle = '', callback = "", callbackparam = "") {
        event.preventDefault();

        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var seve_temp = $(thisElement).val();
        var template_name = seve_temp ? "" : $('#template_name').val();
        if (seve_temp == "") {
            $('#template_name').attr("required", "required");
        } else {
            $('#template_name').removeAttr("required");
        }  
            var route_data = "{{route('ipd.store-discharge-summary-template')}}";
        
        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: route_data,
                // url: formAction,
                type: formMethod,
                cache: false,
                beforeSend: function() {
                    if (customFunc == "") {
                        if (isAModalOpen)
                            $('.modal').modal('hide');


                    }
                    blockUI();
                },
                success: function(data) {
                    if (customFunc == "") {
                        if (data.title == 'Success') {
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                            $('.common-modal-notify .modal-title').html(data.title);
                            $('.common-modal-notify .modal-body').html(data.msg);
                        } else {
                            $('.common-modal-notify-error').modal('show');
                            $('.common-modal-notify-error .modal-title').html(data.title);
                            $('.common-modal-notify-error .modal-body').html(data.msg);
                        }
                    } else {

                        var response_url = responesUrl + "/" + data.insert_id;
                        if (typeof data.sl != 'undefined') {
                            var response_url = responesUrl + "/" + data.insert_id + "/" + data.sl;
                        }
                        dynamicFunc[customFunc](response_url, modalClass, modalTitle);
                    }

                    // $("#" + formID).find("input, textarea").not('.keep_me').val("");
                    // $("#" + formID).find("select").not('.keep_me').val("0");
                    // $('#doctor_info').html('');
                    // $('#doctor_ref1_info').html('');
                    // $('#doctor_ref2_info').html('');


                    // billingEngine.resetBillForm();

                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();

                if (callback != "")
                    callback(callbackparam);
            });
        }

        event.stopImmediatePropagation();

    }
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    openBillingItemAutocomplete(".item_typehead", "MED,GENERIC", "", selectMedItem);
    openBillingItemAutocomplete(".item_investigation_typehead", item_type = "", item_type_void = "MED,GENERIC",
        selectInvestigationItem);
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1');

    openDoctorAutocomplete('#pre_ot_anaesthesia', 'hdn_pre_ot_anaesthesia', 'doctor_ind', '1');
    openDoctorAutocomplete('#pre_ot_surgeon', 'hdn_pre_ot_surgeon', 'doctor_ind', '1');
    openDoctorAutocomplete('#pre_ot_anaesthetist', 'hdn_pre_ot_anaesthetist', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_anaesthesia', 'hdn_post_ot_anaesthesia', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_surgeon', 'hdn_post_ot_surgeon', 'doctor_ind', '1');
    openDoctorAutocomplete('#post_ot_anaesthetist', 'hdn_post_ot_anaesthetist', 'doctor_ind', '1');
    openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "CHIEFCOM");

    function selectInvestigationItem(item, obj) {
        $('#hdn_investigation_id_1').val(item.item_id);
        $('#hdn_investigation_name_1').val(item.item_name);
        $('#hdn_investigation_type_1').val(item.item_type);

    }


    function selectMedItem(item, obj) {
        $('#hdn_item_id_1').val(item.item_id);
        $('#hdn_item_name_1').val(item.item_name);
        $('#hdn_item_type_1').val(item.item_type);


    }

    function addRow(thisElement) {
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);

        row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
        row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
        row.find('#hdn_item_type_' + oldId).attr('id', 'hdn_item_type_' + newId);
        var item_id = $('#hdn_item_id_' + oldId).val();


        row.find('#hdn_report_serial_med_' + oldId).attr('id', 'hdn_report_serial_med_' + newId);
        row.find('#hdn_medicine_item_id_' + oldId).attr('id', 'hdn_medicine_item_id_' + newId);
        row.find('#medicine_item_' + oldId).attr('id', 'medicine_item_' + newId);
        row.find('#medicine_dose_' + oldId).attr('id', 'medicine_dose_' + newId);
        row.find('#medicine_duration_mu_' + oldId).attr('id', 'medicine_duration_mu_' + newId);
        row.find('#medicine_duration_type_' + oldId).attr('id', 'medicine_duration_type_' + newId);
        row.find('#medicine_quantity_' + oldId).attr('id', 'medicine_quantity_' + newId);
        row.find('#instruction_' + oldId).attr('id', 'instruction_' + newId);
        row.find('#is_continue_' + oldId).attr('id', 'is_continue_' + newId);
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        row.find('#is_continue_' + newId).attr('name', 'is_continue_' + item_id);

        row.find('#hdn_report_serial_med_' + newId).val($(thisElement).parents('tbody').find('#hdn_report_serial_med_' +
            oldId).val());
        row.find('#medicine_dose_' + newId).val($(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val());
        row.find('#instruction_' + newId).val($(thisElement).parents('tbody').find('#instruction_' + oldId).val());

        $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_item_type_' + oldId).val('');



        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');
        // $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
        $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#is_continue_' + oldId).prop('checked', false);

        console.log(newId);


        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function addRowForInvestigation(thisElement) {
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);



        row.find('#hdn_investigation_id_' + oldId).attr('id', 'hdn_investigation_id_' + newId);
        row.find('#hdn_investigation_name_' + oldId).attr('id', 'hdn_investigation_name_' + newId);
        row.find('#hdn_investigation_type_' + oldId).attr('id', 'hdn_investigation_type_' + newId);
        row.find('#investigation_' + oldId).attr('id', 'investigation_' + newId);
        row.find('#investigation_findings_' + oldId).attr('id', 'investigation_findings_' + newId);
        row.find('#investigation_note_' + oldId).attr('id', 'investigation_note_' + newId);
        row.find('#med_fin_td_action_' + oldId).attr('id', 'med_fin_td_action_' + newId);



        $(thisElement).parents('tbody').find('#hdn_investigation_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_investigation_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_investigation_type_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_findings_' + oldId).val('');
        $(thisElement).parents('tbody').find('#investigation_note_' + oldId).val('');

        console.log(newId);


        $(thisElement).parents("#data-append").append(row);

        $('#med_fin_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }



    loadEditor("discharge_note");
    loadEditor("pre_ot");
    loadEditor("post_ot");
    loadEditor("advice");
    loadEditor("first_baby_note");
    loadEditor("second_baby_note");
</script>