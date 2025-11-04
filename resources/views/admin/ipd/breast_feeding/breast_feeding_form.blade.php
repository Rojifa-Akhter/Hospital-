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
            <h5 class="mt-2 mb-0">Breast Feeding Form</h5>
            <small>IPD / Nurse Station / Breast Feeding Form</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">

            @include('admin.components.patient_info')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fa fa-capsules"></i>&nbsp; Breast Feeding Information</h5>
                        </div>

                        <div class="card-body">
                            <form id="nurse-station-medicine-details"
                                action="{{ route('ipd.breast-feeding-store') }}" method="post">@csrf
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
                                    <div class="col-md-3">
                                        <label for="breastfeeding_date" class="col-form-label col-form-label-sm">Time
                                        </label>
                                        <div class="input-group">
                                            {{-- <input type="text" class="date_picker form-control"
                                                name="breastfeeding_date" id="breastfeeding_date"> --}}
                                            <input type="text" class="timepicker form-control"
                                                name="breastfeeding_time" id="breastfeeding_time">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label for="sucking" class="col-form-label col-form-label-sm">Sucking</label>
                                            <select class="form-control form-control-sm select2 m-0 p-0"
                                                id="sucking" name="sucking">
                                                <option value="0">Select</option>
                                                <option value="1">Good</option>
                                                <option value="2">Average</option>
                                                <option value="3">Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <label for="milk_flow" class="col-form-label col-form-label-sm">Milk Flow</label>
                                            <select class="form-control form-control-sm select2 m-0 p-0"
                                                id="milk_flow" name="milk_flow">
                                                <option value="0">Select</option>
                                                <option value="1">Good</option>
                                                <option value="2">Average</option>
                                                <option value="3">Poor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="entryDate" class="col-form-label col-form-label-sm">Duration of Feeding
                                        </label>
                                            <input type="text" class="form-control"
                                                name="feeding_duration" id="feeding_duration">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="staff__id" class="col-form-label col-form-label-sm">Employee</label>
                                        <input type="text" class="form-control form-control-sm pat_info staff__id" maxlength="50" id="staff__id" name="staff__id" placeholder="Enter Employee">
                                        <input type="hidden" name="hdn_staff__id" id="hdn_staff__id">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label for="remark" class="col-form-label col-form-label-sm">Remarks</label>
                                            <textarea class="form-control" id="remark" rows="3" name="remark"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row border-bottom ">
                                    <div class="m-0 mt-3 mb-2 mr-2 ">
                                        @php
                                            $patient_no_pk = $patient_info->patient_no_pk;
                                            $admission_no_pk = $patient_info->admission_no_pk;
                                            $response_url_page = route('ipd.breast-feeding-form', [$patient_no_pk, $admission_no_pk]);

                                        @endphp

                                        <button
                                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url_page }}')"
                                            type="button" class="btn btn-success btn-sm"><i class="fa fa-save"></i>
                                            Save</button>
                                        <button type="reset" class="btn btn-info btn-sm"
                                            title="Click here to Clear form data">Clear</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <div class="form-row mt-2" id="patient-details-list">

                                    @include('admin.ipd.breast_feeding.breast_feeding_list_table')

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


        });
        openDoctorAutocomplete('#staff__id', 'hdn_staff__id');
    </script>
