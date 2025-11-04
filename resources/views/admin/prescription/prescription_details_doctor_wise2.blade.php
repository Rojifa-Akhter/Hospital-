<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    #examination ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #examination li {
        list-style: none;
        margin-bottom: 0px;
    }

    #history ul {
        list-style: none;
        margin-bottom: 0px;
        padding-left: 25px;
    }

    #history li {
        list-style: none;
        margin-bottom: 0px;
    }
    .dataTable tbody tr td{
        padding: 0px;
    }

</style>
@php
$add_to_pres_url = route('add-pres-favourit-list');
$physio_erectile_edit = (isset($physio_erectile_edit) && (!empty($physio_erectile_edit))) ? $physio_erectile_edit : [];
$problem_duration = ($physio_erectile_edit) ? $physio_erectile_edit->problem_duration: '';
$onset_problem = ($physio_erectile_edit) ? $physio_erectile_edit->onset_problem: '';
//$onset_problem = ($physio_erectile_edit) ? $physio_erectile_edit->onset_problem: '';
$related_onset = ($physio_erectile_edit) ? $physio_erectile_edit->related_onset: '';
$psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
$psf_sexual_raltion = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexual_raltion: '';
$psf_penetrate_partner = ($physio_erectile_edit) ? $physio_erectile_edit->psf_penetrate_partner: '';
$psf_completion_intercourse = ($physio_erectile_edit) ? $physio_erectile_edit->psf_completion_intercourse: '';
$psf_satisfactory_opinion = ($physio_erectile_edit) ? $physio_erectile_edit->psf_satisfactory_opinion: '';
$psf_sexual_desire = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexual_desire: '';
$psf_during_past_month = ($physio_erectile_edit) ? $physio_erectile_edit->psf_during_past_month: '';
$psf_achieving_orgasm = ($physio_erectile_edit) ? $physio_erectile_edit->psf_achieving_orgasm: '';
$psf_sexual_partner = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexual_partner: '';
$achieve_orgasm = ($physio_erectile_edit) ? $physio_erectile_edit->achieve_orgasm: '';
$ejaculate_normally = ($physio_erectile_edit) ? $physio_erectile_edit->ejaculate_normally: '';
$premature_ejaculation = ($physio_erectile_edit) ? $physio_erectile_edit->premature_ejaculation: '';
$emotional_cause = ($physio_erectile_edit) ? $physio_erectile_edit->emotional_cause: '';
$pain_erection = ($physio_erectile_edit) ? $physio_erectile_edit->pain_erection: '';
$abnormaly_bend = ($physio_erectile_edit) ? $physio_erectile_edit->abnormaly_bend: '';
$directions_bend = ($physio_erectile_edit) ? $physio_erectile_edit->directions_bend: '';
$degrees_bend = ($physio_erectile_edit) ? $physio_erectile_edit->degrees_bend: '';
$bend_during = ($physio_erectile_edit) ? $physio_erectile_edit->bend_during: '';
$pev_level_measure = ($physio_erectile_edit) ? $physio_erectile_edit->pev_level_measure: '';
$pev_testosterone_result = ($physio_erectile_edit) ? $physio_erectile_edit->pev_testosterone_result: '';
$pev_penile_injection = ($physio_erectile_edit) ? $physio_erectile_edit->pev_penile_injection: '';
$pev_full_erection_result = ($physio_erectile_edit) ? $physio_erectile_edit->pev_full_erection_result: '';
$pev_blood_flow = ($physio_erectile_edit) ? $physio_erectile_edit->pev_blood_flow: '';
$pev_penile_blood_result = ($physio_erectile_edit) ? $physio_erectile_edit->pev_penile_blood_result: '';
$pev_erections_sleep = ($physio_erectile_edit) ? $physio_erectile_edit->pev_erections_sleep: '';
$pev_erection_result = ($physio_erectile_edit) ? $physio_erectile_edit->pev_erection_result: '';
$pt_cialis = ($physio_erectile_edit) ? $physio_erectile_edit->pt_cialis: '';
$pt_vigra_work = ($physio_erectile_edit) ? $physio_erectile_edit->pt_vigra_work: '';
$pt_muse = ($physio_erectile_edit) ? $physio_erectile_edit->pt_muse: '';
$pt_muse_produce = ($physio_erectile_edit) ? $physio_erectile_edit->pt_muse_produce: '';
$pt_using_muse = ($physio_erectile_edit) ? $physio_erectile_edit->pt_using_muse: '';
$pt_injection_therapy = ($physio_erectile_edit) ? $physio_erectile_edit->pt_injection_therapy: '';
$pt_injection_produce = ($physio_erectile_edit) ? $physio_erectile_edit->pt_injection_produce: '';
$pt_doing_injection = ($physio_erectile_edit) ? $physio_erectile_edit->pt_doing_injection: '';
$pt_vacuum_device = ($physio_erectile_edit) ? $physio_erectile_edit->pt_vacuum_device: '';
$pt_vacuum_device_work = ($physio_erectile_edit) ? $physio_erectile_edit->pt_vacuum_device_work: '';
$pt_like_vacuum_device = ($physio_erectile_edit) ? $physio_erectile_edit->pt_like_vacuum_device: '';
$pt_treatment_ind = ($physio_erectile_edit) ? $physio_erectile_edit->pt_treatment_ind: '';
$pt_treatments = ($physio_erectile_edit) ? $physio_erectile_edit->pt_treatments: '';
$rsd_injureid_penis = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_injureid_penis: '';
$rsd_forcible_bent = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_forcible_bent: '';
$rsd_straddle_injury = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_straddle_injury: '';
$rsd_bicyle_regularly = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_bicyle_regularly: '';
$rsd_cigarettes_regularly = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_cigarettes_regularly: '';
$rsd_currnetly_smoke = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_currnetly_smoke: '';
$rsd_alcohol_driking = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_alcohol_driking: '';
$rsd_spinal_cord = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_spinal_cord: '';
$rsd_removed_cancer = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_removed_cancer: '';
$rsd_prostate_cancer = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_prostate_cancer: '';
$rsd_prostatic_growth = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_prostatic_growth: '';
$rsd_children = ($physio_erectile_edit) ? $physio_erectile_edit->rsd_children: '';
$pmh_diabetes = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_diabetes: '';
$pmh_control_sugar = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_control_sugar: '';
$pmh_blood_pressure = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_blood_pressure: '';
$pmh_blood_cholesterol_level = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_blood_cholesterol_level: '';
$pmh_heart_diseas = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_heart_diseas: '';
$pmh_stroke = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_stroke: '';
$pmh_hardening_arteries = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_hardening_arteries: '';
$pmh_drepressions = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_drepressions: '';
$pmh_medical_illness = ($physio_erectile_edit) ? $physio_erectile_edit->pmh_medical_illness: '';
$past_surgery = ($physio_erectile_edit) ? $physio_erectile_edit->past_surgery: '';
$list_medications = ($physio_erectile_edit) ? $physio_erectile_edit->list_medications: '';
$take_aspiring = ($physio_erectile_edit) ? $physio_erectile_edit->take_aspiring: '';
$allergic = ($physio_erectile_edit) ? $physio_erectile_edit->allergic: '';
$fh_blood_pressure_ind = ($physio_erectile_edit) ? $physio_erectile_edit->fh_blood_pressure_ind: '';
$fh_heart_diseae_ind = ($physio_erectile_edit) ? $physio_erectile_edit->fh_heart_diseae_ind: '';
$fh_peyronie_disease_ind = ($physio_erectile_edit) ? $physio_erectile_edit->fh_peyronie_disease_ind: '';
$daibets_ind = ($physio_erectile_edit) ? $physio_erectile_edit->daibets_ind: '';
$prostate_cancer_ind = ($physio_erectile_edit) ? $physio_erectile_edit->prostate_cancer_ind: '';
$cancer_ind = ($physio_erectile_edit) ? $physio_erectile_edit->cancer_ind: '';
$pe_weight = ($physio_erectile_edit) ? $physio_erectile_edit->pe_weight: '';
$per_height = ($physio_erectile_edit) ? $physio_erectile_edit->per_height: '';
$race = ($physio_erectile_edit) ? $physio_erectile_edit->race: '';
$temp = ($physio_erectile_edit) ? $physio_erectile_edit->temp: '';
$pulse = ($physio_erectile_edit) ? $physio_erectile_edit->pulse: '';
$resp = ($physio_erectile_edit) ? $physio_erectile_edit->resp: '';
$phallus = ($physio_erectile_edit) ? $physio_erectile_edit->phallus: '';
$meatus = ($physio_erectile_edit) ? $physio_erectile_edit->meatus: '';
$circumcised = ($physio_erectile_edit) ? $physio_erectile_edit->circumcised: '';
$plaque = ($physio_erectile_edit) ? $physio_erectile_edit->plaque: '';
$sex_characteristics = ($physio_erectile_edit) ? $physio_erectile_edit->sex_characteristics: '';
$dupuytren_contrature = ($physio_erectile_edit) ? $physio_erectile_edit->dupuytren_contrature: '';
$left_size = ($physio_erectile_edit) ? $physio_erectile_edit->left_size: '';
$left_hydrocele = ($physio_erectile_edit) ? $physio_erectile_edit->left_hydrocele: '';
$left_hernia = ($physio_erectile_edit) ? $physio_erectile_edit->left_hernia: '';
$left_location = ($physio_erectile_edit) ? $physio_erectile_edit->left_location: '';
$left_varicocele = ($physio_erectile_edit) ? $physio_erectile_edit->left_varicocele: '';
$right_location = ($physio_erectile_edit) ? $physio_erectile_edit->right_location: '';
$right_size = ($physio_erectile_edit) ? $physio_erectile_edit->right_size: '';
$right_hydrocele = ($physio_erectile_edit) ? $physio_erectile_edit->right_hydrocele: '';
$right_varicocele = ($physio_erectile_edit) ? $physio_erectile_edit->right_varicocele: '';
$right_hernia = ($physio_erectile_edit) ? $physio_erectile_edit->right_hernia: '';
$prostate = ($physio_erectile_edit) ? $physio_erectile_edit->prostate: '';
$pulses_id = ($physio_erectile_edit) ? $physio_erectile_edit->pulses_id: '';
$carotid_bruit = ($physio_erectile_edit) ? $physio_erectile_edit->carotid_bruit: '';
$blt_testosterone = ($physio_erectile_edit) ? $physio_erectile_edit->blt_testosterone: '';
$blt_tsh = ($physio_erectile_edit) ? $physio_erectile_edit->blt_tsh: '';
$blt_prolactin = ($physio_erectile_edit) ? $physio_erectile_edit->blt_prolactin: '';
$blt_hba1c = ($physio_erectile_edit) ? $physio_erectile_edit->blt_hba1c: '';
$blt_bsh_lh = ($physio_erectile_edit) ? $physio_erectile_edit->blt_bsh_lh: '';
$blt_psa = ($physio_erectile_edit) ? $physio_erectile_edit->blt_psa: '';
$blt_others = ($physio_erectile_edit) ? $physio_erectile_edit->blt_others: '';
$urine_test_exam = ($physio_erectile_edit) ? $physio_erectile_edit->urine_test_exam: '';
$usg_penile_vasculature = ($physio_erectile_edit) ? $physio_erectile_edit->usg_penile_vasculature: '';
$usg_others = ($physio_erectile_edit) ? $physio_erectile_edit->usg_others: '';
$x_ray_mri = ($physio_erectile_edit) ? $physio_erectile_edit->x_ray_mri: '';
$mp_dx = ($physio_erectile_edit) ? $physio_erectile_edit->mp_dx: '';
$mp_treatment = ($physio_erectile_edit) ? $physio_erectile_edit->mp_treatment: '';
$mp_number_of_sessions = ($physio_erectile_edit) ? $physio_erectile_edit->mp_number_of_sessions: '';
$advice = ($physio_erectile_edit) ? $physio_erectile_edit->advice: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';
// $psf_sexually_stimulated = ($physio_erectile_edit) ? $physio_erectile_edit->psf_sexually_stimulated: '';

@endphp

<div class="row bg-white mb-3 align-items-center">
    <div class="col-md-12 col-lg-12 col-sm-12 p-0" >
       <div class="card">
           <div class="card-body p-2">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="approximate_duration" name="problem_duration" placeholder=" ENTER APPROXIMATE DURATION OF PROBLEM IN YEARS" value="{{$problem_duration}}">
                      </div>
                </div>

                <div class="col-md-6">
                    <div class="input-group ml-3">
                        <label for="" class="col-for-label">ONSET OF THE PROBLEM WAS :</label>
                        <div class="form-group ml-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input onset_chk1" type="radio" name="onset_problem" id="p_was_inlineRadio1" value="1" {{ $onset_problem == '1' ? 'checked' : ''}}>
                                <label class="form-check-label" for="p_was_inlineRadio1">Gradual </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input onset_chk2" type="radio" name="onset_problem" id="p_was_inlineRadio2" value="2" {{ $onset_problem == '2' ? 'checked' : ''}}>
                                <label class="form-check-label" for="p_was_inlineRadio2">Sudden</label>
                              </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 doc_wise_hde">
                    <div class="input-group justify-content-end">
                        <label for="" class="col-for-label">If sudden, was it related in onset to: </label>
                        <div class="form-group ml-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="onset_sudden" id="onset_inlineRadio3" value="1" {{ $related_onset == '1' ? 'checked' : ''}}>
                                <label class="form-check-label" for="onset_inlineRadio3">Surgery  </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="onset_sudden" id="onset_inlineRadio4" value="2" {{ $related_onset == '2' ? 'checked' : ''}}>
                                <label class="form-check-label" for="onset_inlineRadio4">New medication  </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="onset_sudden" id="onset_inlineRadio5" value="3" {{ $related_onset == '3' ? 'checked' : ''}}>
                                <label class="form-check-label" for="onset_inlineRadio5">Life event </label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="onset_sudden" id="onset_inlineRadio6" value="4" {{ $related_onset == '4' ? 'checked' : ''}}>
                                <label class="form-check-label" for="onset_inlineRadio6">Penile injury  </label>
                              </div>
                        </div>
                    </div>
                </div>






            </div>
           </div>
       </div>
    </div>

</div>
<div class="row border bg-white">
    <div class="col-md-12 col-lg-3 col-sm-12 p-0 border-left">
        <div class="card mt-0 bg-none">
            <div class="card-header">
                <span id="favourit_list_title" data-append-to="">Favourite List</span>
                <span class="loading-img"></span>
            </div>
            <div class="card-body" style="max-height: 500px;">
                <div class="form-group mt-2">
                    <input type="search" class="form-control form-control-sm" id="" name=""
                        placeholder="Search Favourite Item">
                </div>
                <table class="table m-0">
                    <tbody id="pres-favourit-list" style="word-break: break-all;">
                        @include('admin.components.pres_favourit_list2')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-9 col-sm-12 p-0 border-left shadow-sm">
        <div class="card my-0 border-0">
            <div class="card-header bg-navy">Prescription
                <a href="{{ route('pacs.show', 1) }}" target="_blank"
                    class="btn btn-outline-warning btn-sm bg-none cursor-pointer float-right mx-1"><i
                        class="fa fa-laptop-medical"></i> PACS</a>
                <span id="btn_emr" class="btn btn-outline-warning btn-sm bg-none cursor-pointer float-right mx-1"><i
                        class="fa fa-laptop-medical"></i> EMR</span>
                <div class="btn-group float-right mr-1 btn_template">
                    <span type="button" class="btn btn-outline-primary btn-sm bg-none cursor-pointer dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
                        <i class="fa fa-file-prescription"></i> Templates
                    </span>
                    <div class="dropdown-menu dropdown-menu-right justify-content-center" id="template-container">
                        <div class="d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light">

                <div class="row">
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pl-3" >
                        <div class="form-group">
                            <label for="cmb_continue_medicine" class="col-form-label col-form-label-sm">Continue &
                                Chronic Medicine</label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-med" id="continue_med_con" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($continue_med_arr))
                                        @foreach ($continue_med_arr as $continue_med)
                                            <tr>
                                                @if ($continue_med->chronic_ind == 1)
                                                    <td>
                                                        <input onclick="prescriptionFunc.updateContinueChronic(this)"
                                                            data-action="{{ route('update_continue_chronic') }}"
                                                            data-type="CHR"
                                                            value="{{ $continue_med->prescription_med_no_pk }}"
                                                            type="checkbox" checked="checked">
                                                    </td>
                                                    <td class="text-danger" title="Chronic Medicine">
                                                        {{ $continue_med->item_name }}</td>
                                                @else
                                                    <td>
                                                        <input onclick="prescriptionFunc.updateContinueChronic(this)"
                                                            data-action="{{ route('update_continue_chronic') }}"
                                                            data-type="CON"
                                                            value="{{ $continue_med->prescription_med_no_pk }}"
                                                            type="checkbox" checked="checked">
                                                    </td>
                                                    <td title="Continue Medicine">{{ $continue_med->item_name }}</td>
                                                @endif
                                                <td>{{ $continue_med->dosage }}</td>
                                                <td>{{ $continue_med->duration }} {{ $continue_med->duration_mu }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Pre
                                Investigation / Procedure</label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-lab-rad" id="path_con"  >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($path_rad_invest['LAB']))
                                            @foreach ($path_rad_invest['LAB'] as $path_row)
                                                @php
                                                    $invest = explode('_', $path_row);
                                                @endphp
                                                @if ($invest[1] != '')
                                                    <tr>

                                                        <td class="text-primary"><a
                                                                href="{{ route('path.bc-report-pdf', $invest[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $invest[0] }}</a></td>
                                                    @else
                                                        <td> LAB - {{ $invest[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if (!empty($path_rad_invest['RAD']))
                                            @foreach ($path_rad_invest['RAD'] as $rad_row)
                                                @php
                                                    $invest = explode('_', $rad_row);
                                                @endphp
                                                @if ($invest[1] != '')
                                                    <tr>

                                                        <td class="text-primary"><a
                                                                href="{{ route('radiology.rad-report-pdf', $invest[1]) }}"
                                                                class="text-decoration-none" target="_blank">RAD -
                                                                {{ $invest[0] }}</a></td>
                                                    @else
                                                        <td>RAD - {{ $invest[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 ">
                        <div class="form-group">
                            <label for="cmb_pathology" class="col-form-label col-form-label-sm">Pre
                                Electro Therapy  / Therapeutic Excercise</label>
                            <div class="bg-white p-1">

                                <table class="w-100 details_header data-table-ptet-ptte " id="path_con"  >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($ptet_ptte_item['PTET']))
                                            @foreach ($ptet_ptte_item['PTET'] as $ptet_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $ptet_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('path.bc-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                            </td>
                                                    @else
                                                        <td> PTET - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if (!empty($ptet_ptte_item['ACUP']))
                                            @foreach ($ptet_ptte_item['ACUP'] as $acup_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $acup_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('path.bc-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">LAB -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                            </td>
                                                    @else
                                                        <td> ACUP - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if (!empty($ptet_ptte_item['PTTE']))
                                            @foreach ($ptet_ptte_item['PTTE'] as $rad_row)
                                                @php
                                                    $ptet_ptte_exp = explode('_', $rad_row);
                                                @endphp
                                                @if ($ptet_ptte_exp[1] != '')
                                                    <tr>

                                                        <td class="text-primary">
                                                            {{-- <a href="{{ route('radiology.rad-report-pdf', $ptet_ptte_exp[1]) }}"
                                                                class="text-decoration-none" target="_blank">RAD -
                                                                {{ $ptet_ptte_exp[0] }}</a> --}}
                                                            </td>
                                                    @else
                                                        <td>PTTE - {{ $ptet_ptte_exp[0] }} </td>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-3 col-sm-12 p-1 pr-3">
                        <div class="form-group">
                            <label for="cmb_radiology" class="col-form-label col-form-label-sm">Pre Prescription
                            </label>
                            <div class="bg-white p-1">
                                <table class="w-100 details_header data-table-pre-prescription" id="path_con"  >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($pat_pres_list))
                                            @foreach ($pat_pres_list as $pat_pres_uid => $pat_pres_date_app)
                                                <tr>
                                                    <?php
                                                    $date_app = explode('_', $pat_pres_date_app);
                                                    ?>
                                                    <td>

                                                        <strong @if ($date_app[3] == 1) title="Dental Prescription" @elseif ($date_app[4] == 1) title="Eye Prescription" @endif>{{ $pat_pres_uid }}
                                                            @if ($date_app[3] == 1)
                                                                <i class="fas fa-tooth"></i> @endif @if ($date_app[4] == 1)
                                                                    <i class="far fa-eye"></i>
                                                                @endif
                                                        </strong>
                                                        <div>
                                                            {{ date('d/M/Y H:i', strtotime($date_app[0])) }}
                                                        </div>
                                                    </td>
                                                    <td>

                                                        <span
                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                            data-presc="" data-presc-type="pre"
                                                            data-dtls-action="{{ route('get-prescription-dtls2', $pat_pres_uid) }}"
                                                            data-action="{{ route('get-prescription-mst2', [$date_app[1], $date_app[2], $pat_pres_uid]) }}"
                                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                            title="Edit Prescription">
                                                            <i class="fa fa-prescription"></i>
                                                        </span>

                                                        <a href="{{ route('opd_prescription_print_pdf2', $pat_pres_uid) }}"
                                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                            target="_blank" data-id="{{ $pat_pres_uid }}"
                                                            title="Print Prescription"><i
                                                                class="fa fa-file-pdf"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @if (!empty($su_info) && $su_info->eye_ind == 1)
                @include('admin.prescription.prescription_eye2')
            @elseif(!empty($su_info) && $su_info->dental_ind == 1)
                @include('admin.prescription.prescription_dental2')
            @else
                {{-- @include('admin.prescription.prescription_investigation_element2')
                @include('admin.prescription.prescription_general2') --}}
                <div class="card border-0">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#quickrx" role="tab" aria-controls="home" aria-selected="true">
                                    PRESENT SEXUAL FUNCTION
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#spectacles" role="tab" aria-controls="home" aria-selected="true">
                                    PREVIOUS EVALUATION
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#ocularexamination" role="tab" aria-controls="home" aria-selected="true">
                                    PREVIOUS TREATMENT
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#symptoms" role="tab" aria-controls="home" aria-selected="true">
                                    RF FOR ERECTILE DYSFUNCTION
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#past_medical_history" role="tab" aria-controls="home" aria-selected="true">
                                    PAST MEDICAL HISTORY
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#family_history" role="tab" aria-controls="home" aria-selected="true">
                                    FAMILY HISTORY
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#physical_examination" role="tab" aria-controls="home" aria-selected="true">
                                    PHYSICAL EXAMINATION
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#physio_investigation" role="tab" aria-controls="home" aria-selected="true">
                                    INVESTIGATION
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#management_plan" role="tab" aria-controls="home" aria-selected="true">
                                    MANAGEMENT PLAN
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#ipss_questionnaire" role="tab" aria-controls="home" aria-selected="true">
                                    IPSS QUESTIONNAIRE
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#iief_questionnaire" role="tab" aria-controls="home" aria-selected="true">
                                    IIEF-5 QUESTIONNAIRE
                                </a>
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#therapy_details" role="tab" aria-controls="home" aria-selected="true">
                                    THERAPY DETAILS
                                </a>
                            </div>
                        </nav>
                    </div>

                    <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent">
                        <div class="tab-pane fade show active border-bottom" id="quickrx" role="tabpanel" aria-labelledby="quickrx-tab">
                                            @include('admin.prescription.prescription_investigation_element2')
                                            {{-- <div class="input-group mb-3 group-end">
                                                <a class="btn btn-success btnNext">Next</a>
                                              </div> --}}
                                            {{-- @include('admin.prescription.prescription_general2') --}}
                        </div>
                        <div class="tab-pane fade border-bottom" id="spectacles" role="tabpanel" aria-labelledby="spectacles-tab">
                            @include('admin.prescription.prescription_previous_evaluation')
                            {{-- <div class="input-group mb-3 group-end">
                                <a class="btn btn-danger btnPrevious">Previous</a>
                                <a class="btn btn-success btnNext">Next</a>
                              </div> --}}
                        </div>
                        <div class="tab-pane fade border-bottom" id="ocularexamination" role="tabpanel" aria-labelledby="ocularexamination-tab">
                            @include('admin.prescription.prescription_eye_ocularexamination2')
                        </div>
                        <div class="tab-pane fade border-bottom" id="symptoms" role="tabpanel" aria-labelledby="symptoms-tab">
                            @include('admin.prescription.prescription_symptoms')
                        </div>
                        <div class="tab-pane fade border-bottom" id="past_medical_history" role="tabpanel" aria-labelledby="past_medical_history-tab">
                            @include('admin.prescription.prescription_past_medical_history')
                        </div>
                        <div class="tab-pane fade border-bottom" id="family_history" role="tabpanel" aria-labelledby="family_history-tab">
                            @include('admin.prescription.prescription_family_history')
                        </div>
                        <div class="tab-pane fade border-bottom" id="physical_examination" role="tabpanel" aria-labelledby="physical_examination-tab">
                            @include('admin.prescription.prescription_physical_examination')
                        </div>
                        <div class="tab-pane fade border-bottom" id="physio_investigation" role="tabpanel" aria-labelledby="physio_investigation-tab">
                            @include('admin.prescription.prescription_physio_investigation')
                        </div>
                        <div class="tab-pane fade border-bottom" id="management_plan" role="tabpanel" aria-labelledby="management_plan-tab">
                            @include('admin.prescription.prescription_management_plan')
                        </div>
                        @if(isset($prescription_id))
                        <div class="tab-pane fade border-bottom" id="ipss_questionnaire" role="tabpanel" aria-labelledby="ipss_questionnaire-tab">
                            @include('admin.prescription.internation_prostate_symptom_score_edit_form')
                        </div>
                        <div class="tab-pane fade border-bottom" id="iief_questionnaire" role="tabpanel" aria-labelledby="iief_questionnaire-tab">
                            @include('admin.prescription.IIEF-5_questionnaire_edit')
                        </div>
                        @else

                        <div class="tab-pane fade border-bottom" id="ipss_questionnaire" role="tabpanel" aria-labelledby="ipss_questionnaire-tab">
                            @include('admin.prescription.international_prostate_symptom_score_form')
                        </div>
                        <div class="tab-pane fade border-bottom" id="iief_questionnaire" role="tabpanel" aria-labelledby="iief_questionnaire-tab">
                            @include('admin.prescription.IIEF-5_questionnaire_form')
                        </div>
                         @endif
                         <div class="tab-pane fade border-bottom" id="therapy_details" role="tabpanel" aria-labelledby="therapy_details-tab">
                            @include('admin.prescription.therapy_details')
                        </div>


                    </div>
                </div>
            @endif
            <div class="col-md-12 p-3">
                <div class="form-group">
                    @php
                        $prescription_id = '';
                        $riderect_action = route('prescription.create-doctor-wise');
                        $response_url = route('opd_prescription_print2', $prescription_id);

                        // $riderect_action = route('prescription.create');


                    @endphp
                    <span class="btn btn-md btn-success" data-response_action="{{ $response_url }}"
                        onclick="savePrescription(this);"
                        data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i
                            class="fa fa-save"></i> Save</span>
                            <span class="btn btn-md btn-success  btnPrevious">Previous</span>
                            <span class="btn btn-md btn-success btnNext">Next</span>

                            {{-- <span class="btn btn-md btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url  }}')"
                        data-riderect_action="{{ $riderect_action }}" title="Click here to save Prescription"><i
                            class="fa fa-save"></i> Save</span> --}}

                    {{-- <span class="btn btn-md btn-success" data-action="{{ route('pres-opd-save-update-template') }}"
                        data-response_action="{{ $response_url }}"
                        onclick="prescriptionFunc.savePrescriptionAsTemplate(this); prescriptionFunc.savePrescription(this);"
                        data-riderect_action="{{ $riderect_action }}"
                        title="Click here to save this Prescription as Tempalte"><i class="fa fa-save"></i> Save As
                        Template</span> --}}

                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    <a href="" class="btn btn-danger btn-md" rel="tab"
                        title="Click here to go back to Dashboard">Exit</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
  $('.btnNext').click(function() {
    $('.nav-tabs .active').next('a').trigger('click');
  });

  $('.btnPrevious').click(function() {
    $('.nav-tabs .active').prev('a').trigger('click');
  });




 function savePrescription(thisElement) {
        var patient_id = $("#hdn_patient_id").val();

        if (patient_id == "") {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html("You did not select any Patient");
            return;
        }

        var action = $(thisElement).attr("data-response_action");
        var riderect_action = $("#hdn_current_url").val();
        var items = $('input[name="item_name[]"]');
        var appointment_date = $("#hdn_appointment_date").val();
        var hdn_eye_ind = $("#hdn_eye_ind").val();
        btnSaveUpdate($(thisElement), '', '', '', '', dynamicFunc.afterSaveLoadPage, riderect_action);
    }
      if ($("input.onset_chk2").is(':checked'))
      {
        $('.doc_wise_hde').show();


      }
      else
      {
        $('.doc_wise_hde').hide();


      }
    $("input.onset_chk2").on('click',function()
    {
        $('.doc_wise_hde').show();

    });


    $("input.onset_chk1").on('click',function()
    {
        $('.doc_wise_hde').hide();

    });
    function daysdifference(firstDate, secondDate) {
        var startDay = new Date(firstDate);
        var endDay = new Date(secondDate);
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
        return Math.round(Math.abs(days));
    }


    $('.data-table-med').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-lab-rad').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-ptet-ptte').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});
    $('.data-table-pre-prescription').DataTable({
		"lengthMenu": [
		[5],
		[5]
		],
		"ordering": false,
		"bPaginate": true,
		"bLengthChange": false,
		"bAutoWidth": false
	});

    function saveExamination() {
        var pre = '';
        $("#examination").html("");
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#examination").append(pre);

        $("#test345 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";

            if (item_name != undefined) {
                console.log(item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {
                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);
            }


            $("#examination").append(lookup_data);
        });
        pre = '</ul>';
        $("#examination").append(pre);
    }

    function saveMenstrual() {
        var pre = '';
        $("#history").html('');
        pre += ' <ul class="list-unstyled mb-0 pt-1">';
        $("#history").append(pre);
        $("#test123 div").each(function() {

            var item_name = $(this).find(".item_name").val();
            var item_dtl_val = $(this).find(".item_dtl_val").val();
            var lookup_id = $(this).find(".lookup_id").val();
            var lookup_code = $(this).find(".lookup_code").val();
            var lookupdata_code = $(this).find(".lookupdata_code").val();
            //var lookup_data = "";


            if (item_name != undefined) {
                console.log(item_name, lookup_id, lookup_code, lookupdata_code);
                if (pre != lookupdata_code) {
                    var lookup_data = "<li id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><i class='fa fa-angle-double-right'></i> " +
                        lookupdata_code +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;<ul>" +
                        item_name + " - " + item_dtl_val +
                        "<input type='hidden' name='item_dtl_val[]' value='" + item_dtl_val +
                        "' readonly='readonly'></ul>";
                    pre = lookupdata_code;
                } else {
                    var lookup_data = "<ul id='item-" + lookupdata_code +
                        "'><input type='hidden' class='left-element' name='item_id[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_name[]' value='" +
                        item_name +
                        "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                        lookup_id +
                        "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                        lookup_code +
                        "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                        lookupdata_code +
                        "' readonly='readonly'><input type='hidden' name='item_dtl_val[]' value='" +
                        item_dtl_val + "' readonly='readonly'><i class=''></i> " +
                        item_name +
                        " - " + item_dtl_val +
                        "<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;&nbsp;</ul></li>";
                }
                //console.log(lookup_data);


            }



            $("#history").append(lookup_data);




        });
        pre += '</ul>';
        $("#history").append(pre);


    }


    // // $(document).ready(function() {
    //     // $(document).on('keyup focus blur', '#next_followup', function(event) {
    //     //     // focus blur

    //     //     var x = event.which || event.keyCode;

    //     //     if (x != '9') {
    //     //         $('.date_picker_app').datepicker({
    //     //             format: 'dd/mm/yyyy',
    //     //             autoclose: true,
    //     //             clearBtn: true,
    //     //             // todayHighlight: true,
    //     //         })
    //     //     }
    //     // })

    //     $('.date_picker_app').datepicker({
    //         format: 'mm-dd-yyyy',
    //         autoclose: true,
    //         clearBtn: true,
    //         todayHighlight: true,
    //     }).on {

    //         // if (x != '9') {

    //             var selected_date = new Date(e.format().toString());
    //             var today = new Date();

    //             var todayDate = today.getDate() + "/" +  (today.getMonth() + 1)+ "/" + today.getFullYear();
    //             var selected = selected_date.getDate() + "/" +  (selected_date.getMonth() + 1)+ "/" +
    //                 selected_date.getFullYear();

    //             var days = daysdifference(selected.toString(), todayDate.toString());
    //             $("#followup_after").val(days);
    //             $("#followup_after_mu").val("DAY");
    //         // }

    //     });

    // teeth_autocomplete.init();

    // // });


    $(document).ready(function() {

        $('.date_picker_app').datepicker({
            // todayHighlight: true,
            format: 'dd-mm-yyyy',
            autoclose: true,
        }).on('changeDate', function(e) {
            var selected_date = new Date(e.date.toString());

            var today = new Date();

            var todayDate = (today.getMonth() + 1) + "/" + today.getDate() + "/" + today.getFullYear();
            var selected = (selected_date.getMonth() + 1) + "/" + selected_date.getDate() + "/" +
                selected_date.getFullYear();
                console.log(selected);
            // var diff = new Date(selected - todayDate);
            // console.log(selected,todayDate,diff);
            // var days = diff/1000/60/60/24;
            const date1 = new Date(todayDate);
            const date2 = new Date(selected);
            const diffTime = Math.abs(date2 - date1);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            console.log(diffTime + " milliseconds");
            console.log(diffDays + " days");

            $("#followup_after").val(diffDays);
            $("#followup_after_mu").val("DAY");
        });

        teeth_autocomplete.init();

    });



    openItemAutocompleteWithList($('#investigation_item'), 'RAD,LAB', "#investigation", "121", "INVFIND");

    openLookupAutocomplete("#cheif_complaint", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHIEFCOM", "#chfcom");

    openLookupAutocomplete("#provisional_diag", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "PROVDIAG", "#prov_diag");

    openLookupAutocomplete("#history_of_objective", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CLINICHIST", "#ho");

    openLookupAutocomplete("#desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE",
        "#desease_con");

    openLookupAutocomplete("#icd", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISEASE", "#icd_con");

    openLookupAutocomplete("#chronic_desease", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "CHRDISEASE", "#chronic_des");
    openLookupAutocomplete("#advice", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "ADVICE", "#adv");

    openLookupAutocomplete("#disposal_item", "{{ route('lookup-pres-data-autocomplete') }}", "PRES", "DISPOSAL",
        "#disposal");

    openLookupAutocomplete("#investigation_findings", "{{ route('lookup-pres-data-autocomplete') }}", "PRES",
        "INVFIND", "#investigation_find_con");

    openItemAutocompleteWithList($("#procedure_item"), 'SERVICE,SUR', "#proc", "122", "PROCDURE");

    openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0',);
    openItemAutocompletePTET($("#et_item_name_1"), 'PTET', "#hdn_item_id_1", "#hdn_item_name_1","202", "PTET"); // 3 = SERVICE ITEM TYPE
    openItemAutocompletePTET($("#acup_item_name_1"), 'ACUP', "#hdn_item_id_1", "#hdn_item_name_1","242", "ACUP"); // 3 = SERVICE ITEM TYPE
    openItemAutocompletePTTE($("#te_item_name_1"), 'PTTE', "#hdn_item_id_1", "#hdn_item_name_1", "203" ,"PTTE"); // 3 = SERVICE ITEM TYPE
</script>
