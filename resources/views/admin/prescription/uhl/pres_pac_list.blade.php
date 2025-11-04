@php
    $pac_data = isset($pac_data) && !empty($pac_data) ? $pac_data : [];
    $purpose_off_reff = $pac_data->purpose_off_reff ?? '';
    $diagnosis = $pac_data->diagnosis ?? '';
    $result_of_inv_note = $pac_data->result_of_inv_note ?? '';
    $plane_proc_withdate = $pac_data->plane_proc_withdate ?? '';
    $estimated_duration_surge = $pac_data->estimated_duration_surge ?? '';
    $specefic_req_n_remarks = $pac_data->specefic_req_n_remarks ?? '';
    $reff_date = $pac_data->reff_date ?? '';
    $full_name = $pac_data->full_name ?? '';
    $reff_doc_no_fk = $pac_data->reff_doc_no_fk ?? '';
    $appoint_no_fk = $pac_data->appoint_no_fk ?? '';
    $patient_no_fk = $pac_data->patient_no_fk ?? '';
    $reff_anes_dept_no_pk = $pac_data->reff_anes_dept_no_pk ?? '';
@endphp

<div class="row mt-4">
    <!-- Left Side: Reply Form -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="mb-0 me-3">Anesthesia Reply</h5>
                    <select name="reply_type" class="form-select form-control ml-2" style="width: 200px;" required>
                        <option value="ACCEPT">Fit For Surgery</option>
                        <option value="DEFERRED">Deferred</option>
                    </select>
                </div>


                <!-- Accept/Deferred Selection -->

            </div>
            <div class="card-body">
                {{-- <form action="{{ route('ot.reply-submit') }}" method="POST" id="replyForm">
                    @csrf --}}
                <input type="hidden" name="reff_anes_dept_no_pk" value="{{ $pac_list_data->reff_anes_dept_no_pk }}">

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Dear Doctor</label>
                    <input type="text" class="form-control bg-light" name="dearDoctor"
                        value="Dr. {{ $pac_list_data->full_name ?? '' }}" readonly>
                </div>


                <div class="mb-3">
                    <label class="form-label fw-bold text-dark">Reply Message</label>
                    <textarea class="form-control" name="replyMessage" rows="5"
                        placeholder="Write your message to the referring doctor..."></textarea>
                </div>

                <div class="text-end mt-3">
                    <p class="text-muted fst-italic mb-0">Thank you.<br>Yours sincerely,</p>
                </div>

                <hr class="my-4">

                {{-- <div class="text-end">
                        <button type="submit" class="btn btn-success me-2">
                            <i class="fa fa-save me-1"></i> Save
                        </button>
                        <button type="reset" class="btn btn-info">
                            <i class="fa fa-undo me-1"></i> Clear
                        </button>
                    </div> --}}
                {{-- </form> --}}
            </div>
        </div>
    </div>
    <!-- Right Side: Action Buttons -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body d-grid gap-3">

                <a href="{{ route('ipd.anaesthetic-refferral-form-doc-pdf', $pac_list_data->reff_anes_dept_no_pk) }}"
                    class="btn btn-warning w-100 mt-3" target="_blank">
                    <i class="fa fa-file-pdf me-2"></i> Anesthetic Referral Form
                </a>

                @if ($pac_list_data->reply_type)
                    @php
                        $replyClass =
                            $pac_list_data->reply_type === 'ACCEPT'
                                ? 'btn-warning'
                                : ($pac_list_data->reply_type === 'REJECT'
                                    ? 'btn-danger'
                                    : 'btn-secondary');
                    @endphp
                    <a href="{{ route('ipd.anaesthetic-refferral-form-pdf', $pac_list_data->reff_anes_dept_no_pk) }}"
                        class="btn {{ $replyClass }} w-100 mt-3" target="_blank">
                        PAC (Anaesthetic Reply)
                    </a>
                @endif

                {{-- <span class="btn btn-success open-modal w-100 mt-3" data-modal="common-modal-xl" data-title="PAC Accept"
                    data-action="{{ route('ot.pac-accept', $pac_list_data->reff_anes_dept_no_pk) }}">
                    <i class="fa fa-check me-2"></i> Fit For Surgery
                </span>

                <span class="btn btn-danger open-modal w-100 mt-3" data-modal="common-modal-xl" data-title="OT Deferred"
                    data-action="{{ route('ot.pac-deferred', $pac_list_data->reff_anes_dept_no_pk) }}">
                    <i class="fa fa-times-circle me-2"></i> Deferred
                </span> --}}

                <a href="{{ route('ipd.pre-anesthetic-patient-checkup-form', [$pac_list_data->patient_no_fk, $pac_list_data->reff_anes_dept_no_pk]) }}"
                    class="btn btn-primary w-100 mt-3" target="_blank">
                    Pre‑Anesthesia Assessment Form
                </a>

                <a href="{{ route('ipd.pre-anesthetic-patient-checkup-pdf', [$pac_list_data->patient_no_fk, $pac_list_data->reff_anes_dept_no_pk]) }}"
                    class="btn btn-warning w-100 mt-3" target="_blank">
                    Pre‑Anesthesia PDF
                </a>
            </div>
        </div>
    </div>
</div>
