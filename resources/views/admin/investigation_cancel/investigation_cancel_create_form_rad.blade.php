<form method="post" id="frm-result_entry" action="{{ route('path.store-result-entry') }}" enctype="multipart/form-data" action="javascript:void(0)">
	@csrf
	<input type="hidden" name="hdn_report_id" value="" />

	<div class="card">
		<div class="card-body p-2">
			<div class="form-row justify-content-center mt-2">
				<div class="col-md-8">
					<table class="table table-bordered mb-0">
						<tr>
							<th class="text-left">Patient No</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->patient_code :'' }}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
							<th class="text-left">Admission No</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->admission_no_pk :''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
							<th class="text-left">Delivery Date</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) && $patient_info->report_delivary_date !=null ? date('d/m/Y', strtotime($patient_info->report_delivary_date))  :''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
						</tr>
						<tr>
							<th class="text-left">Invoice No</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->invoice_no_fk : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
							{{-- <th class="text-left">Ref Invoice No</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->patient_code : ''}}" placeholder="" style="margin-bottom: 0px!important;">
							</td> --}}
							<th class="text-left">Invoice Date</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) && $patient_info->invoice_date !=null ? date('d/m/Y',strtotime($patient_info->invoice_date)): ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
                            <th class="text-left">Patient Name</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->patient_name : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
						</tr>
						<tr>

							<th class="text-left">Age</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->age  : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
							<th class="text-left">Gender</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->gender_txt: ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
                            <th class="text-left">Mobile</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) && $patient_info->mobile1 !=null ?$patient_info->mobile1 : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
						</tr>
						<tr>

							<th class="text-left">Blood Group</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->blood_group_txt : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
							<th class="text-left">Maritial Status</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->marital_status_txt : ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
                            <th class="text-left">Ref Doc Name</th>
							<td><input class="form-control form-control-sm" type="text" id="" name="" value="{{!empty($patient_info) ?$patient_info->full_name: ''}}" placeholder="" style="margin-bottom: 0px!important;" readonly>
							</td>
						</tr>
						<tr>
							<th class="text-left">Remarks
							</th>
							<td colspan="3"><input class="form-control form-control-sm" type="text" id="" name="{{!empty($patient_info) ?$patient_info->remarks_text:''}}" value="" placeholder="" style="margin-bottom: 0px!important;">
							</td>

						</tr>

					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="" style="overflow: auto;">
    @if ($item_info !=null)
    @foreach ( $item_info  as $value)
		<div class="d-flex align-items-center checked_ind" style="width: 150%;" id="checked_ind_{{$value->radinvoicedtl_no_pk}}" data-lab_no="{{$value->radinvoicedtl_no_pk}}">
            {{-- <div class="card" style="width: 33.3%; ">
				<div class="card-body p-2">
					<div class="d-flex align-items-start"> --}}
						<div class="m-1 p-2 border" style="min-height: 115px;">
							<div class="form-group  m-0 mb-2">
							 <label for="lab_no" class="col-form-label s-12">Rad Detail No</label>
								<input type="text" class="form-control form-control-sm " id="lab_no" name="lab_no"  value="{{$value->radinvoicedtl_no_pk}}" placeholder="Lab No.">
							</div>
							<div class="form-group  m-0" style="margin-bottom: 0px!important;">
							<label for="mobile_no" class="col-form-label s-12">Exam Name</label>
								<input type="text" class="form-control form-control-sm " id="exam_name" name="exam_name" value="{{$value->item_name}}" placeholder="Exam Name" style="margin-bottom: 0px!important;">
							</div>
						</div>
						{{-- <div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Radiology App. </strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RA?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}"  data-cancel_value="{{"RADAPP"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->ic_image_capture_key_ind}}" @if ($value->ic_image_capture_key_ind == 1) checked @else disabled @endif  onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->ic_image_capture_keyed_by}}" placeholder="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->ic_image_capture_keyed_time ? date('d/m/Y', strtotime($value->ic_image_capture_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div> --}}
						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Image Capture </strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">IC?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}"  data-cancel_value="{{"IMGCAP"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->ic_image_capture_key_ind}}" @if ($value->ic_image_capture_key_ind == 1) checked @else disabled @endif  onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->ic_image_capture_keyed_by}}" placeholder="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->ic_image_capture_keyed_time ? date('d/m/Y', strtotime($value->ic_image_capture_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>
						{{-- <div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Lab Receive Unit</strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RVC?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"SAMRCV"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->lab_rcv_from_sp_key_ind}}" @if ($value->lab_rcv_from_sp_key_ind == 1) checked @else disabled  @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->lab_rcv_from_sp_keyed_by}}" placeholder="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->lab_rcv_from_sp_keyed_time ? date('d/m/Y', strtotime($value->lab_rcv_from_sp_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div> --}}
					{{-- </div>
				</div>
			</div> --}}

			{{-- <div class="card" style="width: 33.3%; ">
				<div class="card-body p-2">
					<div class="d-flex align-items-start"> --}}

						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Prepared Unit</strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RPP?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESENT"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->result_prepared_key_ind}}" @if ($value->result_prepared_key_ind == 1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_prepared_keyed_by}}" placeholder="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_prepared_keyed_time ? date('d/m/Y', strtotime($value->result_prepared_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>

						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Verify Unit </strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RV?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESVER"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->result_verify_key_ind}}" @if ($value->result_verify_key_ind == 1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_verify_keyed_by}}" placeholder="" >
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_verify_keyed_time ? date('d/m/Y', strtotime($value->result_verify_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>
						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Finalize </strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RF?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESFINAL"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->result_final_key_ind}}" @if ($value->result_final_key_ind ==1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_final_keyed_by}}" placeholder="" >
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_final_keyed_time ? date('d/m/Y', strtotime($value->result_final_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>

					{{-- </div>
				</div>
			</div> --}}

			{{-- <div class="card" style="width: 33.3%; ">
				<div class="card-body p-2">
					<div class="d-flex align-items-start"> --}}
						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Result Print Unit</strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RP?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESPRINT"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->result_print_key_ind}}" @if ($value->result_print_key_ind == 1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_print_keyed_by}}" placeholder="" >
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->result_print_keyed_time ? date('d/m/Y', strtotime($value->result_print_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>
						{{-- <div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;">Report Processing Unit</strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label" for="" style="font-size:12px;">RPC?</label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESPROCS"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->report_procees_ind}}" @if ($value->report_procees_ind ==1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->report_procees_keyed_by}}" placeholder="" >
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->report_procees_keyed_time ? date('d/m/Y', strtotime($value->report_procees_keyed_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div> --}}
						<div class="m-1 p-2 border" style="min-height: 115px;">
							<strong class="mb-2 border-bottom d-block" style="font-size: 12px; padding-bottom: 7px; font-style: italic;"> <i>Report Delivery Unit</i></strong>
							<div class="d-flex align-items-start">
								<div class="form-check form-check-inline">
									<label class="form-check-label " for="">RDV? </label>
									<input class="form-check-input ml-2 check_box_{{$value->radinvoicedtl_no_pk}}" type="checkbox" id="{{$value->radinvoicedtl_no_pk}}" data-cancel_value="{{"RESDEL"."_".$value->radinvoicedtl_no_pk."_".$value->rad_report_no_pk}}" value="{{$value->delivered_ind}}" @if ($value->delivered_ind ==1) checked @else disabled @endif onclick="cancel(this)" data-prev="check_box_{{$value->radinvoicedtl_no_pk}}">
								</div>
								<div class="">
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->delivered_keyed_by}}" placeholder="" >
									<input class="form-control form-control-sm" type="text" id="" name="" value="{{$value->delivered_time ? date('d/m/Y', strtotime($value->delivered_time)) : ''}}" placeholder="" style="margin-bottom: 0px!important;">
								</div>
							</div>
						</div>
					{{-- </div>
				</div>
			</div> --}}

		</div>
    @endforeach
    @endif

	</div>
</form>
