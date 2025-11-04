<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prescription:: {{ @$prescription_mst->prescription_uid }}</title>
</head>

@include('admin.prescription.prescription_pdf.prescription_css')
<style>
    .table-footer {
        position: relative;
        bottom: 0px;
        left: 0;
        right: 0;
    }

    @media print {
    .table-footer {
        page-break-inside: avoid;
        break-inside: avoid;
    }
    .table-footer td {
        page-break-inside: avoid;
        break-inside: avoid;
    }
}
</style>

<body>
    {{-- <h2 style="text-align: center;">OP Summary</h3> --}}
    <table>
        <thead style="border-bottom:1px solid;">
            @include('admin.prescription.prescription_pdf.precription_header_op_summary')
        </thead>

        <!-- Table Body -->
        <tbody>
            <tr class="no-break">
                <td width="65%" valign="top" style="border-right: 1px solid;margin-bottom: 0px;padding-bottom: 0px;">

                    <h3 class="py-1"></h3>
                    @if (isset($left_side_arr['CHIEFCOM']))
                        <div class="mb-2">
                            <div><strong>Chief Complaints</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                    @if (isset($vitals))
                        <div class="mb-2">
                            @if (
                                !empty($vitals->height_val) ||
                                    !empty($vaitals->weight_val) ||
                                    !empty($vitals->pulse_val) ||
                                    !empty($vitals->bp_val_sys) ||
                                    !empty($vitals->bp_val_dia) ||
                                    !empty($vitals->temp_val) ||
                                    !empty($vitals->spo2_value) ||
                                    !empty($vitals->ofc))
                                <div><strong>Vitals</strong></div>
                                <div style=" margin-left:25px !important;">
                                    @php
                                        echo isset($vitals->pulse_val)
                                            ? 'Pulse :' . ' <strong>' . $vitals->pulse_val . '</strong>' . ' b/m '
                                            : '';
                                        echo isset($vitals->bp_val_sys)
                                            ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . '</strong>'
                                            : '';
                                        echo isset($vitals->bp_val_dia)
                                            ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg '
                                            : '';
                                        echo isset($vitals->temp_val)
                                            ? ' , Temp: <strong>' . $vitals->temp_val . '</strong> &deg;F'
                                            : '';
                                        echo isset($vitals->spo2_value)
                                            ? ' , SPO2 :' . '<strong> ' . $vitals->spo2_value . '</strong>' . ' '
                                            : '';
                                        // echo isset($vitals->ofc) ? ' , OFC :' . '<strong> ' . $vitals->ofc . '</strong>' . ' ' : '';
                                    @endphp
                                </div>

                                <div style=" margin-left:25px !important;">
                                    @php
                                        echo isset($vitals->height_val)
                                            ? ' Height :' . ' <strong> ' . $vitals->height_val . '</strong>' . ' cm '
                                            : '';
                                        echo isset($vitals->weight_val)
                                            ? ' , Weight :' . ' <strong> ' . $vitals->weight_val . '</strong>' . ' kg '
                                            : '';
                                        echo isset($vitals->bmi) && $vitals->bmi != 0
                                            ? ' , BMI :' . ' <strong> ' . $vitals->bmi . '</strong>'
                                            : '';

                                        $kg = $vitals->bmi ? ' kg/m ' : '';
                                        $sup = $vitals->bmi ? 2 : '';

                                    @endphp
                                    {{ $kg }} <sup>{{ $sup }} </sup>
                                </div>
                                <div style=" margin-left:25px !important;">
                                    @php
                                        echo isset($vitals->heart_rate) && $vitals->heart_rate != 0
                                            ? ' Heart  :' . '<strong>' . $vitals->heart_rate . ' </strong> '
                                            : '';
                                        echo isset($vitals->ofc)
                                            ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> '
                                            : '';
                                        echo isset($vitals->spo2_value)
                                            ? ' , SPO2  :' . ' <strong> ' . $vitals->spo2_value . '</strong>' . ' % '
                                            : '';
                                        echo isset($vitals->rr_value)
                                            ? ' , RR :' . ' <strong> ' . $vitals->rr_value . '</strong>' . ' bpm '
                                            : '';
                                    @endphp

                                </div>
                            @endif
                            <div style=" margin-left:25px !important;">
                                @php
                                    echo isset($vitals->bowel_condition)
                                        ? ' Bowel Condition	  :' . '<strong>' . $vitals->bowel_condition . ' </strong> ,'
                                        : '';
                                    echo isset($vitals->lung_condition)
                                        ? ' Lung Condition :' . ' <strong> ' . $vitals->lung_condition . ' </strong>, '
                                        : '';
                                    echo isset($vitals->heart_condition)
                                        ? ' Bladder Condition  :' .
                                            ' <strong> ' .
                                            $vitals->heart_condition .
                                            '</strong>' .
                                            ''
                                        : '';
                                @endphp

                            </div>

                        </div>
                    @endif

                    @if (isset($left_side_arr['HISTORY']))
                        <div class="mb-2">
                            <div><strong>History & Clinical Examination</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                        <ol style="padding-left: 15px">
                                            @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($vitals->hypothyroidism))
                        <div class="mb-2">
                            <div><strong>
                                    Confirmatory Diagnosis
                                </strong></div>
                            <ol class="mb-5" style="">
                                <li> @php
                                    echo isset($vitals->hypothyroidism) ? $vitals->hypothyroidism : '';
                                @endphp</li>
                            </ol>
                        </div>
                    @endif

                    @if (isset($left_side_arr['HISTORY']))
                        <div class="mb-2">
                            <div><strong>History & Clinical Examination</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                        <ol style="padding-left: 15px">
                                            @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            </ol>
                            @if (isset($left_side_arr['EXAMINATION']))
                                <ol class="mb-5" style="">
                                    @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                        <li>{{ $cc_history }}</li>
                                        @if (!empty($cc_item))
                                            <ol style="padding-left: 15px">
                                                @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                    <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    @elseif(isset($left_side_arr['EXAMINATION']))
                        <div class="mb-2">
                            <div><strong>History & Clinical Examination</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                        <ol style="padding-left: 15px">
                                            @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($left_side_arr['CLINICHIST']))
                        <div class="mb-2">
                            <div><strong>
                                    @if (Session::get('user.ses_hospital_code') == 'SSG')
                                        Drug history
                                    @else
                                        Clinical Examination Findings
                                    @endif
                                </strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif



                    @if (isset($left_side_arr['HISTORY']))
                        <div class="mb-2">
                            <div><strong>History & Clinical Examination</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                        <ol style="padding-left: 15px">
                                            @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                                <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif
                    @if (isset($left_side_arr['PROVDIAG']))
                        <div class="mb-2">
                            <div><strong>Clinical Examination</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($in_arr['INV']))
                        <div class="mb-2">
                            <div><strong>Investigations</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($in_arr['INV'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($prescription_mst->investigation_findings_note))
                        <div class="mb-2">
                            <div><strong>Investigation Findings</strong></div>
                            <ol class="mb-5" style="font-size: 13px !important;">
                                <li> {!! nl2br(e($prescription_mst->investigation_findings_note)) !!}</li>
                            </ol>

                        </div>
                    @endif


                    @if (isset($left_side_arr['ICD']))
                        <div class="mb-2">
                            <div><strong>
                                    @if (Session::get('user.ses_hospital_code') == 'SSG')
                                        Diagnosis (Dx)
                                    @else
                                        Confirmatory Diagnosis / Provisional diagnosis(ICD)
                                    @endif
                                </strong></div>
                            <ol class="mb-5"
                                style="font-size: 13px !important; font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';">
                                @foreach ($left_side_arr['ICD'] as $cc_item)
                                    <li style="font-size: 13px !important;">{{ $cc_item }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($chronic_item) && !$chronic_item->isEmpty())
                        <div>
                            <div> <strong>Chronic</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($chronic_item as $vlaue)
                                    <li> {{ $vlaue->chronic_dis_name }}
                                        {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($allergy) && !$allergy->isEmpty())
                        <div>
                            <div><strong>Allergies</strong></div>

                            <ol class="mb-5" style="">
                                @foreach ($allergy as $vlaue)
                                    <li> {{ $vlaue->allergies_name }}
                                        {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}
                                    </li>
                                @endforeach
                            </ol>

                        </div>
                    @endif

                    @if (Session::get('user.serviceunit_code') == 'GYNOB' ||
                            Session::get('user.serviceunit') == 'Obstetrics & Gynaecology' ||
                            $prescription_mst->gender_txt == 'Female')
                        @if (isset($vitals))
                            <div class="mb-2">

                                @php
                                    $isPaediatric = Session::get('user.serviceunit_code') === 'PAEDIATRIC';
                                    $hasObs =
                                        !$isPaediatric &&
                                        (!empty($vitals->married_for) ||
                                            !empty($vitals->para) ||
                                            !empty($vitals->gravida) ||
                                            !empty($vitals->alc));
                                @endphp

                                @if ($isPaediatric)
                                    <div style="width:45%">
                                        <strong>MH (Maternal History)</strong>
                                    </div>
                                @elseif($hasObs)
                                    <div style="width:45%">
                                        <strong>OBS (Obstetric History):</strong>
                                    </div>
                                @endif


                                @php
                                    $fields = [
                                        'OBS' => $vitals->obs,
                                        'Married For' => $vitals->married_for,
                                        'Para' => $vitals->para,
                                        'Gravida' => $vitals->gravida,
                                        'ALC' => $vitals->alc,
                                        'Age Of Last Child' => $vitals->age_of_lastchild,
                                        'Dehydeation' => $vitals->dehydeation,
                                        'Gestational Age' => $vitals->gestational_age
                                            ? $vitals->gestational_age . ' Week'
                                            : null,
                                        'Mother Blood Group' => $vitals->mblood_group,
                                        'GDM' => $vitals->gdm,
                                        'PIH' => $vitals->dih,
                                        'Hypothyroidism' => $vitals->hypothyroidism,
                                        'OHA' => $vitals->brochial_asthma,
                                        'Birth Order' => $vitals->birthorder,
                                        'Birth Weight' => $vitals->birth_weight ? $vitals->birth_weight . ' gm' : null,
                                    ];

                                    $filtered = collect($fields)->filter(fn($value) => isset($value) && $value !== '');
                                @endphp
                                @if ($filtered->isNotEmpty())
                                    <ol class="mb-3" style="">
                                        @foreach ($filtered as $label => $value)
                                            <li><strong>{{ $label }}:
                                                </strong>{{ $value }}
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif

                                @php
                                    $fields = [
                                        'menstrual_cycle' => 'Menstrual Cycle',
                                        'mp' => 'MP',
                                        'mf' => 'MF',
                                        'dysmenorrhoea' => 'Dysmenorrhoea',
                                        'lmp' => 'LMP',
                                        'lmp_remarks' => 'LMP Remarks',
                                        'edd' => 'EDD',
                                        'edd_remarks' => 'EDD Remarks',
                                    ];

                                    $availableFields = collect($fields)->filter(
                                        fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                                    );
                                @endphp

                                @if ($availableFields->isNotEmpty())
                                    <div style="width:45%;"><strong>Menstrual History:</strong>
                                    </div>
                                    <ol class="mb-3" style="">
                                        @foreach ($availableFields as $key => $label)
                                            <li>
                                                <strong>{{ $label }}:</strong>
                                                @if ($key === 'lmp')
                                                    {{ isset($vitals->lmp) ? date('d/m/Y', strtotime($vitals->lmp)) : 'N/A' }}
                                                @elseif($key === 'edd')
                                                    {{ isset($vitals->edd) ? date('d/m/Y', strtotime($vitals->edd)) : 'N/A' }}
                                                @elseif($key === 'lmp_remarks' || $key === 'edd_remarks')
                                                    {{ $vitals->$key ?: 'N/A' }}
                                                @else
                                                    {{ $vitals->$key }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif


                                @php
                                    $fields = [
                                        'contraceptive_history' => 'Contraceptive History',
                                        'drug_history' => 'Drug History',
                                        'surgical_history' => 'Surgical History',
                                    ];

                                    $availableFields = collect($fields)->filter(
                                        fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                                    );
                                @endphp

                                @if ($availableFields->isNotEmpty())
                                    @foreach ($availableFields as $key => $label)
                                        <div style="width:45%;">
                                            <strong>{{ $label }}:</strong>
                                        </div>
                                        <ol class="mb-3" style="">
                                            <li>{{ $vitals->$key }}</li>
                                        </ol>
                                    @endforeach
                                @endif


                                {{-- @if (isset($vitals->medical_history))
                                            <div style="width:45%;"><strong>Medical History: </strong></div>
                                        @endif --}}

                                {{-- <ol class="mb-3 unico" style="">
                                            @if (isset($vitals->medical_history))
                                                <li><strong>Medical History: </strong>{{ $vitals->medical_history }}
                                                </li>
                                            @endif
                                        </ol> --}}

                                @php
                                    $fields = [
                                        'perineum_and_vulva' => 'Perineum and Vulva',
                                        'cx' => 'Cervix (Cx)',
                                        'vaginal_wall' => 'Vaginal Wall',
                                        'discharge' => 'Discharge',
                                        'uterus' => 'Uterus',
                                        'adnexa' => 'Adnexa',
                                        'bme_note' => 'BME Note',
                                        'd_r_e' => 'DRE',
                                        'breast_examination' => 'Breast Examination',
                                        'sfh' => 'SFH',
                                        'fm' => 'FM',
                                        'fhs' => 'FHS',
                                        'pr' => 'PR',
                                        'hq' => 'LIQ',
                                        'swelling' => 'Swelling',
                                        'scar_work' => 'Scar Work',
                                        'tenderness' => 'Tenderness',
                                        'pae_note' => 'P/A/E Note',
                                    ];

                                    $availableFields = collect($fields)->filter(
                                        fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                                    );
                                @endphp

                                @if ($availableFields->isNotEmpty())
                                    <div style="width:45%;"><strong>Clinical Examination:</strong>
                                    </div>
                                    <ol class="mb-3" style="">
                                        @foreach ($availableFields as $key => $label)
                                            <li><strong>{{ $label }}:</strong>
                                                {{ $vitals->$key }}
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif


                                @php
                                    $sections = [
                                        // 'perineum_and_vulva' => 'Pelvic Examination',
                                        // 'cx' => 'Cervix (Cx)',
                                        // 'vaginal_wall' => 'Vaginal Wall',
                                        // 'discharge' => 'Discharge',
                                        // 'uterus' => 'Uterus',
                                        // 'adnexa' => 'Adnexa',
                                        // 'bme_note' => 'BME Note',
                                        // 'd_r_e' => 'DRE',
                                        // 'breast_examination' => 'Breast Examination',
                                    ];

                                    $availableSections = collect($sections)->filter(
                                        fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                                    );
                                @endphp

                                @if ($availableSections->isNotEmpty())
                                    @foreach ($availableSections as $key => $label)
                                        <div style="width:45%;">
                                            <strong>{{ $label }}:</strong>
                                        </div>
                                        <ol class="mb-3 unico" style="">
                                            <li>{{ $vitals->$key }}</li>
                                        </ol>
                                    @endforeach
                                @endif

                            </div>
                        @endif
                    @endif
                    @php
                        $vitalItems = [
                            'diabetes_mel_typ1' => 'Diabetes Mellitus Type 1',
                            'diabetes_mel_typ2' => 'Diabetes Mellitus Type 2',
                            'hypertension' => 'Hypertension',
                            'dyslipdemia' => 'Dyslipidemia',
                            'obesity' => 'Obesity',
                            'sedentary_lifestyle' => 'Sedentary Lifestyle',
                            'smoking' => 'Smoking',
                            'dietary_factors' => 'Dietary Factors',
                            'stress' => 'Stress',
                            'anemia' => 'Anemia',
                            'inflammation' => 'Inflammation',
                            'genetic_factors' => 'Genetic Factors',
                            'heredity' => 'Heredity',
                        ];
                    @endphp

                    @php
                        $riskFactorItem = false;
                        foreach ($vitalItems as $key => $label) {
                            if (!empty($prescription_mst->$key)) {
                                $riskFactorItem = true;
                                break;
                            }
                        }
                    @endphp

                    @if ($riskFactorItem)
                        <div class="mb-2">
                            <div><strong>Risk Factor</strong></div>
                            <ol class="mb-3 unico" style="">
                                @foreach ($vitalItems as $key => $label)
                                    @if (!empty($prescription_mst->$key))
                                        <li><strong>{{ $label }}:</strong>
                                            {{ $prescription_mst->$key }}</li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @php
                        $sections = [
                            'medical_history' => 'Medical History',
                            'family_history' => 'Family History',
                            'complaints_history' => 'Complaints History',
                            'past_history' => 'Past History',
                            // 'surgical_history' => 'Surgical History',
                        ];

                        $availableSections = collect($sections)->filter(
                            fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                        );
                    @endphp

                    @if ($availableSections->isNotEmpty())
                        @foreach ($availableSections as $key => $label)
                            <div class="mb-2">
                                <div><strong>{{ $label }}</strong></div>
                                <ol class="mb-5" style="">
                                    {{ $vitals->$key }}
                                </ol>
                            </div>
                        @endforeach
                    @endif




                    @if (isset($acup_thy_arr['ACUP']))
                        <div class="mb-2">
                            <div><strong>Modern Traditional Chinese Medicine(TCM)</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($acup_thy_arr['ACUP'] as $acup)
                                    @php
                                        $acup_exp = explode('_', $acup);
                                    @endphp
                                    <li>{{ $acup_exp[0] }}
                                        <br>
                                        @if ($acup_exp[1] != 0)
                                            [{{ $acup_exp[1] }} {{ $acup_exp[2] }}]
                                        @endif
                                        {{ $acup_exp[3] ? 'Duration' . ' : ' . $acup_exp[3] : '' }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($ele_thy_arr['PTET']))
                        <div class="mb-2">
                            <div><strong> Electro Therapy</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($ele_thy_arr['PTET'] as $ptet)
                                    @php
                                        $ptet_exp = explode('_', $ptet);
                                    @endphp
                                    <li>{{ $ptet_exp[0] }}
                                        <br>
                                        @if ($ptet_exp[1] != 0)
                                            [{{ $ptet_exp[1] }} {{ $ptet_exp[2] }}]
                                        @endif
                                        {{ $ptet_exp[4] ? 'Duration' . ' : ' . $ptet_exp[4] : '' }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                    @if (isset($therapiu_therapy_arr['PTTE']))
                        <div class="mb-2">
                            <div><strong> Therapeutic Exercise</strong></div>
                            <ol class="mb-5" style="">
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
                            </ol>
                        </div>
                    @endif
                    @if (isset($left_side_arr['DISEASE']))
                        <div class="mb-2">
                            <div><strong>Disease</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($pr_arr['PROCEDURE']))
                        <div class="mb-2">
                            <div><strong>OT</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($referedInfo))
                        <div class="mb-2">
                            <div><strong>Planned OT / Procedure Date & Time</strong></div>
                            <ol class="mb-5" style="">
                                <li>{{ !empty($referedInfo->reff_date) ? date('d/m/Y H:i A', strtotime($referedInfo->reff_date)) : '' }}
                                </li>
                            </ol>
                            {{-- <div><strong>{{!empty($referedInfo->reff_date)?date('d/m/Y H:i A', strtotime($referedInfo->reff_date)):''}} </strong></div> --}}

                        </div>
                    @endif


                    @if (isset($prescription_mst->disposal))
                        <div class="mb-2">
                            <div><strong>Advised for Admission </strong></div>
                            <ol class="mb-5" style="">
                                <li>{{ $prescription_mst->disposal }}</li>
                            </ol>
                        </div>
                    @endif
                    @if (isset($prescription_mst->note))
                        @if ($prescription_mst->note != '^' && $prescription_mst->note != '')
                            <div class="mb-2">
                                <div><strong>Note</strong></div>
                                <ol class="mb-5" style="">
                                    <li>{{ $prescription_mst->note }}</li>
                                </ol>
                            </div>
                        @endif
                    @endif
                    @if (isset($prescription_mst->management_plan_note))
                        @if ($prescription_mst->management_plan_note != '^' && $prescription_mst->management_plan_note != '')
                            <div class="mb-2">
                                <div><strong>Management Plan Note</strong></div>
                                <ol class="mb-5" style="">
                                    <li style="font-size: 13px !important;">{!! nl2br(e($prescription_mst->management_plan_note)) !!} </li>
                                </ol>
                            </div>
                        @endif
                    @endif

                    {{-- @if (isset($vitals->medical_history))
                    <div class="mb-2">
                        <div><strong>Medical History</strong></div>
                        <ol class="mb-5" style="">
                        {{ $vitals->medical_history }}
                        </ol>
                    </div>
                @endif

                @if (isset($vitals->family_history))
                    <div class="mb-2">
                        <div><strong>Family History</strong></div>
                        <ol class="mb-5" style="">
                            {{ $vitals->family_history }}
                        </ol>
                    </div>
                @endif

                @if (isset($vitals->complaints_history))
                    <div class="mb-2">
                        <div><strong>Complaints History</strong></div>
                        <ol class="mb-5" style="">
                            {{ $vitals->complaints_history }}
                        </ol>
                    </div>
                @endif

                @if (isset($vitals->past_history))
                    <div class="mb-2">
                        <div><strong>Past History</strong></div>
                        <ol class="mb-5" style="">
                        {{ $vitals->past_history }}
                        </ol>
                    </div>
                @endif

                @if (isset($acup_thy_arr['ACUP']))
                    <div class="mb-2">
                        <div><strong>Modern Traditional Chinese Medicine(TCM)</strong></div>
                        <ol class="mb-5" style="">
                            @foreach ($acup_thy_arr['ACUP'] as $acup)
                                @php
                                    $acup_exp = explode('_', $acup);
                                @endphp
                                <li>{{ $acup_exp[0] }}
                                    <br>
                                    @if ($acup_exp[1] != 0)
                                        [{{ $acup_exp[1] }} {{ $acup_exp[2] }}]
                                    @endif
                                    {{ $acup_exp[3] ? 'Duration' . ' : ' . $acup_exp[3] : '' }}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                @if (isset($ele_thy_arr['PTET']))
                    <div class="mb-2">
                        <div><strong> Electro Therapy</strong></div>
                        <ol class="mb-5" style="">
                            @foreach ($ele_thy_arr['PTET'] as $ptet)
                                @php
                                    $ptet_exp = explode('_', $ptet);
                                @endphp
                                <li>{{ $ptet_exp[0] }}
                                    <br>
                                    @if ($ptet_exp[1] != 0)
                                        [{{ $ptet_exp[1] }} {{ $ptet_exp[2] }}]
                                    @endif
                                    {{ $ptet_exp[4] ? 'Duration' . ' : ' . $ptet_exp[4] : '' }}
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                @if (isset($therapiu_therapy_arr['PTTE']))
                    <div class="mb-2">
                        <div><strong> Therapeutic Exercise</strong></div>
                        <ol class="mb-5" style="">
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
                        </ol>
                    </div>
                @endif

                @if (isset($left_side_arr['DISEASE']))
                    <div class="mb-2">
                        <div><strong>Disease</strong></div>
                        <ol class="mb-5" style="">
                            @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                <li>{{ $cc_item }}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                @if (isset($pr_arr['PROCEDURE']))
                    <div class="mb-2">
                        <div><strong>Plan</strong></div>
                        <ol class="mb-5" style="">
                            @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                <li>{{ $cc_item }}</li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                @if (isset($prescription_mst->disposal))
                    <div class="mb-2">
                        <div><strong>Disposal</strong></div>
                        <ol class="mb-5" style="">
                            <li>{{ $prescription_mst->disposal }}</li>
                        </ol>
                    </div>
                @endif

                @if (isset($prescription_mst->note))
                    @if ($prescription_mst->note != '^' && $prescription_mst->note != '')
                        <div class="mb-2">
                            <div><strong>Note</strong></div>
                            <ol class="mb-5" style="">
                                <li>{{ $prescription_mst->note }}</li>
                            </ol>
                        </div>
                    @endif
                @endif --}}

                    @if (isset($left_side_arr['REFDOC']))
                        <div class="mb-2">
                            <div><strong>Referred To</strong></div>
                            <ol class="mb-5" style="">
                                @foreach ($left_side_arr['REFDOC'] as $cc_item)
                                    <li>{{ $cc_item }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif

                    @if (isset($left_side_arr['ADVICE']))
                        <div class="">
                            <div><strong>Advice</strong></div>
                            <ol class="" style="font-size: 13px !important;">
                                @foreach ($left_side_arr['ADVICE'] as $cc_item)
                                    <li style="font-size: 13px !important;">{{ $cc_item }}</li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                  
                    @if (!empty($prescription_mst->next_followup_dt))
                        <div class="mb-2 mt-20">
                            <strong>Next Followup:
                            </strong>{{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                            @if ($prescription_mst->followup_num != '')
                                ( After {{ $prescription_mst->followup_num }}
                                {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                            @endif
                        </div>
                    @endif
                    @if (!empty($prescription_mst->ref_doc_name))
                        <div class="mb-3">
                            <strong>Referred Doctor:</strong>
                            @php
                                $str = $prescription_mst->ref_doc_name;
                                $doc_dt = explode(',', $str);
                            @endphp
                            @if (!empty($doc_dt[0]))
                                {{ ucwords($doc_dt[0]) }}
                            @endif
                        </div>
                    @endif
                </td>

                <td class="text-left" valign="top" style="padding-left: 10px;">
                    <h3 style="padding-left: 10px" class="py-2"><strong>R<sub>x</sub></strong></h3>

                    @if (isset($pres_med) && !empty($pres_med))
                        <table>
                            <tbody>
                                @foreach ($pres_med as $key => $med_row_item)
                                    @php $keyDT = explode('`', $key); @endphp

                                    @if (isset($keyDT[0]) && $keyDT[0] === 'Unknown')
                                        @continue
                                    @endif

                                    <tr>
                                        <td valign="top" width="20">{{ $loop->iteration }}.</td>
                                        <td valign="top">
                                            <strong>{{ $keyDT[0] ?? '' }}</strong>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif




                </td>
            </tr>

        </tbody>
        <!-- Close Table Body -->

        </table>
    <table style="width: 100%;" class="table-footer">
            <tbody>
                <tr>
                    <td style="width:70%;text-align:right;padding-right:60px;">
                    </td>
                    <td style="width:30%; line-height: 100%; vertical-align:text-top; text-align:left;">
                        <div>
                            @if ($prescription_mst->doctor_signature_image)
                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $prescription_mst->doctor_signature_image) }}"
                                    alt="image" style="width: 100px;height:45px">
                            @endif

                            <?php
                            $doctorSignature = isset($prescription_mst->doctor_signature) ? $prescription_mst->doctor_signature : '';
                            $cleanedSignature = str_replace('<br>Unico Hospital Limited', '', $doctorSignature);
                            ?>
                            {!! $cleanedSignature !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        @php
                            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                            $date = $dt->format('g:i A');
                        @endphp
                        Printing Date: {{ date('d/m/Y') }} , {{ $date }}, Printed By:
                        {{ Session::get('user.ses_user_name') }} , Powered By - [NextGen]</td>
                </tr>
            </tbody>
        </table>

    

</body>
<script>
    window.onload = function() {
        window.print();
    };

    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>

</html>
