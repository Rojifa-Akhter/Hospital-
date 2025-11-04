 <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
 <table class="table data-table table-bordered  ">
    <thead class="global-uhl-table-bg">
        <tr>
            <!-- <th class="text-center" scope="col">#SL</th> -->
            <th class="text-center" scope="col">Patient</th>
            <th class="text-center" scope="col">Attendance Date</th>
            <!-- <th class="text-center" scope="col">Card No</th> -->
            <!-- <th class="text-center" scope="col"> Name</th> -->
            <th class="text-center" scope="col">Department</th>
            <!-- <th class="text-left" scope="col">Designation</th> -->
            <th class="text-center" scope="col" style="width: 15%">Shift</th>
            <th class="text-center" scope="col" style="width: 10%">IN HH:12</th>
            <th class="text-center" scope="col" style="width: 10%">OUT HH:12</th>
            <th class="text-center" scope="col">Lunch OUT HH:12</th>
            <th class="text-center" scope="col">Lunch in HH:12</th>
            <th class="text-center" scope="col">OT</th>
            <th class="text-center" scope="col">Late</th>
            <!-- <th class="text-left" scope="col">Status</th> -->
            <!-- <th class="text-left" scope="col">Entry Status</th> -->
            <!-- <th class="text-center" scope="col">Action</th> -->
        </tr>
    </thead>
    <tbody>

        @if(isset($attendence_data))
        @foreach($attendence_data as $sample_row)
        <tr>
            <td>
                <div class="d-flex aling-items-center">
                    <div class="d-inline-block">
                        @if($sample_row->photo_name == '')
                            <img src="{{asset('images/boy.jpg')}}" width="50">

                        @else
                       <img src="{{asset('images/uploads/doctor_images/thumb/'.$sample_row->photo_name)}}" width="50">
                       @endif
                   </div>
                   <div class="d-inline-block mr-2">
                    <table>
                        <tr>
                            <td  class="border-0 text-left">  {{ $sample_row->full_name }}</td>
                        </tr>
                        <tr>
                            <td  class="border-0 text-left">  {{ $sample_row->person_card_no}}</td>
                        </tr>
                         <tr>
                            <td  class="border-0 text-left">  {{ $sample_row->designation_name }}</td>
                        </tr>
                    </table>

                </div>
            </div>

        </td>
        <td>{{date("d-m-Y",strtotime( $sample_row->attendance_date )) }}</td>
        <td>{{ $sample_row->serviceunit_name }}</td>
        <td>

             <table>
                        <tr>
                            <td  class="border-0 text-left" colspan="2">  {{ $sample_row->shift_code }} </td>

                        </tr>
                        <tr>
                            <td  class="border-0 text-left"> <strong>In :</strong> </td>
                            <td  class="border-0 text-left">  {{ isset($sample_row->duty_in_time) ? date('h:i a',strtotime($sample_row->duty_in_time)) : '' }}</td>
                        </tr>
                         <tr>
                            <td  class="border-0 text-left"> <strong>Out :</strong> </td>
                            <td  class="border-0 text-left">  {{ isset($sample_row->duty_out_time) ? date('h:i a',strtotime($sample_row->duty_out_time)) : '' }}</td>
                        </tr>
                    </table>


        </td>
        <td class=" @if($sample_row->entry_type == "2") text-danger @endif">{{ isset($sample_row->in_time) ? date('h:i a',strtotime($sample_row->in_time)) : '' }}</td>
        <td class="@if($sample_row->entry_type == "2") text-danger @endif">{{ isset($sample_row->out_time) ? date('h:i a',strtotime($sample_row->out_time)) : '' }}</td>
        <td>{{ isset($sample_row->lunch_out_time) ? date('h:i a',strtotime($sample_row->lunch_out_time)) : '' }}</td>
        <td>{{ isset($sample_row->lunch_in_time) ? date('h:i a',strtotime($sample_row->lunch_in_time)) : '' }}</td>
        <td>   {{$sample_row->over_time_min }}    </td>
        <td> {{$sample_row->late_time_min }}  </td>


    </tr>
    @endforeach
    @endif

</tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
 $('.data-table').DataTable({
    "ordering": false,
    "bPaginate": false,
    "bLengthChange": false,
    "bAutoWidth": false
});
</script>
