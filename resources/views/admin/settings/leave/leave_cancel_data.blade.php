    <div class="card-body">
        <div class="form-row">
            <div id="search-result" class="col-12 table-responsive">
                <table id="data-table"
                class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-left">Leave Name</th>
                        <th class="text-center">Date</th>                       
                        <th class="text-left">Reason</th>
                        <th class="text-left">Leave Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($leave_cancel))
                    @foreach ($leave_cancel as $element)
                    <tr id="{{$element->leavedtl_no_pk}}">
                        <td class="text-left">{{ $element->lookupdata_name }}</td>                              
                        <td class="text-left">{{date('d/m/Y',strtotime($element->leave_dates)) }}</td>
                        <td class="text-left">{{ $element->leave_reason }}</td>
                        <td class="text-left">{{ ($element->leave_status == 1)? 'Active' : 'Inactive' }}</td>
                        <td class="text-center"> 

                            @php
                            $response_action = route('leave.index');
                            @endphp
                            <div class="col-md-3 ">                                   
                                <input type="hidden" id="leave_delete" class="leave_delete" name="" value="{{$element->leavedtl_no_pk}}">
                                <span  class="badge badge-md badge-danger leave_delete_btn  p-1 mb-1 cursor-pointer"   title="leave delete"><i class="far fa-trash-alt" id="leave_delete_btn"></i></span> 
                            </div>

                        </td>
                    </tr>

                    @endforeach
                    @endif

                </tbody>                    
            </table>
            <button  class="btn btn-md btn-danger float-right mt-2"  data-dismiss="modal"  title="Cancel">Close</button>
        </div>
    </div>
</div>


