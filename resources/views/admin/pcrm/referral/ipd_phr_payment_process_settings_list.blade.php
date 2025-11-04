<div class="card">
	<div class="card-body">
		<div class="row mt-2">
			<div class="col-md-12 table-responsive">
				<table id="datatable" class="table table-bordered table-hover table-striped">
					<thead class="bg-primary">
						<tr>
							<th class="text-center" >Sl#</th>
							<th class="text-center" >Type</th>
							<th class="text-left" >Tytpe Name</th>
							<th class="text-center" >Status</th>
                            <th class="text-center" >Actions</th>
						</tr>


					</thead>
					<tbody>

						@if(isset($data))
						@foreach($data as $sample_row)
						<tr>

							<td  class="border-0 text-center">  {{ $loop->iteration }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->ipd_setting_type }}</td>
							<td  class="border-0 text-left">  {{ $sample_row->ipd_setting_name }}</td>
							<td  class="border-0 text-center">  {{ $sample_row->status ==1 ? 'Active': 'Inactive' }}</td>
							<td  class="border-0 text-center">
                                <input type="hidden" name="" id="ipd_medicine_inv_set_no_pk" value="{{ $sample_row->ipd_medicine_inv_set_no_pk}}">
                                <input type="hidden" name="" id="ipd_setting_type" value="{{ $sample_row->ipd_setting_type }}">
                                <input type="hidden" name="" id="ipd_setting_name" value="{{ $sample_row->ipd_setting_name }}">
                                <input type="hidden" name="" id="status" value="{{ $sample_row->status}}">

                                <span class="btn btn-sm btn-primary " title="Edit" onclick="editData(this)"> <i class="fa fa-pencil-alt"></i></span>
                            </td>
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>





