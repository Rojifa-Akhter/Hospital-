<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body pt-2">

                <div class="form-group row">
                    <label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">UHID </label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                : {{ $data->patient_code }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_name" class="col-sm-2 col-form-label col-form-label-sm">Patient Name </label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                : {{ $data->salutation }} {{ $data->patient_name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_gender" class="col-sm-2 col-form-label col-form-label-sm">Gender </label>
                    <div class="col-sm-4">
                        : {{ $data->gender_txt }}
                    </div>
                    <label for="patient_blood_group" class="col-sm-2 col-form-label col-form-label-sm">Blood Group
                    </label>
                    <div class="col-sm-4">
                        : {{ $data->blood_group_txt }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_age" class="col-sm-2 col-form-label col-form-label-sm">Patient Age </label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-prepend w-100">
                                : {{ $data->pat_age != 0 ? $data->pat_age : '' }}
                            </div>
                        </div>
                    </div>
                    <label for="patient_dob" class="col-sm-2 col-form-label col-form-label-sm">Patient DOB </label>
                    <div class="col-sm-4">
                        : {{ $data->dob != '' ? date('d/m/Y', strtotime($data->dob)) : '' }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_nationality" class="col-sm-2 col-form-label col-form-label-sm">Nationality
                    </label>
                    <div class="col-sm-4">
                        : {{ $data->nationality_text }}
                    </div>

                    <label for="patient_marital_status" class="col-sm-2 col-form-label col-form-label-sm">Marital Status
                    </label>
                    <div class="col-sm-4">
                        : {{ $data->marital_status_txt }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_religion" class="col-sm-2 col-form-label col-form-label-sm">Religion </label>
                    <div class="col-sm-4">
                        : {{ $data->religion_txt }}
                    </div>
                    <label for="patient_nid" class="col-sm-2 col-form-label col-form-label-sm">NID </label>
                    <div class="col-sm-4">
                        : {{ $data->national_id }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="patient_passport" class="col-sm-2 col-form-label col-form-label-sm">Passport No
                    </label>
                    <div class="col-sm-4">
                        : {{ $data->passport_no }}
                    </div>
                    <label for="patient_passport" class="col-sm-2 col-form-label col-form-label-sm">Occupation
                    </label>
                    <div class="col-sm-4">
                        : {{ $data->occupation_name }}
                    </div>
                </div>

                <div class="form-group row">

                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h5>Address Information</h5>
            </div>
            <div class="card-body pt-2">
                <div class="form-group row">
                    <label for="present_addres" class="col-sm-2 col-form-label col-form-label-sm">Present </label>
                    <div class="col-sm-10">
                        : {{ $data->present_addr }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">Permanent </label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            : {{ $data->permanent_addr }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Payer Information</h5>
                    </div>
                    <div class="card-body pt-2">
                        {{-- <div class="form-group row">
                            <label for="present_addres" class="col-sm-2 col-form-label col-form-label-sm">Present
                                </label>
                            <div class="col-sm-10">
                                {{ $data->present_addr }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">Permanent
                                </label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    {{ $data->permanent_addr }}
                                </div>
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="parmanent_address" class="col-sm-4 col-form-label col-form-label-sm">Payer Type
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    : {{ $data->payer_type_code }}
                                </div>
                            </div>

                            <label for="parmanent_address" class="col-sm-4 col-form-label col-form-label-sm">Payer
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    : {{ $data->ccm_client_name }}
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Others Information</h5>
                    </div>
                    <div class="card-body pt-2">
                        <div class="form-group row">

                            <label for="parmanent_address" class="col-sm-4 col-form-label col-form-label-sm">Reg.
                                Remarks
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    : {{ $data->reg_remarks }}
                                </div>
                            </div>
                            <label for="parmanent_address" class="col-sm-4 col-form-label col-form-label-sm">Edit Reason
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    : {{ $data->last_edit_reason }}
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="form-group row">
                            <label for="parmanent_address" class="col-sm-2 col-form-label col-form-label-sm">Permanent
                                </label>
                            <div class="col-sm-10">
                                <div class="input-group mb-3">
                                    {{ $data->permanent_addr }}
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Others Information</h5>
                    </div>
                    <div class="card-body pt-2">
                        <div class="form-group row">

                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    VIP : <span>{{ isset($data->vip_ind) && $data->vip_ind ==1 ?'Yes':'No' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group mb-3">
                                    Name Masking : <span>{{ isset($data->fall_risk) && $data->fall_risk ==1 ?'Yes':'No' }}</span>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    Handle With Care : <span>{{ isset($data->handle_with_care) && $data->handle_with_care ==1 ?'Yes':'No' }}</span>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="input-group mb-3">
                                    Fall Risk : <span>{{ isset($data->n_masking) && $data->n_masking ==1 ?'Yes':'No' }}</span>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Patient Image</h5>
            </div>
            <div class="card-body pt-2">
                <div class="form-group row">
                    <div class="col-sm-12  text-center">
                        @if ($data->patient_photo != '')
                            <img class="rounded w-25"
                                src="{{ asset('images/uploads/patient_images/thumb/' . $data->patient_photo) }}">
                        @else
                            @if ($data->gender == 'Male')
                                <img class="rounded w-25" src="{{ asset('images/patient.png') }}">
                            @else
                                <img class="rounded w-25" src="{{ asset('images/patient.png') }}">
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Family Information</h5>
            </div>
            <div class="card-body pt-2">
                <div class="form-group row">
                    <label for="patient_father" class="col-sm-3 col-form-label col-form-label-sm">Father </label>
                    <div class="col-sm-9">
                        : {{ $data->father_name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_mother" class="col-sm-3 col-form-label col-form-label-sm">Mother </label>
                    <div class="col-sm-9">
                        : {{ $data->mother_name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_spouse" class="col-sm-3 col-form-label col-form-label-sm">Spouse </label>
                    <div class="col-sm-9">
                        : {{ $data->spouse_name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="patient_spouse" class="col-sm-3 col-form-label col-form-label-sm">G. Name </label>
                    <div class="col-sm-9">
                        : {{ $data->guardian_name }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Contact</h5>
            </div>
            <div class="card-body pt-2">
                <div class="form-group row">
                    <label for="emergency_contact_name" class="col-sm-4 col-form-label col-form-label-sm">Mobile
                    </label>
                    <div class="col-sm-8">
                        : {{ $data->mobile1 }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="emergency_contact_address" class="col-sm-4 col-form-label col-form-label-sm">Alt.
                        Phone </label>
                    <div class="col-sm-8">
                        : {{ $data->mobile2 }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="emergency_contact_relation" class="col-sm-4 col-form-label col-form-label-sm">Email
                    </label>
                    <div class="col-sm-8">
                        : {{ $data->email }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Emergency Contact</h5>
            </div>
            <div class="card-body pt-2">
                <div class="form-group row">
                    <label for="emergency_contact_name" class="col-sm-3 col-form-label col-form-label-sm">Name
                    </label>
                    <div class="col-sm-9">
                        : {{ $data->emergency_contact_name }}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="emergency_contact_relation" class="col-sm-3 col-form-label col-form-label-sm">Relation
                    </label>
                    <div class="col-sm-9">
                        : {{ $data->emergency_contact_relation }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="emergency_contact_contact" class="col-sm-3 col-form-label col-form-label-sm">Contact
                    </label>
                    <div class="col-sm-9">
                        : {{ $data->emergency_contact_contact }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 pt-3">
        <button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data"
            data-dismiss="modal">Close</button>
        <a href="{{ route('cover.patient-admin-panel') }}" class="btn btn-info btn-md" rel="tab"
            title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
    </div>
