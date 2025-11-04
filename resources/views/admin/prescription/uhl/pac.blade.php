<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Referral to Anesthesia Department</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-md-6">


                <!-- This h2 will be dynamically added here -->

                <div class="row">
                    <div class="col-md-6">
                        <label for="purpose" class="form-label" style="font-weight: bold;">
                            Purpose of Referral
                        </label><br>
                        <select id="purpose" name="purpose" class="form-select form-control">
                            <option value="">-- Select Purpose --</option>
                            <option value="preOp">Preoperative Assessment</option>
                            <option value="postOpComplication">Post-operative Complication</option>
                            <option value="painClinic">Pain Clinic</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="urgency" class="form-label" style="font-weight: bold;">
                            Surgical Urgency
                        </label><br>
                        <select id="urgency" name="urgency" class="form-select form-control"
                            onchange="showUrgencyPage()">
                            <option value="">-- Select Urgency --</option>
                            <!-- Urgency options here -->
                            <option value="Immediate">Immediate(1)</option>
                            <option value="Urgent">Urgent(2)</option>
                            <option value="Expedited">Expedited(3)</option>
                            <option value="Elective">Elective(4)</option>
                        </select>
                    </div>

                    <div class="col-md-6" style="display: none;">
                        <label for="urgency" class="form-label" style="font-weight: bold;">
                            Referring Doctor & Department
                        </label><br>


                        <input type="text" class="form-control form-control-sm m-0" id="referral_doctor"
                            name="referral_doctor" value="{{ Session::get('user.ses_user_name') }}"
                            placeholder="Enter Referring Doctor" />
                    </div>
                </div>

                <input type="hidden" id="ref_doc" name="ref_doc"
                    value="{{ Session::get('user.ses_person_no_fk') }}" />

                <div class="mb-3">
                    <label for="diagnosis" class="form-label" style="font-weight: bold;">Diagnosis</label>
                    <input type="text" id="diagnosis" name="diagnosis" class="form-control"
                        placeholder="Enter diagnosis">
                </div>
                <div class="mb-3">
                    <label for="investigationResult" class="form-label" style="font-weight: bold;">Result of
                        Investigations & Clinical Notes(Positive findings, if any) <span id="recommendInvestigations"
                            style="font-size: smaller;" class="btn btn-outline-primary mt-1" onclick="showPdf()"
                            role="button" tabindex="0">
                            Recommend Investigations
                        </span></label>
                    <textarea id="investigationResult" name="investigationResult" class="form-control mt-1" rows="3"
                        placeholder="Enter investigation results"></textarea>
                </div>
                <div class="form-check mb-3 " style="text-align: right;">
                    <input class="form-check-input" type="checkbox" id="referredToAnesthesia"
                        name="referredToAnesthesia" value="Refer to Anesthesia Department">
                    <label class="form-check-label text-danger" for="referredToAnesthesia" style="font-weight: bold;">
                        Refer to Anesthesia Department
                    </label>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="plannedProcedure" class="form-label" style="font-weight: bold;">Planned
                        Procedure</label>

                    <textarea id="plannedProcedure" name="plannedProcedure" class="form-control" rows="2"
                        placeholder="Enter Planned Procedure"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col">
                        <div class="mb-3">
                            <label for="procedureDate" class="form-label"  style="font-weight: bold;">Planned Date</label>
                            <input type="date" id="procedureDate" name="procedureDate" class="form-control" readonly>
                        </div>


                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="procedureTime" class="form-label"  style="font-weight: bold;">Planned Time</label>
                            <input type="text" id="procedureTime" name="procedureTime" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="estimatedDuration" class="form-label" style="font-weight: bold;">Estimated
                                Duration Surgery</label>
                            <input type="text" id="estimatedDuration" name="estimatedDuration"
                                class="form-control" placeholder="e.g., 2 hours">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="specificRequirements" class="form-label" style="font-weight: bold;">Specific
                        Requirements / Remarks</label>
                    <textarea id="specificRequirements" name="specificRequirements" class="form-control" rows="3"
                        placeholder="Enter any specific requirements or remarks"></textarea>
                </div>

                <div class="mb-3">
                    <div id="anesthesiaInfoContainer"></div>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    function showUrgencyPage() {
        $("#exampleModal .modal-content").load("{{ route('obstetric-urgency.print') }}", function() {
            $('#exampleModal').modal('show');
        });
    }

    function showPdf() {
        $("#exampleModal .modal-content").load("{{ route('ot.recommend-investigation') }}", function() {
            $('#exampleModal').modal('show');
        });
    }


    $(document).ready(function() {
        const $checkbox = $('#referredToAnesthesia');
        const $planedDate = $('#procedureDate');

        // Function to handle checkbox change
        function handleCheckboxChange() {
            if ($checkbox.is(':checked') && $.trim($planedDate.val()) === '') {
                alert('Please add Planed date and Time.');
                $planedDate.focus();
            }
        }

        // Trigger on page load if checkbox is checked and input is empty
        handleCheckboxChange();

        // Bind change event to checkbox
        $checkbox.change(handleCheckboxChange);
    });
</script>
