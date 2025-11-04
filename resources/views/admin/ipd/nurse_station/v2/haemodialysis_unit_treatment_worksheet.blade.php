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
                            <h5 class="mt-2 mb-0">HAEMODIALYSIS UNIT TREATMENT WORKSHEET</h5>
                            <small>IPD / Nurse Station / Haemodialysis unit treatment worksheet</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.haemodialysis-unit-treatment-worksheet-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-haemodialysis-unit-treatment-worksheet') }}"
                                        method="post" id="HAEMODIALYSISTW">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="haemodialysis_tw_no_pk"
                                            value="{{ isset($haemodialysistw->haemodialysis_tw_no_pk) ? $haemodialysistw->haemodialysis_tw_no_pk : '' }}">


                                        <div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <td>HD Machine</td>
                                                            <td><input type="text" name="hd_machine"
                                                                    value="{{ @$haemodialysistw->hd_machine }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bath</td>
                                                            <td><input type="text" name="bath"
                                                                    value="{{ @$haemodialysistw->bath }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dialyzer type</td>
                                                            <td><input type="text" name="dialyzer_type"
                                                                    value="{{ @$haemodialysistw->dialyzer_type }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dry Wt</td>
                                                            <td><input type="text" name="dry_wt"
                                                                    value="{{ @$haemodialysistw->dry_wt }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Starting Time</td>
                                                            @php
                                                                $start_time = explode(
                                                                    ' ',
                                                                    @$haemodialysistw->start_time,
                                                                );
                                                            @endphp
                                                            <td><input type="time" name="start_time"
                                                                    value="{{ $start_time[1] ?? '' }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Finishing Time</td>
                                                            @php
                                                                $finish_time = explode(
                                                                    ' ',
                                                                    @$haemodialysistw->finish_time,
                                                                );
                                                            @endphp
                                                            <td><input type="time" name="finish_time"
                                                                    value="{{ $finish_time[1] ?? '' }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Duration of HD</td>
                                                            <td><input type="text" name="duration"
                                                                    value="{{ @$haemodialysistw->duration }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Heparin Bolus</td>
                                                            <td><input type="text" name="heparin_bolus"
                                                                    value="{{ @$haemodialysistw->heparin_bolus }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Heparin Hourly</td>
                                                            <td><input type="text" name="heparin_hourly"
                                                                    value="{{ @$haemodialysistw->heparin_hourly }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total Heparin</td>
                                                            <td><input type="text" name="total_heparin"
                                                                    value="{{ @$haemodialysistw->total_heparin }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Access</td>
                                                            <td><input type="text" name="acess"
                                                                    value="{{ @$haemodialysistw->acess }}"
                                                                    class="form-control"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6><b>Treatment Data form:</b></h6>
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Pre-HD</th>
                                                                <th>Post-HD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Wt</td>
                                                                <td><input type="text" name="tpre_wt"
                                                                        value="{{ @$haemodialysistw->tpre_wt }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="tpost_wt"
                                                                        value="{{ @$haemodialysistw->tpost_wt }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>BP</td>
                                                                <td><input type="text" name="tpre_bp"
                                                                        value="{{ @$haemodialysistw->tpre_bp }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="tpost_bp"
                                                                        value="{{ @$haemodialysistw->tpost_bp }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Temp</td>
                                                                <td><input type="text" name="tpre_temp"
                                                                        value="{{ @$haemodialysistw->tpre_temp }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="tpost_temp"
                                                                        value="{{ @$haemodialysistw->tpost_temp }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <h6><b>Treatment Data for Today:</b></h6>
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Pre-HD</th>
                                                                <th>Post-HD</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Wt</td>
                                                                <td><input type="text" name="pre_wt"
                                                                        value="{{ @$haemodialysistw->pre_wt }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="post_wt"
                                                                        value="{{ @$haemodialysistw->post_wt }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>BP-Standing </td>
                                                                <td><input type="text" name="pre_bs"
                                                                        value="{{ @$haemodialysistw->pre_bs }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="post_bs"
                                                                        value="{{ @$haemodialysistw->post_bs }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>BP-Sitting</td>
                                                                <td><input type="text" name="pre_bps"
                                                                        value="{{ @$haemodialysistw->pre_bps }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="post_bps"
                                                                        value="{{ @$haemodialysistw->post_bps }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Temp</td>
                                                                <td><input type="text" name="pre_temp"
                                                                        value="{{ @$haemodialysistw->pre_temp }}"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="post_temp"
                                                                        value="{{ @$haemodialysistw->post_temp }}"
                                                                        class="form-control"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>



                                                <div class="col-md-6">
                                                    <table class="table table-bordered text-center">

                                                        <tbody>
                                                            <tr>
                                                                <td>Wt. Gain</td>
                                                                <td><input type="text" name="gain"
                                                                        value="{{ @$haemodialysistw->gain }}"
                                                                        class="form-control"></td>

                                                            </tr>
                                                            <tr>
                                                                <td>Dry Wt.</td>
                                                                <td><input type="text" name="dry"
                                                                        value="{{ @$haemodialysistw->dry }}"
                                                                        class="form-control"></td>

                                                            </tr>
                                                            <tr>
                                                                <td>UF Goal:</td>
                                                                <td><input type="text" name="goal"
                                                                        value="{{ @$haemodialysistw->goal }}"
                                                                        class="form-control"></td>

                                                            </tr>
                                                            <tr>
                                                                <td>IVF/BT during HD:</td>
                                                                <td><input type="text" name="ivf"
                                                                        value="{{ @$haemodialysistw->ivf }}"
                                                                        class="form-control"></td>

                                                            </tr>
                                                            <tr>
                                                                <td>Medication:</td>
                                                                <td><input type="text" name="med"
                                                                        value="{{ @$haemodialysistw->med }}"
                                                                        class="form-control"></td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Pre-Hd Remarks :</label>
                                                    <div><input type="text" name="pre"
                                                            value="{{ @$haemodialysistw->pre }}"
                                                            class="form-control"></div>
                                                </div> <br>

                                                @php
                                                    $time_list = !empty($haemodialysistw->time)
                                                        ? json_decode($haemodialysistw->time, true)
                                                        : [];
                                                    $bp = !empty($haemodialysistw->bp)
                                                        ? json_decode($haemodialysistw->bp, true)
                                                        : [];
                                                    $pr = !empty($haemodialysistw->pr)
                                                        ? json_decode($haemodialysistw->pr, true)
                                                        : [];
                                                    $bf = !empty($haemodialysistw->bf)
                                                        ? json_decode($haemodialysistw->bf, true)
                                                        : [];
                                                    $df = !empty($haemodialysistw->df)
                                                        ? json_decode($haemodialysistw->df, true)
                                                        : [];
                                                    $tmp = !empty($haemodialysistw->tmp)
                                                        ? json_decode($haemodialysistw->tmp, true)
                                                        : [];
                                                    $ap = !empty($haemodialysistw->ap)
                                                        ? json_decode($haemodialysistw->ap, true)
                                                        : [];
                                                    $vp = !empty($haemodialysistw->vp)
                                                        ? json_decode($haemodialysistw->vp, true)
                                                        : [];
                                                    $ufr = !empty($haemodialysistw->ufr)
                                                        ? json_decode($haemodialysistw->ufr, true)
                                                        : [];
                                                    $hep = !empty($haemodialysistw->hep)
                                                        ? json_decode($haemodialysistw->hep, true)
                                                        : [];
                                                    $cond = !empty($haemodialysistw->cond)
                                                        ? json_decode($haemodialysistw->cond, true)
                                                        : [];
                                                @endphp

                                                <div class="col-md-12">
                                                    <table class="table table-bordered text-center">

                                                        <tr>
                                                            <th>TIME</th>
                                                            <th>BP</th>
                                                            <th>PR</th>
                                                            <th>BF</th>
                                                            <th>DF</th>
                                                            <th>TMP</th>
                                                            <th>AP</th>
                                                            <th>VP</th>
                                                            <th>UFR</th>
                                                            <th>HEP</th>
                                                            <th>COND</th>
                                                            <th style="width: 6%">Action</th>
                                                        </tr>
                                                        <tbody id="vitalsTable">
                                                            @if (!empty($time_list))
                                                                @foreach ($time_list as $i => $time)
                                                                    <tr>
                                                                        <td><input type="text" name="time[]"
                                                                                value="{{ $time }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="bp[]"
                                                                                value="{{ $bp[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="pr[]"
                                                                                value="{{ $pr[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="bf[]"
                                                                                value="{{ $bf[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="df[]"
                                                                                value="{{ $df[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="tmp[]"
                                                                                value="{{ $tmp[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="ap[]"
                                                                                value="{{ $ap[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="vp[]"
                                                                                value="{{ $vp[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="ufr[]"
                                                                                value="{{ $ufr[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="hep[]"
                                                                                value="{{ $hep[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td><input type="text" name="cond[]"
                                                                                value="{{ $cond[$i] ?? '' }}"
                                                                                style="width:100%"></td>
                                                                        <td>
                                                                            <span
                                                                                class="btn btn-success btn-md addvt"><i
                                                                                    class="fa fa-plus"></i></span>
                                                                            <button type="button"
                                                                                class="btn btn-md btn-danger vtdeleterow"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><input type="text" name="time[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="bp[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="pr[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="bf[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="df[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="tmp[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="ap[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="vp[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="ufr[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="hep[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="cond[]"
                                                                            style="width:100%"></td>
                                                                    <td><span class="btn btn-success btn-md addvt"><i
                                                                                class="fa fa-plus"></i></span></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Complication if any:</label>
                                                    <div><input type="text" name="cfa"
                                                            value="{{ @$haemodialysistw->cfa }}"
                                                            class="form-control"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label>Post -HD remarks :</label>
                                                    <div><input type="text" name="post"
                                                            value="{{ @$haemodialysistw->post }}"
                                                            class="form-control"></div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Singnature Of Doctor :</label>
                                                    <div><input type="text" name="doc" id="doc"
                                                            value="{{ @$haemodialysistw->doc }}"
                                                            class="form-control">
                                                        <input type="hidden" name="h_doc" id="h_doc"
                                                            value="" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Singnature Of Nurse :</label>
                                                    <div><input type="text" name="nurse" id="nurse"
                                                            value="{{ @$haemodialysistw->nurse }}"
                                                            class="form-control">
                                                        <input type="hidden" name="h_nurse" id="h_nurse"
                                                            value="" class="form-control">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route(
                                                    'ipd.haemodialysis-unit-treatment-worksheet-form',
                                                    [
                                                        'patient_no_fk' => $patient_no_fk,
                                                        'admission_id' => $admission_id,
                                                    ],
                                                );
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
    openDoctorAutocomplete('#doc', 'h_doc', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse', 'h_nurse', 'employee_ind', '1');

$(function() {
    const makeRow = () => `
        <tr>
            <td><input type="text" name="time[]" style="width:100%"></td>
            <td><input type="text" name="bp[]" style="width:100%"></td>
            <td><input type="text" name="pr[]" style="width:100%"></td>
            <td><input type="text" name="bf[]" style="width:100%"></td>
            <td><input type="text" name="df[]" style="width:100%"></td>
            <td><input type="text" name="tmp[]" style="width:100%"></td>
            <td><input type="text" name="ap[]" style="width:100%"></td>
            <td><input type="text" name="vp[]" style="width:100%"></td>
            <td><input type="text" name="ufr[]" style="width:100%"></td>
            <td><input type="text" name="hep[]" style="width:100%"></td>
            <td><input type="text" name="cond[]" style="width:100%"></td>
            <td>
                <span class="btn btn-success btn-md addvt"><i class="fa fa-plus"></i></span>
                <button type="button" class="btn btn-md btn-danger vtdeleterow"><i class="fa fa-trash"></i></button>
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


</script>
