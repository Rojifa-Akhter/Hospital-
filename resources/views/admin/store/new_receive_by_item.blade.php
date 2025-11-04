<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-9">
			<h5 class="mt-2 mb-0">New Item Receive</h5>
			<small>Store / New Item Receive</small>
		</div>
        <div class="col-md-3">
            <div id="top-action">

                <a  rel="tab" href="{{ route('item_receive_by_item') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Item Recieve List</a>

            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header"><h5><i class="fa fa-plus"></i> New Receive by Item </h5></div>
				<div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('store_new_item_receive') }}" id="item_receive_form" method="post">
                        <input type="hidden" name="receive_type" value="item">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label class="col-form-label col-form-label-sm" for="fiscal_year">Fiscal Year <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="fiscal_year" name="fiscal_year">
                                <option value="">Select Year</option>
                                @if(!empty($search_fiscal_year))
                                    @foreach($search_fiscal_year as $key => $sfy)
                                        <option value="{{ $key }}">{{ $sfy['data'] }}</option>
                                    @endforeach
                                @endif
                            </select>
						</div>

						<div class="form-group col-md-2">
							<label class="col-form-label col-form-label-sm" for="quarter">Quarter <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="quarter" name="quarter">
                                <option value="">Select Quarter</option>
                                @if(!empty($search_quarter))
                                    @foreach($search_quarter as $key => $sq)
                                        <option value="{{ $key }}">{{ $sq['data'] }}</option>
                                    @endforeach
                                @endif
                            </select>
						</div>

                        <div class="form-group col-md-2">
                            <label class="col-form-label col-form-label-sm" for="store_id">Store <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="store_id" name="store_id">
                                <option value="">Select Store</option>
                                @if(!empty($stores))
                                    @foreach($stores as $store)
                                        @if($store->med_store_ind == 1)
                                            <option value="{{ $store->su_no_fk }}"
                                                    @if($store->default_ind == 1)
                                                    selected
                                                    @endif
                                                    >{{ $store->su_name }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                        </div>

						<div class="form-group col-md-2">
							<label class="col-form-label col-form-label-sm" for="challan_no">Challan No</label>
							<input type="text" class="form-control form-control-sm m-0" id="challan_no" name="challan_no" value="" placeholder="Challan No" >
						</div>

						<div class="form-group col-md-2">
							<label class="col-form-label col-form-label-sm" for="date">Date</label>
							<input type="text" class="form-control form-control-sm m-0 date_picker" id="date" name="date" value="" placeholder="yyyy-mm-dd" >
						</div>



						<div class="form-group col-md-2">
							<label class="col-form-label col-form-label-sm" for="demand_id">Demand No</label>
							<select class="form-control select2" id="demand_id" name="demand_id">
								<option value="">Select Demand No</option>
								@if(!empty($demands))
                                    @foreach($demands as $demand)
                                        <option value="{{ $demand->demand_no_pk }}">{{ $demand->demand_uid  }} ({{ $demand->fiscal_year }})</option>
                                    @endforeach
                                @endif
							</select>
						</div>


					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="col-form-label col-form-label-sm" for="pvms_no">PVMS No</label>
									<input type="text" class="form-control form-control-sm m-0" id="pvms_no" name="pvms_no" value="" placeholder="PVMS No" >
								</div>

								<div class="form-group col-md-2">
									<label class="col-form-label col-form-label-sm" for="item_name">Item Name</label>
                                    <input type="hidden" name="item_id_hidden" id="item_id_hidden">
									<input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name" value="" placeholder="Item Name" >
								</div>

                                <div class="form-group col-md-2">
									<label class="col-form-label col-form-label-sm" for="item_uom">Item UOM</label>
                                    <input type="hidden" name="item_uom_hidden" id="item_uom_hidden">
									<input type="text" class="form-control form-control-sm m-0" id="item_uom" name="item_uom" value="" placeholder="Item UOM">
								</div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm " for="item_price">Item Price</label>
                                    <input type="text" class="form-control form-control-sm m-0  number_only text-right" id="item_price" name="item_price" value="0" placeholder="Item Price">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="item_quantity">Item Quantity</label>
                                    <input type="text" class="form-control form-control-sm m-0 number_only text-right" id="item_quantity" name="item_quantity" value="0" placeholder="Item Quantity">
                                </div>





								<div class="form-group col-md-2">
									<button type="button" id="add_item_btn" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-plus"></i> Add Item</button>
								</div>
							</div>

						</div>
					</div>


                    <div class="row">
                        <div class="col-12 table-responsive" >

                            <table class="table data-table table-striped table-bordered table-hover">
                                <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">SL</th>
                                    <th class="text-center">PVMS No</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Item UOM</th>
                                    <th class="text-center">Item Price</th>
                                    <th class="text-center">Received Quantity</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>

                                <tbody id="items_to_receive">

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        @php
                            $response_action = route('item_receive_by_item');
                        @endphp
                        <div class="col-12 text-right">
                            <button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"  class="btn btn-success btn-md"><i class="fa fa-save"></i> Save</button>
                            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                        </div>

                    </div>
                    </form>

				</div>
			</div>
		</div>
	</div>

</div>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function (item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();

        });
        openReceiveItemAutocomplete('#item_name', 'item_name', function (item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        $(document).on('click', '#add_item_btn', function (e) {
            e.preventDefault()
            var pvms_no = $('#pvms_no').val();
            var item_name = $('#item_name').val();
            var item_id = $('#item_id_hidden').val();
            var item_uom_name = $('#item_uom').val();
            var item_uom_no = $('#item_uom_hidden').val();
            var item_quantity = $('#item_quantity').val();
            var item_price = $('#item_price').val();

            if (item_id == '' || item_name == '') {
                alert('Item name cannot be blank.')
                return false
                e.stopImmediatePropagation();
            }
            var same_item = false
            $('input[class=same-item-id]').each(function (index, elem) {
                if ($(elem).val() == item_id) {
                    same_item = true
                    return false
                }
            })
            if (same_item == true) {
                alert('You have already taken this item.')
                $('#pvms_no').val('');
                $('#item_name').val('');
                $('#item_id_hidden').val('');
                $('#item_uom').val('');
                $('#item_uom_hidden').val('');
                $('#item_quantity').val(0);
                $('#item_price').val(0);
                e.stopImmediatePropagation();
                return false
            }
            var row = '<tr>' +
                    '<td class="sl-td">0</td>'+
                    '<td> <input type="hidden"  name="pvms_nos[]" value="'+ pvms_no +'">'+ pvms_no +'</td>'+
                    '<td> <input type="hidden" class="same-item-id" name="item_ids[]" value="'+ item_id +'">'+ item_name +'</td>'+
                    '<td> <input type="hidden" name="item_uoms[]" value="'+ item_uom_no +'">'+ item_uom_name +'</td>'+
                    '<td class="text-right"> <input type="hidden"  name="item_prices[]" value="'+ item_price +'">'+ item_price +'</td>'+
                    '<td class="text-right"> <input type="hidden"   name="item_quantities[]" value="'+ item_quantity +'">'+ item_quantity +'</td>'+
                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>'+
                    '</tr>';

            $('#items_to_receive').append(row);

            $('#pvms_no').val('');
            $('#item_name').val('');
            $('#item_id_hidden').val('');
            $('#item_uom').val('');
            $('#item_uom_hidden').val('');
            $('#item_quantity').val(0);
            $('#item_price').val(0);

            $('.sl-td').each(function (index, elem) {
                $(elem).text(index + 1);
            });

            e.stopImmediatePropagation();

        })

        $(document).on('click', '.remove-item-btn', function (e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            $('.sl-td').each(function (index, elem) {
                $(elem).text(index + 1);
            })
            e.stopImmediatePropagation();
        })

        /*$(document).on('change', '.min-zero', function (e) {
            e.preventDefault()
            if ($(this).val() < 0) {
                $(this).val(0)
            }
            e.stopImmediatePropagation();
        })*/

        $(document).on('change', '#demand_id', function (e) {
            e.preventDefault()
            $.ajax({
                async: true,
                data: { demand_pk: $(this).val()},
                url: "{{ route('get_demand_items') }}",
                type: 'post',
                beforeSend:function(){
                    if(isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function (data) {
                    var rows = ''
                    if (data.length > 0) {
                        var rows = ''
                        var same_item = ''
                        data.forEach(function (iteminfo) {
                            $('input[class=same-item-id]').each(function (index, elm) {
                                if ($(elm).val() == iteminfo.item_no_fk) {
                                    same_item = iteminfo.item_no_fk
                                }
                            })
                            if (same_item != iteminfo.item_no_fk) {
                                rows += '<tr>' +
                                        '<td class="sl-td">0</td>'+
                                        '<td> <input type="hidden" name="pvms_nos[]" value="'+ iteminfo.pvms_no +'">'+ iteminfo.pvms_no +'</td>'+
                                        '<td> <input type="hidden" class="same-item-id" name="item_ids[]" value="'+ iteminfo.item_no_fk +'">'+ iteminfo.item_name +'</td>'+
                                        '<td> <input type="hidden" name="item_uoms[]" value="'+ iteminfo.uom +'">'+ iteminfo.uom_text +'</td>'+
                                        '<td class="text-right"> <input type="hidden"  name="item_prices[]" value="'+ iteminfo.item_rate +'">'+ iteminfo.item_rate +'</td>'+
                                        '<td class="text-right"> <input type="hidden"   name="item_quantities[]" value="'+ iteminfo.entry_qty +'">'+ iteminfo.entry_qty +'</td>'+
                                        '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>'+
                                        '</tr>'
                            }

                        })

                        $('#items_to_receive').append(rows);
                        $('.sl-td').each(function (index, elem) {
                            $(elem).text(index + 1)
                        })
                    }else{
                        alert('Sorry !!! No Data is found.')
                    }
                },
                error: function (data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages="";
                    for (messages in errors) {
                        var field_name = $("#"+messages).siblings("label").html();
                        error_messages +=  "<div class='alert alert-danger' role='alert'>"+errors[messages]+"</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function () {
                $.unblockUI();
            });
            e.stopImmediatePropagation();
        })
    })


</script>