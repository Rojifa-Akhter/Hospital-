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
            <h5 class="mt-2 mb-0">Vital Details</h5>
            <small>IPD / Nurse Station / Vital Details</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            @include('admin.components.patient_info')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-capsules"></i>&nbsp; Patient Clinical Information</h5>
                        </div>

                        <div class="card-body">
                            <form id="nurse-station-medicine-details"
                                action="{{ route('ipd.nurse-station-vital-store') }}" method="post">@csrf
                                <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
                                    value="{{ $patient_info->patient_no_pk }}">
                                <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
                                    value="{{ $patient_info->admission_no_pk }}">
                                <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
                                    value="{{ $patient_info->admission_uid }}">


                                <div class="d-flex justify-content-center border-bottom pb-2">
                                    <!-- <span class="p-10 m-1">
                                        <div class="input-group ">

                                            Follow Up Date <input type="text" class="date_picker form-control ml-2"
                                                name="followUpDate" id="followUpDate">

                                            Follow Up Time <input type="text"
                                                class="timepicker form-control ml-2 mr-2" name="followUpTiem"
                                                id="followUpTiem">
                                        </div>
                                    </span> -->
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

                                <div class="form-row">
                                    <div class="col-md-12 ">
                                        <div class="">
                                            <table class="table border-0 mt-2 mb-0" id="vital_item">Rx
                                                <thead>
                                                    <tr class="border-0">
                                                        <!-- <th class="p-0 px-1 border-0">Follow Up Type</th> -->
                                                        <th class="p-0 px-1 border-0">Date & Time</th>

                                                        <th class="p-0 px-1 border-0">Pulse</th>
                                                        <th class="p-0 px-1 border-0">BP(s)</th>
                                                        <th class="p-0 px-0 border-0">BP(d)</th>
                                                        <th class="p-0 px-1 border-0">Temperature</th>
                                                        <th class="p-0 px-1 border-0">R/R</th>


                                                        <th class="p-0 px-1 border-0">SPO2</th>
                                                        <th class="p-0 px-1 border-0">Heart</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-0">
                                                        <!-- <td class="p-0 px-1 border-0">

                                                            <select
                                                                class="form-control form-control-sm m-0 p-0 followUpType"
                                                                name="followUpType" id="followUpType"
                                                                onchange="prescriptionFunc.addMoreDropdownOption(this,'.followUpType');">
                                                                <option value="">select</option>

                                                                @if (!empty($ipd_followup_type))
                                                                    @foreach ($ipd_followup_type as $key => $value)
                                                                        <option value="{{ $value }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                @endif

                                                                <option data-qnty="0" data-dropdown_option="add_more"
                                                                    data-popup_header="Follow Up Type"
                                                                    data-input_label="Follow Up Type"
                                                                    data-input_placeholder="Enter Follow Up Type (i.e.,Morning, Evening)"
                                                                    value="0">Add
                                                                    More</option>
                                                            </select>
                                                        </td> -->
                                                        <td class="p-0 px-1 border-0 ">

                                                            <div class="input-group ">
                                                                <input type="text" class="date_picker form-control"
                                                                    name="followTypeDate" id="followTypeDate">
                                                                <input type="text" class="timepicker form-control"
                                                                    name="followUpTypeTime" id="followUpTypeTime">
                                                            </div>
                                                        </td>


                                                        <td class="p-0 px-1 border-0"><input type="number"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_pulse" name="txt_pulse" value=""
                                                                placeholder="Pulse" /></td>

                                                        <td class="p-0 px-1 border-0">
                                                            <div class="input-group"><input type="number"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_bp_sys" name="txt_bp_sys" value=""
                                                                    placeholder="Systolic BP" /></div>
                                                        </td>
                                                        <td class="p-0 px-0 border-0">
                                                            <div class="input-group"><input type="number"
                                                                    class="form-control form-control-sm m-0 p-0"
                                                                    id="txt_bp_dia" name="txt_bp_dia" value=""
                                                                    placeholder="Diastolic BP" /></div>
                                                        </td>

                                                        <td class="p-0 px-1 border-0"><input type="number"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_temperature" name="txt_temperature"
                                                                value="" placeholder="Temperature" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_rr" name="in_rr" value=""
                                                                placeholder="R/R" /></td>

                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="spo2" name="spo2" value=""
                                                                placeholder="SPO2" /></td>

                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_heart_condition" name="in_heart_condition"
                                                                value="" placeholder="Heart" /></td>





                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="border-bottom pb-3">
                                            <table class="table border-0 mb-0" id="vital_item">
                                                <thead>
                                                    <tr class="border-0">
                                                        <th class="p-0 px-1 border-0">O2 Support</th>
                                                        <th class="p-0 px-1 border-0">CBG</th>
                                                        <th class="p-0 px-1 border-0">Cannula Check</th>
                                                        <th class="p-0 px-0 border-0">Activity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-0">

                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_o2support" name="in_o2support" value=""
                                                                placeholder="O2 Support" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_cbg" name="in_cbg" value=""
                                                                placeholder="CBG" /></td>
                                                        <td class="p-0 px-1 border-0">
                                                            <select class="form-control form-control-sm select2 m-0 p-0"
                                                            id="in_cannula_check" name="in_cannula_check">
                                                                <option value="">Select</option>
                                                                <option value="1">ON</option>
                                                                <option value="2">OFF</option>
                                                            </select>
                                                        </td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_activity" name="in_activity" value=""
                                                                placeholder="Activity" /></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="border-bottom pb-3">
                                            <table class="table border-0 mt-2 mb-0" id="vital_item">
                                                <thead>
                                                    <tr class="border-0">
                                                        <th class="p-0 px-1 border-0">Lungs</th>
                                                        <th class="p-0 px-1 border-0">Anemia</th>
                                                        <th class="p-0 px-1 border-0">Jaundice</th>

                                                        <th class="p-0 px-0 border-0">Dehydration</th>
                                                        <th class="p-0 px-0 border-0">Bowel</th>
                                                        <th class="p-0 px-0 border-0">Bladder</th>

                                                        <th class="p-0 px-1 border-0">Height</th>
                                                        <th class="p-0 px-1 border-0">Body Weight</th>
                                                        <th class="p-0 px-1 border-0">BMI</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-0">
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_lung_condition" name="in_lung_condition"
                                                                value="" placeholder="Lungs" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="anemia" name="anemia" value=""
                                                                placeholder="anemia" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="jaundice" name="jaundice" value=""
                                                                placeholder="jaundice" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_dehydeation" name="in_dehydeation"
                                                                value="" placeholder="Dehydeation" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_bowel_condition" name="in_bowel_condition"
                                                                value="" placeholder="Bowel" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="in_bladder_condition" name="in_bladder_condition"
                                                                value="" placeholder="Bladder" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="text"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_height" name="height" value=""
                                                                placeholder="inch" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="number"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_weight" name="weight" value=""
                                                                placeholder="kg" /></td>
                                                        <td class="p-0 px-1 border-0"><input type="number"
                                                                class="form-control form-control-sm m-0 p-0"
                                                                id="txt_bmi" name="bmi" value=""
                                                                placeholder="BMI" /></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-row border-bottom col-md-7">
                                        <div class="m-0 mt-3 mb-2 mr-2 text-right">
                                            @php
                                                $patient_no_pk = $patient_info->patient_no_pk;
                                                $admission_no_pk = $patient_info->admission_no_pk;
                                                $response_url_page = route('ipd.nurse-station-vital-details', [$patient_no_pk, $admission_no_pk]);

                                            @endphp

                                            <button
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url_page }}')"
                                                type="button" class="btn btn-success btn-sm"><i
                                                    class="fa fa-save"></i>
                                                Save</button>
                                            <button type="reset" class="btn btn-info btn-sm"
                                                title="Click here to Clear form data">Clear</button>

                                            {{-- <a href="{{ route('ipd_case_sheet', [$patient_info->patient_no_pk, $patient_info->admission_uid]) }}"
                                                target="_blank" class="btn btn-success btn-sm "
                                                style="margin-left:10px;color:white">
                                                Case Sheet</a> --}}
                                            {{-- <span class="btn btn-danger btn-sm" rel="tab"
                                                title="Click here to dismiss the modal"
                                                data-dismiss="modal">Exit</span> --}}
                                        </div>


                                    </div>
                                </div>


                            </form>
                            <div class="card-body">
                                <div class="form-row mt-2" id="patient-details-list">

                                    @include('admin.ipd.nurse_station.nurse_station_patient_vital_list')

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
        // $('body').on('keyup', '#txt_height', function() {
        //         let height_to_meter = $(this).val() != "" ? $(this).val() * 0.0254 : 0;
        //         let weight = $('#txt_weight').val();
        //         let bmi = weight != "" ? weight / (height_to_meter * height_to_meter) : 0;
        //         $('#txt_bmi').val(bmi.toFixed(1));
        //     })

        $(document).on('keyup', '#txt_weight', function() {
            let height_to_meter = $('#txt_height').val() != "" ? $('#txt_height').val() * 0.0254 : 0;
            let weight = $(this).val();
            let bmi = height_to_meter != "" ? weight / (height_to_meter * height_to_meter) : 0;
            $('#txt_bmi').val(bmi.toFixed(1));
            console.log(height_to_meter, weight, bmi);
        })
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
            // openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');

            $(document).on("click", ".remove-item-btn", function() {
                let med_data = $(this).attr('data-value-med');
                let admission_data = $(this).attr('data-value-admission');
                let patient_data = $(this).attr('data-value-patient');
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

            // $('#nurse-station-medicine-details').on("submit", function(e) {
            //     e.preventDefault();
            //     if (confirm("Are you sure?")) {
            //         $.ajax({
            //             async: true,
            //             type: "POST",
            //             url: "{{ route('ipd.store-received-patient-clinical-info') }}",
            //             data: $('#nurse-station-medicine-details').serialize(),
            //             dataType: 'html',
            //             beforeSend: function() {
            //                 blockUI();
            //             },
            //             success: (data) => {
            //                 alert('New Prescription created successfully.')
            //                 $('#patient-details-list').html(data)
            //                 /* $('.common-modal-notify').modal('show');
            // 					$('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
            // 					$('.common-modal-notify .modal-title').html(data.title);
            //                     $('.common-modal-notify .modal-body').html(data.msg); */
            //                 var hdn_patient_id = $('#hdn_patient_no_fk').val();
            //                 var hdn_admission_id = $('#hdn_admission_no_pk').val();
            //                 var hdn_admission_uid = $('#hdn_admission_uid').val();
            //                 $('ul#investigation').empty()
            //                 $('ul#ot_list').empty()
            //                 $('ul#diet_list').empty()
            //                 $('ul#service_list').empty()
            //                 $("#medicine_list tr:gt(1)").remove();
            //                 $('form#nurse-station-medicine-details').trigger("reset");
            //                 $('#hdn_patient_no_fk').val(hdn_patient_id);
            //                 $('#hdn_admission_no_pk').val(hdn_admission_id);
            //                 $('#hdn_admission_uid').val(hdn_admission_uid);
            //                 $.unblockUI();
            //             },
            //             error: function(data) {
            //                 console.log(data);
            //                 $.unblockUI();
            //             },
            //         });
            //     }

            // });


            // Added By nazmul



        });
    </script>
