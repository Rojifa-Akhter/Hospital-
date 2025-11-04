<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
@php
    $data = isset($edit_data) && !empty($edit_data) ? $edit_data : [];
    $hdnemp_seprtn_no_pk = $data ? $data->emp_seprtn_no_pk : '';
    $employee_name = $data ? $data->employee_name : '';
    $emp_seprtn_person_no_fk = $data ? $data->emp_seprtn_person_no_fk : '';
    $serviceunit_name = $data ? $data->serviceunit_name : '';
    $designation_name = $data ? $data->designation_name : '';
    $seprtn_type = $data ? $data->seprtn_type : '';
    $save_option = $data ? $data->save_option : '';
    $emp_seprtn_application_date = !empty($data->emp_seprtn_application_date) ? date('d-m-Y', strtotime($data->emp_seprtn_application_date)) : '';
    $emp_seprtn_expected_date = !empty($data->emp_seprtn_expected_date) ? date('d-m-Y', strtotime($data->emp_seprtn_expected_date)) : '';
    $last_working_day = !empty($data->last_working_day) ? date('d-m-Y', strtotime($data->last_working_day)) : '';
    $emp_seprtn_application_remarks = $data ? $data->emp_seprtn_application_remarks : '';
@endphp
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('v1.hrm.seperation-application-save') }}" id="ApplicationforSeparation" method="post">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Application for Seperation</h5>
                        <small>HRM / Application for Seperation</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-row">
                                    <div class="col">
                                        <label for="emp_name" class="col-form-label">Employe Name</label> <br>
                                        <input type="text" class="form-control" id="emp_name" name="emp_name"
                                            placeholder="Search by Name / ID" value="{{ $employee_name }}" />
                                        <input type="hidden" name="emp_seprtn_person_no_fk"
                                            id="emp_seprtn_person_no_fk" value="{{ $emp_seprtn_person_no_fk }}">
                                        <input type="hidden" name="emp_seprtn_uid" id="emp_seprtn_uid"
                                            value="{{ !empty($emp_seprtn_uid) ? $emp_seprtn_uid : '' }}">
                                        <input type="hidden" name="hdnemp_seprtn_no_pk" id="hdnemp_seprtn_no_pk"
                                            value="{{ $hdnemp_seprtn_no_pk }}">
                                    </div>

                                    <div class="col">
                                       <label for="emp_name" class="col-form-label">ID <span
                                                    style="color: red;">*</span></label>
                                        <input type="text" class="form-control form-control-sm" id="emp_name_"
                                                name="emp_name_" placeholder="" value="{{ $emp_seprtn_person_no_fk }}"
                                                readonly required />
                                    </div>

                                    <div class="col">
                                        <label for="department" class="col-form-label">Department</label>
                                        <input type="text" class="form-control form-control-sm" id="department"
                                            name="department" placeholder="" value="{{ $serviceunit_name }}"
                                            readonly />
                                    </div>

                                    <div class="col">
                                        <label for="dseignation" class="col-form-label">Designation</label>
                                        <input type="text" class="form-control form-control-sm" id="dseignation"
                                            name="dseignation" placeholder="" value="{{ $designation_name }}"
                                            readonly />
                                    </div>

                                    <div class="col">
                                        <label for="seprtn_type" class="col-form-label">Seperation Type <span
                                            style="color: red;">*</span></label>
                                        <select class="form-control form-control-sm select2" id="seprtn_type"
                                            name="seprtn_type" required>
                                            <option value="">Select</option>
                                            <option value="Resignation"
                                                @if ($seprtn_type == 'Resignation') selected @endif>Resignation
                                            </option>
                                            <option value="Unauthorised"
                                                @if ($seprtn_type == 'Unauthorised') selected @endif>Unauthorised
                                            </option>
                                            <option value="Retirement"
                                                @if ($seprtn_type == 'Retirement') selected @endif>Retirement
                                            </option>
                                            <option value="Termination"
                                                @if ($seprtn_type == 'Termination') selected @endif>Termination
                                            </option>
                                            <option value="Poor Performance"
                                                @if ($seprtn_type == 'Poor Performance') selected @endif>Poor Performance
                                            </option>
                                            <option value="Long Time Absent"
                                                @if ($seprtn_type == 'Long Time Absent') selected @endif>Long Time Absent
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col" style="display: none">
                                        <label for="seprtn_type" class="col-form-label">Patient Type <span
                                            style="color: red;">*</span></label>
                                        <select class="form-control form-control-sm select2" id="patient_type"
                                            name="patient_type" required>
                                                <option value="">Select</option>
                                                @if (!empty($patient_type))
                                                    @foreach ($patient_type as $data)
                                                        <option data-type_code="{{ $data->patient_type_code }}"
                                                            value="{{ $data->patient_type_no_pk }}"
                                                            {{ $data->patient_type_code == "GENERAL" ? 'selected' : '' }}
                                                            >
                                                            {{ $data->patient_type_code }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                    </div>

                                  </div>

                                    <div class="form-row">
                                      <div class="col">
                                        <label for="emp_seprtn_application_date" class="col-form-label">Date of
                                            Application <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control form-control-sm date_picker"
                                            id="emp_seprtn_application_date" name="emp_seprtn_application_date"
                                            placeholder="" value="{{ $emp_seprtn_application_date }}" required />
                                      </div>

                                      <div class="col">
                                        <label for="emp_seprtn_expected_date" class="col-form-label">Exp. Date of
                                            Separation<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control form-control-sm date_picker"
                                            id="emp_seprtn_expected_date" name="emp_seprtn_expected_date"
                                            placeholder="" value="{{ $emp_seprtn_expected_date }}" required />
                                      </div>

                                      <div class="col">

                                        @if (!empty($save_option))
                                        <label for="last_working_day" class="col-form-label">Last Working Day<span
                                            style="color: red;">*</span></label>
                                       <input type="text" class="form-control form-control-sm date_picker"
                                        id="last_working_day" name="last_working_day" placeholder=""
                                        value="{{ $last_working_day }}" required />

                                        @else

                                        <label for="last_working_day" class="col-form-label">Last Working Day</label>
                                       <input type="text" class="form-control form-control-sm date_picker"
                                        id="last_working_day" name="last_working_day" placeholder=""
                                        value="{{ $last_working_day }}"/>

                                        @endif
                                      </div>

                                      <div class="col">
                                        <label for="emp_seprtn_attachment_path" class="col-form-label">
                                            Attachment</label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input form-control"
                                                    name="emp_seprtn_attachment_path"
                                                    id="emp_seprtn_attachment_path" />
                                                <label class="custom-file-label form-control upload_app_label"
                                                    for="upload_app">Upload </label>
                                            </div>
                                            @if (isset($edit_data) && $edit_data->emp_seprtn_attachment_path != null)
                                                <a href="{{asset('/images/uploads/emp_seprtn_attachment/'.@$edit_data->emp_seprtn_attachment_path)}}" target="_blank" rel="noopener noreferrer"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            @endif

                                            {{-- <label for="del_attachment" class="col-form-label">Delete</label>
                                            <input type="checkbox" id="del_attachment" name="del_attachment" /> --}}
                                        </div>
                                      </div>

                                      <div class="col">
                                        <label for="emp_seprtn_application_remarks"
                                        class="col-form-label">Remarks</label>
                                       <textarea class="form-control" name="emp_seprtn_application_remarks" id="emp_seprtn_application_remarks"
                                        rows="1">{{ $emp_seprtn_application_remarks }}</textarea>
                                      </div>

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @php
                        $response_action = route('v1.hrm.employee-seperation');
                    @endphp
                    <div class="col-lg-12 col-md-12 col-12">
                        <input type="hidden" id="save_option" name="save_option" value="">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        @if (!empty($save_option))
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="SaveOption('SAVE'); btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}');"
                                                id="save" style="background-color: #5cb85c;">Save</button>
                                        </li> 
                                        @else
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="SaveOption('DRAFT'); btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}');"
                                                id="">Draft</button>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });

    function SaveOption(value) {
        $("#save_option").val(value);
    }
    openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1, personInfo);

    function personInfo(item, obj) {
        console.log(item.person_code);
        $("#emp_seprtn_person_no_fk").val(item.doctor_id);
        $("#emp_name_").val(item.person_code);
        $("#emp_id").val(item.person_code);
        // $("#emp_name_").val(item.full_name);
        $("#department").val(item.su_name);
        $("#dseignation").val(item.designation);


    }
</script>
