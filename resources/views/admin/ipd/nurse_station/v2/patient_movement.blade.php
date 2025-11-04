<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-patient-movement') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="nspatmovement_no_pk" id="nspatmovement_no_pk" value="">

    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-patient-movement',[$patient_no_fk, $admission_id])}}">Export PDF</a></div>
    </div>




    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group mb-0">
                <label for="purpose_of_movement" class="col-form-label col-form-label-sm">Purpose of movement</label>

                <select name="purpose_of_movement" id="purpose_of_movement" class="form-control form-control-sm m-0 p-0 item_element  mb-0">
                    <option value="1">OPD CONSULTATION</option>
                    <option value="2">PAC</option>
                    <option value="3">X-RAY</option>
                    <option value="4">MRI</option>
                    <option value="5">CT</option>
                    <option value="6">ULTRA SOUND</option>
                    <option value="7">DIALYSIS</option>
                    <option value="8">PROCEDURE</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label for="escort_by_no" class="col-form-label col-form-label-sm">Escort by</label>
                <select name="escort_by_no" id="escort_by_no" class="form-control form-control-sm m-0 p-0 item_element  mb-0">
                    <option value="1">PCA</option>
                    <option value="2">RN</option>
                </select>


            </div>
            <div class="form-group mb-0">
                <label for="mode_of_transfer" class="col-form-label col-form-label-sm">Mode of Transfer</label>
                <select class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="mode_of_transfer" name="mode_of_transfer">
                    <option value="">Select One</option>
                    <option value="1">WHEELCHAIR</option>
                    <option value="2">BED</option>
                    <option value="3">STRETCHER</option>
                    <option value="4">LAP</option>
                    <option value="5">BASINET</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label for="level_of_consciousness" class="col-form-label col-form-label-sm">Level of Consciousness</label>
                <select class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="level_of_consciousness" name="level_of_consciousness">
                    <option value="">Select One</option>
                    <option value="1">CONSCIOUS</option>
                    <option value="2">RESTLESSNESS</option>
                    <option value="3">DISORIENTED</option>
                    <option value="4">DROWSY</option>
                    <option value="5">UNCONSCIOUS</option>
                </select>
            </div>

            <div class="form-group mb-0">
                <label for="npo" class="col-form-label col-form-label-sm">NPO</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="npo" name="npo" value="" placeholder="NPO"/>
            </div>
        </div>


        <div class="col-md-6 col-12">
            
            <div class="form-group mb-0">
                <label for="isolation_precaution" class="col-form-label col-form-label-sm">Isolation</label>
                <select class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="isolation_precaution" name="isolation_precaution">
                    <option value="">Select One</option>
                    <option value="1">YES</option>
                    <option value="2">NO</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label for="receive_back_at" class="col-form-label col-form-label-sm">Receive Back At</label>
                <input type="time" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="receive_back_at" name="receive_back_at" value="" placeholder="Receive Back At"/>
            </div>
            <div class="form-group mb-0">
                <label for="remarks" class="col-form-label col-form-label-sm">Remarks</label>
                <textarea class="form-control form-control-sm m-0 p-0 item_element  mb-0" rows="4" id="remarks" name="remarks" placeholder="Write here ..."></textarea>
            </div>
        </div>
    </div>


    <div class="modal-footer">
        @php
            $response_action = route('v2.ipd.nurse-note',$admission_id);
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>


    <div class="row">
        <div class="col-md-12 col-12">
            <h6 class="text-center mt-2"><b>Patient Movement History</b></h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center" style="width: 16%">Sending At</th>
                                <th class="text-center" style="width: 16%">Receive Back At</th>
                                <th class="text-left" style="width: 16%">Purpose of movement</th>
                                <th class="text-left" style="width: 14%">Escort by</th>
                                <th class="text-left" style="width: 18%">Mode of transfer</th>
                                <th class="text-left" style="width: 10%">Level of Consciousness</th>
                                <th class="text-center" style="width: 7%">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patient_movement as $item)
                                <tr>
                                    <td class="text-center">
                                        @if(!empty($item->au_entry_at))
                                            {{ date('d/m/Y h:i:s A',strtotime($item->au_entry_at))}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($item->receive_back_at))
                                            {{ date('d/m/Y h:i:s A',strtotime($item->receive_back_at))}}
                                        @endif
                                    </td>

                                    <td class="text-left ">
                                        @if($item->purpose_of_movement == 1)
                                            OPD CONSULTATION
                                        @elseif($item->purpose_of_movement == 2)
                                            PAC
                                        @elseif($item->purpose_of_movement == 3)
                                            X-RAY
                                        @elseif($item->purpose_of_movement == 4)
                                            MRI
                                        @elseif($item->purpose_of_movement == 5)
                                            CT
                                        @elseif($item->purpose_of_movement == 6)
                                            ULTRA SOUND
                                        @elseif($item->purpose_of_movement == 7)
                                            DIALYSIS
                                        @elseif($item->purpose_of_movement == 8)
                                            PROCEDURE
                                        @elseif($item->purpose_of_movement == 9)
                                            CT
                                        @endif
                                    </td> 
                                    <td class="text-left">
                                        @if($item->escort_by_no == 1)
                                            PCA
                                        @elseif($item->escort_by_no == 2)
                                            RN
                                        @endif
                                    </td> 
                                    <td class="text-left">
                                        @if($item->mode_of_transfer == 1)
                                            WHEELCHAIR
                                        @elseif($item->mode_of_transfer == 2)
                                            BED
                                        @elseif($item->mode_of_transfer == 3)
                                            STRETCHER
                                        @elseif($item->mode_of_transfer == 4)
                                            LAP
                                        @elseif($item->mode_of_transfer == 5)
                                            BASINET
                                        @endif
                                    </td> 
                                    <td class="text-left">
                                        @if($item->level_of_consciousness == 1)
                                            CONSCIOUS
                                        @elseif($item->level_of_consciousness == 2)
                                            RESTLESSNESS
                                        @elseif($item->level_of_consciousness == 3)
                                            DISORIENTED
                                        @elseif($item->level_of_consciousness == 4)
                                            DROWSY
                                        @elseif($item->level_of_consciousness == 5)
                                            UNCONSCIOUS
                                        @endif
                                    </td> 
                                    <td class="text-center ">	 						
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="getMovementInfo({{$item->nspatmovement_no_pk}})">
                                            Edit
                                        </button>							
                                    </td> 
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">Data Not Found</td>
                                </tr>
                            @endforelse 
                                                        
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</form>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete("#escort_by_name", "escort_by_no");
    function getMovementInfo(nspatmovement_no_pk){
        $.ajax({
			data: {
				nspatmovement_no_pk: nspatmovement_no_pk,
			},
			url: "{{route('v2.get-patient-movement-info')}}",
			type: 'post',
            beforeSend: function() {
				blockUI();
			},
			success: function(data) {
                $.unblockUI();
                var result = data.data;

                var nspatmovement_date = result.nspatmovement_date;
                    if(nspatmovement_date != null){
                        nspatmovement_date = result.nspatmovement_date.split(" ");
                        nspatmovement_date = nspatmovement_date[1];
                    }
                var receive_back_at = result.receive_back_at;
                    if(receive_back_at != null){
                        receive_back_at = result.receive_back_at.split(" ");
                        receive_back_at = receive_back_at[1];
                    }
                $("#nspatmovement_date").val(nspatmovement_date);
                $("#purpose_of_movement").val(result.purpose_of_movement);
                $("#escort_by_no").val(result.escort_by_no);
                $("#escort_by_name").val(result.full_name);
                $("#mode_of_transfer").val(result.mode_of_transfer);
                $("#nspatmovement_no_pk").val(result.nspatmovement_no_pk);
                $("#level_of_consciousness").val(result.level_of_consciousness);
                $("#npo").val(result.npo);
                $("#isolation_precaution").val(result.isolation_precaution);
                $("#receive_back_at").val(receive_back_at);
                $("#remarks").val(result.remarks);
			},
			error: function(err) {
				$.unblockUI();
				var error = err.responseJSON;
				$('.common-modal-notify-error').modal('show');
				$('.common-modal-notify-error .modal-title').html('Failed');
				$('.common-modal-notify-error .modal-body').html(error.message);
			}
		})
    }
</script>
