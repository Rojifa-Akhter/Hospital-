 <!-- Modal -->
 <div class="row">
    <div class="col-12">
        <h6><strong>Admission No:</strong> {{$patient_info->admission_no_pk}}</h6>
        <h6><strong>Patient Name:</strong> {{$patient_info->patient_name}}</h6>
    </div>

    <div class="col-12">
        <form action="#" method="post" id="medicine_return_receive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center" style="width: 5%">SL</th>
                        <th class="text-center" style="width: 17%">Indent No</th>
                        <th class="text-center" style="width: 38%">Name</th>
                        <th class="text-center" style="width: 20%">Dose</th>
                        <th class="text-center" style="width: 15%">Qty</th>
                        <th class="text-center" style="width: 5%">
                            <div style="display: flex;justify-content:center">
                                <div class="mt-1"> <input type="checkbox" name="checked_all" id="checked_all" value="1" class="form-control form-control-sm" onclick="checkedAll()"/></div>
                                <div><label class="form-check-label" for="checked_all">&nbsp;All</label></div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                        @forelse ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-left">{{ $item->med_req_id }}</td>
                                <td class="text-left">{{ $item->brand_name }}</td>
                                <td class="text-left">{{$item->dosage}}</td>
                                <td class="text-center">{{ $item->mr_qty }}</td>
                                <td class="text-center"><input type="checkbox" class="all" name="return_receive[]" value="{{$item->patmedtran_no_pk}}"></td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">Data Not Found</td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="text-center">
    <button type="button" class="btn btn-danger mt-3" data-dismiss="modal" id="patient_wise_medicine_return_modal">Close</button>
    <button type="button" class="btn btn-success mt-3" onclick="returnReceiveMedicine()">Save</button>
</div>

<script>

function checkedAll(){
        if($("#checked_all").is(":checked")){
            $(".all").prop('checked', true);
        }
        else{
            $(".all").prop('checked', false);
        }
    }

    // function returnReceiveMedicine() {
    //     let formElement = document.querySelector('#medicine_return_receive');
    //     let formData = new FormData(formElement);
    //     console.log(formData);
    //     // return false;
        
    //         $.ajax({
    //             url: "{{ route('v2.ipd.medicine-return-receive') }}",
    //             method: "post",
    //             dataType:"json",
    //             data:formData,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             beforeSend: function() {
    //                 blockUI();
    //             },
    //             success: function(response){
    //                 $("#patient_wise_medicine_return_modal").click();
    //                 getMedcineReturn();
    //                 $('.common-modal-notify').modal('show');
    //                 $('.common-modal-notify .modal-title').html('Success');
    //                 $('.common-modal-notify .modal-body').html(response.message);
    //             },
    //             error:function(err){
    //                 var error = err.responseJSON;
    //                 $('.common-modal-notify-error').modal('show');
    //                 $('.common-modal-notify-error .modal-title').html('Failed');
    //                 $('.common-modal-notify-error .modal-body').html(error.message);
    //             },
    //             complete: function() {
    //                 $.unblockUI();
    //             }
    //         })
    // }
    
    function returnReceiveMedicine() {
        let formElement = document.querySelector('#medicine_return_receive');
        let formData = new FormData(formElement);
        console.log(formData);
        // return false;
        
            $.ajax({
                url: "{{ route('v2.ipd.medicine-return-receive') }}",
                method: "post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(response){
                    $("#patient_wise_medicine_return_modal").click();
                    $("#receive-return").click();
                    // getMedcineReturn();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html('Success');
                    $('.common-modal-notify .modal-body').html(response.message);
                    
                },
                error:function(err){
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                    $.unblockUI();
                },
                complete: function() {
                    $.unblockUI();
                }
            })
    }
</script>
