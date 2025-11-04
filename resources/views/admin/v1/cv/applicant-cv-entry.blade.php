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
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<main id="page-content">
    <form action="{{ route('v1.hrm.store-cv') }}" id="applicant-cv-entry-form" method="post"
        enctype="multipart/form-data">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Applicant CV Entry</h5>
                                <small>HRM / Applicant CV Entry</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-9 col-sm-12">
                                        <div class="form-row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_id" class="col-sm-4 col-form-label">Applicant
                                                        ID</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="applicant_id"
                                                            name="applicant_id" value="{{ $applicant_id }}"
                                                            placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_date"
                                                        class="col-sm-4 col-form-label">Applicant Date</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control date_picker"
                                                            id="applicant_date" name="applicant_date" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <div class="form-group form-row">
                                                    <label for="full_name" class="col-sm-4 col-form-label">Full
                                                        Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="full_name"
                                                            name="full_name" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="dob_" class="col-sm-4 col-form-label">DOB</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control date_picker"
                                                            id="dob_" name="dob" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicant_gender"
                                                        class="col-sm-4 col-form-label">Gender</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="applicant_gender"
                                                            name="applicant_gender">
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
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="mobile_" class="col-sm-4 col-form-label">Mobile</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="mobile_"
                                                            name="mobile_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="applicantion_circular"
                                                        class="col-sm-4 col-form-label">Application for</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control select2"
                                                            id="applicantion_circular" name="applicantion_circular">
                                                            <option value="">Select</option>
                                                            @if (isset($job_circular))
                                                                @foreach ($job_circular as $circular)
                                                                    <option value="{{ $circular->jobcircular_no_pk }}"
                                                                        {{ $circularId == $circular->jobcircular_no_pk ? 'selected' : '' }}>
                                                                        {{ $circular->position_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="designation"
                                                        class="col-sm-4 col-form-label">Designation</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="designation"
                                                            name="designation" placeholder="" />
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="post_"
                                                        class="col-sm-4 col-form-label">Post/Postion</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="post_"
                                                            name="post_" placeholder="" />
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group form-row">
                                                    <label for="deaprtment"
                                                        class="col-sm-4 col-form-label">Department</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control select2" id="department"
                                                            name="department">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="form-group col-md-12">
                                            <label for="" class="col-form-label upload_label">Upload
                                                Photo</label>
                                            <div class="upload__img__box">
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type="file" id="imageUpload" name="pat_photo"
                                                            value="" />
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview"
                                                            style="background-image: url('../images/patient.jpg');">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="upload_app" class="col-form-label">Upload CV</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control"
                                                        id="upload_app" name="upload_cv" />
                                                    <label class="custom-file-label form-control upload_app_label"
                                                        for="upload_app">Upload CV</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="upload_cir" class="col-form-label">Upload Circuler</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control"
                                                        id="upload_cir" name="upload_cir" />
                                                    <label class="custom-file-label form-control upload_app_label"
                                                        for="upload_cir">Upload Circuler</label>
                                                </div>
                                            </div>
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
                                        <label for="skill_" class="col-sm-2 col-form-label">Skill</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="skill_" name="skill_"
                                                placeholder="" />
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
                                                    <th>University/Board</th>
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
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="degree_title[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="universit_board[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="institute_name[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="passing_year[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="result[]" id="" />
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="highest_education[]" id="" />
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
                                                            id="" />
                                                    </td>
                                                    {{-- <td>
                                                        <select class="form-control" id="" name="">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </td> --}}
                                                    <td>
                                                        <span type="button" class="btn btn-secondary btn-sm"
                                                            id="med_td_action_0" onclick="addRow(this)">Add</span>
                                                    </td>
                                                </tr>
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
                                            <tbody id="data-append-to2">
                                                <tr id="0">
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="company_name[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="company_location[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="old_designation[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="start_date[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="end_date[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="number_of_years[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="resign_reason[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm"
                                                            name="currentjob[]" id="" />
                                                    </td>

                                                    <td>
                                                        <span type="button" id="med_td_action_0"
                                                            onclick="addRow2(this)"
                                                            class="btn btn-secondary btn-sm">Add</span>
                                                    </td>
                                                </tr>
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
                                                    <th>Duration</th>
                                                    <th>Certification Date</th>
                                                    {{-- <th>Highest Education</th> --}}
                                                    <th>Attachment</th>
                                                    <th>Certificate Link</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to3">
                                                <tr id="0">
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="cert_tr_tittle[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="institute_name[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="training_from_date[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="training_to_date[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="training_duration[]" id="" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="certification_date[]" id="" />
                                                    </td>
                                                    {{-- <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="" />
                                                    </td> --}}
                                                    <td>

                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input form-control"
                                                                    id="tr_cert_file" name="tr_cert_file[]" />
                                                                <label
                                                                    class="custom-file-label form-control upload_app_label"
                                                                    for="upload_app">Upload</label>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="tr_cert_url[]" id="" />
                                                    </td>

                                                    <td>
                                                        <span type="button" id="med_td_action_0"
                                                            onclick="addRow3(this)"
                                                            class="btn btn-secondary btn-sm">Add</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Present Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group form-row">
                                    <label for="address_" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="pre_address" name="pre_address" placeholder="" row="3"
                                            style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="distric_city" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="distric_city"
                                            name="pr_district">
                                            <option value="">Select</option>
                                            @if (!empty($district))
                                                @foreach ($district as $row)
                                                    <option value="{{ $row->id }}">
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="thana"
                                            name="pr_thana">
                                            <option value="">Select</option>
                                            <option value="1"> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="country" class="col-sm-4 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="present_country"
                                            name="pr_country">
                                            @if (!empty($country))
                                                @foreach ($country as $row)
                                                    <option value="{{ $row->country_no_pk }}">
                                                        {{ $row->country_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Permenant Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                        onclick="sameAddress(this)" />
                                    <label class="form-check-label" for="exampleCheck1">Same As</label>
                                </div>
                                <div class="form-group form-row">
                                    <label for="address_" class="col-sm-4 col-form-label">Address</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm" id="par_address" name="par_address" placeholder="" row="3"
                                            style="min-height: 100px !important;"></textarea>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="per_distric_city" class="col-sm-4 col-form-label">District</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12"
                                            id="per_distric_city" name="per_distric_city">
                                            <option value="">Select</option>
                                            @if (!empty($district))
                                                @foreach ($district as $row)
                                                    <option value="{{ $row->id }}">
                                                        {{ $row->name }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="thana_ps"
                                            name="thana_ps">
                                            <option value="">Select</option>
                                            <option value=""> Dhaka</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-row">
                                    <label for="country" class="col-sm-4 col-form-label">Country</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm font_size_12" id="per_country"
                                            name="per_country">
                                            @if (!empty($country))
                                                @foreach ($country as $row)
                                                    <option value="{{ $row->country_no_pk }}">
                                                        {{ $row->country_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $response_action = route('v1.hrm.cv-entry');
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
    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).ready(function() {
        $('.select2').select2();
    });

    function addRow(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        row.attr('id', newId);


        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function addRow2(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to2").find("tr").length + 1;
        row.attr('id', newId);


        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to2").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function addRow3(thisElement) {

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to3").find("tr").length + 1;
        row.attr('id', newId);


        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to3").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }

    function sameAddress(element) {
        var pre_addr = $('#pre_address').val();
        var pre_thana = $('#thana_ps').find(":selected").val();
        var pre_district = $('#distric_city').find(":selected").val();
        var pre_division = $('#state_division').find(":selected").val();
        var pre_country = $('#present_country').find(":selected").val();
        console.log(pre_district);
        if ($(element).is(':checked')) {
            $('#par_address').val(pre_addr);
            $('#per_distric_city option[value="' + pre_district + '"]').attr('selected', 'selected');
            $('#per_state_division option[value="' + pre_division + '"]').attr('selected', 'selected');
            $('#per_country option[value="' + pre_country + '"]').attr('selected', 'selected');
        } else {
            $('#par_address').val('');
            $('#per_distric_city option[value=""]').attr('selected', 'selected');
            $('#per_state_division option[value=""]').attr('selected', 'selected');
            $('#per_country option[value=""]').attr('selected', 'selected');
        }
    }


    $(document).on("change", "#distric_city", function(e) {
        var disct_value = $(this).val();
        $.ajax({
            url: "{{ route('pat_all_thana_pre') }}",
            type: 'GET',
            data: {
                disct_value: disct_value
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#thana").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("change", "#per_distric_city", function(e) {
        var disct_value = $(this).val();
        $.ajax({
            url: "{{ route('pat_all_thana_pre') }}",
            type: 'GET',
            data: {
                disct_value: disct_value
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#thana_ps").html(data);

            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
