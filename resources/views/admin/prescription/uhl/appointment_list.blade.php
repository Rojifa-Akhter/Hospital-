<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Appointment List</h5>
            </div>
            <div class="card-body" style="height: 438px; overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped data-table">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th>Slot No</th>
                                <th>Slot SL</th>
                                <th>Available</th>
                                <th>Schedule Date</th>
                                <th>Block Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Patient Name</th>
                                <th>Admission UID</th>
                                <th>Item Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointment_list as $row)
                                <tr>
                                    <td>{{ $row->ot_slot_no_pk }}</td>
                                    <td>{{ $row->slot_sl }}</td>
                                    <td>{{ $row->available_ind == 1 ? 'yes' : 'no' }}</td>
                                    <td>{{date('d/m/Y', strtotime($row->schedule_dt))}}</td>
                                    <td>{{ $row->block_date }}</td>
                                    <td>{{date('h:i a', strtotime($row->start_time))}}</td>
                                    <td>{{date('h:i a', strtotime($row->end_time))}}</td>
                                    <td>{{ $row->patient_name }}</td>
                                    <td>{{ $row->admission_uid }}</td>
                                    <td>{{ $row->item_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
