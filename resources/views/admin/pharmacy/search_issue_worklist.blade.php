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

                @if(!empty($issue_work_list))

                    @foreach($issue_work_list as $indent_no => $iwls)
                        @php $loopOne = $loop; @endphp
                        @foreach($iwls as $iwl)
                            {{-- @php
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

                            @endphp --}}
                            <form action="">
                                <tr @if($loopOne->even) style="background-color: floralwhite" @endif>
                                    <td class="text-left"
                                        @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $loopOne->iteration }}
                                        @endif
                                    </td>

                                    <td class="text-left"
                                        @if(!$loop->last) style="border-bottom: none" @endif>
                                        @if($loop->iteration == 1)
                                            {{ $iwl->inv_requisition_uid?:'N/A' }}
                                        @else
                                            <span
                                                style="visibility: hidden">{{ $iwl->inv_requisition_uid?:'N/A' }}</span>
                                        @endif
                                    </td>

                                    <td class="text-left">{{ !empty($iwl->inv_requisition_date)?date('Y-m-d', strtotime($iwl->inv_requisition_date)):'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->req_by_name?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->to_store_name?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->pvmsno?:'N/A' }}</td>
                                    <td class="text-left">{{ $iwl->item_name?:'N/A' }}</td>
                                    <td class="text-center">{{ $iwl->balance_qty ?: 0 }}</td>
                                    <td class="text-right">{{ $iwl->req_quantity?:0 }}</td>
                                    <td class="text-right">{{ $iwl->issue_quantity?:0 }}</td>
                                    <td class="text-right">
                                        <input style="width: 100px" class="text-right number_only"
                                               type="text"
                                               value="{{ $iwl->req_quantity - $iwl->issue_quantity?:0 }}">
                                    </td>

                                    <td class="text-right">{{ $iwl->recv_quantity?:0 }}</td>
                                    <td class="text-right">
                                        @if($iwl->issue_ind)
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
                                                data-indentqty="{{ $iwl->req_quantity - $iwl->issue_quantity}}"
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
