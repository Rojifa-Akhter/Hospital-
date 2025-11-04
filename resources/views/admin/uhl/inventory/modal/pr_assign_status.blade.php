 <!-- Modal -->

    <div class="row">
        <div class="col-6">
            <h6><strong>PR No:</strong> {{@$inv_requisition_po_no_fk}}</h6>
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-center" style="width: 15%">Date</th> 
                        <th class="text-left" style="width: 22%">Assigned To</th> 
                        <th class="text-left" style="width: 24%">Name</th>
                        <th class="text-center" style="width: 13%">Revoke</th> 
                        <th class="text-center" style="width: 13%">PO Status</th> 
                        <th class="text-center" style="width: 18%">Assign PDF</th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($available_item as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{date('d/m/Y',strtotime($item->assign_at))}}</td>
                                <td class="text-left"> {{ $item->emp_name}}</td>
                                <td class="text-left">{{$item->item_name}}</td> 
                                <td class="text-center">
                                     @if(($item->revoked_ind) == 1)
                                        <span class="badge badge-success">Yes</span>
                                     @else
                                        <span class="badge badge-danger">No</span>
                                     @endif
                                    </td>
                                <td class="text-center"> 
                                    @if(($item->po_ind) == 1)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-danger">No</span>
                                    @endif 
                                </td>
                                <td class="text-center"><a href="{{ route('v2.assigned-pr-pdf', $item->prassignmst_no_pk) }}" target="_blank" class="btn btn-sm btn-info" Title="Assigned PR"><i class="fas fa-print"></i></a></td>

                            </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>


