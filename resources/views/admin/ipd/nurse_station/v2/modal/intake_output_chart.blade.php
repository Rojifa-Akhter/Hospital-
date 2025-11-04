<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .datewise_intake:hover{
        background-color: blue !important;
        color:white;
    }
</style>
@php 
$report_dates = collect($report_dates)->sortByDesc(fn($value) => $value)->values();
@endphp
<div class="row">
    <div class="col-md-3 "><strong> Name </strong></div>
    <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
    <div class="col-md-3">  <a class="btn btn-md btn-warning" target="_blank" href="{{route('ipd.download-intake-output-chart',[$patient_no_fk, $admission_id])}}">Export PDF</a></div>
</div>


<diw class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="intake-tab" data-toggle="tab" href="#tab-intake" role="tab" aria-controls="tab-intake" aria-selected="true">Intake<span class="badge badge-secondary"></span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " id="output-tab" data-toggle="tab" href="#tab-output" role="tab" aria-controls="not-assigned" aria-selected="true">Output<span class="badge badge-secondary"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="reports-tab" data-toggle="tab" href="#tab-reports" role="tab" aria-controls="reports" aria-selected="true">Reports<span class="badge badge-secondary"></span></a>
                    </li>
                </ul>

                <div class="tab-content p-0" id="myTabContent">   
                    <!-- Intake -->                       
                    <div class="tab-pane fade show active" id="tab-intake" role="tabpanel" aria-labelledby="intake-tab">
                        <form  action="{{ route('ipd.save-intake') }}" method="post" id="intake">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="patintake_no_pk" id="patintake_no_pk" value="">
                                    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
                                    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
            
                                    <div class="form-group mb-0">
                                        <label for="intake_type" class="col-form-label col-form-label-sm">Intake Type</label>
                                        <select class="form-control form-control-sm" id="intake_type" name="intake_type" onclick="changeIntakeType(this.value)">
                                            <option value="1">ORAL</option>
                                            {{-- <option value="4">RT</option> --}}
                                            <option value="4">NG Tube</option>
                                            <option value="5">PEG Tube</option>
                                            <option value="2">IV FLUID</option>
                                            <option value="3">BLOOD PRODUCTS</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0" id="ivf_name_list" style="display:none">
                                        <label for="ivf_name" class="col-form-label col-form-label-sm">IVF Name</label>
                                        <select class="form-control form-control-sm" id="ivf_name" name="ivf_name">
                                            <option value="1">Normal saline</option>
                                            <option value="2">5% DNS</option>
                                            <option value="3">5% Dextrose</option>
                                            <option value="4">10% Dextrose</option>
                                            <option value="5">25% Dextrose</option>
                                            <option value="6">Dextrosal Baby (0.225% Normal  saline+5% dextrose)</option>
                                            <option value="7">Dextrosal  Mini(0.45% Normal Saline+5% Dextrose)</option>
                                            <option value="8">Ringers solution</option>
                                            <option value="9">Cholera Saline</option>
                                            <option value="10">Others</option>
                                        </select>
                                    </div>
                                
                                    {{-- <div class="form-group mb-0">
                                        <label for="intake_time" class="col-form-label col-form-label-sm">Time</label>
                                        <input type="time" class="form-control form-control-sm " id="intake_time" name="intake_time" placeholder="Time" value="" />
                                    </div> --}}
                                
                                    <div class="form-group mb-0">
                                        <label for="type" class="col-form-label col-form-label-sm">Type.</label>
                                        <select onchange="changeOthers(this)" class="form-control form-control-sm" id="type" name="type">
                                            <option value="1">WATER</option>
                                            <option value="2">TEA</option>
                                            <option value="3">COFFEE</option>
                                            <option value="4">CLEAR SOUP</option>
                                            <option value="5">SOUP</option>
                                            <option value="6">COCONUT WATER</option>
                                            <option value="7">JUICE</option>
                                            <option value="8">MILK</option>
                                            <option value="9">FORMULA FEED</option>
                                            <option value="10">EBM</option>
                                            <option value="11">OTHERS</option>
                                        </select>
                                        <input class="form-control form-control-sm mt-2 d-none" type="text" id="type_others" name="type_others">
                                    </div>
                                
                                    <div class="form-group mb-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="intake_qty" class="col-form-label col-form-label-sm">Quantity</label>
                                                <input type="number" class="form-control form-control-sm " id="intake_qty" name="intake_qty" placeholder="Quantity" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="intake_qty" class="col-form-label col-form-label-sm">Unit</label>
                                                <select class="form-control form-control-sm" id="uom_no_fk" name="uom_no_fk">
                                                    @foreach ($uom as $item)
                                                        {{-- <option value="{{$item->uom_no_pk}}">{{$item->uom_code}}</option> --}}
                                                        @if ($item->uom_code == 'ML')
                                                            <option value="{{ $item->uom_no_pk }}" selected>{{ $item->uom_code }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="remarks" class="col-form-label col-form-label-sm">Remarks</label>
                                        <textarea type="text" class="form-control form-control-sm" id="in_remarks" name="remarks" placeholder="Remarks" rows="3"></textarea>
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


                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h6 class="text-center mt-2"><b>Intake History</b></h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center nowrap" style="width: 5%">Intake Type</th>
                                                        <th class="text-center nowrap" style="width: 12%">Time</th>
                                                        <th class="text-left nowrap" style="width: 17%">Type</th>
                                                        <th class="text-right nowrap" style="width: 15%">Quantity</th> 
                                                        <th class="text-left nowrap" style="width: 20%">Remarks</th>
                                                        <th class="text-center nowrap" style="width: 13%">Action</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($ipd_patintake as $key => $item)
                                                        <tr>
                                                            <td class="text-left nowrap">
                                                                @if($item->intake_type == 1)
                                                                    ORAL
                                                                @elseif($item->intake_type == 2)
                                                                    IV FLUID
                                                                @elseif($item->intake_type == 3)
                                                                    BLOOD PRODUCTS
                                                                @elseif($item->intake_type == 4)
                                                                    NG Tube
                                                                @elseif($item->intake_type == 5)
                                                                    PEG Tube
                                                                @endif
                                                            </td>
                                                            <td class="text-center">@if(!empty($item->patintake_date))
                                                                {{ date('h:i:s A',strtotime($item->patintake_date))}}
                                                            @endif</td>
                                                            <td class="text-left nowrap">

                                                                @if($item->intype == 1)
                                                                    WATER
                                                                @elseif($item->intype == 2)
                                                                    TEA
                                                                @elseif($item->intype == 3)
                                                                COFFEE
                                                                @elseif($item->intype == 4)
                                                                CLEAR SOUP
                                                                @elseif($item->intype == 5)
                                                                SOUP
                                                                @elseif($item->intype == 6)
                                                                COCONUT WATER
                                                                @elseif($item->intype == 7)
                                                                JUICE
                                                                @elseif($item->intype == 8)
                                                                MILK
                                                                @elseif($item->intype == 9)
                                                                FORMULA FEED
                                                                @elseif($item->intype == 10)
                                                                EBM
                                                                @elseif($item->intype == 11)
                                                                    {{ $item->type_others != null ? $item->type_others : 'OTHERS' }}
                                                                @endif
                                                                {{-- @elseif($item->intype == 11)
                                                                OTHERS
                                                                @endif --}}

                                                            </td>
                                                            <td class="text-right nowrap">{{$item->intake_value}} {{$item->uom_code}}</td> 
                                                            <td class="text-left nowrap">{{$item->remarks}}</td> 
                                                            <td class="text-center nowrap">	 
                                                                <button type="button" class="btn btn-sm btn-secondary" onclick="getPatIntake({{$item->patintake_no_pk}})">
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
                    </div>

                    <!-- Output -->
                    <div class="tab-pane fade " id="tab-output" role="tabpanel" aria-labelledby="output-tab">
                        <form  action="{{ route('ipd.save-output') }}" method="post" id="output">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="patoutput_no_pk" id="patoutput_no_pk" value="">
                                    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
                                    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
            
                                    {{-- <div class="form-group mb-0">
                                        <label for="output_time" class="col-form-label col-form-label-sm">Time</label>
                                        <input type="time" class="form-control form-control-sm" id="output_time" name="output_time" placeholder="Time" value="" />
                                    </div> --}}
                                
                                    <div class="form-group mb-0">
                                        <label for="output_urine" class="col-form-label col-form-label-sm">Urine</label>
                                        <input type="number" class="form-control form-control-sm" id="output_urine" name="output_urine" placeholder="Urine" value="" />
                                    </div>
                                
                                    <div class="form-group mb-0">
                                        <label for="output_emosis" class="col-form-label col-form-label-sm">Emesis(Vomit)</label>
                                        <input type="number" class="form-control form-control-sm" id="output_emosis" name="output_emosis" placeholder="Emesis" value="" />
                                    </div>
                                
                                    <div class="form-group mb-0">
                                        <label for="output_as_piration" class="col-form-label col-form-label-sm">NG As-piration</label>
                                        <input type="number" class="form-control form-control-sm" id="output_as_piration" name="output_as_piration" placeholder="RT As-Piration" value="" />
                                    </div> 
                                    <div class="form-group mb-0">
                                        <label for="output_drain" class="col-form-label col-form-label-sm">Drainage</label>
                                        <input type="number" class="form-control form-control-sm" id="output_drain" name="output_drain" placeholder="Output Drain" value="" />
                                    </div> 
                                    <div class="form-group mb-0">
                                        <label for="output_stool" class="col-form-label col-form-label-sm">Stool</label>
                                        <select class="form-control form-control-sm" id="output_stool" name="output_stool">
                                            <option value="No" selected>No</option>
                                            <option value="Yes" >Yes</option>
                                        </select>
                                    </div> 
                                    <div class="form-group mb-0">
                                        <label for="output_water_stool" class="col-form-label col-form-label-sm">Watery Stool</label>
                                        <input type="number" class="form-control form-control-sm" id="output_water_stool" name="output_water_stool" placeholder="water stool" value="" />
                                    </div> 

                                    <div class="form-group mb-0">
                                        <label for="" class="col-form-label col-form-label-sm">Remarks</label>
                                        <textarea type="text" class="form-control form-control-sm" id="out_remarks" name="remarks" placeholder="Remarks" rows="3"></textarea>
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

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <h6 class="text-center mt-2"><b>Output History</b></h6>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center nowrap" style="width: 15%">Time</th>
                                                        <th class="text-right nowrap" style="width: 10%">Urine</th>
                                                        <th class="text-right nowrap" style="width: 15%">Emesis</th>
                                                        <th class="text-right nowrap" style="width: 16%">RT As-piration</th> 
                                                        <th class="text-right nowrap" style="width: 17%">Drain</th>
                                                        <th class="text-right nowrap" style="width: 17%">Stool</th> 
                                                        <th class="text-right nowrap" style="width: 17%">Water Stool</th> 
                                                        <th class="text-center nowrap" style="width: 10%">Action</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($ipd_patoutput as $key => $item)
                                                        <tr>
                                                            <td class="text-center">@if(!empty($item->patoutput_date))
                                                                {{ date('h:i:s A',strtotime($item->patoutput_date))}}
                                                            @endif</td>
                                                            <td class="text-right nowrap">{{$item->urin_val}}</td>
                                                            <td class="text-right nowrap">{{$item->emosis_val}}</td> 
                                                            <td class="text-right nowrap">{{$item->rt_val}}</td> 
                                                            <td class="text-right nowrap">{{$item->drain_val}}</td> 
                                                            <td class="text-right nowrap">{{$item->stool_val}}</td>
                                                            <td class="text-right nowrap">{{$item->water_stool}}</td>
                                                            <td class="text-center nowrap">	 
                                                                <button type="button" class="btn btn-sm btn-secondary" onclick="getPatOutput({{$item->patoutput_no_pk}})">
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
                    </div>
                    <!-- report -->
                    <div class="tab-pane fade " id="tab-reports" role="tabpanel" aria-labelledby="reports-tab">
                        <div class="row">
                            <div class="col-12">
                               <h5 class="text-center py-2"><u> Intake Output Dates</u></h5>
                            </div>
                            @forelse($report_dates as $key => $item)
                                <div class="col-md-3  col-6">
                                   <a href="{{route('ipd.date-wise-intake-output-chart',[$patient_no_fk, $admission_id,$item])}}" target="_blank">
                                        <div class="alert {{$key%2 == 0 ? 'alert-primary' : 'alert-success'}} text-center datewise_intake" role="alert" title="Click to Download Intake Output Report">
                                            {{date('d/m/Y', strtotime($item))}}
                                        </div>
                                   </a>
                                </div>
                            @empty
                                <h5 class="text-danger text-center">Data Not Found!</h5>
                            @endforelse
                        </div>
                      
                    </div>

                </div>
            </div>
        </div>
    </div>
</diw>





<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    function changeOthers(element) {
        let others = $(element).val();
        if (others == '11') {
            $('#type_others').removeClass('d-none').attr('required', true);
        } else {
            $('#type_others').addClass('d-none').val('').removeAttr('required');
        }
    }


    $(document).ready(function(){
        $("#intake").validate({
            rules:{
                intake_type:{
                    required:true,
                },
                // intake_time:{
                //     required:true,
                // },
                intake_type:{
                    required:true,
                },
                intake_qty:{
                    required:true,
                },
            },
            messages:{
                intake_type:{
                    required: "Intake Type"
                },
                // intake_time:{
                //     required: "Intake Time",
                // },
                intake_type:{
                    required: "Intake Type",
                },
                intake_qty:{
                    required: "Intake Quantity",
                },
            }
        });

        // Output
        $("#output").validate({
            rules:{
                // output_time:{
                //     required:true,
                // },
                output_urine:{
                    required:true,
                },
                output_emosis:{
                    required:true,
                },
                output_as_piration:{
                    required:true,
                },
                output_drain:{
                    required:true,
                },
                output_stool:{
                    required:true,
                }
                output_water_stool:{
                    required:true,
                }
            },
            messages:{
                // output_time:{
                //     required: "Time Required"
                // },
                output_urine:{
                    required: "Urine Required",
                },
                output_emosis:{
                    required: "Emesis Required",
                },
                output_as_piration:{
                    required: "As-Piration",
                },
                output_drain:{
                    required: "Drain Required",
                },
                output_stool:{
                    required: "Stool Required",
                },
                output_water_stool:{
                    required: "Water Stool Required",
                },
            }
        });
    })
    
    function changeIntakeType(value){
        if(value == 2){
            $('#ivf_name_list').show();
        }else{
            $('#ivf_name_list').hide();
        }
    }

    function getPatIntake(patintake_no_pk){
        $.ajax({
			async: true,
			data: {
				patintake_no_pk: patintake_no_pk,
			},
			url: "{{ route('ipd.get-intake-info') }}",
			type: 'post',
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
				$.unblockUI();
                var result = data.data;
                $("#intake_type").val(result.intake_type);
                if(result.intake_type == 2){
                    $('#ivf_name_list').show();
                }else{
                    $('#ivf_name_list').hide();
                }
                $("#ivf_name").val(result.ivf_name);
                var time = [null,null];;
                if(result.patintake_date != null){
                     time = result.patintake_date.split(" ");
                }
                // $("#intake_time").val(time[1]);
                $("#type").val(result.intype);
                $("#uom_no_fk").val(result.uom_no_fk);
                $("#intake_qty").val(result.intake_value);
                $("#in_remarks").val(result.remarks);
                $("#patintake_no_pk").val(result.patintake_no_pk);
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

    function getPatOutput(patoutput_no_pk){
        $.ajax({
			async: true,
			data: {
				patoutput_no_pk: patoutput_no_pk,
			},
			url: "{{ route('ipd.get-output-info') }}",
			type: 'post',
			beforeSend: function() {
				blockUI();
			},
			success: function(data) {
				$.unblockUI();
                var result = data.data;
                var time = [null,null];
                if(result.patoutput_date != null){
                     time = result.patoutput_date.split(" ");
                }
                // $("#output_time").val(time[1]);
                $("#output_urine").val(result.urin_val);
                $("#output_emosis").val(result.emosis_val);
                $("#output_as_piration").val(result.rt_val);
                $("#output_drain").val(result.drain_val);
                $("#output_stool").val(result.stool_val);
                $("#output_water_stool").val(result.water_stool);
                $("#out_remarks").val(result.remarks);
                $("#patoutput_no_pk").val(result.patoutput_no_pk);


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
