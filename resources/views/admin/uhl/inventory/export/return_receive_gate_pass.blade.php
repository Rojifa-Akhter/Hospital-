

<style>
    table{
        border-collapse: collapse;
    }
    table td {
        font-size: 13px;
        padding-right:3px;
        border:1px solid #B4B5B6;
    }
    @media (min-width: 1600px){
        .table td, .table th {
            font-size: 13px !important;
        }
    }
     .table th {
        font-size: 13px !important;
        border:1px solid #B4B5B6;
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    td{
        text-align: center;
        padding: 2px auto;
    }
    .expired{
        background-color: #FFED4A !important;
    }
</style>
    @php
        $expired = false;
    @endphp
    <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
    <h5 style="margin-top: 10px; text-align:center; margin-bottom:0px" >Return Receive Gate Pass List</h5>            
    <div style="text-align:center;">
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("m/d/Y",strtotime(@$from_date))}}, To Date: {{date("m/d/Y",strtotime(@$to_date))}}</h6>
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><span style="font-style:italic;"><b></b>
           <b> Return Status: </b>{{$status  == 0 ? 'Pending' : 'Received'}}
        </span></h6>
    </div>

    <table class="table" style="width: 100%;" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center">SL No</th>
                <th class="text-center" style="white-space: nowrap">Department</th>
                <th class="text-center">GID</th>
                {{-- <th class="text-center">Day</th> --}}
                <th class="text-center">Date</th>
                <th class="text-center">Issued By</th>
                <th class="text-center">Issue To</th>
                <th class="text-center">Issue Date</th>
                <th class="text-center">Return Date</th>
                <th class="text-center">Purpose/Problem</th>
                <th class="text-center">Supplier Name</th>
                <th class="text-center">OneTime</th>
                <th class="text-center">No of Item</th>
                <th class="text-center">Status</th>
                <th class="text-center">Approval Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($data as $key => $value)
            @php
                $currentDate = new DateTime();  
                $return_date = new DateTime($value->return_date); 
                if($return_date < $currentDate && $value->rcv_ind == 0){
                    $expired = true;
                }
                else{
                    $expired = false;  
                }
            @endphp
            <tr class="{{ $expired ? 'expired' : '' }}">
                <td class="{{ $expired ? 'expired' : '' }}">{{ $loop->iteration }}</td>
                <td class="text-left">{{ isset($value->department) ? $value->department : '' }}</td>
                <td class="text-center">{{ $value->gatepass_uid }}</td>
                {{-- <td class="text-center">{{ abs(floor($value->day_difference)) }} Days @if($value->day_difference < 0) {{" Due"}} @else {{' Left'}} @endif</td> --}}
                <td>{{ $value->gatepass_date != '' ? date('m/d/Y', strtotime($value->gatepass_date)) : '' }}</td>
                <td>{{ $value->emp_name }}</td>
                <td>{{ $value->issued_to_name }}</td>
                <td>{{ $value->issue_date != '' ? date('m/d/Y', strtotime($value->issue_date)) : '' }}</td>
                <td>{{ $value->return_date != '' ? date('m/d/Y', strtotime($value->return_date)) : '' }}</td>
                <td>{{ $value->gatepass_purpose_short }}</td>
                <td>{{ $value->vendor_supplier_name }}</td>

                <td class="text-center">
                    @if ($value->onetime_use_ind == 1)
                        <i class="fas fa-check"></i>
                    @endif
                </td>
                <td class="text-center">{{ $value->item_count }} </td>
                <td class="text-center">{{ $value->rcv_ind == 1 ? 'Received' : 'Pending' }} </td>
                <td class="text-center">
                    @php
                        $status = 'Approval Not Found';
                        $approval_exp = $value->approval_level_status_text != '' ? explode('/', $value->approval_level_status_text) : '';
                        $status_pending = strpos($value->approval_status_text, 'PENDING') >= 1;
                        
                        if (strpos($value->approval_status_text, 'APPROVED') >= 1) {
                            $status = 'APPROVED';
                        }
                        if (strpos($value->approval_status_text, 'PENDING') >= 1) {
                            $status = 'PENDING';
                        }
                        if (strpos($value->approval_status_text, 'REJECTED') >= 1) {
                            $status = 'REJECTED';
                        }
                        if (strpos($value->approval_status_text, 'HOLD') >= 1) {
                            $status = 'HOLD';
                        }
                        
                    @endphp
                    {{ $status }}
                </td>
            </tr>
            @empty
                
            @endforelse                                                                                                                                            
        </tbody>
    </table>