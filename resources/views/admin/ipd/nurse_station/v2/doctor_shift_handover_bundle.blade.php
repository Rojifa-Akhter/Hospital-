<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container">
    
    <p><b>Patient:</b> {{ $patient_info->patient_name }} | <b>IP No:</b> {{ $patient_info->admission_uid }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Form #</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($forms as $key => $form)
            <tr>
                <td>Form {{ $key+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($form->au_entry_at)->format('d-m-Y h:i A') }}</td>
                <td>
                    <a href="{{ route('ipd.doctor-shift-handover-edit', [$form->ipd_docshift_handover_no_pk, $patient_no_fk, $admission_id]) }}" class="btn btn-sm btn-primary">Edit</a>
                    <a href="{{ route('ipd.doctor-shift-handover-form-print', [$form->ipd_docshift_handover_no_pk,$patient_no_fk, $admission_id]) }}" class="btn btn-sm btn-danger" target="_blank">Print</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('ipd.doctor-shift-handover-form', [$patient_no_fk, $admission_id]) }}" class="btn btn-success">+ New Handover Form</a>
</div>
