<div class="container-fluid">
	<div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
		<div class="col-md-12">
			<h5 class="mt-2 mb-0">Sample Collection</h5>
			<small>Pathology / Sample Collection</small>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><h5><i class="fa fa-search"></i> Search Panel</h5></div>
				<div class="card-body pt-3">
					<div class="row justify-content-center">
						<div class="col-md-6">
							<div class="form-group row justify-content-center">
								<div class="col-sm-6">
									<input type="text" class="form-control m-0" id="prescription_uid" name="prescription_uid" value=""  placeholder="Invoice No" >
									<input type="hidden" name="hdn_presc_id" id="hdn_presc_id" />
								</div>

								<div class="col-sm-3">
									<button class="btn btn-md btn-success btn-block" onclick="pathologyFunc.searchSampleCollectionListByPresc(this)" data-action="{{ route('path.search-sample-collection') }}"> <i class="fa fa-search mr-1"></i> Search</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mt-1" id="sample-container">
		@include('admin.pathology.sample_collection_list')
	</div>
</div>
