<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table  table-bordered">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-left" >Task</th>
            <th class="text-center" >Sl#</th>
            <th class="text-left" >ID</th>
            <th class="text-left" >Created By At</th>
            <th class="text-left" >Waiting</th>
            <th class="text-left" >Status</th>
            <th class="text-left" >PDF</th>
            <th class="text-left" >Action</th>
            <th class="text-left" style="width: 200px;">Remarks</th>
        </tr>
    </thead>

    @if(isset($approvalDataArray))
        @foreach ($approvalDataArray as $key => $singleApprovalDataArray)
            @foreach ($singleApprovalDataArray as $item => $data)
                @inject('app_status','App\Http\Controllers\HOSApprovalMatrixController')
                @php
                    $approval_status = $app_status->check_approval_status($data->primary_key_value,$data->approval_for_code);
                    $reject_status=strpos($approval_status->pluck('reject_ind')->implode(', '),'1') ;
                    $hold_status=strpos($approval_status->pluck('hold_ind')->implode(', '),'1') ;
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

                
                <!-- if($key=="GATEPASS"){ dd($reject_status,$hold_status,$approval_status->pluck('reject_ind')->implode(', ') ,$approval_status->pluck('hold_ind')->implode(', '),$approval_status);} -->
                @if($app_status == 1)
                    <tr>
                  
                        {{-- @if($item == 0) --}}
                        {{-- rowspan="{{ count($singleApprovalDataArray) }}" --}}
                        <td style="vertical-align: top;" class="text-left" >{{$key}}</td>
                        {{-- @endif --}}
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
                                  $strArray = explode('-', $data->level_status_text); ?>
                  
                                    @if($strArray[1] =="APPROVED" )
                                        @if($reject_status ===false && $hold_status ===false)
                                        <span class="badge badge-success">{{$data->level_status_text }}</span>
                                        @elseif($reject_status ===0 && $hold_status ===false)
                                        <span class="badge badge-danger">{{explode('-',$data->level_status_text)[0]}} - REJECTED</span>
                                        @elseif($reject_status ===false && $hold_status ===0)
                                        <span class="badge badge-danger">{{explode('-',$data->level_status_text)[0]}} -  HOLD</span>
                                        @endif
                                    @elseif ($strArray[1] =="PENDING")
                                        <span class="badge badge-warning">{{$data->level_status_text }}</span>
                                    @elseif ($strArray[1] =="REJECTED")
                                        <span class="badge badge-danger">{{$data->level_status_text}}</span>
                                    @elseif ($strArray[1] =="HOLD")
                                        <span class="badge badge-danger">{{$data->level_status_text}}</span>
                                    @else
                                        <span class="badge badge-primary">{{$data->level_status_text}}</span>
                                    @endif
                            </a> 
                        </td>

                        <td class="text-left" style="white-space: nowrap">
                            @if($key =="LEAVEAPP")
                            <a href="{{ route('v1.hrm.leave_report_for_approval', $data->au_entry_by) }}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                            @elseif ($key == "ATTNREQ")
                            <a href="{{ route('v1.hrm.attendance_request_report_for_approval', $data->apprprocess_no_pk) }}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                            @elseif ($key == "IOUEX")
                            <a href="{{ route('expense_memo_report', $data->primary_key_value) }}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                         
                            @else
                            @if($data->approval_for_link !="")
                            <a href="{{$data->approval_for_link ? route($data->approval_for_link, json_decode($data->primary_key_value, true))  : ''}}" class="btn btn-outline-primary btn-sm bg-none" target="_blank"  title="">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                             @if($key =="PO" && $ses_hospital_code != "KPJ" )
                                <a href="{{ $data->approval_for_link ? route('v2.purchase-order-print', [
                                    'purchase_order_id' => $data->primary_key_value,
                                    'showWithHeader' => 'true'
                                    ]) : '#' }}" 
                                class="btn btn-outline-primary btn-sm bg-none" 
                                target="_blank"  
                                title="Generate PDF">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                            @endif
                            
                            @if($key == "CONVEYANCE")
                                @php
                                    $conv = DB::table('acct_conveyancebilldtl')
                                            ->select('attachment_name_01', 'attachment_name_02')
                                            ->where('conveyancebillmst_no_fk', '=', $data->primary_key_value)
                                            ->first();
                                @endphp 

                                @if(isset($conv) && !empty($conv->attachment_name_01))
                                    <a href="{{ asset('uploads/conveyance_bill/' . $conv->attachment_name_01) }}" target="_blank">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                    </a>
                                @endif
                                @if(isset($conv) && !empty($conv->attachment_name_02))
                                    <a href="{{ asset('uploads/conveyance_bill/' . $conv->attachment_name_02) }}" target="_blank">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                    </a>
                                @endif
                            @endif

                            @endif
                            @endif

                            @if($key =="LEAVEAPP")
                            @php
                                $leave_attachment = DB::table("hrms_leave_entry")->where('leave_no_pk', $data->primary_key_value)->first();
                            @endphp
                            
                            @if(!empty(@$leave_attachment->leave_attch))
                            <a href="{{asset('uploads/leave_file/'.@$leave_attachment->leave_attch)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                            @endif
                           @endif

                            @if($key =="PR")
                                @php
                                    $pr_info = DB::table("inv_requisitionmst_po")->where('inv_requisition_po_no_pk', $data->primary_key_value)->first();

                                @endphp
                                @if(!empty(@$pr_info->pr_doc_attachment_path))
                                <a href="{{asset('images/uploads/attachment/'.@$pr_info->pr_doc_attachment_path)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                @endif
                            @endif
                            @if( $key == "WORKORDER" || $key == "WORKORDERBILL")
                                @php
                                    $con_info = DB::table("cons_workordermst")->where('workordermst_no_pk', $data->primary_key_value)->first();

                                @endphp
                                @if(!empty(@$con_info->att_doc) && $key != "WORKORDERBILL")
                                <a href="{{asset('uploads/construction/'.@$con_info->att_doc)}}" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-file"></i></a>
                                @endif


                                @if(@$key == "WORKORDERBILL")

                                @php $con_info = DB::table("CONS_WORKORDERBILL")->where('WORKORDERBILL_NO_PK', $data->primary_key_value)->select('workordermst_no_fk')->first(); @endphp


                                    <a href="{{route('construction.show-work-order', $con_info->workordermst_no_fk)}}" class="btn btn-outline-success btn-sm bg-none" target="_blank"  title="Work order pdf">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
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
                         
                                <button @if(($data->approved_ind == 1 || $data->reject_ind == 1 || $data->hold_ind == 1) && $hold_status != 3) disabled  @endif type="button" class="btn btn-md btn-outline-success mb-1 mt-1 open-modal" data-action="{{ route('v1.edit.my.approval.status',$data->apprprocess_no_pk.'*'.$data->approval_for_code) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Approve"  title="Approve">Approve</button>
                                <button @if($data->approved_ind == 1 || $strArray[1] == 'REJECTED' || $data->hold_ind == 1) disabled  @endif type="button" class="btn btn-md btn-danger mb-1 mt-1 open-modal" data-action="{{ route('v1.reject.my.approval.status',[$data->apprprocess_no_pk, $data->approval_for_code]) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Reject"  title="Reject">Reject</button>

                                @if($data->hold_ind != 1)
                                    <button 
                                        @if($data->approved_ind == 1  || $data->reject_ind == 1) 
                                            disabled 
                                        {{-- @elseif($data->hold_ind == 1) 
                                            disabled  --}}
                                        @endif 
                                        type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.hold.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Hold"  title="Hold">Hold</button>
                                @elseif($data->hold_ind == 1)
                                    <button type="button" class="btn btn-md btn-warning mb-1 mt-1 open-modal" data-action="{{ route('v1.unHold.my.approval.status',$data->apprprocess_no_pk) }}" data-id="{{ $data->apprprocess_no_pk }}" data-modal="common-modal-sm" data-title="Unhold" title="Unhold">Unhold</button>
                                @endif
                                
                                @if($data->approved_ind != 1 )
                                    @php
                                    if ($key =="PO") {
                                        $url_edit=$data->primary_key_value;
                                    }else{
                                        $url_edit=$key =="PR" ? $data->primary_key_value.'/'.'0' : $data->primary_key_value.'.'.$data->apprprocess_no_pk;
                                    }
                                        
                                    @endphp
                                     <a href="{{$data->approval_for_edit_link ? route($data->approval_for_edit_link, $url_edit)  : ''}}" class="btn btn-sm btn-info" title="Edit" target="_blank" style="@if($data->reject_ind == 1) pointer-events: none; @endif"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                @endif
                           
                        </td>
                        <td style="white-space: break-word;" class="text-left">
                            {{isset($data->remarks) ? $data->remarks :''}}
                        </td>
                    </tr>
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
