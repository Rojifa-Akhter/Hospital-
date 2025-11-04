<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    #examination ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #examination li {
        list-style: none;
        margin-bottom: 0px;
    }

    #history ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #history li {
        list-style: none;
        margin-bottom: 0px;
    }

    .dataTable tbody tr td {
        padding: 0px;
    }

    .twitter-typeahead {
        width: 98% !important;
    }

    .hidden_cc {
        display: none;
    }

    .hidden_advice {
        display: none;
    }

    .hidden_investigation {
        display: none;
    }

    .hidden_medichine {
        display: none;
    }

    .hidden_current_medichine {
        display: none;
    }

    .hidden_relevent {
        display: none;
    }

    .nav-tabs .nav-link {
        margin-right: -6px !important;
    }
</style>
@php
$add_to_pres_url = route('add-pres-favourit-list');
@endphp

<div class="row border bg-white">
    {{-- <div class="row"> --}}
    <div class="col-md-2 col-lg-2 col-sm-2 p-1 hidden_cc" id="prescriptionPreview"
        style="height: 120px; position: relative; overflow:scroll;">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm">
                Previous Clinical History</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header data-table-ptet-ptte " id="cc_preview">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-lg-2 col-sm-2 p-1 hidden_relevent" id="prescriptionReleventPreview"
        style="height: 120px; position: relative; overflow:scroll;">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm">
                Pre Relevent History</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header data-table-ptet-ptte " id="relevent_preview">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-lg-2 col-sm-2 p-1 hidden_investigation" id="prescriptionInvestigationPreview"
        style="height: 120px; position: relative; overflow:scroll;">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm">
                Pre Investigation</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header data-table-ptet-ptte" id="investigation_preview">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-2 col-lg-2 col-sm-2 p-1 hidden_advice" id="prescriptionAdvicePreview"
        style="height: 120px; position: relative; overflow:scroll;">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm">
                Previous Advice</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header data-table-ptet-ptte " id="advice_preview">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-2 col-lg-2 col-sm-2 p-1 pl-1 hidden_medichine" id="prescriptionMedichinePreview">
        <div class="form-group" style="height: 120px; position: relative; overflow:scroll; ">
            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm"><strong></strong>Past
                Medicine</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header table-bordered" id="medichine_prev">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-lg-2 col-sm-2 p-1 pl-1 hidden_current_medichine" id="currentMedichinePreview">
        <div class="form-group" style="height: 120px; position: relative; overflow:scroll; ">
            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm"><strong></strong>Current
                Medicine</label>
            <div class="bg-white p-1">
                <table class="w-100 details_header table-bordered" id="current_medichine_prev">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{-- </div> --}}
    <div class="col-md-8 col-sm-8 p-1 bg-white border-right" style="min-height: 450px;">
        @php
        $action_url = route('physiotherapy.load-pres-favourit-list-uhl');
        @endphp
        <div>
            <div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="chief-complaint-tab" data-toggle="tab" href="#chief_complaint"
                            role="tab" aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'CHIEFCOM','CC','#chfcom', '{{ $action_url }}','#pres-favourit-list-chief-complaint'), previewTab()">
                            Chief Complaint &nbsp;
                        </a>
                        <a class="nav-link" id="relevant-history-tab" data-toggle="tab" href="#relevant_history"
                            role="tab" aria-controls="home" aria-selected="true" onclick="previewTab()">
                            Relevant History &nbsp;
                        </a>
                        <a class="nav-link" id="investigations-tab" data-toggle="tab" href="#investigations"
                            role="tab" aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'INVFIND','Investigation','#investigation', '{{ $action_url }}','#pres-favourit-list-investigation'), previewTab()">
                            Investigations &nbsp;
                        </a>
                        <a class="nav-link" id="medications-tab" data-toggle="tab" href="#medications" role="tab"
                            aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'MED','Medicine','#data-append-to', '{{ $action_url }}','#pres-favourit-list-med'), previewTab()">
                            Medications &nbsp;
                        </a>

                        <a class="nav-link" id="advices-tab" data-toggle="tab" href="#advices" role="tab"
                            aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'ADVICE','Advice','#adv', '{{ $action_url }}', '#pres-favourit-list-advice'), previewTab()">
                            Advices &nbsp;
                        </a>
                        <a class="nav-link" id="management-plan-tab" data-toggle="tab" href="#management_plan"
                            role="tab" aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'PROCEDURE','Procedure','#proc', '{{ $action_url }}', '#pres-favourit-list-plan'), previewTab()">
                            Management Plan &nbsp;
                        </a>

                        @if (Session::get('user.serviceunit') != 'Anesthesiology')

                        <a class="nav-link" id="ot-plan-tab" data-toggle="tab" href="#ot_plan" role="tab"
                            aria-controls="home" aria-selected="true"
                            onclick="prescriptionV2.loadToPresFavouritListV2(this,'PROCEDURE','Procedure','#ot_list', '{{ $action_url }}', '#pres-favourit-list-ot'), previewTab()">
                            OT / Procedure &nbsp;
                        </a>
                        <a class="nav-link" id="pac-tab" data-toggle="tab" href="#pac" role="tab"
                            aria-controls="home" aria-selected="true" previewTab()">
                            PAC &nbsp;
                        </a>

                        @else
                        <a class="nav-link" id="pac_list-tab" data-toggle="tab" href="#pac_list" role="tab"
                            aria-controls="home" aria-selected="true" previewTab()">
                            PAC Reply &nbsp;
                        </a>
                        @endif

                        <div class="btn-group float-right ml-1 btn_template">
                            <span type="button" class="btn btn-outline-primary btn-sm cursor-pointer dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-file-prescription"></i> Templates
                            </span>
                            <div class="dropdown-menu dropdown-menu-right justify-content-center"
                                id="template-container">
                                <div class="d-flex justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent" style="min-height: 540px;">
                <div class="tab-pane show active fade" id="chief_complaint" role="tabpanel"
                    aria-labelledby="chief-complaint-tab">
                    @include('admin.prescription.uhl.chief_complaint')
                </div>

                <div class="tab-pane fade" id="investigations" role="tabpanel" aria-labelledby="investigations-tab">
                    @include('admin.prescription.uhl.investigations')
                </div>
                <div class="tab-pane fade" id="medications" role="tabpanel" aria-labelledby="medications-tab"
                    style="min-height: 204px; overflow-y: none;">
                    @include('admin.prescription.uhl.medications')
                </div>

                <div class="tab-pane fade" id="relevant_history" role="tabpanel"
                    aria-labelledby="relevant-history-tab">
                    @include('admin.prescription.uhl.relevant_history')
                </div>

                <div class="tab-pane fade" id="clinical_findings" role="tabpanel" aria-labelledby="absent-tab">
                    @include('admin.prescription.uhl.clinical_findings')
                </div>

                <div class="tab-pane fade" id="advices" role="tabpanel" aria-labelledby="advices-tab">
                    @include('admin.prescription.uhl.advice')
                </div>

                <div class="tab-pane fade" id="management_plan" role="tabpanel"
                    aria-labelledby="management-plan-tab">
                    @include('admin.prescription.uhl.management_plan')
                </div>
                @if (Session::get('user.serviceunit') != 'Anesthesiology')
                <div class="tab-pane fade" id="ot_plan" role="tabpanel" aria-labelledby="ot-plan-tab">
                    @include('admin.prescription.uhl.ot')
                </div>
                <div class="tab-pane fade" id="pac" role="tabpanel" aria-labelledby="pac-tab">
                    @include('admin.prescription.uhl.pac')
                </div>


                @else
                <div class="tab-pane fade" id="pac_list" role="tabpanel" aria-labelledby="pac_list-tab">
                    @include('admin.prescription.uhl.pres_pac_list')
                </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="preview-tab" data-toggle="tab" href="#preview" role="tab"
                aria-controls="home" aria-selected="true" onclick="previewTab()"> Preview &nbsp;
            </a>
        </div>
        <div class="tab-pane fade show active" id="preview" role="tabpanel" aria-labelledby="preview-tab">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 mt-3">
                        <div id="chief_complaint_preview"></div>
                        <div id="others_preview"></div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div id="medichine_preview"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        console.log(window.location.href)
    });

    function MenstrualHistoryBtn(element) {
        let body_data = $('.menstrualhistory_data').children().clone();
        // let body_data = $('.menstrualhistory_data').find('input').filter(function() {
        // return $(this).val() !== '' && $(this).val() !== null;
        // }).closest('.col-md-12').clone();
        $('#menstrualhistorybtn_data').html('');
        $('#menstrualhistorybtn_data').html(body_data);
    }

    function ObstetricalHistoryBtn(element) {
        let body_data = $('.obstetricalhistory_data').children().clone();
        $('#obstetricalhistorybtn_data').html('');
        $('#obstetricalhistorybtn_data').html(body_data);
    }

    function ContraceptiveHistoryBtn(element) {
        let body_data = $('.contraceptive_data').children().clone();
        $('#contraceptivehistorybtn_data').html('');
        $('#contraceptivehistorybtn_data').html(body_data);
    }

    function DrugHistoryBtn(element) {
        let body_data = $('.drug_data').children().clone();
        $('#drughistorybtn_data').html('');
        $('#drughistorybtn_data').html(body_data);
    }

    function SurgicalHistoryBtn(element) {
        let body_data = $('.surgical_data').children().clone();
        $('#surgicalhistorybtn_data').html('');
        $('#surgicalhistorybtn_data').html(body_data);
    }

    function MedicalHistoryBtn(element) {
        let body_data = $('.medical_data').children().clone();
        $('#medicalhistorybtn_data').html('');
        $('#medicalhistorybtn_data').html(body_data);
    }

    function ClinicalExaminationBtn(element) {
        let body_data = $('.clinicalexamination_data').children().clone();
        $('#clinicalexaminationbtn_data').html('');
        $('#clinicalexaminationbtn_data').html(body_data);
    }


    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }

    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });
    $('.date_picker_1').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy',
    });

    $('#ot_date_time').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd/mm/yyyy',
    });

    function saveExamination() {
        var pre = '';
        $("#examination").html("");
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#examination").append(pre);

        $("#test345 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";

            if (item_name != undefined) {
                if (pre != lookupdata_code) {
                    var lookup_data = "<    li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);
            }


            $("#examination").append(lookup_data);
        });
        pre = '</ul>';
        $("#examination").append(pre);
    }

    function saveMenstrual() {
        var pre = '';
        $("#history").html('');
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#history").append(pre);
        $("#test123 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";


            if (item_name != undefined) {
                if (pre != lookupdata_code) {
                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);

            }

            $("#history").append(lookup_data);
        });
        pre += '</ul>';
        $("#history").append(pre);


    }


    $(document).ready(function() {

        $('.date_picker_app').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            autoclose: true,
        }).on('changeDate', function(e) {
            var selected_date = new Date(e.date.toString());

            var today = new Date();

            var todayDate = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
            var selected = (selected_date.getMonth() + 1) + "/" + selected_date.getDate() + "/" +
                selected_date.getFullYear();
            const date1 = new Date(todayDate);
            const date2 = new Date(selected);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            console.log(diffTime + " milliseconds");
            console.log(diffDays + " days");

            $("#followup_after").val(diffDays);
            $("#followup_after_mu").val("DAY");
        });

        teeth_autocomplete.init();

    });

    function favoriteListSearch(thisElement) {
        const prescriptionData = $(thisElement).val()
        const itemType = $(thisElement).attr('searcAttrvalue')

        $.ajax({
            async: true,
            data: {
                prescriptionData: prescriptionData,
                itemType: itemType
            },
            url: "../public/prescription-favorite-worklist-search-data",
            type: "post",

            beforeSend: function() {
                // blockUI();
            },
            success: function(item) {
                $("#pres-favourit-list").html(item);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }


    function dept(item, obj) {
        console.log(item)
        console.log(item.su_name)
        $(".department_name").val(item.su_name)
        $('#doc_dept').find(":selected").val(item.serviceunit_no_fk);
        $('#doc_dept').find(":selected").text(item.su_name);
    }

    function deptOtAneas(item, obj) {
        console.log(item)
        console.log(item.su_name)
        $("#referDept").val(item.su_name)
    }

    function deptWiseDoctor(thisElement) {
        var deptValue = $(thisElement).val();
        var title = 'Department Wise Doctor List';
        $.ajax({
            data: {
                deptValue: deptValue
            },
            url: "{{ url('prescription-department-wise-doctor') }}",
            type: 'post',
            beforeSend: function() {
                // blockUI();
            },
            success: function(data) {
                $('#dept_doctor_list_modal').html(data)
                $('#myModal').modal("show");
                $('#modal-title').html(title);
            },
            complete: function() {
                // $.unblockUI();
            }
        });

    }

    $('#txt_referred_doctor').on('input', function() {
        if ($(this).val() === '') {
            $('#ref_doc_card_hidn').val('');
        }
    });

    $('#referredToAnesthesia').change(function() {
        if ($(this).is(':checked')) {
            $('#anesthesiaInfoContainer').html(
                '<h2 style="color: green; font-weight: bold;">Refer to Anesthesia Department</h2>');
        } else {
            $('#anesthesiaInfoContainer').empty();
        }
    });




    $(document).on('click', "input[name='ot_time[]']", function() {
        // Uncheck all other checkboxes in the group
        $("input[name='ot_time[]']").not(this).prop('checked', false);

        // Update hidden input with selected slot ID or clear if none
        const selected = $(this).is(':checked') ? this.value : '';
        $("#ot_slot_id").val(selected);
        const labelText = $(this).closest('tr').find('label[for="' + this.id + '"]').text().trim();
        const startTime = labelText.split(' - ')[0].trim();
        $("#procedureTime").val(startTime);

        // Optional: notify if none selected
        if (!selected) {
            alert('Please select a schedule!');
        }
    });


    $(function() {
        $("#ot_date_time").on("change", function() {
            const parts = this.value.split("/");
            if (parts.length !== 3) return; // invalid format

            const [day, month, year] = parts.map(s => s.padStart(2, "0"));
            const iso = `${year}-${month}-${day}`; // convert to "YYYY‑MM‑DD"

            // HTML date input accepts ISO format exactly :contentReference[oaicite:1]{index=1}
            $("#procedureDate").val(iso);
        });
    });



    openItemAutocompleteWithList($('#investigation_item'), 'RAD,LAB,SUR,PROCEDURE,PROC', "#investigation", "121",
        "INVFIND");

    openLookupAutocompleteV2("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHIEFCOM", "#chfcom");

    openLookupAutocompleteV2("#provisional_diag", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "PROVDIAG", "#prov_diag");

    openLookupAutocompleteV2("#history_of_objective", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CLINICHIST", "#ho");

    openLookupAutocompleteV2("#desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE",
        "#desease_con");

    openLookupAutocompleteV2("#icd", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ICD", "#icd_con");

    openLookupAutocompleteV2("#chronic_desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHRDISEASE", "#chronic_des");
    openLookupAutocompleteV2("#advice", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ADVICE", "#adv");

    openLookupAutocomplete("#disposal_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISPOSAL",
        "#disposal");

    // openLookupAutocomplete("#procedure_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "PROCEDURE",
    //     "#proc");
    // openLookupAutocomplete("#ot_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "PROCEDURE,SUR",
    //     "#ot_list");
    // openLookupAutocomplete("#instruction_0", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "INSTRUCTION",
    //     "#ins");
    // openItemAutocompleteWithList($("#procedure_item"), 'SERVICE,SUR', "#proc", "122", "PROCEDURE");
    // openLookupAutocomplete("#investigation_findings", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
    //     "INVFIND", "#investigation_find_con");

    // openOPDPrescriptionAutocomplete($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0', );
    openItemAutocompleteWithStockPrescription($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0',
        '#medicine_item_0',
        function(data) {
            $("#hdn_genetic_id_0").val(data.generic_name)
        });
    openItemAutocompletePTET($("#et_item_name_1"), 'PTET', "#et_hdn_item_id_1", "#et_hdn_item_name_1", "202",
        "PTET"); // 3 = SERVICE ITEM TYPE
    openItemAutocompleteACUP($("#acup_item_name_1"), 'ACUP', "#hdn_item_id_1", "#hdn_item_name_1", "242",
        "ACUP"); // 3 = SERVICE ITEM TYPE
    openItemAutocompletePTTE($("#te_item_name_1"), 'PTTE', "#te_hdn_item_id_1", "#te_hdn_item_name_1", "203",
        "PTTE"); // 3 = SERVICE ITEM TYPE

    openDoctorAutocompleteAll('#txt_referred_doctor', 'ref_doc_card_hidn', 'doctor_ind', '1', dept);
    openItemAutocompleteWithList($("#ot_item"), "SUR,PROC", "#ot_list", "122", "PROC"); //PROCDURE

    openDoctorAutocompleteAll('#referringDoctor', 'refhdnDoc', 'doctor_ind', '1', deptOtAneas);

    openDoctorAutocomplete('#referral_doctor', 'ref_doc');
</script>
