@php

$referral_doctor = (isset($referral_doctor) && (!empty($referral_doctor))) ? $referral_doctor : [];

$ref_doc_no_pk = ($referral_doctor) ? $referral_doctor->person_no_pk : '';
$ref_doc_salutation = ($referral_doctor) ? $referral_doctor->salutation : '';
$ref_doc_first_name = ($referral_doctor) ? $referral_doctor->fname : '';
$ref_doc_last_name = ($referral_doctor) ? $referral_doctor->lname : '';
$ref_doc_qualification = ($referral_doctor) ? $referral_doctor->qualification : '';
$ref_doc_location = ($referral_doctor) ? $referral_doctor->pr_addr1 : '';
$ref_doc_phone_mobile = ($referral_doctor) ? $referral_doctor->phone_mobile : '';
$ref_doc_email_personal = ($referral_doctor) ? $referral_doctor->email_personal : '';
$ref_doc_area = ($referral_doctor) ? $referral_doctor->pe_addr1 : '';
// $ref_doc_photo = ($referral_doctor) ? $referral_doctor->photo_name : '';
$status = ($referral_doctor) ? $referral_doctor->status : '';
$ref_code = ($referral_doctor) ? $referral_doctor->person_code : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('doctor-referral.store') }}" method="post" id="ref-doctor-create">
        @csrf
        <input type="hidden" name="id" value="{{ $ref_doc_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="category_lookup" class="col-sm-12 col-form-label col-form-label-sm">Name <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="form-control font_size_12 m-auto" id="ref_doc_salutation width-200" name="ref_doc_salutation">
                                <option value="MR." @if($ref_doc_salutation == 'MR.') selected @endif>MR.</option>
                                <option value="MRS." @if($ref_doc_salutation == 'MRS.') selected @endif>MRS.</option>
                            </select>
                        </div>
                        <input type="text" class="form-control form-control-sm required text-capitalize" id="ref_doc_first_name" name="ref_doc_first_name" value="{{ $ref_doc_first_name }}" placeholder="First Name" required onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">

                        <input type="text" class="form-control form-control-sm required text-capitalize" id="ref_doc_last_name" name="ref_doc_last_name" value="{{ $ref_doc_last_name }}" placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ref_doc_qualification" class="col-sm-12 col-form-label col-form-label-sm">Qualification</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="ref_doc_qualification" name="ref_doc_qualification" value="{{ $ref_doc_qualification }}" placeholder="Qualification">
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="ref_doc_location" class="col-sm-12 col-form-label col-form-label-sm">Location</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="ref_doc_location" name="ref_doc_location" value="{{ $ref_doc_location }}" placeholder="Enter Location">
                </div>
            </div>

            <div class="col-md-6">
                <label for="ref_doc_phone_mobile" class="col-sm-12 col-form-label col-form-label-sm">Contact <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="ref_doc_phone_mobile" name="ref_doc_phone_mobile" value="{{ $ref_doc_phone_mobile }}" placeholder="Contact" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="ref_doc_email_personal" class="col-sm-12 col-form-label col-form-label-sm">Email <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="ref_doc_email_personal" name="ref_doc_email_personal" value="{{ $ref_doc_email_personal }}" placeholder="Email" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ref_doc_area" class="col-sm-12 col-form-label col-form-label-sm">Area</label>
                <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="ref_doc_area" name="ref_doc_area" value="{{ $ref_doc_area }}" placeholder="Enter Area" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="ref_doc_photo" class="col-sm-12 col-form-label col-form-label-sm">Referral Code</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="ref_code" name="ref_code" value="{{ $ref_code }}" placeholder="Referral Code">
                </div>
            </div>
            <div class="col-md-6">
                <label for="ref_doc_photo" class="col-sm-12 col-form-label col-form-label-sm">Photo</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control form-control-sm" id="ref_doc_photo" name="ref_doc_photo" value="" placeholder="Photo">
                </div>
            </div>
            <div class="col-md-12">
                <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                         <input class="form-check-input" type="checkbox" name=" status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                         <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>
        @php
            $response_action = route('doctor-referral.index');
        @endphp
        <div class=" pl-0">

            <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
            <button type="reset" class="btn btn-md btn-primary" data-dismiss="modal">Clear</button>
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Exit</button>
        </div>
    </form>
</div>


