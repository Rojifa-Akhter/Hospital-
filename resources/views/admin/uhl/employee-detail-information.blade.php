<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <form action="{{ route('employee.store-information') }}" method="post" id="patient-info-create">
        @csrf

        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Employee Detail Information</h5>
                                <small>HRM / Employee Detail Information</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row justify-content-center">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="id_" class="col-form-label">ID</label>
                                            <input type="text" class="form-control form-control-sm" id="employee_id"
                                                name="employee_id" placeholder=""
                                                value="{{ !empty($employee_info->full_name) ? $employee_info->full_name : '' }}"
                                                data-employee-route="{{ route('employee-data') }}" />
                                            <input type="hidden" name="employee_name" id="employee_name"
                                                value="{{ !empty($employee_info->person_no_pk) ? $employee_info->person_no_pk : '' }}">
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_" class="col-form-label">Name</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="name_" name="name_" placeholder="" {{!empty($employee_info->full_name)?$employee_info->full_name:''}}/>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="mobile_" class="col-form-label">Mobile</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="mobile_" name="mobile_" placeholder="" value="" />
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-block btn-success btn-md mt-4 btn-md-global">Search</button>
                                        </div> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-row">

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name_" class="col-form-label">Name</label>
                                            <input type="text" class="form-control form-control-sm" id="employee_name"
                                                name="" placeholder=""
                                                value="{{ !empty($employee_info->full_name) ? ucfirst($employee_info->full_name) : '' }}"readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_designation"
                                                name="" placeholder=""
                                                value="{{ !empty($employee_info->designation) ? ucfirst($employee_info->designation) : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_department"
                                                name="emp_department" placeholder=""
                                                value="{{ !empty($employee_info->su_name) ? ucfirst($employee_info->su_name) : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="dob" class="col-form-label">DoB</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_dob"
                                                name="emp_dob" placeholder=""
                                                value="{{ !empty($employee_info->dob) ? date('d/m/y', strtotime($employee_info->dob)) : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="mobile" class="col-form-label">Mobile</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_mobile"
                                                name="emp_mobile" placeholder=""
                                                value="{{ !empty($employee_info->phone_mobile) ? $employee_info->phone_mobile : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="gender" class="col-form-label">Gender</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_gender"
                                                name="emp_gender" placeholder=""
                                                value="{{ !empty($employee_info->gender_txt) ? ucfirst($employee_info->gender_txt) : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label">Email</label>
                                            <input type="text" class="form-control form-control-sm" id="emp_email"
                                                name="emp_email" placeholder=""
                                                value="{{ !empty($employee_info->email_personal) ? ucfirst($employee_info->email_personal) : '' }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="joining_date" class="col-form-label">Joining Date</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="emp_joining_date" name="emp_joining_date" placeholder=""
                                                value="{{ !empty($employee_info->join_date) ? date('d/m/y', strtotime($employee_info->join_date)) : '' }}" readonly/>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="skill" class="col-sm-2 col-form-label">Skill</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="skill" name="skill"
                                                placeholder="Enter Your Skill" value="{{ !empty($employee_info->skill) ? ucfirst($employee_info->skill) : '' }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <h5>Education</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th>Degree Title</th>
                                                    <th>Board</th>
                                                    <th>Institute Name</th>
                                                    <th>Passing Year</th>
                                                    <th>Result</th>
                                                    <th>Highest Education</th>
                                                    {{-- <th>Attachment</th> --}}
                                                    <th>Certificate Link</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to">
                                                <tr id="0">
                                                    <td>
                                                        {{-- <input type="text" class="form-control form-control-sm"
                                                            name="" id="" /> --}}
                                                        <select
                                                            class="
                                                        form-control font_size_12 m-auto select2"
                                                            name="name[]" id="degree_name_0">
                                                            <option value="0">Select Degree</option>

                                                            @if (!empty($degree))
                                                                @foreach ($degree as $key => $value)
                                                                    <option value="{{ $key }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{-- <input
                                                        type="
                                                    text"
                                                        class="form-control" id="university_0"
                                                        name="university[]"
                                                        placeholder="Enter Board Name" maxlength="100"> --}}
                                                        <select
                                                            class="
                                                    form-control font_size_12 m-auto select2"
                                                            name="education_board[]" id="education_board_0">
                                                            <option value="0">Select Board Name</option>

                                                            @if (!empty($eduboard))
                                                                @foreach ($eduboard as $key => $value)
                                                                    <option value="{{ $key }}">
                                                                        {{ $value }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="
                                                    text"
                                                            class="form-control" id="institution_0"
                                                            name="institution[]" placeholder="Enter Institute"
                                                            maxlength="100">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="p_year_[]" id="p_year__0"
                                                            placeholder="Enter Passing Year" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="result[]" id="result_0"
                                                            placeholder="Enter Result" />
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="highest_edu[]" id="highest_edu_0"
                                                            placeholder="Enter Highest Education" />
                                                    </td>

                                                    {{-- <td>

                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input form-control"
                                                                    id="upload_app" name="upload_" />
                                                                <label
                                                                    class="custom-file-label form-control upload_app_label"
                                                                    for="upload_app">Upload</label>
                                                            </div>
                                                        </div>

                                                    </td> --}}
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="certificate_link[]" id="certificate_link_0"
                                                            placeholder="Certificate Link" />
                                                    </td>
                                                    <td>
                                                        <span id="med_td_action_0" onclick="addDegreeRow(this)"
                                                            class="btn btn-md btn-success"> +Add </span>
                                                    </td>
                                                </tr>


                                                @php
                                                    $tableId = 2;
                                                @endphp
                                                @if (!empty($educationInfo))
                                                    @foreach ($educationInfo as $education)
                                                        <tr id="{{ $tableId }}">
                                                            <td>


                                                                <select
                                                                    class="
                                                        form-control font_size_12 m-auto select2"
                                                                    name="name[]" id="degree_name_0">
                                                                    <option value="0">Select Degree</option>

                                                                    @if (!empty($degree))
                                                                        @foreach ($degree as $key => $value)
                                                                            <option value="{{ $key }}"
                                                                                @if ($education->degree_name == $key) selected @endif>
                                                                                {{ $value }}
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>

                                                            <td>


                                                                <select
                                                                    class="
                                                        form-control font_size_12 m-auto select2"
                                                                    name="education_board[]" id="education_board_0">
                                                                    <option value="0">Select Board Name</option>
                                                                    @if (!empty($eduboard))
                                                                        @foreach ($eduboard as $key => $value)
                                                                            <option value="{{ $key }}"
                                                                                @if ($education->board_university == $key) selected @endif>
                                                                                {{ $value }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="institution_0" name="institution[]"
                                                                    placeholder="Enter Institute" maxlength="100"
                                                                    value="{{ !empty($education->institute_name) ? $education->institute_name : '' }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="p_year_[]" id="p_year__0"
                                                                    placeholder="Enter Passing Year"value="{{ !empty($education->passing_year) ? $education->passing_year : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="result[]" id="result_0"
                                                                    placeholder="Enter Result"
                                                                    value="{{ !empty($education->result_text) ? $education->result_text : '' }}" />
                                                            </td>

                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="highest_edu[]" id="highest_edu_0"
                                                                    placeholder="Enter Highest Education"
                                                                    value="{{ !empty($education->highest_education_ind) ? $education->highest_education_ind : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="certificate_link[]" id="certificate_link_0"
                                                                    placeholder="Certificate Link"
                                                                    value="{{ !empty($education->education_cert_url) ? $education->education_cert_url : '' }}" />
                                                            </td>


                                                            <td id="med_td_action_{{ $tableId }}">
                                                                <span onclick="removeTableRowOnly(this)"
                                                                    class="btn btn-sm btn-danger"> <i
                                                                        class='fa fa-times'></i> </span>
                                                            </td>
                                                        </tr>
                                                        <td>
                                                            <input type="hidden" name="hidden_temp_edu_id[]"
                                                                value="{{ $education->education_no_pk }}">
                                                        </td>
                                                        @php
                                                            $tableId = $tableId + 1;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h5>Experience</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Company Location/Contact</th>
                                                    <th>Designation</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Number of years</th>
                                                    <th>Reason for Resign</th>
                                                    <th>Current Job</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to-1">
                                                <tr id="0">
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="company_name[]" id="company_name_0"
                                                            placeholder="Enter Company Name" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="company_location[]" id="company_location_0"
                                                            placeholder="Enter Company Location" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="designation[]" id="designation_0"
                                                            placeholder="Enter Designation" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="start_date[]" id="start_date_0"
                                                            placeholder="Enter Start Date" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="end_date[]" id="end_date_0"
                                                            placeholder="Enter End Date" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="number_of_years[]" id="number_of_years_0"
                                                            placeholder="Enter Number Of Years" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="reason_of_resign[]" id="reason_of_resign_0"
                                                            placeholder="Enter Reason Of Resign" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="current_job[]" id="current_job_0"
                                                            placeholder="Enter Current Job" />
                                                    </td>

                                                    <td>
                                                        <span id="med_td_action_one_0"
                                                            onclick="addExperienceRow(this)"
                                                            class="btn btn-md btn-success"> +Add </span>
                                                    </td>
                                                </tr>

                                                @php
                                                    $tableIdone = 2;
                                                @endphp
                                                @if (!empty($experience_dt))
                                                    @foreach ($experience_dt as $ex)
                                                        <tr id="{{ $tableIdone }}">
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="company_name[]" id="company_name_0"
                                                                    placeholder="Enter Company Name" value="{{ !empty($ex->company_name) ? $ex->company_name : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="company_location[]" id="company_location_0"
                                                                    placeholder="Enter Company Location" value="{{ !empty($ex->company_address) ? $ex->company_address : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="designation[]" id="designation_0"
                                                                    placeholder="Enter Designation" value="{{ !empty($ex->designation_name) ? $ex->designation_name : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="start_date[]" id="start_date_0"
                                                                    placeholder="Enter Start Date" value="{{ !empty($ex->emp_from_date) ? $ex->emp_from_date : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="end_date[]" id="end_date_0"
                                                                    placeholder="Enter End Date" value="{{ !empty($ex->emp_to_date) ? $ex->emp_to_date : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="number_of_years[]" id="number_of_years_0"
                                                                    placeholder="Enter Number Of Years"  />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="reason_of_resign[]" id="reason_of_resign_0"
                                                                    placeholder="Enter Reason Of Resign" value="{{ !empty($ex->reason_of_resign) ? $ex->reason_of_resign : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="current_job[]" id="current_job_0"
                                                                    placeholder="Enter Current Job" value="{{ !empty($ex->current_job_ind) ? $ex->current_job_ind : '' }}" />
                                                            </td>



                                                            <td id="med_td_action_{{ $tableIdone }}">
                                                                <span onclick="removeTableRowOnly(this)"
                                                                    class="btn btn-sm btn-danger"> <i
                                                                        class='fa fa-times'></i> </span>
                                                            </td>
                                                        </tr>
                                                        <td>
                                                            <input type="hidden" name="hidden_experience_no_pk_id[]"
                                                                value="{{ $ex->experience_no_pk }}">
                                                        </td>
                                                        @php
                                                            $tableIdone = $tableIdone + 1;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-header">
                                <h5>Certification / Training</h5>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th>Certification / Training Tittle</th>
                                                    <th>Institute Name</th>
                                                    <th>Date From</th>
                                                    <th>Date To</th>
                                                    <th>Certification Date</th>
                                                    <th>Highest Education</th>
                                                    {{-- <th>Attachment</th> --}}
                                                    <th>Certificate Link</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to-two-0">
                                                <tr id="0">
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="certificate_title[]" id="certificate_title_0"
                                                            placeholder="Enter Certificate Title" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="institude_name[]" id="institude_name_0"
                                                            placeholder="Enter Institude Name" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="certificate_start_date[]"
                                                            id="certificate_start_date_0"
                                                            placeholder="Enter Start Date" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="certificate_end_date_0[]"
                                                            id="certificate_end_date_0"
                                                            placeholder="Enter End Date" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm "
                                                            name="certificate__date_0[]" id="certificate__date_0"
                                                            placeholder="Enter Certificate Date" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="highest_education[]" id="highest_education_0"
                                                            placeholder="Enter Highest Education" />
                                                    </td>
                                                    {{-- <td>

                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input form-control"
                                                                    id="upload_app" name="upload_" />
                                                                <label
                                                                    class="custom-file-label form-control upload_app_label"
                                                                    for="upload_app">Upload</label>
                                                            </div>
                                                        </div>

                                                    </td> --}}
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="certificate_link[]" id="certificate_link_0"
                                                            placeholder="Enter Certificate Link" />
                                                    </td>

                                                    <td>
                                                        <span id="med_td_action_two_0"
                                                            onclick="addEcertificateRow(this)"
                                                            class="btn btn-md btn-success"> +Add </span>
                                                    </td>
                                                </tr>

                                                @php
                                                    $tableIdtwo = 2;
                                                @endphp
                                                @if (!empty($certificate_dt))
                                                    @foreach ($certificate_dt as $cer)
                                                        <tr id="{{ $tableIdtwo }}">
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="certificate_title[]" id="certificate_title_0"
                                                                    placeholder="Enter Certificate Title"  value="{{ !empty($cer->cert_tr_tittle) ? $cer->cert_tr_tittle : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="institude_name[]" id="institude_name_0"
                                                                    placeholder="Enter Institude Name"  value="{{ !empty($cer->institute_name) ? $cer->institute_name : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="certificate_start_date[]"
                                                                    id="certificate_start_date_0"
                                                                    placeholder="Enter Start Date"  value="{{ !empty($cer->emp_from_date) ? $cer->emp_from_date : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="certificate_end_date_0[]"
                                                                    id="certificate_end_date_0"
                                                                    placeholder="Enter End Date"  value="{{ !empty($cer->emp_to_date) ? $cer->emp_to_date : '' }}" />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm "
                                                                    name="certificate__date_0[]" id="certificate__date_0"
                                                                    placeholder="Enter Certificate Date"  />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="highest_education[]" id="highest_education_0"
                                                                    placeholder="Enter Highest Education"   />
                                                            </td>
                                                            {{-- <td>

                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file"
                                                                            class="custom-file-input form-control"
                                                                            id="upload_app" name="upload_" />
                                                                        <label
                                                                            class="custom-file-label form-control upload_app_label"
                                                                            for="upload_app">Upload</label>
                                                                    </div>
                                                                </div>

                                                            </td> --}}
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="certificate_link[]" id="certificate_link_0"
                                                                    placeholder="Enter Certificate Link"  value="{{ !empty($cer->tr_cert_url) ? $cer->tr_cert_url : '' }}" />
                                                            </td>



                                                            <td id="med_td_action_{{ $tableIdtwo }}">
                                                                <span onclick="removeTableRowOnly(this)"
                                                                    class="btn btn-sm btn-danger"> <i
                                                                        class='fa fa-times'></i> </span>
                                                            </td>
                                                        </tr>
                                                        <td>
                                                            <input type="hidden" name="hidden_cert_tr_no_pk_id[]"
                                                                value="{{ !empty($cer->cert_tr_no_pk) ? $cer->cert_tr_no_pk : '' }}">
                                                        </td>
                                                        @php
                                                            $tableIdtwo = $tableIdtwo + 1;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            {{-- <button type="button"
                                                class="btn btn-secondary uhl_save_btn"id="">Save</button> --}}

                                            @php
                                                $response_action = route('v1.employee-detail-information');
                                            @endphp
                                            <button class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>

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
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    // openPatientAutocomplete('#employee_id', 'employee_name');
    openDoctorAutocomplete('#employee_id', 'employee_name', '', '', function(item, obj) {
        patientData(item, obj);
        obj.stopImmediatePropagation();
    });
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    function patientData(empData, patientObj) {
        console.log(empData)
        var emp_id = empData.doctor_id;
        var emr_route = $("#employee_id").attr("data-employee-route");
        window.location = emr_route + "/" + emp_id;
    }

    function addDegreeRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        row.attr('id', newId);


        // $('#degree_name_0').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Degree'
        //     }]
        // });

        // $('#education_board').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Education Board'
        //     }]
        // });
        row.find('#degree_name_' + oldId).attr('id', 'degree_name_' + newId).val($(thisElement).parents('tbody').find(
            '#degree_name_' + oldId).val());
        $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('Select');
        $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#education_board_' + oldId).val('');
        $(thisElement).parents('tbody').find('#p_year_' + oldId).val('');

        $(thisElement).parents('tbody').find('#institution_' + oldId).val('');

        $(thisElement).parents('tbody').find('#result_' + oldId).val('');
        $(thisElement).parents('tbody').find('#highest_edu_' + oldId).val('');
        $(thisElement).parents('tbody').find('#certificate_link_' + oldId).val('');

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);
        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }




    function addExperienceRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to-1").find("tr").length + 1;
        row.attr('id', newId);


        // $('#degree_name_0').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Degree'
        //     }]
        // });

        // $('#education_board').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Education Board'
        //     }]
        // });
        $(thisElement).parents('tbody').find('#company_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#company_location_' + oldId).val('');
        $(thisElement).parents('tbody').find('#designation_' + oldId).val('');
        $(thisElement).parents('tbody').find('#start_date_' + oldId).val('');
        $(thisElement).parents('tbody').find('#end_date_' + oldId).val('');
        $(thisElement).parents('tbody').find('#number_of_years_' + oldId).val('');
        $(thisElement).parents('tbody').find('#reason_of_resign_' + oldId).val('');
        $(thisElement).parents('tbody').find('#current_job_' + oldId).val('');

        row.find('#med_td_action_one_' + oldId).attr('id', 'med_td_action_one_' + newId);
        $(thisElement).parents("#data-append-to-1").append(row);
        $('#med_td_action_one_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }


    function addEcertificateRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to-two-0").find("tr").length + 1;
        row.attr('id', newId);


        // $('#degree_name_0').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Degree'
        //     }]
        // });

        // $('#education_board').val('0').select2({
        //     data: [{
        //         id: '',
        //         text: 'Select Education Board'
        //     }]
        // });
        $(thisElement).parents('tbody').find('#certificate_title_' + oldId).val('');
        $(thisElement).parents('tbody').find('#institude_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#certificate_start_date_' + oldId).val('');
        $(thisElement).parents('tbody').find('#certificate_end_date_0_' + oldId).val('');
        $(thisElement).parents('tbody').find('#certificate__date_0_' + oldId).val('');
        $(thisElement).parents('tbody').find('#highest_education_' + oldId).val('');
        $(thisElement).parents('tbody').find('#certificate_link_' + oldId).val('');

        row.find('#med_td_action_two_' + oldId).attr('id', 'med_td_action_two_' + newId);
        $(thisElement).parents("#data-append-to-two-0").append(row);
        $('#med_td_action_two_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }
</script>
