 <!-- Modal -->

 <form action="{{route('construction.partial-bill-generate-entry')}}" method="post" id="partialBillGenerate" enctype="multipart/form-data">
    @csrf
    <div class="form-row">


        <div class="col-lg-12 col-md-12 col-12">
            <h5 class="text-center"><strong>Work Order No:</strong> {{$order_no}}</h5><br>
            <div class="form-group form-row">
                <label for="bill_amount" class="col-sm-4 col-form-label">Total Amount</label>
                <div class="col-sm-8">
                  {{ number_format($data['total_amount'],2)}}
                </div>
                <label for="bill_amount" class="col-sm-4 col-form-label">Generated Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['bill'],2)}}
                </div>
                <label for="bill_amount" class="col-sm-4 col-form-label">Due Amount</label>
                <div class="col-sm-8">
                    {{ number_format($data['due'],2)}}
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="bill_amount" class="col-sm-4 col-form-label">Generate Amount</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="bill_amount"
                        name="bill_amount" value="{{$data['due']}}" placeholder="Rate"/>

                        <input type="hidden" name="work_order" id="work_order" value="{{$data['work_order']}}">
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

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="remarks" class="col-sm-4 col-form-label">Attachment</label>
                <div class="col-sm-8">
                    <input type="file" class="upload-signature form-control form-control-sm" id="attachment" name="attachment" style="line-height: 1.0 !important"/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('construction.work-order-bill-generate');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdatefile(this,'','','','',getWorkOrderList,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#partialBillGenerate").validate({
            rules:{
                work_order:{
                    required:true,
                },
                bill_amount:{
                    required:true
                },
                attachment:{
                    extension: "jpg|jpeg|png|pdf",
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