@php
$dependent = isset($dependent) && !empty($dependent) ? $dependent : [];
//dd($dependent);
$ccm_staffdep_no_pk = $dependent ? $dependent->ccm_staffdep_no_pk : '';

$staff_no_pk = $dependent ? $dependent->ccm_staff_no_fk : '';
$patient_no_fk = $dependent ? $dependent->patient_no_fk : '';

//$ccm_company_id = $dependent ? $dependent->ccm_company_id : '';
$ccm_dep_dob = $dependent ? date('d-m-Y', strtotime($dependent ->ccm_dep_dob)):'';
$ccm_patient_name = $dependent ? $dependent->ccm_patient_name : '';
$ccm_patient_relation = $dependent ? $dependent->ccm_patient_relation : '';
$contact = $dependent ? $dependent->mobile: '';
$gender_no_fk = $dependent ? $dependent->gender_no_fk : '';
$age= $dependent ? $dependent->age : '';

// $ccm_staff_name = $dependent ? $dependent->ccm_staff_name : '';
// $ccm_designation_no_fk = $dependent ? $dependent->ccm_designation_no_fk : '';
// $ccm_staff_email = $dependent ? $dependent->ccm_staff_email : '';
// $ccm_patient_no_fk = $staff_record ? $staff_record->ccm_patient_no_fk : '';
// $ccm_staff_dob = $staff_record ? $staff_record->ccm_staff_dob : '';
// $ccm_gender_no_fk = $staff_record ? $staff_record->ccm_gender_no_fk : '';
// $ccm_age = $staff_record ? $staff_record->ccm_age : '';
// $ccm_staff_contact = $staff_record ? $staff_record->ccm_staff_contact : '';
@endphp
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <!-- form start -->
        {{--form start--}}
        <form action="{{route('store.staff.dependent')}}" method="post" id="staffDependent">
            @csrf
            <input type="hidden" name="staff_no_pk" value="{{ $staff_no_pk }}">
            <input type="hidden" name="id" value="{{ $ccm_staffdep_no_pk }}">

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="patientID" class="col-form-label s-12">Patient ID</label>
                        <input type="text" class="form-control" id="Patient_ID" name="Patient_ID"
                        value="{{$patient_no_fk}}" placeholder="Patient ID" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="Patient Name" class="col-form-label s-12">Patient Name</label>
                        <input type="text" class="form-control" id="Patient_Name" name="Patient_Name"
                        value="{{$ccm_patient_name}}" placeholder="Patient Name" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactPerson" class="col-form-label s-12">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson"
                        name="contactPerson" value="{{}}" placeholder="Contact Person"
                        style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactNumber" class="col-form-label s-12">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber"
                        value="{{}}" placeholder="+880" style="margin-bottom: 0px!important;" />
                    </div>
                </div> --}}
            </div>
            <div class="form-row">
                <div class="col-md-6">

                <div class="form-group">
                    <label for="Gender" class="col-form-label s-12">Gender</label>
                    <select class="form-control mr-sm-2" id="Gender" name="Gender">
                        <option selected value="">Choose gender</option>
                        @if(isset($gender))
                        @foreach($gender as $key=>$value)
                        <option value="{{$key}}" {{$key==$gender_no_fk?'selected':''}}>{{$value}}</option>
                         @endforeach
                        @endif
                    </select>
                </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contact_no" class="col-form-label s-12">Contact Number</label>
                        <input type="text" class="form-control" id="Contact_Number" name="Contact_Number"
                        value="{{$contact}}" placeholder="Contact Number" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactPerson" class="col-form-label s-12">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson"
                        name="contactPerson" value="{{}}" placeholder="Contact Person"
                        style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactNumber" class="col-form-label s-12">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber"
                        value="{{}}" placeholder="+880" style="margin-bottom: 0px!important;" />
                    </div>
                </div> --}}
            </div>
            <div class="form-row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB" value="{{$ccm_dep_dob}}"
                                class="form-control" />
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <input type="text" id="Age" name="Age" value="{{$age}}"
                                class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="relataion" class="col-form-label s-12">Relation</label>
                        <input type="text" class="form-control" id="Relation" name="Relation"
                        value="{{$ccm_patient_relation}}" placeholder="Relation" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactPerson" class="col-form-label s-12">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson"
                        name="contactPerson" value="{{}}" placeholder="Contact Person"
                        style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactNumber" class="col-form-label s-12">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber"
                        value="{{}}" placeholder="+880" style="margin-bottom: 0px!important;" />
                    </div>
                </div> --}}
            </div>


            {{-- <div class="form-row">
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="Email" class="col-form-label s-12">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                        value="{{}}" placeholder="example@mail.com" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Patient ID</label>
                        <input type="text" class="form-control" id="patientID"
                        name="patientID" value="{{}}" placeholder="Patient ID" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB" value=""
                                class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">

                    <label for="Gender" class="col-form-label s-12">Relation</label>
                    <input type="text" class="form-control" id="companyName" name="companyName"
                    value="" placeholder="Company Name" style="margin-bottom: 0px!important;" />

                </div>
            </div> --}}
            <div class="modal-footer mt-1 text-left">
                @php
                $response_action = route('corporate.staff-entry');
                @endphp
                {{-- <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button> --}}
                {{-- <button type="button" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save changes</button> --}}

            </div>

            <button type="button" class="btn btn-info btn-md btn-block" title="" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">ADD</button>

            {{-- <button type="submit" class="btn btn-info btn-md btn-block" title="">ADD</button> --}}

        </form>

        <!-- form end -->
    </div>
</div>

