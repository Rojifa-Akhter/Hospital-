<div class="custom-card-header">
    @php
    $prev_date  = date('d-m-Y', strtotime("-1 day", strtotime($appointment_date)));
    $next_date  = date('d-m-Y', strtotime("+1 day", strtotime($appointment_date)));
    @endphp
    <input type="hidden" id="hdn_appointment_date" value="{{ $appointment_date }}">
    <ul class="list-inline">
        <li class="list-inline-item">All Appointment <span class="badge badge-primary">{{ count($appointment_rs) }}</span></li>
        {{-- <li class="list-inline-item">Pending <span class="badge badge-warning">{{ $pending_ind }}</span></li>
        <li class="list-inline-item">Payment <span class="badge badge-success">{{ $payment_ind }}</span></li> --}}
        <li class="list-inline-item">Report Patient <span class="badge badge-default">{{ $report_pat }}</span></li>
        <li class="list-inline-item">Free Patient <span class="badge badge-default">{{ $free_pat }}</span></li>
        <li class="list-inline-item">Prescription Done <span class="badge badge-default">{{ $prescription_ind }}</span></li>
        <li class="list-inline-item">Canceled <span class="badge badge-danger">{{ $cancel_ind }}</span></li>

        <li class="list-inline-item float-right border-right-0 cursor-pointer" title="Switch to List View" style="font-size: 1rem;">
            <a href="{{ route('appointments.free-list-view') }}" rel="tab"><i class="fa fa-list"></i></a>
        </li>
        <li class="list-inline-item float-right cursor-pointer" title="Switch to Grid View" style="font-size: 1rem;">
            <a href="{{ route('free.appointments.grid-view') }}" rel="tab"><i class="fa fa-th"></i></a>
        </li>
    </ul>
</div>
