@php

$marketing_agent = (isset($marketing_agent) && (!empty($marketing_agent))) ? $marketing_agent : [];

$marketing_agent_no_pk = ($marketing_agent) ? $marketing_agent->person_no_pk : '';
$marketing_agent_salutation = ($marketing_agent) ? $marketing_agent->salutation : '';
$marketing_agent_first_name = ($marketing_agent) ? $marketing_agent->fname : '';
$marketing_agent_last_name = ($marketing_agent) ? $marketing_agent->lname : '';
$marketing_agent_addess1 = ($marketing_agent) ? $marketing_agent->pr_addr1 : '';
$marketing_agent_addess2 = ($marketing_agent) ? $marketing_agent->pe_addr1 : '';
$marketing_agent_phone_mobile = ($marketing_agent) ? $marketing_agent->phone_mobile : '';
$marketing_agent_email_personal = ($marketing_agent) ? $marketing_agent->email_personal : '';
$marketing_agent_supervisor = ($marketing_agent) ? $marketing_agent->supervisor_person_no_fk : '';
$marketing_area_area_no = ($marketing_agent) ? $marketing_agent->area_no_pk : '';
// $ref_doc_photo = ($marketing_agent) ? $marketing_agent->photo_name : '';
$status = ($marketing_agent) ? $marketing_agent->status : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('marketing-agent.store') }}" method="post" id="marketing-agent-create">
        @csrf
        <input type="hidden" name="id" value="{{ $marketing_agent_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="category_lookup" class="col-sm-12 col-form-label col-form-label-sm">Name <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="form-control font_size_12 m-auto" id="marketing_agent_salutation width-200" name="marketing_agent_salutation">
                                <option value="MR." @if($marketing_agent_salutation == 'MR.') selected @endif>MR.</option>
                                <option value="MRS." @if($marketing_agent_salutation == 'MRS.') selected @endif>MRS.</option>
                            </select>
                        </div>
                        <input type="text" class="form-control form-control-sm required text-capitalize" id="marketing_agent_first_name" name="marketing_agent_first_name" value="{{ $marketing_agent_first_name }}" placeholder="First Name" required onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">

                        <input type="text" class="form-control form-control-sm required text-capitalize" id="marketing_agent_last_name" name="marketing_agent_last_name" value="{{ $marketing_agent_last_name }}" placeholder="Last Name" onkeypress="return /^[a-zA-Z\s]+$/i.test(event.key)">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="marketing_agent_addess1" class="col-sm-12 col-form-label col-form-label-sm">Address 1 <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="marketing_agent_addess1" name="marketing_agent_addess1" value="{{ $marketing_agent_addess1 }}" placeholder="Address 1" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="marketing_agent_addess2" class="col-sm-12 col-form-label col-form-label-sm">Address 2</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="marketing_agent_addess2" name="marketing_agent_addess2" value="{{ $marketing_agent_addess2 }}" placeholder="Enter Address 2">
                </div>
            </div>

            <div class="col-md-6">
                <label for="marketing_agent_phone_mobile" class="col-sm-12 col-form-label col-form-label-sm">Contact <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="marketing_agent_phone_mobile" name="marketing_agent_phone_mobile" value="{{ $marketing_agent_phone_mobile }}" placeholder="Contact" required>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="marketing_agent_email_personal" class="col-sm-12 col-form-label col-form-label-sm">Email</label>
                <div class="col-sm-12">
                <input type="email" class="form-control form-control-sm email" id="marketing_agent_email_personal" name="marketing_agent_email_personal" value="{{ $marketing_agent_email_personal }}" placeholder="Email">
                </div>
            </div>

            <div class="col-md-6">
                <label for="marketing_agent_supervisor" class="col-sm-12 col-form-label col-form-label-sm">Supervisor</label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="marketing_agent_supervisor" name="marketing_agent_supervisor">
                        <option value="">Select Supervisor</option>
                        @if($supervisor)
                            @foreach($supervisor as $record)
                                <option value="{{ $record->person_no_pk }}" {{ $record->person_no_pk == $marketing_agent_supervisor ? 'selected' : '' }}>{{ $record->full_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="marketing_area_area_no" class="col-sm-12 col-form-label col-form-label-sm">Area Name <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 required m-auto" id="marketing_area_area_no" name="marketing_area_area_no" required>
                        <option value="">Select Area</option>
                        @if($marketing_area)
                            @foreach($marketing_area as $record)
                                <option value="{{ $record->area_no_pk }}" {{ $record->area_no_pk == $marketing_area_area_no ? 'selected' : '' }}>{{ $record->district }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                         <input class="form-check-input" type="checkbox" name=" status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }}>
                         <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer mt-1">
            <!-- <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button> -->
            <button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this)">Save changes</button>
             <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
          <a href="{{ route('marketing-agent.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>
	

