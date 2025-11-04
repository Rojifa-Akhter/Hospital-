
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div class="card">
    <div class="card-header"><h5>Manual Attendence List </h5></div>
    <div class="card-body">
        <div class="form-row">
            <div id="search-result" class="col-12 table-responsive">
                <table id="data-table"
                       class="data-table table-bordered table-hover table-striped mt-4 border mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th class="text-center">sl</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Card Number</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Dept</th>
                        <th class="text-center">Design</th>
                        <th class="text-center">In Time</th>
                        <th class="text-center">Out Time</th>
                        <th class="text-center">Duty In Time</th>
                        <th class="text-center">Duty Out Time</th>
                        <th class="text-center">OT</th>
                        <th class="text-center">Late</th>
                        <!-- <th class="text-center">Status</th> -->
                    </tr>
                    </thead>
            <tbody id="invest_data">

            @if(!empty($attendence_data))
                        @foreach($attendence_data as $sample_row)
                        <tr>
                            <!-- <td>{{ $loop->iteration }}</td> -->
                            <td>{{ $sample_row->attendance_date1 }}</td>
                            <td>{{ $sample_row->person_card_no}}</td>
                            <td>{{ $sample_row->full_name }}</td>
                            <td>{{ $sample_row->serviceunit_name }}</td>
                            <td>{{ $sample_row->designation_name }}</td>
                            <td>{{ $sample_row->in_time }}</td>
                            <td>{{ $sample_row->out_time }}</td>
                            <td>{{ $sample_row->duty_in_time }}</td>
                            <td>{{ $sample_row->duty_out_time }}</td>
                            <td>{{ $sample_row->over_time_min }}</td>
                            <td>{{ $sample_row->late_time_min }}</td>
                            <td>{{ $sample_row->over_time_min }}</td>

                        </tr>
                        @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
