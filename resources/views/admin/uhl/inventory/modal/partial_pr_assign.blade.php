 <!-- Modal -->
 <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
 <form action="{{route('v2.assign-partial-pr-employee')}}" method="post" id="payPartialBillPayment" class="updateAccountsSubGroup">
    @csrf
    <div class="row">
        <div class="col-6">
            <h6><strong>PR No:</strong> {{$pr_id}}</h6>
        </div>
        

        <div class="col-12">
            <div class="row py-2 justify-content-center" id="employee_field">
                <div class="col-4">
                    <label for="" class="float-end">Assign To</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm w-100" title="Type Employee Name" name="emp_name_modal" id="emp_name_modal" placeholder="Employee Name" />
                    <input type="hidden" name="emp_id_modal" id="emp_id_modal">
                </div>
            </div>
        
        
            <div class="text-right">
                @php
                    $redirect_url = route('v2.pr-assign');
                    $currentRouteName = Route::currentRouteName();
                @endphp
                <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary uhl_save_btn mt-3" onclick="btnSaveUpdate(this,'','','','',searchPR,'{{ $redirect_url }}')">Assign</button>
            </div>
        </div>
        <div class="col-12">
            <h6><strong>Available Item Show</strong></h6>
            <input type="hidden" name="inv_requisition_po_no_fk" id="inv_requisition_po_no_fk" value="{{$pr_id}}">
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-left" style="width: 70%">Name</th>
                        <th class="text-center" style="width: 5%">UOM</th>
                        <th class="text-center" style="width: 10%">Qty</th>
                        <th class="text-center" style="width: 10%;white-space:nowrap">
                            <div class="d-flex justify-content-center">
                                <div>Assign(</div>
                                <div>
                                    <div class="form-check">
                                        <label class="form-check-label" for="selectAll">
                                        <input type="checkbox" class="form-check-input" id="selectAll" value="1" onclick="checkedAll()">All)
                                        </label>
                                    </div>
                                </div>
                            </div>
                                
                            
                        </th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($available_item as $key => $item)
                           
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left">{{$item->item_name}}</td> 
                                <td class="text-center">{{$item->sales_uom}}</td> 
                                <td class="text-center">{{$item->req_quantity}}</td> 
                                {{-- 'req.sales_uom','req.req_quantity' --}}
                                <td class="text-center"><input type="checkbox" class="all" onclick="checkedAllChecked()" name="inv_requisitiondtl_po_no_pk[]" id="inv_requisitiondtl_po_no_pk{{$key}}" value="{{$item->inv_requisitiondtl_po_no_pk}}"></td> 
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

    
 </form>
 <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
 <script> 
    $(document).ready(function(){
        openDoctorAutocomplete('#emp_name_modal', 'emp_id_modal', "employee_ind", 1);
    })

    function checkedAll(val){
        if($("#selectAll").is(":checked")){
            $('.all').prop('checked', true);
        }
        else
        {
            $('.all').prop('checked', false);
        }
    }
    function checkedAllChecked(){
        $('#selectAll').prop('checked', false);
    }
 </script>

