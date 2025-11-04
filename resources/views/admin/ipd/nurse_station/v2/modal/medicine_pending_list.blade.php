 <!-- Modal -->

 <form action="{{route('v2.ipd.medicine-approve-request')}}" method="post" id="payPartialBillPayment" class="updateAccountsSubGroup">
    @csrf
    <div class="row">
        <div class="col-6">
            <h6><strong>Admission No:</strong> {{$patient_info->admission_no_pk}}</h6>
            <h6><strong>Patient Name:</strong> {{$patient_info->patient_name}}</h6>
        </div>
        <div class="col-6">
            <h6 class="text-right"><strong>Prescription No: </strong>{{$patient_info->prescription_no_pk}}</h6>
            <h6 class="text-right"><strong>Prescription UHID:</strong> {{$patient_info->prescription_uid}}</h6>
        </div>
        <div class="col-12">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-left" style="width: 38%">Name</th>
                        <th class="text-left" style="width: 15%">Dose</th>
                        <th class="text-left" style="width: 25%">Instruction</th> 
                        <th class="text-center" style="width: 17%">Approve</th> 
                    </tr>
                </thead>
                <tbody>
                    
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left">{{$item->brand_name}}</td>
                                <td class="text-left">{{$item->dosage}}</td>
                                <td class="text-left">{{$item->instruction_take}}</td> 
                                <td class="text-center"><input type="checkbox" name="approve_ind[]" id="approve_ind{{$key}}" value="{{$item->prescription_med_no_pk}}" {{$item->approve_ind == 1 ? 'checked disabled' : ''}}></td> 
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse                          
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        @php
            $redirect_url = route('v2.ipd.medicine-approval');
            $currentRouteName = Route::currentRouteName();
        @endphp
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3" onclick="btnSaveUpdate(this,'','','','',getPendingMedicine,'{{ $redirect_url }}')">Approve</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
 </form>

