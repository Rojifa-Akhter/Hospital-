<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Inventory Item Issue Worklist</h5>
            <small>Store / Inventory Item Issue Worklist</small>
        </div>
        <div class="col-md-4 ">
            {{-- <div class="row text-right">
                <strong class="col-md-2 text-right">Export:</strong>
                <div class="col-md-2 text-right">
                    <form action="{{ route('print_item_issue_worklist') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="print_type" value="pdf">
                        <input type="hidden" name="print_indent" class="print_indent">
                        <input type="hidden" name="print_date_from" class="print_date_from" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="print_date_to" class="print_date_to" value="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-pdf"></i></button>
                    </form>
                </div>
                <div class="col-md-2 text-right">
                    <form action="{{ route('print_item_issue_worklist') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="print_type" value="excel">
                        <input type="hidden" name="print_indent" class="print_indent">
                        <input type="hidden" name="print_date_from" class="print_date_from" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="print_date_to" class="print_date_to" value="{{ date('Y-m-d') }}">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-file-excel"></i></button>
                    </form>
                </div>
            </div> --}}
        </div>
        <div class="col-md-4">
            <div id="top-action">

                <a rel="tab" href="{{ route('inventory_indent_worklist') }}"
                    class="btn btn-outline-primary btn-md float-right"><i class="fa fa-desktop"></i>&nbsp;Indent
                    Worklist
                    (Received by Item)</a>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                </div>
                <div class="card-body border-bottom-3 p-2">
                    <form action="{{ route('pharmacy-issue-worklist-pdf') }}" method="POST" id="inventory-worklist-search"
                        target="_blank">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="col-form-label col-form-label-sm" for="indent_no">Indent No</label>
                                <input type="text" class="form-control form-control-sm m-0" id="indent_no"
                                    name="indent_no" value="" placeholder="Indent No">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="col-form-label col-form-label-sm" for="indent_date_from">Indent
                                    Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="indent_date_from" name="indent_date_from" value=""
                                        placeholder="yyyy-mm-dd">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="indent_date_to" name="indent_date_to" value=""
                                        placeholder="yyyy-mm-dd">
                                </div>
                            </div>

							<div class="form-group col-md-2">
								<label class="col-form-label col-form-label-sm" for="store_list">Store
									List</label>
								<select class="form-control select2" id="store_list" name="store_list">
									<option value="">Select Store</option>
									@if (!empty($stores))
										@foreach ($stores as $store)
											@if ($store->hospital_store_ind == 1)
												<option value="{{ $store->su_no_fk }}"
													@if ($store->default_ind == 1) selected @endif>
													{{ $store->serviceunit_name }}</option>
											@endif
										@endforeach
									@endif
								</select>
							</div>

                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button id="search_item_iw" type="button"
                                        onclick="generateSearch( this, 'inventory-worklist-search', '{{ route('inventory_serach_worklist') }}', 'iuw' )"
                                        class="btn btn-success  btn-md mt-4"><i class="fa fa-search"></i>
                                        Search
                                    </button>
                                    <a href="{{ route('inventory_item_issue_worklist') }}" rel="tab"
                                        class="btn btn-info  btn-md mt-4"><i class="fa fa-redo"></i> Reset</a>
                                    <button type="submit" class="btn btn-md btn-outline-primary bg-none mt-4"
                                        data-print="STOREPDF"><i class="fa fa-file-pdf"></i>&nbsp; Export PDF</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card" id="iuw">
                <div class="card-header">
                    <h5><i class="fa fa-list"></i> Item List</h5>
                    <ul class="list-inline text-right m-0">
                        <li class="ml-auto bg-none">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="pending" name="deli_status"
                                    value="Pending">
                                <label class="custom-control-label" for="pending">Pending</label>
                            </div>
                            {{-- <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="pertial_received"
                                       name="deli_status" value="Received">
                                <label class="custom-control-label" for="pertial_received">Partial Received</label>
                            </div>
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="received" name="deli_status"
                                       value="Received">
                                <label class="custom-control-label" for="received">Received</label>
                            </div> --}}
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="issued" name="deli_status"
                                    value="Issued">
                                <label class="custom-control-label" for="issued">Issued</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table data-table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center" width="6%">SL</th>
                                        <th class="text-center" width="6%">Indent No</th>
                                        <th class="text-center" width="8%">Indent Date</th>
                                        <th class="text-center" width="8%">Indent By</th>
                                        <th class="text-center" width="12%">Store Name</th>
                                        <th class="text-center" width="9%">PVMS No</th>
                                        <th class="text-center" width="11%">Item Name</th>
                                        <th class="text-center" width="">Stock</th>
                                        <th class="text-center" width="6%">Indent Qty</th>
                                        <th class="text-center" width="6%">Prev Issued Qty</th>
                                        <th class="text-center" width="6%">Issued Qty</th>
                                        <th class="text-center" width="6%">Received Qty</th>
                                        <th class="text-center" width="8%">Status</th>
                                        <th class="text-center" width="14%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (!empty($issue_work_list))

                                        @foreach ($issue_work_list as $indent_no => $iwls)
                                            @php $loopOne = $loop; @endphp
                                            @foreach ($iwls as $iwl)
                                                {{-- @php
                                                $badgeStatus = '';
                                                switch($iwl->issue_ind){
                                                // case "Partial Received":
                                                // $badgeStatus = 'badge-primary';
                                                // break;
                                                case "1":
                                                $badgeStatus = 'badge-success';
                                                break;
                                               // case "Closed":
                                                // $badgeStatus = 'badge-danger';
                                                // break;
                                                default:
                                                $badgeStatus = 'badge-warning';
                                                }

                                            @endphp --}}
                                                <form action="">
                                                    <tr
                                                        @if ($loopOne->even) style="background-color: floralwhite" @endif>
                                                        <td class="text-left"
                                                            @if (!$loop->last) style="border-bottom: none" @endif>
                                                            @if ($loop->iteration == 1)
                                                                {{ $loopOne->iteration }}
                                                            @endif
                                                        </td>

                                                        <td class="text-left"
                                                            @if (!$loop->last) style="border-bottom: none" @endif>
                                                            @if ($loop->iteration == 1)
                                                                {{ $iwl->inv_requisition_uid ?: 'N/A' }}
                                                            @else
                                                                <span
                                                                    style="visibility: hidden">{{ $iwl->inv_requisition_uid ?: 'N/A' }}</span>
                                                            @endif
                                                        </td>

                                                        <td class="text-left">
                                                            {{ !empty($iwl->inv_requisition_date) ? date('Y-m-d', strtotime($iwl->inv_requisition_date)) : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $iwl->req_by_name ? $iwl->req_by_name : 'N/A' }}</td>
                                                        <td class="text-left">
                                                            {{ $iwl->to_store_name ? $iwl->to_store_name : 'N/A' }}</td>
                                                        <td class="text-left">{{ $iwl->pvmsno ? $iwl->pvmsno : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $iwl->item_name ? $iwl->item_name : 'N/A' }}</td>
                                                        <td class="text-center">
                                                            {{ $iwl->balance_qty ? $iwl->balance_qty : 0 }}</td>
                                                        <td class="text-right">
                                                            {{ $iwl->req_quantity ? $iwl->req_quantity : 0 }}</td>
                                                        <td class="text-right">
                                                            {{ $iwl->issue_quantity ? $iwl->issue_quantity : 0 }}</td>
                                                        <td class="text-right">
                                                            <input style="width: 100px" class="text-right number_only"
                                                                type="text"
                                                                value="{{ $iwl->req_quantity - $iwl->issue_quantity ? $iwl->req_quantity - $iwl->issue_quantity : 0 }}">
                                                        </td>

                                                        <td class="text-right">
                                                            {{ $iwl->recv_quantity ? $iwl->recv_quantity : 0 }}</td>

                                                        <td class="text-right">
                                                            @if ($iwl->issue_ind)
                                                                <span class="badge badge-success">Issued</span>
                                                            @else
                                                                <span class="badge badge-warning">Pending</span>
                                                            @endif

                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" title="issue item"
                                                                data-in_transref_no="{{ $iwl->inv_requisition_no_fk }}"
                                                                data-in_transref_date="{{ $iwl->inv_requisition_date }}"
                                                                data-in_stock_su_no_fk="{{ $iwl->to_store_no_fk }}"
                                                                data-from_store_no_fk="{{ $iwl->from_store_no_fk }}"
                                                                data-indentqty="{{ $iwl->req_quantity - $iwl->issue_quantity }}"
                                                                data-pk="{{ $iwl->inv_requisitiondtl_no_pk }}"
                                                                data-in_item_no_fk="{{ $iwl->item_no_fk }}"
                                                                data-prev_issue_qty="{{ $iwl->issue_quantity }}"
                                                                data-indent_qty="{{ $iwl->req_quantity }}"
                                                                class="btn btn-sm btn-info issue-btn"> Issue
                                                            </button>

                                                        </td>

                                                    </tr>
                                                </form>
                                            @endforeach
                                        @endforeach
                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
                    return this.value;
                }).get();


                if (offices.length === 0) {
                    return true;
                }


                if (offices.indexOf(searchData[12]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });

        $(document).on('click', '#search_item_iw', function(e) {
            e.preventDefault()

            $('.print_indent').val($('#indent_no').val())
            $('.print_date_from').val($('#indent_date_from').val())
            $('.print_date_to').val($('#indent_date_to').val())

        })
    });
    $(document).on('click', '.issue-btn', function(e) {
        e.preventDefault()

        var response_action = 'inventory_item_issue_worklist';
        var elem = $(this).closest('tr').find('input.number_only')[0];
        var issued_qty = parseInt($(elem).val());
        var indent_qty = parseInt($(this).attr('data-indentqty'));
        var pk = $(this).attr('data-pk');
        var transfer_no = $(this).attr('data-in_transref_no');
        var transfer_date = $(this).attr('data-in_transref_date');
        var stock_store = $(this).attr('data-in_stock_su_no_fk');
        var item_no_fk = $(this).attr('data-in_item_no_fk');
        var prev_issue_qty = $(this).attr('data-prev_issue_qty');
        var prev_req_qty = $(this).attr('data-indent_qty');
        var from_store_fk = $(this).attr('data-from_store_no_fk');

        if (prev_issue_qty == prev_req_qty) {
            alert('Issue quantity is not available.');
            e.stopImmediatePropagation()
            return false;
        }
        /* if (issued_qty > indent_qty) {
            alert('Issue quantity cannot be greater than Indent Quantity.');
            e.stopImmediatePropagation()
            return false;
        } */
        if (issued_qty <= 0) {
            alert('Issue quantity cannot be zero or negative.');
            e.stopImmediatePropagation()
            return false;
        }
        if (!confirm("Are you sure?")) {
            e.stopImmediatePropagation()
            return false
        }

        var data = {
            issued_quantity: $(elem).val(),
            pk: pk,
            in_transref_no: transfer_no,
            in_transref_date: transfer_date,
            in_stock_su_no_fk: stock_store,
            in_item_no_fk: item_no_fk,
            from_store_fk: from_store_fk
        }

        $.ajax({
            async: true,
            data: data,
            url: "{{ route('update_item_issue') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                }
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                        messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();
    });
</script>
