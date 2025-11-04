@php

$radiology = (isset($radiology) && (!empty($radiology))) ? $radiology : [];
$item_code = ($radiology) ? $radiology->item_code : '';
$item_name = ($radiology) ? $radiology->item_name : '';
$item_no_pk = ($radiology) ? $radiology->item_no_pk : '';
$item_short_name = ($radiology) ? $radiology->item_short_name : '';
$sales_price = ($radiology) ? $radiology->sales_price : '';
$normal_delivery_hour = ($radiology) ? $radiology->normal_delivery_hour : '';
$urgent_delivery_hour = ($radiology) ? $radiology->urgent_delivery_hour : '';
$active_stat = ($radiology) ? $radiology->active_stat : '';
$serviceunit_no_fk = ($radiology) ? $radiology->serviceunit_no_fk : '';
$report_header = ($radiology) ? $radiology->report_header : '';
$stat_delivery_hour = ($radiology) ? $radiology->stat_delivery_hour : '';
 // dd($radiology);

@endphp

<div class="card">
	<div class="card-header"><h5>Radiology Investigation item Entry</h5></div>

	<div class="card-body">
		<form action="{{route('item.radiology-item-store')}}" method="post" id="form-submit">
			<input type="hidden" name="id" id="hdn_value" value="{{$item_no_pk}}">

			<div class="form-row align-items-center">
				<div class="col-md-12">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="item_name">Item Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control form-control-sm m-0" id="item_id" name="item_name" value="{{$item_name}}" placeholder="Item Name" autofocus="autofocus" required />
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="report_header">Report Header</label>
						<input type="text" class="form-control form-control-sm m-0" id="report_header" name="report_header" value="{{$report_header}}" placeholder="Report Header"/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="item_no_barcode">Item No/ Barcode <span class="text-danger">*</span></label>
						<input type="text" class="form-control form-control-sm m-0" id="item_no_barcode" name="item_no_barcode" value="{{$item_code}}" placeholder="Item No./ Barcode" required />
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="short_name">Short Name</label>
						<input type="text" class="form-control form-control-sm m-0" id="short_name" name="short_name" value="{{$item_short_name}}" placeholder="Short Name"/>
					</div>
				</div>


				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="normal_delivery_hour">Normal Deli. Hour</label>
						<input type="text" class="form-control form-control-sm m-0 number_only " id="normal_delivery_hour" name="normal_delivery_hour" value="{{$normal_delivery_hour}}" placeholder="Normal Deli. Hour"/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="urgent_delivery_hour">Urgent Deli. Hour</label>
						<input type="text" class="form-control form-control-sm m-0 number_only" id="urgent_delivery_hour" name="urgent_delivery_hour" value="{{$urgent_delivery_hour}}" placeholder="Urgent Delivery Hour"/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="item_price">Normal Fee</label>
						<input type="text" class="form-control form-control-sm m-0  number_only" id="item_price" name="item_price" value="{{$sales_price}}" placeholder="Normal Fee"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="urgent_item_price">Urgent Fee</label>
						<input type="text" class="form-control form-control-sm m-0  number_only" id="urgent_item_price" name="urgent_item_price" value="{{$sales_price}}" placeholder="Urgent Fee"/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="item_department" class="col-form-label col-form-label-sm">Department</label>
						<select class="form-control" id="item_department" name="item_department">
							<option value="">Select Department</option>
							@if(!empty($dept))
							@foreach($dept as $value)
							<option value="{{$value->serviceunit_no_pk}}" {{$value->serviceunit_no_pk == $serviceunit_no_fk ? 'selected' : ''}}>{{$value->serviceunit_name}}</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="stat_delivery_hour">Stat. Delivery Hour</label>
						<input type="text" class="form-control form-control-sm m-0 number_only" id="stat_delivery_hour" name="stat_delivery_hour" value="{{$stat_delivery_hour}}" placeholder="Start Delivery Hour"/>
					</div>
				</div>

				<div class="col-md-6">
					<div class="custom-control custom-checkbox custom-control-inline text-center mt-3">
						<input type="checkbox" id="radiology_active" name="radiology_active" class="custom-control-input" value="1" {{$active_stat==1 ? 'checked' : ''}}>
						<label class="custom-control-label" for="radiology_active">Active</label>
					</div>
				</div>

				<div class="col-12 text-right">
					@php
					$response_action = route('item.radiology-item-setup');
					@endphp
					<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
					<button type="reset" class="btn btn-info btn-md " title="Click here to Clear form data">Clear</button>
					<a href="#" class="btn btn-danger btn-md " rel="tab" title="Click here to go back to Dashboard">Exit</a>
				</div>
			</div>
		</form>
	</div>
</div>