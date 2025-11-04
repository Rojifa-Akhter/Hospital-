@php

$marketing_area = (isset($marketing_area) && (!empty($marketing_area))) ? $marketing_area : [];

$marketing_area_no_pk = ($marketing_area) ? $marketing_area->area_no_pk : '';
$marketing_area_code = ($marketing_area) ? $marketing_area->area_code : '';
$marketing_area_person_no = ($marketing_area) ? $marketing_area->supervisor_person_no_fk : '';
$marketing_area_district = ($marketing_area) ? $marketing_area->district : '';
$marketing_area_post_code = ($marketing_area) ? $marketing_area->post_code : '';
$status = ($marketing_area) ? $marketing_area->status : '';
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('marketing-area.store') }}" method="post" id="marketing-area-create">
        @csrf
        <input type="hidden" name="id" value="{{ $marketing_area_no_pk }}">
        <div class="form-group row">
            <div class="col-md-6">
                <label for="marketing_area_code" class="col-sm-12 col-form-label col-form-label-sm">Area Code <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="marketing_area_code" name="marketing_area_code" value="{{ $marketing_area_code }}" placeholder="Area Code" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="marketing_area_person_no" class="col-sm-12 col-form-label col-form-label-sm">Supervisor</label>
                <div class="col-sm-12">
                    <select class="form-control font_size_12 m-auto select2" id="marketing_area_person_no" name="marketing_area_person_no">
                        <option value="">Select Supervisor</option>
                        @if($supervisor)
                            @foreach($supervisor as $record)
                                <option value="{{ $record->person_no_pk }}" {{ $record->person_no_pk == $marketing_area_person_no ? 'selected' : '' }}>{{ $record->full_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="marketing_area_district" class="col-sm-12 col-form-label col-form-label-sm">District <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm required" id="marketing_area_district" name="marketing_area_district" value="{{ $marketing_area_district }}" placeholder="Enter District" required>
                </div>
            </div>

            <div class="col-md-6">
                <label for="marketing_area_post_code" class="col-sm-12 col-form-label col-form-label-sm">Contact</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control form-control-sm" id="marketing_area_post_code" name="marketing_area_post_code" value="{{ $marketing_area_post_code }}" placeholder="Contact">
                </div>
            </div>
        </div>


        <div class="form-group row">
            
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

        <div class="modal-footer mt-1">
            <!-- <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button> -->
            <!-- <button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this)">Save changes</button> -->
             @php
                $response_action = route('marketing-area.index');
             @endphp
                <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
              <a href="{{ route('marketing-area.index') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>
	

