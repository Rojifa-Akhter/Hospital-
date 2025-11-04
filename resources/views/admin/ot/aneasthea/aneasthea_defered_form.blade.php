@php

    $pac_data = isset($pac_data) && !empty($pac_data) ? $pac_data : [];
    $purpose_off_reff = $pac_data ? $pac_data->purpose_off_reff : '';
    $diagnosis = $pac_data ? $pac_data->diagnosis : '';
    $result_of_inv_note = $pac_data ? $pac_data->result_of_inv_note : '';
    $plane_proc_withdate = $pac_data ? $pac_data->plane_proc_withdate : '';
    $estimated_duration_surge = $pac_data ? $pac_data->estimated_duration_surge : '';
    $specefic_req_n_remarks = $pac_data ? $pac_data->specefic_req_n_remarks : '';
    $reff_date = $pac_data ? $pac_data->reff_date : '';
    $full_name = $pac_data ? $pac_data->full_name : '';
    $reff_doc_no_fk = $pac_data ? $pac_data->reff_doc_no_fk : '';
    $appoint_no_fk = $pac_data ? $pac_data->appoint_no_fk : '';
    $patient_no_fk = $pac_data ? $pac_data->patient_no_fk : '';
    $reff_anes_dept_no_pk = $pac_data ? $pac_data->reff_anes_dept_no_pk : '';
@endphp
<div class="container-fluid">
    <form action="{{ route('ot.reply-submit') }}" method="POST" id="replyForm">
        @csrf
        <input type="hidden" name="reff_anes_dept_no_pk" value="{{ $reff_anes_dept_no_pk }}">
        <input type="hidden" name="type" value="DEFERRED">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-3" id="referralTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " id="referral-tab" data-toggle="tab" href="#referral" role="tab"
                            aria-controls="referral" aria-selected="true">
                            <i class="fa fa-info-circle mr-1"></i> Referral Info
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="reply-tab" data-toggle="tab" href="#reply" role="tab"
                            aria-controls="reply" aria-selected="false">
                            <i class="fa fa-reply mr-1"></i> Reply
                        </a>
                    </li>
                </ul>

                <div class="tab-content border rounded p-3 bg-white" id="referralTabsContent">
                    <!-- Referral Info Tab -->
                    <div class="tab-pane fade" id="referral" role="tabpanel"
                        aria-labelledby="referral-tab">
                        <div class="row g-4 bg-light rounded p-3 border">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Purpose of Referral</label>
                                    <select class="form-select" disabled>
                                        <option value="">-- Select Purpose --</option>
                                        <option value="preOp" {{ $purpose_off_reff == 'preOp' ? 'selected' : '' }}>
                                            Preoperative Assessment</option>
                                        <option value="postOpComplication"
                                            {{ $purpose_off_reff == 'postOpComplication' ? 'selected' : '' }}>
                                            Post-operative
                                            Complication</option>
                                        <option value="painClinic"
                                            {{ $purpose_off_reff == 'painClinic' ? 'selected' : '' }}>Pain Clinic
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Diagnosis</label>
                                    <input type="text" class="form-control bg-white" readonly
                                        value="{{ $diagnosis }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Investigation Results & Notes</label>
                                    <textarea class="form-control bg-white" rows="4" readonly>{{ $result_of_inv_note }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Planned Procedure</label>
                                    <textarea class="form-control bg-white" rows="3" readonly>{{ $plane_proc_withdate }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-dark">Planned Date</label>
                                        <input type="date" class="form-control bg-white" readonly
                                            value="{{ $reff_date ? \Carbon\Carbon::parse($reff_date)->format('Y-m-d') : '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-dark">Estimated Duration</label>
                                        <input type="text" class="form-control bg-white" readonly
                                            value="{{ $estimated_duration_surge }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">Specific Requirements / Remarks</label>
                                    <textarea class="form-control bg-white" rows="3" readonly>{{ $specefic_req_n_remarks }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Tab -->
                    <div class="tab-pane fade show active" id="reply" role="tabpanel" aria-labelledby="reply-tab">
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Dear Doctor</label>
                                <input type="text" class="form-control bg-light" name="dearDoctor"
                                    value="Dr. {{ $full_name ?? '' }}" readonly>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Deferred Reason</label>
                                <textarea class="form-control" name="replyMessage" rows="5"
                                    placeholder="Write your message to the referring doctor..."></textarea>


                                <!-- Hidden input to capture CKEditor content -->
                                {{-- <input type="hidden" name="replyMessage" id="replyMessage" value="">

                                <!-- CKEditor textarea -->
                                <textarea id="editor1" class="form-control" rows="5" placeholder="Write your message to the referring doctor..." required></textarea> --}}

                            </div>

                            <div class="col-md-12 text-end mt-2">
                                <p class="text-muted fst-italic mb-0">
                                    Thank you.<br>
                                    Yours sincerely,
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <hr class="my-4">
                {{-- <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa fa-check-circle mr-1"></i> Accept
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4 ml-2">
                        <i class="fa fa-times-circle mr-1"></i> Exit
                    </a>
                </div> --}}
               <div class="m-0 pt-2 text-right border-top">
                    @php
                        $response_action = route('ot.pac-list');
                        // $response_action = route('ot.operation-status');
                    @endphp
                    <button type="button" id="saveBtn" class="btn btn-success btn-md"><i class="fa fa-save"></i>
                        Save</button>
                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    {{-- <a href="{{ $response_action }}" class="btn btn-danger btn-md" rel="tab"
                        title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a> --}}
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $('#saveBtn').on('click', function() {
        if (confirm("Are You Sure?")) {
            $.ajax({
                type: 'POST',
                url: '{{ route('ot.reply-submit') }}',
                data: $('#replyForm').serialize(),
                cache: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(res) {
                    // First modal hide after successful POST
                    $(".exampleModal").modal("hide");

                    // Then trigger second AJAX GET
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('ipd.submit-referral') }}',
                        data: {
                            reply_id: res.id // ID returned from first POST
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log('Second AJAX data:', data);

                            // Define bgColour outside of the blocks so it's in the right scope
                            let bgColour = 'btn-secondary'; // fallback
                            if (data.reply_type === "ACCEPT") {
                                bgColour = 'btn-warning';
                            } else if (data.reply_type === "REJECT") {
                                bgColour = 'btn-danger';
                            }

                            if (data && data.id) {
                                var href =
                                    "{{ route('ipd.anaesthetic-refferral-form-pdf', '__ID__') }}"
                                    .replace('__ID__', data.id);

                                var $link = $(
                                    '<a class="btn btn-lg ' + bgColour +
                                    ' ms-3 ml-3" target="_blank" href="' + href +
                                    '">' +
                                    'PAC (Anaesthetic Referral Form)' +
                                    '</a>'
                                );

                                $('#pdf-link-container').html(
                                $link); // Replace existing content
                                $(".hiddenClass").addClass("d-none");
                            } else {
                                alert('No ID returned from second request.');
                            }
                        },

                        error: function(xhr) {
                            console.error('Error in second AJAX:', xhr);
                            alert('An error occurred with the follow-up request');
                        }
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        console.log(xhr.responseJSON.errors);
                        alert('Validation error');
                    } else {
                        alert('An error occurred');
                    }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    });
</script>
