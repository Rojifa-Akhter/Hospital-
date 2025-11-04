
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
                                        <li>{{ strtoupper($cc_item) }}</li>
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
                                                                            {{ !empty($multidose->dosage) ? $multidose->dosage : '' }} {{ !empty($multidose->route) ? '- ' . strtoupper($multidose->route) . ' -' : '' }}
                                                                            
                                                                            @if (isset($multidose->instruction_take))
                                                                                @if ($multidose->instruction_take != '0')
                                                                                        ({{ strtoupper($multidose->instruction_take) }})
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