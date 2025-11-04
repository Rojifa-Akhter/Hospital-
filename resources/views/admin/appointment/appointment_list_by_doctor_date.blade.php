
<div class="">
    <div class="row">
        <div class="col-md-3">
            <div class="card-counter primary">
                <i class="fa fa-code-fork"></i>
                <span class="count-numbers">12</span>
                <span class="count-name">Total</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter danger">
                <i class="fa fa-ticket"></i>
                <span class="count-numbers">9</span>
                <span class="count-name">Confirmed</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter success">
                <i class="fa fa-database"></i>
                <span class="count-numbers">1</span>
                <span class="count-name">Rescheduled</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter info">
                <i class="fa fa-users"></i>
                <span class="count-numbers">2</span>
                <span class="count-name">Cancelled</span>
            </div>
        </div>
    </div>
</div>
<hr />
@if(!empty($appointment_list))
<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">SL</th>
            <th scope="col">Time</th>
            <th scope="col">Patient Name</th>
            <th scope="col">Chief Complaint</th>
            <th scope="col">Priority</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($appointment_list as $appointment)
        <tr>
            <th scope="row">{{ $appointment->slot_sl }}</th>
            <td>{{ $appointment->start_time }}</td>
            <td><a href="#">{{ $appointment->patient_name}}</a></td>
            <td>{{ $appointment->chif_complain }}</td>
            <td>{{ $appointment->priority }}</td>
            <td class="text-center">
                <span class="btn btn-sm btn-success open-modal" data-id="{{ $appointment->appoint_no_pk }}" data-action="{{ route('appointment-card-pat',$appointment->appoint_no_pk) }}" data-title="Appointment card" title="Appointment card" data-modal="common-modal-sm"><i class="fa fa-address-card"></i></span>
                <button class="btn btn-info btn-sm" title="View Details">
                    <i class="oi oi-eye"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-danger" role="alert">
    No Appointment created yet.
</div>
@endif