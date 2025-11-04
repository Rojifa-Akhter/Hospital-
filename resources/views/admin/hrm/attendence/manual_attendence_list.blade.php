<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">



<table class="table table-bordered   data-table" border="1">
    <thead class="global-uhl-table-bg">
        <tr>
           <th class="text-left">SL#</th>
            <th class="text-left">Employee</th>
            <th class="text-left">Date</th>
            <!-- <th class="text-center">Person Card Number</th> -->
            <!-- <th class="text-center">Name</th> -->
            <th class="text-left">Dept.</th>
            <!-- <th class="text-center">Designation</th> -->
            {{-- <th class="text-center">Shift</th> --}}
            <th class="text-left">In Time</th>
            <th class="text-left">Out Time</th>
            {{-- <th class="text-center">Lunch out </th>
            <th class="text-center">Lunch In </th> --}}
            <!-- <th class="text-center">Duty In </th> -->
            <!-- <th class="text-center">Duty Out </th> -->
            {{-- <th class="text-center">OT</th>
            <th class="text-center">Late</th> --}}
            <th class="text-left">Action</th>
            <!-- <th class="text-center">Status</th> -->
        </tr>
    </thead>
    <tbody>

        @if (!empty($attendence_data))

            @foreach ($attendence_data as $sample_row)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <div class="d-flex aling-items-center">
                            <div class="d-inline-block mr-2">
                                @if (!empty($sample_row->photo_name))
                                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $sample_row->photo_name) }}"
                                        width="50">
                                @else
                                    <img src="{{ asset('images/doctor.png') }}" width="50">
                                @endif
                            </div>
                            <div class="d-inline-block">
                                <table>
                                    <tr>
                                        <td class="border-0 text-left"> <strong>Name</strong></td>
                                        <td class="border-0 text-left"> : {{ $sample_row->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 text-left"><strong>Card No</strong></td>
                                        <td class="border-0 text-left"> : {{ $sample_row->person_card_no }}</td>
                                    </tr>
                                    <tr>
                                        <td class="border-0 text-left"> <strong>Designation</strong></td>
                                        <td class="border-0 text-left"> : {{ $sample_row->designation_name }}</td>
                                    </tr>

                                </table>



                            </div>
                        </div>

                    </td>

                    <td>{{ $sample_row->attendance_date ? date('d/m/Y', strtotime($sample_row->attendance_date )) : ""}}</td>
                    <!-- <td>{{ $sample_row->person_card_no }}</td> -->
                    <!-- <td>{{ $sample_row->full_name }}</td> -->
                    <td>{{ $sample_row->serviceunit_name }}</td>
                    <!-- <td>{{ $sample_row->designation_name }}</td> -->
                    {{-- <td>
                        {{ $sample_row->shift_code }} <br>
                        <strong>Duty in</strong> :
                        {{ !empty($sample_row->duty_in_time) ? date('h:i A', strtotime($sample_row->duty_in_time)) : '' }}
                        <br>
                        <strong>Duty Out</strong> :
                        {{ !empty($sample_row->duty_out_time) ? date('h:i A', strtotime($sample_row->duty_out_time)) : '' }}
                    </td> --}}
                    <td>
                        {{ !empty($sample_row->in_time) ? date('h:i A', strtotime($sample_row->in_time)) : '' }}
                    </td>
                    <td>
                        {{ !empty($sample_row->out_time) ? date('h:i A', strtotime($sample_row->out_time)) : '' }}
                    </td>
                    {{-- <td>
                        {{ !empty($sample_row->lunch_out_time) ? date('h:i A', strtotime($sample_row->lunch_out_time)) : '' }}
                    </td>
                    <td>
                        {{ !empty($sample_row->lunch_in_time) ? date('h:i A', strtotime($sample_row->lunch_in_time)) : '' }}
                    </td> --}}


                    {{-- <td>
                        {{ !empty($sample_row->over_time_min) ? $sample_row->over_time_min : '' }}
                        <!--    @php
                            $a = new DateTime($sample_row->duty_out_time);
                            $b = new DateTime($sample_row->out_time);
                            $interval = $a->diff($b);
                            echo $interval->format('%H:%I:%S');
                        @endphp -->

                    </td>
                    <td>
                        {{ !empty($sample_row->late_time_min) ? $sample_row->late_time_min : '' }}

                    </td> --}}
                    <td width="70px"><span Class="btn btn-sm btn-primary open-modal" data-id=""
                            data-action="{{ route('hrm.attendence-manual-attendence.edit-list', $sample_row->mattendance_no_pk) }}"
                            data-modal="common-modal-md" data-title="Edit Manual Attendence" title="Edit"><i
                                class="fa fa-pencil-alt"></i></span> &nbsp;


                        <input type="hidden" id="manual_att_delete" class="manual_att_delete" name=""
                            value="{{ $sample_row->mattendance_no_pk }}">
                        <span class="badge badge-md badge-danger att_delete  p-1 mb-1 cursor-pointer"
                            onclick="deleteManualAtt(this)" title="Manual Attendence delete"><i class="far fa-trash-alt"
                                id="att_delete"></i></span>

                    </td>

                </tr>
            @endforeach
        @endif
    </tbody>
</table>







<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(".datatable").DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
