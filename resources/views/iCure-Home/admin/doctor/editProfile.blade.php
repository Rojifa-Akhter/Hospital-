@extends('iCure-Home.admin.partials.cover_master')
@section('admin_content')

    @push('doctor_css')
        <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    @endpush

    @php
    $doctor = isset($data) && !empty($data) ? $data : [];

    $doctor_code = $doctor ? $doctor->person_code : '';
    $doctor_no_pk = $doctor ? $doctor->person_no_pk : '';
    $ref_agent_person_no_fk = $doctor ? $doctor->ref_agent_person_no_fk : '';
    $apps_user = $doctor ? $doctor->apps_user_ind : '';
    $passcode = $doctor ? $doctor->agent_access_code : '';
    $employee_ind = $doctor ? $doctor->employee_ind : '';
    $doctor_salutation = $doctor ? $doctor->salutation : '';
    $doctor_first_name = $doctor ? $doctor->fname : '';
    $doctor_last_name = $doctor ? $doctor->lname : '';
    $doctor_age = $doctor ? $doctor->age : '';
    $doctor_date_of_birth = $doctor ? $doctor->dob : '';

    $place_of_birth = $doctor ? $doctor->place_of_birth : '';
    $doctor_address1 = $doctor ? $doctor->emergency_contact_addr : '';
    $doctor_address2 = $doctor ? $doctor->present_addr : '';
    $doctor_address3 = $doctor ? $doctor->permanent_addr : '';
    $doctor_nid = $doctor ? $doctor->nid_no : '';
    $doctor_mobile = $doctor ? $doctor->phone_mobile : '';
    $doctor_father = $doctor ? $doctor->father_name : '';
    $father_name_bangla = $doctor ? $doctor->father_name_bangla : '';
    $doctor_mother = $doctor ? $doctor->mother_name : '';
    $doctor_mother_bangla = $doctor ? $doctor->mother_name_bangla : '';
    $doctor_spouse = $doctor ? $doctor->spouse_name : '';
    $spuse_name_bangla = $doctor ? $doctor->spouse_name_bangla : '';
    $email_personal = $doctor ? $doctor->email_personal : '';
    $phone_mobile = $doctor ? $doctor->phone_mobile : '';
    $doctor_blood_group = $doctor ? $doctor->blood_group_lookup_no_fk : '';
    $doctor_job_type = $doctor ? $doctor->job_type_lookup_no_fk : '';
    $doctor_hr_type = $doctor ? $doctor->hr_type_lookup_no_fk : '';
    $doctor_emp_type = $doctor ? $doctor->emp_type_lookup_no_fk : '';
    $doctor_job_title = $doctor ? $doctor->jobtitle_lookup_no_fk : '';
    $grade_no_fk = $doctor ? $doctor->grade_no_fk : '';
    $roster_type = $doctor ? $doctor->duty_roster_type : '';
    $inactivate_resson = $doctor ? $doctor->inactivate_resson : '';
    $inactivate_date = $doctor ? $doctor->inactivate_date : '';

    $bank_name = $doctor ? $doctor->bank_name : '';
    $bank_acc_no = $doctor ? $doctor->bank_acc_no : '';
    $bank_acc_name = $doctor ? $doctor->bank_acc_name : '';
    $agent_banking_type = $doctor ? $doctor->agent_banking_type : '';
    $agent_banking_no = $doctor ? $doctor->agent_banking_no : '';
    $security_money_amount = $doctor ? $doctor->security_money_amount : '';
    $security_money_received_date = $doctor ? $doctor->security_money_received_date : '';

    $photo_name = $doctor ? $doctor->photo_name : '';
    // $gender_txt = $doctor ? $doctor_data->gender_txt : '';

    $department = $doctor ? $doctor->serviceunit_no_fk : '';
    $doctor_join_date = $doctor ? $doctor->join_date : '';

    $doctor_lic_no = $doctor ? $doctor->doc_lic_no : '';
    $pr_post_code = $doctor ? $doctor->pr_post_code : '';
    $remarks_text = $doctor ? $doctor->remarks_text : '';
    $doctor_lic_issue_date = $doctor && $doctor->license_issue_date ? date('d-m-Y', strtotime($doctor->license_issue_date)) : '';
    $doctor_card_number = $doctor ? $doctor->card_no : '';
    $present_address = $doctor ? $doctor->pr_addr1 : '';
    $salary_ind = $doctor ? $doctor->salary_ind : '';
    $bonus_eligibility = $doctor ? $doctor->bonus_elig_ind : '';

    $permanent_address = $doctor ? $doctor->pe_addr1 : '';
    $emergency_contact_address = $doctor ? $doctor->emergency_contact_addr : '';

    $accomodation_ind = $doctor ? $doctor->accomodation_ind : '';
    $transport_ind = $doctor ? $doctor->transport_ind : '';
    $provident_fund_type = $doctor ? $doctor->provident_fund_type : '';
    $ot_payable_ind = $doctor ? $doctor->ot_payable_ind : '';

    $user_into = isset($user_into) && !empty($user_into) ? $user_into : [];
    $user_name = $user_into ? $user_into->user_name : '';

    // $chamber = isset($chamber_doctor_details) && !empty($chamber_doctor_details) ? $chamber_doctor_details : [];
    // dd($chamber);

    @endphp


    <!--Page header-->
    <div class="page-header shadow-sm">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Edit Profile</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Pages</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Edit Profile</a></li>
            </ol>
        </div>
        <div class="page-rightheader">
            <div class="btn btn-list">
            </div>
        </div>
    </div>
    <!--End Page header-->

    <!-- Row -->


    @csrf
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card box-widget widget-user">
                <div class="widget-user-image mx-auto mt-5">

                    @if ($photo_name != '')
                        <img class="rounded"
                            src="{{ asset('images/uploads/doctor_images/thumb/' . $photo_name) }}">
                    @else
                        {{-- @if (ucfirst($gender_txt) == 'Male')
                            <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                        @else
                            <img class="rounded" src="{{ asset('images/nurse-2.png') }}">
                        @endif --}}
                        <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                    @endif

                    {{-- <img alt="User Avatar" class="rounded-circle" src="{{ asset('coverpage/img/doc7.jpg') }}" /> --}}

                </div>
                <div class="card-body text-center pt-2">
                    <div class="pro-user">
                        <h3 class="pro-user-username text-dark mb-1 fs-22">
                            {{ !empty($doctor_data->full_name) ? $doctor_data->full_name : '' }}</h3>
                        <h6 class="pro-user-desc text-muted">
                            {{ !empty($doctor_data->su_name) ? $doctor_data->su_name : '' }}
                        </h6>
                        <div class="text-center mb-4">
                            <span><i class="fa fa-star text-warning"></i></span>
                            <span><i class="fa fa-star text-warning"></i></span>
                            <span><i class="fa fa-star text-warning"></i></span>
                            <span><i class="fas fa-star-half-alt text-warning"></i></span>
                            <span><i class="far fa-star text-warning"></i></span>
                        </div>
                        <a href="{{ route('mcare.doctor-profile', Auth::user()->person_no_fk) }}"
                            class="btn btn-primary mt-3">View Profile</a>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="row">
                        <div class="col-sm-6 border-right text-center">
                            <div class="description-block p-4">
                                <h5 class="description-header mb-1 font-weight-bold text-dark number-font">
                                    {{ $doctor_list[0]->appointment_patient }}</h5>
                                <span class="text-muted">Patients</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block text-center p-4">
                                <h5 class="description-header mb-1 font-weight-bold text-dark number-font">
                                    {{ $doctor_list[0]->prescribed_list }}</h5>
                                <span class="text-muted">Prescribed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Password</div>
                </div>
                <form action="{{ route('mcare-update-doctor', $doctor_no_pk) }}" method="post" id="editprofile">
                    <div class="card-body">
                        <div class="text-center mb-5">
                            <div class="widget-user-image">

                                @if ($photo_name != '')
                                    <img class="rounded"
                                        src="{{ asset('images/uploads/doctor_images/thumb/' . $photo_name) }}">
                                @else
                                    {{-- @if (ucfirst($gender_txt) == 'Male')
                                        <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                                    @else
                                        <img class="rounded" src="{{ asset('images/nurse-2.png') }}">
                                    @endif --}}
                                    <img class="rounded" src="{{ asset('images/doc-1.png') }}">
                                @endif
                                {{-- <img alt="User Avatar" class="rounded-circle mr-3" src="../../assets/images/users/2.jpg" /> --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" placeholder="Old Password" name="old_password" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control form-control-sm " id="password" name="password"
                                value="" placeholder="Password" onkeyup='check();' minlength="6">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm " id="password2" name="password2"
                                value="" placeholder="Confirm Password" onkeyup='check();' minlength="6">
                        </div>

                        <span id='message'></span>
                    </div>
                    <div class="card-footer text-right">

                        @php
                            $response_action = route('mcare.doctor.edit_profile', $doctor_no_pk);
                        @endphp
                        <button class="btn btn-primary"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            updated</button>
                        <a href="#" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-xl-9 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profile</div>
                </div>

                <form action="{{ route('mcare-update-doctor-info', $doctor_no_pk) }}" method="post" id="editprofileInfo">
                    @csrf
                    <div class="card-body">
                        <div class="card-title font-weight-bold">Basic info:</div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="doctor_first_name"
                                        name="doctor_first_name" value="{{ $doctor_first_name }}"
                                        placeholder="First Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)"
                                        required="required" maxlength="50" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="doctor_last_name" name="doctor_last_name"
                                        value="{{ $doctor_last_name }}" placeholder="Last Name"
                                        onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)" maxlength="50" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="doctor_email" name="doctor_email"
                                        value="{{ $email_personal }}"
                                        pattern="[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*"
                                        placeholder="abc@gmail.com" maxlength="50" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" id="doctor_mobile_no"
                                        name="doctor_mobile_no" value="{{ $phone_mobile }}" placeholder="Mobile No"
                                        required maxlength="15" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Chamber Address</label>
                                    <input type="text" class="form-control" placeholder="Home Address"
                                        name="chamber_add" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">BMDC/ Licence No</label>
                                    <input type="text" class="form-control" placeholder="BMDC/ Licence No"
                                        name="doctor_lic_no" value="{{ $doctor_lic_no }}" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label class="form-label">Postal Code</label>
                                    <input type="number" class="form-control" placeholder="ZIP Code" name="zip_code"
                                        value="{{ $pr_post_code }}" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <select class="form-control select2" name="country">
                                        <option value="Bangladeshi">Select Country</option>
                                        @if (isset($nationality))
                                            @foreach ($nationality as $key => $value)
                                                <option value="{{ $value }}" {{-- @if ($patient_nationality == $key) selected @endif --}}
                                                    {{ $value == 'Bangladeshi' ? 'selected' : '' }}>{{ $value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>






                        {{-- Education --}}

                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="table mt-2 mb-0" id="mytable">
                                    <thead>
                                        <tr>
                                            <th class="p-0">Degree Name</th>
                                            <th class="p-0 ">Result</th>
                                            <th class="p-0 ">Passing Year</th>
                                            <th class="p-0 ">Board/ Institute</th>
                                        </tr>
                                    </thead>

                                    <tbody id="data-append-to">
                                        <tr id="0">
                                            <td class="">


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

                                            <td class="">
                                                <input type="
                                                                                            text" class="form-control"
                                                    id="result_0" name="result[]" placeholder="Result" maxlength="20">
                                            </td>
                                            <td class="">
                                                <input type="
                                                                                            text"
                                                    class="form-control number_only" id="p_year_0" name="p_year[]"
                                                    placeholder="Passing Year" maxlength="10">
                                            </td>
                                            <td class="">
                                                <input type="
                                                                                            text" class="form-control"
                                                    id="institution_0" name="institution[]" placeholder="Board/Institute"
                                                    maxlength="100">
                                            </td>
                                            <td id="med_td_action_0">
                                                <span onclick="addDegreeRow(this)" class="btn btn-md btn-success"> +Add
                                                </span>
                                            </td>
                                        </tr>
                                        @php
                                            $tableId = 2;
                                        @endphp

                                        @if (!empty($educationInfo))
                                            @foreach ($educationInfo as $education)
                                                <tr id="{{ $tableId }}">
                                                    <td>


                                                        <select class="form-control font_size_12 m-auto select2"
                                                            name="name[]">
                                                            @if (!empty($degree))
                                                                @foreach ($degree as $key => $value)
                                                                    <option value="{{ $key }}"
                                                                        {{ $education->degree_name == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control" name="result[]"
                                                            placeholder="Result" value="{{ $education->result_text }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="p_year[]"
                                                            placeholder="Passing Year"
                                                            value="{{ $education->passing_year }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="institution[]"
                                                            placeholder="Board" value="{{ $education->institute_name }}">
                                                    </td>
                                                    <td id="med_td_action_{{ $tableId }}">
                                                        <span onclick="removeTableRowOnly(this)"
                                                            class="btn btn-sm btn-danger"> <i class='fa fa-times'></i>
                                                        </span>
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
                        {{-- end --}}






                        <div class="card-title font-weight-bold mt-5">Biography:</div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">About Me</label>
                                    <textarea rows="5" class="form-control" placeholder="Enter About your description"
                                        name="bio">{{ $remarks_text }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        @php
                            $response_action = route('patient.doctor-details');
                        @endphp
                        <button class="btn btn-primary"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            updated</button>
                        <a href="#" class="btn btn-danger">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Row-->
@endsection


@push('admin_js')
    <script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script>
        $('.select2').select2();
        openDoctorDegreeAutocomplete('#doctor_degree1');
        openDoctorDegreeAutocomplete('#doctor_degree2');
        openDoctorDegreeAutocomplete('#doctor_degree3');
        openDoctorDegreeAutocomplete('#doctor_degree4');

        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('password2').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'matching';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'not matching';
            }
        }

        function addDegreeRow(thisElement) {

            var row = $(thisElement).parents("tr").clone();
            var oldId = Number($(thisElement).parents("tr").attr("id"));
            var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
            row.attr('id', newId);
            $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');


            $('#degree_name_0').val('0').select2({
                data: [{
                    id: '',
                    text: 'Select Degree'
                }]
            });
            /*        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
                    $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
                    $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
                    $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');
                    $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('DAY');
                    $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('');
                    $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
                    $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');*/
            row.find('#degree_name_' + oldId).attr('id', 'degree_name_' + newId).val($(thisElement).parents('tbody').find(
                '#degree_name_' + oldId).val());
            $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('Select');
            $(thisElement).parents('tbody').find('#degree_name_' + oldId).val('');
            $(thisElement).parents('tbody').find('#p_year_' + oldId).val('');

            $(thisElement).parents('tbody').find('#institution_' + oldId).val('');

            $(thisElement).parents('tbody').find('#result_' + oldId).val('');

            row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
            $(thisElement).parents("#data-append-to").append(row);

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
    </script>

@endpush
