@php
$staff_record = isset($staff_record) && !empty($staff_record) ? $staff_record : [];
//dd($staff_record);
$ccm_staff_no_pk = $staff_record ? $staff_record->ccm_staff_no_pk : '';
$ccm_company_id = $staff_record ? $staff_record->ccm_company_id : '';
$ccm_company_name = $staff_record ? $staff_record->ccm_company_name : '';
$ccm_contact_person = $staff_record ? $staff_record->ccm_contact_person : '';
$ccm_contact_number = $staff_record ? $staff_record->ccm_contact_number : '';
$ccm_staff_id = $staff_record ? $staff_record->ccm_staff_id : '';
$ccm_staff_name = $staff_record ? $staff_record->ccm_staff_name : '';
$ccm_designation_no_fk = $staff_record ? $staff_record->ccm_designation_no_fk : '';
$ccm_staff_email = $staff_record ? $staff_record->ccm_staff_email : '';
$ccm_patient_no_fk = $staff_record ? $staff_record->ccm_patient_no_fk : '';
$ccm_staff_dob = $staff_record ? date('d-m-Y', strtotime($staff_record->ccm_staff_dob)):'';
//dd($ccm_staff_dob);
$ccm_gender_no_fk = $staff_record ? $staff_record->ccm_gender_no_fk : '';
$ccm_age = $staff_record ? $staff_record->ccm_age : '';
$ccm_staff_contact = $staff_record ? $staff_record->ccm_staff_contact : '';


@endphp
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <!-- form start -->
        {{--form start--}}
        <form action="{{route('corporate.staff.store')}}" method="post" id="staffedit">
            @csrf
            <input type="hidden" name="id" value="{{ $ccm_staff_no_pk }}">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="companyId" class="col-form-label s-12">Company ID</label>
                        <input type="text" class="form-control" id="companyId" name="companyId"
                        value="{{$ccm_company_id}}" placeholder="Company ID" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="companyName" class="col-form-label s-12">Company Name</label>
                        <input type="text" class="form-control" id="companyName" name="companyName"
                        value="{{$ccm_company_name}}" placeholder="Company Name" style="margin-bottom: 0px!important;" />
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
                {{-- <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="companyId" class="col-form-label s-12">Company ID</label>
                        <input type="text" class="form-control" id="companyId" name="companyId"
                        value="" placeholder="Company ID" style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="companyName" class="col-form-label s-12">Company Name</label>
                        <input type="text" class="form-control" id="companyName" name="companyName"
                        value="" placeholder="Company Name" style="margin-bottom: 0px!important;" />
                    </div>
                </div> --}}

                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactPerson" class="col-form-label s-12">Contact Person</label>
                        <input type="text" class="form-control" id="contactPerson"
                        name="contactPerson" value="{{$ccm_contact_person}}" placeholder="Contact Person"
                        style="margin-bottom: 0px!important;" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 0px!important;">
                        <label for="contactNumber" class="col-form-label s-12">Contact Number</label>
                        <input type="tel" class="form-control" id="contactNumber" name="contactNumber"
                        value="{{$ccm_contact_number}}" placeholder="+880" style="margin-bottom: 0px!important;" />
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID" class="col-form-label s-12">ID</label>
                        <input type="text" class="form-control" id="Id" name="Id" value="{{$ccm_staff_id}}"
                        placeholder="Staff ID" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Name" class="col-form-label s-12">Name</label>
                        <input type="text" class="form-control" id="Name" name="Name" value="{{$ccm_staff_name}}"
                        placeholder="Staff Name" />
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <label for="Designation" class="col-form-label s-12">Designation</label>
                    <select class="form-control mr-sm-2 select2" id="Designation" name="Designation">
                        <option selected value="">Choose designation</option>
                        @if(isset($designation))
                        @foreach($designation as $record)
                        <option value="{{$record->designation_no_pk}}" {{$record->designation_no_pk == $ccm_designation_no_fk? 'selected': ''}}>{{$record->designation_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Contact" class="col-form-label s-12">Contact</label>
                        <input type="tel" class="form-control" id="Contact" name="Contact"
                        value="" placeholder="+880" />
                    </div>
                </div> --}}
            </div>
            <div class="form-row">
                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID" class="col-form-label s-12">ID</label>
                        <input type="text" class="form-control" id="Id" name="Id" value=""
                        placeholder="Staff ID" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Name" class="col-form-label s-12">Name</label>
                        <input type="text" class="form-control" id="Name" name="Name" value=""
                        placeholder="Staff Name" />
                    </div>
                </div> --}}

                <div class="col-md-6">
                    <label for="Designation" class="col-form-label s-12">Designation</label>
                    <select class="form-control mr-sm-2 select2" id="Designation" name="Designation">
                        <option selected value="">Choose designation</option>
                        @if(isset($designation))
                        @foreach($designation as $record)
                        <option value="{{$record->designation_no_pk}}" {{$record->designation_no_pk == $ccm_designation_no_fk? 'selected': ''}}>{{$record->designation_name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Contact" class="col-form-label s-12">Contact</label>
                        <input type="tel" class="form-control" id="Contact" name="Contact"
                        value="{{$ccm_staff_contact}}" placeholder="+880" />
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Email" class="col-form-label s-12">Email</label>
                        <input type="email" class="form-control" id="Email" name="Email"
                        value="{{$ccm_staff_email}}" placeholder="example@mail.com" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Patient ID</label>
                        <input type="text" class="form-control" id="patientID"
                        name="patientID" value="{{$ccm_patient_no_fk}}" placeholder="Patient ID" />
                    </div>
                </div>

                {{-- <div class="col-md-5">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB" value="{{}}"
                            class="form-control" />
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <input type="text" id="Age" name="Age" value="{{}}"
                            class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="Gender" class="col-form-label s-12">Gender</label>
                    <select class="form-control mr-sm-2" id="Gender" name="Gender">
                        <option selected value="{{}}">Choose gender</option>
                        @if(isset($gender))
                        @foreach($gender as $key=>$value)
                        <option value="{{$key}}"  {{$key == $ccm_gender_no_fk? 'selected': ''}}>{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div> --}}
            </div>
            <div class="form-row">
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
                </div> --}}

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="patientID" class="col-form-label s-12">Date Of Birth</label>
                        <div class="input-group">
                            <input type="date" id="DOB" name="DOB"
                            class="form-control" value="{{$ccm_staff_dob}}"/>
                            <div class="input-group-prepend">
                                <span class="input-group-text">Age</span>
                            </div>
                            <input type="text" id="Age" name="Age" value="{{$ccm_age}}"
                            class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="Gender" class="col-form-label s-12">Gender</label>
                    <select class="form-control mr-sm-2" id="Gender" name="Gender">
                        <option selected value="">Choose gender</option>
                        @if(isset($gender))
                        @foreach($gender as $key=>$value)
                        <option value="{{$key}}"  {{$key == $ccm_gender_no_fk? 'selected': ''}}>{{$value}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
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
<script type="text/javascript">
    $(function() {

        $("input[name=Deposit]:radio").click(function() {
            if ($('input[name=Deposit]:checked').val() == "1") {
                $('.deposit-text-box').show();
            }
        });

    });
</script>

