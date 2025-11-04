 <!-- Modal -->
 <div class="row">
    <div class="col-12">
        <h6><strong>Admission No:</strong> {{$patient_info->admission_no_pk}}</h6>
        <h6><strong>Patient Name:</strong> {{$patient_info->patient_name}}</h6>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered table-hover">
            <thead class="global-uhl-table-bg">
                <tr>
                    <th class="text-center" style="width: 5%">SL</th>
                    <th class="text-center" style="width: 15%">Indent No</th> 
                    <th class="text-left" style="width: 17%">Generic Name</th>
                    <th class="text-left" style="width: 23%">Name</th>
                    <th class="text-center" style="width: 20%">Dose</th>
                    <th class="text-center" style="width: 15%">Qty</th> 
                    <th class="text-center" style="width: 5%">Action</th> 
                </tr>
            </thead>
            <tbody>
                    @forelse ($data as $key => $item)
                        <tr>
                            <td class="text-center">{{++$key}}</td>
                            <td class="text-center">{{ $item->med_req_id }}</td>
                            <td class="text-left">{{ $item->generic_name }}</td>
                            <td class="text-left">{{ $item->brand_name }}</td>
                            <td class="text-center">{{$item->dosage}}</td>
                            <td class="text-center">{{ $item->mr_qty }}</td>
                            <td class="text-center">
                                
                                @if(!empty($item->invoice_no_fk) && !empty($item->ledgertrn_no_fk)) 
                                    <a class="btn btn-sm btn-primary text-white" style="cursor:pointer" href="{{ route('pos-due-invoice-print',$item->invoice_no_fk, $item->ledgertrn_no_fk) }}" target="_blank" title="Invoice">
                                        <i class="fa fa-file text-white"></i>
                                    </a>
                                @endif
                            
                            </td> 
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
    <button type="button" class="btn btn-danger mt-3" data-dismiss="modal" id="patient_wise_medicine_return_modal">Close</button>
</div>

<script>
    function returnReceiveMedicine(id) {
            $.ajax({
                url: "{{ route('v2.ipd.medicine-return-receive') }}",
                method: "post",
                data:{id: id},
                beforeSend: function() {
                        blockUI();
                },
                success: function(response){
                    $("#patient_wise_medicine_return_modal").click();
                    getMedcineReturn();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html('Success');
                    $('.common-modal-notify .modal-body').html(response.message); 
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message); 
                },
                complete: function() {
                    $.unblockUI();
                }
            })
        }
</script>
