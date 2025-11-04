<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{route('hrm.salary_sheet_update_frm_attendance')}}" method="post" id="Monthly_attendance_store">
<table class="table table-bordered table-hover table-striped">
	<thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Employee Card</td>
            <td class="text-left" scope="col">Employee Name</td>
            <td class="text-left" scope="col">Department</td>
            {{-- <td class="text-left" scope="col">Shift</td> --}}
            <td class="text-center" scope="col">Late Count (Days)</td>
            <td class="text-center" scope="col">Action</td>
        </tr>
	</thead>
	<tbody>
		@if(isset($monthlyLateData))
			@foreach($monthlyLateData as $data)
			<tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-left">{{$data->person_card_no}}</td>
                <td class="text-left">{{$data->full_name}}</td>
                <td class="text-left">{{$data->serviceunit_name}}</td>
                {{-- <td class="text-left" scope="col">

                    <table>
                        <tr>
                            <td class="border-0 text-left" colspan="2"> {{ $data->shift_code }} </td>

                        </tr>
                        <tr>
                            <td class="border-0 text-left"> <strong>Duty In </strong> </td>
                            <td class="border-0 text-left"> :
                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 text-left"> <strong>Duty Out </strong> </td>
                            <td class="border-0 text-left"> :
                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}
                            </td>
                        </tr>
                    </table>

                </td> --}}
                <td class="text-center">{{$data->late_days}}</td>
                <td class="text-center">
                    <a style="cursor:pointer" class="open-modal btn btn-sm btn-secondary" data-action="{{ route('hrm.employee_late_detail',[$data->person_no_fk, $month_year, $department, $card_num]) }}"  data-modal="common-modal-md" data-title="Employee Late Detail"  title="Detail">
                        <i class="fa fa-eye" aria-hidden="true" style="color: #fff !important"></i>
                    </a>
                </td>

            </tr>
			@endforeach
		@endif
	</tbody>
</table>
<div style="text-align:center;">
    @php
        $response_action = route('hrm.attendence-monthly-data');
    @endphp
    <button type="button" class="btn btn-success btn-md text-center" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
</div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
 $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ]
    });
</script>
