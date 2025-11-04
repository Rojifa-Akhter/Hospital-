<div class="card-body border-top pt-1">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group mb-0">
				<label for="clinical_disease" class="col-form-label col-form-label-sm">Investigation / Procedure</label>
				<input type="text" class="form-control mb-0" id="investigation_item" name="investigation_item"  placeholder="Enter Investigation or Procedure Name" onclick="prescriptionFunc.loadToPresFavouritList(this,'RAD,LAB','Investigation','#investigation', '{{ $action_url }}')">
			</div>
			<div class="form-group">
				@if(!empty($in_arr))
				@php
				$class = !empty($in_arr)?" border p-1":"";
				@endphp
				<ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation">
					@foreach($in_arr as $code => $rows)
					@foreach($rows as $row)
					@php
					$row_data = explode("_", $row);
					@endphp
					<li id="item-">
						<input type="hidden" name="item_id[]" value="" readonly="readonly">
						<input class="left-element" type="hidden" name="item_name[]" value="" readonly="readonly">
						<input type="hidden" name="lookup_id[]" value="" readonly="readonly">
						<input type="hidden" name="lookup_code[]" value="" readonly="readonly">
						<input type="hidden" name="lookupdata_code[]" value="" readonly="readonly">
						<i class="fa fa-angle-double-right"></i> &nbsp;&nbsp;
						<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="" data-id="" data-name="" data-type=""><i class="fa fa-star text-primary"></i></span>
					</li>
					@endforeach
					@endforeach
				</ul>
				@else
				<ul class="list-unstyled mb-0 pt-1" id="investigation"></ul>
				@endif
			</div>
		</div>
		<div class="col-md-4">

			<div class="form-group mb-0">
				<label for="clinical_disease" class="col-form-label col-form-label-sm">Findings</label>
				<input type="text" class="form-control mb-0" id="investigation_findings" name="investigation_findings"  placeholder="Write Findings" onclick="prescriptionFunc.loadToPresFavouritList(this,'INVFIND','Inv. Findings','#investigation_find_con', '{{ $action_url }}')" data-lookup-id="{{ $lookup_id_arr->INVFIND }}" data-lookup-code="INVFIND">
				<div class="card mt-0">
					<div class="card-body p-0">
						@if(!empty($inf_arr))
						@php
						$class = !empty($inf_arr)?" border p-1":"";
						@endphp
						<ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="investigation_find">
							@foreach($inf_arr as $rows)
							@foreach($rows as $row)
							@php
							$row_data = explode("_", $row);
							@endphp
							<li id="item-{{ $row_data[0] }}">
								<input type="hidden" name="item_id[]" value="{{ $row_data[0] }}" readonly="readonly">
								<input class="left-element" type="hidden" name="item_name[]" value="{{ $row_data[1] }}" readonly="readonly">
								<input type="hidden" name="lookup_id[]" value="{{ $row_data[2] }}" readonly="readonly">
								<input type="hidden" name="lookup_code[]" value="INVFIND" readonly="readonly">
								<input type="hidden" name="lookupdata_code[]" value="{{ $row_data[3] }}" readonly="readonly">
								<i class="fa fa-angle-double-right"></i> {{ $row_data[1] }}&nbsp;&nbsp;
								<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="{{ $add_to_pres_url }}" data-id="{{ $row_data[0] }}" data-name="{{ $row_data[1] }}" data-type="INVFIND"><i class="fa fa-star text-primary"></i></span>
							</li>
							@endforeach
							@endforeach
						</ul>
						@else
						<ul class="list-unstyled mb-0 pt-1" id="investigation_find_con"></ul>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="clinical_disease" class="col-form-label col-form-label-sm">Note</label>
				<input type="text" class="form-control mb-0" id="investigation_note" name="investigation_note"  placeholder="Write Note">
			</div>
		</div>
	</div>
</div>
<div class="card border-0">
	<div class="card-body">
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#quickrx" role="tab" aria-controls="home" aria-selected="true">
					Quick RX
				</a>
				<a class="nav-link" id="home-tab" data-toggle="tab" href="#spectacles" role="tab" aria-controls="home" aria-selected="true">
					Spectacles
				</a>
				<a class="nav-link" id="home-tab" data-toggle="tab" href="#ocularexamination" role="tab" aria-controls="home" aria-selected="true">
					Ocular Examination
				</a>
			</div>
		</nav>
	</div>

	<div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent">
		<div class="tab-pane fade show active border-bottom" id="quickrx" role="tabpanel" aria-labelledby="quickrx-tab">
			@include('admin.prescription.prescription_general')
		</div>
		<div class="tab-pane fade border-bottom" id="spectacles" role="tabpanel" aria-labelledby="spectacles-tab">
			@include('admin.prescription.prescription_eye_spactacles')
		</div>
		<div class="tab-pane fade" id="ocularexamination" role="tabpanel" aria-labelledby="ocularexamination-tab">
			@include('admin.prescription.prescription_eye_ocularexamination')
		</div>

	</div>
</div>
