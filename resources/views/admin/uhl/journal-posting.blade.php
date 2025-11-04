<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .upload-signature {
    cursor: pointer;
    color: #595757;
    border: 1px dashed #97dad4;
}
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Journal Posting</h5>
                            <small>Accounts / Journal Posting</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="doc_date" class="col-sm-4 col-form-label">Document Date<span class=text-danger>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="doc_date" name="doc_date" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>
                               

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="cost-center-code" class="col-sm-4 col-form-label">Cost Center Code<span class=text-danger>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="cost-center-code" name="cost-center-code" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="attachment1" class="col-sm-4 col-form-label">Attachment-1</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="attachment1" name="attachment1" placeholder="Enter file name" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                	<div class="form-group form-row">
                                	    <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                	    <div class="col-sm-8">
                                	        <div onclick="uploadPhoto('input2','display2')">
                                	            <input onchange="uploadDocField(this)" type="file" id="input2" name="upload" class="d-none" />
                                	            <label for="input2" id="display2" class="upload-signature form-control py-2">
                                	                <i class="fas fa-file-upload"></i>
                                	                <span class="ml-2">Upload</span>
                                	            </label>
                                	        </div>
                                	    </div>
                                	</div>	
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="total-dr" class="col-sm-4 col-form-label">Total Dr.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="total-dr" name="total-dr" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="journal_type" class="col-sm-4 col-form-label">Journal Type<span class=text-danger>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="journal_type" name="journal_type" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                   <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="attachment2" class="col-sm-4 col-form-label">Attachment-2</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="attachment2" name="attachment2" placeholder="Enter file name" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                	<div class="form-group form-row">
                                	    <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                	    <div class="col-sm-8">
                                	        <div onclick="uploadPhoto('input3','display3')">
                                	            <input onchange="uploadDocField(this)" type="file" id="input3" name="upload" class="d-none" />
                                	            <label for="input3" id="display3" class="upload-signature form-control py-2">
                                	                <i class="fas fa-file-upload"></i>
                                	                <span class="ml-2">Upload</span>
                                	            </label>
                                	        </div>
                                	    </div>
                                	</div>	
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="total-cr" class="col-sm-4 col-form-label">Total Cr.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="total-cr" name="total-cr" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="voucher_no" class="col-sm-4 col-form-label">Voucher No.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="voucher_no" name="voucher_no" placeholder="" value="" />
                                        </div>
                                    </div>
                                </div>


                                   <div class="col-lg-3 col-md-6 col-12">
                                    <div class="form-group form-row">
                                        <label for="attachment3" class="col-sm-4 col-form-label">Attachment-3</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="attachment3" name="attachment3" placeholder="Enter file name" value="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-12">
                                	<div class="form-group form-row">
                                	    <label for="upload" class="col-sm-4 col-form-label">Upload</label>
                                	    <div class="col-sm-8">
                                	        <div onclick="uploadPhoto('input4','display4')">
                                	            <input onchange="uploadDocField(this)" type="file" id="input4" name="upload" class="d-none" />
                                	            <label for="input4" id="display4" class="upload-signature form-control py-2">
                                	                <i class="fas fa-file-upload"></i>
                                	                <span class="ml-2">Upload</span>
                                	            </label>
                                	        </div>
                                	    </div>
                                	</div>	
                                </div>

                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="form-group form-row">
                                        <label for="notes" class="col-sm-1 col-form-label">Notes</label>
                                        <div class="col-sm-11">
                                            <textarea class="form-control" id="notes" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        	<div class="table-responsive">
                        	    <table class="table table-striped table-bordered table-hover">
                        	        <thead class="global-uhl-table-bg">
                        	            <tr>
                        	                <th class="text-center">General Ledger (GL)<span class="text-danger">*</span></th>
                        	                <th class="text-center">Sub Ledger Type</th>
                        	                <th class="text-center">Sub Ledger</th>
                        	                <th class="text-center">Dr<span class="text-danger">*</span> </th>
                        	                <th class="text-center">Cr<span class="text-danger">*</span> </th>
                        	                <th class="text-center">Currency</th>
                        	                <th class="text-center">Amt. in Doc. Curr<span class="text-danger">*</span></th>
                        	                <th class="text-center">Amt. in Loc. Curr</th>
                        	                <th class="text-center">Cost Center</th>
                        	                <th class="text-center">Company</th>
                        	                <th class="text-center">Internal Activity</th>
                        	                <th class="text-center">Narration</th>
                        	                <th class="text-center">Cheq. Date</th>
                        	                <th class="text-center">Cheq. No</th>
                        	                <th class="text-center"></th>
                        	               
                        	            </tr>

                        	        </thead>

                        	        <tbody>
                        	          <tr>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">BDT</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		 <input type="text" class="form-control form-control-sm" id="" name="" placeholder="" value="" />

                        	          	</td>
                        	          	<td>
                        	          		<input type="text" class="form-control form-control-sm" id="" name="" placeholder="" value="" />

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">Select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">Select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<select class="form-control form-control-sm" id="" name="">
                        	          		    <option value="">Select</option>
                        	          		    <option value=""></option>
                        	          		</select>

                        	          	</td>
                        	          	<td>
                        	          		<input type="text" class="form-control form-control-sm" id="" name="" placeholder="" value="" />

                        	          	</td>
                        	          	<td>
                        	          		<input type="text" class="form-control form-control-sm" id="" name="" placeholder="" value="" />

                        	          	</td>
                        	          	<td>
                        	          		<input type="text" class="form-control form-control-sm" id="" name="" placeholder="" value="" />

                        	          	</td>
                        	          	<td>
                                            <span class="badge badge-primary"><i class="fas fa-plus-circle"></i></span>
                        	          	</td>
                        	          </tr>

                        	        </tbody>
                        	    </table>
                        	</div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="form-group">
                                <ul class="list-inline btn__box">
                                    <li class="list-inline-item">
                                        <button type="button" class="btn btn-secondary uhl_save_btn" id="">Post</button>
                                    </li>

                                    <li class="list-inline-item"><button type="button" class="btn btn-secondary">Reset</button></li>
                                    <li class="list-inline-item"><button type="button" class="btn btn-danger">Exit</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

 
           
        </div>
    </section>
</main>

<script>
    $("body").addClass("sidebar-collapse");
</script>

