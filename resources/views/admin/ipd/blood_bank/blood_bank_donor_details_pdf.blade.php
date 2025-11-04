<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 0px 2px 0px 10px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        }

        body {
            /* margin-bottom: 2.8cm; */
            font-family: 'Roboto', sans-serif;
            color: black;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
        }

        .signature {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 6.7cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            margin-top: 10px;
        }
    </style>
</head>
<header>
    <table width="100%">
        <tr>
            <td style="width: 15%;">
                @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60px" />
                @endif
            </td>
            <td>
                <span style="font-size: 13px;">
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong>
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                </span>
            </td>
        </tr>
    </table>
    <div style="text-align: center;font-size: 15px; font-style:bold">

        <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px;margin-top:10px; width: 45%; font-size:15px; border-radius: 15px; background-color:E9E8E8">
            <strong>Medical Assessment of Blood Donor</strong>
        </p>
    </div>

    <div class="" style=" height: 150px; padding: 10px;  font-size:13px !important">
        <p>
            <strong>Knowledge of blood donors : </strong>
        <ol>
            <li> Have you ever received unscreened blood or blood components? =  <strong>{{ $blood_requisition_dtl_data->rec_unscr_bld}}</strong></li>
            <li> Are you used to taking any narcotic or intravenous drugs? = <strong>{{ $blood_requisition_dtl_data->taking_narcotic_inta_drg}}</strong></li>
            <li> Does your informant have sexual intercourse habits? = <strong>{{ $blood_requisition_dtl_data->sexual_interc_habits}}</strong></li>
        </ol>
        If any of the above reasons apply, you should contact yourself to donate blood that is harmful to the sexually transmitted disease HIV (AIDS)/Hepatitis. Remember the blood will be your own.
        </p>

    </div>
</header>
<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>
    <div class="" style=" border-top: 1px solid black;">
        <span style="">printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
        <span>Powered By: NEXTGEN IT</span>
    </div>
</footer>

<body>
    <table class="" style="font-size:12px !important;width:100%;border:#000 1px solid">
        <tbody>
            @if (isset($blood_requisition_dtl_data))
            <tr>
                <td class="text-left" style="width: 150px;"> <strong>Name</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->donor_name }}</td>
                <td class="text-left" style="width: 165px;"> <strong> Father's/Housbend Name</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->fatherorhousbend_name}} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Age</strong></td>
                <td class="text-left"> : {{ $blood_requisition_dtl_data->age !=""?  $blood_requisition_dtl_data->age .'  Year':'' }}</td>
                <td class="text-left" style="width: 165px;"> <strong> Gender</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->donor_gender  }} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Marital Status</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->marital_status }}</td>
                <td class="text-left" style="width: 165px;"> <strong> Profession</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->donor_professionP}} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Mobile</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->donor_mobile}} </td>
                <td class="text-left" style="width: 165px;"> <strong> Last Blood donat Date</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->last_blood_donat_date }}</td>
            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Address</strong></td>
                <td class="text-left" colspan="3">: {{ $blood_requisition_dtl_data->donor_address}}</td>

            </tr>
            @endif
        </tbody>
    </table>
    <table class="" style="font-size:11px !important;width:100%;margin-top:10px" border="1">
        <thead>
            <tr>
                <th>Have you previously or currently been infected?</th>
                <th style="width: 10px;">Answer</th>
                <th>What is yours currently?</th>
                <th style="width: 10px;">Answer</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="p-2">Hepatitis (Jaundice)</td>
                @php $font_bold_hep_jaundice=$blood_requisition_dtl_data->hep_jaundice =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_hep_jaundice; ?>"> {{$blood_requisition_dtl_data->hep_jaundice}}</td>
                <td class="p-2">Abortion Occurred</td>
                @php $font_bold_abortion_occurred=$blood_requisition_dtl_data->abortion_occurred =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_abortion_occurred ?>"> {{$blood_requisition_dtl_data->abortion_occurred }}</td>
            </tr>
            <tr>
                <td class="p-2">Malaria</td>
                @php $font_bold_malaria=$blood_requisition_dtl_data->malaria =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_malaria ?>">{{$blood_requisition_dtl_data->malaria }}</td>
                <td class="p-2">Recent Weight Loss
                    @php $font_bold_rec_wt_loss=$blood_requisition_dtl_data->rec_wt_loss =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_rec_wt_loss ?>">{{$blood_requisition_dtl_data->rec_wt_loss}}</td>
            </tr>
            <tr>
                <td class="p-2">Rabies</td>
                @php $font_bold_rabies=$blood_requisition_dtl_data->rabies =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_rabies ?>">{{$blood_requisition_dtl_data->rabies}}</td>
                <td class="p-2">Currently Pregnant</td>
                <td class="p-2 text-center"> {{$blood_requisition_dtl_data->currently_pregnant}}</td>
            </tr>
            <tr>
                <td class="p-2">Heart Disease</td>
                @php $font_bold_heart_disease=$blood_requisition_dtl_data->heart_disease =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_heart_disease ?>">{{$blood_requisition_dtl_data->heart_disease}}</td>
                <td class="p-2">Breastfeeding Mother
                    @php $font_bold_breastfeeding_mother=$blood_requisition_dtl_data->breastfeeding_mother =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_breastfeeding_mother ?>">{{$blood_requisition_dtl_data->breastfeeding_mother}}</td>
            </tr>
            <tr>
                <td class="p-2">Diabetes (Polyuria)
                    @php $font_bold_diabetes_polyuria=$blood_requisition_dtl_data->diabetes_polyuria =='Yes' ? 'font-weight: bold;':''; @endphp
                </td>
                <td class="p-2 text-center" style=" <?php echo $font_bold_diabetes_polyuria ?>  ">{{$blood_requisition_dtl_data->diabetes_polyuria }}</td>
                <td class="p-2">Menstruating Within
                    @php $font_bold_mens_w_sixm=$blood_requisition_dtl_data->mens_w_sixm =='Yes' ? 'font-weight: bold;':''; @endphp 6 Months</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_mens_w_sixm ?>">{{$blood_requisition_dtl_data->mens_w_sixm }}</td>
            </tr>
            <tr>
                <td class="p-2">Sexually Transmitted Infections</td>
                <td class="p-2 text-center">{{ $blood_requisition_dtl_data->sex_trans_infec}}</td>
                <td class="p-2">Undergone Major Surgery Within 4 Weeks
                    @php $font_bold_undergone_msw_fourw=$blood_requisition_dtl_data->undergone_msw_fourw =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_undergone_msw_fourw ?>">{{$blood_requisition_dtl_data->undergone_msw_fourw}}</td>
            </tr>
            <tr>
                <td class="p-2">Asthma/Shortness of Breath</td>
                <td class="p-2 text-center">{{ $blood_requisition_dtl_data->asthma }}</td>
                <td class="p-2">Removed a Tooth Witin 4 Weeks
                    @php $font_bold_removed_tooth_wfw=$blood_requisition_dtl_data->removed_tooth_wfw =='Yes' ? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bold_removed_tooth_wfw ?>">{{$blood_requisition_dtl_data->removed_tooth_wfw }}</td>
            </tr>
            <tr>
                <td class="p-2">Eczema (Skin Disease)</td>
                @php $font_bd_eczema_skin_dis=$blood_requisition_dtl_data->eczema_skin_dis =='Yes'? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bd_eczema_skin_dis ?>"> {{$blood_requisition_dtl_data->eczema_skin_dis}}</td>
                <td class="p-2">Received a Vaccine or Injection
                    @php $font_bold_received_vac_or_inj=$blood_requisition_dtl_data->received_vac_or_inj =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_received_vac_or_inj ?>">{{$blood_requisition_dtl_data->received_vac_or_inj}}</td>
            </tr>
            <tr>
                <td class="p-2">High Blood Pressure (Hypertension)
                    @php $font_bold_hypertension=$blood_requisition_dtl_data->hypertension =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_hypertension ?>">{{$blood_requisition_dtl_data->hypertension}}</td>
                <td class="p-2">Donated Blood or Blood Components Within 1 Week
                    @php $font_bd_donated_blood_wow=$blood_requisition_dtl_data->donated_blood_wow =='Yes'? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bd_donated_blood_wow ?>"> {{$blood_requisition_dtl_data->donated_blood_wow }}</td>
            </tr>
            <tr>
                <td class="p-2">Kidney Disease</td>
                @php $font_bold_kidney_disease=$blood_requisition_dtl_data->kidney_disease =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_kidney_disease ?>">{{$blood_requisition_dtl_data->kidney_disease}}</td>
                <td class="p-2">Taken Aspirin or Similar Medication
                    @php $font_bold_taken_aspirin_or_sm=$blood_requisition_dtl_data->taken_aspirin_or_sm =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style=" <?php echo $font_bold_taken_aspirin_or_sm ?>">{{$blood_requisition_dtl_data->taken_aspirin_or_sm }}</td>
            </tr>
            <tr>
                <td class="p-2">Tuberculosis (TB)</td>
                @php $font_bold_tuberculosis_tb=$blood_requisition_dtl_data->tuberculosis_tb =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_tuberculosis_tb ?>">{{$blood_requisition_dtl_data->tuberculosis_tb }}</td>
                <td class="p-2">Substance Abuse</td>
                @php $font_bold_substance_abuse=$blood_requisition_dtl_data->substance_abuse =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_substance_abuse ?>">{{$blood_requisition_dtl_data->substance_abuse}}</td>
            </tr>
            <tr>
                <td class="p-2">Piles</td>
                @php $font_bold_piles=$blood_requisition_dtl_data->piles =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_piles ?>">{{$blood_requisition_dtl_data->piles}}</td>
                <td class="p-2">Consumed Any Intoxicating Substance/Drugs
                    @php $font_bold_con_intoxic_subordrugs=$blood_requisition_dtl_data->con_intoxic_subordrugs =='Yes' ? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bold_con_intoxic_subordrugs ?>">{{$blood_requisition_dtl_data->con_intoxic_subordrugs}}</td>
            </tr>
            <tr>
                <td class="p-2">Cancer</td>
                @php $font_bold_cancer=$blood_requisition_dtl_data->cancer =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_cancer ?>">{{$blood_requisition_dtl_data->cancer}}</td>
                <td class="p-2">Traveled Abroad</td>
                @php $font_bold_traveled_abroad=$blood_requisition_dtl_data->traveled_abroad =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_traveled_abroad ?>">{{$blood_requisition_dtl_data->traveled_abroad}}</td>
            </tr>
            <tr>
                <td class="p-2">Peptic Ulcer</td>
                @php $font_bold_peptic_ulcer=$blood_requisition_dtl_data->peptic_ulcer =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_peptic_ulcer ?>">{{$blood_requisition_dtl_data->peptic_ulcer}}</td>
                <td class="p-2">Currently Taking Any Medication
                    @php $font_bold_currently_tam=$blood_requisition_dtl_data->currently_tam =='Yes' ? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bold_currently_tam ?>">{{$blood_requisition_dtl_data->currently_tam }}</td>
            </tr>
            <tr>
                <td class="p-2">Typhoid</td>
                @php $font_bold_typhoid=$blood_requisition_dtl_data->typhoid =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_typhoid ?>">{{$blood_requisition_dtl_data->typhoid }}</td>
                <td class="p-2">Regularly Interested in Voluntary Blood Donation
                    @php $font_bold_reg_interested_vbd=$blood_requisition_dtl_data->reg_interested_vbd =='Yes' ? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bold_reg_interested_vbd ?>">{{$blood_requisition_dtl_data->reg_interested_vbd}}</td>
            </tr>
            <tr>
                <td class="p-2">Viral Fever</td>
                @php $font_bold_viral_fever=$blood_requisition_dtl_data->viral_fever =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_viral_fever ?>">{{$blood_requisition_dtl_data->viral_fever }}</td>
                <td class="p-2">Currently Feeling Healthy
                    @php $font_bd_currently_fh=$blood_requisition_dtl_data->currently_fh =='Yes'? 'font-weight: bold;':''; @endphp </td>
                <td class="p-2 text-center" style="<?php echo $font_bd_currently_fh ?>"> {{$blood_requisition_dtl_data->currently_fh }}</td>
            </tr>
            <tr>
                <td class="p-2">Syphilis</td>
                @php $font_bold_syphilis=$blood_requisition_dtl_data->syphilis =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_syphilis ?>">{{$blood_requisition_dtl_data->syphilis}}</td>
                <td class="p-2">Consumed Food</td>
                @php $font_bold_consumed_food=$blood_requisition_dtl_data->consumed_food =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_consumed_food ?>">{{$blood_requisition_dtl_data->consumed_food}}</td>
            </tr>
            <tr>
                <td class="p-2">Gastric Ulcer</td>
                @php $font_bold_gastric_ulcer=$blood_requisition_dtl_data->gastric_ulcer =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_gastric_ulcer ?>">{{$blood_requisition_dtl_data->gastric_ulcer}}</td>
                <td class="p-2">Had an Accident/Injury
                    @php $font_bold_had_accidnt_injury=$blood_requisition_dtl_data->had_accidnt_injury =='Yes' ? 'font-weight: bold;':''; @endphp</td>
                <td class="p-2 text-center" style="<?php echo $font_bold_had_accidnt_injury ?>">{{$blood_requisition_dtl_data->had_accidnt_injury}}</td>
            </tr>
            <tr>
                <td class="p-2">Bloodborne Diseases
                    @php $font_bold_bloodborne_diseases=$blood_requisition_dtl_data->bloodborne_diseases =='Yes' ? 'font-weight: bold;':''; @endphp
                </td>
                <td class="p-2 text-center" style="<?php echo $font_bold_bloodborne_diseases ?>">{{$blood_requisition_dtl_data->bloodborne_diseases}}</td>
                <td class="p-2 text-center"></td>
                <td class="p-2 text-center"></td>
            </tr>
            <tr>
                <td class="p-2">Dengue Fever</td>
                @php $font_bold_dengue_fever=$blood_requisition_dtl_data->dengue_fever =='Yes' ? 'font-weight: bold;':''; @endphp
                <td class="p-2 text-center" style="<?php echo $font_bold_dengue_fever ?>">{{$blood_requisition_dtl_data->dengue_fever }}</td>
                <td class="p-2 text-center"></td>
                <td class="p-2 text-center"></td>
            </tr>
            <tr>
                <td class="p-2">Measles/Mumps</td>
                <td class="p-2 text-center">{{$blood_requisition_dtl_data->measlesormumps}}</td>
                <td class="p-2 text-center"></td>
                <td class="p-2 text-center"></td>
            </tr>
        </tbody>
    </table>
</body>
<div style="page-break-after: always;"></div>
<header>
    <table width="100%">
        <tr>
            <td style="width: 15%;">
                @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60px" />
                @endif
            </td>
            <td>
                <span style="font-size: 13px;">
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong>
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                </span>
            </td>
        </tr>
    </table>
    <div style="text-align: center;font-size: 15px; font-style:bold">

        <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px;margin-top:10px; width: 45%; font-size:15px; border-radius: 15px; background-color:E9E8E8">
            <strong>Physical fitness of the blood donor</strong>
        </p>
    </div>

</header>

<body>
    @if (isset($blood_requisition_dtl_data))
    <table class="" style="font-size:12px !important;width:100%; margin-top:10px; border:#000 1px solid; border-radius:10px">
        <tbody>

            <tr>
                <td class="text-left" style="width: 110px;"> <strong>Hemoglobin</strong></td>
                <td class="text-left" style="width:200px;">: {{ $blood_requisition_dtl_data->hemoglobin !="" ? $blood_requisition_dtl_data->hemoglobin .' (g/dL%)':'' }} </td>
                <td class="text-left" style="width: 110px;"> <strong> Age</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->age !="" ? $blood_requisition_dtl_data->age . ' year':''}} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 110px;"> <strong> Weight</strong></td>
                <td class="text-left" style="width:200px;"> : {{ $blood_requisition_dtl_data->donor_weight !="" ? $blood_requisition_dtl_data->donor_weight.' (Kg)':'' }} </td>
                <td class="text-left" style="width: 110px;"> <strong> BP</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->bp !="" ? $blood_requisition_dtl_data->bp.'  (Millimeter Mercury)' :'' }} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 110px;"> <strong> Pulse</strong></td>
                <td class="text-left" style="width:200px;">: {{ $blood_requisition_dtl_data->pulse !="" ? $blood_requisition_dtl_data->pulse.' (Every Minute)':'' }} </td>
                <td class="text-left" style="width: 110px;"> <strong> Temparture</strong></td>
                <td class="text-left">: {{ $blood_requisition_dtl_data->temparture !="" ? $blood_requisition_dtl_data->temparture .' (°Celsius/Fahrenheit)' :''}} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 110px;"> <strong> Blood Group</strong></td>
                <td class="text-left" style="width:200px;">: {{ $blood_requisition_dtl_data->blood_group}} </td>
                <td class="text-left" style="width: 110px;"> </td>
                <td class="text-left"> </td>
            </tr>

        </tbody>
    </table>
    @endif
    <p style='font-size:12px !important;'>
        <strong> For donating blood   </strong> <strong style="padding-left: 15px;">:</strong>
        @if($blood_requisition_dtl_data->is_selected_donate =='Yes')
        <strong> Selected </strong>
        @elseif($blood_requisition_dtl_data->is_selected_donate =='No')
        <strong> Rejected </strong>
        @endif
        <!-- <br>
        <strong>Date </strong><strong style="padding-left: 103px;">: {{date('d/m/Y')}}</strong> -->
    </p>
    @if (isset($blood_requisition_dtl_data))
    <table class="" style="font-size:12px !important;width:100%; margin-top:10px;padding-top:30px">
        <tbody>
            <tr>
                <td class="text-left" style="width: 60%"></td>
                <td style="text-align:center;vertical-align:bottom;padding-top:35px">
                    <p>  <?php echo $blood_requisition_dtl_data->doctor_signature; ?></p>
                </td>
            </tr>
        </tbody>
    </table>
    @endif
    <div>
        <p style="text-align: center; font-size:15px"> <strong> Blood donation consent form: </strong></p>
        <p style="font-size: 13px;">I am willing to donate blood consciously and voluntarily after reading the form. Giving permission for my blood to undergo AIDS and other necessary tests. I voluntarily donated blood in the blood donation program of National Blood Transfusion Services after knowing all the issues related to blood donation. In case of any complication after blood donation, the person or institution responsible for this institution will not be responsible. This blood can be used for any patient whenever needed.</p>
    </div>
    <div style="display: inline-block;font-size:13px;font-weight: bold;padding-top:100px;Width:50%"><span> Code No : {{$blood_requisition_dtl_data->blood_requisition_no_fk}} </span></div>
    <div style="display: inline-block;font-size:13px;font-weight: bold;padding-top:100px;text-align:right;Width:50%;"><span style="border-top:#000 1px solid;margin-right:100px;">{{$blood_requisition_dtl_data->donor_name}} </span></div>
</body>

</html>