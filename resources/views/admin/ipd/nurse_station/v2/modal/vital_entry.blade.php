<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<div class="row">
    <div class="col-md-3 "><strong> Name </strong></div>
    <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
    <div class="col-md-3">  
        <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-vital-report',[$patient_no_fk, $admission_id])}}">Export PDF</a>
        <a class="btn btn-md btn-danger" target="_blank" href="{{route('v2.ipd.vital-report-generate',[$patient_no_fk, $admission_id])}}">Generate Report</a>
    </div>
</div>


<diw class="row">
    <div class="col-12">
        <form action="{{ route('ipd.save-vital-entry') }}" method="post" id="vital_entry">
            @csrf

            <div class="row">
                <div class="col-6">
                        <input type="hidden" name="vital_no_pk" id="vital_no_pk" value="">
                        <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
                        <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
                        
                        <div class="form-group mb-0">
                            <label for="" class="col-form-label col-form-label-sm">Pulse(bpm)</label>
                            <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="pulse" name="pulse" placeholder="Pulse" value="" />
                        </div>
                    
                        <div class="form-group mb-0">
                            <label for="" class="col-form-label col-form-label-sm">BP(mmHg)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bp_first" id="bp_first" placeholder="BP(mmHg)">
                                <span class="px-2" style="font-size: 20px" >/</span>
                                <input type="text" class="form-control" name="bp_second" id="bp_second" placeholder="BP(mmHg)">
                              </div>
                        </div>
                    
                        <div class="form-group mb-0">
                            <label for="" class="col-form-label col-form-label-sm">Temperature(&deg;F)</label>
                            <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="temperature" name="temperature" placeholder="Temperature" value="" />
                        </div>
                      
                </div>
                <div class="col-6">
                    <div class="form-group mb-0">
                        <label for="" class="col-form-label col-form-label-sm">Spo2(%)</label>
                        <input class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="spo2" name="spo2" placeholder="Spo2(%)"/>
                    </div>
                    <div class="form-group mb-0">
                        <label for="" class="col-form-label col-form-label-sm">Respiration</label>
                        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 " id="respiration" name="respiration" placeholder="Respiration" value="" />
                    </div>
                
                    {{-- <div class="form-group mb-0">
                        <label for="" class="col-form-label col-form-label-sm">Height(cm)</label>
                        <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0" id="height" name="height" placeholder="Height(cm)" value="{{@$height}}" oninput="calculateBMI()"/>
                    </div>
                
                    <div class="form-group mb-0">
                        <label for="" class="col-form-label col-form-label-sm">Weight(kg)</label>
                        <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0" id="weight" name="weight" placeholder="Weight" value="{{@$weight}}" oninput="calculateBMI()" />
                    </div>
                
                    <div class="form-group mb-0">
                        <label for="" class="col-form-label col-form-label-sm">BMI(kg/m <sup>2</sup>)</label>
                        <input type="number" class="form-control form-control-sm m-0 p-0 item_element  mb-0" id="bmi" name="bmi" placeholder="BMI" value="" readonly/>
                    </div> --}}
                
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
        <h6 class="text-center mt-2"><b>Vital Sign History</b></h6>
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center nowrap" style="width: 16%">Date</th>
                            <th class="text-right nowrap" style="width: 10%">Pulse(bpm)</th>
                            <th class="text-right nowrap" style="width: 10%">BP(mmHg)</th>
                            <th class="text-right nowrap" style="width: 12%">Temperature(&deg;F)</th>
                            <th class="text-right nowrap" style="width: 10%">Respiration</th> 
                            <th class="text-right nowrap" style="width: 8%">Spo2(%)</th>
                            <th class="text-right nowrap" style="width: 8%">Height(cm)</th> 
                            <th class="text-right nowrap" style="width: 8%">Weight(kg)</th> 
                            <th class="text-right nowrap" style="width: 8%">BMI(kg/m <sup>2</sup>)</th> 
                            <th class="text-center nowrap" style="width: 10%">Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $key => $item)
							<tr>
								<td class="text-center">@if(!empty($item->au_entry_at))
                                    {{ date('d/m/Y h:i:s A',strtotime($item->au_entry_at))}}
                                @endif</td>
								<td class="text-right nowrap">{{$item->pulse_val}}</td>
								<td class="text-right nowrap">{{$item->bp_val_sys}}/{{$item->bp_val_dia}}</td> 
								<td class="text-right nowrap">{{$item->temp_val}}</td> 
								<td class="text-right nowrap">{{$item->respiration}}</td> 
								<td class="text-right nowrap">{{$item->spo2}}</td>
								<td class="text-right nowrap">{{$item->height_val}}</td>
								<td class="text-right nowrap">{{$item->weight_val}}</td>
								<td class="text-right nowrap">{{$item->bmi}}</td>
								<td class="text-center">	 
                                    {{-- <a href="{{route('v2.ipd.vital-report-generate', $item->vital_no_pk)}}"  class="btn btn-sm btn-danger" target="_blank">
                                        <i class="fa fa-file-pdf text-white"></i>
                                    </a>	 --}}
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="getVitalsInfo({{$item->vital_no_pk}})">
                                        Edit
                                    </button>							
								</td> 
								
							</tr>
						@empty
							<tr>
								<td colspan="10" class="text-center text-danger">Data Not Found</td>
							</tr>
						@endforelse 
                                                    
                    </tbody>
			</table>
		</div>
    </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    $(document).ready(function(){
        $("#vital_entry").validate({
            rules:{
                temperature:{
                    required:true,
                },
                pulse:{
                    required:true,
                },
                bp_first:{
                    required:true,
                },
                bp_second:{
                    required:true,
                },
                height:{
                    required:true,
                },
                weight:{
                    required:true,
                },
                bmi:{
                    required:true,
                },
                spo2:{
                    required:true,
                },
                respiration:{
                    required:true,
                },
                height:{
                    required:true,
                },
                weight:{
                    required:true,
                }
            },
            messages:{
                temperature:{
                    required: "Temperature Required"
                },
                pulse:{
                    required: "Pulse Required",
                },
                bp_first:{
                    required: "BP Required",
                },
                bp_second:{
                    required: "BP Required",
                },
                height:{
                    required:"Height Required",
                },
                weight:{
                    required:"Weight Required",
                },
                bmi:{
                    required:"BMI Required",
                },
                spo2:{
                    required:"Spo2(%) Required",
                },
                respiration:{
                    required:"Respiration Required",
                },
                height:{
                    required:"Height(cm) Required",
                },
                weight:{
                    required:"Weight(kg) Required",
                }
                
            }
        });

    })
    calculateBMI();
    function calculateBMI(){
        var height = $('#height').val();
            height = height == '' ? 0 : height;
            height = height/100;
        var weight = $('#weight').val();
            weight = weight == '' ? 0 : weight;

        var bmi = (weight/(height*height)).toFixed(2);

        $("#bmi").val(bmi);
    }

    function getVitalsInfo(vital_no_pk){
        $.ajax({
			async: true,
			data: {
				vital_no_pk: vital_no_pk,
			},
			url: "{{ route('ipd.get-vital-info') }}",
			type: 'post',
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
				$.unblockUI();
                var result = data.data;
                $("#pulse").val(result.pulse_val);
                $("#vital_no_pk").val(result.vital_no_pk);
                $("#bp_second").val(result.bp_val_dia);
                $("#bp_first").val(result.bp_val_sys);
                $("#temperature").val(result.temp_val);
                $("#respiration").val(result.respiration);

                $("#spo2").val(result.spo2);
                $("#height").val(result.height_val);
                $("#weight").val(result.weight_val);
                $("#bmi").val(result.bmi);
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
