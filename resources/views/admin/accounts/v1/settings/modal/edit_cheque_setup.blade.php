@php
    $redirect_url = route('v1.accounts.cheque-setup');
@endphp

<form action="{{ route('v1.accounts.update-cheque') }}" method="post" id="updateChequeForm">
    @csrf
    <input type="hidden" name="cheque_verified_no_pk" value="{{ $data->cheque_verified_pk }}">

    <div class="form-group form-row">
        <label for="edit_bank_account_select" class="col-4 col-form-label">Bank <span style="color: #dc3545;">*</span></label>
        <div class="col-8">
            <select name="bank_name" id="edit_bank_account_select" class="bank-account-select">
                <option value=""></option> 
                @foreach ($bankAccounts as $account)
                    <option value="{{ $account->account_pk }}" {{ $data->bank_pk == $account->account_pk ? 'selected' : '' }}>
                        {{ $account->account_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group form-row">
        <label for="cheque_start_number" class="col-sm-4 col-form-label">Cheque Start Number <span style="color: #dc3545;">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="cheque_start_number" 
                   name="cheque_start_number" placeholder="Cheque Start Number" 
                   value="{{ $data->cheque_no_form ?? '' }}" />
        </div>
    </div>

    <div class="form-group form-row">
        <label for="cheque_end_number" class="col-sm-4 col-form-label">Cheque End Number <span style="color: #dc3545;">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="cheque_end_number"
                   name="cheque_end_number" placeholder="Cheque End Number"
                   value="{{ $data->cheque_no_to ?? '' }}" />
        </div>
    </div>

    <div class="form-group form-row">
        <label for="status" class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-8">
            <select name="status" id="status" class="form-control form-control-sm">
                <option value="2" {{ isset($data->status) && $data->status == 2 ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>
                    Issue
                </option>
            </select>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary uhl_save_btn">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>