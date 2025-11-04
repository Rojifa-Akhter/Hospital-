<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-nursing-care-plan') }}" method="post" id="refer_doctor">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <input type="hidden" name="nscareplan_no_pk" id="nscareplan_no_pk" value="">


    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-nursing-care-plan',[$patient_no_fk, $admission_id])}}">Export PDF</a></div>
    </div>


    <div class="form-group row">
        <div class="col-md-12">
            <strong for="nscareplan_date">Time</strong>
        </div>
        <div class="col-md-12">
            <input type="time" name="nscareplan_date" id="nscareplan_date" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="problem_identified">Problem Identified</strong>
        </div>
        <div class="col-md-12">
            <input id="problem_identified" name="problem_identified" class="form-control"  placeholder="Problem Identified" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="goal">Goal</strong>
        </div>
        <div class="col-md-12">
            <input id="goal" name="goal" class="form-control" placeholder="Goal">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="implementation">Implementation</strong>
        </div>
        <div class="col-md-12">
            <input id="implementation" name="implementation" class="form-control" placeholder="Implementation">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="outcome">Outcome</strong>
        </div>
        <div class="col-md-12">
            <input id="outcome" name="outcome" class="form-control" placeholder="Outcome">
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
            <h6 class="text-center mt-2"><b>Nursing Care Plan History</b></h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center nowrap" style="width: 16%">Date Time</th>
                                <th class="text-center nowrap" style="width: 16%">Problem identified</th>
                                <th class="text-left nowrap" style="width: 14%">Goal</th>
                                <th class="text-left nowrap" style="width: 18%">Implementation</th>
                                <th class="text-left nowrap" style="width: 10%">Outcome</th>
                                <th class="text-center nowrap" style="width: 7%">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nursing_care_plan as $item)
                                <tr>
                                    <td class="text-center">
                                        @if(!empty($item->nscareplan_date))
                                            {{ date('d/m/Y h:i:s A',strtotime($item->nscareplan_date))}}
                                        @endif
                                    </td>

                                    <td class="text-left nowrap">{{$item->problem_identified}}</td> 
                                    <td class="text-left nowrap">{{$item->goal}}</td> 
                                    <td class="text-left nowrap">{{$item->implementation}}</td> 
                                    <td class="text-left nowrap">{{$item->outcome}}</td> 
                                    <td class="text-center nowrap">	 						
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="getNursingCareInfo({{$item->nscareplan_no_pk}})">
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
    function getNursingCareInfo(nscareplan_no_pk){
        $.ajax({
			data: {
				nscareplan_no_pk: nscareplan_no_pk,
			},
			url: "{{route('v2.get-nursing-care-plan-info')}}",
			type: 'post',
            beforeSend: function() {
				blockUI();
			},
			success: function(data) {
                $.unblockUI();
                var result = data.data;

                var nscareplan_date = result.nscareplan_date;
                    if(nscareplan_date != null){
                        nscareplan_date = result.nscareplan_date.split(" ");
                        nscareplan_date = nscareplan_date[1];
                    }
                $("#nscareplan_date").val(nscareplan_date);
                $("#problem_identified").val(result.problem_identified);
                $("#goal").val(result.goal);
                $("#implementation").val(result.implementation);
                $("#nscareplan_no_pk").val(result.nscareplan_no_pk);
                $("#outcome").val(result.outcome);
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
