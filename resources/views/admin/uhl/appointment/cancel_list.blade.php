<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Cancel List</h5>
            </div>
            <div class="card-body" style="
            height: 438px;overflow-y: scroll; ">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped data-table  ">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>Sl</th>
                                <th class="text-left">App. Code</th>
                                <th class="text-left">App. Date</th>
                                <th class="text-left">Patient Name</th>
                                <th class="text-left">Patient Mobile</th>
                                <th class="text-left">Slot Time</th>
                                <th class="text-left">Doctor Name</th>
                                <th class="text-center">App Source</th>
                                <th class="text-left">Cancel Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($appointment_list) && count($appointment_list)>0)
                                @foreach ($appointment_list as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->appoint_code }}</td>
                                        <td>{{ date('d/m/Y', strtotime($row->appoint_date)) }}</td>
                                        <td>{{ $row->patient_name }}</td>
                                        <td>{{ $row->mobile1 }}</td>
                                        <td>{{ date('h:i a', strtotime($row->start_time)) }} - {{ date('h:i a', strtotime($row->end_time)) }}</td>
                                        <td>{{ $row->full_name }}</td>
                                        <td class="text-center">{{ $row->appoint_source }}</td>
                                        <td class="text-left">{{ $row->cancel_reason }}</td>

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
