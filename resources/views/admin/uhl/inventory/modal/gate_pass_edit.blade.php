 <!-- Modal -->
 <form action="{{route('v1.returnable-gate-pass-receive')}}" method="post" id="GatePassReceive" class="GatePassReceive">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Receive Status<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm" id="status" name="status"  value="" >
                        {{-- <option value="0" >Pending</option> --}}
                        <option value="1" selected>Received</option>
                    </select>
                    <input type="hidden" value="{{$data->gatepass_no_pk}}" name="gatepass_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="receive_date" class="col-sm-4 col-form-label">Received Date<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" value="" name="receive_date" class="datepickerModal form-control form-control-sm">
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Remarks</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->rcv_remarks}}" placeholder="Remarks" cols="5" rows="5">{{$data->rcv_remarks}}</textarea>
                </div>
            </div>
        </div>



    </div>

    @php
        $redirect_url = route('v1.returnable-gate-pass-worklist');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getPassReturnableForm,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {

        var currentDates = new Date();
        $(".datepickerModal").datepicker({
            todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'mm/dd/yyyy',
        }).datepicker('setDate', currentDates);

        $("#GatePassReceive").validate({
            rules:{
                status:{
                    required:true,
                },
                receive_date:{
                    required:true,
                },
                notes:{
                    maxlength:500
                }
            },
            messages:{
                status:{
                    required: "Receive Status Required",
                },
            }
    });

    });
</script>

