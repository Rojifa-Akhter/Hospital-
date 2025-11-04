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

    textarea {
        width: 100%;
        height: 100%;
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
                            <h5 class="mt-2 mb-0">PATIENT CLINICAL RECORDS </h5>
                            <small>IPD / Nurse Station / Patient Clinical Records</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.patient-clinical-records-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-patient-clinical-records') }}" method="post"
                                        id="PATIENT_CLINICAL_RECORDS">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="pt_clinical_rec_no_pk"
                                            value="{{ isset($pt_record->pt_clinical_rec_no_pk) ? $pt_record->pt_clinical_rec_no_pk : '' }}">


                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td><b>Presenting Complaints:</b></td>
                                                    <td>
                                                        <textarea name="pc" class="form-control form-control-sm">{{ @$pt_record->pc }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>History of Present Illness:</b></td>
                                                    <td>
                                                        <textarea name="hopi" class="form-control form-control-sm">{{ @$pt_record->hopi }}</textarea>
                                                    </td>
                                                </tr>



                                            </table>

                                            <table class="table table-bordered">

                                                <tr>
                                                    <th colspan="4">Obstetrics History:</th>
                                                </tr>


                                                <tr>
                                                    <td>Married for:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="mf" value="{{ $pt_record->mf ?? '' }}">
                                                    </td>
                                                    <td>Gravida:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="gravida"
                                                            value="{{ $pt_record->gravida ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Para:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="para" value="{{ $pt_record->para ?? '' }}">
                                                    </td>
                                                    <td>ALC:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="alc" value="{{ $pt_record->alc ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="4">Past Obstetrics History:</th>
                                                </tr>


                                                <tr>
                                                    <td>PIH/PE:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="pih" value="{{ $pt_record->pih ?? '' }}">
                                                    </td>
                                                    <td>GDM:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="gdm" value="{{ $pt_record->gdm ?? '' }}">
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>APH:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="aph" value="{{ $pt_record->aph ?? '' }}">
                                                    </td>
                                                    <td>PPH:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="pph" value="{{ $pt_record->pph ?? '' }}">
                                                    </td>
                                                </tr>


                                            </table>
                                            @php
                                                $pregnancy_list = !empty($pt_record->pregnancy)
                                                    ? json_decode($pt_record->pregnancy, true)
                                                    : [];

                                                $yeardate = !empty($pt_record->yeardate)
                                                    ? json_decode($pt_record->yeardate, true)
                                                    : [];

                                                $gestation = !empty($pt_record->gestation)
                                                    ? json_decode($pt_record->gestation, true)
                                                    : [];
                                                $induced = !empty($pt_record->induced)
                                                    ? json_decode($pt_record->induced, true)
                                                    : [];
                                                $delivery = !empty($pt_record->delivery)
                                                    ? json_decode($pt_record->delivery, true)
                                                    : [];
                                                $complication = !empty($pt_record->complication)
                                                    ? json_decode($pt_record->complication, true)
                                                    : [];
                                                $puerperium = !empty($pt_record->puerperium)
                                                    ? json_decode($pt_record->puerperium, true)
                                                    : [];
                                                $sex = !empty($pt_record->sex)
                                                    ? json_decode($pt_record->sex, true)
                                                    : [];

                                            @endphp

                                            <table class="table table-bordered text-center">

                                                <tr>
                                                    <th>No. of
                                                        Pregnancy </th>
                                                    <th>Year & Date </th>
                                                    <th>Gestation
                                                        Age </th>
                                                    <th>Spontaneous/
                                                        Induced </th>
                                                    <th>Mode of
                                                        delivery</th>
                                                    <th>Complication</th>
                                                    <th>Puerperium</th>
                                                    <th>Baby wt.
                                                        Sex, BF</th>

                                                    <th style="width: 8%">Action</th>
                                                </tr>
                                                <tbody id="vitalsTable">
                                                    @if (!empty($pregnancy_list))
                                                        @foreach ($pregnancy_list as $i => $pregnancy)
                                                            <tr>
                                                                <td><input type="text" name="pregnancy[]"
                                                                        value="{{ $pregnancy }}" style="width:100%">
                                                                </td>
                                                                <td><input type="text" name="yeardate[]"
                                                                        value="{{ $yeardate[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="gestation[]"
                                                                        value="{{ $gestation[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="induced[]"
                                                                        value="{{ $induced[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="delivery[]"
                                                                        value="{{ $delivery[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="complication[]"
                                                                        value="{{ $complication[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="puerperium[]"
                                                                        value="{{ $puerperium[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="sex[]"
                                                                        value="{{ $sex[$i] ?? '' }}"
                                                                        style="width:100%"></td>

                                                                <td>
                                                                    <span class="btn btn-success btn-md addvt"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-md btn-danger vtdeleterow"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="pregnancy[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="yeardate[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="gestation[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="induced[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="delivery[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="complication[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="puerperium[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="sex[]"
                                                                    style="width:100%">
                                                            </td>

                                                            <td><span class="btn btn-success btn-md addvt"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <table class="table table-bordered">

                                                <tr>
                                                    <th colspan="4">H/O of Immunization:</th>
                                                </tr>


                                                <tr>
                                                    <td>Tetanus:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="tetanus"
                                                            value="{{ $pt_record->tetanus ?? '' }}">
                                                    </td>
                                                    <td>Rubella:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rubella"
                                                            value="{{ $pt_record->rubella ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Hepatitis B:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="hepatitis"
                                                            value="{{ $pt_record->hepatitis ?? '' }}">
                                                    </td>
                                                    <td>Others:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="ho_others"
                                                            value="{{ $pt_record->ho_others ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="4">Menstrual History:</th>
                                                </tr>


                                                <tr>
                                                    <td>MC:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="mc" value="{{ $pt_record->mc ?? '' }}">
                                                    </td>
                                                    <td>LMP:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lmp" value="{{ $pt_record->lmp ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>MP:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="mp" value="{{ $pt_record->mp ?? '' }}">
                                                    </td>
                                                    <td>EDD:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="edd" value="{{ $pt_record->edd ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dysmenorrhea:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="dysmen"
                                                            value="{{ $pt_record->dysmen ?? '' }}">
                                                    </td>
                                                    <td>Post coital bleeding:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="bleeding"
                                                            value="{{ $pt_record->bleeding ?? '' }}">
                                                    </td>
                                                </tr>

                                            </table>
                                            <table class="table table-bordered text-center">
                                                @php
                                                    $drugs_list = !empty($pt_record->drugs)
                                                        ? json_decode($pt_record->drugs, true)
                                                        : [];
                                                    $duration = !empty($pt_record->duration)
                                                        ? json_decode($pt_record->duration, true)
                                                        : [];
                                                    $dose = !empty($pt_record->dose)
                                                        ? json_decode($pt_record->dose, true)
                                                        : [];
                                                    $side = !empty($pt_record->side)
                                                        ? json_decode($pt_record->side, true)
                                                        : [];
                                                    $adverse = !empty($pt_record->adverse)
                                                        ? json_decode($pt_record->adverse, true)
                                                        : [];
                                                @endphp


                                                <tr>
                                                    <th>Drugs</th>
                                                    <th>Durations</th>
                                                    <th>Dose</th>
                                                    <th>Side Effects </th>
                                                    <th>Adverse……</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tbody id="drugTable">
                                                    @if (!empty($drugs_list))
                                                        @foreach ($drugs_list as $i => $d)
                                                            <tr>
                                                                <td><input type="text" name="drugs[]"
                                                                        value="{{ $d }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="duration[]"
                                                                        value="{{ $duration[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="dose[]"
                                                                        value="{{ $dose[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="side[]"
                                                                        value="{{ $side[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="adverse[]"
                                                                        value="{{ $adverse[$i] ?? '' }}"
                                                                        style="width:100%"></td>
                                                                <td>
                                                                    <span class="btn btn-success btn-md add"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-md btn-danger deleterow"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="drugs[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="duration[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="dose[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="side[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="adverse[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><span class="btn btn-success btn-md add"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            @php
                                                $med_history =
                                                    json_decode($pt_record->med_history ?? '[]', true) ?? [];
                                                $surgical_history =
                                                    json_decode($pt_record->surgical_history ?? '[]', true) ?? [];
                                                $family_history =
                                                    json_decode($pt_record->family_history ?? '[]', true) ?? [];
                                            @endphp

                                            <table class="table table-bordered" style="width:100%; text-align:left;">

                                                <tr>
                                                    <th colspan="3" style="text-align:left;">H/O of Immunization:
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="1"
                                                            {{ in_array('1', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> DM
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="2"
                                                            {{ in_array('2', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Cardiac disorder
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="3"
                                                            {{ in_array('3', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Br. Asthma
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="4"
                                                            {{ in_array('4', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> PUD
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="5"
                                                            {{ in_array('5', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Liver disorder
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="6"
                                                            {{ in_array('6', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Hemoglobinopathies
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="7"
                                                            {{ in_array('7', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> HTN
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="8"
                                                            {{ in_array('8', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Thyroid disorder
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="9"
                                                            {{ in_array('9', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> UTI
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="med_history[]" value="10"
                                                            {{ in_array('10', $med_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Others:
                                                    </td>
                                                    <td colspan="2" style="text-align:left;">
                                                        <input type="text" class="form-control form-control-sm"
                                                            style="display:inline-block; width:50%; margin-left:5px;"
                                                            name="med_others"
                                                            value="{{ $pt_record->med_others ?? '' }}"
                                                            placeholder="Specify Others">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="3" style="text-align:left;">Surgical History:</th>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="1"
                                                            {{ in_array('1', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Appendicectomy
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="2"
                                                            {{ in_array('2', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Salpingectomy
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="3"
                                                            {{ in_array('3', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Laparotomy
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="4"
                                                            {{ in_array('4', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Ovarian Cystectomy
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="5"
                                                            {{ in_array('5', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> LUCS
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="surgical_history[]"
                                                            value="6"
                                                            {{ in_array('6', $surgical_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Others: <br>
                                                        <input type="text" class="form-control form-control-sm"
                                                            style="display:inline-block; width:50%; margin-top:5px;"
                                                            name="surgical_others"
                                                            value="{{ $pt_record->surgical_others ?? '' }}"
                                                            placeholder="Specify Others">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th colspan="3" style="text-align:left;">Family History:</th>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="1"
                                                            {{ in_array('1', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> HTN
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="2"
                                                            {{ in_array('2', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> DM
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="3"
                                                            {{ in_array('3', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Heart disease
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="4"
                                                            {{ in_array('4', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Br. Asthma
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="5"
                                                            {{ in_array('5', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Allergies
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="family_history[]" value="6"
                                                            {{ in_array('6', $family_history) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Others: <br>
                                                        <input type="text" class="form-control form-control-sm"
                                                            style="display:inline-block; width:50%; margin-top:5px;"
                                                            name="family_others"
                                                            value="{{ $pt_record->family_others ?? '' }}"
                                                            placeholder="Specify Others">
                                                    </td>
                                                </tr>
                                            </table>

                                            <table class="table table-bordered">

                                                <tr>
                                                    <th colspan="4">Social & Personal history:</th>
                                                </tr>


                                                <tr>
                                                    <td>Occupation:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="occupation"
                                                            value="{{ $pt_record->occupation ?? '' }}">
                                                    </td>
                                                    <td>Education:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="education"
                                                            value="{{ $pt_record->education ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Husband Occupation:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="occupation_husband"
                                                            value="{{ $pt_record->occupation_husband ?? '' }}">
                                                    </td>
                                                    <td>Financial Condition:</td>
                                                    <td>
                                                        <select name="financial_condition"
                                                            class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->financial_condition == '1' ? 'selected' : '' }}>
                                                                Poor</option>
                                                            <option value="2"
                                                                {{ @$pt_record->financial_condition == '2' ? 'selected' : '' }}>
                                                                Middle</option>
                                                            <option value="3"
                                                                {{ @$pt_record->financial_condition == '3' ? 'selected' : '' }}>
                                                                Upper</option>
                                                        </select>
                                                    </td>
                                                </tr>

                                            </table>
                                            @php
                                                $method_list = !empty($pt_record->method)
                                                    ? json_decode($pt_record->method, true)
                                                    : [];
                                                $use_duration = !empty($pt_record->use_duration)
                                                    ? json_decode($pt_record->use_duration, true)
                                                    : [];
                                            @endphp
                                            <table class="table table-bordered text-center">
                                                <tr>
                                                    <th colspan="3">Contraceptive Used:</th>
                                                </tr>

                                                <tr>
                                                    <th>Methods</th>
                                                    <th>Duration of Use</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tbody id="contraceptiveTable">
                                                    @if (!empty($method_list))
                                                        @foreach ($method_list as $i => $m)
                                                            <tr>
                                                                <td><input type="text" name="method[]"
                                                                        value="{{ $m }}"
                                                                        style="width:100%"></td>
                                                                <td><input type="text" name="use_duration[]"
                                                                        value="{{ $use_duration[$i] ?? '' }}"
                                                                        style="width:100%"></td>

                                                                <td>
                                                                    <span class="btn btn-success btn-md addct"><i
                                                                            class="fa fa-plus"></i></span>
                                                                    <span class="btn btn-md btn-danger deleterowct"><i
                                                                            class="fa fa-trash"></i></span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="method[]"
                                                                    style="width:100%">
                                                            </td>
                                                            <td><input type="text" name="use_duration[]"
                                                                    style="width:100%">
                                                            </td>

                                                            <td><span class="btn btn-success btn-md addct"><i
                                                                        class="fa fa-plus"></i></span></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <table class="table table-bordered" style="width:100%; text-align:left;">

                                                <tr>
                                                    <th colspan="3" style="text-align:left;">General Examination:
                                                    </th>
                                                </tr>

                                                @php
                                                    $general_exam =
                                                        json_decode($pt_record->general_exam ?? '[]', true) ?? [];
                                                @endphp

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="1"
                                                            {{ in_array('1', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Appearance
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="2"
                                                            {{ in_array('2', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Cyanosis
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="3"
                                                            {{ in_array('3', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Breast
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="4"
                                                            {{ in_array('4', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Height
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="5"
                                                            {{ in_array('5', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Edema
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="6"
                                                            {{ in_array('6', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Lymphnodes
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="7"
                                                            {{ in_array('7', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Weight
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="8"
                                                            {{ in_array('8', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Heart sound
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="9"
                                                            {{ in_array('9', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Thyroid
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="10"
                                                            {{ in_array('10', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Pulse
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="11"
                                                            {{ in_array('11', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Murmur
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="12"
                                                            {{ in_array('12', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Others
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="13"
                                                            {{ in_array('13', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> BP
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="14"
                                                            {{ in_array('14', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Lungs
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="15"
                                                            {{ in_array('15', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Temp.
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="16"
                                                            {{ in_array('16', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Breath sound
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="17"
                                                            {{ in_array('17', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Resp. Rate
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="18"
                                                            {{ in_array('18', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Creps
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="19"
                                                            {{ in_array('19', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Anemia
                                                    </td>
                                                    <td style="text-align:left;">
                                                        <input type="checkbox" name="general_exam[]" value="20"
                                                            {{ in_array('20', $general_exam) ? 'checked' : '' }}
                                                            style="margin-right:5px;" /> Rhonchi
                                                    </td>
                                                    <td style="text-align:left;"></td>
                                                </tr>

                                            </table>


                                            <table class="table table-bordered">

                                                <tr>
                                                    <th colspan="4">Abdominal Examination: </th>
                                                </tr>

                                                <tr>
                                                    <th colspan="4" style="text-align: left">Obstetrical:</th>
                                                </tr>


                                                <tr>
                                                    <td>Ht of uterus (wks/cm)</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="uterus"
                                                            value="{{ $pt_record->uterus ?? '' }}">
                                                    </td>
                                                    <td>Presentation:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="presentation"
                                                            value="{{ $pt_record->presentation ?? '' }}">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Engagement:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="engagement"
                                                            value="{{ $pt_record->engagement ?? '' }}">
                                                    </td>
                                                    <td>Amniotic fluid vol:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="vol"
                                                            value="{{ $pt_record->vol ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fetal movement:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="fetal"
                                                            value="{{ $pt_record->fetal ?? '' }}">
                                                    </td>
                                                    <td>Scar tenderness:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="scar"
                                                            value="{{ $pt_record->scar ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>FHS:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="fhs"
                                                            value="{{ $pt_record->fhs ?? '' }}">
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Gynecological:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="gynecological" class="form-control form-control-sm">{{ @$pt_record->gynecological }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Inspection:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="inspection" class="form-control form-control-sm">{{ @$pt_record->inspection }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Any Lumps:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lumps"
                                                            value="{{ $pt_record->lumps ?? '' }}">
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Palpation:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="palpation" class="form-control form-control-sm">{{ @$pt_record->palpation }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: left">Lumps:</th>
                                                </tr>
                                                <tr>
                                                    <td>Size:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lum_size"
                                                            value="{{ $pt_record->lum_size ?? '' }}">
                                                    </td>
                                                    <td>Mobility:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lum_mobility"
                                                            value="{{ $pt_record->lum_mobility ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Margin Ill Defined:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lum_margin"
                                                            value="{{ $pt_record->lum_margin ?? '' }}">
                                                    </td>
                                                    <td>Ascites:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="lum_ascites"
                                                            value="{{ $pt_record->lum_ascites ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Percussion:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="percussion" class="form-control form-control-sm">{{ @$pt_record->percussion }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Auscultation:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="auscultation" class="form-control form-control-sm">{{ @$pt_record->auscultation }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Pelvic Examination:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="pelvic" class="form-control form-control-sm">{{ @$pt_record->pelvic }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: left">Obstetrical:</th>
                                                </tr>
                                                <tr>
                                                    <td>Cervix Consistency</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="cervix"
                                                            value="{{ $pt_record->cervix ?? '' }}">
                                                    </td>
                                                    <td>Position</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="pos"
                                                            value="{{ $pt_record->pos ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Effacement(%)</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="effacement"
                                                            value="{{ $pt_record->effacement ?? '' }}">
                                                    </td>
                                                    <td>Presentation part</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="p_part"
                                                            value="{{ $pt_record->p_part ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Station</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="station"
                                                            value="{{ $pt_record->station ?? '' }}">
                                                    </td>
                                                    <td>Pelvis</td>
                                                    <td>
                                                        <select name="pelvis" class="form-control form-control-sm">
                                                            <option value="">Select</option>
                                                            <option value="1"
                                                                {{ @$pt_record->pelvis == '1' ? 'selected' : '' }}>
                                                                Adequate</option>
                                                            <option value="2"
                                                                {{ @$pt_record->pelvis == '2' ? 'selected' : '' }}>
                                                                Border line</option>
                                                            <option value="3"
                                                                {{ @$pt_record->pelvis == '3' ? 'selected' : '' }}>
                                                                Inadequate</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Gynecological:</th>
                                                </tr>
                                                <tr>
                                                    <td>Vulva/vagina</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="vagina"
                                                            value="{{ $pt_record->vagina ?? '' }}">
                                                    </td>
                                                    <td>Urethral orifice</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="orifice"
                                                            value="{{ $pt_record->orifice ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Perineum</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="perineum"
                                                            value="{{ $pt_record->perineum ?? '' }}">
                                                    </td>
                                                    <td>Cystocele</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="cystocele"
                                                            value="{{ $pt_record->cystocele ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Perspectum:</th>
                                                </tr>
                                                <tr>
                                                    <td>Cervix</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="vagina"
                                                            value="{{ $pt_record->vagina ?? '' }}">
                                                    </td>
                                                    <td>Fomices</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="orifice"
                                                            value="{{ $pt_record->orifice ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Discharge – </td>
                                                    <td>Color <br>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="color"
                                                            value="{{ $pt_record->color ?? '' }}">
                                                    </td>
                                                    <td>
                                                        Amount <br>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="amount"
                                                            value="{{ $pt_record->amount ?? '' }}">
                                                    </td>
                                                    <td>
                                                        Smell <br>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="smell"
                                                            value="{{ $pt_record->smell ?? '' }}">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th colspan="4">Bimanual:</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: left">Uterus</th>
                                                </tr>
                                                <tr>
                                                    <td>Size:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="u_size"
                                                            value="{{ $pt_record->u_size ?? '' }}">
                                                    </td>
                                                    <td>Consistency:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="u_consistency"
                                                            value="{{ $pt_record->u_consistency ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: left">Fomices</th>
                                                </tr>
                                                <tr>
                                                    <td>Rt:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="f_rt"
                                                            value="{{ $pt_record->f_rt ?? '' }}">
                                                    </td>
                                                    <td>Lt:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="f_lt"
                                                            value="{{ $pt_record->f_lt ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Posterior:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="posterior"
                                                            value="{{ $pt_record->posterior ?? '' }}">
                                                    </td>
                                                    <td>Appendages:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="appendage"
                                                            value="{{ $pt_record->appendage ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: left">Pre rectal Exam</th>
                                                </tr>
                                                <tr>
                                                    <td>Rectal mucosa:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="mucosa"
                                                            value="{{ $pt_record->mucosa ?? '' }}">
                                                    </td>
                                                    <td>Sphincter condition:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="sphincter"
                                                            value="{{ $pt_record->sphincter ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Any lump:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="any_lump"
                                                            value="{{ $pt_record->any_lump ?? '' }}">
                                                    </td>
                                                    <td>Rectocele:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="rectocele"
                                                            value="{{ $pt_record->rectocele ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Other Systemic Examination:</th>
                                                </tr>
                                                <tr>
                                                    <td>CVS:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="cvs"
                                                            value="{{ $pt_record->cvs ?? '' }}">
                                                    </td>
                                                    <td>Respiratory:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="respiratory"
                                                            value="{{ $pt_record->respiratory ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>CNS:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="cns"
                                                            value="{{ $pt_record->cns ?? '' }}">
                                                    </td>
                                                    <td>Others:</td>
                                                    <td><input type="text" class="form-control form-control-sm"
                                                            name="systemic_other"
                                                            value="{{ $pt_record->systemic_other ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Provisional Diagnosis:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="provisional" class="form-control form-control-sm">{{ @$pt_record->provisional }}</textarea>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Initial Diagnosis:</b></td>
                                                    <td colspan="3">
                                                        <textarea name="initial_diagnosis" class="form-control form-control-sm">{{ @$pt_record->initial_diagnosis }}</textarea>
                                                    </td>
                                                </tr>


                                            </table>

                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.patient-clinical-records-form', [
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
    openDoctorAutocomplete('#doc_name', 'hh_doc_name', 'employee_ind', '1');
    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="text" name="pregnancy[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="yeardate[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="gestation[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="induced[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="delivery[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="complication[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="puerperium[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="sex[]" style="width:100%">
                                                        </td>
            <td>
                <span class="btn btn-md btn-danger vtdeleterow"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;

        // Prevent duplicate bindings
        $(document).off('click', '.addvt').on('click', '.addvt', function(e) {
            e.preventDefault();
            $("#vitalsTable").append(makeRow());
        });

        $(document).off('click', '.vtdeleterow').on('click', '.vtdeleterow', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="text" name="drugs[]" style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="duration[]"
                                                                style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="dose[]"
                                                                style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="side[]"
                                                                style="width:100%">
                                                        </td>
                                                        <td><input type="text" name="adverse[]"
                                                                style="width:100%">
                                                        </td>
            <td>
                <span class="btn btn-md btn-danger deleterow"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;


        $(document).off('click', '.add').on('click', '.add', function(e) {
            e.preventDefault();
            $("#drugTable").append(makeRow());
        });

        $(document).off('click', '.deleterow').on('click', '.deleterow', function() {
            $(this).closest('tr').remove();
        });
    });
    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="text" name="method[]" style="width:100%"></td>
            <td><input type="text" name="use_duration[]" style="width:100%"></td>
            <td>
                <span class="btn btn-md btn-danger deleterowct"><i class="fa fa-trash"></i></span>
            </td>
        </tr>`;


        $(document).off('click', '.addct').on('click', '.addct', function(e) {
            e.preventDefault();
            $("#contraceptiveTable").append(makeRow());
        });

        $(document).off('click', '.deleterowct').on('click', '.deleterowct', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
