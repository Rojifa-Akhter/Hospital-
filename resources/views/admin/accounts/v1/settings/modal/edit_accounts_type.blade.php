 <!-- Modal -->
@php $account_group = collect($account_group_type->getData()->data)->sortBy('acc_3grouptype_code')->values(); @endphp
<form action="{{route('v1.accounts.update-accounts-type')}}" method="post" id="updateAccountsType" class="updateAccountsType">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_group_type_fk" class="col-sm-4 col-form-label">Account Sub Group<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <select class="form-control form-control-sm selectAccountsType" name="account_group_type_fk" id="account_group_type_fk">
                        <option value="" disabled selected>Select one</option>
                        @foreach ($account_group as $item)
          
                            @if($item->status == 1)
                                <option value="{{$item->acc_3grouptype_no_pk}}" {{ $item->acc_3grouptype_no_pk == $data->acc_3grouptype_no_fk ? 'selected' : ''}}>{{ $item->acc_3grouptype_code}} - {{ $item->acc_3grouptype_name }} @if(!empty($item->acc_code_range_3_start) && ($item->acc_code_range_3_end)) ( {{$item->acc_code_range_3_start}} - {{ $item->acc_code_range_3_end}} ) @endif</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_type_name" class="col-sm-4 col-form-label">Acc. Type Name<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_type_name"
                        name="account_type_name" value="{{$data->acc_4type_name}}" placeholder="Edit Account Type Name"/>
                        <input type="hidden" value="{{$data->acc_4type_no_pk}}" name="acc_4type_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="account_type_code" class="col-sm-4 col-form-label">Acc. Type Code<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="account_type_code"
                        name="account_type_code" value="{{$data->acc_4type_code}}" placeholder="Account Type Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="start_range" class="col-sm-4 col-form-label">Start Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="start_range"
                        name="start_range" value="{{$data->acc_code_range_4_start}}" placeholder="Start Range Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="end_range" class="col-sm-4 col-form-label">End Range Code</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="end_range"
                        name="end_range" value="{{$data->acc_code_range_4_end}}" placeholder="End Range Code"/>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="description" class="col-sm-4 col-form-label">Description</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="description"
                        name="description" value="{{$data->acc_4type_description}}" placeholder="Description" cols="2" rows="2">{{$data->acc_4type_description}}</textarea>
                </div>
            </div>
        </div> --}}

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->acc_4type_notes}}" placeholder="Notes" cols="4" rows="4">{{$data->acc_4type_notes}}</textarea>
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
        $redirect_url = route('v1.accounts.accounts-type');
    @endphp

    <div class="text-center">
        <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getAccountsType,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.selectAccountsType').select2();
        $("#updateAccountsType").validate({
        rules:{
            account_group_type_fk:{
                required:true, 
            },
            account_type_name:{
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
            account_type_code:{
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
            account_group_type_fk:{
                required: "Account Group Type Name Required", 
            },
            account_type_name:{
                required: "Account Type Name Required",
            },
            account_type_code:{
                required: "Account Type Code Required",
            }
        }
        });
    });
</script>