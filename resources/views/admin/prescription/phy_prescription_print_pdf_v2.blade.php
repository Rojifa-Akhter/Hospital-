
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
    
    <header style="width:100%">
        <table style="width: 100%;" class="signature">
            <tr style="">
                {{-- <td style="width: 10%;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $company_details->logo) }}"
                        style="background-color: {{ $company_details->logo_background_color }}; width:120px; padding-right:15px"
                        alt=""> --}}
                </td>
                <td style="text-align:left;">
                    {{-- <span style="font-size: 15px;"> <strong>
                            {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($company_details->telephone1) ? $company_details->telephone1 : '' }}</span> --}}
                </td>
            </tr>
        </table>
    </header>


    <section style="margin-top: 3cm">
        
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
                                        <li>{{ ucfirst(strtolower($cc_item)) }}</li>
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
                                <div>
                                    <strong>Confirmatory Diagnosis / Provisional diagnosis(ICD)</strong>
                                </div>
                                <ul class="mb-5 ml-20">
                                    @foreach ($left_side_arr['ICD'] as $cc_item)
                                        <li>{{ $cc_item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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

                        <div>
                            @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                <div><strong>Intervention</strong></div>
                            @else
                                <div><strong>Disposal</strong></div>
                            @endif
                            <ul class="mb-5 ml-20">
                                <li>{{ $prescription_mst->disposal }}</li>
                            </ul>
                        </div>

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
                                     <li>{{ ucfirst(strtolower($cc_item)) }}</li> 
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
                        
                        @if (!$prescription_med->isEmpty())
                        <div class="mb-2">
                            <div><strong>Medicine </strong></div>
                            <table>
                                @php $i=1; @endphp
                                @foreach ($prescription_med as $med_row_item)
                                    <tr class="mt-5">
                                        <td valign="top" width="20">{{ $i }}.</td>
                                        <td valign="top" style="padding-bottom: 10px;">
                                            {{ $med_row_item->brand_name }}
                                            <div><small>
                                                    {{ $med_row_item->route }}
                                                    {{ $med_row_item->dosage }}
                                                    @if ($med_row_item->continue_ind != 1)
                                                        [
                                                        {{ $med_row_item->duration }}
                                                        {{ $med_row_item->duration_mu }} ]
                                                    @endif
                                             
                                                    @if (isset($med_row_item->instruction_take))
                                                        @if ($med_row_item->instruction_take != '' || $med_row_item->instruction_take != 0)
                                                            ({{ $med_row_item->instruction_take }})
                                                            <strong>{{ $med_row_item->continue_ind == 1 ? ' - Continue' : '' }}</strong>
                                                        @endif
                                                    @endif
                                                </small></div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </table>
                        </div>
                    @endif

                    @if (isset($acup_thy_arr['ACUP']))
                    <div class="mb-2" style="padding-left: 3px;">
                        <div><strong> Modern Traditional Chinese Medicine(TCM): </strong></div>
                        <ul class="mb-5" style="margin-left: 20px;">
                            @foreach ($acup_thy_arr['ACUP'] as $ptet)
                                @php
                                    $ptet_exp = explode('_', $ptet);
                                @endphp
                                <li>{{ $ptet_exp[0] }}
                                    @php
                                        if ($ptet_exp[5] || $ptet_exp[6]) {
                                            echo '<br>';
                                            echo $ptet_exp[5] ? 'Frequency' . ' : ' . $ptet_exp[5] : '';
                                            echo $ptet_exp[7] ? ' Repetition' . ' : ' . $ptet_exp[7] : '';
                                            echo $ptet_exp[6] ? '&nbsp&nbspMode' . ' : ' . $ptet_exp[6] : '';
                                        }
                                        if ($ptet_exp[1] || $ptet_exp[4] || $ptet_exp[2]) {
                                            echo '<br>';
                                            if ($ptet_exp[1] != 0) {
                                                echo $ptet_exp[1] ? ' Unit/Intensity' . ' : ' . $ptet_exp[1] : '';
                                            }
                                            echo $ptet_exp[4] ? '&nbsp&nbspDuration' . ' : ' . $ptet_exp[4] . '&nbsp' . $ptet_exp[2] : '';
                                            echo $ptet_exp[8] ? '&nbsp&nbspSession/Days' . ' : ' . $ptet_exp[8] : '';
                                        }
                                    @endphp
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (isset($ele_thy_arr['PTET']))
                        <div class="mb-2"  style="padding-left: 3px;">
                            <div><strong> Electro Therapy</strong></div>
                            <ul class="mb-5" style="margin-left: 20px;">
                                @foreach ($ele_thy_arr['PTET'] as $ptet)
                                    @php
                                        $ptet_exp = explode('_', $ptet);
                                    @endphp
                                    <li>{{ $ptet_exp[0] }}
                                        @php
                                            if ($ptet_exp[5] || $ptet_exp[6]) {
                                                echo '<br>';
                                                echo $ptet_exp[5] ? 'Frequency' . ' : ' . $ptet_exp[5] : '';
                                                echo $ptet_exp[6] ? '&nbsp&nbspMode' . ' : ' . $ptet_exp[6] : '';
                                                echo $ptet_exp[7] ? '&nbsp&nbspArea/location' . ' : ' . $ptet_exp[7] : '';
                                            }
                                            if ($ptet_exp[1] || $ptet_exp[4] || $ptet_exp[2]) {
                                                echo '<br>';
                                                if ($ptet_exp[1] != 0) {
                                                    echo $ptet_exp[1] ? ' Unit/Intensity' . ' : ' . $ptet_exp[1] : '';
                                                }
                                                echo $ptet_exp[4] ? '&nbsp&nbspDuration' . ' : ' . $ptet_exp[4] . '&nbsp' . $ptet_exp[2] : '';
                                                echo $ptet_exp[8] ? '&nbsp&nbspSession/Days' . ' : ' . $ptet_exp[8] : '';
                                            }
                                        @endphp
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($therapiu_therapy_arr['PTTE']))
                        <div class="mb-2"  style="padding-left: 3px;">
                            <div><strong> Therapeutic Exercise</strong></div>
                            <ul class="mb-5" style="margin-left: 20px;">
                                @foreach ($therapiu_therapy_arr['PTTE'] as $ptte)
                                    @php
                                        $ptte_exp = explode('_', $ptte);
                                    @endphp
                                    <li>{{ $ptte_exp[0] }}
                                        @php
                                            if ($ptte_exp[5] || $ptte_exp[6]) {
                                                echo '<br>';
                                                echo $ptte_exp[5] ? 'Frequency' . ' : ' . $ptte_exp[5] : '';
                                                echo $ptte_exp[6] ? '&nbsp&nbspMode' . ' : ' . $ptte_exp[6] : '';
                                                echo $ptte_exp[7] ? '&nbsp&nbspRepetition' . ' : ' . $ptte_exp[7] : '';
                                            }
                                            if ($ptte_exp[1] || $ptte_exp[4] || $ptte_exp[2]) {
                                                echo '<br>';
                                                if ($ptte_exp[1] != 0) {
                                                    echo $ptte_exp[1] ? ' Unit/Intensity' . ' : ' . $ptte_exp[1] : '';
                                                }
                                                echo $ptte_exp[3] ? '&nbsp&nbspDuration' . ' : ' . $ptte_exp[3] . '&nbsp' . $ptte_exp[2] : '';
                                                echo $ptte_exp[8] ? '&nbsp&nbspSession/Days' . ' : ' . $ptte_exp[8] : '';
                                            }
                                        @endphp
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (isset($vitals->outcome_measurement))
                        <div class="mb-2"  style="padding-left: 3px;">
                            <div><strong>Outcome Measurement</strong></div>
                            <p class="mb-5" style="margin-left: 20px;">
                                {{ $vitals->outcome_measurement }}
                            </p>
                        </div>
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