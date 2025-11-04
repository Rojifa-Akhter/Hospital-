@php

$otherItem = (isset($other_item_data) && (!empty($other_item_data))) ? $other_item_data : [];

$item_uid = ($otherItem) ? $otherItem->item_code : '';
$item_name = ($otherItem) ? $otherItem->item_name : '';
$serviceunit_no_fk = ($otherItem) ? $otherItem->serviceunit_no_fk : '';
$anaesthesia_cat_ind = ($otherItem) ? $otherItem->anaesthesia_cat_ind : '';
$uom_no_fk = ($otherItem) ? $otherItem->uom_no_fk : '';
$dk_current_ind = ($otherItem) ? $otherItem->dk_current_ind : '';
$test_short_name = ($otherItem) ? $otherItem->test_short_name : '';
$expireable = ($otherItem) ? $otherItem->expireable : '';
$active_stat = ($otherItem) ? $otherItem->active_stat : '';
$item_no_pk = ($otherItem) ? $otherItem->item_no_pk : '';
$sales_price = ($otherItem) ? $otherItem->sales_price : '';
$purchase_price = ($otherItem) ? $otherItem->purchase_price : '';
$report_header = ($otherItem) ? $otherItem->report_header : '';
$ot_service_ind = ($otherItem) ? $otherItem->ot_service_ind : '';
$re_order_qty = ($otherItem) ? $otherItem->re_order_qty : '';
$item_uom_name = ($otherItem) ? $otherItem->item_uom_name : '';
$item_type = ($otherItem) ? $otherItem->item_type : '';
$itemtype_no_fk = ($otherItem) ? $otherItem->itemtype_no_fk : '';
$supplier_no_fk = ($otherItem) ? $otherItem->supplier_no_fk : '';
$manufacturer_no_fk = ($otherItem) ? $otherItem->manufacturer_no_fk : '';
$anaesthesia_cat_ind = ($otherItem) ? $otherItem->anaesthesia_cat_ind : '';
@endphp

<form action="{{route('item.other-item-store')}}" id="other-item" method="post">
	<input type="hidden" value="{{$item_no_pk}}" id="hdn_value" name="id">
	<div class="form-row align-items-center justify-content-center">
		<div class="col-md-6">
			<div class="text-center p-2 border my-2 ">
				<div class="custom-control custom-radio custom-control-inline text-center">
					<input type="radio" id="other_item_setup" name="otherOtDiet_item_setup" class="custom-control-input" value="OTHERS" {{'OTHERS' == $item_type ? 'selected' : ''}}>
					<label class="custom-control-label" for="other_item_setup">Others Item Setup</label>
				</div>

				<div class="custom-control custom-radio custom-control-inline text-center">
					<input type="radio" id="ot_item_setup" name="otherOtDiet_item_setup" class="custom-control-input" value="SUR"  checked="checked" {{'SUR' == $item_type ? 'selected' : ''}}>
					<label class="custom-control-label" for="ot_item_setup">OT Item Setup</label>
				</div>

				<div class="custom-control custom-radio custom-control-inline text-center">
					<input type="radio" id="diet_item_setup" name="otherOtDiet_item_setup" class="custom-control-input" value="FOOD" {{'FOOD' == $item_type ? 'selected' : ''}}>
					<label class="custom-control-label" for="diet_item_setup">Diet Item Setup</label>
				</div>
			</div>
		</div>



		<div class="col-md-10">
			<div class="form-row">
				<div class="col-md-4">
					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="item_no_barcode">Item No./ Barcode <span class="text-danger">*</span></label>
						<input type="text" class="form-control form-control-sm m-0" id="item_no_barcode" name="item_no_barcode" value="{{$item_uid}}" placeholder="Item No./ Barcode" autofocus="autofocus" required />
					</div>

					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="item_name">Item Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="{{$item_name}}" placeholder="Item Name" required />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="short_name">Short Name</label>
								<input type="text" class="form-control form-control-sm m-0" id="short_name" name="short_name" value="{{$test_short_name}}" placeholder="Short Name"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="item_type" class="col-form-label col-form-label-sm">Item Type</label>
						<select class="form-control" id="item_type" name="item_type">
							<option value="">Select Item Type</option>
							{{-- <option value="RAD" {{'RAD' == $item_type ? 'selected' : ''}} >Radiology</option>
							<option value="LAB" {{'LAB' == $item_type ? 'selected' : ''}} >Pathology</option>
							<option value="SUR" {{'SUR' == $item_type ? 'selected' : ''}} >Ot</option>
							<option value="FOOD" {{'FOOD' == $item_type ? 'selected' : ''}} >Diet</option>
							<option value="OTHER" {{'OTHER' == $item_type ? 'selected' : ''}} >Others</option>
							<option value="SERVICE" {{'SERVICE' == $item_type ? 'selected' : ''}} >Service</option> --}}
							@if(isset($itemType))
							@foreach($itemType as $key => $val)
							<option value="{{$key}}" {{$itemtype_no_fk == $key ? 'selected' : '' }}>{{$val}}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="item_map_type">Item Map Type</label>
								<input type="text" class="form-control form-control-sm m-0" id="item_map_type" name="item_map_type" value="{{$item_uom_name}}" placeholder="Item Map Type" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="item_department" class="col-form-label col-form-label-sm">UOM Name</label>
								<select class="form-control" id="uom" name="uom">
									<option value="">Select Item UOM</option>
									@if(isset($uom))
									@foreach($uom as $key => $val)
									<option value="{{$key}}" {{$uom_no_fk == $key ? 'selected' : '' }}>{{$val}}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label for="item_department" class="col-form-label col-form-label-sm">Department</label>
						<select class="form-control" id="item_department" name="item_department">
							<option value="">Select Department</option>
							@if(isset($service_unit))
							@foreach($service_unit as $key => $val )
							<option value="{{$val->serviceunit_no_pk}}" {{$serviceunit_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>{{$val->serviceunit_name}}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="sales_price">Sales Price</label>
								<input type="text" class="form-control form-control-sm m-0 number_only" id="sales_price" name="sales_price" value="{{$sales_price}}" placeholder="Sales Price" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="purchase_unit_price">Purchase/Unit Price</label>
								<input type="text" class="form-control form-control-sm m-0 number_only" id="purchase_unit_price" name="purchase_unit_price" value="{{$purchase_price}}" placeholder="Purchase/Unit Price" />
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="re_order_qty">Re Order Qty.</label>
								<input type="text" class="form-control form-control-sm m-0 number_only" id="re_order_qty" name="re_order_qty" value="{{$re_order_qty}}" placeholder="Re Order Qty" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label col-form-label-sm" for="discount_amount">Discount Amount</label>
								<input type="text" class="form-control form-control-sm m-0 number_only" id="discount_amount" name="discount_amount" value="{{$dk_current_ind}}" placeholder="Discount Amount"/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-form-label col-form-label-sm" for="report_header">Report Header</label>
						<input type="text" class="form-control form-control-sm m-0" id="report_header" name="report_header" value="{{$report_header}}" placeholder="Report Header"/>
					</div>
				</div>

				<div class="col-md-4">
					{{-- <div class="form-group">
						<label for="edsims_category" class="col-form-label col-form-label-sm">AFMSD Category</label>
						<select class="form-control" id="edsims_category" name="edsims_category">
							<option value="">Select AFMSD Category</option>
							@if(isset($afmsd))
							@foreach($afmsd as $key => $val)
							<option value="{{$key}}" {{$anaesthesia_cat_ind == $key ? 'selected' : '' }}>{{$val}}</option>
							@endforeach
							@endif
						</select>
					</div> --}}

					<div class="form-group">
						<label for="supplier" class="col-form-label col-form-label-sm">Supplier</label>
						<select class="form-control" id="supplier" name="supplier">
							<option value="0">Select Supplier</option>
							@if(isset($supplier))
							@foreach($supplier as $key => $val )
							<option value="{{$val->supplier_no_pk}}" {{$supplier_no_fk == $val->supplier_no_pk ? 'selected' : '' }}>{{$val->supplier_name}}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="form-group">
						<label for="manufacturer" class="col-form-label col-form-label-sm">Manufacturer</label>
						<select class="form-control" id="manufacturer" name="manufacturer">
							<option value="">Select Manufacturer</option>
							@if(isset($manufacturer))
							@foreach($manufacturer as $key => $val )
							<option value="{{$val->supplier_no_pk}}" {{$supplier_no_fk == $val->supplier_no_pk ? 'selected' : '' }}>{{$val->supplier_name}}</option>
							@endforeach
							@endif
						</select>
					</div>

					<div class="form-group"  id="myDIV">
						<label class="col-form-label col-form-label-sm" for="ot_duration">OT Duration</label>
						<input type="text" class="form-control form-control-sm m-0" id="ot_duration" name="ot_duration" value="{{$ot_service_ind}}" placeholder="OT Duration"/>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-2">						

			<div class="custom-control custom-checkbox">
				<input class="custom-control-input" type="checkbox" id="expirable" name="expirable" value="1"{{ $expireable == '1' ? 'checked' : '' }}>
				<label class="custom-control-label" for="expirable">Expirable</label>
			</div>

			<div class="custom-control custom-checkbox">
				<input class="custom-control-input" type="checkbox" id="demand_flag" name="demand_flag" value="1" {{ $dk_current_ind == '1' ? 'checked' : '' }}>
				<label class="custom-control-label" for="demand_flag">Demand Flag</label>
			</div>
			<div class="custom-control custom-checkbox">
				<input class="custom-control-input" type="checkbox" id="active" name="active" value="1" {{ $active_stat == '1' ? 'checked' : '' }}>
				<label class="custom-control-label" for="active">Active</label>
			</div>
		</div>

		<div class="col-md-12 mt-2 border-top pt-2">

			@php
			$response_action = route('item.other-item-worklist');
			@endphp
			<button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"> Save</button>
			<button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
			<a href="#" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
		</div>
	</div>
</form>