<div class="custom-card-header">
    {{-- @php
    $prev_date  = date('d-m-Y', strtotime("-1 day", strtotime($appointment_date)));
    $next_date  = date('d-m-Y', strtotime("+1 day", strtotime($appointment_date)));
    @endphp --}}
    <input type="hidden" id="hdn_appointment_date" >
    <ul class="list-inline global-uhl-table-bg" style="width: 100%">
        <li class="list-inline-item">All Admitted Patient :  <span class="badge badge-primary">{{ count($referedPatients) }}</span></li>
    </ul>
</div>
