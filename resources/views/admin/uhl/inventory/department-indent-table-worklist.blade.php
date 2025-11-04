<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2" class="text-left">Indent No</th>
                <th rowspan="2" class="text-left">Indent Date</th>
                <th rowspan="2" class="text-left">From Dept.</th>
                <th rowspan="2" class="text-left">To Dept.</th>
                <th colspan="2">Req. By</th>
                <th rowspan="2">Ref. Req. No</th>
                <th rowspan="2">Indent Remarks</th>
                <!-- <th rowspan="2">Is Urgent</th>
                <th rowspan="2">Is Exact</th> -->
                <th rowspan="2">Indent Status</th>
                <th rowspan="2">Approval Status</th>
                <th rowspan="2" style="width: 100px">Action</th>
            </tr>
            <tr>
                <th>Type</th>
                <th>Req. By</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($requisition_list))
                @foreach ($requisition_list as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->inv_requisition_uid }}</td>
                        <td>{{ $row->inv_requisition_date != '' ? date('d/m/Y', strtotime($row->inv_requisition_date)) : '' }}
                        </td>
                        <td>{{ $row->from_stor }}</td>
                        <td>{{ $row->to_store }}</td>
                        <td>{{ $row->req_type }}</td>
                        <td>{{ $row->user_name }}</td>
                        <td>{{ $row->ref_indent_no_fk }}</td>
                        <td>{{ $row->indent_remarks }}</td>

                        <td class="text-center">

                            @php                                
                                $disabled = route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk]);                                
                            @endphp


                            @if ($row->indent_save_option == 'POST')
                                <button class="badge badge-success"> POST</button>
                            @elseif($row->indent_save_option == 'DRAFT')
                                <button class="badge badge-success"> DRAFT</button>
                            @endif
                        </td>
                        <td class="text-left">

                            @if (strpos($row->approval_status_text, 'REJECTED') >= 1 || strpos($row->approval_status_text, 'HOLD') >= 1)
                                <span
                                    class="text-danger">{{ strpos($row->approval_status_text, 'HOLD') >= 1 ? 'Hold' : 'Rejected' }}</span>
                            @else
                                @if ($row->approval_level_status_text != '')
                                    @php
                                        $lavel = explode('/', $row->approval_level_status_text);
                                        $approval_status = $lavel[0] == $lavel[1] ? 'Approved' : 'Pending';
                                        $approval_person = $row->approval_level_status_text != '' ? explode('/', $row->approval_level_status_text) : '';
                                        
                                    @endphp
                                    @if (!empty($approval_person) && $approval_person[0] == $approval_person[1])
                                    <a style="cursor:pointer" class="open-modal" data-action="{{route('v1.my.approval.level.detail-pr-list',[$row->inv_requisition_no_pk,'INDENT'])}}" data-id="{{$row->inv_requisition_no_pk}}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">  <span class="badge badge-success">({{ $row->approval_level_status_text }})
                                        </span>
                                    </a>
                                    @else
                                    <a style="cursor:pointer" class="open-modal" data-action="{{route('v1.my.approval.level.detail-pr-list',[$row->inv_requisition_no_pk,'INDENT'])}}" data-id="{{$row->inv_requisition_no_pk}}" data-modal="common-modal-sm" data-title="Level Detail" title="Level Detail">  
                                        <span
                                            class="badge badge-warning">({{ $row->approval_level_status_text }})
                                        </span>
                                    </a>
                                    @endif
                                    {{ $approval_status }}
                                 
                                @endif
                            @endif
                        </td>
                        <td style="text-align: left">
                            @php
                                
                                $approval_exp = !empty($row->approval_level_status_text) && $row->approval_level_status_text != '' ? explode('/', $row->approval_level_status_text) : '';
                            @endphp

                            @if ($approval_exp != '' && $approval_exp[0] != $approval_exp[1])
                                @php
                                    $approval = 1;
                                @endphp
                            @else
                                @php
                                    $approval = 0;
                                @endphp
                            @endif
                            <!-- $row->indent_save_option != 'POST'  -->
                            @if ($approval == 1 && ($approval_exp[0] <= 0 || Session::get('user.inv_hod_ind') == 1))
                                @if ($row->indent_save_option == 'POST' || $row->indent_save_option == 'ISSUE')
                                @else
                                    <a href="{{ route('v1-department-indent.edit', $row->inv_requisition_no_pk) }} "
                                        rel="tab" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                                @endif
                            @endif
                            <a href="{{ route('v1.department-indent-print', $row->inv_requisition_no_pk) }}"
                                target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>

                            <a data-modal="common-modal"
                                data-action="{{ route('v1.department-indent-list-view', $row->inv_requisition_no_pk) }}"
                                class="btn mb-1 btn-success btn-sm open-modal modal-lg"
                                data-title="Department Indent View"><i class="fas fa-eye"></i></a>
                            @if (isset($lavel[0]) && $lavel[0] <=0 )
                                <span class="btn-sm btn-danger" style="cursor: pointer" data-indentId="{{$row->inv_requisition_no_pk}}" data-type="{{$row->indent_save_option}}" onclick="cancelIndent(this)"><i class="fa fa-times" aria-hidden="true"></i></span>
                            @endif
                                
                        </td>
                    </tr>
                @endforeach

            @endif
        </tbody>
    </table>
</div>
