@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
->first();
$imageURL = isset($company_details->logo)
? '/images/uploads/hospital_images/' . $company_details->logo
: 'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color)
? $company_details->logo_background_color
: 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
date_default_timezone_set('Asia/Dhaka');

//bangla
$search_array = [
'1',
'2',
'3',
'4',
'5',
'6',
'7',
'8',
'9',
'0',
'Jan',
'Feb',
'Mar',
'Apr',
'May',
'Jun',
'Jul',
'Aug',
'Sep',
'Oct',
'Nov',
'Dec',
':',
',',
'DAY',
'MONTH',
'WEEK',
'YEAR',
'HOUR',
];
$replace_array = [
'১',
'২',
'৩',
'৪',
'৫',
'৬',
'৭',
'৮',
'৯',
'০',
'জানুয়ারি',
'ফেব্রুয়ারী',
'মার্চ',
'এপ্রিল',
'মে',
'জুন',
'জুলাই',
'আগষ্ট',
'সেপ্টেম্বর',
'অক্টোবর',
'নভেম্বর',
'ডিসেম্বর',
':',
',',
'দিন',
'মাস ',
'সপ্তাহ ',
'বছর',
'ঘন্টা',
];
@endphp
<style type="text/css">
    .teeth-table td {
        border: 1px solid #000;
    }

    .border-less {
        border: 1px solid #fff !important;
    }

    .bg-danger {
        background-color: red;
        color: #fff;
    }

    .alert-danger h4,
    .alert-danger p {
        color: #721c24;
    }

    .modal-footer a,
    .modal-footer button {
        min-width: 200px;
    }
</style>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12 border-bottom">
            <table style="width: 100%;" class="signature">
                <tr>
                    <td style="width: 10%;">
                        <img class="hospital-logo" style="background-color:{{ $backgroundColor }};width:100px"
                            src="{{ asset($imageURL) }}" alt="">
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($company_details->telephone1) ? $company_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <section id="prescription " style="margin-top: 10px;">
        <div class="container p-0">

            <table style="width: 100%; border-bottom:1px solid;">
                <tr>
                    <td colspan="2" class="text-left"><img src="data:image/png;base64, {{ $patient_barcode }} " />
                    </td>
                    <td colspan="2" class="text-right"><img
                            src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                </tr>
                <tr>
                    <td width="10%" class="text-left"><strong>UHID</strong></td>
                    <td width="55%" class="text-left">: {{ $prescription_mst->patient_code }}</td>
                    <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                    <td class="text-left">: {{ $prescription_mst->prescription_uid }}</td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>: {{ $prescription_mst->patient_name . ' ( ' . $prescription_mst->patient_type_code . ' ) ' }}
                    </td>
                    <td><strong>Visit Date & Time</strong></td>
                    <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                </tr>
                <tr>
                    <td><strong>Age</strong></td>
                    <td>: {{ $prescription_mst->age }}</td>
                    <td><strong>Sex</strong></td>
                    <td>: {{ $prescription_mst->gender_txt }}</td>
                </tr>

            </table>
            @if (isset($prescription_mst->dental_ind))
            @if ($prescription_mst->dental_ind == 1)
            @php
            $add_to_pres_url = route('add-pres-favourit-list');
            $adult_upper_right_arr = [
            '18' => 'Teeth-18',
            '17' => 'Teeth-17',
            '16' => 'Teeth-16',
            '15' => 'Teeth-15',
            '14' => 'Teeth-14',
            '13' => 'Teeth-13',
            '12' => 'Teeth-12',
            '11' => 'Teeth-11',
            ];
            $adult_upper_left_arr = [
            '21' => 'Teeth-21',
            '22' => 'Teeth-22',
            '23' => 'Teeth-23',
            '24' => 'Teeth-24',
            '25' => 'Teeth-25',
            '26' => 'Teeth-26',
            '27' => 'Teeth-27',
            '28' => 'Teeth-28',
            ];
            $adult_lower_right_arr = [
            '48' => 'Teeth-48',
            '47' => 'Teeth-47',
            '46' => 'Teeth-46',
            '45' => 'Teeth-45',
            '44' => 'Teeth-44',
            '43' => 'Teeth-43',
            '42' => 'Teeth-42',
            '41' => 'Teeth-41',
            ];
            $adult_lower_left_arr = [
            '31' => 'Teeth-31',
            '32' => 'Teeth-32',
            '33' => 'Teeth-33',
            '34' => 'Teeth-34',
            '35' => 'Teeth-35',
            '36' => 'Teeth-36',
            '37' => 'Teeth-37',
            '38' => 'Teeth-38',
            ];

            $child_upper_right_arr = [
            '55' => 'Teeth-55',
            '54' => 'Teeth-54',
            '53' => 'Teeth-53',
            '52' => 'Teeth-52',
            '51' => 'Teeth-51',
            ];
            $child_lower_right_arr = [
            '85' => 'Teeth-85',
            '84' => 'Teeth-84',
            '83' => 'Teeth-83',
            '82' => 'Teeth-82',
            '81' => 'Teeth-81',
            ];
            $child_upper_left_arr = [
            '61' => 'Teeth-61',
            '62' => 'Teeth-62',
            '63' => 'Teeth-63',
            '64' => 'Teeth-64',
            '65' => 'Teeth-65',
            ];
            $child_lower_left_arr = [
            '71' => 'Teeth-71',
            '72' => 'Teeth-72',
            '73' => 'Teeth-73',
            '74' => 'Teeth-74',
            '75' => 'Teeth-75',
            ];
            @endphp
            <table width="80%" style="margin:30px auto 10px auto;">
                <tr>
                    <td>
                        <div><span style="border-top:1px solid #000; border-left:1px solid #000;">Upper</span>
                            Right
                        </div>
                    </td>
                    <td align="right">
                        <div>Upper <span
                                style="border-top:1px solid #000; border-right:1px solid #000;">Left</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="border-right">
                        <table class="teeth-table" cellpadding="5" cellspacing="2"
                            style="float: right;border-collapse:separate !important;">
                            <tr>
                                @foreach ($adult_upper_right_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($child_upper_right_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($child_lower_right_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($adult_lower_right_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="border-collapse:separate !important;" class="teeth-table" cellpadding="5"
                            cellspacing="2">
                            <tr>
                                @foreach ($adult_upper_left_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="border-less"></td>
                                <td class="border-less"></td>
                                <td class="border-less"></td>
                                @foreach ($child_upper_left_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="border-less"></td>
                                <td class="border-less"></td>
                                <td class="border-less"></td>
                                @foreach ($child_lower_left_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($adult_lower_left_arr as $key => $row)
                                @php
                                $selected = in_array($row, $selected_dental_arr) ? 'bg-danger' : '';
                                @endphp
                                <td class="{{ $selected }}">{{ $key }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div><span
                                style="border-bottom:1px solid #000; border-left:1px solid #000;">Lower</span>
                            Right</div>
                    </td>
                    <td align="right">
                        <div>Lower<span
                                style="border-bottom:1px solid #000; border-right:1px solid #000;">Left</span>
                        </div>
                    </td>
                </tr>
            </table>
            @if (isset($dental_arr['TEETHFIND']))
            <div class="mb-2">
                @foreach ($dental_arr['TEETHFIND'] as $teeth_row)
                @php
                $teeth_item = explode('_', $teeth_row);
                @endphp
                <div><strong>{{ $teeth_item[0] }}:</strong> {{ $teeth_item[1] }}</div>
                @endforeach
            </div>
            @endif
            @endif
            @endif

            <table style="width: 100%;">
                <tr>
                    <td></td>
                    <td>
                        <h5 class="mb-0"><strong>R<sub>x</sub></strong></h5>
                    </td>
                </tr>
                <tr>
                    <div class="display-flex">
                        <td width="45%" valign="top" style="border-right: 1px solid; ">
                            @if (isset($left_side_arr['CHIEFCOM']))
                            <div class="mb-2">
                                <div><strong>Chief Complaints</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['HISTORY']))
                            <div class="mb-2">
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                        <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (isset($vitals->hypothyroidism))
                            <div class="mb-2">
                                <div><strong>
                                        Confirmatory Diagnosis
                                    </strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    <li> @php
                                        echo isset($vitals->hypothyroidism) ? $vitals->hypothyroidism : '';
                                        @endphp</li>
                                </ul>
                            </div>
                            @endif

                            @if (isset($left_side_arr['HISTORY']))
                            <div class="mb-2">
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['HISTORY'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                        <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @endforeach
                                </ul>
                                @if (isset($left_side_arr['EXAMINATION']))
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                        <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @elseif(isset($left_side_arr['EXAMINATION']))
                            <div class="mb-2">
                                <div><strong>History & Clinical Examination</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['EXAMINATION'] as $cc_history => $cc_item)
                                    <li>{{ $cc_history }}</li>
                                    @if (!empty($cc_item))
                                    <ul style="padding-left: 15px">
                                        @foreach ($cc_item as $cc_item_key => $cc_item_dlt_value)
                                        <li>{{ $cc_item_key }} - {{ $cc_item_dlt_value }}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (isset($left_side_arr['CLINICHIST']))
                            <div class="mb-2">
                                <div><strong>
                                        @if (Session::get('user.ses_hospital_code') == 'SSG')
                                        Drug history
                                        @else
                                        Clinical History
                                        @endif
                                    </strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if (isset($vitals))
                            <div class="mb-2" style="margin-bottom: 10px">
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
                                <div>
                                    @php
                                    echo isset($vitals->pulse_val)
                                    ? 'Pulse :' .
                                    ' <strong>' .
                                        $vitals->pulse_val .
                                        '</strong>' .
                                    ' b/m '
                                    : '';
                                    echo isset($vitals->bp_val_sys)
                                    ? ' , BP :' . ' <strong>' . $vitals->bp_val_sys . '</strong>'
                                    : '';
                                    echo isset($vitals->bp_val_dia)
                                    ? '<strong> / ' . $vitals->bp_val_dia . '</strong> ' . ' mmHg '
                                    : '';
                                    echo isset($vitals->temp_val)
                                    ? ' , Temp :' .
                                    '<strong> ' .
                                        $vitals->temp_val .
                                        '</strong>' .
                                    ' &deg;F '
                                    : '';
                                    // echo isset($vitals->spo2_value) ? ' , SPO2 :' . '<strong> ' . $vitals->spo2_value . '</strong>' . ' ' : '';
                                    // echo isset($vitals->ofc) ? ' , OFC :' . '<strong> ' . $vitals->ofc . '</strong>' . ' ' : '';
                                    @endphp
                                </div>

                                <div>
                                    @php
                                    echo isset($vitals->height_val)
                                    ? ' , Height :' .
                                    ' <strong> ' .
                                        $vitals->height_val .
                                        '</strong>' .
                                    ' cm '
                                    : '';
                                    echo isset($vitals->weight_val)
                                    ? ' , Weight :' .
                                    ' <strong> ' .
                                        $vitals->weight_val .
                                        '</strong>' .
                                    ' kg '
                                    : '';
                                    echo isset($vitals->bmi) && $vitals->bmi != 0
                                    ? ' , BMI :' . ' <strong> ' . $vitals->bmi . '</strong>'
                                    : '';

                                    $kg = $vitals->bmi ? ' kg/m ' : '';
                                    $sup = $vitals->bmi ? 2 : '';

                                    @endphp
                                    {{ $kg }} <sup>{{ $sup }} </sup>
                                </div>
                                <div>
                                    @php
                                    echo isset($vitals->heart_rate) && $vitals->heart_rate != 0
                                    ? ' , Heart :' .
                                    '<strong>' .
                                        $vitals->heart_rate .
                                        ' </strong> '
                                    : '';
                                    echo isset($vitals->ofc)
                                    ? ' , OFC :' . ' <strong> ' . $vitals->ofc . ' </strong> '
                                    : '';
                                    echo isset($vitals->spo2_value)
                                    ? ' , SPO2 :' .
                                    ' <strong> ' .
                                        $vitals->spo2_value .
                                        '</strong>' .
                                    ' % '
                                    : '';
                                    echo isset($vitals->rr_value)
                                    ? ' , RR :' .
                                    ' <strong> ' .
                                        $vitals->rr_value .
                                        '</strong>' .
                                    ' bpm '
                                    : '';
                                    @endphp

                                </div>
                                @endif
                                <div>
                                    @php
                                    echo isset($vitals->bowel_condition)
                                    ? ' Bowel Condition :' .
                                    '<strong>' .
                                        $vitals->bowel_condition .
                                        ' </strong> ,'
                                    : '';
                                    echo isset($vitals->lung_condition)
                                    ? ' Lung Condition :' .
                                    ' <strong> ' .
                                        $vitals->lung_condition .
                                        ' </strong>, '
                                    : '';
                                    echo isset($vitals->heart_condition)
                                    ? ' Bladder Condition :' .
                                    ' <strong> ' .
                                        $vitals->heart_condition .
                                        '</strong>' .
                                    ''
                                    : '';
                                    @endphp

                                </div>

                            </div>
                            @endif

                            @if (isset($left_side_arr['PROVDIAG']))
                            <div class="mb-2">
                                <div><strong>Clinical Examination</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (isset($in_arr['INV']))
                            <div class="mb-2">
                                <div><strong>Investigations</strong></div>
                                <ul class="mb-5" style="margin-left: 20px;">
                                    @foreach ($in_arr['INV'] as $cc_item)
                                    <li>{{ ucfirst($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            {{-- @if (isset($left_side_arr['FINDINGS']))
                                    <div class="mb-2">
                                        <div><strong>Investigation Findings</strong></div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_side_arr['FINDINGS'] as $if_item)
                                                <li>{{ ucfirst($if_item) }}</li>
                            @endforeach
                            </ul>
                    </div>
                    @endif --}}
                    @if (isset($prescription_mst->investigation_findings_note))
                    <div class="mb-2">
                        <div><strong>Investigation Findings</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            <li> {!! nl2br(e($prescription_mst->investigation_findings_note)) !!}</li>
                        </ul>

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
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($left_side_arr['ICD'] as $cc_item)
                            <li>{{ $cc_item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- @if (isset($chronic_item) && !$chronic_item->isEmpty()) --}}
                    @if (isset($chronic_item) && count($chronic_item) > 0)
                    <div>
                        <div> <strong>Chronic</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($chronic_item as $vlaue)
                            <li> {{ $vlaue->chronic_dis_name }}
                                {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (isset($allergy) && count($allergy) > 0)
                    <div>
                        <div><strong>Allergies</strong></div>

                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($allergy as $vlaue)
                            <li> {{ $vlaue->allergies_name }}
                                @if ($vlaue->allergies_severity_text != '' && $vlaue->allergies_severity_text != 'Select')
                                ({{ $vlaue->allergies_severity_text }})
                                @endif
                            </li>
                            @endforeach
                        </ul>

                    </div>
                    @endif @if (Session::get('user.serviceunit_code') == 'GYNOB' ||
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
                        'Birth Weight' => $vitals->birth_weight
                        ? $vitals->birth_weight . ' gm'
                        : null,
                        ];

                        $filtered = collect($fields)->filter(
                        fn($value) => isset($value) && $value !== '',
                        );
                        @endphp
                        @if ($filtered->isNotEmpty())
                        <ul class="mb-3" style="margin-left: 20px;">
                            @foreach ($filtered as $label => $value)
                            <li><strong>{{ $label }}: </strong>{{ $value }}
                            </li>
                            @endforeach
                        </ul>
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
                        <div style="width:45%;"><strong>Menstrual History:</strong></div>
                        <ul class="mb-3" style="margin-left: 20px;">
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
                        </ul>
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
                        <div style="width:45%;"><strong>{{ $label }}:</strong>
                        </div>
                        <ul class="mb-3" style="margin-left: 20px;">
                            <li>{{ $vitals->$key }}</li>
                        </ul>
                        @endforeach
                        @endif


                        {{-- @if (isset($vitals->medical_history))
                                            <div style="width:45%;"><strong>Medical History: </strong></div>
                                        @endif --}}

                        {{-- <ul class="mb-3 unico" style="margin-left: 20px;">
                                            @if (isset($vitals->medical_history))
                                                <li><strong>Medical History: </strong>{{ $vitals->medical_history }}
                        </li>
                        @endif
                        </ul> --}}

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
                        <div style="width:45%;"><strong>Clinical Examination:</strong></div>
                        <ul class="mb-3" style="margin-left: 20px;">
                            @foreach ($availableFields as $key => $label)
                            <li><strong>{{ $label }}:</strong> {{ $vitals->$key }}
                            </li>
                            @endforeach
                        </ul>
                        @endif


                        @php
                        $sections = [
                        'perineum_and_vulva' => 'Pelvic Examination',
                        'cx' => 'Cervix (Cx)',
                        'vaginal_wall' => 'Vaginal Wall',
                        'discharge' => 'Discharge',
                        'uterus' => 'Uterus',
                        'adnexa' => 'Adnexa',
                        'bme_note' => 'BME Note',
                        'd_r_e' => 'DRE',
                        'breast_examination' => 'Breast Examination',
                        ];

                        $availableSections = collect($sections)->filter(
                        fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                        );
                        @endphp

                        @if ($availableSections->isNotEmpty())
                        @foreach ($availableSections as $key => $label)
                        <div style="width:45%;"><strong>{{ $label }}:</strong>
                        </div>
                        <ul class="mb-3 unico" style="margin-left: 20px;">
                            <li>{{ $vitals->$key }}</li>
                        </ul>
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
                        <ul class="mb-3 unico" style="margin-left: 20px;">
                            @foreach ($vitalItems as $key => $label)
                            @if (!empty($prescription_mst->$key))
                            <li><strong>{{ $label }}:</strong>
                                {{ $prescription_mst->$key }}
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @php
                    $sections = [
                    'medical_history' => 'Medical History',
                    'family_history' => 'Family History',
                    'complaints_history' => 'Complaints History',
                    'past_history' => 'Past History',
                    'surgical_history' => 'Surgical History',
                    ];

                    $availableSections = collect($sections)->filter(
                    fn($label, $key) => isset($vitals->$key) && $vitals->$key !== null,
                    );
                    @endphp

                    @if ($availableSections->isNotEmpty())
                    @foreach ($availableSections as $key => $label)
                    <div class="mb-2">
                        <div><strong>{{ $label }}</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            {{ $vitals->$key }}
                        </ul>
                    </div>
                    @endforeach
                    @endif




                    @if (isset($acup_thy_arr['ACUP']))
                    <div class="mb-2">
                        <div><strong>Modern Traditional Chinese Medicine(TCM)</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
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
                        </ul>
                    </div>
                    @endif

                    @if (isset($ele_thy_arr['PTET']))
                    <div class="mb-2">
                        <div><strong> Electro Therapy</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
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
                        </ul>
                    </div>
                    @endif
                    @if (isset($therapiu_therapy_arr['PTTE']))
                    <div class="mb-2">
                        <div><strong> Therapeutic Exercise</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
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
                    @if (isset($left_side_arr['DISEASE']))
                    <div class="mb-2">
                        <div><strong>Disease</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($left_side_arr['DISEASE'] as $cc_item)
                            <li>{{ $cc_item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (isset($pr_arr['PROCEDURE']))
                    <div class="mb-2">
                        <div><strong>OT</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                            <li>{{ $cc_item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (isset($prescription_mst->disposal))
                    <div class="mb-2">
                        <div><strong>Disposal</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            <li>{{ $prescription_mst->disposal }}</li>
                        </ul>
                    </div>
                    @endif
                    @if (isset($prescription_mst->note))
                    @if ($prescription_mst->note != '^' && $prescription_mst->note != '')
                    <div class="mb-2">
                        <div><strong>Note</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            <li>{{ $prescription_mst->note }}</li>
                        </ul>
                    </div>
                    @endif
                    @endif
                    @if (isset($prescription_mst->management_plan_note))
                    @if ($prescription_mst->management_plan_note != '^' && $prescription_mst->management_plan_note != '')
                    <div class="mb-2">
                        <div><strong>Management Plan Note</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            <li>{!! nl2br(e($prescription_mst->management_plan_note)) !!} </li>
                        </ul>
                    </div>
                    @endif
                    @endif
                    @if (isset($left_side_arr['REFDOC']))
                    <div class="mb-2">
                        <div><strong>Referred To</strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($left_side_arr['REFDOC'] as $cc_item)
                            <li>{{ $cc_item }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (isset($left_side_arr['ADVICE']))
                    <div class="">
                        <div><strong>Advice</strong></div>
                        <ol class="" style="margin-left: 20px;">
                            @foreach ($left_side_arr['ADVICE'] as $cc_item)
                            <li>{{ $cc_item }}</li>
                            @endforeach
                        </ol>
                    </div>
                    @endif
                    <br>
                    @if ($prescription_mst->ref_doc_name != '')
                    <div class="mb-3">
                        <strong>Referred Doctor:</strong>
                        <?php
                        $str = $prescription_mst->ref_doc_name;
                        $doc_dt = explode(',', $str);
                        ?>
                        @if ($doc_dt[0] != '')
                        {{ ucwords($doc_dt[0]) }}
                        @endif
                        @if (!empty($prescription_mst->serviceunit_no_fk_dept_name))
                        - <strong>({{ $prescription_mst->serviceunit_no_fk_dept_name }})</strong>
                        @endif
                    </div>
                    @endif


                    <br>
                    @if ($prescription_mst->ipd_referred_date != '')
                    <?php
                    $englishDate_ref = date('d/M/Y', strtotime($prescription_mst->ipd_referred_date));

                    // convert all bangle char to English char
                    $bn_date_ref = str_replace($search_array, $replace_array, $englishDate_ref);
                    ?>
                    @endif
                    @if (isset($prescription_mst->ipd_referred_advice))
                    <div class="mb-2 mt-20">
                        <div><strong>Admission Advice</strong></div>
                        <p>{{ $prescription_mst->ipd_referred_advice }}</p>
                        @if ($prescription_mst->ipd_referred_date)
                        @php
                        $referredDate = \Carbon\Carbon::parse(
                        $prescription_mst->ipd_referred_date,
                        );
                        $formattedDate = $referredDate->format('l, d F Y'); // Day, Date Month Year
                        $daysDifference = $referredDate->diffInDays(now()); // Difference in days from today
                        @endphp
                        <strong>Admission Referred on: {{ $formattedDate }}
                            ({{ $daysDifference }} days
                            ago)</strong>
                        @endif
                    </div>
                    @endif

                    @if ($prescription_mst->next_followup_dt != '')
                    <div class="mb-2 mt-20">
                        <strong>Next Followup:
                        </strong>{{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                        @if ($prescription_mst->followup_num != '')
                        ( After {{ $prescription_mst->followup_num }}
                        {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                        @endif
                    </div>
                    @endif

                    @if ($prescription_mst->next_followup_dt != '')
                    <?php
                    $englishDate = date('d-M-Y', strtotime($prescription_mst->next_followup_dt));
                    $followup_dt = $prescription_mst->followup_num;

                    // convert all bangle char to English char
                    $bn_date = str_replace($search_array, $replace_array, $englishDate);
                    $followup_date = str_replace($search_array, $replace_array, $followup_dt);
                    ?>
                    @endif


                    </td>
                    <td class="text-left pl-2" valign="top">
                        @if (!empty($pres_med))
                        <table>
                            @foreach ($pres_med as $brand_name => $med_list)
                            <tr>
                                <td valign="top" width="20">{{ $loop->iteration }}.</td>
                                <td valign="top">
                                    <strong>{{ strtoupper($brand_name) }}</strong>

                                    @foreach ($med_list as $multidose)
                                    @php
                                    $medDate = $multidose->duration;
                                    $medDay = $multidose->duration_mu;

                                    $bn_medDate = str_replace($search_array, $replace_array, $medDate);
                                    $bn_medDay = str_replace($search_array, $replace_array, $medDay);
                                    @endphp

                                    <ul style="font-size:13px; margin-bottom: 4px;">
                                        <li>
                                            {{ $multidose->dosage }}
                                            {{ $multidose->route ? '- ' . strtoupper($multidose->route) . ' -' : '' }}

                                            @if ($multidose->continue_ind == '1' || $multidose->duration == 'Continue')
                                            @if (!empty($multidose->instruction_take))
                                            ({{ strtoupper($multidose->instruction_take) }})
                                            @endif
                                            <strong>- Continue</strong>
                                            @else
                                            @if (!empty($multidose->instruction_take))
                                            ({{ strtoupper($multidose->instruction_take) }})
                                            @endif
                                            <strong>- [{{ $medDate }} {{ $medDay }}]</strong>
                                            @endif
                                        </li>
                                    </ul>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @endif


                        @if (isset($prescription_mst->eye_ind))
                        @if ($prescription_mst->eye_ind == 1)
                        <div class="mt-4">
                            @if (!empty($ocular_exam_right_arr) || !empty($ocular_exam_left_arr))
                            <div class="mb-4 mt-10"><strong>Ocular Examination</strong></div>
                            @endif
                            <table width="100%">
                                <tr>
                                    <td style="width: 50%">
                                        @if (!empty($ocular_exam_right_arr))
                                        <div class="mb-5"><strong>Right Eye</strong></div>
                                        @foreach ($ocular_exam_right_arr as $key => $right_rows)
                                        <div>{{ $key }}</div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($right_rows as $rows)
                                            <li>{{ $rows }}</li>
                                            @endforeach
                                        </ul>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($ocular_exam_left_arr))
                                        <div class="mb-5"><strong>Left Eye</strong></div>
                                        @foreach ($ocular_exam_left_arr as $key => $left_rows)
                                        <div>{{ $key }}</div>
                                        <ul class="mb-5" style="margin-left: 20px;">
                                            @foreach ($left_rows as $rows)
                                            <li>{{ $rows }}</li>
                                            @endforeach
                                        </ul>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @endif
                        @endif


                    </td>
        </div>
        </tr>
        </table>
</div>

<div class="container p-3">

    <!-- Notification Message -->
    <div class="alert alert-danger text-center" role="alert">
        <h4 class="mb-0">
            Please review the entire prescription.
        </h4>
        <p class="mt-2 mb-0">
            If you need to make any changes to this prescription, click the <strong>EDIT</strong> button.
        </p>
    </div>

    <!-- Edit Button -->
    <div class="text-center mb-4">
        <span class="btn btn-success btn-md"
            data-presc="{{ $prescription_mst->prescription_no_pk }}"
            data-dtls-action="{{ route('prescription.create-doctor-wise-uhl', [$prescription_mst->appoint_no_fk, $prescription_mst->patient_code, $prescription_mst->patient_no_fk, $prescription_mst->prescription_no_pk]) }}"
            onclick="callPrescriptionRoute(this)"
            title="Edit Prescription">
            <i class="fa fa-prescription mr-2"></i> Edit Prescription
        </span>
    </div>

    <!-- Print Buttons -->
    <div class="modal-footer justify-content-between flex-wrap">

        @if ($prescription_mst->eye_ind == 1)
        <a href="{{ route('opd_prescription_print_pdf_uhl', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-primary btn-md mb-2"
            target="_blank"
            title="Print Ocular Examination Prescription">
            <i class="fas fa-print mr-1"></i> Ocular Examination Print
        </a>

        <a href="{{ route('prescription-print-specticles-pdf', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-success btn-md mb-2"
            target="_blank"
            title="Print Spectacles Prescription">
            <i class="fas fa-print mr-1"></i> Eye Spectacles Print
        </a>
        @else
        <a href="{{ route('v2.op_summary_pdf_uhl', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-primary btn-md mb-2"
            target="_blank"
            title="Print Prescription">
            <i class="fa fa-file-pdf mr-1"></i> Print OP Summary
        </a>
        @endif

        <a href="{{ route('prescription.appointment-list')}}"
            class="btn btn-danger btn-md mb-2" rel="tab" onclick="closeModal(this)">
            <i class="fa fa-times mr-1"></i> Exit
        </a>
        <!-- <button class="btn btn-danger btn-md mb-2" data-dismiss="modal">
            <i class="fa fa-times mr-1"></i> Exit
        </button> -->
    </div>
</div>

</section>
</div>

<script>
    function callPrescriptionRoute(element) {
        const prescriptionNo = element.getAttribute('data-presc');
        const routeUrl = element.getAttribute('data-dtls-action');

        // Example: navigate to the route
        window.location.href = routeUrl;

        // Or use fetch/AJAX if needed
    }

    function closeModal(thisElement) {
        $(".exampleModal ").modal("hide");
    }
</script>