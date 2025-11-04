<div class="card-header">
    <h5><i class="fa fa-list"></i> Item List</h5>
    <ul class="list-inline text-right m-0">
        <li class="ml-auto bg-none">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="pending" name="deli_status" value="Pending">
                <label class="custom-control-label" for="pending">Pending</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="pertial_received" name="deli_status" value="Received">
                <label class="custom-control-label" for="pertial_received">Partial Received</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="received" name="deli_status" value="Received">
                <label class="custom-control-label" for="received">Received</label>
            </div>
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" class="custom-control-input" id="closed" name="deli_status" value="Closed">
                <label class="custom-control-label" for="closed">Closed</label>
            </div>
        </li>
    </ul>
</div>
<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive" >
            <table class="table data-table  table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th class="text-center" width="6%">SL</th>
                    <th class="text-center" width="6%">Indent No</th>
                    <th class="text-center" width="8%">Indent Date</th>
                    <th class="text-center" width="8%">Indent By</th>
                    <th class="text-center" width="12%">Pharmacy Name</th>
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
                {{--<tr>

                    <th class="text-center" width="6%">SL</th>
                    <th class="text-center" width="6%">Indent No</th>
                    <th class="text-center" width="8%">Indent Date</th>
                    <th class="text-center" width="8%">Indent By</th>
                    <th class="text-center" width="12%">Pharmacy Name</th>
                    <th class="text-center" width="9%">PVMS No</th>
                    <th class="text-center" width="11%">Item Name</th>
                    <th class="text-center" width="6%">Indent Qty</th>
                    <th class="text-center" width="6%">Prev Issued Qty</th>
                    <th class="text-center" width="6%">Issued Qty</th>
                    <th class="text-center" width="6%">Received Qty</th>
                    <th class="text-center" width="8%">Status</th>
                    <th class="text-center" width="14%">Action</th>
                </tr>--}}
                </thead>
                <tbody>
                @if(!empty($issue_work_list))

                    @foreach($issue_work_list as $indent_no => $iwls)
                        @php $loopOne = $loop; @endphp
                        @foreach($iwls as $iwl)
                            @php
                            $badgeStatus = '';
                            switch($iwl->req_ind_text){
                            case "Partial Received":
                            $badgeStatus = 'badge-primary';
                            break;
                            case "Received":
                            $badgeStatus = 'badge-success';
                            break;
                            case "Closed":
                            $badgeStatus = 'badge-danger';
                            break;
                            default:
                            $badgeStatus = 'badge-warning';
                            }

                            @endphp
                            {{--<form action="">
                                <tr @if($loopOne->even) style="background-color: floralwhite" @endif>
                                    <td class="text-center" @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $loopOne->iteration }}
                                        @endif
                                    </td>

                                    <td  class="text-center" @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $iwl->requisition_uid?:'N/A' }}
                                        @else
                                            <span style="visibility: hidden">{{ $iwl->requisition_uid?:'N/A' }}</span>
                                        @endif
                                    </td>

                                    <td class="text-center">{{ !empty($iwl->requisition_date)?date('d/m/Y', strtotime($iwl->requisition_date)):'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->req_by_name?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->to_store_name?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->pvmsno?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->item_name?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->req_quantity?:0 }}</td>
                                    <td class="text-center">{{ $iwl->issue_quantity?:0 }}</td>
                                    <td class="text-right">
                                        <input style="width: 100px" class="text-right number_only"  type="text" value="{{ $iwl->req_quantity - $iwl->issue_quantity?:0 }}">
                                    </td>
                                    <td class="text-center">{{ $iwl->recv_quantity?:0 }}</td>
                                    <td class="text-center"><span class="badge {{ $badgeStatus }}">{{ $iwl->req_ind_text?:'N/A' }}</span></td>
                                    <td class="text-center">
                                        <button type="button" data-indentqty = "{{ $iwl->req_quantity - $iwl->issue_quantity}}" data-pk="{{ $iwl->requisitiondtl_no_pk }}"   class="btn btn-sm btn-info issue-btn"> Issue</button>
                                    </td>
                                </tr>
                            </form>--}}
                            <form action="">
                                <tr @if($loopOne->even) style="background-color: floralwhite" @endif>
                                    <td class="text-left" @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $loopOne->iteration }}
                                        @endif
                                    </td>

                                    <td  class="text-left" @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $iwl->requisition_uid?:'N/A' }}
                                        @else
                                            <span style="visibility: hidden">{{ $iwl->requisition_uid?:'N/A' }}</span>
                                        @endif
                                    </td>

                                    <td class="text-left">{{ !empty($iwl->requisition_date)?date('d/m/Y', strtotime($iwl->requisition_date)):'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->req_by_name?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->from_store_name?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->pvmsno?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->item_name?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->balance_qty ?: 0 }}</td>
                                    <td class="text-right">{{ $iwl->req_quantity?:0 }}</td>
                                    <td class="text-right">{{ $iwl->issue_quantity?:0 }}</td>
                                    <td class="text-right">
                                        <input style="width: 100px" class="text-right number_only"  type="text" value="{{ $iwl->req_quantity - $iwl->issue_quantity?:0 }}">
                                    </td>
                                    <td class="text-right">{{ $iwl->recv_quantity?:0 }}</td>
                                    <td class="text-right"><span class="badge {{ $badgeStatus }}">{{ $iwl->req_ind_text?:'N/A' }}</span></td>
                                    <td class="text-center">
                                        <button type="button" title="issue item" data-in_transref_no="{{ $iwl->requisition_no_pk }}" data-in_transref_date="{{ $iwl->requisition_date }}"
                                                data-in_stock_su_no_fk ="{{ $iwl->to_store_no_fk }}" data-from_store_no_fk = "{{ $iwl->from_store_no_fk }}"
                                                data-indentqty = "{{ $iwl->req_quantity - $iwl->issue_quantity}}" data-pk="{{ $iwl->requisitiondtl_no_pk }}"
                                                data-in_item_no_fk = "{{ $iwl->item_no_fk }}" data-prev_issue_qty = "{{ $iwl->issue_quantity }}" data-indent_qty = "{{ $iwl->req_quantity }}"
                                                class="btn btn-sm btn-info issue-btn"> Issue</button>

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

