<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="row">
    <div class="col-md-3 "><strong> Name </strong></div>
    <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
    {{-- <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-glucose-chart',[$patient_no_fk, $admission_id])}}">Export PDF</a></div> --}}
</div>


<diw class="row">
    <div class="col-12">
        <form action="{{ route('ipd.save-ot-requsition') }}" method="post" id="ot_requsition">
            @csrf

            <div class="row">
                <div class="col-6">
                        <input type="hidden" name="ot_req_no_pk" id="ot_req_no_pk" value="">
                        <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
                        <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
                        
                        <div class="form-group mb-0">
                            <label for="doctor_name_0" class="col-form-label col-form-label-sm">OT Name</label>
                            <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 item_typehead" id="ot_name" name="ot_name" placeholder="OT Name" value="" />
                            <input type="hidden" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="ot_id" name="ot_id" placeholder="" value="" />
                        </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="doctor_name_0" class="col-form-label col-form-label-sm">OT Date</label>
                        <input type="datetime-local" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="ot_date" name="ot_date" placeholder="OT Datetime" value="" />
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="modal-footer">
                        @php
                            $response_action = route('v2.ipd.nurse-note',$admission_id);
                        @endphp
                        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                    </div>
                </div>
            </div>
        
            
        </form>
    </div>
</diw>



<div class="row">
    <div class="col-md-12 col-12">
        <h6 class="text-center mt-2"><b>OT History</b></h6>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center nowrap" style="width: 10%">SL</th>
                            <th class="text-center nowrap" style="width: 15%">Requsition Date</th>
                            <th class="text-center nowrap" style="width: 15%">OT Date</th>
                            <th class="text-left nowrap" style="width: 30%">OT Name</th> 
                            <th class="text-left nowrap" style="width: 15%">Status</th> 
                            <th class="text-center nowrap" style="width: 15%">Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $key => $item)
							<tr>

								<td class="text-center">
                                    {{ ++$key }}
                                </td>
								<td class="text-center">
                                    @if(!empty($item->ot_req_date))
                                        {{ date('d/m/Y',strtotime($item->ot_req_date))}}
                                    @endif
                                </td>
								<td class="text-center">
                                    @if(!empty($item->ot_date))
                                        {{ date('d/m/Y',strtotime($item->ot_date))}}
                                    @endif
                                </td>
								<td class="text-left">
                                    {{$item->item_name}}
                                </td>
								<td class="text-center">
                                    {{$item->ot_in_ind == 0 ? 'Pending' : 'Completed'}}
                                </td>

								<td class="text-center nowrap">	 
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="getGlucoseInfo({{$item->ot_req_no_pk}})">
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

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openBillingItemAutocomplete(".item_typehead", item_type = 'SUR,PROCEDURE', item_type_void = "",setId);
    function setId(item){
        $('#ot_id').val(item.item_id);
    }
    $(document).ready(function(){
        $("#ot_requsition").validate({
            rules:{
                ot_id:{
                    required:true,
                },
                ot_date:{
                    required:true,
                },
            },
            messages:{
                ot_id:{
                    required: "OT Name"
                },
                ot_date:{
                    required: "OT Date",
                },
            }
        });

    })

    function getGlucoseInfo(ot_req_no_pk){
        $.ajax({
			async: true,
			data: {
				ot_req_no_pk: ot_req_no_pk,
			},
			url: "{{ route('v2.ipd.get-ot-requsition') }}",
			type: 'post',
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
				$.unblockUI();
                var result = data.data;
                $("#patient_no_fk").val(result.patient_no_fk);
                $("#admission_no_fk").val(result.admission_no_fk);
                $("#ot_req_no_pk").val(result.ot_req_no_pk);
                $("#ot_name").val(result.item_name);
                $("#ot_id").val(result.item_no_fk);
                $("#ot_date").val(result.ot_date);
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
