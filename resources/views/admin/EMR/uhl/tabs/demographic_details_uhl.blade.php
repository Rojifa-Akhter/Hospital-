<div class="tab-pane fade active show" id="demographic-details" role="tabpanel" aria-labelledby="demographic-details-tab">
    <div class="form-row">
        <div class="col-12">
            <div class="detail-info-tab">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    {{-- <li class="nav-item" role="presentation">
                        <a class=" active nav-link cursor-pointer" id="nav-lab-report-tab" data-toggle="tab"
                            role="tab" aria-controls="past-medical-records" aria-controls="nav-lab-report"
                            onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="14"
                            data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Demographic
                            Details</a>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <a class="active nav-link cursor-pointer" id="vitals" data-toggle="tab" aria-controls="vitals"
                            onclick="EMRFunc.getCurrentMedicalUsages(this)" data-tab-type="12"
                            data-action="{{ route('emr.patient-current-emr-use-uhl') }}" aria-selected="false">Vitals</a>
                    </li>
                </ul>

                <div class="tab-content p-0" id="myTabContent">
                    {{-- <div class="tab-pane fade show active p-0 pt-2" id="nav-prescription" role="tabpanel"
                        aria-labelledby="demographic-details-tab">
                        @include('admin.EMR.uhl.tabs.demographic_details_uhl.demographic_details_uhl')
                    </div> --}}

                    <div class="tab-pane fade pt-2 show active" id="nav-vitals" role="tabpanel" aria-labelledby="nav-vitals-tab">
                        @include('admin.EMR.uhl.tabs.demographic_details_uhl.vitals_uhl')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
