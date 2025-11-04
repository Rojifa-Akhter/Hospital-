<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Post Anesthesia Instructions</h5>
                <small>Report / Post Anesthesia Instructions</small>
            </div>
        </div>

        <div class="anaesthetic__form">
            <form action="{{ route('post-anesthetic-checkup-store') }}" method="post" id="postANESTHETICCHECKUP">
                @csrf
                <input type="hidden" name="admission_id"
                    value="{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}">
                <input type="hidden" name="ref_no" value="{{ isset($ref_no) ? $ref_no : '' }}">
                <input type="hidden" name="pat_id"
                    value="{{ isset($pat_info->patient_no_pk) ? $pat_info->patient_no_pk : '' }}">
                <input type="hidden" name="anesthesia_orders_no_pk"
                    value="{{ isset($pre_anesthetic_checkup->anesthesia_orders_no_pk) ? $pre_anesthetic_checkup->anesthesia_orders_no_pk : '' }}">

                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h2 class="card-title mb-0 text-left"><strong>Patient Info</strong></h2>
                            </div>
                            <div class="card-body p-3">
                                <div class="form-row" style="border: 1px solid #298949; padding: 10px;">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="regNo" class="col-form-label col-form-label-sm">UHID
                                            </label>
                                            <input type="text" class="form-control form-control-sm" id="regNo"
                                                name="regNo"
                                                value="{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}"
                                                placeholder="" readonly />
                                        </div>
                                    </div>


                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ippt" class="col-form-label col-form-label-sm">
                                                IP No</label>
                                            <input type="text" class="form-control form-control-sm" readonly
                                                id="ippt" name="ippt"
                                                value="{{ isset($pat_info->admission_uid) ? $pat_info->admission_uid : '' }}"
                                                placeholder="ip no" />
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nameOfpt" class="col-form-label col-form-label-sm">
                                                Patient Name</label>
                                            <input type="text" class="form-control form-control-sm" readonly
                                                id="nameOfpt" name="nameOfpt"
                                                value="{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}"
                                                placeholder="Name Of pt" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ptAge" class="col-form-label col-form-label-sm">Age</label>
                                            <input type="text" class="form-control form-control-sm" id="ptAge"
                                                name="ptAge"
                                                value="{{ isset($pat_info->age) ? $pat_info->age : '' }}"
                                                placeholder="45 Years" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ptSex" class="col-form-label col-form-label-sm">Sex</label>
                                            <input type="text" class="form-control form-control-sm" id="ptSex"
                                                name="ptSex"
                                                value="{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}"
                                                placeholder="" readonly />
                                        </div>
                                    </div>


                                    {{-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ptUnit"
                                                class="col-form-label col-form-label-sm">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="ptUnit"
                                                name="ptUnit"
                                                value="{{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : '' }}"
                                                placeholder="" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ptWard" class="col-form-label col-form-label-sm">Cabin</label>
                                            <input type="text" class="form-control form-control-sm" id="ptWard"
                                                name="ptWard"
                                                value="{{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : '' }}"
                                                placeholder="" readonly />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="ptBed" class="col-form-label col-form-label-sm">Bed
                                                Category</label>
                                            <input type="text" class="form-control form-control-sm" id="ptBed"
                                                name="ptBed"
                                                value="{{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : '' }}"
                                                placeholder="" readonly />
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="date" class="col-form-label col-form-label-sm">Reg.
                                                Date</label>
                                            <input type="text" class="form-control form-control-sm" id="date"
                                                name="date"
                                                value="{{ isset($pat_info->reg_date) ? date('Y-m-d', strtotime($pat_info->reg_date)) : date('Y-m-d') }}"
                                                placeholder="YYYY-mm-dd" readonly tabindex="-1" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm">Consultant</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="doctor_name" name="doctor_name" placeholder="Dr. Name"
                                                value="{{ isset($pre_anesthetic_checkup->doctor_name) ? $pre_anesthetic_checkup->doctor_name : '' }}"
                                                />
                                            <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id"
                                                value="{{ isset($pat_info->primary_doctor_no_fk) ? $pat_info->primary_doctor_no_fk : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h2 class="card-title mb-0 text-left"><strong>Post Anesthesia Instructions</strong>
                                </h2>
                            </div>
                            <table width="100%" border="1" style="margin-top:10px">
                                <tr>
                                    <td>
                                        <label for="position"
                                            class="col-form-label col-form-label-sm">Position:</label>

                                    </td>
                                    <td>
                                        <select name="position" class="form-select large-select mt-1">
                                            <option value="Supine"
                                                {{ isset($pre_anesthetic_checkup->position) && $pre_anesthetic_checkup->position == 'Supine' ? 'selected' : '' }}>
                                                Supine</option>

                                            <option value="Lateral- Right or left"
                                                {{ isset($pre_anesthetic_checkup->position) && $pre_anesthetic_checkup->position == 'Lateral- Right or left' ? 'selected' : '' }}>
                                                Lateral- Right or left</option>

                                            <option value="Head Elevated"
                                                {{ isset($pre_anesthetic_checkup->position) && $pre_anesthetic_checkup->position == 'Head Elevated' ? 'selected' : '' }}>
                                                Head Elevated</option>

                                        </select>

                                    </td>
                                    <td>
                                        <label for="p_others" class="col-form-label col-form-label-sm">Others:</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="p_others"
                                            value="{{ isset($pre_anesthetic_checkup->flow_mint) ? $pre_anesthetic_checkup->flow_mint : '' }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="oxygen" class="col-form-label col-form-label-sm">Oxygen:
                                        </label></td>
                                    <td>
                                        <select name="oxygen" class="form-select large-select mt-1">
                                            <option value="Nasal canula"
                                                {{ isset($pre_anesthetic_checkup->oxygen) && $pre_anesthetic_checkup->oxygen == 'Nasal canula' ? 'selected' : '' }}>
                                                Nasal canula</option>

                                            <option value="Mask"
                                                {{ isset($pre_anesthetic_checkup->oxygen) && $pre_anesthetic_checkup->oxygen == 'Mask' ? 'selected' : '' }}>
                                                Mask</option>

                                        </select>
                                    </td>
                                    <td>
                                        <label for="ox_others" class="col-form-label col-form-label-sm">Others:</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="ox_others"
                                            value="{{ isset($pre_anesthetic_checkup->monitor_dtl) ? $pre_anesthetic_checkup->monitor_dtl : '' }}" />
                                    </td>
                                    <td>
                                        <strong>(Flow @ L/min):</strong>
                                        <input type="text" class="form-control form-control-sm d-inline-block"
                                            name="flow_hr" style="width:50%;"
                                            value="{{ isset($pre_anesthetic_checkup->flow_hr) ? $pre_anesthetic_checkup->flow_hr : '' }}" />
                                        <strong>hr</strong>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="col-form-label col-form-label-sm">Nothing per oral (NPO)
                                            till:</label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" class="form-control form-control-sm d-inline-block"
                                            name="npo" style="width:70%;"
                                            value="{{ isset($pre_anesthetic_checkup->npo) ? $pre_anesthetic_checkup->npo : '' }}" />
                                        <strong>hr</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="col-form-label col-form-label-sm">Monitor</label>
                                    </td>
                                    <td colspan="3">
                                        <p>
                                            Pulse. Blood pressure, Respiratory rate, SpO2, Temp, Surgical drain( If
                                            any),
                                            Nasogastric suction( If any), Sanitary pad ( If any) at 5 minute interval
                                            for 15
                                            minutes, then 10 min interval for 30 minute and then 15 min interval for 1
                                            hour
                                        </p>

                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="col-form-label col-form-label-sm">Record</label>
                                    </td>
                                    <td colspan="3">
                                        <p>
                                            Pulse, Blood pressure, Respiratory rate, SpO2, Temp, Surgical drain( If
                                            any),
                                            Nasogastric suction( If any), Sanitary pad ( If any) at 1 hour interval.
                                        </p>

                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <label class="col-form-label col-form-label-sm">Care of Anesthetized
                                            (paralyzed/numbed)
                                            area</label>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <label class="col-form-label col-form-label-sm">Encourage change of
                                            posture</label>
                                        as soon as possible by him/herself

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="form-group">
                                            <label for="analgesia"
                                                class="col-form-label col-form-label-sm">Analgesia:</label>
                                            <textarea name="analgesia" class="form-control" rows="4">{{ isset($pre_anesthetic_checkup->analgesia) ? $pre_anesthetic_checkup->analgesia : '' }}</textarea>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="form-group">
                                            <label for="fluid" class="col-form-label col-form-label-sm">Fluid &
                                                Others:</label>
                                            <textarea name="fluid" class="form-control" rows="5">{{ $pre_anesthetic_checkup->fluid ?? '' }}</textarea>


                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="form-group">
                                            <label for="special_instructions"
                                                class="col-form-label col-form-label-sm">Special
                                                Instructions:</label>
                                            <textarea name="special_instructions" class="form-control" rows="5">{{ isset($pre_anesthetic_checkup->special_instructions) ? $pre_anesthetic_checkup->special_instructions : '' }}</textarea>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label for="shift_to"
                                            class="col-form-label col-form-label-sm">Shift
                                            to:</label></td>
                                    <td colspan="3">
                                        <select name="shift_to" class="form-select large-select mt-1">
                                            <option value="Cabin"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'Cabin' ? 'selected' : '' }}>
                                                Cabin</option>

                                            <option value="Word"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'Word' ? 'selected' : '' }}>
                                                Word</option>
                                            <option value="Post operative ward"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'Post operative ward' ? 'selected' : '' }}>
                                                Post operative ward</option>
                                            <option value="HDU"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'HDU' ? 'selected' : '' }}>
                                                HDU</option>
                                            <option value="ICU"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'ICU' ? 'selected' : '' }}>
                                                ICU</option>
                                            <option value="Discharge"
                                                {{ isset($pre_anesthetic_checkup->shift_to) && $pre_anesthetic_checkup->shift_to == 'Discharge' ? 'selected' : '' }}>
                                                Discharge</option>

                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><label
                                            class="col-form-label col-form-label-sm">Anesthesiologists:</label></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            id="anesthesiologists" name="anesthesiologists" placeholder="Name"
                                            value="{{ isset($pre_anesthetic_checkup->anesthesiologist) ? $pre_anesthetic_checkup->anesthesiologist : '' }}" />
                                        <input type="hidden" name="hdn_anesthesiologists" id="hdn_anesthesiologists"
                                            value="{{ isset($pre_anesthetic_checkup->anesthesiologist_no_fk) ? $pre_anesthetic_checkup->anesthesiologist_no_fk : '' }}">
                                    </td>
                                    <td><label class="col-form-label col-form-label-sm">Surgeons:</label></td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="surgeons"
                                            name="surgeons" placeholder="Name"
                                            value="{{ isset($pre_anesthetic_checkup->surgeons) ? $pre_anesthetic_checkup->surgeons : '' }}" />
                                        <input type="hidden" name="hdn_surgeons" id="hdn_surgeons"
                                            value="{{ isset($pre_anesthetic_checkup->surgeons_no_fk) ? $pre_anesthetic_checkup->surgeons_no_fk : '' }}">
                                    </td>
                                </tr>
                                {{-- <tr>
                        <td colspan="5">
                            <div class="form-group">
                                <label for="date" class="col-form-label col-form-label-sm">Date</label>
                                <input type="text" class="form-control form-control-sm date_picker" id="date"
                                    name="date" placeholder="Date" />
                            </div>
                        </td>
                    </tr> --}}


                            </table>

                        </div>
                    </div>
                </div>

                @php
                    $redirect_url = route('ipd.post-anesthetic-checkup-form',[$pat_info->patient_no_pk,$ref_no]);
                @endphp

                <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
            </form>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    openDoctorAutocomplete('#doctor_name', 'hdn_doctor_id', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#anesthesiologists', 'hdn_anesthesiologists', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#surgeons', 'hdn_surgeons', 'doctor_ind', '1,2');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd-mm-yyyy'
        });
        $('.timepicker').timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });

    });
</script>
