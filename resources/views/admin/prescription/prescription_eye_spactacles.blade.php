<div class="row">
	<div class="col-md-5">
		<div class="form-group text-center">
			<img width="250" src="{{ asset('images/eye_axis.png') }}">
		</div>
	</div>
	<div class="col-md-2"></div>
	<div class="col-md-5">
		<div class="form-group text-center">
			<img width="250" src="{{ asset('images/eye_axis.png') }}">
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group bg-light p-2">
			<div class="form-row">
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_r_dv_sph"><strong>Sph.</strong></label>
					{{-- @if (!empty($pat_eye_rs))
						@dd($pat_eye_rs)
					@endif --}}
					<input type="text" class="form-control" id="txt_r_dv_sph" name="txt_r_dv_sph" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->sph_right_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_r_dv_cyl"><strong>Cyl</strong></label>
					<input type="text" class="form-control" id="txt_r_dv_cyl" name="txt_r_dv_cyl" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->cyl_right_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_r_dv_axis"><strong>Axis</strong></label>
					<input type="text" class="form-control" id="txt_r_dv_axis" name="txt_r_dv_axis" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->axis_left_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_r_dv_va"><strong>VA</strong></label>
					<input type="text" class="form-control" id="txt_r_dv_va" name="txt_r_dv_va" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->va_right_dv:'' }}">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_r_nv_sph" name="txt_r_nv_sph" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->sph_right_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_r_nv_cyl" name="txt_r_nv_cyl" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->cyl_right_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_r_nv_axis" name="txt_r_nv_axis" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->axis_right_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_r_nv_va" name="txt_r_nv_va" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->va_right_nv:'' }}">
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label class="text-center w-100 mt-4" for="inputEmail4"><strong>DV</strong></label>
			<label class="text-center w-100 mt-3" for="inputEmail4"><strong>NV</strong></label>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group bg-light p-2">
			<div class="form-row">
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_l_dv_sph"><strong>Sph.</strong></label>
					<input type="text" class="form-control" id="txt_l_dv_sph" name="txt_l_dv_sph" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->sph_left_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_l_dv_cyl"><strong>Cyl</strong></label>
					<input type="text" class="form-control" id="txt_l_dv_cyl" name="txt_l_dv_cyl" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->cyl_left_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_l_dv_axis"><strong>Axis</strong></label>
					<input type="text" class="form-control" id="txt_l_dv_axis" name="txt_l_dv_axis" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->axis_right_dv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<label class="text-center w-100" for="txt_l_dv_va"><strong>VA</strong></label>
					<input type="text" class="form-control" id="txt_l_dv_va" name="txt_l_dv_va" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->va_left_dv:'' }}">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_l_nv_sph" name="txt_l_nv_sph" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->sph_left_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_l_nv_cyl" name="txt_l_nv_cyl" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->cyl_left_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_l_nv_axis" name="txt_l_nv_axis" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->axis_left_nv:'' }}">
				</div>
				<div class="form-group col-md-3">
					<input type="text" class="form-control" id="txt_l_nv_va" name="txt_l_nv_va" value="{{ !empty($pat_eye_rs) ? $pat_eye_rs->va_left_nv:'' }}">
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<div class="border-top"></div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_r_add" class="col-form-label col-form-label-sm">Add</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_r_add" name="txt_r_add" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->add_right:'' }}">
			<div class="card mt-0"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_l_add" class="col-form-label col-form-label-sm">Add</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_l_add" name="txt_l_add" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->add_left:'' }}">
			<div class="card mt-0"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_ipd" class="col-form-label col-form-label-sm">I.P.D</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_ipd" name="txt_ipd" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->i_p_d:'' }}">
			<div class="card mt-0"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_spec_remarks" class="col-form-label col-form-label-sm">Remarks</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_spec_remarks" name="txt_spec_remarks" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->remarks_txt:'' }}"> <div class="card mt-0"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_glass" class="col-form-label col-form-label-sm">Glass</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_glass" name="txt_glass" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->glass_type:'' }}">
			<div class="card mt-0"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="txt_usage_type" class="col-form-label col-form-label-sm">Usage Type</label>
			<input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0" id="txt_usage_type" name="txt_usage_type" value="{{ !empty($pat_eye_rs)?$pat_eye_rs->usage_type:'' }}">
			<div class="card mt-0"></div>
		</div>
	</div>
</div>
