<table class="table data-table table-striped table-bordered table-hover mb-0">
	<thead class="bg-primary">
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Patient Name</th>
            <th class="text-center">Prescription ID</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Ward Name</th>
            {{--												<th class="text-center">Base/Unit</th>--}}
            <th class="text-center">Age</th>
            <th class="text-center">Requisition Date</th>
            <th class="text-center">Operation</th>
            <th class="text-center">Rejected Date</th>
            <th class="text-center">Rejected By</th>
            <th class="text-center">Rejected Note</th>
        </tr>
	</thead>
	<tbody>
		@if($ot_rejection_list)
			@foreach($ot_rejection_list as $ot_rejection)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-left">{{!empty($ot_rejection->patient_name)?$ot_rejection->patient_name:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->prescription_uid)?$ot_rejection->prescription_uid:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->admission_uid)?$ot_rejection->admission_uid:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->ward_name)?$ot_rejection->ward_name:''}}</td>
                    {{--													<td class="text-left">{{!empty($ot_rejection->pat_unit)?$ot_rejection->pat_unit:''}}</td>--}}
                    <td class="text-left">{{!empty($ot_rejection->age)?$ot_rejection->age:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->ot_req_date)?date('d/m/Y', strtotime($ot_rejection->ot_req_date)):''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->item_name)?$ot_rejection->item_name:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->reject_time)?date('d/m/Y', strtotime($ot_rejection->reject_time)):''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->reject_by)?$ot_rejection->reject_by:''}}</td>
                    <td class="text-left">{{!empty($ot_rejection->reject_note)?$ot_rejection->reject_note:''}}</td>
                </tr>
			@endforeach
		@endif

	</tbody>
</table>
