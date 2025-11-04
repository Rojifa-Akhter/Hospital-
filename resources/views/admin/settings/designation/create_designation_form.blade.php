
@php

$designation = (isset($designation) && (!empty($designation))) ? $designation : [];

$designation_code = ($designation) ? $designation->designation_code : '';
$designation_name = ($designation) ? $designation->designation_name : '';
$grade_no_fk = ($designation) ? $designation->grade_no_fk : '';
$strength = ($designation) ? $designation->strength : '';
$designation_no_pk = ($designation) ? $designation->designation_no_pk : '';
$status = ($designation) ? $designation->status : '';
@endphp




<div class="row">
<div class="col-sm-12 col-lg-12 col-xl-12">
    <form action="{{ route('designation.store') }}" method="post" id="desgination-form">
        @csrf
        <input type="hidden" name="id" value="{{ $designation_no_pk }}">
        <div class="form-group row">
             <div class="col-md-12">
                <label for="desgination_code" class="col-sm-12 col-form-label col-form-label-sm">Designation Code<span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="desgination_code" name="desgination_code" value="{{ $designation_code }}" placeholder="Enter Designation Code" required>
                </div>
            </div>


            <div class="col-md-12">
                <label for="desgination" class="col-sm-12 col-form-label col-form-label-sm">Designation <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                     <input type="text" class="form-control form-control-sm" id="desgination" name="desgination" value="{{ $designation_name }}" placeholder="Enter Designation" required>
                </div>
            </div> 

        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <label for="grade" class="col-sm-12 col-form-label col-form-label-sm">Grade <span class="text-danger">*</span></label>
                <div class="col-sm-12">
               <select class="form-control font_size_12 m-auto" id="grade" name="grade" required>
                    <option value="">Select One </option>

                    @if(!empty($grade))
                        @foreach($grade as $value)
                            <option value="{{ $value->grade_no_pk }}" @if($grade_no_fk == $value->grade_no_pk) selected @endif> {{ $value->grade_name }} </option>
                        @endforeach
                    @endif

                </select>
                </div>
            </div>

            <div class="col-md-12">
                <label for="strength" class="col-sm-12 col-form-label col-form-label-sm">Strength</label>
                <div class="col-sm-12">
                    <input type="number" class="form-control form-control-sm" id="strength" name="strength" value="{{ $strength }}" placeholder="Enter Strength" >
                </div>
            </div>
            <div class="col-md-12">
                 <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                         <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $status == '1' ? 'checked' : '' }} >
                         <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>
            @php
                $response_action = route('designation.index');
            @endphp

        <div class="modal-footer pl-0">
          
            <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
              <!--  <button type="reset" id="resetData" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button> -->
        <a href="{{ route('designation.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Designation List">Exit</a>
        </div>
    </form>
    </div>
</div>
	

