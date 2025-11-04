<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

{{-- {{ route('ipd.store-medicine-clinical-info') }} --}}
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Intake Output Form</h5>
            <small>IPD / Nurse Station</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">

            @include('admin.components.patient_info')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-capsules"></i>&nbsp; Intake & Output Chart Information</h5>
                        </div>

                        <div class="card-body">
                            <form id="nurse-station-medicine-details"
                                action="{{ route('ipd-intake-output.store') }}" method="post">@csrf
                                <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
                                    value="{{ $patient_info->patient_no_pk }}">
                                <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
                                    value="{{ $patient_info->admission_no_pk }}">
                                <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
                                    value="{{ $patient_info->admission_uid }}">
                                <div class="d-flex justify-content-center border-bottom pb-2">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission No:
                                        @if (!empty($patient_info->admission_uid))
                                            {{ $patient_info->admission_uid }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        @if (!empty($patient_info->admission_date))
                                            {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department:
                                        @if (!empty($patient_info->admitted_department))
                                            {{ $patient_info->admitted_department }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Ward Name:
                                        @if (!empty($patient_info->ward_name))
                                            {{ $patient_info->ward_name }}
                                        @endif
                                    </span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Name:
                                        @if (!empty($patient_info->bed_name))
                                            {{ $patient_info->bed_name }}
                                        @endif
                                    </span>
                                </div>



                                <div class="form-row border-bottom pb-3">
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label for="clinical_disease" class="col-form-label col-form-label-sm">I/V
                                            </label>
                                            <input type="text" class="form-control mb-0" id="intake_iv"
                                                name="intake_iv" placeholder="Enter I/V Name">
                                        </div>

                                    </div>
                                    @if (Session::get('user.ses_hospital_code') == 'AMCSH')
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label for="clinical_disease" class="col-form-label col-form-label-sm">I/V Fluid Rate(S-I)
                                                </label>
                                                <input type="text" class="form-control mb-0" id="fluid_rate1"
                                                    name="fluid_rate1" placeholder="Enter I/V Fluid Rate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label for="clinical_disease" class="col-form-label col-form-label-sm">I/V Fluid Rate(S-II)
                                                </label>
                                                <input type="text" class="form-control mb-0" id="fluid_rate2"
                                                    name="fluid_rate2" placeholder="Enter I/V Fluid Rate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-0">
                                                <label for="clinical_disease" class="col-form-label col-form-label-sm">I/V Fluid Rate(S-III)
                                                </label>
                                                <input type="text" class="form-control mb-0" id="fluid_rate3"
                                                    name="fluid_rate3" placeholder="Enter I/V Fluid Rate">
                                            </div>
                                        </div>
                                    @endif
                                   

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="intake_iv_amount"
                                                class="col-form-label col-form-label-sm">Amount</label>
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                                id="intake_iv_amount" name="intake_iv_amount" placeholder="Enter Amount "
                                                lookup-code="INVFIND" data-append-id="ot_list">

                                            @php
                                                $class = !empty($pr_arr) ? ' border p-1' : '';
                                            @endphp
                                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list">
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="intake_iv_amount"
                                                class="col-form-label col-form-label-sm">UoM</label>
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                                id="intake_iv_amount_uom" name="intake_iv_amount_uom" placeholder="UoM"
                                                lookup-code="INVFIND" data-append-id="ot_list">

                                            @php
                                                $class = !empty($pr_arr) ? ' border p-1' : '';
                                            @endphp
                                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list">
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="diet_name"
                                                class="col-form-label col-form-label-sm">Route</label>
                                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_route"
                                                id="intake_oral_others" name="intake_oral_others"
                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');">
                                                <option value="0">Select</option>

                                                @if (!empty($route))
                                                    @foreach ($route as $key => $dmu)
                                                        <option value="{{ $key }}">
                                                            {{ $dmu['data'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                    data-popup_header="Medicine Route" data-input_label="Route"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">Add
                                                    More</option>
                                            </select>
                                        </div>

                                        <ul class="list-unstyled mb-0 p-1" id="diet_list"></ul>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="intake_oral_others_amount"
                                                class="col-form-label col-form-label-sm">Amount</label>
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                                id="intake_oral_others_amount" name="intake_oral_others_amount" placeholder="Enter Amount"
                                                lookup-code="INVFIND">

                                            @php
                                                $class = !empty($pr_arr) ? ' border p-1' : '';
                                            @endphp
                                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list">
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="intake_iv_amount"
                                                class="col-form-label col-form-label-sm">UoM</label>
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                                id="intake_oral_others_amount_uom" name="intake_oral_others_amount_uom" placeholder="UoM"
                                                lookup-code="INVFIND" data-append-id="ot_list">

                                            @php
                                                $class = !empty($pr_arr) ? ' border p-1' : '';
                                            @endphp
                                            <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list">
                                            </ul>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-row border-bottom ">
                                    <div class="m-0 mt-3 mb-2 mr-2 ">
                                        @php
                                            $patient_no_pk = $patient_info->patient_no_pk;
                                            $admission_no_pk = $patient_info->admission_no_pk;
                                            $response_url_page = route('ipd-intake-output.index', [$patient_no_pk, $admission_no_pk]);

                                        @endphp

                                        <button
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url_page }}')"
                                            type="button" class="btn btn-success btn-sm"><i class="fa fa-save"></i>
                                            Save</button>
                                        <button type="reset" class="btn btn-info btn-sm"
                                            title="Click here to Clear form data">Clear</button>


                                        <span class="btn btn-danger btn-sm" rel="tab"
                                            title="Click here to dismiss the modal" data-dismiss="modal">Exit</span>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <div class="form-row mt-2" id="patient-details-list">

                                    @include('admin.ipd.intake_output.intake_output_list')

                                </div>
                            </div>



                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>



    <!-- Add New Dose Option Modal -->
    <div class="modal fade" id="addMoreDropdownOption" tabindex="-1" role="dialog"
        aria-labelledby="addMoreDropdownOptionTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" id="newDropdownOptionDiv">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="addMoreDropdownOptionHeader">Header</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="new_dose_opt" id="addMoreDropdownOptionLabel"
                                class="col-form-label col-form-label-sm">Label</label>
                            <input type="hidden" name="thisElement_id" id="thisElement_id" value="">
                            <input type="text" class="form-control" id="new_dropdown_opt" name="new_dropdown_opt"
                                value="" placeholder="Enter new option" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer py-1">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary add_new_option_btn"
                            onclick="prescriptionFunc.addToDropdown(this)">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
    <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                "ordering": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bAutoWidth": false,
                "searching": false,
                "bInfo": false,
            });

            $(".timepicker").timepicker({
                defaultTime: new Date(),
                interval: "5",
            });

            $(".date_picker").datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                clearBtn: true,
            });
            $(".date_picker").datepicker("setDate", new Date());


            openItemAutocompleteWithList($("#service_name"), "SERVICE", "#service_list", "122", "PROCDURE");
            openItemAutocompleteWithList($("#diet_name"), 'FOOD', "#diet_list", "122", "DIET");
            /* openPtaItemAutocomplete("#investigation_item_0", "item_name", "RAD,LAB", function (item, obj) {
                $("#investigation_item_id_0_hidden").val(item.item_id);
                obj.stopImmediatePropagation();
            }); */
            openDoctorAutocomplete("#doctor_name_0", "doctor_id");
            openItemAutocompleteWithList($("#investigation_item"), 'RAD,LAB', "#investigation", "121", "INVFIND");
            openItemAutocompleteWithList($("#ot_item"), "SUR", "#ot_list", "122", "PROCDURE");
            openItemAutocomplete($("#medicine_item_0"), "MED", "#hdn_medicine_item_id_0", "#medicine_item_0");

            $(document).on("click", ".remove-item-btn", function() {
                let med_data = $("#remove-item-btn").attr('data-value-med');
                let admission_data = $("#remove-item-btn").attr('data-value-admission');
                let patient_data = $("#remove-item-btn").attr('data-value-patient');
                if (confirm("Are you sure?")) {
                    $.ajax({
                        async: true,
                        type: "POST",
                        url: "{{ route('ipd.medicine-remove') }}",
                        data: {
                            med_data: med_data,
                            admission_data: admission_data,
                            patient_data: patient_data
                        },
                        dataType: 'html',
                        beforeSend: function() {
                            blockUI();
                        },
                        success: (data) => {
                            alert('Medicine discontinued successfully.')
                            $('#patient-details-list').html(data)
                            $.unblockUI();
                        },
                        error: function(data) {
                            console.log(data);
                            $.unblockUI();
                        },
                    });
                }
            });
        });
    </script>
