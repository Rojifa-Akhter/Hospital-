<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">



<table class="table table-bordered   data-table" border="1">
    <thead class="global-uhl-table-bg">
        <tr>
           <th class="text-left">SL#</th>
            <th class="text-left">Employee</th>
            <th class="text-left">Date</th>
            <th class="text-left">Dept.</th>
            <th class="text-left">Overtime</th>
            <th class="text-left">Action</th>
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

                    <td>{{ $sample_row->attendance_date ? date('d-m-Y', strtotime($sample_row->attendance_date)) : ""}}</td>
                    <td>{{ $sample_row->serviceunit_name }}</td>
                    <td>
                        {{ !empty($sample_row->over_time) ?  $sample_row->over_time : '' }}
                    </td>

                    <td width="70px"><span Class="btn btn-sm btn-primary open-modal" data-id=""
                            data-action="{{ route('hrm.edit-manual-overtime', $sample_row->over_time_req_no_pk) }}"
                            data-modal="common-modal-md" data-title="Edit Manual Overtime" title="Edit"><i
                                class="fa fa-pencil-alt"></i></span> &nbsp;


                        <input type="hidden" id="manual_overtime_delete" class="manual_overtime_delete" name=""
                            value="{{ $sample_row->over_time_req_no_pk }}">
                        <span class="badge badge-md badge-danger overtime_delete  p-1 mb-1 cursor-pointer"
                            onclick="deleteManualOvertime(this)" title="Manual Overtime delete"><i class="far fa-trash-alt"
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
