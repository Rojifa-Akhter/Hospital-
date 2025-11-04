 <!-- Modal -->
 <form action="{{route('v2.revoked-partial-pr-employee')}}" method="post" id="payPartialBillPayment" class="updateAccountsSubGroup">
    @csrf
    <div class="row">
        <div class="col-6">
            <h6><strong>PR No:</strong> {{@$available_item[0]->inv_requisition_po_no_fk}}</h6>
        </div>
        <div class="col-12">
            <h6><strong>Available Item Show</strong></h6>
            <input type="hidden" name="inv_requisition_po_no_fk" id="inv_requisition_po_no_fk" value="{{@$available_item[0]->inv_requisition_po_no_fk}}">
            <input type="hidden" name="assign_by" id="assign_by" value="{{@$available_item[0]->assign_by}}">
            <input type="hidden" name="prassignmst_no_pk" id="prassignmst_no_pk" value="{{$prassignmst_no_pk}}">
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-left" style="width: 65%">Name</th>
                        <th class="text-center" style="width: 30%">Revoke</th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($available_item as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left">{{$item->item_name}}</td> 
                                <td class="text-center"><input type="checkbox" name="prassigndtl_no_pk[]" id="prassigndtl_no_pk{{$key}}" value="{{$item->prassigndtl_no_pk}}"></td> 
                            </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        @php
            $redirect_url = route('v2.pr-assign');
            $currentRouteName = Route::currentRouteName();
        @endphp
        @if(count($available_item) > 0)
            <button type="button" class="btn btn-primary uhl_save_btn mt-3" onclick="btnSaveUpdate(this,'','','','',searchPR,'{{ $redirect_url }}')">Revoke</button>
        @endif
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
 </form>

