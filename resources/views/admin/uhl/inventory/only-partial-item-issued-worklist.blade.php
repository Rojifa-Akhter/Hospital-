<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2">Indent No</th>
                <th rowspan="2">Indent Date</th>
                <th rowspan="2">From Dept.</th>
                <th rowspan="2">To Dept.</th>
                <th colspan="2">Req. By</th>
                <th rowspan="2">Ref. Req. No</th>
                <th rowspan="2">Indent Remarks</th>
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

            @if (!empty($requisition_list))
           
                @foreach ($requisition_list as $row)
                    @inject('indent', 'App\Http\Controllers\HOSItemIssueController')
                    @php
                        
                        $indt_qty = 0;
                        $iss_qty = 0;
                        $iss_ind = 0;
                        $indent_item = $indent->get_issued_indent_details($row->inv_requisition_uid);
                        
                        foreach ($indent_item as $item) {
                            $indt_qty += $item->req_quantity;
                            $iss_qty += $item->issue_quantity;
                            $iss_ind = isset($item->issue_ind) ? $item->issue_ind : 0;
                        }
                        
                    @endphp
                    @if (strpos($row->approval_status_text, 'REJECTED') >= 1)
                    @else
                        {{-- @dd($indt_qty ,$iss_qty , $iss_qty , $iss_ind) --}}
                        {{-- @if ($indt_qty != $iss_qty && $iss_qty > 0 && $iss_ind == 1) --}}
                        @if ($indt_qty != $iss_qty && $iss_qty > 0 )
                            <!-- $indt_qty != $iss_qty && -->
                            @if ($indt_qty == $iss_qty)
                                <tr style="background-color: #ebca7a">
                                @else
                                <tr>
                            @endif
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
                                <span class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                    {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                    {{ $row->exact != 0 ? 'Yes' : 'No' }}
                                </span>

                            </td>
                            <td>

                                @if ($indt_qty > $iss_qty )
                                    <button class="btn btn-sm btn-primary text-white">Partial Issued</button>
                                @elseif($indt_qty == $iss_qty )
                                    <button class="btn btn-sm uhl_common_btn text-white">Issued</button>
                                    {{-- @elseif($row->recv_ind == 1)    
                                <button class="btn btn-sm uhl_common_btn text-white">Received</button> --}}
                                @endif
                            </td>
                            <td>

                                @if ($indt_qty > $iss_qty)
                                    <a href="{{ route('v1-item-issue.create', ['requisition_no' => $row->inv_requisition_no_pk]) }}"
                                        target="_blank" class="btn btn-sm uhl_common_btn text-white"
                                        style="opacity: 1!important;" rel="tab">Issue</a>
                                @endif
                                <a href="{{ route('v1.department-partial-issued-indent-print', $row->inv_requisition_no_pk) }}"
                                    target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                            </td>
                            </tr>
                        @endif
                    @endif
                @endforeach

            @endif
        </tbody>
    </table>
</div>
