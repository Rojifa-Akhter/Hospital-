<div class="col-12 table-responsive" >
	<table class="table data-table table-striped table-bordered table-hover mb-0">
		<thead class="bg-primary">
			<tr>
				<th class="text-center">SL</th>
				<th class="text-center">Patient Name</th>
				<th class="text-center">Patient ID</th>
				<th class="text-center">Gender</th>
				<th class="text-center">Age</th>
				<th class="text-center">Request ID</th>
				<th class="text-center">Request Date</th>
				<th class="text-center">Department</th>
				<th class="text-center">Cancel Reason</th>
			</tr>
		</thead>
		<tbody>
			@if(!empty($referedCancelledPatients))
				@foreach($referedCancelledPatients as $rp)
					<tr>
						<td class="text-center">{{ $loop->iteration }}</td>
						<td class="text-left">{{ !empty($rp->patient_name)? $rp->patient_name: '' }}</td>
						<td class="text-left">{{ !empty($rp->patient_code)? $rp->patient_code: '' }}</td>
						<td class="text-left">{{ !empty($rp->gender_txt)? $rp->gender_txt: '' }}</td>
						<td class="text-left">{{ !empty($rp->age)? $rp->age: '' }}</td>
						<td class="text-left">{{ !empty($rp->admission_req_uid)? $rp->admission_req_uid: '' }}</td>
						<td class="text-left">{{ !empty($rp->admission_req_date)? date('d/m/Y', strtotime($rp->admission_req_date)): '' }}</td>
						<td class="text-left">{{ !empty($rp->serviceunit_name)? $rp->serviceunit_name: '' }}</td>
						<td class="text-left">{{ !empty($rp->cancel_reason)? $rp->cancel_reason: '' }}</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>