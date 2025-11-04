
<div class="col-12 table-responsive">
    <table class="table data-table table-striped table-bordered table-hover mb-0">
        <thead class="bg-primary">
            <tr>
                <th class="text-center">SL</th>
                <th class="text-left">Patient Name</th>
                <th class="text-left">UHID</th>
                <th class="text-left">Sex</th>
                <th class="text-left">Age</th>
                <th class="text-left">Prescription ID</th>
                <th class="text-left">Prescription Date</th>
                <th class="text-left">Admission Requested On</th>
                <th class="text-left">Department</th>
                <th class="text-left">Referred By</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            @if(!empty($referedPatients))
                @foreach($referedPatients as $rp)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ !empty($rp->patient_name)? $rp->patient_name: '' }}</td>
                        <td class="text-left">{{ !empty($rp->patient_code)? $rp->patient_code: '' }}</td>
                        <td class="text-left">{{ !empty($rp->gender)? $rp->gender_txt: '' }}</td>
                        <td class="text-left">{{ !empty($rp->age)? $rp->age: '' }}</td>
                        <td class="text-left">{{ !empty($rp->prescription_uid)? $rp->prescription_uid: '' }}</td>
                        <td class="text-left">{{ !empty($rp->au_entry_at)? date('d/m/Y', strtotime($rp->au_entry_at)): '' }}</td>
                        <td class="text-left">{{ !empty($rp->admission_req_date)? date('d/m/Y', strtotime($rp->admission_req_date)): '' }}</td>
                        <td class="text-left">{{ !empty($rp->serviceunit_name)? $rp->serviceunit_name: '' }}</td>
                        <td class="text-left">{{ !empty($rp->serviceunit_name)? $rp->user_name: '' }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm open-modal"
                                    data-modal="common-modal" data-title="IPD Admission"
                                    data-action="{{ route('ipd.quick-admission',[$rp->patient_no_fk,1,$rp->opd_doctor_no_fk,$rp->user_name,$rp->admission_req_no_pk]) }}">Admission</button>
                            {{-- <button type="button" class="btn btn-success btn-sm open-modal"
                                    data-modal="common-modal" data-title="IPD Admission"
                                    data-action="{{ route('ipd.ipd-request-referred-patient-admission',[$rp->patient_no_fk, $rp->admission_req_uid]) }}">Admission</button> --}}

                            <button type="button" class="btn btn-danger btn-sm open-modal"
                                    data-modal="common-modal-sm" data-title="IPD Admission"
                                    data-action="{{ route('ipd.admission-rejection',[$rp->patient_no_fk, $rp->admission_req_uid]) }}">Reject</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>