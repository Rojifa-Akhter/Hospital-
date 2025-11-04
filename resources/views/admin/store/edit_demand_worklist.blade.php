<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-9">
			<h5 class="mt-2 mb-0">Demand Entry</h5>
			<small>Edit Demand Entry</small>
		</div>
        <div class="col-md-3">
            <div id="top-action">

                <a  rel="tab" href="{{ route('demand_worklist') }}" class="btn btn-outline-primary btn-md float-right" ><i class="fa fa-desktop"></i>&nbsp;Demand Worklist</a>

            </div>
        </div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h5>Demand Entry</h5>
						</div>

						<div class="card-body mt-2">
                            <form action="{{ route('store_demand_items') }}" id="store_demand_items" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="date">Date <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date" name="date"
                                                       value="{{ !empty($demand_items[0]->demand_date)? date('Y-m-d', strtotime($demand_items[0]->demand_date)):'' }}" placeholder="yyyy-mm-dd" >
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="fiscal_year" class="col-form-label col-form-label-sm">Fiscal Year <span class="text-danger">*</span></label>
                                                <select class="form-control select2" id="fiscal_year" name="fiscal_year">
                                                    <option value="">Select Year</option>
                                                    @if(!empty($fiscal_years))
                                                        @foreach($fiscal_years as $key => $fy)
                                                            <option value="{{ $key }}"
                                                                    @if(!empty($demand_items[0]->fiscal_year)
                                                                    && $demand_items[0]->fiscal_year == $key)
                                                                        selected
                                                                    @endif
                                                                    >{{ $fy['data'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label for="item_category" class="col-form-label col-form-label-sm">Item Category <span class="text-danger">*</span></label>
                                                <select class="form-control select2" id="category_id" name="category_id">
                                                    <option value="">Select Category</option>
                                                    @if(!empty($item_categories))
                                                        @foreach($item_categories as $key => $ic)
                                                            <option value="{{ $ic['data'] }}"
                                                                    @if(!empty($demand_items[0]->item_category)
                                                                    && $demand_items[0]->item_category == strtoupper($ic['data']))
                                                                    selected
                                                                    @endif
                                                                    >{{ $ic['data'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <a href="javascript:void(0)" id="default_item" class="btn btn-success btn-block btn-md mt-4 popup-items">Default</a>
                                                    <a href="javascript:void (0)" id="last_year_item" class="btn btn-info btn-block btn-md mt-4 popup-items">Last Year</a>
                                                </div>
                                            </div>
                                        </div>
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
                                                <label class="col-form-label col-form-label-sm" for="item_price">Item Price</label>
                                                <input type="text" class="form-control form-control-sm m-0 text-right number_only" id="item_price" name="item_price" value="0" placeholder="Item Price">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="item_quantity">Item Quantity</label>
                                                <input type="text" class="form-control form-control-sm m-0 text-right number_only" id="item_quantity" name="item_quantity" value="0" placeholder="Item Quantity">
                                            </div>


                                            <div class="form-group col-md-2">
                                                <button type="button" id="add_item_btn" class="btn btn-success btn-block btn-md mt-4"><i class="fa fa-plus"></i> Add Item</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 table-responsive mt-3" >
                                        <table class="table  table-striped table-bordered table-hover">
                                            <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center ">SL</th>
                                                <th class="text-center">PVMS No</th>
                                                <th class="text-center">Item Name</th>
                                                <th class="text-center">UOM</th>
                                                <th class="text-center ">Rate</th>
                                                <th class="text-center ">Item Quantity</th>
                                                <th class="text-center ">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="demand_items">
                                                @if(!empty($demand_items))
                                                    @foreach($demand_items as $di)
                                                        <tr>
                                                            <td class="sl-td">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <input type="hidden" name="pvms_nos[]" value="{{ $di->pvms_no }}">
                                                                {{ $di->pvms_no }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="same-item-id" name="item_ids[]" value="{{ $di->item_no_fk }}">
                                                                {{ $di->item_name }}
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="item_uoms[]" value="{{ $di->uom }}">
                                                                {{ $di->uom_text }}
                                                            </td>
                                                            <td>
                                                                <input class="item-rate number_only text-right" type="text" min="0"  name="item_rates[]" value=" {{ $di->item_rate?: 0 }}">
                                                            </td>
                                                            <td>
                                                                <input class="item-qty number_only text-right" type="text" min="0" name="item_quantities[]" value="{{ $di->entry_qty?: 0 }}">
                                                            </td>
                                                            <td><a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="custom-box">
                                            <div class="custom-box-body m-0 text-right">

                                                @php
                                                $response_action = route('demand_worklist');
                                                @endphp

                                                <button type="submit" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"  class="btn btn-md btn-success">Save</button>

                                                <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
                                                <a href="{{ route('dashboard') }}" class="btn btn-danger btn-md" rel="tab" title="Click here to go back to Dashboard">Exit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>

    $(document).ready(function () {

        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            startDate: new Date()
        });
        $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        /*$('.data-table').DataTable({
            "paging":   false,
            "info":     false
        });*/
        openDemandEntryAutocomplete('#pvms_no','pvms_no', function (item, obj) {
            $('#item_id_hidden').val(item.item_id)
            $('#item_uom_hidden').val(item.uom_no_fk)
            $('#item_uom').val(item.uom_name)
            $('#item_name').val(item.item_name)
            $('#item_quantity').val(item.default_qty)
            $('#item_price').val(item.item_rate)
            obj.stopImmediatePropagation();

        });
        openDemandEntryAutocomplete('#item_name', 'item_name', function (item, obj) {
            $('#item_id_hidden').val(item.item_id)
            $('#item_uom_hidden').val(item.uom_no_fk)
            $('#item_uom').val(item.uom_name)
            $('#pvms_no').val(item.pvms_no)
            $('#item_quantity').val(item.default_qty)
            $('#item_price').val(item.item_rate)
            obj.stopImmediatePropagation();
        });

        $(document).on('click', '#default_item', function (e) {
            e.preventDefault()

            var category_id = $('#category_id').val()
            var id_val = $(this).attr('id')
            if (category_id == "") {
                alert('Please, select category.')
                return false
            }

            var categories = []
            "<?php foreach($item_categories as $ic): ?>"
            categories.push("<?php echo $ic['data']; ?>")
            "<?php endforeach; ?>"

            $.ajax({
                async: true,
                data: {
                    category: $('#category_id').val(),
                    item_categories: categories,
                },
                dataType: "html",
                url: "{{ route('demand_items') }}",
                type: 'post',
                beforeSend:function(){
                    if(isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function (data) {

                    $('.modal-body').html(data)
                    $('#demand_entry_modal').modal('show')
                    $('.data-table').DataTable({
                        "paging":   false,
                        "info":     false
                    });

                },
                complete: function(){
                    $.unblockUI();
//				dynamicFunc.afterSaveLoadPage(response_action);
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
            });
            e.stopImmediatePropagation();

        })

        $(document).on('click', '#last_year_item', function (e) {
            e.preventDefault()
            var category = $('#category_id').val()

            if (category == '') {
                alert('Please, select category.')
                e.stopImmediatePropagation();
                return false
            }

            $.ajax({
                async: true,
                data: {
                    category: category
                },
                dataType: "json",
                url: "{{ route('last_year_demand_items') }}",
                type: 'post',
                beforeSend:function(){
                    if(isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function (data) {
                    var rows = ''
                    if (data.length > 0) {

                        data.forEach(function (iteminfo) {
                            rows += '<tr>' +
                                    '<td class="text-center sl-td">0</td>'+
                                    '<td class="text-center"> <input type="hidden" name="pvms_nos[]" value="'+ iteminfo.pvms_no +'">'+ iteminfo.pvms_no +'</td>'+
                                    '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="'+ iteminfo.item_no_fk +'">'+ iteminfo.item_name +'</td>'+
                                    '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="'+ iteminfo.uom +'">'+ iteminfo.uom_text +'</td>'+
                                    '<td class="text-center"> <input class="item-rate number_only text-right" type="text" min="0"  name="item_rates[]" value="'+ 0 +'"></td>'+
                                    '<td class="text-center"> <input class="item-qty number_only text-right" type="text" min="0" name="item_quantities[]" value="'+ 0 +'"></td>'+
//                '<td class="text-center"> <span class="amount">' + parseInt(item_price)*parseInt(item_quantity) + '</span></td>'+
                                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>'+
                                    '</tr>'
                        })
                        $('#demand_items').append(rows)
                        $('.sl-td').each(function (index, elem) {
                            $(elem).text(index + 1)
                        })
                    }else{
                        alert('Sorry !!! No Data is found.')
                    }
                },
                complete: function(){
                    $.unblockUI();
//				dynamicFunc.afterSaveLoadPage(response_action);
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
            });
            e.stopImmediatePropagation();

        })

        $(document).on('click', '#entry_ready_items', function (e) {
            e.preventDefault()

            var rows = ''
            var same_item = false
            $('.selected-default-item').each(function (index, elem) {
                if ($(elem).is(":checked")) {
                    var iteration = $(elem).attr('data-iteration')
                    var pvms_no = $('#pvms_'+iteration).val()
//                var barcode_no = $('#barcode_'+iteration).val()
                    var item_id = $('#item_id_'+iteration).val()
                    var  item_name = $('#item_name_'+iteration).val()
                    var item_uom_no = $('#uom_no_'+iteration).val()
                    var item_uom_name = $('#uom_name_'+iteration).val()
                    var rate = $('#rate_'+iteration).val()
                    var quantity = $('#qty_'+iteration).val()


                    $('input[class=same-item-id]').each(function (index, elm) {
                        if ($(elm).val() == item_id) {
                            same_item = true
                        }
                    })
                    if (same_item == true) {
                        return false
                    }

                    rows += '<tr>' +
                            '<td class="text-center sl-td">0</td>'+
                            '<td class="text-center"> <input type="hidden" name="pvms_nos[]" value="'+ pvms_no +'">'+ pvms_no +'</td>'+
//                        '<td class="text-center"> <input type="hidden" name="barcodes[]" value="'+ barcode_no +'">'+ barcode_no +'</td>'+
                            '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="'+ item_id +'">'+ item_name +'</td>'+
                            '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="'+ item_uom_no +'">'+ item_uom_name +'</td>'+
                            '<td class="text-center"> <input class="item-rate text-right number_only" min="0" type="text" name="item_rates[]" value="'+ rate +'"></td>'+
                            '<td class="text-center"> <input class="item-qty text-right number_only" min="0" type="text" name="item_quantities[]" value="'+ quantity +'"></td>'+
//                        '<td class="text-center"> <span class="amount">' + parseInt(rate)*parseInt(quantity) + '</span></td>'+
                            '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>'+
                            '</tr>'
                }

            })
            if (same_item == true) {
                alert('You have already taken some of the selected items.' )
                e.stopImmediatePropagation();
                return false
            }
            $('#demand_items').append(rows)
            $('.sl-td').each(function (index, elem) {
                $(elem).text(index + 1)
            })
            $('#demand_entry_modal').modal('hide')

        })

        $(document).on('click', '#add_item_btn', function (e) {
            e.preventDefault()
            var pvms_no = $('#pvms_no').val()
            var item_name = $('#item_name').val()
            var item_id = $('#item_id_hidden').val()
            var item_uom_name = $('#item_uom').val()
            var item_uom_no = $('#item_uom_hidden').val()
            var item_quantity = $('#item_quantity').val()
            var item_price = $('#item_price').val()

            if (item_id == '' || item_name == '') {
                alert('Item name cannot be blank.')
                e.stopImmediatePropagation();
                return false
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
                $('#pvms_no').val('')
                $('#item_name').val('')
                $('#item_id_hidden').val('')
                $('#item_uom').val('')
                $('#item_uom_hidden').val('')
                $('#item_quantity').val(0)
                $('#item_price').val(0)
                e.stopImmediatePropagation();
                return false
            }

            var row = '<tr>' +
                    '<td class="text-center sl-td">0</td>'+
                    '<td class="text-center"> <input type="hidden" name="pvms_nos[]" value="'+ pvms_no +'">'+ pvms_no +'</td>'+
                    '<td class="text-center"> <input type="hidden" class="same-item-id" name="item_ids[]" value="'+ item_id +'">'+ item_name +'</td>'+
                    '<td class="text-center"> <input type="hidden" name="item_uoms[]" value="'+ item_uom_no +'">'+ item_uom_name +'</td>'+
                    '<td class="text-center"> <input class="item-rate text-right number_only" min="0" type="text" name="item_rates[]" value="'+ item_price +'"></td>'+
                    '<td class="text-center"> <input class="item-qty text-right number_only" min="0" type="text" name="item_quantities[]" value="'+ item_quantity +'"></td>'+
//                '<td class="text-center"> <span class="amount">' + parseInt(item_price)*parseInt(item_quantity) + '</span></td>'+
                    '<td> <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-item-btn" title="Remove"><i class="fa fa-times-circle"></i></a></td>'+
                    '</tr>'
            $('#demand_items').append(row)

            $('#pvms_no').val('')
            $('#item_name').val('')
            $('#item_id_hidden').val('')
            $('#item_uom').val('')
            $('#item_uom_hidden').val('')
            $('#item_quantity').val(0)
            $('#item_price').val(0)

            $('.sl-td').each(function (index, elem) {
                $(elem).text(index + 1)
            })
            e.stopImmediatePropagation();
        })

        $(document).on('click', '.remove-item-btn', function () {
            $(this).closest('tr').remove()
            $('.sl-td').each(function (index, elem) {
                $(elem).text(index + 1)
            })
        })

        $(document).on('change', '#item_category_popup', function (e) {
            e.preventDefault()

            $.ajax({
                data: {search_category: true, category: $(this).val()},
                dataType: "html",
                url: "{{ route('demand_items') }}",
                type: "post",
                beforeSend:function(){
                    blockUI();
                },
                success: function (data) {
                    $("#demand_entry_modal #crl").html(data);
                    $('#demand_entry_modal #crl .data-table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });
                },
                complete:function(){
                    $.unblockUI();
                }
            });

            e.stopImmediatePropagation();
        })

        /*$(document).on('change', '.min-zero', function (e) {
            e.preventDefault()
            if ($(this).val() < 0) {
                $(this).val(0)
            }
            e.stopImmediatePropagation();
        })*/


    })










</script>
