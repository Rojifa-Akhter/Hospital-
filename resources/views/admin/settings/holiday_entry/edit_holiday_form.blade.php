@php

$holiday_data = (isset($holiday_data) && (!empty($holiday_data))) ? $holiday_data : [];

$holiday_no_pk = ($holiday_data) ? $holiday_data->holiday_no_pk : '';
$holiday_name = ($holiday_data) ? $holiday_data->holiday_name : '';
$holiday_date = ($holiday_data) ? $holiday_data->holiday_date : '';
$holiday_year = ($holiday_data) ? $holiday_data->holiday_year : '';
$status = ($holiday_data) ? $holiday_data->status : '';


@endphp

							<form action="{{route('holiday_entry.store')}}" method="post" id="holiday-edit-id">
								 @csrf
								 <input type="hidden" name="id" value="{{$holiday_no_pk}}">


								 <div class="col-md-12">
								 	<div class="row">
								 		<div class="col-md-5">
								 			 <div class="form-group">

												<label for="grade_name" class="col-form-label col-form-label-sm">Holiday Name<span class="text-danger">*</span></label>
												<!-- <div class="col-sm-12"> -->
													<div class="col-md-12">
														<div class="row justify-content-center">
															<input type="text"
		                                                       class="form-control form-control-sm m-0"
		                                                       id="holiday_name" name="holiday_name" placeholder="Holiday Name" value="{{$holiday_name}}" required>
														</div>
													</div>
									<!-- </div> -->
											</div>	
								 			
								 		</div>


								 		<div class="col-md-5">
								 			 <div class="form-group">

												<label for="grade_name" class="col-form-label col-form-label-sm">Holidays Date <span class="text-danger">*</span></label>
												<!-- <div class="col-sm-12"> -->
													<div class="col-md-12">
														<div class="row justify-content-center">
															<input type="text"
		                                                       class="form-control form-control-sm m-0 date_picker"
		                                                       id="holiday_entry_data" name="holiday_entry_data" 
		                                                      value="{{date('d-m-Y',strtotime($holiday_date))}}" required>


		                                                     
														</div>
													</div>
									<!-- </div> -->
											</div>	
								 			
								 		</div>


								 		<div class="col-md-2 mt-4">
								 			 <div class="form-group">													
		                                                      @php
		               											 $response_action = route('holiday_entry.create');
		          											  @endphp
		          											  	<button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')" >Save</button>
											</div>	
								 			
								 		</div>


								 	</div>
								 </div>
											</div>
										</div>

							       
								</form>



<script>
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true
    });
    
</script>
