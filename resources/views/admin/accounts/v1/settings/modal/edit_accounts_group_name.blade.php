 <!-- Modal -->
<form action="{{route('v1.accounts.update-accounts-group')}}" method="post" id="updateAccountsGroup" class="updateAccountsGroup">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_group_name" class="col-sm-4 col-form-label">Edit Account Group<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_group_name"
                        name="account_group_name" value="{{$data->acc_1group_name}}" placeholder="Edit Account Group Name"/>
                        <input type="hidden" value="{{$data->acc_1group_no_pk}}" name="acc_1group_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_group_code" class="col-sm-4 col-form-label">Account Group Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_group_code"
                        name="account_group_code" value="{{$data->acc_1group_code}}" placeholder="Account Group Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="start_range" class="col-sm-4 col-form-label">Start Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="start_range"
                        name="start_range" value="{{$data->acc_code_range_1_start}}" placeholder="Start Range Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="end_range" class="col-sm-4 col-form-label">End Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="end_range"
                        name="end_range" value="{{$data->acc_code_range_1_end}}" placeholder="End Range Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->acc_1group_notes}}" placeholder="Notes" cols="5" rows="5">{{$data->acc_1group_notes}}</textarea>
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
        $redirect_url = route('v1.accounts.accounts-group');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getAccountsGroup,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#updateAccountsGroup").validate({
            rules:{
                account_group_name:{
                    required:true,
                    minlength:5,
                    maxlength:50,
                    notOnlySpaces: true
                },
                start_range:{
                    maxlength:10, 
                },
                end_range:{
                    maxlength:10, 
                },
                account_group_code:{
                    required:true,
                    minlength:1,
                    maxlength:20,
                    notOnlySpaces: true
                },
                notes:{
                    maxlength:500
                }
            },
            messages:{
                account_group_name:{
                    required: "Account Group Name Required",
                },
                account_group_code:{
                    required: "Account Group Code Required",
                }
            }
    });

    });
</script>