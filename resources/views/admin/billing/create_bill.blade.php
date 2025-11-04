<form action="">
	<div class="row">
	    <div class="col-md-12">
	        <div class="form-group row">
	            <label for="disc_by" class="col-form-label col-form-label-sm col-sm-4">Discount By</label>
	            <div class="col-md-8">
	                <select class="form-control" id="disc_by" name="disc_by">
	                        <option value="">Select Discount By</option>
	                        <option value="">Discount By-1</option>
	                        <option value="">Discount By-2</option>
	                        <option value="">Discount By-3</option>
	                </select>
	            </div>
	        </div>

	        <div class="row">
	            <div class="col-md-4">
	                <div class="form-check">
	                  <input class="form-check-input" type="radio" name="pay_with" id="pay_with_cash" value="" checked>
	                  <label class="form-check-label" for="pay_with_cash">Cash</label>
	                </div>

	                <div class="form-check">
	                    <input class="form-check-input" type="radio" name="pay_with" id="pay_with_other" value="">
	                    <label class="form-check-label" for="pay_with_other">Other</label>
	                </div>
	            </div>

	            <div class="col-md-2">
	                <div class="form-group">
	                    <label for="pay_amt">Pay Amount</label>
	                    <input type="text" class="form-control" id="pay_amt" name="pay_amt" value="" placeholder="Pay Amount">
	                </div>
	            </div>

	            <div class="col-md-2">
	                <div class="form-group">
	                    <label for="amt_given">Given</label>
	                    <input type="text" class="form-control" id="amt_given" name="amt_given" value="" placeholder="Given Amount">
	                </div>
	            </div>

	            <div class="col-md-2">
	                <div class="form-group">
	                    <label for="amt_change">Change</label>
	                    <input type="text" class="form-control" id="amt_change" name="amt_change" value="" placeholder="Change Amount">
	                </div>
	            </div>

	            <div class="col-md-2">
	                <div class="form-group">
	                    <label for="pay_amt_others">Others Pay Amt</label>
	                    <input type="text" class="form-control" id="pay_amt_others" name="pay_amt_others" value="" placeholder="Others Pay Amt">
	                </div>
	            </div>

	            <div class="col-sm-12 col-lg-12 col-xl-12">
	                <div class="form-group row">
	                    <label class="col-md-4" for="pay_remarks">Remarks</label>
	                    <div class="col-md-8">
	                        <input type="text" class="form-control" id="pay_remarks" name="pay_remarks" value="" placeholder="Enter Remarks">
	                    </div>
	                </div>
	            </div>

	            <div class="col-sm-12 col-lg-12 col-xl-12">
	                <div class="form-group row">
	                    <label class="col-md-4" for="pay_del_date_time">Del. Date Time</label>
	                    <div class="col-md-8">
	                    	<div class="form-row">
	                    		<div class="col-md-6 form-group">
	                    			<input type="text" class="date_picker form-control" id="pay_del_date_time" name="pay_del_date_time" value="" placeholder="Delivery Date">
	                    		</div>
	                    		<div class="col-md-6 form-group">
	                    			<input type="time" class="form-control timepicker" id="pay_del_date_time" name="pay_del_date_time" value="" placeholder="Delivery Time">
	                    		</div>
	                    	</div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</form>