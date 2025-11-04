@php
    $company_details = $lead_unit = \App\Models\Company::where('status', 1)
        ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
    $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
    $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
    date_default_timezone_set('Asia/Dhaka');
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
                    <td><strong>Gender</strong></td>
                    <td>: {{ $prescription_mst->gender_txt }}</td>
                </tr>

            </table>
            @if (isset($prescription_mst->dental_ind))
                @if ($prescription_mst->dental_ind == 1)
                    @php
                        $add_to_pres_url = route('add-pres-favourit-list');
                        $adult_upper_right_arr = ['18' => 'Teeth-18', '17' => 'Teeth-17', '16' => 'Teeth-16', '15' => 'Teeth-15', '14' => 'Teeth-14', '13' => 'Teeth-13', '12' => 'Teeth-12', '11' => 'Teeth-11'];
                        $adult_upper_left_arr = ['21' => 'Teeth-21', '22' => 'Teeth-22', '23' => 'Teeth-23', '24' => 'Teeth-24', '25' => 'Teeth-25', '26' => 'Teeth-26', '27' => 'Teeth-27', '28' => 'Teeth-28'];
                        $adult_lower_right_arr = ['48' => 'Teeth-48', '47' => 'Teeth-47', '46' => 'Teeth-46', '45' => 'Teeth-45', '44' => 'Teeth-44', '43' => 'Teeth-43', '42' => 'Teeth-42', '41' => 'Teeth-41'];
                        $adult_lower_left_arr = ['31' => 'Teeth-31', '32' => 'Teeth-32', '33' => 'Teeth-33', '34' => 'Teeth-34', '35' => 'Teeth-35', '36' => 'Teeth-36', '37' => 'Teeth-37', '38' => 'Teeth-38'];

                        $child_upper_right_arr = ['55' => 'Teeth-55', '54' => 'Teeth-54', '53' => 'Teeth-53', '52' => 'Teeth-52', '51' => 'Teeth-51'];
                        $child_lower_right_arr = ['85' => 'Teeth-85', '84' => 'Teeth-84', '83' => 'Teeth-83', '82' => 'Teeth-82', '81' => 'Teeth-81'];
                        $child_upper_left_arr = ['61' => 'Teeth-61', '62' => 'Teeth-62', '63' => 'Teeth-63', '64' => 'Teeth-64', '65' => 'Teeth-65'];
                        $child_lower_left_arr = ['71' => 'Teeth-71', '72' => 'Teeth-72', '73' => 'Teeth-73', '74' => 'Teeth-74', '75' => 'Teeth-75'];
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
                    <td width="40%" valign="top" style="border-right: 1px solid; padding: 10px;">


                        @if (isset($chronic_item) && !$chronic_item->isEmpty())
                            <div>
                                <div> <strong>Chronic</strong></div>
                                <ul class="ml-0 pl-4">
                                    @foreach ($chronic_item as $vlaue)
                                        <li> {{ $vlaue->chronic_dis_name }}
                                            {{ $vlaue->chronic_dis_description != '' ? ' ( ' . $vlaue->chronic_dis_description . ' ) ' : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (isset($allergy) && !$allergy->isEmpty())
                            <div>
                                <div><strong>Allergies</strong></div>
                                <ul class="ml-0 pl-4">
                                    @foreach ($allergy as $vlaue)
                                        <li> {{ $vlaue->allergies_name }}
                                            {{ $vlaue->allergies_severity_text != '' ? ' ( ' . $vlaue->allergies_severity_text . ' ) ' : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (isset($left_side_arr['CHIEFCOM']))
                            <div class="mb-2">
                                <u><strong>Chief Complaints</strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['CHIEFCOM'] as $cc_item)
                                        <li>{{ strtoupper($cc_item) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['CLINICHIST']))
                            <div class="mb-2">
                                <u><strong>
                                        @if (Session::get('user.ses_hospital_code') == 'SSG')
                                            Drug history
                                        @else
                                            Clinical History
                                        @endif

                                    </strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['CLINICHIST'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['ICD']))
                            <div class="mb-2">
                                <u><strong>
                                        @if (Session::get('user.ses_hospital_code') == 'SSG')
                                            provisional diagnosis
                                        @else
                                            Confirmatory Diagnosis (ICD)
                                        @endif
                                    </strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['ICD'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['PROVDIAG']))
                            <div class="mb-2">
                                <u><strong> Clinical Examination</strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['PROVDIAG'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        @if (isset($in_arr['INV']))
                            <div class="mb-2">
                                <u><strong>Investigations</strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($in_arr['INV'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (isset($ele_thy_arr['PTET']))

                            <div class="mb-2">
                                <div><strong> Electro Therapy</strong></div>
                                <ul class="mb-5">
                                    @foreach ($ele_thy_arr['PTET'] as $ptet)
                                        @php
                                            $ptet_exp = explode('_', $ptet);
                                            // dd($ptet_exp);
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
                                <ul class="mb-5">
                                    @foreach ($therapiu_therapy_arr['PTTE'] as $ptte)
                                        @php
                                            $ptte_exp = explode('_', $ptte);
                                            // dd($ptte_exp);
                                        @endphp
                                        <li>{{ $ptte_exp[0] }}
                                            <br>
                                            @if ($ptte_exp[1] != 0)
                                                [{{ $ptte_exp[1] }} {{ $ptte_exp[2] }}]
                                            @endif
                                            {{ $ptte_exp[3] ? 'Duration' . ' : ' . $ptte_exp[3] : '' }}
                                        </li>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif

                        @if (isset($left_side_arr['DISEASE']))
                            <div class="mb-2">
                                <u><strong>Diagnosis </strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['DISEASE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($pr_arr['PROCEDURE']))
                            <div class="mb-2">
                                <u><strong>Procedure</strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($pr_arr['PROCEDURE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        @if (isset($left_side_arr['ADVICE']))
                            <div class="mb-2">
                                <u><strong>Advice</strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['ADVICE'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($left_side_arr['DISPOSAL']))
                            <div class="mb-2">
                                @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                    <u><strong>Intervention</strong></u>
                                @else
                                    <u><strong>Disposal</strong></u>
                                @endif

                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['DISPOSAL'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (isset($prescription_mst->note))
                            @if ($prescription_mst->note != '')
                                {{-- <div class="mb-2 mt-20">
							<strong>Note: </strong>{{ $prescription_mst->note }}
						</div> --}}
                                <div class="mb-2">
                                    <u><strong>Note </strong></u>
                                    <ul class="ml-0 pl-4">
                                        <li>{{ $prescription_mst->note }}</li>
                                    </ul>
                                </div>
                            @endif
                        @endif

                        @if (isset($left_side_arr['REFDOC']))
                            <div class="mb-2">
                                <u><strong>Referred To </strong></u>
                                <ul class="ml-0 pl-4">
                                    @foreach ($left_side_arr['REFDOC'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($prescription_mst->next_followup_dt != '')
                            <div class="mb-2 mt-20">
                                <strong>Next Followup:
                                </strong>{{ date('d/m/Y', strtotime($prescription_mst->next_followup_dt)) }}
                                ( After {{ $prescription_mst->followup_num }}
                                {{ $prescription_mst->followup_mu }}{{ $prescription_mst->followup_num > 1 ? 's' : '' }})
                            </div>
                        @endif
                    </td>
                    <td class="text-left pl-2" valign="top">
                        <div class="mb-2">
                            @if (!empty($pres_med))
                                <div class="mt-10">
                                    <table>
                                        @foreach ($pres_med as $key => $med_row_item)
                                            <tr>

                                                <td valign="top" width="30">
                                                    <strong>{{ $loop->iteration }}.</strong>
                                                </td>
                                                <td valign="top">
                                                    <div>{{ !empty($key) ? ucwords($key) : '' }}</div>
                                                    @foreach ($med_row_item as $key1 => $medDt)
                                                        <?php
                                                        $med_exp_dt = explode('^', $key1);
                                                        ?>
                                                        {{-- {{dd($medDt)}} --}}

                                                        {{-- @if (empty($med_exp_dt[6])) --}}
                                                        {{-- <div class="mb-2">&nbsp;&nbsp; &nbsp;&nbsp;
                                                                <strong>
                                                                    @if (empty($med_exp_dt[6]))
                                                                        {{ !empty($med_exp_dt[0]) ? $med_exp_dt[0] : '' }}
                                                                        {{ !empty($med_exp_dt[1]) ? $med_exp_dt[1] : '' }}

                                                                        &nbsp;&nbsp;
                                                                        [
                                                                        {{ !empty($med_exp_dt[2]) ? $med_exp_dt[2] : '' }}
                                                                        {{ !empty($med_exp_dt[3]) ? $med_exp_dt[3] : '' }}
                                                                        ]&nbsp;&nbsp;
                                                                        Qty.
                                                                        {{ !empty($med_exp_dt[4]) ? $med_exp_dt[4] : 0 }}
                                                                        @if (isset($med_exp_dt[5]))
                                                                            @if ($med_exp_dt[5] != '' || $med_exp_dt[5] != 0)
                                                                                ({{ $med_exp_dt[5] }})
                                                                                <strong>{{ !empty($med_exp_dt[6]) || $med_exp_dt[6] == 1 ? ' - Continue' : '' }}</strong>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </strong>
                                                            </div> --}}
                                                        {{-- @endif --}}





                                                        @if (!empty($medDt))
                                                            <div class="mt-10">
                                                                <table>
                                                                    @foreach ($medDt as $multidose)
                                                                        {{-- {{dd($multidose)}} --}}

                                                                        <div class="mb-2">&nbsp;&nbsp; &nbsp;&nbsp;
                                                                            <strong>
                                                                                {{-- @if (empty($med_exp_dt[6])) --}}
                                                                                @if (empty($multidose->multidose_txt))
                                                                                    {{ !empty($multidose->dosage) ? $multidose->dosage : '' }}
                                                                                    {{ !empty($multidose->route) ? $multidose->route : '' }}


                                                                                    &nbsp;&nbsp;
                                                                                    @if (isset($multidose->item_qty))
                                                                                        @if ($multidose->instruction_take != '' || $multidose->instruction_take != 0)
                                                                                            ({{ $multidose->instruction_take }})
                                                                                            <strong>{{ !empty($multidose->continue_ind) || $multidose->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                                                        @endif
                                                                                    @endif

                                                                                    @if ($multidose->duration && $multidose->duration != 'Continue')
                                                                                        &nbsp;&nbsp;
                                                                                        ---------------------
                                                                                        &nbsp;&nbsp; [
                                                                                            @if ($multidose->duration_mu != 'CONTINUE')
                                                                                                {{$multidose->duration}}
                                                                                            @endif
                                                                                            {{ !empty($multidose->duration_mu) ? $multidose->duration_mu : '' }}

                                                                                        ]&nbsp;&nbsp;
                                                                                    @endif

                                                                                    {{-- Qty. --}}
                                                                                    {{-- {{ !empty($multidose->item_qty) ? $multidose->item_qty : '' }} --}}
                                                                                @endif
                                                                            </strong>
                                                                        </div>




                                                                        <?php
                                                                        $multidose_data = explode(',', $multidose->multidose_txt);
                                                                        ?>

                                                                        @if (!empty($multidose_data))
                                                                            @foreach ($multidose_data as $data)
                                                                                <?php
                                                                                $exp_multidose_data = explode('~', $data);
                                                                                ?>

                                                                                <tr>
                                                                                    <td valign="top" width="30">
                                                                                        <strong>{{ !empty($exp_multidose_data[0]) ? 'ডোজ-' . $loop->iteration . '.' : '' }}</strong>
                                                                                    </td>
                                                                                    <td valign="top">
                                                                                        <div class="mb-2">
                                                                                            &nbsp;&nbsp;
                                                                                            &nbsp;&nbsp;
                                                                                            <strong>
                                                                                                {{ !empty($exp_multidose_data[0]) ? $exp_multidose_data[0] : '' }}
                                                                                                &nbsp;&nbsp;
                                                                                                @if (!empty($exp_multidose_data[0]))
                                                                                                    [
                                                                                                    {{ !empty($exp_multidose_data[1]) ? $exp_multidose_data[1] : '' }}
                                                                                                    {{ !empty($exp_multidose_data[2]) ? $exp_multidose_data[2] : '' }}
                                                                                                    ]&nbsp;&nbsp;

                                                                                                    Qty.
                                                                                                    {{ !empty($exp_multidose_data[3]) ? $exp_multidose_data[3] : '' }}
                                                                                                    @if (isset($exp_multidose_data[5]))
                                                                                                        @if ($exp_multidose_data[5] != '' || $exp_multidose_data[5] != 0)
                                                                                                            ({{ $exp_multidose_data[5] }})
                                                                                                        @endif
                                                                                                    @endif
                                                                                                @endif

                                                                                            </strong>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        @endif
                                                </td>

                                            </tr>
                                        @endforeach
                            @endforeach
            </table>
        </div>
        @endif
        @if (isset($prescription_mst->eye_ind))
            @if ($prescription_mst->eye_ind == 1)
                <div class="mt-4">
                    @if (!empty($ocular_exam_right_arr) || !empty($ocular_exam_left_arr))
                        <strong>Ocular Examination</strong>
                    @endif
                    <table width="100%">
                        <tr>
                            <td style="width: 50%">
                                @if (!empty($ocular_exam_right_arr))
                                    <strong>Right Eye</strong>
                                    @foreach ($ocular_exam_right_arr as $key => $right_rows)
                                        <div>{{ $key }}</div>
                                        <ul class="ml-0 pl-4 mb-1">
                                            @foreach ($right_rows as $rows)
                                                <li>{{ $rows }}</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if (!empty($ocular_exam_left_arr))
                                    <strong>Left Eye</strong>
                                    @foreach ($ocular_exam_left_arr as $key => $left_rows)
                                        <div>{{ $key }}</div>
                                        <ul class="ml-0 pl-4 mb-1">
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
</div>
</td>
</tr>
</table>
</div>
<div class="modal-footer mt-2">


    @if ($prescription_mst->eye_ind == 1)
        <a href="{{ route('opd_prescription_print_pdf', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-primary btn-md" target="_blank" data-id="{{ $prescription_mst->prescription_no_pk }}"
            title="Print Ocular Examination Prescription"><i class="fas fa-print"></i> Ocular Examination
            Print</a>
        <a href="{{ route('prescription-print-specticles-pdf', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-success btn-md" target="_blank" data-id="{{ $prescription_mst->prescription_no_pk }}"
            title="Print Specticles Prescription"><i class="fas fa-print"></i> Eye Specticles Print</a>
    @else
        <a href="{{ route('opd_prescription_print_pdf', $prescription_mst->prescription_no_pk) }}"
            class="btn btn-primary btn-md" target="_blank" data-id="{{ $prescription_mst->prescription_no_pk }}"
            title="Print Prescription"><i class="fas fa-print"></i> Print</a>
    @endif


    <button class="btn btn-danger btn-md" data-dismiss="modal"> Close </button>
</div>
</section>
</div>
