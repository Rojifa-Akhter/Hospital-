 <div class="card shadow-lg">
     <div class="card-header bg-primary text-white">
         <h5 class="mb-0">Referral to Anesthesia Department</h5>
     </div>
     <div class="card-body">
         <div class="row g-4">

             <!-- Left Column: Referral Details -->
             <div class="col-md-6">
                 <div class="row">
                     <!-- Purpose of Referral -->
                     <div class="col-md-6">
                         <label for="purpose" class="form-label font-weight-bold">Purpose of
                             Referral</label>
                         <select id="purpose" name="purpose" class="form-select form-control">
                             <option value="">-- Select Purpose --</option>
                             <option value="preOp">Preoperative Assessment</option>
                             <option value="prePa">Pre-Procedure Assessment</option>
                             <option value="postOpComplication">Post-operative Complication</option>
                             <option value="painClinic">Pain Clinic</option>
                         </select>
                     </div>

                     <!-- Surgical Urgency -->
                     <div class="col-md-6">
                         <label for="urgency" class="form-label font-weight-bold">Surgical
                             Urgency</label>
                         <select id="urgency" name="urgency" class="form-select form-control"
                             onchange="showUrgencyPage()">
                             <option value="">-- Select Urgency --</option>
                             <option value="Immediate">Immediate(1)</option>
                             <option value="Urgent">Urgent(2)</option>
                             <option value="Expedited">Expedited(3)</option>
                             <option value="Elective">Elective(4)</option>
                         </select>
                     </div>

                     <!-- Referring Doctor Information (Hidden if urgency not selected) -->
                     <div class="col-md-6" style="display: none;">
                         <label for="referral_doctor" class="form-label font-weight-bold">Referring
                             Doctor & Department</label>
                         <input type="text" class="form-control form-control-sm m-0" id="referral_doctor"
                             name="referral_doctor" value="{{ Session::get('user.ses_user_name') }}"
                             placeholder="Enter Referring Doctor" />
                     </div>
                 </div>

                 <!-- Diagnosis -->
                 <div class="mb-3">
                     <label for="diagnosis" class="form-label font-weight-bold">Diagnosis</label>
                     <input type="text" id="diagnosis" name="diagnosis" class="form-control"
                         placeholder="Enter diagnosis">
                 </div>

                 <!-- Investigations & Clinical Notes -->
                 <div class="mb-3">
                     <label for="investigationResult" class="form-label font-weight-bold">
                         Result of Investigations & Clinical Notes (Positive findings, if any)
                         <span id="recommendInvestigations" class="btn btn-outline-primary mt-1" onclick="showPdf()"
                             role="button" tabindex="0">Recommend
                             Investigations</span>
                     </label>
                     <textarea id="investigationResult" name="investigationResult" class="form-control mt-1" rows="3"
                         placeholder="Enter investigation results"></textarea>
                 </div>

                 <!-- Checkbox to Refer to Anesthesia Department -->
                 <div class="form-check mb-3 text-end">
                     <input class="form-check-input" type="checkbox" id="referredToAnesthesia"
                         name="referredToAnesthesia" value="Refer to Anesthesia Department">
                     <label class="form-check-label text-danger" for="referredToAnesthesia"
                         style="font-weight: bold;">Refer to Anesthesia Department</label>
                 </div>
             </div>

             <!-- Right Column: Planned Procedure Details -->
             <div class="col-md-6">
                 <!-- Planned Procedure -->
                 <div class="mb-3">
                     <label for="plannedProcedure" class="form-label font-weight-bold">Planned
                         Procedure</label>
                     <textarea id="plannedProcedure" name="plannedProcedure" class="form-control" rows="2"
                         placeholder="Enter Planned Procedure"></textarea>
                 </div>

                 <!-- Planned Date, Time & Duration -->
                 <div class="row g-3">
                     <div class="col">
                         <div class="mb-3">
                             <label for="procedureDate" class="form-label font-weight-bold">Planned
                                 Date</label>
                             <input type="text" class="form-control form-control-sm m-0 date_picker"
                                 id="procedureDate" name="procedureDate" value="{{ date('d/m/Y') }}"
                                 placeholder="dd/mm/yyyy" autocomplete="off">
                         </div>
                     </div>
                     <div class="col">
                         <div class="mb-3">
                             <label for="procedureTime" class="form-label font-weight-bold">Planned
                                 Time</label>
                             <input type="text" id="procedureTime" name="procedureTime" class="form-control">
                         </div>
                     </div>
                     <div class="col">
                         <div class="mb-3">
                             <label for="estimatedDuration" class="form-label font-weight-bold">Estimated Duration
                                 Surgery</label>
                             <input type="text" id="estimatedDuration" name="estimatedDuration"
                                 class="form-control" placeholder="e.g., 2 hours">
                         </div>
                     </div>
                 </div>

                 <!-- Specific Requirements or Remarks -->
                 <div class="mb-3">
                     <label for="specificRequirements" class="form-label font-weight-bold">Specific
                         Requirements / Remarks</label>
                     <textarea id="specificRequirements" name="specificRequirements" class="form-control" rows="3"
                         placeholder="Enter any specific requirements or remarks"></textarea>
                 </div>

                 <!-- Anesthesia Information Container -->
                 <div class="mb-3">
                     <div id="anesthesiaInfoContainer"></div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Submit Button -->
 <div class="form-group row">
     <div class="modal-footer mt-1">
         @php
             $response_action = 'javascript:history.back()';
         @endphp


         <div class="col-md-12 mt-4">
             <button type="submit" class="btn btn-md btn-success">Save</button>
             <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
             <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
         </div>
     </div>
 </div>
