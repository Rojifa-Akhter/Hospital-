<section id="create_Policy">
	<div class="container-fluid">
		<nav class="mt-3">
			<div class="nav nav-tabs" id="nav-tab" role="tablist">

				<a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="{{ route('policy.index') }}" rel="tab" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-plus"></i> Add New Policy</a>

				<a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="{{ route('policy.comission') }}" rel="tab" role="tab" aria-controls="nav-home" aria-selected="true">Policy Commission Setup</a>

			</div>
		</nav>
		<div class="tab-content" id="nav-tabContent">
			<div class="row">
				<div class="col-sm-12 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-header"><h5>Create Policy</h5></div>
						<div class="card-body mt-2">
							<form action="{{ route('policy.store') }}" method="post" id="frmPolicy">
								@csrf
								<div class="form-row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="cmb_apply_to">Apply To</label>
											<select class="form-control font_size_12 m-auto" id="cmb_apply_to" name="cmb_apply_to">
												<option value="">Select</option>
												@if(isset($apply_to))
												@foreach($apply_to as $key => $val)
												<option value="{{$key}}">{{$val}}</option>
												@endforeach
												@endif
											</select>
										</div>
										<div class="form-group">
											<label for="txt_policy_code">Policy Code</label>
											<input type="text" class="form-control" id="txt_policy_code" name="txt_policy_code">
										</div>
										<div class="form-group">
											<label class=" mt-1" for="txt_policy_name">Policy Name</label>
											<input type="text" class="form-control" id="txt_policy_name" name="txt_policy_name">
										</div>
									</div>									
								</div>
								<div class="form-row">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-md btn-success" onclick="btnSaveUpdate(this)">Save</button>
										<button type="reset" class="btn btn-danger btn-md" title="Click here to Clear form data">Clear</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					@include('admin.settings.policy.policy_list')
				</div>
			</div>
		</div>

	</div>
</section>