<div class="card-body mt-3">
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table data-table table-striped table-bordered table-hover">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Indent No</th>
                        <th class="text-center">Indent Date</th>
                        <th class="text-center">Indent By</th>
                        <th class="text-center">Store Name</th>
                        <th class="text-center">No of Item</th>
                        <th class="text-center">No of Received Item</th>
                        <th class="text-center">Verified Status</th>
                        {{-- <th class="text-center">Status</th> --}}
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indents as $indent)
                        @php
                            $badgeStatus = '';
                            switch ($indent->req_ind_text) {
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
                            
                            $indent_items = \DB::table('phr_requisition_item_vw')
                                ->where('inv_requisition_no_fk', $indent->inv_requisition_uid)
                                ->get();
                            //dd($indent_items);
                            $total_hod_approval = $indent_items->where('aproval_hod_ind', 1)->count();
                            $total_hod_reject = $indent_items->where('aproval_hod_ind', 2)->count();
                            $total_admin_approval = $indent_items->where('aproval_diradm_ind', 1)->count();
                            $total_admin_reject = $indent_items->where('aproval_diradm_ind', 2)->count();
                            $total_director_approval = $indent_items->where('aproval_dirhospital_ind', 1)->count();
                            $total_director_reject = $indent_items->where('aproval_dirhospital_ind', 2)->count();
                            $total_chairman_approval = $indent_items->where('aproval_md_chairman_ind', 1)->count();
                            $total_chairman_reject = $indent_items->where('aproval_md_chairman_ind', 2)->count();
                            
                        @endphp
                        <tr>
                            <td class="text-center" width="8%">{{ $loop->iteration }}</td>
                            <td class="text-center" width="8%">{{ $indent->inv_requisition_uid }}</td>
                            <td class="text-center" width="11%">
                                {{ date('Y-m-d', strtotime($indent->inv_requisition_date)) }}</td>
                            <td class="text-center" width="13%">{{ $indent->req_by_name }}</td>
                            <td class="text-center" width="13%">{{ $indent->from_store_name }}</td>
                            <td class="text-center" width="11%">{{ $indent->no_of_item }}</td>
                            <td class="text-center" width="11%">{{ $indent->no_of_received_item }}</td>
                            <td class="text-right" width="16%">


                                <strong>HOD</strong> Approved&nbsp;<span
                                    class="badge badge-success">{{ $total_hod_approval }}</span>
                                Rejected&nbsp;<span class="badge badge-danger">{{ $total_hod_reject }}</span>
                                <br>
                                <strong>Admin</strong> Approved&nbsp;<span
                                    class="badge badge-success">{{ $total_admin_approval }}</span>
                                Rejected&nbsp;<span class="badge badge-danger">{{ $total_admin_reject }}</span>
                                <br>
                                <strong>Director</strong> Approved&nbsp;<span
                                    class="badge badge-success">{{ $total_director_approval }}</span>
                                Rejected&nbsp;<span class="badge badge-danger">{{ $total_director_reject }}</span>
                                <br>
                                <strong>Chairman</strong> Approved&nbsp;<span
                                    class="badge badge-success">{{ $total_chairman_approval }}</span>
                                Rejected&nbsp;<span class="badge badge-danger">{{ $total_chairman_reject }}</span>








                            </td>
                            {{-- <td class="text-center" width="11%"><span class="badge badge-warning">{{ $indent->req_ind_text }}</span></td> --}}

                            <td class="text-center" width="11%">
                                <span Class="btn btn-sm btn-success open-modal"
                                    data-action="{{ route('indent_item_details', $indent->inv_requisition_uid) }}"
                                    data-modal="common-modal-md" data-title="Indent Item Details" title="view"><i
                                        class="fa fa-eye"></i></span>

                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
