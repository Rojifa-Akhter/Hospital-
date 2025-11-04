<style>
    .tablink {
        background-color: #555;
        color: white;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        font-size: 17px;
        width: 25%;
    }

    @media (max-width:767px) {
        .tablink {
            width: 50%;
        }
    }

    .tablink:hover {
        background-color: #777;
    }
    .tabcontent {
        display: none;
        padding-top: 10px;
        padding-bottom: 10px;
        height: 100%;
    }
</style>

<div class="row">
    <div class="col-12">
        <button class="tablink" onclick="openPage('tab2', this, 'gray')" id="defaultOpen">History of illness</button>
        <button class="tablink" onclick="openPage('tab3', this, 'gray')">General Examination</button>
        <button class="tablink" onclick="openPage('tab4', this, 'gray')">Systemic examination</button>
        <button class="tablink" onclick="openPage('tab5', this, 'gray')">Others</button>
    </div>

    <div class="col-12">
        <form action="{{ route('v2.ipd.patient-history-store') }}" method="post" id="pat_history">
            @csrf
            <input type="hidden" name="admission_id" value="{{ $pat_info->admission_no_pk }}">
            <input type="hidden" name="patient_history" value="{{ !empty($pat_history->patient_history_no_pk) ? $pat_history->patient_history_no_pk : '' }}">
    
            <div id="tab2" class="tabcontent">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row p-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h4>History of present illness<span style="color:red">*</span></h4>
                                    <textarea name="present_illness" id="present_illness" class="form-control" cols="30" rows="3" required>{{ !empty($pat_history->history_of_present_illness) ? $pat_history->history_of_present_illness : '' }}</textarea>
                                </div>
                            </div>
    
                            <div class="col-md-12">
                                <h4>History of past illness</h4>
                                <textarea name="history_of_past_illness" id="history_of_past_illness" class="form-control" cols="30" rows="3">{{ !empty($pat_history->history_of_past_illness) ? $pat_history->history_of_past_illness : '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="family_history"> Family History :</label>
                                    <input type="text" class="form-control" id="family_history" name="family_history" value="{{ !empty($pat_history->past_fam_history) ? $pat_history->past_fam_history : '' }}">
                                </div>
    
                                <div class="form-group">
                                    <label for="drug_history"> Drug History :</label>
                                    <input type="text" class="form-control" id="drug_history" name="drug_history" value="{{ !empty($pat_history->past_fam_drug_history) ? $pat_history->past_fam_drug_history : '' }}">
                                </div>
    
                                <div class="form-group">
                                    <label for="personal_history"> Personal History :</label>
                                    <input type="text" class="form-control" id="personal_history" name="personal_history" value="{{ !empty($pat_history->past_fam_personal_histotry) ? $pat_history->past_fam_personal_histotry : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="contraceptive_history"> Contraceptive History :</label>
                                    <input type="text" class="form-control" id="contraceptive_history" name="contraceptive_history" value="{{ !empty($pat_history->contrac_previous_history) ? $pat_history->contrac_previous_history : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="socio_economic_history"> Socio-economic History :</label>
                                    <input type="text" class="form-control" id="socio_economic_history" name="socio_economic_history" value="{{ !empty($pat_history->socio_econmic_history) ? $pat_history->socio_econmic_history : '' }}">
                                </div>
    
                                <div class="form-group">
                                    <label for=""> Menstrual history :</label>
                                    <ul>
                                        <li> Menarche <input type="text" name="menstrual_menarche" id="menstrual_menarche" class="form-control" value="{{ !empty($pat_history->menstrual_history_menarche) ? $pat_history->menstrual_history_menarche : '' }}"> </li>
                                        <li>MC/ MF <input type="text" name="mc_mf_menarche" id="mc_mf_menarche" class="form-control" value="{{ !empty($pat_history->menstrual_history_mc_mf) ? $pat_history->menstrual_history_mc_mf : '' }}"> </li>
                                        <li>Married For <input type="text" name="married_menarche" id="married_menarche" class="form-control" value="{{ !empty($pat_history->mensrual_history_married) ? $pat_history->mensrual_history_married : '' }}"> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allergic_history"> Allergic History :</label>
                                    <input type="text" class="form-control" id="allergic_history"  name="allergic_history" value="{{ !empty($pat_history->allergic_history) ? $pat_history->allergic_history : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="immunization_history"> Immunization History :</label>
                                    <input type="text" class="form-control" id="immunization_history"  name="immunization_history" value="{{ !empty($pat_history->immunaizations_history) ? $pat_history->immunaizations_history : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for=""> Obstetrics History :</label>
                                    <ul>
                                        <li> Para <input type="text" name="para_obstetrics" id="para_obstetrics"  class="form-control" value="{{ !empty($pat_history->obs_hist_para) ? $pat_history->obs_hist_para : '' }}">
                                        </li>
                                        <li>LMP <input type="text" name="lmp_obstetrics" id="lmp_obstetrics" class="form-control" value="{{ !empty($pat_history->obs_hist_lmp) ? $pat_history->obs_hist_lmp : '' }}">
                                        </li>
                                        <li>ALC <input type="text" name="alc_obstetrics" id="alc_obstetrics" class="form-control" value="{{ !empty($pat_history->obs_hist_alc) ? $pat_history->obs_hist_alc : '' }}">
                                        </li>
                                        <li> Gravida <input type="text" name="gravida_obstetrics" id="gravida_obstetrics" class="form-control" value="{{ !empty($pat_history->obs_hist_gravida) ? $pat_history->obs_hist_gravida : '' }}">
                                        </li>
                                        <li>EDD <input type="text" name="edd_obstetrics" id="edd_obstetrics" class="form-control" value="{{ !empty($pat_history->obs_hist_edd) ? $pat_history->obs_hist_edd : '' }}">
                                        </li>
                                        <li>Mode of Previous Delivery<input type="text" name="previous_delivery_obstetrics" id="previous_delivery_obstetrics" class="form-control" value="{{ !empty($pat_history->obs_hist_mode_prev_delivery) ? $pat_history->obs_hist_mode_prev_delivery : '' }}"></li>
                                    </ul>
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div id="tab3" class="tabcontent">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row p-2">
    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="appearance"> Appearance<span style="color:red">*</span>: </label>
                                    <input type="text" class="form-control" id="appearance" name="appearance" value="{{ !empty($pat_history->gen_exm_appearance) ? $pat_history->gen_exm_appearance : '' }}" required>
                                </div>
    
                                <div class="form-group">
                                    <label for="decubitus"> Decubitus :</label>
                                    <input type="text" class="form-control" id="decubitus" name="decubitus" value="{{ !empty($pat_history->gen_exm_decuvitus) ? $pat_history->gen_exm_decuvitus : '' }}">
                                </div>
    
                                <div class="form-group">
                                    <label for="co_operation"> Co-operation :</label>
                                    <input type="text" class="form-control" id="co_operation" name="co_operation" value="{{ !empty($pat_history->gen_exm_co_operation) ? $pat_history->gen_exm_co_operation : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="body_built"> Body built :</label>
                                    <input type="text" class="form-control" id="body_built" name="body_built" value="{{ !empty($pat_history->gen_exm_body_build) ? $pat_history->gen_exm_body_build : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="nutritional_status"> Nutritional Status :</label>
                                    <input type="text" class="form-control" id="nutritional_status" name="nutritional_status" value="{{ !empty($pat_history->gen_exm_nutritional_status) ? $pat_history->gen_exm_nutritional_status : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="anemia"> Anemia :</label>
                                    <input type="text" class="form-control" id="anemia" name="anemia" value="{{ !empty($pat_history->gen_exm_anemia) ? $pat_history->gen_exm_anemia : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="jaundice"> Jaundice :</label>
                                    <input type="text" class="form-control" id="jaundice" name="jaundice" value="{{ !empty($pat_history->gen_exm_jaundice) ? $pat_history->gen_exm_jaundice : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="cyanosis"> Cyanosis :</label>
                                    <input type="text" class="form-control" id="cyanosis" name="cyanosis" value="{{ !empty($pat_history->gen_exm_cyanosis) ? $pat_history->gen_exm_cyanosis : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="Clubbing"> Clubbing :</label>
                                    <input type="text" class="form-control" id="Clubbing" name="Clubbing" value="{{ !empty($pat_history->gen_exm_clubbing) ? $pat_history->gen_exm_clubbing : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="koilonychia"> Koilonychia :</label>
                                    <input type="text" class="form-control" id="koilonychia" name="koilonychia" value="{{ !empty($pat_history->gen_exm_koilonychia) ? $pat_history->gen_exm_koilonychia : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="lung"> Lung :</label>
                                    <input type="text" class="form-control" id="lung" name="lung" value="{{ !empty($pat_history->lung) ? $pat_history->lung : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="leukonychia">Leukonychia: </label>
                                    <input type="text" class="form-control" id="leukonychia" name="leukonychia" value="{{ !empty($pat_history->gen_exm_leukonychia) ? $pat_history->gen_exm_leukonychia : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="oedema"> Oedema :</label>
                                    <input type="text" class="form-control" id="oedema" name="oedema" value="{{ !empty($pat_history->gen_exm_oedema) ? $pat_history->gen_exm_oedema : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="lymph_node"> Lymph Node :</label>
                                    <input type="text" class="form-control" id="lymph_node" name="lymph_node"  value="{{ !empty($pat_history->gen_exm_lymph_node) ? $pat_history->gen_exm_lymph_node : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="dehydration"> Dehydration :</label>
                                    <input type="text" class="form-control" id="dehydration" name="dehydration"  value="{{ !empty($pat_history->gen_exm_dehydration) ? $pat_history->gen_exm_dehydration : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="thyroid_gland"> Thyroid Gland :</label>
                                    <input type="text" class="form-control" id="thyroid_gland"  name="thyroid_gland" value="{{ !empty($pat_history->gen_exm_thyroid_gland) ? $pat_history->gen_exm_thyroid_gland : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="pulse">Pulse :</label>
                                    <input type="number" step="0.01" class="form-control" id="pulse" name="pulse"  value="{{ !empty($pat_history->gen_exm_pulse) ? $pat_history->gen_exm_pulse : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="bp"> BP :</label>
                                    <input type="number" step="0.01" class="form-control" id="bp" name="bp" value="{{ !empty($pat_history->gen_exm_bp) ? $pat_history->gen_exm_bp : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="temperature"> Temperature :</label>
                                    <input type="number" step="0.01" class="form-control" id="temperature" name="temperature" value="{{ !empty($pat_history->gen_exm_temperature) ? $pat_history->gen_exm_temperature : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="resp_rate"> Resp. Rate :</label>
                                    <input type="number" step="0.01" class="form-control" id="resp_rate" name="resp_rate"  value="{{ !empty($pat_history->gen_exm_resp_rate) ? $pat_history->gen_exm_resp_rate : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="heart"> Heart :</label>
                                    <input type="number" step="0.01" class="form-control" id="heart" name="heart"  value="{{ !empty($pat_history->heart) ? $pat_history->heart : '' }}">
                                </div>
                                <div class="form-group">
                                    <label for="liver"> Liver :</label>
                                    <input type="text" class="form-control" id="liver" name="liver"   value="{{ !empty($pat_history->liver) ? $pat_history->liver : '' }}">
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-row p-2">
                            <div class="col-md-12">
                                <label for="local_examination"> Local Examination :</label>
                                <textarea class="form-control" id="local_examination" name="local_examination">{{ !empty($pat_history->local_examination) ? $pat_history->local_examination : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div id="tab4" class="tabcontent">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row p-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cardiovascular_system"> Cardiovascular System<span style="color:red">*</span> :</label>
                                    <textarea type="text" class="form-control" id="cardiovascular_system" name="cardiovascular_system" required>{{ !empty($pat_history->cardiovascular_system) ? $pat_history->cardiovascular_system : '' }}</textarea>
                                </div>
    
                                <div class="form-group">
                                    <label for="gastrointestinal_system"> Gastrointestinal System :</label>
                                    <textarea type="text" class="form-control" id="gastrointestinal_system" name="gastrointestinal_system">{{ !empty($pat_history->gastrointestinal_system) ? $pat_history->gastrointestinal_system : '' }}</textarea>
                                </div>
    
                                <div class="form-group">
                                    <label for="respiratory_system"> Respiratory System :</label>
                                    <textarea type="text" class="form-control" id="respiratory_system" name="respiratory_system">{{ !empty($pat_history->respiratory_system) ? $pat_history->respiratory_system : '' }} </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="nervous_system"> Nervous System :</label>
                                    <textarea type="text" class="form-control" id="nervous_system" name="nervous_system">{{ !empty($pat_history->nervous_system) ? $pat_history->nervous_system : '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="musculoskeletal_system"> Musculoskeletal System :</label>
                                    <textarea type="text" class="form-control" id="musculoskeletal_system" name="musculoskeletal_system">{{ !empty($pat_history->musculoskeletal_system) ? $pat_history->musculoskeletal_system : '' }} </textarea>
                                </div>
    
                            </div>
    
    
    
    
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table style="width: 100%">
                                        <tr>
                                            <th style="padding: 5px">Per Abdominal Examination:</th>
                                            <th style="padding: 5px">Presentation</th>
                                            <th style="padding: 5px">Pelvic Examination</th>
                                            <th style="padding: 5px">Per Speculum Examination</th>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px">Inspection : <input type="text" class="form-control" name="inspection" id="inspection"  value="{{ !empty($pat_history->inspectation) ? $pat_history->inspectation : '' }}"></td>
                                            <td style="padding: 5px"> Engaged / Not Engaged <input type="text" class="form-control" name="engaged" id="engaged"  value="{{ !empty($pat_history->engaged) ? $pat_history->engaged : '' }}"></td>
                                            <td style="padding: 5px">Inspection of vulva & vagina: <input type="text" class="form-control" name="inspection_vulva_vagina" id="inspection_vulva_vagina" value="{{ !empty($pat_history->inspectation_vulva_vagina) ? $pat_history->inspectation_vulva_vagina : '' }}"></td>
                                            <td style="padding: 5px">Cervix :<input type="text" class="form-control" name="cervix" id="cervix" value="{{ !empty($pat_history->cervix) ? $pat_history->cervix : '' }}"></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px">Palpation: <input type="text"  class="form-control" name="palpation" id="palpation" value="{{ !empty($pat_history->palpation) ? $pat_history->palpation : '' }}"></td>
                                            <td style="padding: 5px">Liquor Seems to be: <input type="text" class="form-control" name="liquor_seems" id="liquor_seems" value="{{ !empty($pat_history->liquor_seems) ? $pat_history->liquor_seems : '' }}"></td>
                                            <td style="padding: 5px"></td>
                                            <td style="padding: 5px">Bimanual: <input type="text" class="form-control"  name="bimanual" id="bimanual" value="{{ !empty($pat_history->bimanual) ? $pat_history->bimanual : '' }}"> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px"> 
                                                Fundal Height: <input type="text" class="form-control" name="fundal_height" id="fundal_height" value="{{ !empty($pat_history->fundal_height) ? $pat_history->fundal_height : '' }}">
                                                Ascultation: <input type="text" class="form-control" name="ascultation" id="ascultation"  value="{{ !empty($pat_history->ascultation) ? $pat_history->ascultation : '' }}"><br>
                                                FHR: <input type="text" class="form-control" name="fhr" id="fhr"  value="{{ !empty($pat_history->fhr) ? $pat_history->fhr : '' }}"><br>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td style="padding: 5px">
                                                Uterine Size: <input type="text" class="form-control" name="uterine_size" id="uterine_size" value="{{ !empty($pat_history->uterine_size) ? $pat_history->uterine_size : '' }}">
                                                A/V or R/V: <input type="text" class="form-control" name="a_v_r_v" id="a_v_r_v" value="{{ !empty($pat_history->av) ? $pat_history->av : '' }}"><br>
                                                CET: <input type="text" class="form-control" name="cet" id="cet" value="{{ !empty($pat_history->cet) ? $pat_history->cet : '' }}"><br>
                                                Fornics: <input type="text" class="form-control" name="fornics" id="fornics" value="{{ !empty($pat_history->fornics) ? $pat_history->fornics : '' }}"><br>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div id="tab5" class="tabcontent">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="salient_feature"> Salient Feature<span style="color:red">*</span>: </label>
                                <textarea class="form-control" id="salient_feature" name="salient_feature" required>{{ !empty($pat_history->salient_feature) ? $pat_history->salient_feature : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="provisional_diagnosis"> Provisional Diagnosis: </label>
                                <textarea class="form-control" id="provisional_diagnosis" name="provisional_diagnosis" value="">{{ !empty($pat_history->provisional_diagnosis) ? $pat_history->provisional_diagnosis : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="differential_diagnosis"> Differential Diagnosis : </label>
                                <textarea class="form-control" id="differential_diagnosis" name="differential_diagnosis">{{ !empty($pat_history->differential_diagnosis) ? $pat_history->differential_diagnosis : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="investigations"> Investigations : </label>
                                <textarea class="form-control" id="investigations" name="investigations">{{ !empty($pat_history->investigations) ? $pat_history->investigations : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="confirmed_diagnosis"> Confirmed Diagnosis : </label>
                                <textarea class="form-control" id="confirmed_diagnosis" name="confirmed_diagnosis">{{ !empty($pat_history->confirmed_diagnosis) ? $pat_history->confirmed_diagnosis : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            @php
                $response_action = route('v2.ipd.nurse-note',$admission_id);
            @endphp
            {{-- <button type="button" class="btn btn-success btn-md float-right" onclick="updatePatientInfo(this, '{{ $response_action }}')">Save</button> --}}
        </form>
    </div>
</div>



<script>

    $(document).ready(function() {
        $("#pat_history").validate({
            rules:{
                present_illness:{
                    required:true,
                },
                appearance:{
                    required:true
                },
                cardiovascular_system:{
                    required:true,
                },
                salient_feature:{
                    required:true
                }
            },
            messages:{
                present_illness:{
                    required:"Present Illness Required",
                },
                appearance:{
                    required: "Appearance Required"
                },
                cardiovascular_system:{
                    required:"Cardiovascular System Required",
                },
                salient_feature:{
                    required:"Salient Feature Required"
                }
            }
        });


        $("textarea, input").attr("disabled", true);
    });

    function updatePatientInfo(thisFrom, response_action){

        var hasError = true;
        if($("#present_illness").val() == ''){
            alert('Present Illness Required');
            hasError = false;
            return false;
        }
        if($("#appearance").val() == ''){
            alert('Appearance Required');
            hasError = false;
            return false;
        }
        if($("#cardiovascular_system").val() == ''){
            alert('Cardiovascular System Required');
            hasError = false;
            return false;
        }
        if($("#salient_feature").val() == ''){
            alert('Salient Feature Required');
            hasError = false;
            return false;
        }
        if(hasError == true){
            btnSaveUpdate(thisFrom,'','','','', dynamicFunc.afterSaveLoadPage, response_action);
        }
    }

    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
        }
        document.getElementById(pageName).style.display = "block";
        elmnt.style.backgroundColor = color;
    }

    document.getElementById("defaultOpen").click();
</script>
