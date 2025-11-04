<form action="{{ route('store-allergy') }}" method="post" id="allergy-create">
	@csrf
	<table class="table border-0 mt-2 mb-0">
		<thead>
			<tr class="border-0">
				<th class="p-0 px-1 border-0 w-25">Type <span class="text-danger">*</span> </th>
				<th class="p-0 px-1 border-0 w-25">Allergy <span class="text-danger">*</span> </th>
				<th class="p-0 px-1 border-0 w-25">Severity</th>
				<th class="p-0 px-1 border-0 w-25">Remarks</th>
			</tr>

			<tr class="border-0">
				<td class=" border-0">
					<select id="cmb_type" name="cmb_type" class="form-control" required>
						<option value="">Select</option>

						@if(!empty($lookup_data->ALLERGYCAT))
						@foreach($lookup_data->ALLERGYCAT as $ld)
						<option value="{{ $ld->lookupdata_uid }}">{{ $ld->lookupdata_name }}</option>
						@endforeach
						@endif
					</select>
				</td>
				<td class=" border-0" id="allergy_con">
					<input type="text" class="form-control form-control-sm m-0 p-0 item_element" id="medicine_item" name="medicine_item" placeholder="Generic / Brand" required='required'>
					<input type="text" class="form-control form-control-sm m-0 p-0 d-none item_element" id="free_text" name="" placeholder="Others">

					<input type="hidden" id="medicine_item_id" name="medicine_item_id">

					<select id="cmb_allergy" name="cmb_allergy" class="form-control d-none">
						<option value="">Select</option>
						@if(!empty($lookup_data->ALLERGY))

						@foreach($lookup_data->ALLERGY as $ld)
                        @if ($ld->lookupdata_id)
                        <option value="{{ $ld->lookupdata_id }}">{{ $ld->lookupdata_name }}</option>
                        @endif

						@endforeach
						@endif
					</select>
				</td>
				<td class=" border-0">
					<select id="cmb_severity" name="cmb_severity" class="form-control">
						<option value="0">Select</option>
						@if(!empty($lookup_data->ALLGSEVERITY))
						@foreach($lookup_data->ALLGSEVERITY as $ld)
						<option value="{{ $ld->lookupdata_id }}">{{ $ld->lookupdata_name }}</option>
						@endforeach
						@endif
					</select>
				</td>
				<td class=" border-0">
					<input type="text" class="form-control" id="txt_remarks" name="txt_remarks" placeholder="Write Remarks">
				</td>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

	<div class="modal-footer pl-0">
		<button type="submit" class="btn btn-success btn-md ml-0"  onclick="prescriptionFunc.storeAllergyData(this)">Save</button>
		<button type="button" class="btn btn-danger btn-md" title="Click here to close the window"  data-dismiss="modal">Close</button>
	</div>
</form>
<script type="text/javascript">
	openItemAutocomplete($("#medicine_item"), 'MED','#medicine_item_id','#medicine_item');
</script>
