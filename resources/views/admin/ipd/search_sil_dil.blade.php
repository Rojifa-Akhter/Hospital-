<table class="table data-table table-bordered table-hover table-striped no-footer mb-0">
	<thead>
		<tr class="bg-primary">
			<th>SL#</th>
			<th>Date</th>
			<th>Patient</th>
			<th>Listing</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@if($sil_dil_list)
		@foreach($sil_dil_list as $record)
			<tr>
				<td>{{$loop->iteration}}</td>
				<td>{{!empty($record->sil_dil_date)?date('d/m/Y',strtotime($record->sil_dil_date)):null}}</td>
				<td>
					<div class="participent_info d-flex align-items-center">
						<div class="participent_img">
							@if(!empty($record->patient_photo))
								<img class="w-100" src="{{asset ('img/uploads/patient_images/thumb/')}}/{{$record->patient_photo }}" alt="">
							@else
								@if($record->gender_txt =="Male")
									<img class="w-100" src="{{ asset('img/boy.jpg') }}" alt="">
								@else
									<img class="w-100" src="{{ asset('img/girl.jpg') }}" alt="">
								@endif
							@endif
						</div>

						<div class="participent_details">
							<span class="d-block"><strong>Service ID</strong> :&nbsp;{{ !empty($record->service_number)? $record->service_number: '' }}</span>
							<span class="d-block"><strong>Name</strong> :&nbsp;{{ !empty($record->patient_name_rank)? $record->patient_name_rank: '' }}</span>
							<span class="d-block"><strong>AGE</strong> :&nbsp;{{ !empty($record->age)? $record->age: '' }}</span>
						</div>
					</div>
				</td>
				<td class="text-center">
					@if($record->sil_dil_ind == "SIL")
					<span class="btn btn-sm btn-warning"> {{!empty($record->sil_dil_ind)?$record->sil_dil_ind:''}}</span>
					@else
					<span class="btn btn-sm btn-danger"> {{!empty($record->sil_dil_ind)?$record->sil_dil_ind:''}}</span>
					@endif
				</td>
				<td>
					<button title="Delete the Patient"
										type="button"
										data-ipd_sil_dil_no_pk="{{ $record->ipd_sil_dil_no_pk }}"
										class="btn btn-sm btn-danger sildil-pat-delete-btn"><i class="fa fa-times-circle"></i></button>
				</td>
			</tr>
		@endforeach
		@endif
	</tbody>
</table>