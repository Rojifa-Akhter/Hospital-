<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">BLOOD TRANSFUSION ORDER</h5>
                            <small>IPD / Nurse Station / BLOOD TRANSFUSION ORDER</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('blood-transfusion-order-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('blood-transfusion-order-store') }}" method="post" id="BLOODTRANSFUSIONORDERFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" value="{{ $admission_id }}">
                                        <input type="hidden" name="blood_transfusion_order_no_pk" value="{{ isset($order_form->blood_transfusion_order_no_pk) ? $order_form->blood_transfusion_order_no_pk : '' }}">

                                        <div class="card p-3 mb-3">
                                            <h5 class="text-center mb-4">BLOOD TRANSFUSION ORDER</h5>

                                            <!-- Basic Information (not in table) -->
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label>(To be filled In by Physician)</label>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>Blood group & Rh type:</b></label>
                                                    <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', @$order_form->blood_group) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Blood bag Number:</b></label>
                                                    <input type="text" name="blood_bag_no" class="form-control" value="{{ old('blood_bag_no', @$order_form->blood_bag_no) }}">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>Component:</b></label>
                                                    <input type="text" name="component" class="form-control" value="{{ old('component', @$order_form->component) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Date & Time of Collection:</b></label>
                                                    <input type="datetime-local" name="collection_datetime" class="form-control" value="{{ old('collection_datetime', @$order_form->collection_datetime) }}">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>Date & Time of Transfusion:</b></label>
                                                    <input type="datetime-local" name="transfusion_datetime" class="form-control" value="{{ old('transfusion_datetime', @$order_form->transfusion_datetime) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Expiry date:</b></label>
                                                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', @$order_form->expiry_date ? \Carbon\Carbon::parse($order_form->expiry_date)->format('Y-m-d') : '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table border="1" width="100%" cellspacing="0" cellpadding="5">

                                                <!-- Instruction -->
                                                <tr>
                                                    <td colspan="6">
                                                        <p>
                                                            Please transfuse 1 unit of PRBC /Whole blood /FFP / Platelet/ Cryoprecipitate I/V at the rate of 10-15 drops / Min & watch for 15 minutes for any hypersensitivity reaction .1f there is no transfusion reaction then transfuse at 25 drops per minutes & continue the transfusion till end. Please complete the transfusion as per bellow instruction.
                                                        </p>
                                                    </td>
                                                </tr>

                                                <!-- Blood Component Table -->
                                                <tr>
                                                    <th colspan="2">Blood or blood component</th>
                                                    <th colspan="2">Start Transfusion</th>
                                                    <th colspan="2">Complete Transfusion</th>
                                                </tr>
                                                @php
                                                    $components = [
                                                        ['Whole Blood','Within 30 minutes','Within 4 Hours'],
                                                        ['Red cell','Within 30 minutes','Within 4 Hours'],
                                                        ['Platelet Concentrate','Immediately','Within 20 minutes'],
                                                        ['Fresh Frozen Plasma','Immediately','Within 20 minutes'],
                                                        ['Cryoprecipitate','Immediately','Within 20 minutes'],
                                                    ];
                                                @endphp
                                                @foreach($components as $c)
                                                <tr>
                                                    <td colspan="2">{{ $c[0] }}</td>
                                                    <td colspan="2">{{ $c[1] }}</td>
                                                    <td colspan="2">{{ $c[2] }}</td>
                                                </tr>
                                                @endforeach

                                                <!-- Reaction Instructions -->
                                                <tr>
                                                    <td colspan="6">
                                                        <p>
                                                            Please look for symptoms and signs of adverse event/Transfusion reaction (chills/rigor. Fever with chills, respiratory distress including dyspnea, tachypnea, wheezing, hypoxemia, chest pain, back pain, infusion site pain, nausea with or without vomiting, urticarial including hives, rash, itching, and hematuria).
                                                        </p>
                                                        <p>
                                                            If any adverse event/ transfusion reaction develops during the transfusion, then do the following:
                                                            <ol>
                                                                <li>Stop transfusion</li>
                                                                <li>Follow SOS order in MAR</li>
                                                                <li>Inform the duty doctor</li>
                                                                <li>4.	Maintain venous access using a new administration set and 0.9% sodium chloride (Normal saline).
                                                                    But do not discard the blood administration set and do not flush the original line.
                                                                </li>
                                                                <li>Monitor and record the patient’s temperature, pulse, respirations and blood pressure</li>
                                                                <li>Report the event as per guidelines</li>
                                                            </ol>
                                                        </p>
                                                    </td>
                                                </tr>

                                                <!-- Doctor Details -->
                                                <tr>
                                                    <th>Doctor</th>
                                                    <th>Name</th>
                                                    <th>Signature</th>
                                                    <th>Emp. ID</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><input type="text" name="doctor_name" class="form-control" id="doctor_name" value="{{ old('doctor_name', @$order_form->doctor_name) }}">
                                                    <input type="hidden" name="h_doctor_name" id="h_doctor_name" ></td>
                                                    <td><input type="text" name="doctor_signature" class="form-control" value="{{ old('doctor_signature', @$order_form->doctor_signature) }}"></td>
                                                    <td><input type="text" name="doctor_emp_id" class="form-control" value="{{ old('doctor_emp_id', @$order_form->doctor_emp_id) }}"></td>
                                                    <td><input type="date" name="doctor_date" class="form-control" value="{{ old('doctor_date', @$order_form->doctor_date ? \Carbon\Carbon::parse($order_form->doctor_date)->format('Y-m-d') : '') }}"></td>
                                                    <td><input type="time" name="doctor_time" class="form-control" value="{{ old('doctor_time', @$order_form->doctor_time) }}"></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="text-center mt-3">
                                            @php
                                                $redirect_url = route('blood-transfusion-order', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp
                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_name', 'h_doctor_name', 'employee_ind', '1');

</script>


<script>
    function toggleField(divId, show) {
        document.getElementById(divId).style.display = show ? 'block' : 'none';
    }
</script>