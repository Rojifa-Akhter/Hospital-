@if (!empty($requisition_list))
    @foreach ($requisition_list as $key => $row)
        @if (intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) != intval($row['RECV_QUANTITY']))
            <tr>
                <input type="hidden" name="item_name[]" value="{{ isset($row['ITEM_NO_FK']) ? $row['ITEM_NO_FK'] :'' }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ isset($row['UOM']) ? $row['UOM']:'' }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ isset($row['INV_REQUISITIONDTL_NO_PK']) ? $row['INV_REQUISITIONDTL_NO_PK'] : '' }}">

                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['INV_REQUISITION_NO_FK']))
                {{-- <td>{{ $row['INV_REQUISITION_NO_FK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['INV_REQUISITION_NO_FK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['INV_REQUISITION_NO_FK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INDENT_DATE']))
                <td>{{ $row['INDENT_DATE'] != '' ? date('d/m/Y', strtotime($row['INDENT_DATE'])) : '' }} </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

            
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                <td class="text-center">{{ $row['ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['RECV_QUANTITY'] }}" />
                </td>

                {{-- <td class="text-center">{{ $row['ISSUE_QUANTITY'] - $row['RECV_QUANTITY'] }}</td> --}}
                @if (!empty($row['ISSUE_QUANTITY']))
                <td>{{ $row['ISSUE_QUANTITY'] - $row['RECV_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <!-- <td class="text-right">
                 @if (intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0)
                {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0" class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0 ? 'readonly' : '' }}
                                value="{{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}">
                                {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                @endif
                </td> -->
                <td>

                    @if (intval($row['ISSUE_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                        <span class="badge badge-success ">Received</span>
                    @elseif (intval($row['RECV_QUANTITY']) > 0)
                        <span class="badge badge-primary ">Partial</span>
                    @else
                        <span class="badge badge-warning ">Recv. Pending</span>
                    @endif
                </td>

                @if (!empty($row['INDENT_APPROVAL']))
                    <td>{{ $row['INDENT_APPROVAL'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_NO']))
                    {{-- <td>{{ $row['PR_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_NO']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM']))
                    <td>{{ $row['PR_ITEM'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_QTY']))
                    <td>{{ $row['PR_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['APPROVE_STATUS']))
                    <td>{{ $row['APPROVE_STATUS'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_NO']))
                    {{-- <td>{{ $row['PO_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PO_NO']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PO_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_DATE']))
                <td>{{ $row['PO_DATE'] != '' ? date('d/m/Y', strtotime($row['PO_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_QTY']))
                    <td>{{ $row['PO_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_NO']))
                    <td>
                        {{-- {{ $row['GRN_NO'] }} --}}
                        <a href="{{ isset($row['GRN_NO']) ? route('v1.grn-report-print', $row['GRN_NO']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['GRN_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEMNAME']))
                    <td>{{ $row['GRN_ITEMNAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_DATE']))
                <td>{{ $row['GRN_DATE'] != '' ? date('d/m/Y', strtotime($row['GRN_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_QTY']))
                    <td>{{ $row['GRN_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @elseif(intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) == intval($row['RECV_QUANTITY']))
            <tr style="background-color: #ebca7a">
                <input type="hidden" name="item_name[]" value="{{ isset($row['ITEM_NO_FK']) ? $row['ITEM_NO_FK'] :'' }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ isset($row['UOM']) ? $row['UOM']:'' }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ isset($row['INV_REQUISITIONDTL_NO_PK']) ? $row['INV_REQUISITIONDTL_NO_PK'] : '' }}">
                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['INV_REQUISITION_NO_FK']))
                {{-- <td>{{ $row['INV_REQUISITION_NO_FK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['INV_REQUISITION_NO_FK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['INV_REQUISITION_NO_FK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INDENT_DATE']))
                <td>{{ $row['INDENT_DATE'] != '' ? date('d/m/Y', strtotime($row['INDENT_DATE'])) : '' }}
                @else
                    <td>N/A</td>
                @endif

                 @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif
               
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <td class="text-center">{{ $row['ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty" value="{{ $row['RECV_QUANTITY'] }}" />
                </td>

                {{-- <td class="text-center">
                    {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                </td> --}}

                 @if (!empty($row['ISSUE_QUANTITY']))
                 <td class="text-center">
                    {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                </td>
                 @else
                     <td>N/A</td>
                 @endif

                <!-- <td class="text-right">
                @if (intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0)
                {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0" class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0 ? 'readonly' : '' }} value="{{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}">
                                {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                @endif
                </td> -->
                <td>

                    @if (intval($row['ISSUE_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                        <span class="badge badge-success ">Received</span>
                    @elseif (intval($row['RECV_QUANTITY']) > 0)
                        <span class="badge badge-primary ">Partial</span>
                    @else
                        <span class="badge badge-warning ">Recv. Pending</span>
                    @endif
                </td>

                @if (!empty($row['INDENT_APPROVAL']))
                    <td>{{ $row['INDENT_APPROVAL'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_NO']))
                    {{-- <td>{{ $row['PR_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_NO']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM']))
                    <td>{{ $row['PR_ITEM'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_QTY']))
                    <td>{{ $row['PR_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['APPROVE_STATUS']))
                    <td>{{ $row['APPROVE_STATUS'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_NO']))
                    {{-- <td>{{ $row['PO_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PO_NO']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PO_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_DATE']))
                <td>{{ $row['PO_DATE'] != '' ? date('d/m/Y', strtotime($row['PO_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_QTY']))
                    <td>{{ $row['PO_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_NO']))
                    <td>
                        {{-- {{ $row['GRN_NO'] }} --}}
                        <a href="{{ isset($row['GRN_NO']) ? route('v1.grn-report-print', $row['GRN_NO']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['GRN_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEMNAME']))
                    <td>{{ $row['GRN_ITEMNAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                 @if (!empty($row['GRN_DATE']))
                <td>{{ $row['GRN_DATE'] != '' ? date('d/m/Y', strtotime($row['GRN_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_QTY']))
                    <td>{{ $row['GRN_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @elseif(intval($row['ISSUE_QUANTITY']) == 0)
            <tr style="background-color: #AFEEEE">
                <input type="hidden" name="item_name[]" value="{{ isset($row['ITEM_NO_FK']) ? $row['ITEM_NO_FK'] :'' }}">
                <input type="hidden" name="item_price[]" value="0">
                <input type="hidden" name="item_uom[]" value="{{ isset($row['UOM']) ? $row['UOM']:'' }}">
                <input type="hidden" name="in_inv_requisitiondtl_no_pk[]"
                    value="{{ isset($row['INV_REQUISITIONDTL_NO_PK']) ? $row['INV_REQUISITIONDTL_NO_PK'] : '' }}">
                <td class="text-center">{{ $loop->iteration }}</td>

                @if (!empty($row['INV_REQUISITION_NO_FK']))
                {{-- <td>{{ $row['INV_REQUISITION_NO_FK'] }}</td> --}}
                <td>
                    <a href="{{ route('v1.department-indent-print', $row['INV_REQUISITION_NO_FK']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['INV_REQUISITION_NO_FK'] }}</a>
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['INDENT_DATE']))
                <td>{{ $row['INDENT_DATE'] != '' ? date('d/m/Y', strtotime($row['INDENT_DATE'])) : '' }}
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['ITEM_NAME']))
                <td>{{ $row['ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                
                @if (!empty($row['REQ_QUANTITY']))
                <td>{{ $row['REQ_QUANTITY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
                <td class="text-center">{{ $row['ISSUE_QUANTITY'] }}
                    <input type="hidden" name="issue_qty[]" class="issue_qty"
                        value="{{ $row['ISSUE_QUANTITY'] }}" />
                </td>
                <td class="text-center">{{ $row['RECV_QUANTITY'] }}
                    <input type="hidden" name="rcv_qty[]" class="rcv_qty"
                        value="{{ $row['RECV_QUANTITY'] }}" />
                </td>
                {{-- <td class="text-center">
                    {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                </td> --}}

                @if (!empty($row['ISSUE_QUANTITY']))
                <td class="text-center">
                   {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
               </td>
                @else
                    <td>N/A</td>
                @endif

                <!-- <td class="text-right">
              @if (intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0)
                {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}
                @else
                <input type="hidden" placeholder="0"
                  class="form-control text-right item_quantity" name="item_quantity[]" {{ intval($row['ISSUE_QUANTITY']) > 0 && intval($row['REQ_QUANTITY']) - intval($row['RECV_QUANTITY']) == 0 ? 'readonly' : '' }}
                   value="{{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}">
                   {{ intval($row['ISSUE_QUANTITY']) - intval($row['RECV_QUANTITY']) }}                                                                            
                @endif
             </td> -->
                <td>
                    <span class="badge badge-secondary ">Not Issued</span>
                    <!-- @if (intval($row['ISSUE_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) > 0 &&
                            intval($row['RECV_QUANTITY']) == intval($row['REQ_QUANTITY']))
                <span class="badge badge-success ">Received</span>
                @elseif (intval($row['RECV_QUANTITY']) > 0)
                <span class="badge badge-primary ">Partial</span>
                @else
                <span class="badge badge-warning ">Pending</span>
                @endif -->
                </td>

                @if (!empty($row['INDENT_APPROVAL']))
                    <td>{{ $row['INDENT_APPROVAL'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_NO']))
                    {{-- <td>{{ $row['PR_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.pr-print', $row['PR_NO']) }}" target="_blank"
                            class="btn btn-warning btn-sm">{{ $row['PR_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_ITEM']))
                    <td>{{ $row['PR_ITEM'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PR_QTY']))
                    <td>{{ $row['PR_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['APPROVE_STATUS']))
                    <td>{{ $row['APPROVE_STATUS'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_NO']))
                    {{-- <td>{{ $row['PO_NO'] }}</td> --}}
                    <td>
                        <a href="{{ route('v1.purchase-order-print', $row['PO_NO']) }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['PO_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_ITEM_NAME']))
                    <td>{{ $row['PO_ITEM_NAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_DATE']))
                <td>{{ $row['PO_DATE'] != '' ? date('d/m/Y', strtotime($row['PO_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_QTY']))
                    <td>{{ $row['PO_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['PO_APPROVAL_LEVEL_STATUS_TEXT']))
                    <td>{{ $row['PO_APPROVAL_LEVEL_STATUS_TEXT'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_NO']))
                    <td>
                        {{-- {{ $row['GRN_NO'] }} --}}
                        <a href="{{ isset($row['GRN_NO']) ? route('v1.grn-report-print', $row['GRN_NO']) : '' }}"
                            target="_blank" class="btn btn-warning btn-sm">{{ $row['GRN_NO'] }}</a>
                    </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_ITEMNAME']))
                    <td>{{ $row['GRN_ITEMNAME'] }}</td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_DATE']))
                <td>{{ $row['GRN_DATE'] != '' ? date('d/m/Y', strtotime($row['GRN_DATE'])) : '' }}
                </td>
                @else
                    <td>N/A</td>
                @endif

                @if (!empty($row['GRN_QTY']))
                    <td>{{ $row['GRN_QTY'] }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        @endif
    @endforeach
@endif
