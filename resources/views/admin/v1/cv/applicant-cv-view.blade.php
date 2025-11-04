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
    <form action="#" id="close-applicant-cv" method="">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Applicant CV</h5>
                                <small>HRM / Applicant CV</small>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($singleApplicantInfo))
                    @foreach ($singleApplicantInfo as $basic_info)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-12">
                                                <div class="form-row">
                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="applicant_id"
                                                                class="col-sm-4 col-form-label">Applicant
                                                                ID</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control" id="applicant_id"
                                                                name="applicant_id"
                                                                value="{{ $basic_info->cvapplicant_no_pk }}" readonly /> --}}
                                                                <td>{{ $basic_info->cvapplicant_no_pk }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="applicant_date"
                                                                class="col-sm-4 col-form-label">Applicant
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control date_picker"
                                                                id="applicant_date" name="applicant_date"
                                                                value="{{ isset($basic_info->cvapplicant_date) ? date('d-m-Y', strtotime($basic_info->cvapplicant_date)) : '' }}"
                                                                readonly /> --}}
                                                                <td>{{ isset($basic_info->cvapplicant_date) ? date('d-m-Y', strtotime($basic_info->cvapplicant_date)) : '' }}
                                                                </td>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="full_name" class="col-sm-4 col-form-label">Full
                                                                Name</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control" id="full_name"
                                                                name="full_name" value="{{ $basic_info->full_name }}"
                                                                readonly /> --}}
                                                                <td>{{ $basic_info->full_name }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="dob_"
                                                                class="col-sm-4 col-form-label">DOB</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control date_picker"
                                                                id="dob_" name="dob"
                                                                value="{{ isset($basic_info->dob) ? date('d-m-Y', strtotime($basic_info->dob)) : '' }}"
                                                                readonly /> --}}
                                                                <td>{{ isset($basic_info->dob) ? date('d-m-Y', strtotime($basic_info->dob)) : '' }}
                                                                </td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="applicant_gender"
                                                                class="col-sm-4 col-form-label">Gender</label>
                                                            <div class="col-sm-8">
                                                                {{-- <select class="form-control" id="applicant_gender"
                                                                name="applicant_gender">
                                                                <option value="">Select</option>
                                                            </select> --}}
                                                                <td>{{ $basic_info->ld_gender_name }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="mobile_"
                                                                class="col-sm-4 col-form-label">Mobile</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control" id="mobile_"
                                                                name="mobile_" placeholder="" /> --}}
                                                                <td>{{ $basic_info->mobile_no }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="email"
                                                                class="col-sm-4 col-form-label">Email</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="email" class="form-control" id="email"
                                                                name="email" placeholder="" /> --}}
                                                                <td>{{ $basic_info->email }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="applicantion_circular"
                                                                class="col-sm-4 col-form-label">Application for
                                                                Circular</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control"
                                                                id="applicantion_circular" name="applicantion_circular"
                                                                placeholder="" /> --}}
                                                                <td>{{ $basic_info->applicantion_circular }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="designation"
                                                                class="col-sm-4 col-form-label">Designation</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control" id="designation"
                                                                name="designation" placeholder="" /> --}}
                                                                <td>{{ $basic_info->designation }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="post_"
                                                                class="col-sm-4 col-form-label">Post/Postion</label>
                                                            <div class="col-sm-8">
                                                                {{-- <input type="text" class="form-control" id="post_"
                                                                name="post_" placeholder="" /> --}}
                                                                <td>{{ $basic_info->post }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="deaprtment"
                                                                class="col-sm-4 col-form-label">Department</label>
                                                            <div class="col-sm-8">
                                                                {{-- <select class="form-control select2" id="department"
                                                                name="department">
                                                                <option
                                                                    value="">
                                                                    Select Department</option>
                                                            </select> --}}
                                                                <td>{{ $basic_info->serviceunit_name }}</td>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-6 col-md-6 col-12">
                                                        <div class="form-group form-row">
                                                            <label for="post_"
                                                                class="col-sm-4 col-form-label">Skill</label>
                                                            <div class="col-sm-8">
                                                                <td>{{ $basic_info->skill }}</td>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label upload_label">
                                                        Photo</label>
                                                    <div class="upload__img__box">
                                                        <div class="avatar-upload">
                                                            {{-- <div class="avatar-edit">
                                                            <input type="file" id="imageUpload" name="pat_photo"
                                                                value="" />
                                                            <label for="imageUpload"></label>
                                                        </div> --}}
                                                            <div class="avatar-preview">
                                                                <div id="imagePreview"> {{-- style="background-image: url('../images/patient.jpg');"> --}} <img
                                                                        style="border-radius: 50%;height: 100px;width: 100px;"
                                                                        src=" @if (isset($basic_info->photo)) {{ asset('uploads/cv/' . $basic_info->photo) }}"
																{{ $basic_info->photo }} @endif"
                                                                        alt="">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="form-group">
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
                                                <label for="upload_cir" class="col-form-label">Upload
                                                    Circuler</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input form-control"
                                                            id="upload_cir" name="upload_cir" />
                                                        <label class="custom-file-label form-control upload_app_label"
                                                            for="upload_cir">Upload Circuler</label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="form-group form-row">
                                    <label for="skill_" class="col-sm-2 col-form-label">Skill</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="skill_" name="skill_"
                                            placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
                                                    {{-- <th></th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to">
                                                @if (isset($ApplicantEducationInfo))
                                                    @foreach ($ApplicantEducationInfo as $education_info)
                                                        <tr id="0">
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="degree_title[]" id=""
                                                                    value="{{ $education_info->degree_title }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="universit_board[]" id=""
                                                                    value="{{ $education_info->universit_board }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="institute_name[]" id=""
                                                                    value="{{ $education_info->institute_name }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="passing_year[]" id=""
                                                                    value="{{ $education_info->passing_year }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="result[]" id=""
                                                                    value="{{ $education_info->result }}" readonly />
                                                            </td>

                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="" id=""
                                                                    value="{{ $education_info->highest_education }}"
                                                                    readonly />
                                                            </td>

                                                            {{-- <td> --}}

                                                            {{-- <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file"
                                                                        class="custom-file-input form-control"
                                                                        id="upload_app" name="upload_" />
                                                                    <label
                                                                        class="custom-file-label form-control upload_app_label"
                                                                        for="upload_app">Upload</label>
                                                                </div>
                                                            </div> --}}

                                                            {{-- </td> --}}
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id="" />
                                                            </td>
                                                        </tr>
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
                                                    {{-- <th></th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to2">
                                                @if (isset($ApplicantExperienceInfo))
                                                    @foreach ($ApplicantExperienceInfo as $experience_info)
                                                        <tr id="0">
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="company_name[]" id=""
                                                                    value="{{ $experience_info->company_name }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="company_location[]" id=""
                                                                    value="{{ $experience_info->company_location }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="old_designation[]" id=""
                                                                    value="{{ $experience_info->designation }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="start_date[]" id=""
                                                                    value="{{ isset($experience_info->start_date) ? date('d-m-Y', strtotime($experience_info->start_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm date_picker"
                                                                    name="end_date[]" id=""
                                                                    value="{{ isset($experience_info->end_date) ? date('d-m-Y', strtotime($experience_info->end_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="number_of_years[]" id=""
                                                                    value="{{ $experience_info->number_of_years }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    name="resign_reason[]" id=""
                                                                    value="{{ $experience_info->resign_reason }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    class="form-control form-control-sm"
                                                                    name="currentjob[]" id=""
                                                                    value="{{ $experience_info->currentjob }}"
                                                                    readonly />
                                                            </td>
                                                        </tr>
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
                                                    <th>Attachment</th>
                                                    <th>Certificate Link</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="data-append-to3">
                                                @if (isset($ApplicantTrainingInfo))
                                                    @foreach ($ApplicantTrainingInfo as $training_info)
                                                        <tr id="0">
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ $training_info->cert_tr_tittle }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ $training_info->institute_name }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ isset($training_info->training_from_date) ? date('d-m-Y', strtotime($training_info->training_from_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ isset($training_info->training_to_date) ? date('d-m-Y', strtotime($training_info->training_to_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ isset($training_info->training_from_date) ? date('d-m-Y', strtotime($training_info->training_from_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ isset($training_info->certification_date) ? date('d-m-Y', strtotime($training_info->certification_date)) : '' }}"
                                                                    readonly />
                                                            </td>
                                                            {{-- <td> --}}

                                                            {{-- <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file"
                                                                        class="custom-file-input form-control"
                                                                        id="upload_app" name="upload_" />
                                                                    <label
                                                                        class="custom-file-label form-control upload_app_label"
                                                                        for="upload_app">Upload</label>
                                                                </div>
                                                            </div> --}}

                                                            {{-- </td> --}}
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control form-control-sm"
                                                                    id=""
                                                                    value="{{ $training_info->tr_cert_url }}"
                                                                    readonly />
                                                            </td>
                                                        </tr>
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

                @if (isset($singleApplicantInfo))
                    @foreach ($singleApplicantInfo as $basic_info)
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
                                                    style="min-height: 100px !important;" readonly>{{ $basic_info->pe_address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="distric_city" class="col-sm-4 col-form-label">District</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12"
                                                id="distric_city" name="pr_district">
                                                <option value="">Select</option>
                                            </select> --}}

                                                <td>{{ $basic_info->pr_dist_name }}</td>
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12" id="thana"
                                                name="pr_thana">
                                                <option value="">Select</option>
                                                <option value="1"> Dhaka</option>
                                            </select> --}}
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="country" class="col-sm-4 col-form-label">Country</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12"
                                                id="present_country" name="pr_country">

                                            </select> --}}
                                                <td>{{ $basic_info->country_name }}</td>
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
                                        {{-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                    onclick="sameAddress(this)" />
                                <label class="form-check-label" for="exampleCheck1">Same As</label>
                            </div> --}}
                                        <div class="form-group form-row">
                                            <label for="address_" class="col-sm-4 col-form-label">Address</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-sm" id="par_address" name="par_address" readonly row="3"
                                                    style="min-height: 100px !important;">{{ $basic_info->pr_address }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="per_distric_city"
                                                class="col-sm-4 col-form-label">District</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12"
                                                id="per_distric_city" name="per_distric_city">
                                                <option value="">Select</option>

                                            </select> --}}
                                                <td>{{ $basic_info->pe_dist_name }}</td>
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="thana" class="col-sm-4 col-form-label">Thana</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12" id="thana_ps"
                                                name="thana_ps">
                                                <option value="">Select</option>
                                                <option value=""> Dhaka</option>
                                            </select> --}}
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="country" class="col-sm-4 col-form-label">Country</label>
                                            <div class="col-sm-8">
                                                {{-- <select class="form-control form-control-sm font_size_12" id="per_country"
                                                name="per_country">

                                            </select> --}}
                                                <td>{{ $basic_info->country_name }}</td>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif
            </div>

            @php
                $response_action = route('v1.hrm.cv-list');
            @endphp
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="form-group">
                                <ul class="list-inline btn__box">
                                    <li class="list-inline-item mb-0 mt-0">
                                        <button type="button" class="btn btn-secondary uhl_close_btn"
                                            onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                            id="close-applicant-cv">Close</button>
                                    </li>

                                    {{-- <li class="list-inline-item"><button type="button"
                                        class="btn btn-danger">Cancel</button></li> --}}
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
