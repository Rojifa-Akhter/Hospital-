@include('admin.appointment.appointment_list_header_stat')

			<div id="appointment-list">
				<div class="table-responsive">
					<div class="card-body mt-3">
						<table class="table data-table table-striped table-bordered table-hover">
							<thead class="bg-primary">
								<tr>
									<th class="text-center" scope="col"></th>
									<th class="text-center" scope="col">SL</th>
									<th class="text-center" scope="col">User Name</th>
									<th class="text-center" scope="col">Appointment No</th>
									<th class="text-center" scope="col">Date</th>
									<th class="text-center" scope="col">Entry Date</th>
									<th class="text-center" style = "width: 15%" scope="col">Time</th>
									<th class="text-center " scope="col">Doctor</th>
									<th class="text-center " scope="col">Patient</th>
									{{-- <th class="text-center" scope="col">CC</th>
									<th class="text-left" scope="col">Priority</th> --}}
									<th class="text-center" scope="col">Patient Type</th>
									<th class="text-center" scope="col">Agent Name</th>
									<th class="text-left" scope="col">Status</th>
									<th class="text-center" scope="col" style="width: 16%;">Action</th>
								</tr>
							</thead>
							<tbody>
								@include('admin.patient.appointment_list_table')
							</tbody>
						</table>
					</div>
				</div>

			</div>
