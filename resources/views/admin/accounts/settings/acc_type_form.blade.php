<form action="{{route('save-acc-type')}}" id="acc_type" method="post">
    @csrf
    <div class="form-group">
        <label for="acct_type_code">Account type code</label>
        <input type="text" name="acct_type_code" class="form-control" id="acct_type_code">
    
    </div>
    <div class="form-group">
        <label for="acct_type_name">Account type name</label>
        <input type="text" name="acct_type_name" class="form-control" id="acct_type_name">
    </div>
    <div class="form-group">
        <label for="acct_type_sl">SL No.</label>
        <select name="acct_type_sl" class="form-control" id="acct_type_sl">
            <option value="">Select serial no</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control" id="status">
            <option value="">Select status</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
            
        </select>
    </div>
    <div class="form-group">
        <div class="row">
              <div class="form-check form-check-inline" style="margin:16px;">
                <input class="form-check-input" type="checkbox" id="cashflow_ind" name="cashflow_ind" value="1"/>
                <label class="form-check-label" for="inlineCheckbox1">Cashflow</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="income_exp_ind" name="income_exp_ind" value="1"/>
                <label class="form-check-label" for="inlineCheckbox2">Income & Expense</label>
              </div>
        </div>
    </div>
    <div  class="form-group">
    <button type="submit" class="btn btn-primary save_acc_type">Submit</button>
    <span class="save_loader pl-3"> <i class='fas fa-stroopwafel fa-spin'></i></span>
    </div>
</form>