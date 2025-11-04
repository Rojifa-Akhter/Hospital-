
@php
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

    //bangla
    $search_array = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ':', ',', 'DAY', 'MONTH', 'WEEK', 'YEAR', 'HOUR'];
    $replace_array = ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারি', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগষ্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', ':', ',', 'দিন', 'মাস ', 'সপ্তাহ ', 'বছর', 'ঘন্টা'];

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription:: {{ @$prescription_mst->prescription_uid }}</title>
</head>

@include('admin.prescription.prescription_pdf.prescription_css')
<body onload="window.print()">
    <section>
        <table style="width: 100%;" id="pat_info">
            <thead style=" border-bottom:1px solid;">
                @include('admin.prescription.prescription_pdf.precription_header')
            </thead>

            <!-- Table Body -->
            <tbody>
                <tr class="no-break">
                    <td width="45%" valign="top" style="border-right: 1px solid;">

                        <h3 class="py-2"></h3>

                        @if(isset($left_side_arr['CHIEFCOM']))
                            <div>
                                <div><strong>Chief Complaints</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                        <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['HISTORY']))
                            <div>
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                        <li>{{ $cc_history }}</li>
                                        @if (!empty($cc_item))
                                            <ul clas="pl-15">
                                                @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                    <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        @if(isset($vitals->hypothyroidism))
                            <div>
                                <div><strong>Confirmatory Diagnosis</strong></div>
                                <ul class="mb-5 ml-20">
                                    <li>@php echo isset($vitals->hypothyroidism) ? $vitals->hypothyroidism : ''; @endphp</li>
                                </ul>
                            </div>
                        @endif


                        @if($company_details->hospital_code == 'AMCSH')
                            @if(isset($vitals))
                                <div>
                                    <div><strong>LMP (Menstrual History)</strong></div>
                                    <ul class="mb-5 ml-20">
                                        <li> @php echo isset($vitals->lmp) ? $vitals->lmp : ''; @endphp</li>
                                    </ul>
                                </div>
                            @endif
                            @if(isset($vitals))
                                <div>
                                    <div><strong>LMP (Menstrual History)</strong></div>
                                    <ul class="mb-5 ml-20">
                                        <li>@php echo isset($vitals->obs) ? $vitals->obs : ''; @endphp</li>
                                    </ul>
                                </div>
                            @endif
                        @endif

                        @if (isset($left_side_arr['HISTORY']))
                            <div>
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                        <li>{{ $cc_history }}</li>
                                        @if (!empty($cc_item))
                                            <ul clas="pl-15">
                                                @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                    <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                                @if (isset($left_side_arr['EXAMINATION']))
                                    <ul class="mb-5 ml-20">
                                        @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                            <li>{{ $cc_history }}</li>
                                            @if (!empty($cc_item))
                                                <ul clas="pl-15">
                                                    @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                        <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @elseif(isset($left_side_arr['EXAMINATION']))
                            <div>
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                        <li>{{ $cc_history }}</li>
                                        @if (!empty($cc_item))
                                            <ul clas="pl-15">
                                                @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                    <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        @if(isset($left_side_arr['CLINICHIST']))
                            <div>
                                <div><strong>Clinical History</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                        <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($vitals))
                            <div style="margin-bottom: 10px">
                                <div><strong>Vitals</strong></div>
                                <div>
                                    @php
                                        echo isset($vitals->pulse_val) ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . '</strong>' . ' b/m ' : '';
                                        echo isset($vitals->bp_val_sys) ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . '</strong>' : '';
                                        echo isset($vitals->bp_val_dia) ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg ' : '';
                                        echo isset($vitals->temp_val) ? ' , Temp :' . '<strong> ' . $vitals->temp_val . '</strong>' . ' °F ' : '';
                                    @endphp
                                </div>

                                <div>
                                    @php
                                        echo isset($vitals->height_val) ? ' , Height :' . ' <strong> ' . $vitals->height_val . '</strong>' . ' cm ' : '';
                                        echo isset($vitals->weight_val) ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . '</strong>' . ' kg ' : '';
                                        echo isset($vitals->bmi) && $vitals->bmi != 0 ? ' , BMI :' . ' <strong> ' . $vitals->bmi . '</strong>' : '';
                                        $kg = $vitals->bmi ? ' kg/m ' : '';
                                        $sup = $vitals->bmi ? 2 : '';
                                    @endphp
                                    {{ $kg }} <sup>{{ $sup }} </sup>
                                </div>
                                <div>
                                    @php
                                        echo isset($vitals->heart_rate) && $vitals->heart_rate != 0 ? ' , Heart  :' . '<strong>' . $vitals->heart_rate . ' </strong> ' : '';
                                        echo isset($vitals->ofc) ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> ' : '';
                                        echo isset($vitals->spo2_value) ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . '</strong>' . ' % ' : '';
                                        echo isset($vitals->rr_value) ? ' , RR :' . ' <strong> ' . $vitals->rr_value . '</strong>' . ' bpm ' : '';
                                    @endphp

                                </div>
                                <div>
                                    @php
                                        echo isset($vitals->bowel_condition) ? ' Bowel Condition	  :' . '<strong>' . $vitals->bowel_condition . ' </strong> ,' : '';
                                        echo isset($vitals->lung_condition) ? ' Lung Condition :' . ' <strong> ' . $vitals->lung_condition . ' </strong>, ' : '';
                                        echo isset($vitals->heart_condition) ? ' Bladder Condition  :' . ' <strong> ' . $vitals->heart_condition . '</strong>' . '' : '';
                                    @endphp

                                </div>

                            </div>
                        @endif

                        @if (isset($left_side_arr['PROVDIAG']))
                            <div>
                                <div><strong>Clinical Examination</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                        <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($in_arr['INV']))
                            <div>
                                <div><strong>Investigations</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($in_arr['INV'] as $cc_item)
                                        <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['FINDINGS']))
                        <div>
                            <div><strong>Investigation Findings</strong></div>
                            <ul class="mb-5 ml-20">
                                @foreach ($left_side_arr['FINDINGS'] as $if_item)
                                    <li>{{ ucfirst($if_item) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (isset($left_side_arr['ICD']))
                            <div>
                                <div><strong>
                                        @if (Session::get('user.ses_hospital_code') == 'SSG')
                                            Diagnosis (Dx)
                                        @else
                                            Confirmatory Diagnosis / Provisional diagnosis(ICD)
                                        @endif
                                    </strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['ICD'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif






              
                        <div class="mb-2">
                                <div >
                                    <strong>
                                        @if (Session::get('user.serviceunit_code') == 'PAEDIATRIC')
                                            MH (Maternal History)
                                        @else
                                        @if (!empty($vitals->married_for) || !empty($vitals->para) || !empty($vitals->gravida) || !empty($vitals->alc))
                                            OBS (Obstetric History) :
                                        @endif
                                        @endif
                                    </strong>
                                </div>
                                <ul class="mb-3" style="margin-left: 20px;">
                                    @if (isset($vitals->obs))
                                        <li><strong>OBS: </strong>{{ $vitals->obs }}</li>
                                    @endif
                                    @if (isset($vitals->married_for))
                                        <li><strong>Married For: </strong>{{ $vitals->married_for }}</li>
                                    @endif
                                    @if (isset($vitals->para))
                                        <li><strong>Para: </strong>{{ $vitals->para }}</li>
                                    @endif

                                    @if (isset($vitals->gravida))
                                        <li><strong>Gravida: </strong>{{ $vitals->gravida }}</li>
                                    @endif

                                    @if (isset($vitals->alc))
                                        <li><strong>ALC: </strong>{{ $vitals->alc }}</li>
                                    @endif

                                    @if (isset($vitals->age_of_lastchild))
                                        <li><strong>Age Of Last Child: </strong>{{ $vitals->age_of_lastchild }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->dehydeation))
                                        <li><strong>Dehydeation: </strong>{{ $vitals->dehydeation }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->gestational_age))
                                        <li><strong>Gestational Age: </strong>{{ $vitals->gestational_age }}
                                            Week
                                        </li>
                                    @endif

                                    @if (isset($vitals->mblood_group))
                                        <li><strong>Mother Blood Group: </strong>{{ $vitals->mblood_group }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->gdm))
                                        <li><strong>GDM: </strong>{{ $vitals->gdm }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->dih))
                                        <li><strong>PIH: </strong>{{ $vitals->dih }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->hypothyroidism))
                                        <li><strong>Hypothyroidism: </strong>{{ $vitals->hypothyroidism }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->brochial_asthma))
                                        <li><strong>OHA: </strong>{{ $vitals->brochial_asthma }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->birthorder))
                                        <li><strong>Birth Order: </strong>{{ $vitals->birthorder }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->birth_weight))
                                        <li><strong>Birth Weight: </strong>{{ $vitals->birth_weight }} gm
                                        </li>
                                    @endif
                                </ul>

                                @if (isset($vitals->menstrual_cycle) ||
                                        isset($vitals->mp) ||
                                        isset($vitals->mf) ||
                                        isset($vitals->dysmenorrhoea) ||
                                        isset($vitals->lmp) ||
                                        isset($vitals->edd))
                                    <div style="width:45%;"><strong>Menstrual History :</strong></div>
                                @endif
                                <ul class="mb-3" style="margin-left: 20px;">
                                    @if (isset($vitals->menstrual_cycle))
                                        <li><strong>Menstrual Cycle: </strong>{{ $vitals->menstrual_cycle }}
                                        </li>
                                    @endif

                                    @if (isset($vitals->mp))
                                        <li><strong>MP: </strong>{{ $vitals->mp }}</li>
                                    @endif

                                    @if (isset($vitals->mf))
                                        <li><strong>MF: </strong>{{ $vitals->mf }}</li>
                                    @endif

                                    @if (isset($vitals->dysmenorrhoea))
                                        <li><strong>Dysmenorhoea: </strong>{{ $vitals->dysmenorrhoea }}</li>
                                    @endif

                                    @if (isset($vitals->lmp) || $vitals->lmp_remarks)
                                        <li><strong>LMP: </strong>{{ isset($vitals->lmp) ? date('d/m/Y', strtotime($vitals->lmp)) : 'N/A' }}
                                        </li>

                                        @if($vitals->lmp_remarks != "")
                                            <li>
                                                <strong>LMP Remarks: </strong> {{ $vitals->lmp_remarks }}
                                            </li>
                                        @endif
                                    @endif

                                    @if (isset($vitals->edd)  || $vitals->edd_remarks)
                                        <li><strong>EDD: </strong>{{ isset($vitals->edd) ? date('d/m/Y', strtotime($vitals->edd)) : 'N/A' }}
                                        </li>
                                        @if($vitals->edd_remarks != "")
                                            <li>
                                                <strong>EDD Remarks: </strong> {{ $vitals->edd_remarks }}
                                            </li>
                                        @endif
                                    @endif
                                </ul>

                                @if (isset($vitals->contraceptive_history))
                                    <div style="width:45%;"><strong>Contraceptive History :</strong></div>
                                @endif

                                <ul class="mb-3" style="margin-left: 20px;">
                                    @if (isset($vitals->contraceptive_history))
                                        <li><strong>Contraceptive History:
                                            </strong>{{ $vitals->contraceptive_history }}</li>
                                    @endif
                                </ul>

                                @if (isset($vitals->drug_history))
                                    <div style="width:45%;"><strong>Drug History :</strong></div>
                                @endif

                                <ul class="mb-3" style="margin-left: 20px;">
                                    @if (isset($vitals->drug_history))
                                        <li><strong>Drug History: </strong>{{ $vitals->drug_history }}</li>
                                    @endif
                                </ul>

                                @if (isset($vitals->surgical_history))
                                    <div style="width:45%;"><strong>Surgical History :</strong></div>
                                @endif

                                <ul class="mb-3" style="margin-left: 20px;">
                                    @if (isset($vitals->surgical_history))
                                        <li><strong>Surgical History: </strong>{{ $vitals->surgical_history }}
                                        </li>
                                    @endif
                                </ul>

                                @if (isset($vitals->medical_history))
                                    <div style="width:45%;"><strong>Medical History: </strong></div>
                                @endif

                                <ul class="mb-3 unico" style="margin-left: 20px;">
                                    @if (isset($vitals->medical_history))
                                        <li><strong>Medical History: </strong>{{ $vitals->medical_history }}
                                        </li>
                                    @endif
                                </ul>

                                @if (isset($vitals->perineum_and_vulva) ||
                                        isset($vitals->cx) ||
                                        isset($vitals->vaginal_wall) ||
                                        isset($vitals->discharge) ||
                                        isset($vitals->uterus) ||
                                        isset($vitals->adnexa) ||
                                        isset($vitals->bme_note) ||
                                        isset($vitals->d_r_e) ||
                                        isset($vitals->breast_examination) || isset($vitals->sfh) ||
                                    isset($vitals->fm) ||
                                    isset($vitals->fhs) ||
                                    isset($vitals->pr) ||
                                    isset($vitals->hq) ||
                                    isset($vitals->swelling) ||
                                    isset($vitals->scar_work) ||
                                    isset($vitals->tenderness) ||
                                    isset($vitals->pae_note))
                                    <div style="width:45%;"><strong>Clinical Examination: </strong></div>
                                @endif
                                <br>

                                  @if (
                                isset($vitals->sfh) ||
                                    isset($vitals->fm) ||
                                    isset($vitals->fhs) ||
                                    isset($vitals->pr) ||
                                    isset($vitals->hq) ||
                                    isset($vitals->swelling) ||
                                    isset($vitals->scar_work) ||
                                    isset($vitals->tenderness) ||
                                    isset($vitals->pae_note))
                                 <div style="width:45%;"><strong>P/A/E :</strong></div>
                            @endif
                            <div class="mb-2">
                                @php
                                    echo isset($vitals->sfh)
                                        ? ' , SFH :' . ' <strong> ' . $vitals->sfh . '</strong>' . ''
                                        : '';
                                    echo isset($vitals->fm)
                                        ? ' , FM :' . ' <strong> ' . $vitals->fm . '</strong>' . ''
                                        : '';
                                    echo isset($vitals->fhs)
                                        ? ' , FHS :' . ' <strong> ' . $vitals->fhs . '</strong>' . ''
                                        : '';

                                    echo isset($vitals->pr)
                                        ? ' , PR :' . ' <strong> ' . $vitals->pr . '</strong>' . ''
                                        : '';
                                    echo isset($vitals->hq)
                                        ? ' , LIQ :' . ' <strong> ' . $vitals->hq . '</strong>' . ''
                                        : '';
                                    echo isset($vitals->swelling)
                                        ? ' , SWELLING :' . ' <strong> ' . $vitals->swelling . '</strong>' . ''
                                        : '';
                                    echo isset($vitals->scar_work)
                                        ? ' , SCAR WORK :' .
                                            ' <strong> ' .
                                            $vitals->scar_work .
                                            '</strong>' .
                                            ''
                                        : '';
                                    echo isset($vitals->tenderness)
                                        ? ' , TENDERNESS :' .
                                            ' <strong> ' .
                                            $vitals->tenderness .
                                            '</strong>' .
                                            ''
                                        : '';
                                    echo isset($vitals->pae_note)
                                        ? ' , NOTE :' . ' <strong> ' . $vitals->pae_note . '</strong>' . ''
                                        : '';

                                @endphp
                            </div>

                            @if (isset($vitals->perineum_and_vulva))
                                <div style="width:45%;"><strong>Pelvic Examination :</strong></div>
                            @endif

                            <ul class="mb-2 unico" style="margin-left: 20px;">
                                @if (isset($vitals->perineum_and_vulva))
                                    <li><strong>Pelvic Examination:
                                        </strong>{{ $vitals->perineum_and_vulva }}</li>
                                @endif
                            </ul>

                            @if (isset($vitals->cx) || isset($vitals->vaginal_wall) || isset($vitals->discharge))
                                <div style="width:45%;"><strong>P/S/E :</strong></div>
                            @endif

                            <ul class="mb-3 unico" style="margin-left: 20px;">
                                @if (isset($vitals->cx))
                                    <li><strong>CX: </strong>{{ $vitals->cx }}</li>
                                @endif
                                @if (isset($vitals->vaginal_wall))
                                    <li><strong>Vaginal Wall: </strong>{{ $vitals->vaginal_wall }}</li>
                                @endif
                                @if (isset($vitals->discharge))
                                    <li><strong>Discharge: </strong>{{ $vitals->discharge }}</li>
                                @endif
                            </ul>

                            @if (isset($vitals->uterus) || isset($vitals->adnexa) || isset($vitals->bme_note))
                                <div style="width:45%;"><strong>B/M/E :</strong></div>
                            @endif

                            <ul class="mb-3 unico" style="margin-left: 20px;">
                                @if (isset($vitals->uterus))
                                    <li><strong>Uterus: </strong>{{ $vitals->uterus }}</li>
                                @endif
                                @if (isset($vitals->adnexa))
                                    <li><strong>Adnexa: </strong>{{ $vitals->adnexa }}</li>
                                @endif
                                @if (isset($vitals->bme_note))
                                    <li><strong>Note: </strong>{{ $vitals->bme_note }}</li>
                                @endif
                            </ul>

                            @if (isset($vitals->d_r_e))
                                <div style="width:45%;"><strong>D/R/E :</strong></div>
                            @endif
                            <ul class="mb-3 unico" style="margin-left: 20px;">
                                @if (isset($vitals->d_r_e))
                                    <li><strong>D/R/E: </strong>{{ $vitals->d_r_e }}</li>
                                @endif
                            </ul>

                            @if (isset($vitals->breast_examination))
                                <div style="width:45%;"><strong>Breast Examination :</strong></div>
                            @endif
                            <ul class="mb-3 unico" style="margin-left: 20px;">
                                @if (isset($vitals->breast_examination))
                                    <li><strong>Breast Examination:
                                        </strong>{{ $vitals->breast_examination }}</li>
                                @endif
                            </ul>
                        </div>
                
               

                        @if (isset($chronic_item) && !$chronic_item->isEmpty())
                            <div>
                                <div><strong>Chronic</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($chronic_item as $vlaue)
                                        <li>{{ $vlaue->chronic_dis_name }} {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($allergy) && !$allergy->isEmpty())
                            <div>
                                <div><strong>Allergies</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($allergy as $vlaue)
                                        <li> {{ $vlaue->allergies_name }} {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($ele_thy_arr['PTET']))
                            <div>
                                <div><strong> Electro Therapy</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($ele_thy_arr['PTET'] as $ptet)
                                        @php
                                            $ptet_exp = explode('_', $ptet);
                                        @endphp
                                        <li>{{ $ptet_exp[0] }}<br>
                                            @if ($ptet_exp[1] != 0)
                                                [{{ $ptet_exp[1] }} {{ $ptet_exp[2] }}]
                                            @endif
                                            {{ $ptet_exp[4] ? 'Duration' . ' : ' . $ptet_exp[4] : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($therapiu_therapy_arr['PTTE']))
                            <div>
                                <div><strong>Therapeutic Exercise</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($therapiu_therapy_arr['PTTE'] as $ptte)
                                        @php
                                            $ptte_exp = explode('_', $ptte);
                                        @endphp
                                        <li>{{ $ptte_exp[0] }}
                                            <br>
                                            @if ($ptte_exp[1] != 0)
                                                [{{ $ptte_exp[1] }} {{ $ptte_exp[2] }}]
                                            @endif
                                            {{ $ptte_exp[3] ? 'Duration' . ' : ' . $ptte_exp[3] : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($left_side_arr['DISEASE']))
                            <div>
                                <div><strong>Disease</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($pr_arr['PROCEDURE']))
                            <div>
                                <div><strong>Plan</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(!empty($prescription_mst->disposal))
                            <div><strong>Disposal</strong></div>
                            <ul class="mb-5 ml-20">
                                 <li> {{ @$prescription_mst->disposal }}</li> 
                            </ul>
                        @endif

                        @if(isset($prescription_mst->note))
                            @if ($prescription_mst->note != '^' && $prescription_mst->note != '')
                                <div>
                                    <div><strong>Note</strong></div>
                                    <ul class="mb-5 ml-20">
                                        <li>{{ $prescription_mst->note }}</li>
                                    </ul>
                                </div>
                            @endif
                        @endif

                        @if (isset($left_side_arr['REFDOC']))
                            <div>
                                <div><strong>Referred To</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['REFDOC'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['ADVICE']))
                            <div>
                                <div><strong>Advice</strong></div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['ADVICE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
                        @if(!empty($prescription_mst->next_followup_dt))
                            <div class="mb-2 mt-20">
                                <strong>Next Followup:
                                </strong>{{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                                @if ($prescription_mst->followup_num != '')
                                    ( After {{ $prescription_mst->followup_num }}
                                    {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                                @endif
                            </div>
                        @endif
                    </td>

                    <td class="text-left" valign="top" style="padding-left: 10px;">
                        <h3 style="padding-left: 10px" class="py-2"><strong>R<sub>x</sub></strong></h3>

                        @if (isset($pres_med) && !empty($pres_med))
                            <table>
                                @php $i=1; @endphp
                                @foreach ($pres_med as $key => $med_row_item)
                                    <?php
                                        $keyDT = explode('`', $key);
                                    ?>
                                    
                                    <tr>
                                        <td valign="top" width="20">{{ $loop->iteration }}.</td>
                                        <td valign="top">
                                            <strong>{{ !empty($keyDT[0]) ? $keyDT[0] : '' }}</strong>
                                            @foreach ($med_row_item as $key1 => $medDt)
                                                <?php  $med_exp_dt = explode('^', $key1); ?>
                                                @if(!empty($medDt))
                                                    <table style="margin-bottom: 10px;">
                                                        @foreach ($medDt as $multidose)
                                                            <?php
                                                                $medDate = $multidose->duration;
                                                                $medDay = $multidose->duration_mu;
                                                                $bn_medDate = str_replace($search_array, $replace_array, $medDate);
                                                                $bn_medDay = str_replace($search_array, $replace_array, $medDay);
                                                            ?>
                                                            @if (empty($multidose->multidose_txt))
                                                                <div>
                                                                    <ul style="font-size: font-size:13px">
                                                                        @if(!empty($multidose->dosage) || !empty($multidose->route) || !empty($multidose->instruction_take) || !empty($multidose->duration) || !empty($multidose->duration_mu) || !empty($multidose->item_qty))
                                                                        <li>
                                                                            {{ !empty($multidose->dosage) ? $multidose->dosage : '' }} {{ !empty($multidose->route) ? '- ' . $multidose->route . ' -' : '' }}
                                                                            
                                                                            @if (isset($multidose->instruction_take))
                                                                                @if ($multidose->instruction_take != '0')
                                                                                        ({{ $multidose->instruction_take }})
                                                                                        <strong>{{ !empty($multidose->continue_ind) || $multidose->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                                @elseif(!empty($multidose->instruction_take))
                                                                                        <strong>{{ !empty($multidose->continue_ind) || $multidose->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                                @endif
                                                                            @endif
                                                                                [
                                                                                    {{ $multidose->duration }}
                                                                                    {{ $multidose->duration_mu }}
                                                                                ] 
                                                                                Qty {{ !empty($multidose->item_qty) ? $multidose->item_qty : '' }}
                                                                        </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            @endif


                                                            @php $multidose_data = explode(',', $multidose->multidose_txt); @endphp
                                                            @if(!empty($multidose_data))
                                                                @foreach ($multidose_data as $data)
                                                                    
                                                                    @php
                                                                        $exp_multidose_data = explode('~', $data);
                                                                        $medDatemul = !empty($exp_multidose_data[1]) ? $exp_multidose_data[1] : '';
                                                                        $medDaymul = !empty($exp_multidose_data[2]) ? $exp_multidose_data[2] : '';
                                                                        $bn_medDateMul = str_replace($search_array, $replace_array, $medDatemul);
                                                                        $bn_medDayMul = str_replace($search_array, $replace_array, $medDaymul);

                                                                    @endphp

                                                                    <ul style="{{ empty($exp_multidose_data[0]) ? 'list-style-type: none;display:none' : '' }};font-size:13px">
                                                                        <li valign="top">&nbsp;&nbsp;
                                                                            {{ !empty($exp_multidose_data[0]) ? $exp_multidose_data[0] : '' }}&nbsp;&nbsp;
                                                                            {{ !empty($exp_multidose_data[4]) ? $exp_multidose_data[4] : '' }}&nbsp;&nbsp;
                                                                            @if (!empty($exp_multidose_data[0]) && isset($exp_multidose_data[0]))
                                                                                    [ {{ $exp_multidose_data[1] }} {{ $exp_multidose_data[2] }} ] Qty {{ !empty($exp_multidose_data[3]) ? $exp_multidose_data[3] : '' }}
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif



                        @if(!empty($prescription_mst->ref_doc_name))
                            <div class="mb-3">
                                <strong>Referred Doctor:</strong>
                                    @php
                                        $str = $prescription_mst->ref_doc_name;
                                        $doc_dt = explode(',', $str);
                                    @endphp
                                @if(!empty($doc_dt[0]))
                                    {{ ucwords($doc_dt[0]) }}
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td><br><br><br></td>
                    <td class="doctor_sigature">
                        <!-- Prescription Footer -->
                        <br>
                        <br>
                        <br>
                        @include('admin.prescription.prescription_pdf.precription_footer')
                    </td>
                </tr>
            </tbody>
            <!-- Close Table Body -->

        </table>
    </section>
    @include('admin.prescription.prescription_pdf.print_by')
</body>
</html>