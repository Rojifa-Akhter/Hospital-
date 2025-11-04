<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-nursing-endorsement') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="endorsment_no_pk" id="endorsment_no_pk" value="">

    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.nursing-endorsement',[$patient_no_fk, $admission_id])}}">Export PDF</a></div>
    </div>




    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group mb-0">
                <label for="endorsment_date" class="col-form-label col-form-label-sm">Time</label>
                <input type="datetime-local" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="endorsment_date" name="endorsment_date" value="" required/>
            </div>
            <div class="form-group mb-0">
                <label for="precipititating_factor" class="col-form-label col-form-label-sm">Precipitating Factor</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="precipititating_factor" name="precipititating_factor" value="" placeholder="Precipitating Factor" required/>
            </div>
            <div class="form-group mb-0">
                <label for="type" class="col-form-label col-form-label-sm">Type</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="type" name="type" value="" placeholder="Type"/>
            </div>
            <div class="form-group mb-0">
                <label for="location" class="col-form-label col-form-label-sm">Location</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="location" name="location" value="" placeholder="Location"/>
            </div>
            <div class="form-group mb-0">
                <label for="pain_score" class="col-form-label col-form-label-sm">Pain Score</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="pain_score" name="pain_score" value="" placeholder="Pain Score"/>
            </div>
            <div class="form-group mb-0">
                <label for="frequency" class="col-form-label col-form-label-sm">Frequency</label>
                <select class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="frequency" name="frequency">
                    <option value="" selected>Select One</option>
                    <option value="1">Constant</option>
                    <option value="2">Intermittent</option>
                    <option value="3">Frequency</option>
                </select>
            </div>
        </div>


        <div class="col-md-6 col-12">
            <div class="form-group mb-0">
                <label for="duration" class="col-form-label col-form-label-sm">Duration</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="duration" name="duration" value="" placeholder="Duration"/>
            </div>
            <div class="form-group mb-0">
                <label for="pain_time" class="col-form-label col-form-label-sm">Time</label>
                <input type="datetime-local" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="pain_time" name="pain_time" value="" placeholder="Time"/>
            </div>
            <div class="form-group mb-0">
                <label for="intervention" class="col-form-label col-form-label-sm">Intervention</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="intervention" name="intervention" value="" placeholder="Intervention"/>
            </div>
            <div class="form-group mb-0">
                <label for="inter_time" class="col-form-label col-form-label-sm">Time</label>
                <input type="datetime-local" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="inter_time" name="inter_time" value="" placeholder="Time"/>
            </div>
            <div class="form-group mb-0">
                <label for="post_inv_score" class="col-form-label col-form-label-sm">Post Intervention score</label>
                <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="post_inv_score" name="post_inv_score" value="" placeholder="Post Intervention score"/>
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
                                <th class="text-center" style="width: 16%">Date Time</th>
                                <th class="text-center" style="width: 16%">Precipitating Factor</th>
                                <th class="text-left" style="width: 14%">Type</th>
                                <th class="text-left" style="width: 18%">Location</th>
                                <th class="text-left" style="width: 10%">Pain Score</th>
                                <th class="text-center" style="width: 7%">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nursing_endorsement as $item)
                                <tr>
                                    <td class="text-center">
                                        @if(!empty($item->endorsment_date))
                                            {{ date('d/m/Y h:i:s A',strtotime($item->endorsment_date))}}
                                        @endif
                                    </td>
                                    <td class="text-left ">{{$item->precipititating_factor}}</td> 
                                    <td class="text-left ">{{$item->type}}</td> 
                                    <td class="text-left ">{{$item->location}}</td> 
                                    <td class="text-left ">{{$item->pain_score}}</td> 
                                    <td class="text-center ">	 						
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="getEndorsementInfo({{$item->endorsment_no_pk}})">
                                            Edit
                                        </button>							
                                    </td> 
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">Data Not Found</td>
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
    function getEndorsementInfo(endorsment_no_pk){
        $.ajax({
			data: {
				endorsment_no_pk: endorsment_no_pk,
			},
			url: "{{route('v2.get-nursing-endorsement-info')}}",
			type: 'post',
            beforeSend: function() {
				blockUI();
			},
			success: function(data) {
                $.unblockUI();
                var result = data.data;
                $("#endorsment_no_pk").val(endorsment_no_pk);
                $("#endorsment_date").val(result.endorsment_date);
                $("#precipititating_factor").val(result.precipititating_factor);
                $("#type").val(result.type);
                $("#location").val(result.location);
                $("#pain_score").val(result.pain_score);
                $("#frequency").val(result.frequency);
                $("#duration").val(result.duration);
                $("#intervention").val(result.intervention);
                $("#pain_time").val(result.pain_time);
                $("#inter_time").val(result.inter_time);
                $("#post_inv_score").val(result.post_inv_score);
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
