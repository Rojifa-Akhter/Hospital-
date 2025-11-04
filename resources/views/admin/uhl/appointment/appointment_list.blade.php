<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Appointment List</h5>
            </div>
            <div class="card-body" style="
            height: 438px;overflow-y: scroll; ">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped data-table  ">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>Sl</th>
                                <th class="text-center">App. Code</th>
                                <th class="text-center">App. Date</th>
                                <th class="text-left">Patient Name</th>
                                <th class="text-left">Patient Mobile</th>
                                <th class="text-center">Slot Time</th>
                                <th class="text-left">Doctor Name</th>
                                <th class="text-center">App Source</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($appointment_list) && count($appointment_list)>0)
                                @foreach ($appointment_list as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $row->appoint_code }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($row->appoint_date)) }}</td>
                                        <td>{{ $row->patient_name }}</td>
                                        <td>{{ $row->mobile1 }}</td>
                                        <td class="text-center">{{ date('h:i a', strtotime($row->start_time)) }} - {{ date('h:i a', strtotime($row->end_time)) }}</td>
                                        <td>{{ $row->full_name }}</td>
                                        <td>{{ $row->appoint_source }}</td>

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
