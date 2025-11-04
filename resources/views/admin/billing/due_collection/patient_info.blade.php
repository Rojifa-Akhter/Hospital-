		<div class="col-md-5">
			<div class="card shadow-sm mt-1">
				<div class="card-header"><h5>Customer Information</h5></div>
				<div class="card-body p-2 d-flex align-items-center" id="p_info">
					<input type="hidden" name="hdn_patient_id" value="{{ isset($patient_info->patient_no_pk)? $patient_info->patient_no_pk:''}} ">					
					<input type="hidden" name="hdn_admission_id" value="{{ isset($patient_info->admission_no_pk)? $patient_info->admission_no_pk:''}} ">					
					<input type="hidden" name="hdn_invoice_no" value="{{ isset($patient_info->invoice_no_pk)? $patient_info->invoice_no_pk:''}} ">
					<div class="patient-infos"  >
						<table class="table mb-0 table-borderless">
							<tbody id="p_info">
								<tr>
									<th class="text-left">{{ isset($patient_info->patient_name)? "Name":"" }}</th>
									<td colspan="3" class="text-left" id="p_name">{{ isset($patient_info->patient_name)? ":  $patient_info->patient_name":"" }}</td>
								</tr>

								<tr>
									<th class="text-left">{{ isset($patient_info->age)? "Age":"" }}</th>
									<td class="text-left" id="p_age">{{ isset($patient_info->age)? ": $patient_info->age":"" }}</td>
									<th class="text-left">{{ isset($patient_info->gender_txt)? " Gender":"" }}</th>
									<td class="text-left" id="p_gender">{{ isset($patient_info->gender_txt)? " : $patient_info->gender_txt":"" }}</td>
								</tr>
								<tr>
									<th class="text-left">{{ isset($patient_info->blood_group_txt)? "Blood Group":"" }}</th>
									<td class="text-left" id="p_blood">{{ isset($patient_info->blood_group_txt)? " : $patient_info->blood_group_txt":"" }}</td>
									<th class="text-left">{{ isset($patient_info->marital_status_txt)? "Marital Status":"" }}</th>
									<td class="text-left" id="p_married">{{ isset($patient_info->marital_status_txt)? ": $patient_info->marital_status_txt":"" }}</td>
								</tr>
								<tr>
									<th class="text-left">{{ isset($patient_info->present_addr)? " Address":"" }}</th>
									<td colspan="3" class="text-left" id="p_adderss"> {{ isset($patient_info->present_addr)? " : $patient_info->present_addr":"" }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="patient-img text-center">
						<img class="w-100 rounded" src="{{ asset('images/user.jpg') }}" alt="">
					</div>
				</div>
			</div>
		</div>