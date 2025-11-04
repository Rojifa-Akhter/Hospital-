<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table data-table  table-bordered ">
                <thead class="bg-primary">
                    {{-- <tr>
					<th class="text-center">
						SL

					</th>
					<th class="text-center">Indent No</th>
					<th class="text-center">Indent Date</th>
					<th class="text-center">Indent By</th>
					<th class="text-center">Pharmacy Name</th>
					<th class="text-center">PVMS No</th>
					<th class="text-center">Item Name</th>
					<th class="text-center">Indent Qty</th>
					<th class="text-center">Issued Qty</th>
					<th class="text-center">Prev. Receive</th>
					<th class="text-center">Received Qty</th>
					<th class="text-center">Status</th>
					<th class="text-center">Action</th>
				</tr> --}}
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
                            @php $loopOne = $loop; @endphp
                            @foreach ($iis as $indent_item)
                                {{-- @php
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

                                @endphp --}}


                                {{-- <tr @if ($loopOne->even) style="background-color: floralwhite" @endif>
								<td class="text-center" width="6%" class="text-center" @if (!$loop->last) style="border-bottom: none" @endif>
									@if ($loop->iteration == 1)
										{{ $loopOne->iteration }}
									@endif
								</td>
								<td class="text-center" width="6%" class="text-center" @if (!$loop->last) style="border-bottom: none" @endif>
									@if ($loop->iteration == 1)
										{{ $indent_item->inv_requisition_uid }}
									@else
										<span style="visibility: hidden">{{ $indent_item->inv_requisition_uid }}</span>
									@endif

								</td>
								<td class="text-center" width="9%">{{ date('d-m-yy',strtotime($indent_item->inv_requisition_date)) }}</td>
								<td class="text-center" width="10%">{{ $indent_item->req_by_name }}</td>
								<td class="text-center" width="7%">{{ $indent_item->from_store_name }}</td>
								<td class="text-center" width="5%">{{ $indent_item->pvmsno }}</td>
								<td class="text-left" width="12%">{{ $indent_item->item_name }}</td>
								<td class="text-center" width="5%">{{ $indent_item->req_quantity }}</td>
								<td class="text-center" width="5%">{{ $indent_item->issue_quantity }}</td>
								<td class="text-center" width="5%">{{$indent_item->recv_quantity}}</td>
								<td class="text-right" width="5%">
									<input style="width:100%;" class="text-right number_only" name="item_quantities[]" type="text number_only" value="{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}">

								</td> --}}{{-- <td class="text-center">{{ $indent_item->recv_quantity }}</td> --}}{{-- <td width="8%" class="text-center"><span class="badge {{ $badgeStatus }}">{{ $indent_item->req_ind_text }}</span>
								</td>

								<td width="10%" class="text-center">
									<button type="button" data-indentqty = "{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}" data-pk="{{ $indent_item->requisitiondtl_no_pk }}"   class="btn btn-sm btn-info receive-btn"> Receive</button> --}}{{-- @if ($indent_item->req_ind_text == 'Pending')
                                        <button type="button" data-indentqty = "{{ $indent_item->issue_quantity }}" data-pk="{{ $indent_item->requisitiondtl_no_pk }}"   class="btn btn-sm btn-info receive-btn"> Receive</button>
                                    @elseif($indent_item->req_ind_text=='Received')
                                    <a href="#" class="btn btn-sm btn-info disabled" title="Receive This Item">Receive</a>
                                    @endif --}}{{-- </td>
							</tr> --}}
                                <tr @if ($loopOne->even) style="background-color: floralwhite" @endif>
                                    <td class="text-left"
                                        @if (!$loop->last) style="border-bottom: none" @endif>
                                        @if ($loop->iteration == 1)
                                            {{ $loopOne->iteration }}
                                        @endif
                                    </td>
                                    <td class="text-center"
                                        @if (!$loop->last) style="border-bottom: none" @endif>
                                        @if ($loop->iteration == 1)
                                            {{ $indent_item->inv_requisition_uid }}
                                        @else
                                            <span
                                                style="visibility: hidden">{{ $indent_item->inv_requisition_uid }}</span>
                                        @endif

                                    </td>
                                    <td class="text-left">
                                        {{ date('Y-m-d', strtotime($indent_item->inv_requisition_date)) }}</td>
                                    <td class="text-left">{{ $indent_item->req_by_name }}</td>
                                    <td class="text-left">{{ $indent_item->from_store_name }}</td>
                                    <td class="text-left">{{ $indent_item->pvmsno }}</td>
                                    <td class="text-left">{{ $indent_item->item_name }}</td>
                                    <td class="text-right">{{ $indent_item->balance_qty ?: 0 }}</td>
                                    <td class="text-right">{{ $indent_item->req_quantity }}</td>
                                    <td class="text-right">{{ $indent_item->issue_quantity }}</td>
                                    <td class="text-right">{{ $indent_item->recv_quantity }}</td>

                                    <td class="text-right">
                                        <input style="width:100%;" class="text-right number_only"
                                            name="item_quantities[]" type="text number_only"
                                            value="{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}">

                                    </td>
                                    <td class="text-center">
                                        @if ($indent_item->recv_ind)
                                            <span class="badge badge-success">Received</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{-- @if ($indent_item->expireable == 1) --}}
                                        @php
                                            $rem = $indent_item->issue_quantity - $indent_item->recv_quantity;
                                            $patient_no_fk = isset($indent_item->patient_no_fk) ? $indent_item->patient_no_fk : 0;
                                            $item_details = $indent_item->item_no_fk . '_' . $rem . '_' . $indent_item->to_store_no_fk . '_' . $indent_item->inv_requisition_uid . '_' . $indent_item->from_store_no_fk . '_' . $patient_no_fk ;
                                            //$item_details = str_replace("%","_",$item_details);
                                            //dd($item_details);
                                        @endphp
                                        <span Class="btn btn-sm btn-info open-modal" data-modal="common-modal-sm"
                                            data-id=""
                                            data-action="{{ route('show_indent_item_receive_pop_up',str_replace(" ","_",$item_details)) }}"
                                            data-title="Batch No" id="">Receive</span>
                                        {{-- @else
                                            <button type="button" title="receive item"
                                                data-in_transref_no="{{ $indent_item->inv_requisitiondtl_no_pk }}"
                                                data-in_transref_date="{{ $indent_item->inv_requisition_date }}"
                                                data-rcv="{{ $indent_item->recv_quantity }}"
                                                data-in_stock_su_no_fk_from="{{ $indent_item->from_store_no_fk }}"
                                                data-in_stock_su_no_fk="{{ $indent_item->to_store_no_fk }}"
                                                data-in_item_no_fk="{{ $indent_item->item_no_fk }}"
                                                data-issued="{{ $indent_item->issue_quantity }}"
                                                data-indentqty="{{ $indent_item->issue_quantity - $indent_item->recv_quantity }}"
                                                data-pk="{{ $indent_item->inv_requisitiondtl_no_pk }}"
                                                class="btn btn-sm btn-info receive-btn"> Receive
                                            </button>
                                        @endif --}}
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
