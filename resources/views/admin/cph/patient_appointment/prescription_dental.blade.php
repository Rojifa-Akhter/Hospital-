<div class="card-body border-top pt-1" id="dental-teeth-con">
	<div class="row">
		@php
		$add_to_pres_url = route('add-pres-favourit-list');
		$adult_upper_right_arr = ["18" => "Teeth-18","17" => "Teeth-17","16" => "Teeth-16","15" => "Teeth-15","14" => "Teeth-14","13" => "Teeth-13","12" => "Teeth-12","11" => "Teeth-11"];
		$adult_upper_left_arr  = ["21" => "Teeth-21","22" => "Teeth-22","23" => "Teeth-23","24" => "Teeth-24","25" => "Teeth-25","26" => "Teeth-26","27" => "Teeth-27","28" => "Teeth-28"];
		$adult_lower_right_arr = ["48" => "Teeth-48","47" => "Teeth-47","46" => "Teeth-46","45" => "Teeth-45","44" => "Teeth-44","43" => "Teeth-43","42" => "Teeth-42","41" => "Teeth-41"];
		$adult_lower_left_arr  = ["31" => "Teeth-31","32" => "Teeth-32","33" => "Teeth-33","34" => "Teeth-34","35" => "Teeth-35","36" => "Teeth-36","37" => "Teeth-37","38" => "Teeth-38"];

		$child_upper_right_arr = ["55" => "Teeth-55", "54" => "Teeth-54", "53" => "Teeth-53", "52" => "Teeth-52", "51" => "Teeth-51"];				
		$child_lower_right_arr = ["85" => "Teeth-85", "84" => "Teeth-84", "83" => "Teeth-83", "82" => "Teeth-82", "81" => "Teeth-81"];
		$child_upper_left_arr  = ["61" => "Teeth-61", "62" => "Teeth-62", "63" => "Teeth-63", "64" => "Teeth-64", "65" => "Teeth-65"];
		$child_lower_left_arr  = ["71" => "Teeth-71", "72" => "Teeth-72", "73" => "Teeth-73", "74" => "Teeth-74", "75" => "Teeth-75"];
		@endphp
		<div class="col-5">
			<ul class="list-group list-group-horizontal">
				@foreach($adult_upper_right_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-navy teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>
			<ul class="list-group list-group-horizontal mt-1">
				@foreach($child_upper_right_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-blue teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>

			<ul class="list-group list-group-horizontal mt-1">
				@foreach($child_lower_right_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-blue teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>
			<ul class="list-group list-group-horizontal mt-1">
				@foreach($adult_lower_right_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-navy teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>
		</div>
		<div class="col">
			<ul class="list-group list-group-horizontal">
				@php
				$selected = in_array("Teeth-All", $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-blue w-100 text-center teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" id="Teeth-All">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">All</div>
				</li>
			</ul>
		</div>
		<div class="col-5">
			<ul class="list-group list-group-horizontal float-right">
				@foreach($adult_upper_left_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-navy teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>
			<div class="clearfix">
				<div class="clearfix">
					<ul class="list-group list-group-horizontal mt-1 float-right">
						@foreach($child_upper_left_arr as $key => $row)
						@php
						$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
						@endphp
						<li class="list-group-item list-group-item-blue teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
							<i class="fas fa-tooth" style="font-size: 20px;"></i>
							<div class="border-top text-center">{{ $key }}</div>
						</li>
						@endforeach
					</ul>
				</div>			
				<ul class="list-group list-group-horizontal mt-1 float-right">
					@foreach($child_lower_left_arr as $key => $row)
					@php
					$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
					@endphp
					<li class="list-group-item list-group-item-blue teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
						<i class="fas fa-tooth" style="font-size: 20px;"></i>
						<div class="border-top text-center">{{ $key }}</div>
					</li>
					@endforeach
				</ul>
			</div>
			<ul class="list-group list-group-horizontal mt-1 float-right">
				@foreach($adult_lower_left_arr as $key => $row)
				@php
				$selected = in_array($row, $selected_dental_arr)?"bg-danger":"";
				@endphp
				<li class="list-group-item list-group-item-navy teeth-item {{ $selected }}" onclick="prescriptionFunc.addSelectedTeeth(this)" onclick="prescriptionFunc.addSelectedTeeth(this)" id="{{ $row }}">
					<i class="fas fa-tooth" style="font-size: 20px;"></i>
					<div class="border-top text-center">{{ $key }}</div>
				</li>
				@endforeach
			</ul>
		</div>		
	</div>
</div>
<div class="card-body pt-1">
	<div class="form-row">
		<div class="col-md-4">
			<div class="form-group mb-1 border-bottom">
				<label class="col-form-label col-form-label-sm">Clinical Findings</label>
			</div>
			<div id="selected-teeth">
				<div>
					@if(!empty($dental_arr))
					@foreach($dental_arr as $dental_row)
					@foreach($dental_row as $row)
					@php
					$drow = explode("_", $row);
					@endphp
					<div class='selected-teeth-item' id='selected-teeth-item-{{ $drow[0] }}'>
						<div class='form-group form-row mb-0'>
							<label class='col-sm-4 col-form-label col-form-label-sm'>{{ $drow[3] }}</label>
							<div class='col-sm-6'>
								<input type='text' class='form-control mb-0 teeth_find' id='teeth_findings' name='teeth_findings' 
								onclick='prescriptionFunc.loadToPresFavouritListTeeth(this)' value="{{ $drow[1] }}" data-lookup-code='TEETHFIND'>
								<input type='hidden' class='left-element' name='item_id[]' id='item_id' value='{{ $drow[0] }}' readonly='readonly'>
								<input type='hidden' name='item_name[]' id='item_name' value='{{ $drow[1] }}' readonly='readonly'>
								<input type='hidden' name='lookup_id[]' id='lookup_id' value='' readonly='readonly'>
								<input type='hidden' name='lookup_code[]' id='lookup_code' value='TEETHFIND' readonly='readonly'>
								<input type='hidden' name='lookupdata_code[]' id='lookupdata_code' value='{{ $drow[3] }}' readonly='readonly'>
							</div>
							<div class='col-sm-2'>
								<span class="text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="{{ $add_to_pres_url }}" data-id="{{ $drow[0] }}" data-name="{{ $drow[1] }}" data-type="TEETHFIND"><i class="fa fa-star text-primary"></i></span>
								<span class="text-danger cursor-pointer" title="Remove This Item" onclick="prescriptionFunc.removeSelectedTeeth(this)"><i class="fa fa-times"></i></span>
							</div>
						</div>
						<div class="form-group"></div>
					</div>
					@endforeach
					@endforeach
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="form-group mb-0">
				<label for="clinical_disease" class="col-form-label col-form-label-sm">Treatment Plan</label>
				<textarea  class="form-control" name="txt_treatment_plan" id="txt_treatment_plan" rows="1"></textarea>
			</div>
			<div class="form-group"></div>
		</div>
	</div>
</div>
@include('admin.cph.patient_appointment.prescription_investigation_element')
@include('admin.cph.patient_appointment.prescription_general')