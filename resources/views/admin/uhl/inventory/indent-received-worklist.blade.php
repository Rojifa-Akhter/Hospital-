<div class="table-responsive">
    <table
        class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2">Indent No</th>
                <th rowspan="2">Indent Date</th>
                <th rowspan="2">From Dept.</th>
                <th rowspan="2">To Dept.</th>
                <th colspan="2">Req. By</th>
                <th rowspan="2">Ref. Req. No</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2">Is Urgent</th>
                <th rowspan="2">Is Exact</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Type</th>
                <th>Req. By</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($issued_requisition_list))
                @foreach ($issued_requisition_list as $row)
                    @inject('indent','App\Http\Controllers\HOSItemIssueController')
                    @php
                        
                        $indt_qty = 0;
                        $iss_qty = 0;
                        $iss_ind = 0;
                        $rcv_ind = 0;
                        $rcv_qty = 0;
                        $indent_item = $indent->get_received_indent_details($row->inv_requisition_uid);
                        foreach($indent_item as $item) {
                            $indt_qty += intval($item->req_quantity);
                            $iss_qty += intval($item->issue_quantity);
                            $rcv_qty += intval($item->recv_quantity);
                            $iss_ind = isset($item->issue_ind) ? $item->issue_ind : 0;
                            $rcv_ind = isset($item->recv_ind) ? $item->recv_ind : 0;
                        }
                    @endphp
                    {{-- @if(($indt_qty == $iss_qty || $iss_qty > 0) && ($iss_qty == $rcv_qty)) --}}
                    
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->inv_requisition_uid }}</td>
                        <td>{{ date('d-m-Y h:i a', strtotime($row->req_at)) }}
                        </td>
                        <td>{{ $row->from_stor }}</td>
                        <td>{{ $row->to_store }}</td>
                        <td>{{ $row->req_type }}</td>
                        <td>{{ $row->user_name }}</td>
                        <td>{{ $row->ref_indent_no_fk }}</td>
                        <td>{{ $row->indent_remarks }}</td>


                        <td>
                            <span
                                class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <span
                                class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->exact != 0 ? 'Yes' : 'No' }}
                            </span>

                        </td>
                        <td>
                        </td>
                        <td>
                        @if (isset($type) && $type=="ALLDEPT")
                            <a href="{{ route('v1.department-received-print', $row->inv_requisition_no_pk) }}"target="_blank"class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                       @else
                            @php
                                $status= $rcv_ind == 1 && $iss_ind == 1? 'Received' : '';
                                $disabled = $iss_ind == 1 ? 'javascript:void(0)' : route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk]);
                            @endphp
                            
                            @if (($indt_qty == $iss_qty || $iss_qty > 0) && ($iss_qty != $rcv_qty))
                                <a href="{{route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk])}}"
                                    rel="tab" class="btn btn-sm uhl_common_btn text-white"
                                    style="opacity: 1!important;" >Receive</a>

                            @elseif (($indt_qty == $iss_qty || $iss_qty > 0) && ($iss_qty == $rcv_qty))
                                <a href="{{route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk])}}"
                                    rel="tab" class="btn btn-sm uhl_common_btn text-white"
                                    style="opacity: 1!important;" >Received</a>
                            @endif
                            <a href="{{ route('v1.department-received-print', $row->inv_requisition_no_pk) }}"
                                target="_blank"
                                class="btn btn-sm btn-primary"><i
                                  class="fas fa-print"></i></a>
                        @endif 
                        </td>
                    </tr>
                    {{-- @endif --}}
                @endforeach

            @endif
        </tbody>
    </table>
</div>