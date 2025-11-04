@if (!empty($requisition_list))
    {{-- @dd($requisition_list); --}}
    @foreach ($requisition_list as $key => $row)
        @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) != intval($row['REQ_RECV_QUANTITY']))
            <tr>
                <input type="hidden" name="item_name[]" value="{{ $row['ITEM_NO_FK'] }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ $row['UOM'] }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">

                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['REQ_INV_REQUISITION_NO_PK']))
                {{-- <td>{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['REQ_INV_REQUISITION_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INV_REQUISITION_DATE']))
                <td>{{ $row['INV_REQUISITION_DATE'] != '' ? date('d/m/Y', strtotime($row['INV_REQUISITION_DATE'])) : '' }} </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                {{-- <td class="text-right">{{ $row['REQ_ITEM_PURCHASE_PRICE'] }}</td> --}}
                <!-- <td>{{ $row['REQ_ITEM_REMARKS'] != '0' ? $row['REQ_ITEM_REMARKS'] : '' }}</td>
                 <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                 <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                 {{-- <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td> --}}
                 {{-- <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td> --}}
                 {{-- <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td> --}}
                 {{-- <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td> --}}
                 <td class="text-right"></td> -->
                {{-- <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td> --> --}}
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                <td class="text-center">{{ $row['REQ_ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['REQ_ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['REQ_RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['REQ_RECV_QUANTITY'] }}" />
                </td>

                {{-- <td class="text-center">{{ $row['REQ_ISSUE_QUANTITY'] - $row['REQ_RECV_QUANTITY'] }}</td> --}}
                @if (!empty($row['REQ_ISSUE_QUANTITY']))
                <td>{{ $row['REQ_ISSUE_QUANTITY'] - $row['REQ_RECV_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <!-- <td class="text-right">
                 @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0)
                {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0" class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0 ? 'readonly' : '' }}
                                value="{{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}">
                                {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                @endif
                </td> -->
                <td>

                    @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                        <span class="badge badge-success ">Received</span>
                    @elseif (intval($row['REQ_RECV_QUANTITY']) > 0)
                        <span class="badge badge-primary ">Partial</span>
                    @else
                        <span class="badge badge-warning ">Recv. Pending</span>
                    @endif
                </td>

                @if (!empty($row['REQ_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['REQ_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_INV_REQUISITIONDTL_NO_PK']))
                    {{-- <td>{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_INV_REQUISITIONDTL_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM_NAME']))
                    <td>{{ $row['PR_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_REQ_QUANTITY']))
                    <td>{{ $row['PR_REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PR_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASEORDER_NO_PK']))
                    {{-- <td>{{ $row['PURCHASEORDER_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PURCHASEORDER_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PURCHASEORDER_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASE_DATE']))
                <td>{{ $row['PURCHASE_DATE'] != '' ? date('d/m/Y', strtotime($row['PURCHASE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ENTRY_QTY']))
                    <td>{{ $row['PO_ENTRY_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEMRECEIVE_NO_PK']))
                    <td>
                        {{-- {{ $row['ITEMRECEIVE_NO_PK'] }} --}}
                        <a href="{{ isset($row['ITEMRECEIVE_NO_PK']) ? route('v1.grn-report-print', $row['ITEMRECEIVE_NO_PK']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['ITEMRECEIVE_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEM_NAME']))
                    <td>{{ $row['GRN_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['RECEIVE_DATE']))
                <td>{{ $row['RECEIVE_DATE'] != '' ? date('d/m/Y', strtotime($row['RECEIVE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['DELIVERED_QTY']))
                    <td>{{ $row['DELIVERED_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @elseif(intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) == intval($row['REQ_RECV_QUANTITY']))
            <tr style="background-color: #ebca7a">
                <input type="hidden" name="item_name[]" value="{{ $row['ITEM_NO_FK'] }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ $row['UOM'] }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">
                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['REQ_INV_REQUISITION_NO_PK']))
                {{-- <td>{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['REQ_INV_REQUISITION_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INV_REQUISITION_DATE']))
                <td>{{ $row['INV_REQUISITION_DATE'] != '' ? date('d/m/Y', strtotime($row['INV_REQUISITION_DATE'])) : '' }}
                @else
                    <td>N/A</td>
                @endif

                 @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                {{-- <td class="text-right">{{ $row['REQ_ITEM_PURCHASE_PRICE'] }}</td> --}}
                <!-- <td>{{ $row['REQ_ITEM_REMARKS'] != '0' ? $row['REQ_ITEM_REMARKS'] : '' }}</td>
                <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                {{-- <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td> --}}
                {{-- <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td> --}}
                {{-- <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td> --}}
                {{-- <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td> --}}
                <td class="text-right"></td> -->
                {{-- <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td> --> --}}
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <td class="text-center">{{ $row['REQ_ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['REQ_ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['REQ_RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['REQ_RECV_QUANTITY'] }}" />
                </td>

                {{-- <td class="text-center">
                    {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                </td> --}}

                 @if (!empty($row['REQ_ISSUE_QUANTITY']))
                 <td class="text-center">
                    {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                </td>
                 @else
                     <td>N/A</td>
                 @endif

                <!-- <td class="text-right">
                @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0)
                {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0" class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0 ? 'readonly' : '' }} value="{{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}">
                                {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                @endif
                </td> -->
                <td>

                    @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                        <span class="badge badge-success ">Received</span>
                    @elseif (intval($row['REQ_RECV_QUANTITY']) > 0)
                        <span class="badge badge-primary ">Partial</span>
                    @else
                        <span class="badge badge-warning ">Recv. Pending</span>
                    @endif
                </td>

                @if (!empty($row['REQ_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['REQ_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_INV_REQUISITIONDTL_NO_PK']))
                    {{-- <td>{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_INV_REQUISITIONDTL_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM_NAME']))
                    <td>{{ $row['PR_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_REQ_QUANTITY']))
                    <td>{{ $row['PR_REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PR_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASEORDER_NO_PK']))
                    {{-- <td>{{ $row['PURCHASEORDER_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PURCHASEORDER_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PURCHASEORDER_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASE_DATE']))
                <td>{{ $row['PURCHASE_DATE'] != '' ? date('d/m/Y', strtotime($row['PURCHASE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ENTRY_QTY']))
                    <td>{{ $row['PO_ENTRY_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEMRECEIVE_NO_PK']))
                    <td>
                        {{-- {{ $row['ITEMRECEIVE_NO_PK'] }} --}}
                        <a href="{{ isset($row['ITEMRECEIVE_NO_PK']) ? route('v1.grn-report-print', $row['ITEMRECEIVE_NO_PK']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['ITEMRECEIVE_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEM_NAME']))
                    <td>{{ $row['GRN_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                 @if (!empty($row['RECEIVE_DATE']))
                <td>{{ $row['RECEIVE_DATE'] != '' ? date('d/m/Y', strtotime($row['RECEIVE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['DELIVERED_QTY']))
                    <td>{{ $row['DELIVERED_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @elseif(intval($row['REQ_ISSUE_QUANTITY']) == 0)
            <tr style="background-color: #AFEEEE">
                <input type="hidden" name="item_name[]" value="{{ $row['ITEM_NO_FK'] }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ $row['UOM'] }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ $row['INV_REQUISITIONDTL_NO_PK'] }}">
                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['REQ_INV_REQUISITION_NO_PK']))
                {{-- <td>{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['REQ_INV_REQUISITION_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['REQ_INV_REQUISITION_NO_PK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INV_REQUISITION_DATE']))
                <td>{{ $row['INV_REQUISITION_DATE'] != '' ? date('d/m/Y', strtotime($row['INV_REQUISITION_DATE'])) : '' }}
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                {{-- <td class="text-right">{{ $row['REQ_ITEM_PURCHASE_PRICE'] }}</td> --}}
                <!-- <td>{{ $row['REQ_ITEM_REMARKS'] != '0' ? $row['REQ_ITEM_REMARKS'] : '' }}</td>
                    <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                    <td>{{ $row['REQ_ITEM_REMARKS'] }}</td>
                    {{-- <td class="text-right">{{ $row['GENERIC_STOCK'] }}</td> --}}
                    {{-- <td class="text-right">{{ $row['CON_CURR_STOCK'] }}</td> --}}
                    {{-- <td class="text-right">{{ $row['CON_FROM_STOCK'] }}</td> --}}
                    {{-- <td class="text-right">{{ $row['STOCK_FROM_STORE'] }}</td> --}}
                    <td class="text-right"></td> -->
                {{-- <td class="text-right">{{ $row['CURRENT_STOCK'] }}</td> --> --}}
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <td class="text-center">{{ $row['REQ_ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['REQ_ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['REQ_RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty"
                        value="{{ $row['REQ_RECV_QUANTITY'] }}" />
                </td>
                {{-- <td class="text-center">
                    {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                </td> --}}

                @if (!empty($row['REQ_ISSUE_QUANTITY']))
                <td class="text-center">
                   {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
               </td>
                @else
                    <td>N/A</td>
                @endif

                <!-- <td class="text-right">
              @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0)
                {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0"
                  class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['REQ_ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) == 0 ? 'readonly' : '' }}
                   value="{{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}">
                   {{ intval($row['REQ_ISSUE_QUANTITY']) - intval($row['REQ_RECV_QUANTITY']) }}                                                                            
                @endif
             </td> -->
                <td>
                    <span class="badge badge-secondary ">Not Issued</span>
                    <!-- @if (intval($row['REQ_ISSUE_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) > 0 &&
                            intval($row['REQ_RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                <span class="badge badge-success ">Received</span>
                @elseif (intval($row['REQ_RECV_QUANTITY']) > 0)
                <span class="badge badge-primary ">Partial</span>
                @else
                <span class="badge badge-warning ">Pending</span>
                @endif -->
                </td>

                @if (!empty($row['REQ_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['REQ_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_INV_REQUISITIONDTL_NO_PK']))
                    {{-- <td>{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_INV_REQUISITIONDTL_NO_PK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_INV_REQUISITIONDTL_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM_NAME']))
                    <td>{{ $row['PR_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_REQ_QUANTITY']))
                    <td>{{ $row['PR_REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PR_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASEORDER_NO_PK']))
                    {{-- <td>{{ $row['PURCHASEORDER_NO_PK'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PURCHASEORDER_NO_PK']) }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['PURCHASEORDER_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PURCHASE_DATE']))
                <td>{{ $row['PURCHASE_DATE'] != '' ? date('d/m/Y', strtotime($row['PURCHASE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ENTRY_QTY']))
                    <td>{{ $row['PO_ENTRY_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEMRECEIVE_NO_PK']))
                    <td>
                        {{-- {{ $row['ITEMRECEIVE_NO_PK'] }} --}}
                        <a href="{{ isset($row['ITEMRECEIVE_NO_PK']) ? route('v1.grn-report-print', $row['ITEMRECEIVE_NO_PK']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['ITEMRECEIVE_NO_PK'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEM_NAME']))
                    <td>{{ $row['GRN_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['RECEIVE_DATE']))
                <td>{{ $row['RECEIVE_DATE'] != '' ? date('d/m/Y', strtotime($row['RECEIVE_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['DELIVERED_QTY']))
                    <td>{{ $row['DELIVERED_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @endif
    @endforeach
@endif
