<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Block List</h5>
            </div>
            <div class="card-body" style="
            height: 438px;overflow-y: scroll; ">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped data-table  ">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>Sl</th>
                                <th class="text-center">Blocked Date</th>
                                <th class="text-left">Blocked Slot</th>
                                <th class="text-left">Doctor Name</th>
                                <th class="text-left">Blocked Reason</th>
                                <th class="text-left">Blocked By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($appointment_list) && count($appointment_list) > 0)
                                @foreach ($appointment_list as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($row->schedule_dt)) }}</td>
                                        <td class="text-left">{{ $row->full_name }}</td>
                                        <td class="text-left">{{ date('h:i a', strtotime($row->start_time)) }} -
                                            {{ date('h:i a', strtotime($row->end_time)) }}</td>


                                        <td class="text-left">{{ $row->block_reason }}</td>
                                        <td class="text-left">{{ $row->user_fullname }}</td>


                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">No Appointment Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
