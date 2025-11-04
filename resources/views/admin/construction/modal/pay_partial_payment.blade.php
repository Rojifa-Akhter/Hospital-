 <!-- Modal -->

 <form action="{{route('construction.partial-payment-entry')}}" method="post" id="payPartialBillPayment" class="updateAccountsSubGroup">
    @csrf
    <div class="form-row">


        <div class="col-lg-12 col-md-12 col-12">
            <h5 class="text-center"><strong>Work Order No:</strong> {{$order_no}}</h5><br>
            <div class="form-group form-row">
                <label for="paid_amount" class="col-sm-4 col-form-label">Workorder Amount</label>
                <div class="col-sm-8">
                  {{ number_format($data['total_amount'],2)}}
                </div>

                <label for="paid_amount" class="col-sm-4 col-form-label">Current Bill  Amount</label>
                <div class="col-sm-8">
                  {{ number_format($data['current_bill'],2)}}
                </div>

                <label for="paid_amount" class="col-sm-4 col-form-label">Current Paid Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['current_payment'],2)}}
                </div>
                <label for="paid_amount" class="col-sm-4 col-form-label">Current Due Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['due'],2)}}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="paid_amount" class="col-sm-4 col-form-label">Paid Amount</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="paid_amount"
                        name="paid_amount" value="{{$data['due']}}" placeholder="Rate"/>

                        <input type="hidden" name="work_order" id="work_order" value="{{$data['work_order']}}">
                        <input type="hidden" name="bill_pk" id="bill_pk" value="{{$data['bill_pk']}}">
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                <div class="col-sm-8">
                    <textarea type="text" class="form-control form-control-sm" id="remarks" name="remarks" value="" placeholder="Remarks" rows="4"></textarea>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('construction.work-order-bill-approved-worklist');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getWorkOrderList,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#payPartialBillPayment").validate({
            rules:{
                work_order:{
                    required:true,
                },
                paid_amount:{
                    required:true
                }
            },
            messages:{
                currency_name:{
                    required: "Name Required",
                },
            }
        });
    });
</script>