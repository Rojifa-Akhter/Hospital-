<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="indent_worklist">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-7">
                                <h5 class="mt-2 mb-0">Rate Management</h5>
                                <small>Rate Management/ Rate Management</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#">
                            <div class="card">
                                <div class="card-header">
                                    <div class="form-row">
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <div class="form-group form-row">
                                                <label for="corporate_type" class="col-sm-4 col-form-label">Select Corporate/Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm" id="corporate_type" name="corporate_type" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                       

                                        <div class="col-md-2 col-sm-12">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" class="btn btn-success btn-md-global"><i class="fa fa-search"></i> Search</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                	<div class="card mt-0">
                                		<div class="card-header">
                                			<h5 class="mb-0">Corporate info</h5>
                                		</div>

                                		<div class="card-body">
                                			<div class="corporate__info">
                                				<div class="form-row">
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Code :  </span>
                                							<span class="details--info">850125</span>
                                						</div>
                                					</div>
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Name : </span>
                                							<span class="details--info">Md. Kamruzzaman Sardar</span>
                                						</div>
                                					</div>
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Address : </span>
                                							<span class="details--info">78/A, Road:10, House:85, GreenRoad, Dhaka</span>
                                						</div>
                                					</div>
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Contact Person : </span>
                                							<span class="details--info">Md. Manik Mia</span>
                                						</div>
                                					</div>
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Contact No : </span>
                                							<span class="details--info">01185698000</span>
                                						</div>
                                					</div>
                                					<div class="col-lg-4">
                                						<div class="coporate__details">
                                							<span>Email : </span>
                                							<span class="details--info">example@gmail.com</span>
                                						</div>
                                					</div>
                                				</div>
                                			</div>
                                			
                                		</div>
                                	</div>
                                </div>
                               </div>

                               <div class="card">
                               	<div class="card-header">
                               		<h5>Policy Info</h5>
                               	</div>
                               	<div class="card-body">
                               		
                               		<div class="form-row">
                               		    <div class="col-md-12 mt-0">
                               		        <div class="row ml-2">
                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">Consultation</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="consultation_ind" aria-label="Checkbox for following text input" name="consultation_ind" value="1" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" name="consultation_percent" class="form-control number_only consultation_percent" value="" id="consultation_percent" aria-label="Text input with checkbox" maxlength="3" disabled="" />
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>

                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">General Billing</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="general_billing_ind" aria-label="Checkbox for following text input" value="1" name="general_billing_ind" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" class="form-control number_only agent_ref" maxlength="3" value="" name="general_billing" aria-label="Text input with checkbox" id="general_billing" disabled="" />

                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>

                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">OT</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="ot_ind" aria-label="Checkbox for following text input" name="ot_ind" value="1" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" name="ot" class="form-control number_only doc_ref" value="" id="ot" aria-label="Text input with checkbox" maxlength="3" disabled="" />
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>

                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">Pathology</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="pathology_ind" aria-label="Checkbox for following text input" value="1" name="pathology_ind" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" class="form-control number_only pathology" maxlength="3" value="" name="pathology" aria-label="Text input with checkbox" disabled="" />

                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>

                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">Radiology</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="radiology_ind" aria-label="Checkbox for following text input" name="radiology_ind" value="1" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" name="radiology" class="form-control number_only radiology" value="" id="radiology" aria-label="Text input with checkbox" maxlength="3" disabled="" />
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>

                               		            <div class="form-group col-md-2">
                               		                <label class="col-form-label">Ipd Bed</label>
                               		                <div class="input-group mb-3">
                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <input type="checkbox" id="ipd_bed_ind" aria-label="Checkbox for following text input" value="1" name="ipd_bed_ind" />
                               		                        </div>
                               		                    </div>
                               		                    <input type="text" class="form-control number_only ipd_bed" maxlength="3" value="" name="ipd_bed" aria-label="Text input with checkbox" disabled="" />

                               		                    <div class="input-group-prepend">
                               		                        <div class="input-group-text">
                               		                            <span>%</span>
                               		                        </div>
                               		                    </div>
                               		                </div>
                               		            </div>
                               		        </div>

                               		        <div class="row ml-2">
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="authorization" name="authorization" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="authorization">Authorization</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="authorization_id" name="authorization_id" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="authorization_id">Authorization Code</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="not_doctor" name="not_doctor" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="not_doctor">Not Doctor</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="signed_copy" name="signed_copy" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="signed_copy">Signed Copy</label>
                               		                </div>
                               		            </div>
                               		        </div>
                               		    </div>

                               		    <div class="col-md-12 mt-0">
                               		        <div class="row ml-2">
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="corporate_email_id" name="corporate_email_id" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="corporate_email_id">Corporate Employee ID</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="management_sms" name="management_sms" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="management_sms">Management SMS</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="management_email" name="management_email" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="management_email">Management Email</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="corporate_sms" name="corporate_sms" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="corporate_sms">Corporate SMS</label>
                               		                </div>
                               		            </div>
                               		        </div>
                               		    </div>
                               		    <div class="col-md-12 mt-0 mb-2">
                               		        <div class="row ml-2">
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="staff_id" name="staff_id" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="staff_id">Staff ID</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="corporate_code" name="corporate_code" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="corporate_code">Corporate Code</label>
                               		                </div>
                               		            </div>

                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="corporate_email" name="corporate_email" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="corporate_email">Corporate Email</label>
                               		                </div>
                               		            </div>
                               		            <div class="col-md-3">
                               		                <div class="custom-control custom-checkbox custom-control-inline text-center">
                               		                    <input type="checkbox" id="active" name="active" class="custom-control-input" />
                               		                    <label class="custom-control-label" for="active">Active</label>
                               		                </div>
                               		            </div>
                               		        </div>
                               		    </div>
                               		</div>

                               		<div class="form-row justify-content-end text-right">
                               			<div class="col-md-6">
                               				<button type="button" class="btn btn-secondary uhl_common_btn">Generate</button>
                               			</div>
                               		</div>
                               	</div>

                               </div>

                               <div class="card">
                               	<div class="card-header">
                               		<div class="form-row">
                               		    <div class="col-lg-4 col-md-12 col-12">
                               		        <div class="form-group form-row">
                               		            <label for="item_type" class="col-sm-4 col-form-label">Item</label>
                               		            <div class="col-sm-8">
                               		                <input type="text" class="form-control form-control-sm" id="item_type" name="item_type" placeholder="" />
                               		            </div>
                               		        </div>
                               		    </div>
                                        <div class="col-md-1"></div>
                               		    <div class="col-lg-4 col-md-12 col-12">
                               		        <div class="form-group form-row">
                               		            <label for="discount_percent" class="col-sm-4 col-form-label">Discount %</label>
                               		            <div class="col-sm-8">
                               		                <input type="text" class="form-control form-control-sm" id="discount_percent" name="discount_percent" placeholder="" />
                               		            </div>
                               		        </div>
                               		    </div>

                               		    <div class="col-md-1 col-sm-12">
                               		            <div class="btn-group btn-block" role="group">
                               		                <button type="button" class="btn btn-success btn-md-global"><i class="fas fa-plus"></i> Add</button>
                               		            </div>
                               		        </div>

                               		</div>

                               	</div>
                               	<div class="card-body">
                               	    <div class="table-responsive">
                               	        <table class="table table-bordered table-hover table-striped">
                               	            <thead class="global-uhl-table-bg">
                               	                <tr>
                               	                    <th>SN</th>
                               	                    <th>Item </th>
                               	                    <th>Type</th>
                               	                    <th>Quantity</th>
                               	                    <th>Base Rate</th>
                               	                    <th>Rate</th>
                               	                    <th>Package</th> 
                               	                </tr>
                               	                
                               	            </thead>
                               	            <tbody>
                               	                <tr>
                               	                    <td>1</td>
                               	                    <td></td>
                               	                    <td></td>
                               	                    <td></td>
                               	                    <td></td>
                               	                    <td></td>
                               	                    <td></td> 
                               	                </tr>
                               	            </tbody>
                               	        </table>
                               	    </div>

                               	    <div class="form-row justify-content-end text-right">
                               	    	<div class="col-md-6">
                               	    		<button type="button" class="btn btn-secondary uhl_save_btn">Save</button>
                               	    	</div>
                               	    </div>
                               	</div>
                               </div>



                                
                            

                            
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
