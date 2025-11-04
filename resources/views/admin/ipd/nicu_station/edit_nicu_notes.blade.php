<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{route('ipd.upadte-nicu')}}" method="post" id="update-nicu-notes">
            @csrf
            <input type="hidden" name="nicu_id" value="{{ $nicu_id }}">

            <div class="form-group row">
                <div class="col-md-12">
                    <label for="remarks" class="col-sm-12 col-form-label col-form-label-sm mb-2">Notes</label>
                    <div class="col-sm-12">
                        <textarea class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass" name="notes" id="notes"
                        rows="10">{{$notesData->notes}}</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-1">
                @php
                    $response_action = route('ipd.nicu-station-patient-notes', [$notesData->patient_no_fk, $notesData->admission_no_fk]);
                @endphp
                <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>

                <button type="submit" class="btn btn-sm btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Update</button>

            </div>
        </form>
        </div>
    </div>


