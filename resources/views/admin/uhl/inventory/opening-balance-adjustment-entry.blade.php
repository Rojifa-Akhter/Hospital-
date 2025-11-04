<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('css/typeaheadjs.css')}}">
<link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('uhl_assets/css/uhl_style.css')}}" />
<main id="page-content">
	<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
	<form action="{{route('v1.opening-balance-adjustment-entry-store')}}" id="adjustment" method="post">
		<section class="paitent__registration_details">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row bg-white border-bottom sticky-top shadow-sm">
							<div class="col-md-10">
								<h5 class="mt-2 mb-0">Opening Balance & Adjustment Entry</h5>
								<small>Inventory / Opening Balance & Adjustment Entry</small>
							</div>
						</div>
					</div>
				</div>

				@csrf

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5>Adjustment</h5>
							</div>
							<div class="card-body p-2">
								<div class="form-row">
									<div class="col-lg-12 col-md-12 col-12">
										<div class="row align-items-center">
											<div class="col-md-8">
												<!-- <div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioOpening" value="OPEN" onchange="typeChecked(this)" required />
													<label class="form-check-label" for="inlineRadioOpening">Opening</label>
												</div> -->
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="inlineRadioOptions" id="positive_adjestment" value="ADJPOS" onchange="typeChecked(this)" required />
													<label class="form-check-label" for="positive_adjestment">
														@if(Session::get('user.ses_hospital_code')=="DMHL")
														Stock Reconciliation Add
														@else
														Positive Adjustment
														@endif
													</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="inlineRadioOptions" id="negative_adjestment" value="ADJNEG" onchange="typeChecked(this)" required />
													<label class="form-check-label" for="negative_adjestment">
														
														@if(Session::get('user.ses_hospital_code')=="DMHL")
														Stock Reconciliation Subtract
														@else
														Negative Adjustment
														@endif
													</label>
												</div>											
											</div>											
										</div>

									</div>

									<div class="col-lg-4 col-md-6 col-12">
										<div class="form-group form-row">
											<label for="store-to-effect" class="col-sm-6 col-form-label">Store Name <span class="text-danger">*</span></label>
											<div class="col-sm-6">
												<select class="form-control form-control-sm select2" id="store-to-effect" name="store_to_effect" onchange="" required>
													<option value="">Select</option>
													@if(!empty($store))
													@foreach($store as $value)
													<option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>
													@endforeach
													@endif
												</select>
											</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-12">
										<div class="form-group form-row">
											<label for="date" class="col-sm-6 col-form-label">Date</label>
											<div class="col-sm-6">
												<input type="text" class="form-control form-control-sm" id="trns_date" name="date" autocomplete="off" value="{{date('d-m-Y')}}" />
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12">
										<div class="form-group form-row">
											<label for="reason_adjustment" class="col-sm-2 col-form-label">Reason for Adjustment</label>
											<div class="col-sm-10">
												<textarea class="form-control form-control-sm" id="reason_adjustment" name="reason_adjustment"></textarea>
											</div>
										</div>
									</div>

									<div class="col-lg-12 col-md-12 col-12">
										<div class="form-group form-row">
											<label for="remarks" class="col-sm-2 col-form-label">Remarks</label>
											<div class="col-sm-10">

												<textarea class="form-control form-control-sm" id="remarks" name="remarksMst"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card-body p-2">
								<div class="form-row">
									<div class="col-lg-2 col-md-6 col-12">
										<div class="form-group">
											<label for="item_name" class="col-form-label">Item Name/Code</label>
											<input type="text" class="form-control form-control-sm" id="item_name" name="" placeholder="" />
											<input type="hidden" id="item_id_hidden" />
											<input type="hidden" class="form-control form-control-sm" id="item_code" name="" placeholder="" />
										</div>
									</div>

									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="uom" class="col-form-label">UOM</label>
											<input type="text" class="form-control form-control-sm" id="item_uom" name="" placeholder="" readonly />
											<input type="hidden" id="item_uom_hidden" name="item_uom_hidden" />
										</div>
									</div>
									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="internal_batch" class="col-form-label">Internal Batch</label>

											<select class="form-control form-control-sm select2" id="internal_batch" name="" onchange="setBatchDate(this)">

											</select>
										</div>
									</div>


									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="Batch" class="col-form-label">Batch</label>
											<input type="text" class="form-control form-control-sm" id="Batch" name="" placeholder="" readonly />
										</div>
									</div>
									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="expiry_date" class="col-form-label">Expiry Date</label>
											<input type="text" class="form-control form-control-sm date_picker" id="expiry_date" name="" autocomplete="off" placeholder="dd-mm-yyyy" readonly />
										</div>
									</div>


									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="purchase_price" class="col-form-label">P. Price</label>
											<input type="text" class="form-control form-control-sm" id="item_price" name="" placeholder="" />
										</div>
									</div>
									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="sales_price" class="col-form-label">Sales Price</label>
											<input type="text" class="form-control form-control-sm" id="sales_price" name="" placeholder="" />
										</div>
									</div>

									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="stock_quantity" class="col-form-label">Stock Qty</label>
											<input type="text" class="form-control form-control-sm " id="stock_quantity" name="" placeholder="" readonly />
										</div>
									</div>
									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="item_quantity" class="col-form-label">Item Qty</label>
											<input type="text" class="form-control form-control-sm number_only" id="item_quantity" name="" placeholder="" onkeyup="setQty(this)" />
										</div>
									</div>
									<div class="col-lg-1 col-md-6 col-12">
										<div class="form-group">
											<label for="item_remarks" class="col-form-label">Remarks</label>
											<input type="text" class="form-control form-control-sm" id="item_remarks" name="" placeholder="remarks" />
										</div>
									</div>
									<div class="form-group col-md-1">
										<input type="hidden" name="hospital_code" id="hospital_code" value="{{Session::get('user.ses_hospital_code')}}">
										<button type="button" id="" class="btn btn-success btn-block btn-md btn-md-global mt-4" onclick="setData(this)">
											<i class="fa fa-plus"></i>
											Add
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body p-2">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead class="global-uhl-table-bg">
											<tr>
												<th class="text-left">SL</th>
												<th class="text-left">Item Code</th>
												<th class="text-left">Item Name</th>
												<th class="text-left">UoM</th>
												<th class="text-center">Item Quantity</th>
												<th class="text-left">Internal Batch</th>
												<th class="text-left">Batch</th>
												<th class="text-left">Expiry Date</th>
												<th class="text-center">Purchase Price</th>
												<th class="text-center">Sales Price</th>
												<th class="text-left">Item Remarks</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody id="t_body">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="card mb-2">
							<div class="card-body">
								<div class="form-group">
									<ul class="list-inline btn__box">
										@php
										$response_action=route('v1.opening-balance-adjustment-entry');
										@endphp
										<li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn" onclick="saveData(this)">Save</button></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</form>
</main>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/typeahead.bundle.js')}}"></script>

<script>
	$("body").addClass("sidebar-collapse");
	$('.date_picker').datepicker({
		todayHighlight: true,
		clearBtn: true,
		autoclose: true,
		format: 'dd-mm-yyyy'
	});
	$('#trns_date').datepicker({
		todayHighlight: true,
		clearBtn: true,
		autoclose: true,
		format: 'dd-mm-yyyy'
	});
	$('.select2').select2();

	$(document).ready(function(){
			$("[name='store_to_effect']").on('change', function() {
					itemFunc($('#store-to-effect'))
			})
		});
	function itemFunc(store_id) {
		$(".item_typehead").each(function() {
            $(this).typeahead('destroy'); // Custom method to remove typeahead
            $(this).off(); // Remove all event handlers
            $(this).val(''); // Clear the input value
            $(this).parent().find('.tt-menu').remove(); // Remove the dropdown menu
        });
		
		// item_info_autocomplete_store_supplier_wise
		// item_info_autocomplete_store_to_store
		item_info_autocomplete_store_add_out('#item_name', 'item_name', store_id, '', function(item, obj) {
			var purchase_price = parseFloat(item.purchase_price);
			var item_price = parseFloat(item.item_rate);
			console.log(item);
			$('#item_id_hidden').val(item.item_id);
			$('#item_uom_hidden').val(item.uom_no_fk);
			$('#item_uom').val(item.uom_name);
			//$('#pvms_no').val(item.pvms_no);
			$('#item_code').val(item.item_code);
			$('#item_price').val(purchase_price.toFixed(2));
			$('#sales_price').val(item_price.toFixed(2));
			$('#item_name').val(item.item_name);
			$('#expiriable_ind').val(item.expireable);
			$('#item_conversion').val(item.pr_uom_conversion_qty);
			// if ($('#hospital_code').val()=="DMHL") {			
			// 	$('#stock_quantity').val(item.stock_qty);
			// }			
			
			var internal_batch = '<option value="">select</option>';
			if (item.internal_batch != null) {
				item.internal_batch.forEach(element => {
					console.log(element.internal_batch_no_uq)
					internal_batch += '<option value="' + element.internal_batch_no_uq + '" data-batch="' + element.batch_no + '" data-exp_date="' + element.expiry_date + '" data-stock="' + element.item_qty + '" data-sales_price="'+element.sales_price+'" data-price_price="'+element.purchase_price+'">' + element.internal_batch_no_uq + '</option>';
				});
			}
			$('#internal_batch').html(internal_batch);
			// alert(item.expireable)
			// console.log(item.expireable);
			obj.stopImmediatePropagation();
		});
}



	

	function setBatchDate(element) {

		var qty = $(element).find('option:selected').attr('data-stock') != null ? $(element).find('option:selected').attr('data-stock') : 0;
		var sales_price = $(element).find('option:selected').attr('data-sales_price') != null ? $(element).find('option:selected').attr('data-sales_price') : 0;
		var purchase_price = $(element).find('option:selected').attr('data-price_price') != null ? $(element).find('option:selected').attr('data-price_price') : 0;
		var batch = $(element).find('option:selected').attr('data-batch') != "null" ? $(element).find('option:selected').attr('data-batch') : '';
		var exp_date = $(element).find('option:selected').attr('data-exp_date') != "null" ? $(element).find('option:selected').attr('data-exp_date') : '';
		$('#Batch').val(batch);
		$('#stock_quantity').val(qty);
		$('#sales_price').val(sales_price);
		$('#item_price').val(purchase_price);
		if ($(element).find('option:selected').val()=='') {
			$('#sales_price').prop('readonly',false);
			$('#item_price').val(0);
		}else{
			$('#sales_price').prop('readonly',true);
		}
		
		$('#item_quantity').val('');
		console.log(exp_date + '_exp_date');
		if (exp_date && exp_date.trim() !== "") {
			var date = new Date(exp_date);
			var formattedDate = formatDate(date);
			$('.date_picker').datepicker('setDate', formattedDate);
			console.log(batch, exp_date)
		}else{
          
		  $('.date_picker').datepicker('setDate', '');
	  }

	}

	function typeChecked(element) {
		var type = $('input[name="inlineRadioOptions"]:checked').val();
		$('#item_quantity').val('');
		if (type == "ADJPOS" || type == "OPEN") {
			$('#Batch').prop('readonly', false);
			$('#expiry_date').prop('readonly', false);
		} else {
			$('#Batch').prop('readonly', true);
			$('#expiry_date').prop('readonly', true);
		}
	}

	function setQty(element) {
		var qty = parseFloat($(element).val());
		var stock_qty = $('#stock_quantity').val() != "" ? parseFloat($('#stock_quantity').val()) : 0;
		var type = $('input[name="inlineRadioOptions"]:checked').val();
		if (type == "ADJPOS" || type == "OPEN") {
			$('#Batch').prop('readonly', false);
			console.log(type + '____1');
			if (stock_qty < 0) {
				alert('Invalid Qty');
				$(element).val('');
				return false;
			}
		} else {
			console.log(type + '____2');
			if (stock_qty <= 0 || qty > stock_qty) {
				alert('Invalid Qty');
				$(element).val('');
				return false;
			}
		}

	}

	function setData(element) {
		
		var item_id = $('#item_id_hidden').val();
		var item_code = $('#item_code').val();
		var item_name = $('#item_name').val();
		var item_uom = $('#item_uom').val();
		var item_uom_id = $('#item_uom_hidden').val();
		var item_qty = $('#item_quantity').val();
		var internal_batch = $('#internal_batch').val();
		var batch = $('#Batch').val();
		var exp_date = $('#expiry_date').val();
		var p_price = $('#item_price').val();
		var sales_price = $('#sales_price').val();
		var remarks = $('#item_remarks').val();
		var sl = ($('#t_body tr').length + 1);

		if (item_qty <= 0 || item_qty == "") {
			alert('Enter Qty');
			return false;
		}
		if ($('#item_id_hidden').val() == "") {
			alert('Enter Item Name');
			return false;
		}
		if ($('#positive_adjestment').is(':checked') && ($('#Batch').val() =='' || $('#expiry_date').val()=='')) {
			alert('Enter Batch & Expiry Date');
			return false;
		}
		// if (internal_batch == "") {
		// 	alert('Select Internal Batch');
		// 	return false;
		// }

		var check_batch = 0;
		$('.internal_batch').each(function(index, element) {
			var internal_batch_id = $(element).val();
			if (internal_batch_id !="" && internal_batch_id == internal_batch) {
				check_batch = 1;
				alert('Already Exit This Internal Batch Id');
				$('#item_id_hidden').val('');
				$('#item_code').val('');
				$('#item_name').val('');
				$('#item_uom').val('');
				$('#item_uom_hidden').val('');
				$('#item_quantity').val('');
				$('#stock_quantity').val('');
				$('#internal_batch').val('').trigger('change');
				$('#Batch').val('');
				$('#expiry_date').val('');
				$('#item_price').val('');
				$('#sales_price').val('');
				$('#item_remarks').val('');
				return false;
			}
			console.log(internal_batch + '_internal_batch_' + index);
		});
		if (check_batch == 1) {
			return false;
		}
		var row = `
		<tr>
			 <input type="hidden" name="item_id[]" value="${item_id}"/>
			 <input type="hidden" name="item_uom_id[]" value="${item_uom_id}"/>
			<td class="text-left ls" >
			 ${sl}
			
			 </td>
			<td class="text-left"> <input type="text" name="item_code[]" class="form-control" value="${item_code}" readonly/> </td>
			<td class="text-left"> <input type="text" name="item_name[]" class="form-control" value="${item_name}" readonly/> </td>
			<td class="text-left"> <input type="text" name="item_uom[]" class="form-control" value="${item_uom}" readonly/> </td>
			<td class="text-center"> <input type="text" name="item_qty[]" class="form-control" value="${item_qty}" readonly/> </td>
			<td class="text-left"> <input type="text" name="internal_batch[]" class="form-control internal_batch" value="${internal_batch}" readonly/> </td>
			<td class="text-left"> <input type="text" name="batch[]" class="form-control" value="${batch}" readonly/> </td>
			<td class="text-left"> <input type="text" name="exp_date[]" class="form-control" value="${exp_date}" readonly/> </td>
			<td class="text-right"> <input type="text" name="p_price[]" class="form-control" value="${p_price}" readonly/> </td>
			<td class="text-right"> <input type="text" name="sales_price[]" class="form-control" value="${sales_price}" readonly/> </td>
			<td class="text-left"> <input type="text" name="remarks[]" class="form-control" value="${remarks}" readonly/> </td>
			<td class="text-center">
			<span class="cursor-pointer" onclick="removeItem(this)"><i class="fas fa-times-circle" style="color: red;" ></i></span>
		</td>
		`;
		$('#t_body').append(row);

		$('#item_id_hidden').val('');
		$('#item_code').val('');
		$('#item_name').val('');
		$('#item_uom').val('');
		$('#item_uom_hidden').val('');
		$('#item_quantity').val('');
		$('#stock_quantity').val('');
		$('#internal_batch').html('');
		$('#Batch').val('');
		$('#expiry_date').val('');
		$('#item_price').val('');
		$('#sales_price').val('');
		$('#item_remarks').val('');

	}

	function removeItem(element) {
		if (confirm('Are you sure?')) {
			$(element).parents('tr').remove();
		}
		$('.ls').each(function(index, element) {
			$(this).html(index + 1)
		});
	}

	function saveData(element) {
		if ($('#t_body tr').length <= 0) {
			alert('select Item');
			return false;

		}
		btnSaveUpdate(element, '', '', '', '', dynamicFunc.afterSaveLoadPage, "{{route('v1.opening-balance-adjustment-entry')}}")
	}

</script>