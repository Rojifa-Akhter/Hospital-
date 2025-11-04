 
 @php 
    $fiscal_year_edit = collect($fiscal_year->getData()->data)->sortBy('fiscal_year')->values();
 @endphp
 <!-- Modal -->
 <form action="{{route('v1.accounts.update-accounts-opening-balance')}}" method="post" id="updateAccountsDescription" class="updateAccountsDescription">
    @csrf
    <div class="form-row">
 
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="acc_4type_no_fk" class="col-sm-4 col-form-label">General Ledger<span style="color:red">*</span></label>
                <div class="col-sm-8">
     
                    <select class="form-control form-control-sm selectAccountOpeningBalance" name="account_no_pk" id="account_no_pk">
                        <option value="" disabled selected>Select one</option>
                        @foreach ($general_ledger->getData()->data as $item)
                            
                            @if($item->status == 1)
                                <option value="{{$item->account_no_pk}}" {{ $item->account_no_pk == $data->trn_account_no_fk ? 'selected' : '' }}>{{ $item->account_code}} - {{ $item->account_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="trn_dr_account_amount" class="col-sm-4 col-form-label">Debit Tk<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="trn_dr_account_amount" name="trn_dr_account_amount" value="{{$data->trn_dr_account_amount}}" placeholder="Debit Tk"/>
                        <input type="hidden" value="{{$data->opbal_no_pk}}" name="opbal_no_pk">
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="trn_cr_account_amount" class="col-sm-4 col-form-label">Credit Tk<span style="color:red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control form-control-sm" id="trn_cr_account_amount"
                        name="trn_cr_account_amount" value="{{$data->trn_cr_account_amount}}" placeholder="Account Description Code"/>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="fiscal_year" class="col-sm-4 col-form-label">Fiscal Year<span style="color:red">*</span></label>
                <div class="col-sm-8">     
                    <select class="form-control form-control-sm" name="fiscal_year" id="fiscal_year">
                        <option value="" disabled selected>Select one</option>
                            @foreach ($fiscal_year_edit as $item)
                                @if($item->status == 1)
                                    <option value="{{$item->fiscalyear_no_pk}}" {{$data->fiscal_year_fk == $item->fiscalyear_no_pk ? 'selected' : ''}}>{{ $item->fiscal_year}}</option>
                                @endif
                            @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                <div class="col-sm-8">
                    <textarea class="form-control form-control-sm" id="notes"
                        name="notes" value="{{$data->narration_text}}" placeholder="Notes" cols="5" rows="5">{{$data->narration_text}}</textarea>
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
            onclick="btnSaveUpdate(this,'','','','',getAccountsOpeningBalV1,'{{ $redirect_url }}')">Save</button>
        <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
    </div>
</form>
<script>
    $(document).ready(function() {
    $('.selectAccountOpeningBalance').select2();

    $("#updateAccountsDescription").validate({
        rules:{
            account_no_pk:{
                required:true, 
            },
            trn_dr_account_amount:{
                required:true,
                minlength:1,
                notOnlySpaces: true
            },
            fiscal_year:{
                required:true, 
            },
            trn_cr_account_amount:{
                required:true,
                minlength:1,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            fiscal_year:{
                required:"Fiscal Year Required", 
            },
            account_no_pk:{
                required: "General Ledger Required", 
            },
            trn_dr_account_amount:{
                required: "Dr Amount Required",
            },
            trn_cr_account_amount:{
                required: "Cr Amount Required",
            }
        }
    });
    });
</script>