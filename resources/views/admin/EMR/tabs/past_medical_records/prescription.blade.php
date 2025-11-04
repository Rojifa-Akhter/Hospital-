<div class="form-row mt-3">
	<div class="col-12 table-responsive" >
		<table class="table table-striped table-bordered table-hover mb-0">
			<thead class="bg-primary">
				<tr>
					<th class="text-center">SL</th>
					<th class="text-center">Prescription ID</th>
					<th class="text-center">Patient Name</th>
					<th class="text-center">Gender</th>
					<th class="text-center">Age</th>
					<th class="text-center">Department</th>
					<th class="text-center">Date</th>
					<th class="text-center">Hospital</th>
					<th class="text-center">Doctor Signature</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				@if(isset($prescription_data))
					@foreach($prescription_data as $value)
					<tr>
						<td class="text-center">{{$loop->iteration}}</td>
						<td class="text-left">{{$value->prescription_uid}}</td>
						<td class="text-left">{{$value->patient_name}}</td>
						<td class="text-left">{{$value->gender_txt}}</td>
						<td class="text-left">{{$value->age}}</td>
						<td class="text-left">{{$value->su_name}}</td>
						<td class="text-left">{{date("d/m/Y", strtotime($value->au_entry_at))}}</td>
						<td class="text-left">{{$value->hospital_code}}</td>
						<td class="text-left"><?php echo $value->doctor_signature; ?></td>
						<td class="text-center">
							<a href="{{ route('opd_prescription_print_pdf_uhl', $value->prescription_no_pk) }}" class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank" data-id="{{ $value->prescription_no_pk }}"  title="Print Prescription"><i class="fa fa-file-pdf"></i></a>
							
						</td>
					</tr>
					@endforeach
				@else
					<tr>
						<td colspan="10" class="text-center">No Data Found</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>
