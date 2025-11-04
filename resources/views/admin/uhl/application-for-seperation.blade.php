<style>
    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Application for Seperation</h5>
                        <small>HRM / Application for Seperation</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                               <div class="form-row">

                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="emp_id" class="col-form-label">Emp ID</label>
                               	        <input type="text" class="form-control form-control-sm" id="emp_id" name="emp_id" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-lg-3 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="name_" class="col-form-label">Name</label>
                               	        <input type="text" class="form-control form-control-sm" id="name_" name="name_" placeholder="" value="" />
                               	    </div>
                               	</div>
                               	<div class="col-lg-3 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="department" class="col-form-label">Department</label>
                               	        <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="dseignation" class="col-form-label">Designation</label>
                               	        <input type="text" class="form-control form-control-sm" id="dseignation" name="dseignation" placeholder="" value="" />
                               	    </div>
                               	</div>

                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="seperation_type" class="col-form-label">Seperation Type</label>
                               	       <select class="form-control form-control-sm" id="seperation_type" name="seperation_type">
	                               	       	<option value="">Select</option>
	                               	       	<option value="">Resignation</option>
	                               	       	<option value="">Termination</option>
	                               	       	<option value="">Poor Performance</option>
	                               	       	<option value="">Long Time Absent</option>
                               	       </select>
                               	    </div>
                               	</div>


                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="date_of_application" class="col-form-label">Date of Application</label>
                               	        <input type="text" class="form-control form-control-sm" id="date_of_application" name="date_of_application" placeholder="" value="" />
                               	    </div>
                               	</div>


                               	<div class="col-lg-2 col-md-6 col-12">
                               	    <div class="form-group">
                               	        <label for="exp_date_of_sepera" class="col-form-label">Expected Date of Seperation</label>
                               	        <input type="text" class="form-control form-control-sm" id="exp_date_of_sepera" name="exp_date_of_sepera" placeholder="" value="" />
                               	    </div>
                               	</div>


                               	<div class="col-lg-3 col-md-12 col-12">
                               	    <div class="form-group">
                               	        <label for="upload_app" class="col-form-label">Application Attachment</label>
                               	        <div class="input-group mb-3">
                               	            <div class="custom-file">
                               	                <input type="file" class="custom-file-input form-control" name="upload_application" id="upload_app" />
                               	                <label class="custom-file-label form-control upload_app_label" for="upload_app">Upload </label>
                               	            </div>
                               	        </div>
                               	    </div>
                               	</div>

                               	<div class="col-lg-5 col-md-12 col-12">
                               	    <div class="form-group">
                               	        <label for="reamrks_" class="col-form-label">Reamrks</label>
                               	        <textarea class="form-control" name="reamrks" rows="1"></textarea>
                               	    </div>
                               	</div>
                                  
                                   
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item mb-0 mt-0">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Draft</button>
                                        </li>

                                        <li class="list-inline-item"><button type="button" class="btn btn-secondary uhl_common_btn">Post</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </section>
    </form>
</main>
<script>
$("body").addClass("sidebar-collapse");

</script>
