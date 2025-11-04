<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<table class="table data-table  table-bordered table-hover table-striped" id="appointment_slot">
	<thead class="bg-primary">
		<tr>
			<th class="text-center" style="width:10%">SL</th>
			{{-- <th class="text-left">Schedule Date</th> --}}
            @if (Session::get('user.ses_hospital_code') != 'UNICO')
			<th class="text-left">S.Time</th>
			<th class="text-left">E.Time</th>
            @else
            <th class="text-center">Duration</th>
            @endif
			<th class="text-left">Booked</th>

		</tr>

	</thead>
	<tbody>
       <input type="text" class="d-none" id="doc_slot_ind" value="{{$slot_ind}}">
		@if (isset($slot_details))

		@foreach ($slot_details as $data)
		<tr id="mytable">
			<td class="text-center">{{ $loop->iteration }}</td>
            {{-- <td>
                {{ date("d-m-Y", strtotime($data->schedule_dt)) }}
            </td> --}}
            @if (Session::get('user.ses_hospital_code') != 'UNICO')
			<td class="text-left ">{{ date('h:i A', strtotime($data->start_time)) }}</td>
			<td class="text-left ">{{ date('h:i A', strtotime($data->end_time)) }}</td>
            @else
            <td class="text-center ">{{ date('h:i A', strtotime($data->start_time)) }} - {{ date('h:i A', strtotime($data->end_time)) }}</td>
            @endif
			<td class="text-center">

                {{-- <input class="form-check-input scheduletype" name="slot" type="checkbox" id="slot" value="1"> --}}
                @if(isset($data->available_ind) && $data->available_ind ==1)
                <div class="form-check form-check-inline">
                    <input class="form-check-input scheduletype" name="slot" type="checkbox" onclick="getTime('{{date('h:i A', strtotime($data->start_time))}}','{{date('h:i A', strtotime($data->end_time))}}','{{$data->slot_no_pk}}')">
                    {{-- <label class="form-check-label" for="slot">Slot</label> --}}
                </div>
                 @else

                <div class="form-check form-check-inline">
                    <input class="form-check-input scheduletype" name="slot" type="checkbox" checked disabled>
                    {{-- <label class="form-check-label" for="slot">Slot</label> --}}
                </div>
                @endif

                </td>

			{{-- <td class="text-right">{{ number_format($data->product_price,2) }}</td> --}}
			{{-- <td class="text-right">{{ number_format($data->product_price*$data->quantity,2) }}</td> --}}

		</tr>
		@endforeach
		@endif
	</tbody>
</table>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
        $("#appointment_slot").DataTable({
            "searching": false,
            "ordering": false,
            "pageLength": 5,
            "info": false,
            "bLengthChange": false,
			"bAutoWidth": false,
            "paging": false



});
$('input.scheduletype').on('change', function() {
    $('input.scheduletype').not(this).prop('checked', false);
   });

    var slot_ind = $('#doc_slot_ind').val();
  // $('#doc_slot_ind_val_').val(slot_ind);

   get_doctor_slot_ind(slot_ind);


</script>
