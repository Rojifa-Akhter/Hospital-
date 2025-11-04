<section id="create_lookup_item_mapping">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-lg-5 col-xl-12">
				<form action="">
					<div class="form-group row">
						<label for="lookup_no" class="col-sm-2 col-form-label col-form-label-sm">Lookup No</label>
						<div class="col-sm-4">
							<select class="form-control font_size_12 m-auto" id="lookup_no" name="lookup_no">
								<option selected="selected">Select Lookup No</option>
								<option value="">Lookup-1</option>
								<option value="">Lookup-1</option>
								<option value="">Lookup-1</option>
							</select>
						</div>

						<label for="lookup_mapping_1" class="col-sm-2 col-form-label col-form-label-sm">Mapping 1</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="lookup_mapping_1" name="lookup_mapping_1" value="" placeholder="Mapping 1">
						</div>
					</div>

					<div class="form-group row">
						<label for="lookup_mapping_2" class="col-sm-2 col-form-label col-form-label-sm">Mapping 2</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="lookup_mapping_2" name="lookup_mapping_2" value="" placeholder="Mapping 2">
						</div>

						<label for="lookup_mapping_description" class="col-sm-2 col-form-label col-form-label-sm"> Description</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="lookup_mapping_description" name="lookup_mapping_description" value="" placeholder="Description">
						</div>
					</div>

					<div class="form-group row">
						<label for="lookup_mapping_serial" class="col-sm-2 col-form-label col-form-label-sm">Serial No</label>
						<div class="col-sm-4">
							<input type="text" class="form-control form-control-sm" id="lookup_mapping_serial" name="lookup_mapping_serial" value="" placeholder="0">
						</div>

						<label for="lookup_status" class="col-sm-2 col-form-label col-form-label-sm">Status</label>
						<div class="col-md-4">
							<div class="form-check form-check-inline">
		                     	<input class="form-check-input" type="checkbox" name=" lookup_status" id="lookup_status" value="" >
		                     	<label class="form-check-label" for="lookup_status">Active</label>
		                    </div>
						</div>
					</div>
                    <div class="modal-footer mt-1">
						<button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
						<button type="button" class="btn btn-sm btn-success">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

