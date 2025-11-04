<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table  table-bordered">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left" scope="col">Task</th>
            <th class="text-center" scope="col">Sl#</th>
            <th class="text-left" scope="col">ID</th>
            <th class="text-left" scope="col">Created By At</th>
            <th class="text-left" scope="col">Waiting</th>
            <th class="text-left" scope="col">Status</th>
            <th class="text-left" scope="col">PDF</th>
            <th class="text-left" scope="col">Action</th>
        </tr>
    </thead>

    @if (isset($approvalDataArray))
        @foreach ($approvalDataArray as $key => $singleApprovalDataArray)

            @foreach ($singleApprovalDataArray as $item => $data)

                @inject('app_status','App\Http\Controllers\HOSApprovalMatrixController')
                @php
                    $approval_status = $app_status->check_approval_status($data->primary_key_value);

                    $app_status = 1;
                    if(intval($data->own_level) == 1) {

                        $app_status = 1;
                    }else {



                        foreach($approval_status as $approval) {
                            $diff = (intval($data->own_level) - intval($approval->own_level));

                            if(intval($approval->own_level) < intval($data->own_level) && intval($approval->approved_ind) == 0 && $diff == 1) {

                                $app_status = 0;
                            }


                        }
                    }

                @endphp
                @if ($data->approved_ind == 1)
                    <tr>
                        @if($item == 0)
                        <td style="vertical-align: top;" class="text-left" rowspan="{{ count($singleApprovalDataArray) }}">{{$key}}</td>
                        @endif
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{$data->primary_key_uid}}({{$data->primary_key_value}})</td>
                        <td class="text-left">{{$data->user_fullname_ent}}<br>{{$data->apprprocess_date}}</td>
                        @php
                            $startDatetime = $data->apprprocess_date;
                            if($data->approved_at != null){
                                $endDatetime =  date('Y-m-d h:i:sa', strtotime($data->approved_at));
                            }else{
                                $endDatetime = date("Y-m-d h:i:sa");
                            }

                            $starttimestamp = strtotime($startDatetime);
                            $endtimestamp = strtotime($endDatetime);
                            $hrDifference = abs($endtimestamp - $starttimestamp)/3600;
                            $dayDifference = abs($endtimestamp - $starttimestamp)/86400;
                            $differenceHrs = round($hrDifference);
                            $differenceDays = round($dayDifference);
                        //  dd($interval->format('%d') "days". $interval->format('%h')." Hours ".$interval->format('%i')." Minutes");
                        @endphp
                        <td class="text-left">{{$differenceDays <=0 ?  $differenceHrs. " hour(s)" : $differenceDays. " day(s)"}}</td>
                        <td class="text-left">
                            <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">

                                <?php
                                    $strArray = explode('-', $data->level_status_text);
                                ?>

                                    @if($strArray[1] =="APPROVED")
                                        <span class="badge badge-success">{{$data->level_status_text}}</span>
                                    @elseif ($strArray[1] =="PENDING")
                                        <span class="badge badge-warning">{{$data->level_status_text}}</span>
                                    @elseif ($strArray[1] =="REJECTED")
                                        <span class="badge badge-danger">{{$data->level_status_text}}</span>
                                    @else
                                        <span class="badge badge-primary">{{$data->level_status_text}}</span>
                                    @endif
                            </a>
                        </td>

                        <td class="text-left">
                            <a href="{{$data->approval_for_link ? route($data->approval_for_link, json_decode($data->primary_key_value, true))  : ''}}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                            @if($key =="PR")
                                @php
                                    $pr_info = DB::table("inv_requisitionmst_po")->where('inv_requisition_po_no_pk', $data->primary_key_value)->first();

                                @endphp
                                @if(!empty(@$pr_info->pr_doc_attachment_path))
                                <a href="{{asset('images/uploads/attachment/'.@$pr_info->pr_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                @endif
                            @endif
                            @if($key =="PO")
                                @php
                                    $pr_info = DB::table("inv_purchaseorder_mst")->where('purchaseorder_no_pk', $data->primary_key_value)->first();

                                @endphp
                                @if(!empty(@$pr_info->pr_doc_attachment_path))
                                <a href="{{asset('images/uploads/attachment/'.@$pr_info->pr_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                @endif
                                @if(!empty(@$pr_info->po_doc_attachment_path))
                                <a href="{{asset('/images/uploads/attachment/'.@$pr_info->po_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                @endif
                            @endif


                        </td>
                        <td class="text-left">
                            {{-- <a href="{{ route('v1.edit-po-terms-conditions', $data->termscon_no_pk) }}"
                            class="btn btn-sm btn-success" title="Edit" ><i class="fas fa-edit"></i></a>
                            <span class="btn btn-sm btn-danger" data-id="{{ $data->termscon_no_pk }}" onclick="removeById(this)" data-url="{{ route('v1.delete-po-terms-conditions',$data->termscon_no_pk) }}" title="Delete"><i class="fas fa-trash"></i></span> --}}
                            {{-- <span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Room" title="Edit"><i class="fa fa-pencil-alt"></i></span> --}}

                            @if($app_status == 1)
                                <button @if($data->approved_ind == 1) disabled  @endif type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal" data-action="{{ route('v1.edit.my.approval.status',$data->apprprocess_no_pk.'*'.$data->approval_for_code) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Approve"  title="Approve">Approve</button>
                                <button @if($data->approved_ind == 1 || $strArray[1] == 'REJECTED') disabled  @endif type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal" data-action="{{ route('v1.reject.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Reject"  title="Reject">Reject</button>
                                <button @if($data->approved_ind == 1) disabled @elseif($data->hold_ind == 1)  disabled @endif type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.hold.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Hold"  title="Hold">Hold</button>

                                @if($data->approved_ind != 1 && $key !="PO")
                                @php
                                    $url_edit=$data->primary_key_value.'.'.$data->apprprocess_no_pk;


                                @endphp

                                <a href="{{$data->approval_for_edit_link ? route($data->approval_for_edit_link, $url_edit)  : ''}}" class="btn btn-sm btn-info" title="Edit" target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                            @endif
                            @endif
                        </td>
                    </tr>
                @else
                    @php
                            $check_status = explode('/', $data->level_status_text);
                    @endphp
                    @if ($check_status[0] >= $data->approval_sequnece -1)
                        <tr>
                            @if($item == 0)
                            <td style="vertical-align: top;" class="text-left" rowspan="{{ count($singleApprovalDataArray) }}">{{$key}}</td>
                            @endif
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{$data->primary_key_uid}}({{$data->primary_key_value}})</td>
                            <td class="text-left">{{$data->user_fullname_ent}}<br>{{$data->apprprocess_date}}</td>
                            @php
                                $startDatetime = $data->apprprocess_date;
                                if($data->approved_at != null){
                                    $endDatetime =  date('Y-m-d h:i:sa', strtotime($data->approved_at));
                                }else{
                                    $endDatetime = date("Y-m-d h:i:sa");
                                }

                                $starttimestamp = strtotime($startDatetime);
                                $endtimestamp = strtotime($endDatetime);
                                $hrDifference = abs($endtimestamp - $starttimestamp)/3600;
                                $dayDifference = abs($endtimestamp - $starttimestamp)/86400;
                                $differenceHrs = round($hrDifference);
                                $differenceDays = round($dayDifference);
                            //  dd($interval->format('%d') "days". $interval->format('%h')." Hours ".$interval->format('%i')." Minutes");
                            @endphp
                            <td class="text-left">{{$differenceDays <=0 ?  $differenceHrs. " hour(s)" : $differenceDays. " day(s)"}}</td>
                            <td class="text-left">
                                <a style="cursor:pointer" class="open-modal" data-action="{{ route('v1.my.approval.level.detail',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Level Detail"  title="Level Detail">

                                    <?php
                                        $strArray = explode('-', $data->level_status_text);
                                    ?>

                                        @if($strArray[1] =="APPROVED")
                                            <span class="badge badge-success">{{$data->level_status_text}}</span>
                                        @elseif ($strArray[1] =="PENDING")
                                            <span class="badge badge-warning">{{$data->level_status_text}}</span>
                                        @elseif ($strArray[1] =="REJECTED")
                                            <span class="badge badge-danger">{{$data->level_status_text}}</span>
                                        @else
                                            <span class="badge badge-primary">{{$data->level_status_text}}</span>
                                        @endif
                                </a>
                            </td>

                            <td class="text-left">
                                <a href="{{$data->approval_for_link ? route($data->approval_for_link, json_decode($data->primary_key_value, true))  : ''}}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                                @if($key =="PR")
                                    @php
                                        $pr_info = DB::table("inv_requisitionmst_po")->where('inv_requisition_po_no_pk', $data->primary_key_value)->first();

                                    @endphp
                                    @if(!empty(@$pr_info->pr_doc_attachment_path))
                                    <a href="{{asset('images/uploads/attachment/'.@$pr_info->pr_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                    @endif
                                @endif
                                @if($key =="PO")
                                    @php
                                        $pr_info = DB::table("inv_purchaseorder_mst")->where('purchaseorder_no_pk', $data->primary_key_value)->first();

                                    @endphp
                                    @if(!empty(@$pr_info->pr_doc_attachment_path))
                                    <a href="{{asset('images/uploads/attachment/'.@$pr_info->pr_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                    @endif
                                    @if(!empty(@$pr_info->po_doc_attachment_path))
                                    <a href="{{asset('/images/uploads/attachment/'.@$pr_info->po_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                    @endif
                                @endif


                            </td>
                            <td class="text-left">
                                {{-- <a href="{{ route('v1.edit-po-terms-conditions', $data->termscon_no_pk) }}"
                                class="btn btn-sm btn-success" title="Edit" ><i class="fas fa-edit"></i></a>
                                <span class="btn btn-sm btn-danger" data-id="{{ $data->termscon_no_pk }}" onclick="removeById(this)" data-url="{{ route('v1.delete-po-terms-conditions',$data->termscon_no_pk) }}" title="Delete"><i class="fas fa-trash"></i></span> --}}
                                {{-- <span Class="btn btn-sm btn-primary open-modal" data-id="'+ row[7] +'" data-action="'+edit_action+'" data-modal="common-modal-sm" data-title="Edit Room" title="Edit"><i class="fa fa-pencil-alt"></i></span> --}}

                                @if($app_status == 1)
                                    <button @if($data->approved_ind == 1) disabled  @endif type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal" data-action="{{ route('v1.edit.my.approval.status',$data->apprprocess_no_pk.'*'.$data->approval_for_code) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Approve"  title="Approve">Approve</button>
                                    <button @if($data->approved_ind == 1 || $strArray[1] == 'REJECTED') disabled  @endif type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal" data-action="{{ route('v1.reject.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Reject"  title="Reject">Reject</button>
                                    <button @if($data->approved_ind == 1) disabled @elseif($data->hold_ind == 1)  disabled @endif type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.hold.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Hold"  title="Hold">Hold</button>

                                    @if($data->approved_ind != 1 && $key !="PO")
                                    @php
                                        $url_edit=$data->primary_key_value.'.'.$data->apprprocess_no_pk;


                                    @endphp

                                    <a href="{{$data->approval_for_edit_link ? route($data->approval_for_edit_link, $url_edit)  : ''}}" class="btn btn-sm btn-info" title="Edit" target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach
        @endforeach
    @endif
</table>

<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>


<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
