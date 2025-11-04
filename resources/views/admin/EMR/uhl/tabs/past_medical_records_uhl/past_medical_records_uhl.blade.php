<div class="form-row">
    <div class="col-12">
        <div class="detail-info-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer active" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="11"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}"
                        aria-selected="false">Prescription</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="5"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Investigation Name</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="6"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Radiology &
                        Imaging</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="7"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Surgical
                        History</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="8"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Admission
                        History</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="9"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Immunization
                        History</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab" role="tab"
                        aria-controls="past-medical-records" aria-controls="nav-lab-report"
                        onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="20"
                        data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Physiotherapy
                        History</a>
                </li>
            </ul>

            <div class="tab-content p-0" id="myTabContent">
                <div class="tab-pane fade show active p-0 pt-2" id="nav-prescription" role="tabpanel"
                    aria-labelledby="nav-prescription-tab">
                    @include('admin.EMR.uhl.tabs.past_medical_records_uhl.prescription_uhl')
                </div>
            </div>
        </div>
    </div>
</div>
