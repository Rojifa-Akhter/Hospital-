<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<style type="text/css">
    .table td,
    .table th {
        vertical-align: top;
    }
</style>
<div class="container-fluid">
    @php
        //dd($indents);
    @endphp
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Return Item Indent Worklist</h5>
            <small>Pharmacy / Return Item Indent Worklist</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">
                <a rel="tab" href="{{ route('new_indent') }}" class="btn btn-outline-primary btn-md float-right"><i
                        class="fa fa-plus"></i>&nbsp;New Indent</a>

            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="indent-work-list-tab" data-toggle="tab"
                        href="#indent-work-list" role="tab" aria-controls="indent-work-list"
                        aria-selected="false">Return Item Indent Work List</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab" id="item-wise-indent-tab" data-toggle="tab" href="#item-wise-indent"
                        role="tab" aria-controls="item-wise-indent" aria-selected="false">Received by Item</a>
                </li>
                <li class="ml-auto bg-none">
                    {{-- <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="pending" name="deli_status"
                            value="Pending">
                        <label class="custom-control-label" for="pending">Pending</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="received" name="deli_status"
                            value="Received">
                        <label class="custom-control-label" for="received">Received</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="closed" name="deli_status"
                            value="Closed">
                        <label class="custom-control-label" for="closed">Closed</label>
                    </div> --}}
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="indent-work-list" role="tabpanel"
                    aria-labelledby="indent-work-list-tab">

                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form method="POST" action="{{ route('pharmacy_search_indent') }}"
                                        id="indent-search">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm" for="indent_no">Indent
                                                    No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="indent_no" name="indent_no" value="" placeholder="Indent No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="indent_date_from">Indent Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_from" name="indent_date_from" value=""
                                                        placeholder="yyyy-mm-dd">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_to" name="indent_date_to" value=""
                                                        placeholder="yyyy-mm-dd">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                                        onclick="generateSearch( this, 'indent-search', '{{ route('pharmacy_search_indent') }}', 'indent-list' )">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card" id="indent-list">
                                <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table datatable table-striped table-bordered table-hover">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">
                                                            SL
                                                        </th>
                                                        <th class="text-center">Indent No</th>
                                                        <th class="text-center">Indent Date</th>
                                                        <th class="text-center">Indent By</th>
                                                        <th class="text-left">Indent Reason</th>
                                                        <th class="text-left">From Store Name</th>
                                                        <th class="text-left">To Store Name</th>
                                                        <th class="text-center">No of Indent Item</th>
                                                        <th class="text-center">No of Received Item</th>
                                                        {{-- <th class="text-center">Verified Status</th> --}}
                                                        {{-- <th class="text-center">Status</th> --}}
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse($indents as $indent)
                                                        @php
                                                            $badgeStatus = '';
                                                            switch ($indent->req_ind_text) {
                                                                case 'Partial Received':
                                                                    $badgeStatus = 'badge-primary';
                                                                    break;
                                                                case 'Received':
                                                                    $badgeStatus = 'badge-success';
                                                                    break;
                                                                case 'Closed':
                                                                    $badgeStatus = 'badge-danger';
                                                                    break;
                                                                default:
                                                                    $badgeStatus = 'badge-warning';
                                                            }

                                                            $indent_items = \DB::table('phr_requisition_item_vw')->where('inv_requisition_no_fk',$indent->inv_requisition_uid)->get();
                                                            //dd($indent_items);
                                                            $total_hod_approval = $indent_items->where('aproval_hod_ind',1)->count();
                                                            $total_hod_reject = $indent_items->where('aproval_hod_ind',2)->count();
                                                            $total_admin_approval = $indent_items->where('aproval_diradm_ind',1)->count();
                                                            $total_admin_reject = $indent_items->where('aproval_diradm_ind',2)->count();
                                                            $total_director_approval = $indent_items->where('aproval_dirhospital_ind',1)->count();
                                                            $total_director_reject = $indent_items->where('aproval_dirhospital_ind',2)->count();
                                                            $total_chairman_approval = $indent_items->where('aproval_md_chairman_ind',1)->count();
                                                            $total_chairman_reject = $indent_items->where('aproval_md_chairman_ind',2)->count();




                                                        @endphp
                                                        <tr>
                                                            <td class="text-center" width="5%">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td class="text-center" width="5%">
                                                                {{ $indent->inv_requisition_uid }}</td>
                                                            <td class="text-left" width="11%">
                                                                {{ isset($indent->inv_requisition_date) ? date('Y-m-d', strtotime($indent->inv_requisition_date)) : '' }}
                                                            </td>
                                                            <td class="text-left" width="13%">
                                                                {{ $indent->req_by_name }}
                                                            </td>
                                                             <td class="text-left" width="13%">
                                                                {{ $indent->return_reason_name }}
                                                            </td>
                                                            <td class="text-left" width="13%">
                                                                {{ $indent->from_store_name }}
                                                            </td>
                                                            <td class="text-left" width="13%">
                                                                {{ $indent->to_store_name }}
                                                            </td>
                                                            <td class="text-right" width="11%">
                                                                {{ $indent->no_of_item }}
                                                            </td>
                                                            <td class="text-right" width="11%">
                                                                {{ $indent->no_of_received_item }}</td>
                                                            {{-- <td class="text-right" width="16%">


                                                                         <strong>HOD</strong> Approved&nbsp;<span class="badge badge-success">{{ $total_hod_approval }}</span>
                                                                          Rejected&nbsp;<span class="badge badge-danger">{{ $total_hod_reject }}</span>
                                                                          <br>
                                                                         <strong>Admin</strong> Approved&nbsp;<span class="badge badge-success">{{ $total_admin_approval }}</span>
                                                                         Rejected&nbsp;<span class="badge badge-danger">{{ $total_admin_reject }}</span>
                                                                         <br>
                                                                         <strong>Director</strong> Approved&nbsp;<span class="badge badge-success">{{ $total_director_approval }}</span>
                                                                         Rejected&nbsp;<span class="badge badge-danger">{{ $total_director_reject }}</span>
                                                                         <br>
                                                                         <strong>Chairman</strong> Approved&nbsp;<span class="badge badge-success">{{ $total_chairman_approval }}</span>
                                                                         Rejected&nbsp;<span class="badge badge-danger">{{ $total_chairman_reject }}</span>








                                                                </td> --}}
                                                            {{-- <td class="text-center" width="11%">
                                                                <span
                                                                    class="badge {{ $badgeStatus }}">{{ $indent->req_ind_text }}</span>
                                                            </td> --}}
                                                            <td class="text-center" width="11%">
                                                                <span Class="btn btn-sm btn-success open-modal"
                                                                data-action="{{ route('return_indent_item_details', $indent->inv_requisition_uid) }}" data-modal="common-modal-md" data-title="Indent Return Item Details" title="view"><i class="fa fa-eye"></i></span>

                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="item-wise-indent" role="tabpanel"
                    aria-labelledby="item-wise-indent-tab">
                    {{-- <div class="row">
                        <div class="col-12 px-0">
                            <div class="custom-card-header">
                                <ul class="list-inline text-right">
                                    <li class="list-inline-item"><i class="fa fa-exclamation-triangle"></i> &nbsp;&nbsp;
                                        <b>Pending</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-warning">{{ count($indent_item_pending) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-clipboard-check"></i> &nbsp;&nbsp;
                                        <b>Received</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-success">{{ count($indent_item_received) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-times-circle"></i> &nbsp;&nbsp;
                                        <b>Closed</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-danger">{{ count($indent_item_closed) }}</span></li>
                                    <li class="list-inline-item"><a rel="tab" href="{{ route('new_indent') }}"
                                            class="btn btn-success btn-md ml-auto mb-1 mt-1"> <i class="fas fa-plus">
                                            </i>&nbsp;&nbsp;New Indent</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="{{ route('pharmacy_search_indent_item') }}" method="POST"
                                        id="indent-item-search">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="indent_no">Indent
                                                    No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="indent_no" name="indent_no" value="" placeholder="Indent No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="indent_date_from">Indent Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_from" name="indent_date_from" value=""
                                                        placeholder="yyyy-mm-dd">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_to" name="indent_date_to" value=""
                                                        placeholder="yyyy-mm-dd">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label class="col-form-label col-form-label-sm" for="store_list">Store
                                                    List</label>
                                                <select class="form-control select2" id="store_list" name="store_list">
                                                    <option value="">Select Store</option>
                                                    @if (!empty($stores))
                                                        @foreach ($stores as $store)
                                                            @if ($store->pharmacy_ind == 1)
                                                                <option value="{{ $store->su_no_fk }}"
                                                                    @if ($store->default_ind == 1) selected @endif>
                                                                    {{ $store->serviceunit_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-success btn-block btn-md mt-4"
                                                        onclick="generateSearch( this, 'indent-item-search', '{{ route('pharmacy_search_indent_item') }}', 'indent-item-list' )"><i
                                                            class="fa fa-search"></i> Search</button>
                                                    <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                             <div class="card" id="indent-item-list">
                              <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table datatable  table-bordered ">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center">
                                                            SL

                                                        </th>
                                                        <th class="text-center">Indent No</th>
                                                        <th class="text-center">Indent Date</th>
                                                        <th class="text-center">Indent By</th>
                                                        <th class="text-center">Store Name</th>
                                                        <th class="text-center">PVMS No</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Stock</th>
                                                        <th class="text-center">Indent Qty</th>
                                                        <th class="text-center">Issued Qty</th>
                                                        <th class="text-center">Prev. Receive</th>
                                                        <th class="text-center">Received Qty</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @if (!empty($indent_items_search))
                                                        @foreach ($indent_items_search as $indent_no => $iis)

                                                        @dd('test');
                                                            @php $loopOne = $loop;
                                                            @endphp
                                                            @foreach ($iis as $indent_item)
                                                                @php
                                                                    $badgeStatus = '';
                                                                    switch ($indent_item->req_ind_text) {
                                                                        case 'Partial Received':
                                                                            $badgeStatus = 'badge-primary';
                                                                            break;
                                                                        case 'Received':
                                                                            $badgeStatus = 'badge-success';
                                                                            break;
                                                                        case 'Closed':
                                                                            $badgeStatus = 'badge-danger';
                                                                            break;
                                                                        default:
                                                                            $badgeStatus = 'badge-warning';
                                                                    }

                                                                @endphp
                                                                <tr
                                                                    @if ($loopOne->even) style="background-color: floralwhite" @endif>
                                                                    <td width="6%" class="text-left"
                                                                        @if (!$loop->last) style="border-bottom: none" @endif>
                                                                        @if ($loop->iteration == 1)
                                                                            {{ $loopOne->iteration }}
                                                                        @endif
                                                                    </td>
                                                                    <td width="6%" class="text-center"
                                                                        @if (!$loop->last) style="border-bottom: none" @endif>
                                                                        @if ($loop->iteration == 1)
                                                                            {{ $indent_item->inv_requisition_uid }}
                                                                        @else
                                                                            <span
                                                                                style="visibility: hidden">{{ $indent_item->inv_requisition_uid }}</span>
                                                                        @endif

                                                                    </td>
                                                                    <td class="text-left" width="9%">
                                                                        {{ isset($indent_item->inv_requisition_date) ? date('d-m-yy', strtotime($indent_item->inv_requisition_date)) : '' }}
                                                                    </td>
                                                                    <td class="text-left" width="10%">
                                                                        {{ $indent_item->req_by_name }}
                                                                    </td>
                                                                    <td class="text-left" width="7%">
                                                                        {{ $indent_item->from_store_name }}
                                                                    </td>
                                                                    <td class="text-left" width="5%">
                                                                        {{ $indent_item->pvmsno }}</td>
                                                                    <td class="text-left" width="12%">
                                                                        {{ $indent_item->item_name }}</td>
                                                                    <td class="text-right" width="%">
                                                                        {{ $indent_item->balance_qty ?: 0 }}</td>
                                                                    <td class="text-right" width="5%">
                                                                        {{ $indent_item->req_quantity }}
                                                                    </td>
                                                                    <td class="text-right" width="5%">
                                                                        {{ $indent_item->issue_quantity }}
                                                                    </td>
                                                                    <td class="text-right" width="5%">
                                                                        {{ $indent_item->recv_quantity }}
                                                                    </td>
                                                                    <td class="text-right" width="5%">
                                                                        <input style="width:100%;"
                                                                            class="text-right number_only"
                                                                            name="item_quantities[]"
                                                                            type="text number_only" readonly
                                                                            value="{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}"
                                                                            readonly>

                                                                    </td>
                                                                    <td width="8%" class="text-center">
                                                                        <span
                                                                            class="badge {{ $badgeStatus }}">{{ $indent_item->req_ind_text }}</span>
                                                                    </td>

                                                                    <td width="10%" class="text-center">
                                                                        @if ($indent_item->expireable == 1)
                                                                            @php
                                                                                $rem = $indent_item->issue_quantity - $indent_item->recv_quantity;
                                                                                $item_details = $indent_item->item_no_fk . '_' . $rem . '_' . $indent_item->to_store_no_fk . '_' . $indent_item->inv_requisition_uid . '_' . $indent_item->from_store_no_fk;
                                                                            @endphp
                                                                            <span Class="btn btn-sm btn-info open-modal"
                                                                                data-modal="common-modal-sm" data-id=""
                                                                                data-action="{{ route('show_indent_item_receive_pop_up', $item_details) }}"
                                                                                data-title="Batch No"
                                                                                id="">Receive</span>
                                                                        @else
                                                                            <button type="button" title="receive item"
                                                                                data-in_transref_no="{{ $indent_item->inv_requisition_no_pk }}"
                                                                                data-in_transref_date="{{ $indent_item->inv_requisition_date }}"
                                                                                data-rcv="{{ $indent_item->recv_quantity }}"
                                                                                data-in_stock_su_no_fk_from="{{ $indent_item->from_store_no_fk }}"
                                                                                data-in_stock_su_no_fk="{{ $indent_item->to_store_no_fk }}"
                                                                                data-in_item_no_fk="{{ $indent_item->item_no_fk }}"
                                                                                data-issued="{{ $indent_item->issue_quantity }}"
                                                                                data-indentqty="{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}"
                                                                                data-pk="{{ $indent_item->inv_requisition_no_pk }}"
                                                                                class="btn btn-sm btn-info receive-btn">
                                                                                Receive
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
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
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
                    return this.value;
                }).get();


                if (offices.length === 0) {
                    return true;
                }
                var tblindex = $('#tab_name').val()

                if (offices.indexOf(searchData[tblindex]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        var table = $('.datatable').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });
        $(document).on('click', '.page-tab', function(e) {
            e.preventDefault()

            if ($(this).attr('id') == 'indent-work-list-tab') {
                $('#tab_name').val(7)
            }
            if ($(this).attr('id') == 'item-wise-indent-tab') {
                $('#tab_name').val(12)
            }
            table.draw();
        })

        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $(document).on('click', '.receive-btn', function(e) {
            e.preventDefault()
            // alert(1);
            var response_action = "{{ route('pharmacy_indent_worklist') }}"
            var elem = $(this).closest('tr').find('input.number_only')[0]
            var receive_qty = parseInt($(elem).val())
            var max_limit = parseInt($(this).attr('data-indentqty'))
            var pk = $(this).attr('data-pk')
            var rcv_qty = $(this).attr('data-rcv')
            var issued_qty = $(this).attr('data-issued')

            var transfer_no = $(this).attr('data-in_transref_no');
            var transfer_date = $(this).attr('data-in_transref_date');
            var stock_store_to = $(this).attr('data-in_stock_su_no_fk');
            var stock_store_from = $(this).attr('data-in_stock_su_no_fk_from');
            var item_no_fk = $(this).attr('data-in_item_no_fk');

            if (isNaN(receive_qty)) {
                alert('Receive quantity is required.');
                e.stopImmediatePropagation()
                return false;
            }
            if (rcv_qty == issued_qty) {
                alert('Issue quantity is not available.');
                e.stopImmediatePropagation()
                return false;
            }
            if (receive_qty > max_limit) {
                alert('Receive quantity cannot be greater than Issue Quantity. \n Receive Balance is ' +
                    max_limit);
                e.stopImmediatePropagation()
                return false;
            }
            if (receive_qty <= 0) {
                alert('Receive quantity cannot be or zero or negative');
                e.stopImmediatePropagation()
                return false;
            }
            if (!confirm("Are you sure?")) {
                return false
            }
            var data = {
                received_quantity: $(elem).val(),
                pk: pk,
                in_transref_no: transfer_no,
                in_transref_date: transfer_date,
                in_stock_su_no_fk_to: stock_store_to,
                in_stock_su_no_fk_from: stock_store_from,
                in_item_no_fk: item_no_fk
            }

            $.ajax({
                async: true,
                data: data,
                url: "{{ route('update_indent') }}",
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
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
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
        })
    })
</script>
