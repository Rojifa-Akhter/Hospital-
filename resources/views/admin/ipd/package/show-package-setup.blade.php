<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('css/typeaheadjs.css')}}">
<link rel="stylesheet" href="{{asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('uhl_assets/css/uhl_style.css')}}" />
<main id="page-content">
	<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
	<form id="packageForm" action="{{ route('v1.ipd-package-store') }}" method="post">
		<section class="ipd__package_details">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="row bg-white border-bottom sticky-top shadow-sm">
							<div class="col-md-10">
								<h5 class="mt-2 mb-0">Package Setup</h5>
								<small>Ipd / Package Setup</small>
							</div>
						</div>
					</div>
				</div>

				@csrf

				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<h5>Package</h5>
							</div>
							<div class="card-body p-2">
								<div class="form-row">
									<div class="col-lg-12 col-md-4 col-12 mb-2">
                                        <input type="hidden" name="pkg_no_pk" value="{{ $package->pkg_no_pk ?? '' }}">
										<div class="form-group form-row">
											<label for="package_name" class="col-sm-1 col-form-label">Package Name</label>
											<div class="col-sm-4">
												<input type="text" class="form-control form-control-sm" id="package_name" name="package_name" autocomplete="off" placeholder="Package Name" value="{{ $package->pkg_name ?? '' }}"/>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-4 col-12 mb-2">
										<div class="form-group form-row">
											<label for="package_details" class="col-sm-1 col-form-label">Package Details</label>
											<div class="col-sm-10">
												<textarea class="form-control form-control-sm" id="package_details" name="package_details" placeholder="Package Details">{{ $package->pkg_details ?? '' }}</textarea>
											</div>
										</div>
									</div>
                                   @php
                                        $packageFor = $package->pkg_for_ipd ?? 1; 
                                    @endphp

                                    <div class="col-lg-12 col-md-4 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="package_for" class="col-sm-1 col-form-label">Package For</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="package_for" id="package_for_ipd" value="1" {{ isset($package) ? ($package->pkg_for_ipd ? 'checked' : '') : 'checked' }}>
                                                <label class="form-label" for="package_for_ipd">IPD</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="package_for" id="package_for_opd" value="2" {{ isset($package) && $package->pkg_for_opd ? 'checked' : '' }}>
                                                <label class="form-label" for="package_for_opd">OPD</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="package_for" id="package_for_daycare" value="3" {{ isset($package) && $package->pkg_for_daycare ? 'checked' : '' }}>
                                                <label class="form-label" for="package_for_daycare">Daycare</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-4 col-12 mb-2">
                                        <div class="form-group form-row">
                                            <label for="bed_category" class="col-sm-1 col-form-label">Bed Category</label>
                                            <div class="col-sm-4">
                                                <select class="form-control form-control-sm" name="bed_category" id="bed_category">
                                                    <option value="0">Select</option>
                                                    @foreach ($bedcategory as $key => $bed)
                                                        <option value="{{ $key }}">{{ $bed }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label">Limit of Amount</label>
                                            <div class="col-sm-11">
                                                <div class="row mb-2">
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_pathology" class="form-label">Pathology</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_pathology" name="package_pathology" placeholder="Package pathology" value="{{ $package->pathology_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_radiology" class="form-label">Radiology</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_radiology" name="package_radiology" placeholder="Package radiology" value="{{ $package->radiology_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_medicine" class="form-label">Medicine</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_medicine" name="package_medicine" placeholder="Package medicine" value="{{ $package->medicone_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_consultation" class="form-label">Consultation</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_consultation" name="package_consultation" placeholder="Package consultation" value="{{ $package->consultation_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_ot" class="form-label">Ot</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_ot" name="package_ot" placeholder="Package ot" value="{{ $package->ot_sur_ana_amount ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_procedure" class="form-label">Procedure</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_procedure" name="package_procedure" placeholder="Package procedure" value="{{ $package->procedure_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_food" class="form-label">Food</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_food" name="package_food" placeholder="Package food" value="{{ $package->food_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_services" class="form-label">Services</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_services" name="package_services" placeholder="Package services" value="{{ $package->service_amount ?? '' }}">
                                                    </div>
                                                    <div class="col-lg-2 col-md-4 mb-2">
                                                        <label for="package_consumable" class="form-label">Consumable</label>
                                                        <input type="number" class="form-control form-control-sm" id="package_consumable" name="package_consumable" placeholder="Package consumable" value="{{ $package->consumable_amount ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-12 mb-2">
                                        <div class="form-group row align-items-center">
                                            <label for="original_rate" class="col-sm-1 col-form-label">Original Rate <span class="text-danger">*</span></label>
                                            <div class="col-sm-2">
                                                <input type="number" class="form-control form-control-sm" id="original_rate" name="original_rate" autocomplete="off" placeholder="Original Rate" />
                                            </div>

                                            <label for="map_service_item" class="col-sm-2 form-label">Map Service Item</label>
                                            <div class="col-sm-2">
                                                <select class="form-control form-control-sm" onchange="displaySalesPrice(this)" name="map_service_item" id="map_service_item">
                                                    <option value="0">Select</option>
                                                    @foreach ($service_item as $item)
                                                        <option data-salesPrice="{{ $item->sales_price }}" value="{{ $item->item_no_pk }}">{{ $item->item_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <label for="package_rate" class="col-sm-2 form-label">Package Rate</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-label" id="package_rate" name="package_rate" placeholder="Display Sales Price" />
                                            </div>
                                        </div>
                                    </div>

								</div>
							</div>
                            <div class="card-body p-2">
                                <div class="form-row align-items-center">
                                    <div class="col-lg-2 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="item_name" class="col-form-label">Item Name</label>
                                            <input type="text" class="form-control form-control-sm" id="item_name" name="item_name" placeholder="Item Name" />
                                            <input type="hidden" id="item_id_hidden" />
                                            <input type="hidden" id="item_id_hidden" class="item_no_pk" />
                                            <input type="hidden" id="item_type_hidden" class="item_type" />

                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="item_type" class="col-form-label">Item Type</label>
                                            <input type="text" class="form-control form-control-sm" id="item_type" value="{{ $item->item_type_name ?? '' }}" readonly />
                                            <input type="hidden" id="item_type_hidden" name="item_type_id" value="{{ $item->item_type ?? '' }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="item_qty" class="col-form-label">Item Qty</label>
                                            <input type="number" class="form-control form-control-sm number_only" id="item_qty" name="item_qty" placeholder="Item qty" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="item_rate" class="col-form-label">Item Rate</label>
                                            <input type="number" class="form-control form-control-sm" id="item_rate" name="item_rate" placeholder="Item rate" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="item_package_rate" class="col-form-label">Package Rate</label>
                                            <input type="number" class="form-control form-control-sm" id="item_package_rate" name="item_package_rate" placeholder="Package rate" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="package_discount_percent" class="col-form-label">Package Discount %</label>
                                            <input type="text" class="form-control form-control-sm" id="package_discount_percent" name="" placeholder="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12 mb-2">
                                        <div class="form-group">
                                            <label for="package_discount_amount" class="col-form-label">Package Discount Amount</label>
                                            <input type="number" class="form-control form-control-sm" id="package_discount_amount" name="package_discount_amount" placeholder="Package discount amount" />
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-11 mb-2">
										<button style="width:58px;" type="button" id="package-add" onclick="addPackageItem(this)" class="btn btn-success btn-block btn-sm btn-md-global mt-4">
											<i class="fa fa-plus"></i>
											Add
										</button>
									</div>
                                </div>
                                <div id="added-items-container" class="mt-2">
                                    <div id="added-items-container" class="mt-2">
                                        @isset($packageItems)
                                            @foreach($packageItems as $item)
                                                <div class="add-package-item row align-items-center mb-1">
                                                    <input type="hidden" class="item_no_pk" value="{{ $item->item_no_fk }}" />
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm item_name" value="{{ $item->item_name }}" readonly></div>
                                                    <div class="col-md-1"><input type="text" class="form-control form-control-sm item_type" value="{{ $item->item_type }}" readonly></div>
                                                    <div class="col-md-1"><input type="text" class="form-control form-control-sm item_qty" value="{{ $item->item_qty }}" readonly></div>
                                                    <div class="col-md-1"><input type="text" class="form-control form-control-sm item_rate" value="{{ $item->item_rate }}" readonly></div>
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm item_package_rate" value="{{ $item->item_pkg_rate }}" readonly></div>
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm package_discount_percent" value="{{ $item->item_pkg_discount_pct }}" readonly></div>
                                                    <div class="col-md-2"><input type="text" class="form-control form-control-sm package_discount_amount" value="{{ $item->item_pkg_discount_amt }}" readonly></div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm remove-package-item">Delete</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2 mt-2">
                                <div class="form-row">
                                    <div class="col-11 mb-2" style="text-align: end;">
                                        <button type="button" onclick="savePackageItem()" class="btn btn-secondary uhl_common_btn">Save</button>
                                    </div>
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
    function displaySalesPrice(element){
        let selectedOption = $(element).find('option:selected');
        let salesPrice = selectedOption.data('salesprice') || '';
        console.log (salesPrice);
        $('#package_rate').val(salesPrice);
    }

    
    $(document).ready(function() {
        pharmacy_autocomplete_iteminfo_by_item_name('#item_name', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_type').val(item.item_type_name);    
            $('#item_type_hidden').val(item.item_type);
            $('#item_qty').val(1); 
            $('#item_rate').val(item.purchase_price || '');
            $('#item_package_rate').val(item.purchase_price || '');
            $('#package_discount_amount').val(0);
            $('#package_discount_percent').val(0);
        });

        $('#item_package_rate').on('input', function() {
            let itemRate = parseFloat($('#item_rate').val()) || 0;
            let packageRate = parseFloat($(this).val()) || 0;

            if(packageRate > itemRate) {
                packageRate = itemRate;
                $(this).val(packageRate);
            }

            let discountAmount = itemRate - packageRate;
            $('#package_discount_amount').val(discountAmount.toFixed(2));

            let discountPercent = itemRate > 0 ? (discountAmount / itemRate * 100) : 0;
            $('#package_discount_percent').val(discountPercent.toFixed(2));

        });

    });
    function addPackageItem() {
        let itemId = $('#item_id_hidden').val();
        let itemName = $('#item_name').val();
        let itemType = $('#item_type').val();
        let itemQty = $('#item_qty').val();
        let itemRate = $('#item_rate').val();
        let itemPackageRate = $('#item_package_rate').val();
        let itemDiscountPercent = $('#package_discount_percent').val();
        let itemDiscountAmount = $('#package_discount_amount').val();

        if (!itemName || !itemQty) {
            alert('Please fill Item Name and Item Quantity');
            return;
        }
        //row
        let rowHtml = `
            <div class="add-package-item row align-items-center mb-1">
                <input type="hidden" class="item_no_pk" value="${itemId}" />
                <div class="col-md-2"><input type="text" class="form-control form-control-sm item_name" value="${itemName}" readonly></div>
                <div class="col-md-1"><input type="text" class="form-control form-control-sm item_type" value="${itemType}" readonly></div>
                <div class="col-md-1"><input type="text" class="form-control form-control-sm item_qty" value="${itemQty}" readonly></div>
                <div class="col-md-1"><input type="text" class="form-control form-control-sm item_rate" value="${itemRate}" readonly></div>
                <div class="col-md-2"><input type="text" class="form-control form-control-sm item_package_rate" value="${itemPackageRate}" readonly></div>
                <div class="col-md-2"><input type="text" class="form-control form-control-sm package_discount_percent" value="${itemDiscountPercent}" readonly></div>
                <div class="col-md-2"><input type="text" class="form-control form-control-sm package_discount_amount" value="${itemDiscountAmount}" readonly></div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-package-item">Delete</button>
                </div>
            </div>
            `;
        $('#added-items-container').append(rowHtml);

        //clear item input filled
       $('#item_name, #item_type, #item_id_hidden, #item_qty, #item_rate, #item_package_rate, #package_discount_percent, #package_discount_amount').val('');
    }

    $(document).on('click', '.remove-package-item', function() {
        $(this).closest('.add-package-item').remove();
    });
    function savePackageItem() {
        var hasError = false;

        if ($('#package_name').val() == '') {
            alert('Package Name required');
            return false;
        }
        // if ($('#bed_category').val() == '0') {
        //     alert('Please Select Bed Category');
        //     return false;
        // }
        if ($('#added-items-container .add-package-item').length == 0) {
            alert('Please add at least one item before saving.');
            return false;
        }

        if (hasError == true) {
            return false;
        }

        let formElement = document.querySelector('#packageForm');
        let formData = new FormData(formElement);

        $('#added-items-container .add-package-item').each(function () {
            let row = $(this);
            formData.append('items[item_no_pk][]', row.find('.item_no_pk').val());
            formData.append('items[item_name][]', row.find('.item_name').val());
            formData.append('items[item_type][]', row.find('.item_type').val());
            formData.append('items[item_qty][]', row.find('.item_qty').val());
            formData.append('items[item_rate][]', row.find('.item_rate').val());
            formData.append('items[item_package_rate][]', row.find('.item_package_rate').val());
            formData.append('items[package_discount_percent][]', row.find('.package_discount_percent').val());
            formData.append('items[package_discount_amount][]', row.find('.package_discount_amount').val());

        });

        if (confirm('Are You Sure You want to Save this Package?')) {
            $.ajax({
                url: "{{ route('v1.ipd-package-store') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI(); 
                },
                success: function(data) {
                    $.unblockUI();

                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title || 'Success');
                    $('.common-modal-notify .modal-body').html(data.msg || 'Package saved successfully.');

                    // Clear form
                    $('#package_name, #package_details, #original_rate, #map_service_item, #package_rate').val('');
                    $('#package_pathology, #package_radiology, #package_medicine, #package_consultation, #package_ot, #package_procedure, #package_food, #package_services, #package_consumable').val('');
                    $('#added-items-container').empty();
                    $('#item_name, #item_type, #item_id_hidden, #item_qty, #item_rate, #item_package_rate, #package_discount_percent, #package_discount_amount').val('');

                    // Redirect after modal is closed
                    $('.common-modal-notify').on('hidden.bs.modal', function () {
                        window.location.href = "{{ route('v1.ipd-package-list') }}";
                    });
                },
                error: function(err) {
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message || 'Something went wrong.');
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }


</script>