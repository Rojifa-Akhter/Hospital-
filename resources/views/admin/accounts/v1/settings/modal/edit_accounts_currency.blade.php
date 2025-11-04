 <!-- Modal -->

 <form action="{{route('v1.accounts.update-accounts-currency-setup')}}" method="post" id="updateAccountsCurrency" class="updateAccountsSubGroup">
    @csrf
    <div class="form-row">

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="currency_name" class="col-sm-4 col-form-label">Currency Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="currency_name"
                        name="currency_name" value="{{$data->currency_code}}" placeholder="Name"/>
                        <input type="hidden" value="{{$data->currency_no_pk}}" name="currency_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="currency_rate" class="col-sm-4 col-form-label">Rate</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="currency_rate"
                        name="currency_rate" value="{{$data->rate}}" placeholder="Rate"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="status" class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-2 mt-1">
                    <input type="checkbox" id="status"
                        name="status" value="1" @if($data->status == 1) {{'checked'}} @endif/>
                </div>
            </div>
        </div>

    </div>

    @php
        $redirect_url = route('v1.accounts.accounts-opening-balance');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getAccountsCurrency,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#updateAccountsCurrency").validate({
            rules:{
                currency_name:{
                    required:true,
                    minlength:2,
                    maxlength:50,
                },
                currency_rate:{
                    required:true,
                    maxlength:5,
                }
            },
            messages:{
                currency_name:{
                    required: "Name Required",
                },
                currency_rate:{
                    required: "Rate Required",
                }
            }
        });
    });
</script>