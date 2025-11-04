<div class="col-md-12 mt-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="vitals-tab" data-toggle="tab" href="#vitals" role="tab" aria-controls="vitals"
                aria-selected="true">Vitals</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="medicine-tab" data-toggle="tab" href="#medicine" role="tab"
                aria-controls="medicine" aria-selected="false">Medicine/Surgical</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="investigationData-tab" data-toggle="tab" href="#investigationData" role="tab"
                aria-controls="investigationData" aria-selected="false">Investigation</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="otData-tab" data-toggle="tab" href="#otData" role="tab" aria-controls="otData"
                aria-selected="false">OT</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="dietData-tab" data-toggle="tab" href="#dietData" role="tab"
                aria-controls="dietData" aria-selected="false">Diet</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="otherServices-tab" data-toggle="tab" href="#otherServices" role="tab"
                aria-controls="otherServices" aria-selected="false">Other Services</a>
        </li>
        <li class="nav-item">
            <a href="#disMedicine" data-toggle="tab" class="nav-link" id="discontinue-medicine-tab" role="tab"
                aria-controls="disMedicine" aria-selected="false">Discontinue Medicine</a>
        </li>

        <li class="nav-item">
            <a href="#indentMedicine" data-toggle="tab" class="nav-link" id="indent-medicine-tab" role="tab"
                aria-controls="indentMedicine" aria-selected="false">Indented Medicine</a>
        </li>

        <li class="nav-item">
            <a href="#patientTreatment" data-toggle="tab" class="nav-link" id="patientTreatment-tab" role="tab"
                aria-controls="patientTreatment" aria-selected="false">Patient Treatment</a>
        </li>
        <li class="nav-item">
            <a href="#clinicalSymptom" data-toggle="tab" class="nav-link" id="clinicalSymptom-tab" role="tab"
                aria-controls="clinicalSymptom" aria-selected="false">Clinical Symptoms</a>
        </li>
        <li class="nav-item">
            <a href="#diagnosisData" data-toggle="tab" class="nav-link" id="diagnosisData-tab" role="tab"
                aria-controls="diagnosisData" aria-selected="false">Diagnosis</a>
        </li>


    </ul>

    <div class="tab-content p-0 mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
            @include('admin.ipd.nurse_station.vitals_table')

        </div>

        <div class="tab-pane fade" id="medicine" role="tabpanel" aria-labelledby="medicine-tab">
            @include('admin.ipd.nurse_station.medicine_table')
        </div>

        <div class="tab-pane fade" id="investigationData" role="tabpanel" aria-labelledby="investigationData-tab">
            @include('admin.ipd.nurse_station.investigation_table')
        </div>

        <div class="tab-pane fade" id="otData" role="tabpanel" aria-labelledby="otData-tab">
            @include('admin.ipd.nurse_station.ot_table')
        </div>


        <div class="tab-pane fade" id="dietData" role="tabpanel" aria-labelledby="dietData-tab">
            @include('admin.ipd.nurse_station.diet_table')

        </div>

        <div class="tab-pane fade" id="otherServices" role="tabpanel" aria-labelledby="otherServices-tab">
            @include('admin.ipd.nurse_station.other_services')

        </div>

        <div class="tab-pane fade" id="disMedicine" role="tabpanel" aria-labelledby="discontinue-medicine-tab">
            @include('admin.ipd.nurse_station.discontinue_medicine')

        </div>

        <div class="tab-pane fade" id="indentMedicine" role="tabpanel" aria-labelledby="indent-medicine-tab">
            @include('admin.ipd.nurse_station.indented_medicine')

        </div>
        <div class="tab-pane fade" id="patientTreatment" role="tabpanel" aria-labelledby="patientTreatment-tab">
            @include('admin.ipd.nurse_station.patientTreatment')

        </div>
        <div class="tab-pane fade" id="clinicalSymptom" role="tabpanel" aria-labelledby="clinicalSymptom-tab">
            @include('admin.ipd.nurse_station.clinical_symptoms')

        </div>
        <div class="tab-pane fade" id="diagnosisData" role="tabpanel" aria-labelledby="diagnosisData-tab">
            @include('admin.ipd.nurse_station.diagnosis_list')

        </div>
    </div>
