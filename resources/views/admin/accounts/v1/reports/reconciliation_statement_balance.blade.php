<form method="GET" action="{{ route('bank-reconciliation.create') }}">
    <input type="hidden" name="year" value="{{ $year }}">
    <input type="hidden" name="acc_pk" value="{{ $acc_pk }}">
    <input type="hidden" name="month" value="{{ $month }}">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="form-group form-row">
                <label for="statement_balance" class="col-sm-4 col-form-label"> Statement Balance</label>
                <div class="col-sm-8">
                    <input class="form-control form-control-sm required" id="statement_balance" name="statement_balance" placeholder="Statement Balance" value="{{ number_format($statement_balance, 2) }}" readonly style="text-align: right">
                </div>
            </div>
        </div>
            
        <div class="col-md-4 col-12">
            <div class="form-group form-row">
                <label for="booked_balance" class="col-sm-4 col-form-label"> Booked Balance</label>
                <div class="col-sm-8">
                    <input class="form-control form-control-sm required" id="booked_balance" name="booked_balance" placeholder="Booked Balance" value="{{ number_format($booked_amount, 2) }}" style="text-align: right">
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="form-group form-row">
                <label for="end-date" class="col-sm-4 col-form-label">End Date</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control form-control-sm required" id="end-date" name="end_date">
                </div>
            </div>
        </div>    
    </div>

    <div style="text-align: end; margin-top: 0.5rem;">
        <button 
            type="submit" 
            class="btn btn-success btn-md px-4"
            id="next-button"
        >
            Next
        </button>
    </div>
</form>
    


