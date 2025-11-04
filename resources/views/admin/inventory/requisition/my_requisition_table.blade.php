@php
$approval_ind = isset($approval_ind) ? $approval_ind : 0;

@endphp
<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table datatable table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center">
                            SL
                        </th>
                        <th class="text-center">Requistion No</th>
                        <th class="text-center">Requistion Date</th>
                        <th class="text-center">Requistion By</th>
                        <th class="text-center">Verified Status</th>
                        {{-- <th class="text-center">Status</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($my_requsition))
                        @foreach ($my_requsition as $indent)
                            <tr>
                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-center">
                                    {{ $indent->pur_requisition_uid }}</td>
                                <td class="text-left">
                                    {{ isset($indent->pur_requisition_date) ? date('d/m/Y', strtotime($indent->pur_requisition_date)) : '' }}
                                </td>
                                <td class="text-left">
                                    {{ $indent->req_name }}
                                </td>
                                <td class="text-center">
                                    @if ($indent->recommended_ind == 1)
                                        Requisition Approved
                                    @elseif ($indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->store_ind != 1)
                                        Approved By Hospital Director
                                    @elseif ($indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && $indent->direc__ind != 1)
                                        Approved By Director Admin
                                    @elseif ($indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->proc_ind != 1)
                                        Checked By Store
                                    @elseif ($indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->manager_acc_ind != 1)
                                        Approved By Procurement Dept.
                                    @elseif ($indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->manager_acc_ind == 1 && $indent->gen_man_ind != 1)
                                        Approved By Manager Accounts & Finance
                                    @elseif ($indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->manager_acc_ind == 1 && $indent->gen_man_ind == 1 && $indent->dir_acc_ind != 1)
                                        Approved By General Manager Admin & Procurement
                                    @elseif ($indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->manager_acc_ind == 1 && $indent->gen_man_ind == 1 && $indent->dir_acc_ind == 1)
                                        @php
                                            $req_sum = DB::select(DB::raw("select sum(approval_qty*rate) approval_sum from inv_purchase_requisitiondtl where pur_requisition_no_pk=$indent->pur_requisition_no_pk and is_stock_ok=0"));
                                        @endphp
                                        @if(intval($req_sum[0]->approval_sum) <= 1000000  && $indent->dir_acc_ind == 1)
                                            Requisition Approved
                                        @else
                                            Approved By Director Finance
                                        @endif
                                    @elseif ($indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && $indent->manager_acc_ind == 1 && $indent->gen_man_ind == 1 && $indent->chairman_ind == 1)
                                        Approved By Chairman
                                    @elseif ($indent->reviewed_ind == 1)
                                        @if (Session::get('user.inv_auth_admin_ind') == 1)
                                            Approved By Admin
                                        @else
                                            Approved By HOD
                                        @endif
                                    @elseif ($indent->req_ind == 1)
                                        Requested
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($approval_ind == 1)
                                        {{-- @if (($indent->direc_admin_ind != 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_director_admin_ind') == 1) || ($indent->direc__ind != 1)) --}}
                                        @if (($indent->direc_admin_ind != 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_director_admin_ind') == 1))
                                       
                                        <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                            rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        {{-- @elseif ($indent->direc__ind != 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_auth_director_ind') == 1) --}}
                                        @elseif ($indent->direc__ind != 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_auth_director_ind') == 1)
                                           
                                        <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                            rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        {{-- @elseif ($indent->store_ind != 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_store_ind') == 1) --}}
                                        @elseif ($indent->store_ind != 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_store_ind') == 1)
                                                
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>

                                        {{-- @elseif ($indent->proc_ind != 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_proc_ind') == 1) --}}
                                        @elseif ($indent->proc_ind != 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_proc_ind') == 1)
                                                    
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        {{-- @elseif ($indent->manager_acc_ind !=1 && $indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_manager_acc_ind') == 1) --}}
                                        {{-- @elseif ($indent->manager_acc_ind !=1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_manager_acc_ind') == 1) --}}
                                        @elseif ($indent->manager_acc_ind !=1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_manager_acc_ind') == 1)
                                                    
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>

                                        {{-- @elseif ($indent->gen_man_ind !=1 && $indent->manager_acc_ind ==1 && $indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_gen_man_proc_ind') == 1) --}}
                                        {{-- @elseif ($indent->gen_man_ind !=1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_gen_man_proc_ind') == 1) --}}
                                        @elseif ($indent->gen_man_ind !=1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && Session::get('user.inv_gen_man_proc_ind') == 1)
                                                    
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>

                                        {{-- @elseif ($indent->gen_man_ind ==1 && $indent->manager_acc_ind ==1 && $indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->direc_admin_ind == 1 && $indent->reviewed_ind == 1 && (Session::get('user.inv_director_acc_ind') == 1 || Session::get('user.inv_auth_chairman_ind') == 1)) --}}
                                        @elseif ($indent->gen_man_ind ==1 && $indent->manager_acc_ind ==1 && $indent->proc_ind == 1 && $indent->store_ind == 1 && $indent->direc__ind == 1 && $indent->reviewed_ind == 1 && (Session::get('user.inv_director_acc_ind') == 1 || Session::get('user.inv_auth_chairman_ind') == 1))
                                                
                                                @php
                                                    $req_sum = DB::select(DB::raw("select sum(approval_qty*rate) approval_sum from inv_purchase_requisitiondtl where pur_requisition_no_pk=$indent->pur_requisition_no_pk and is_stock_ok=0"));
                                                @endphp

                                                @if(intval($req_sum[0]->approval_sum) <= 1000000  && Session::get('user.inv_director_acc_ind') == 1 && $indent->dir_acc_ind != 1)
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                                @endif

                                                @if(intval($req_sum[0]->approval_sum) > 1000000  && Session::get('user.inv_auth_chairman_ind') == 1 && $indent->chairman_ind != 1)
                                                <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                    rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                        class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                                @endif

                                        
                                        @elseif ($indent->reviewed_ind != 1 && Session::get('user.inv_hod_ind') == 1)
                                        
                                        <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                            rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        {{-- @else
                                            @php
                                                $req_sum = DB::select(DB::raw("select sum(approval_qty*rate) approval_sum from inv_purchase_requisitiondtl where pur_requisition_no_pk=$indent->pur_requisition_no_pk and is_stock_ok=0"));
                                            @endphp
                                            @if(intval($req_sum[0]->approval_sum) <= 1000000  && Session::get('user.inv_director_acc_ind') == 1)
                                            <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                    class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                            @endif

                                            @if(intval($req_sum[0]->approval_sum) > 1000000  && Session::get('user.inv_auth_chairman_ind') == 1)
                                            <a href="{{ route('inv-requisition-approval.edit', $indent->pur_requisition_no_pk) }}"
                                                rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                    class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                            @endif --}}
                                        @endif
                                        
                                    @else
                                        @if($indent->reviewed_ind != 1)
                                        <a href="{{ route('inventory-purchase-requisition.edit', $indent->pur_requisition_no_pk) }}"
                                            rel="tab" class="btn btn-sm btn-info" title="Edit"><i
                                                class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                                        @endif
                                    @endif
                                    <a target="_blank"
                                        href="{{ route('inv-purchase-requestion-print', $indent->pur_requisition_no_pk) }}"
                                        class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
