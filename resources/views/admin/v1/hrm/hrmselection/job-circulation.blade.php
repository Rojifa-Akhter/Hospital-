<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<main id="page-content">
    <section class="hr_payroll">
        <div class="container-fluid">
            <div class="row bg-white border-bottom sticky-top shadow-sm">
                <div class="col-md-12">
                    <h5 class="mt-2 mb-0">Create Job Circulation</h5>
                    <small>HRM / Create Job Circulation</small>
                </div>
            </div>
            <form action="{{ route('v1.hrm.store-job-circular') }}" id="job-circular" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    {{-- <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jobcircular_uid" class="col-form-label">Circular ID</label>
                                           
                                            <input type="text" class="form-control form-control-sm"
                                                id="jobcircular_no_pk" name="jobcircular_no_pk" placeholder=""
                                                value="" />
                                        </div>
                                    </div> --}}
                                    {{-- <input type="hidden" class="form-control form-control-sm" id="jobcircular_uid"
                                        name="jobcircular_uid" placeholder="" value="{{ $circular_id }}" /> --}}

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jobcircular_date" class="col-form-label">Circular
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="jobcircular_date" name="jobcircular_date" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="position_name" class="col-form-label">Position Name</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="position_name" name="position_name" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="no_of_post" class="col-form-label">Number of Post</label>
                                            <input type="text" class="form-control form-control-sm" id="no_of_post"
                                                name="no_of_post" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation_no_fk" class="col-form-label">Designation</label>
                                            {{-- <input type="text" class="form-control form-control-sm"
                                                id="designation_no_fk" name="designation_no_fk" placeholder=""
                                                value="" /> --}}
                                            <select class="form-control select2" id="designation_no_fk"
                                                name="designation_no_fk">
                                                <option value="">Select Designation</option>
                                                @if (isset($designation))
                                                    @foreach ($designation as $desig)
                                                        <option value="{{ $desig->designation_no_pk }}">
                                                            {{ $desig->designation_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="su_no_fk" class="col-form-label">Department</label>
                                            {{-- <input type="text" class="form-control form-control-sm" id="su_no_fk"
                                                name="su_no_fk" placeholder="" value="" /> --}}
                                            <select class="form-control select2" id="su_no_fk" name="su_no_fk">
                                                <option value="">Select Department</option>
                                                @if (isset($departments))
                                                    @foreach ($departments as $dept)
                                                        <option value="{{ $dept->serviceunit_no_pk }}">
                                                            {{ $dept->serviceunit_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="skills_required" class="col-form-label">Skills
                                                Required</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="skills_required" name="skills_required" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="minimum_expericences_yy" class="col-form-label">Minimum
                                                Experience by Number</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="minimum_expericences_yy" name="minimum_expericences_yy"
                                                placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="age_limit" class="col-form-label">Age Limit by Number</label>
                                            <input type="text" class="form-control form-control-sm" id="age_limit"
                                                name="age_limit" placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gender_specification" class="col-form-label">Gender
                                                Specification</label>
                                            <select class="form-control" id="gender_specification"
                                                name="gender_specification">
                                                <option value="">Select</option>
                                                @if (isset($gender))
                                                    @foreach ($gender as $key => $value)
                                                        <option value="{{ $key }}">
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jobcircular_opening_date" class="col-form-label">Opening
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="jobcircular_opening_date" name="jobcircular_opening_date"
                                                placeholder="" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jobcircular_closing_date" class="col-form-label">Closing
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="jobcircular_closing_date" name="jobcircular_closing_date"
                                                placeholder="" value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="marketing-criteria" class="col-form-label">Marking
                                                Criteria
                                                Group</label>
                                            {{-- <input type="text" class="form-control form-control-sm"
                                                id="marketing-criteria" name="marketing-criteria" placeholder=""
                                                value="" /> --}}
                                            <select class="form-control" id="marking_criteria"
                                                name="marking_criteria">
                                                <option value="">Select</option>
                                                @if (!empty($marking))
                                                    @foreach ($marking as $m)
                                                        <option value="{{ $m->markingcriteria_no_pk }}">
                                                            {{ $m->marking_creteria }}</option>
                                                    @endforeach

                                                @endif
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jobcircular_text" class="col-form-label">Job Circular
                                                Description
                                            </label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="jobcircular_text" name="jobcircular_text" placeholder=""
                                                value="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="upload_circuler" class="col-form-label">Upload
                                                Circuler</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control"
                                                        id="upload_circuler" name="upload_circuler" />
                                                    <label class="custom-file-label form-control upload_app_label"
                                                        for="upload_circuler">Upload Circuler</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $response_action = route('v1.hrm.job-circulation-work-list');
                @endphp
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                id="">Save</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button"
                                                class="btn btn-danger">Cancel</button></li>
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
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
</script>
