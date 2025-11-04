<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-skin-care') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="skincare_no_pk" id="skincare_no_pk" value="">


    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-skin-care',[$patient_no_fk, $admission_id])}}">Export PDF</a></div>
    </div>


    <div class="form-group row">
        <div class="col-md-12">
            <strong for="skincare_date">Time</strong>
        </div>
        <div class="col-md-12">
            <input type="time" name="skincare_date" id="skincare_date" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="back_care">Back Care</strong>
        </div>
        <div class="col-md-12">
            <input id="back_care" name="back_care" class="form-control"  placeholder="Back Care" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="position_change">Position Change</strong>
        </div>
        <div class="col-md-12">
            <select class="form-control" id="position_change" name="position_change" >
                <option value="1">RIGHT LATERAL</option>
                <option value="2">LEFT LATERAL</option>
                <option value="3">SUPINE</option>
                <option value="4">PRONE</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="skin_condition">Skin Condition</strong>
        </div>
        <div class="col-md-12">
            <select class="form-control" id="skin_condition" name="skin_condition" >
                <option value="1">INTACT</option>
                <option value="2">REDNESS</option>
                <option value="3">BLACKISH</option>
                <option value="4">BLISTER</option>
                <option value="5">SKIN PEELED OFF</option>
                <option value="6">SORE</option>
            </select>
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
            <h6 class="text-center mt-2"><b>Skin Care History</b></h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center nowrap" style="width: 16%">Date Time</th>
                                <th class="text-center nowrap" style="width: 10%">Back Care</th>
                                <th class="text-left nowrap" style="width: 18%">Position Change</th>
                                <th class="text-left nowrap" style="width: 22%">Skin Condition</th>
                                <th class="text-center nowrap" style="width: 15%">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($skin_care as $item)
                                <tr>
                                    <td class="text-center">
                                        @if(!empty($item->skincare_date))
                                            {{ date('d/m/Y h:i:s A',strtotime($item->skincare_date))}}
                                        @endif
                                    </td>

                                    <td class="text-left nowrap">{{$item->back_care}}</td> 
                                    <td class="text-left nowrap">
                                        @if($item->position_change == 1)
                                            RIGHT LATERAL
                                        @elseif($item->position_change == 2)
                                            LEFT LATERAL
                                        @elseif($item->position_change == 3)
                                            SUPINE
                                        @elseif($item->position_change == 4)
                                            PRONE
                                        @endif
                                    </td> 
                                    <td class="text-left nowrap">                                        
                                        @if($item->skin_condition == 1)
                                            INTACT
                                        @elseif($item->skin_condition == 2)
                                            REDNESS
                                        @elseif($item->skin_condition == 3)
                                            BLACKISH
                                        @elseif($item->skin_condition == 4)
                                            BLISTER
                                        @elseif($item->skin_condition == 5)
                                            SKIN PEELED OFF
                                        @elseif($item->skin_condition == 6)
                                            SORE
                                        @endif
                                    </td> 
                                    <td class="text-center nowrap">	 						
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="getSkinCareInfo({{$item->skincare_no_pk}})">
                                            Edit
                                        </button>							
                                    </td> 
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">Data Not Found</td>
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
    function getSkinCareInfo(skincare_no_pk){
        $.ajax({
			data: {
				skincare_no_pk: skincare_no_pk,
			},
			url: "{{route('v2.get-skin-care-info')}}",
			type: 'post',
            beforeSend: function() {
				blockUI();
			},
			success: function(data) {
                $.unblockUI();
                var result = data.data;

                var skincare_date = result.skincare_date;
                    if(skincare_date != null){
                        skincare_date = result.skincare_date.split(" ");
                        skincare_date = skincare_date[1];
                    }
                $("#skincare_date").val(skincare_date);
                $("#back_care").val(result.back_care);
                $("#position_change").val(result.position_change);
                $("#skin_condition").val(result.skin_condition);
                $("#skincare_no_pk").val(result.skincare_no_pk);
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
