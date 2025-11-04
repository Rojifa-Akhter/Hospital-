<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
               <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Prepare Letter </h5>
                        <small>HRM / Prepare Letter</small>
                    </div>
                </div>


               <div class="row">
               	<div class="col-md-12">
               		<div class="card">
               			<div class="card-body">
               				<div class="form-row">
               					<div class="col-lg-4 col-md-6 col-12">
               					    <div class="form-group">
               					        <label for="letter_name" class="col-form-label">Letter Name</label>
               					        <input type="text" class="form-control form-control-sm" id="letter_name" name="letter_name" placeholder="" value="" />
               					    </div>
               					</div>


               					<div class="col-lg-2 col-md-6 col-12">
               					    <div class="form-group">
               					        <label for="emp-id" class="col-form-label">Emp ID</label>
               					        <input type="text" class="form-control form-control-sm" id="emp-id" name="emp-id" placeholder="" value="" />
               					    </div>
               					</div>


               					<div class="col-lg-3 col-md-6 col-12">
               					    <div class="form-group">
               					        <label for="name" class="col-form-label">Name</label>
               					        <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="" value="" />
               					    </div>
               					</div>


               					<div class="col-lg-3 col-md-6 col-12">
               					    <div class="form-group">
               					        <label for="designation" class="col-form-label">Designation</label>
               					        <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="" value="" />
               					    </div>
               					</div>


               					<div class="col-lg-3 col-md-6 col-12">
               					    <div class="form-group">
               					        <label for="department" class="col-form-label">Department</label>
               					        <input type="text" class="form-control form-control-sm" id="department" name="department" placeholder="" value="" />
               					    </div>
               					</div>
               				</div>
               			</div>
               		</div>
               	</div>
               </div>

               <div class="row">
               	<div class="col-lg-12">
               		<div class="card">
               			<div class="card-body">
               				<div class="form-group">
               				    <ul class="list-inline btn__box">

               				        <li class="list-inline-item mb-0 mt-0">
               				            <button type="button" class="btn btn-secondary uhl_common_btn " id="">Preview</button>
               				        </li>
               				        <li class="list-inline-item"><button type="button" class="btn btn-danger uhl_common_btn">Edit</button></li>

               				        <li class="list-inline-item"><button type="button" class="btn btn-danger uhl_save_btn">Post</button></li>
               				    </ul>
               				</div>
               			</div>
               		</div>
               	</div>
               </div>

               <div class="row">
               	<div class="col-md-12">
               		<div class="card">
               			<div class="card-body">
               				<div class="form-row">
               					<div class="col-lg-12 col-md-12 col-12">
               					    <div class="form-group">
               					        <textarea class="form-control" id="" rows="12"></textarea>
               					    </div>
               					</div>

               					<div class="col-lg-12">
               						<div class="form-group">
               						    <ul class="list-inline btn__box">

               						        <li class="list-inline-item mb-0 mt-0">
               						            <button type="button" class="btn btn-secondary uhl_save_btn" id="">Save</button>
               						        </li>

               						        <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li>
               						    </ul>
               						</div>
               					</div>

 
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
