 <!-- Modal -->
@php $account_group = collect($account_accounts_type->getData()->data)->sortBy('type_code')->values(); @endphp
 <form action="{{route('v1.accounts.update-accounts-description')}}" method="post" id="updateAccountsDescription" class="updateAccountsDescription">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="acc_4type_no_fk" class="col-sm-4 col-form-label">Account Type<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm selectAccountDescription" name="acc_4type_no_fk" id="acc_4type_no_fk">
                        <option value="" disabled selected>Select one</option>
                        @foreach ($account_group as $item)
                            @if($item->status == 1)
                                <option value="{{$item->acc_4type_no_pk}}" {{ $item->acc_4type_no_pk == $data->acc_4type_no_fk ? 'selected' : ''}}>{{ $item->acc_4type_code}} - {{ $item->acc_4type_name }} @if(!empty($item->acc_code_range_4_start) && ($item->acc_code_range_4_end)) ( {{$item->acc_code_range_4_start}} - {{ $item->acc_code_range_4_end}} ) @endif</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_description_name" class="col-sm-4 col-form-label">Acc. Description Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_description_name"
                        name="account_description_name" value="{{$data->acc_5type_description}}" placeholder="Edit Account Description Name"/>
                        <input type="hidden" value="{{$data->acc_5typedescription_no_pk}}" name="acc_5typedescription_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_description_code" class="col-sm-4 col-form-label">Acc. Description Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_description_code"
                        name="account_description_code" value="{{$data->type_code}}" placeholder="Account Description Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="start_range" class="col-sm-4 col-form-label">Start Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="start_range"
                        name="start_range" value="{{$data->acc_code_range_5_start}}" placeholder="Start Range Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="end_range" class="col-sm-4 col-form-label">End Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="end_range"
                        name="end_range" value="{{$data->acc_code_range_5_end}}" placeholder="End Range Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->acc_5type_description_notes}}" placeholder="Notes" cols="5" rows="5">{{$data->acc_5type_description_notes}}</textarea>
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
        $redirect_url = route('v1.accounts.accounts-description');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getAccountsDescription,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.selectAccountDescription').select2();
        $("#updateAccountsDescription").validate({
            rules:{
            acc_4type_no_fk:{
                required:true, 
            },
            account_description_name:{
                required:true,
                minlength:5,
                maxlength:200,
                notOnlySpaces: true
            },
            start_range:{
                maxlength:10, 
            },
            end_range:{
                maxlength:10, 
            },
            account_description_code:{
                required:true,
                minlength:1,
                maxlength:50,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            acc_4type_no_fk:{
                required: "Account Type Name Required", 
            },
            account_description_name:{
                required: "Account Description Name Required",
            },
            account_description_code:{
                required: "Account Description Code Required",
            }
        }
        });
    });
</script>