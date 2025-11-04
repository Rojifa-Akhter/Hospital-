<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="card-header"> Job Card </div>
<div class="card-body">
    @if (!empty($details))
        <div class="form-row align-item-center">
            <div class=" col-md-12">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><strong> Name </strong></td>
                            @php
                                $photo = $details->photo_name ? $details->photo_name : '';
                            @endphp

                            <td> : {{ $details->salutation ? $details->salutation : '' }}
                                {{ $details->full_name ? $details->full_name : '' }}</td>

                            <td><strong> Designation </strong></td>
                            <td> : {{ $details->specialization_name ? $details->specialization_name : '' }}</td>
                        </tr>

                        <tr>
                            <td><strong> Card No </strong></td>
                            <td> : {{ $details->person_card_no ? $details->person_card_no : '' }}</td>

                            <td><strong> Department </strong></td>
                            <td> : {{ $details->department ? $details->department : '' }}</td>

                        </tr>
                        <tr>
                            <td><strong> Phone No </strong></td>
                            <td> : {{ $details->phone_mobile ? $details->phone_mobile : '' }}</td>


                            <td><strong> Joining Date </strong></td>
                            <td> : {{ $details->join_date ? date('d/m/Y', strtotime($details->join_date)) : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong> Grade <span class="dashicons dashicons-nametag"></span> </strong></td>
                            <td> : {{ $details->grade_name ? $details->grade_name : '' }}</td>
                            <td><strong> Roster Type </strong></td>
                            <td> : {{ $details->duty_roster_type ? $details->duty_roster_type : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div class="form-row ">
        <div class="col-md-12 table-responsive">
            <table class="table data-table table-bordered ">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <td class="text-center" scope="col"><strong>#SL</strong></td>
                        <td class="text-center" scope="col"><strong>Log Date</strong></td>
                        <td class="text-center" scope="col"><strong>Shift Time</strong></td>
                        <td class="text-center" scope="col"> <strong>In Time</strong></td>
                        <td class="text-center" scope="col"><strong>Out Time</strong></td>
                        <td class="text-center" scope="col"> <strong>Status</strong></td>
                        <td class="text-center" scope="col"><strong>Work Time</strong></td>

                    </tr>
                </thead>

                @if (isset($value))
                    @foreach ($value as $data)
                        <tr>
                            <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                            <td class="text-left" scope="col">
                                {{ date('l jS  F Y ', strtotime($data->attendance_date)) }}</td>
                            <td class="text-center" scope="col">
                                @if (isset($data->shift_code))
                                    {{ $data->shift_code }}
                                    ({{ isset($data->start_time) ? date('h:i a', strtotime($data->start_time)) : '' }}
                                    -{{ isset($data->end_time) ? date('h:i a', strtotime($data->end_time)) : '' }})
                                @endif
                            </td>
                            <td class="text-center" scope="col">
                                {{ isset($data->in_time) ? date('h:i a', strtotime($data->in_time)) : '' }}</td>
                            <td class="text-center" scope="col">{{ isset($data->out_time) ? date('h:i a', strtotime($data->out_time)) : '' }}</td>
                            @php
                                $inTime = strtotime($data->in_time);
                                $outTime = strtotime($data->out_time);
                                $diff = $outTime - $inTime;

                                $hours = floor($diff / 3600);
                                $minutes = floor(($diff / 60) % 60);
                                $seconds = $diff % 60;

                            @endphp
                            <td class="text-center" scope="col">{{ $diff>0 ? "Normal" : "Non Working"}}</td>
                            <td class="text-center" scope="col">{{ $hours }}:{{ $minutes }}</td>

                        </tr>
                    @endforeach
                @endif

            </table>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    // $('.data-table').DataTable({
    // 	"lengthMenu": [
    // 		[50],
    // 		[50]
    // 	]
    // });
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        // "scrollY": "150px",
        "scrollCollapse": true,
        "paging": false,
        "searching": true,
        "ordering": false,
        "info": false
    });
</script>
