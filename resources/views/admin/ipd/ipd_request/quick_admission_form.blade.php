@php
    $ipd_admission = (isset($ipd) && (!empty($ipd))) ? $ipd : [];
    $admission_no_pk = ($ipd_admission) ? $ipd_admission->admission_no_pk : '';
    $admission_uid = ($ipd_admission) ? $ipd_admission->admission_uid : '';
    $admission_date = ($ipd_admission) ? $ipd_admission->admission_date : '';
    $primary_doctor_no_fk = ($ipd_admission) ? $ipd_admission->primary_doctor_no_fk : '';
    $duty_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->duty_doc_person_no_fk : '';
    $initial_bed_no_fk = ($ipd_admission) ? $ipd_admission->initial_bed_no_fk : '';
    $curr_bed_no_fk = ($ipd_admission) ? $ipd_admission->curr_bed_no_fk : '';
    $curr_ward_no_fk = ($ipd_admission) ? $ipd_admission->curr_ward_no_fk : '';
    $reg_type_no_fk = ($ipd_admission) ? $ipd_admission->reg_type_no_fk : '';
    $su_no_fk = ($ipd_admission) ? $ipd_admission->su_no_fk : '';
    $prescription_no_fk = ($ipd_admission) ? $ipd_admission->prescription_no_fk : '';
    $prescription_uid = ($ipd_admission) ? $ipd_admission->prescription_uid : '';
    $appointment_no_fk = ($ipd_admission) ? $ipd_admission->appointment_no_fk : '';
    $opd_department_su_no_fk = ($ipd_admission) ? $ipd_admission->opd_department_su_no_fk : '';
    $opd_department_name = ($ipd_admission) ? $ipd_admission->opd_department_name : '';
    $status = ($ipd_admission) ? $ipd_admission->status : '';
    $first_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->first_ref_doc_person_no_fk : '';
    $second_ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->second_ref_doc_person_no_fk : '';
    $ref_doc_person_no_fk = ($ipd_admission) ? $ipd_admission->ref_doc_person_no_fk : '';
    $patient_no_fk = ($ipd_admission) ? $ipd_admission->patient_no_fk : '';


    $IpdAdmissionDetails = (isset($IpdAdmissionDetails) && (!empty($IpdAdmissionDetails))) ? $IpdAdmissionDetails : [];
    $admission_no_pk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->admission_no_pk : '';
    $pat_condition = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_condition : '';
    $arrival_mode = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->arrival_mode : '';
    $accompanied_by = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->accompanied_by : '';
    $cause_of_admission = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->cause_of_admission : '';
    $contact_person = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person : '';
    $contact_person_mobile = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_person_mobile : '';
    $contact_relaion = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->contact_relaion : '';
    $ward_no_fk = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->ward_no_fk : '';
    $remarks = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->remarks : '';
    $pat_valuable_accessories = ($IpdAdmissionDetails) ? $IpdAdmissionDetails->pat_valuable_accessories : '';


@endphp
<form id="quick_admission_form" action="{{ route('ipd.store-quick-admission') }}" method="post">
    <div class="form-row">
        <div class="col-md-7">
            <div class="card ml-2">
                <div class="card-header">
                    <h5>Admission Form</h5>
                </div>
                <div class="card-body mt-2">
                    <div class="form-group form-row border-bottom">
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.patientType(this)"
                                       type="radio" name="patienttype" id="patient_type1" value="1" checked />
                                <label class="form-check-label" for="patient_type1">Registered</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" onchange="bedViewer.patientType(this)"
                                       type="radio" name="patienttype" id="patient_type2" value="2" />
                                <label class="form-check-label" for="patient_type2">Non-Registered</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="registered_patient">
                                <div class="form-group">
                                    <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" />
                                    <input type="text" class="form-control form-control-sm m-0 mb-0"
                                           id="service_number" name="service_number" value=""
                                           placeholder="Patient ID" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="registered_patient col-md-12">
                            <div class="mt-2 pat_data patient_details d-none" id="patient_details">
                                @include('admin.components.patient_info_min')
                            </div>
                        </div>
                    </div>

                    {{-- ******************** Non Register ********************************************** --}}
                    <div class="non_registered_patient d-none mb-3 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fa fa-user"></i>&nbsp; Patient Quick Registration
                                </h5>
                            </div>
                            <div class="card-body pt-2">
                                @include('admin.patient.patient_quick_registration_form')
                            </div>
                        </div>
                    </div>
                    {{-- *********** non register form end ************** --}}

                    <div class="form-row mt-2">
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="request_department">Department
                                <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm select2"
                                    onchange="bedViewer.getWard(this)" id="request_department"
                                    name="request_department" required>
                                <option value="">select department</option>
                                @if (!empty($requestDepts))
                                    @foreach ($requestDepts as $rd)
                                        <option value="{{ $rd->serviceunit_no_pk }}">
                                            {{ $rd->serviceunit_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4" id="ward_container">
                            @include('admin.ipd.ipd_request.ipd_ward')
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="primary_doctor">Primary
                                Doctor / Admitted Under <span class="text-danger">*</span></label>
                            <input type="hidden" id="doctor_id" name="doctor_id" />
                            <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                   name="primary_doctor" maxlength="50" value="{{$primary_doctor_no_fk}}" placeholder="primay doctor"
                                   required />
                        </div>


                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="referral_doctor">Referral
                                Doctor </label>
                            <input type="hidden" id="ref_doc" name="ref_doc" />
                            <input type="text" class="form-control form-control-sm m-0" id="referral_doctor"
                                   name="referral_doctor" maxlength="50" value="{{$ref_doc_person_no_fk}}"
                                   placeholder="Enter Referral doctor" />
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="first_ref">First Referral
                            </label>
                            <input type="hidden" id="first_ref" name="first_ref" />
                            <input type="text" class="form-control form-control-sm m-0" id="first_referral"
                                   name="first_referral" maxlength="50" value="{{$first_ref_doc_person_no_fk}}"
                                   placeholder="Enter First Referral" />
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="second_ref">Second Referral
                            </label>
                            <input type="hidden" id="second_ref" name="second_ref" />
                            <input type="text" class="form-control form-control-sm m-0" id="second_referral"
                                   name="second_referral" maxlength="50" value="{{$second_ref_doc_person_no_fk}}" placeholder="Second Referral" />
                        </div>



                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="patient_condition">Patient
                                Condition</label>
                            <select class="form-control form-control-sm select2" id="patient_condition"
                                    name="patient_condition">
                                <option value="">select patient condition</option>
                                @if (!empty($patientConditions))
                                    @foreach ($patientConditions as $pk => $patcon)
                                        <option value="{{ $pk }}">{{ $patcon }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="col-form-label col-form-label-sm"
                                   for="patient_valuable_accessories">Patient's
                                Valuable accessories</label>
                            <input type="text" class="form-control form-control-sm m-0"
                                   id="patient_valuable_accessories" name="patient_valuable_accessories" value="{{$pat_valuable_accessories}}"
                                   maxlength="50" placeholder="patient's valuable accessories" />
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="arrival_mode">Arrival
                                Mode</label>
                            <select class="form-control form-control-sm select2" id="arrival_mode"
                                    name="arrival_mode">
                                <option value="">select arrival mode</option>
                                @if (!empty($arrivalModes))
                                    @foreach ($arrivalModes as $pk => $am)
                                        <option value="{{ $pk }}">{{ $am }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="col-form-label col-form-label-sm" for="cause_of_admission">Cause
                                Of Admission</label>
                            <input type="text" class="form-control form-control-sm m-0" id="cause_of_admission"
                                   name="cause_of_admission" maxlength="50" value=""
                                   placeholder="Cause of Admission" />
                        </div>

                        <div class="col-md-8">
                            <label class="col-form-label col-form-label-sm"
                                   for="admission_remarks">Remarks</label>
                            <input type="text" class="form-control form-control-sm m-0" id="admission_remarks"
                                   name="admission_remarks" maxlength="50" value="" placeholder="Remarks Here" />
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="external_hospital">External
                                Hospital</label>
                            <input type="text" class="form-control form-control-sm m-0" id="external_hospital"
                                   name="external_hospital" maxlength="50" value=""
                                   placeholder="External hospital Name" />
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm"
                                   for="accompanied_Guardian by">Accompanied
                                By/
                                Guardian</label>
                            <input type="text" class="form-control form-control-sm m-0"
                                   id="accompanied_Guardian" maxlength="50" name="accompanied_by" value=""
                                   placeholder="Ex: Billal Mia" />
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="relation">Relation</label>
                            <input type="text" class="form-control form-control-sm m-0" id="relation"
                                   maxlength="50" name="relation" value=""
                                   placeholder="Father/Mother/Sister/Brother..." />
                        </div>
                        <div class="col-md-4">
                            <label class="col-form-label col-form-label-sm" for="phone_number by">Phone
                                Number</label>
                            <input type="text" class="form-control form-control-sm m-0 number_only"
                                   id="phone_number" name="phone_number" minlength="10" maxlength="15" value=""
                                   placeholder="Ex:017********" />
                        </div>
                    </div>
                    @php $response_action = route('ipd.ipd-admission'); @endphp

                    <div class="mt-2 modal-inline">

                        <button type="submit" class="btn btn-md btn-success"
                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                            Save
                        </button>
                        {{--                                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">--}}
                        {{--                                    Clear--}}
                        {{--                                </button>--}}
                        {{--                                <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">--}}
                        {{--                                    Exit--}}
                        {{--                                </button>--}}
                        <button type="reset" class="btn btn-md btn-info">Reset</button>
                        <a href="{{ route('ipd.ipd-admission') }}" class="btn btn-danger btn-md" rel="tab"
                           title="Click here to go back to Dashboard">Exit</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="Bed_data">
                <div class="card">
                    <div class="card-header">
                        <h5>Bed Viewer</h5>
                    </div>
                    <div class="card-body" id="Bed_data">
                        @include('admin.ipd.ipd_request.ipd_bed_viewer')
                    </div>
                </div>
                <div class="mt-2 bed_data d-none" id="bedAndPatientData">
                    @include('admin.ipd.ipd_request.bed_data_view')
                </div>
            </div>
        </div>
    </div>
</form>

