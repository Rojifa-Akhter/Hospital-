@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    $specimen_name = $hospital->hospital_code == 'GMC' ? 'Source Of Specimen' : 'Sample';
    $nature_of_examination = $hospital->hospital_code == 'GMC' ? 'Nature Of Examination' : 'Test';
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Histopathology Report</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
        .footer_2 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 8cm;
            vertical-align: text-top;
            padding-bottom: 15px;
            /* text-align: center; */
            /* font-size: 9px; */
        }
        .footer_3 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2.2cm;
            vertical-align: text-bottom;
            padding-bottom: 15px;
            /* text-align: center; */
            /* font-size: 9px; */
        }
    </style>

</head>

<body>

    @if ($po_hospital_details->report_header_image_prshde_ind == 1)

        <table style="width: 100%;" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                <tr>
                    <td style="width: 10%;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px "
                            alt="">
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="text-align: center ">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                            width="250" alt="">
                    </td>
                </tr>
            @endif
        </table>

    @endif

    <table style="width: 100%;border-collapse:collapse;margin-top:113px;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table width="100%" style="padding: 0px; margin:0px">
                        <tr>
                            <td style="text-align:left" width="30%">
                                <img style="" src="data:image/png;base64, {{ $invoice_varcode }} "
                                    style="width: 120px; " /> <br>
                                <strong>Invoice ID</strong>: {{ $report_header->invoice_code }}

                            </td>

                            <td style="text-align:center" width="40%"> <img style=""
                                    src="data:image/png;base64, {{ $patient_varcode }} " style="width: 120px; " />
                                <br>
                                <strong>Patient ID</strong>: {{ $report_header->patient_code }}
                            </td>
                             {{-- Duplicate print --}}
                            @if(!is_null($report_header->result_print_key_ind) && $report_header->result_print_key_ind == 1)
                                <td style="text-align:left; color:blue; font-weight:bold; font-size:16px; width:15%;">
                                    DUPLICATE
                                </td>
                            @endif
                            <td style="text-align: center"> </td>
                            <td style="text-align: right" width="30%">

                                <img style="" src="data:image/png;base64, {{ $report_varcode }} "
                                    style="width: 120px; " />
                                <br>
                                <strong>Report ID</strong>: {{ $report_header->report_code }}
                            </td>
                        </tr>
                    </table>
                    <table
                        style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px; margin-bottom:5px !important;font-size:14px">
                        <tr>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Patient Name</strong>
                            </td>
                            <td width="25%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                : {{ $report_header->patient_name }}
                            </td>

                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Age </strong>
                            </td>
                            {{-- {{ dd($report_header->age) }} --}}


                            <?php
                            $explode_age = '';
                            if ($report_header->age != '') {
                                $str_age = $report_header->age;
                                $explode_age = explode(',', $str_age);
                            }
                            ?>
                            {{-- {{ dd($explode_age) }} --}}

                            <td width="25%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{-- {{ $report_header->age != '' ? " : $report_header->age" : '' }} --}}

                                {{-- {{ $explode_age[0] != '' ? ": $explode_age[0]" : '' }}
                            {{ $explode_age[1] != '' && $explode_age[0] == ' ' ? "$explode_age[1]" : '' }}
                            {{ $explode_age[1] != '' && $explode_age[0] != '' ? ",$explode_age[1]" : '' }}
                            {{ $explode_age[2] != '' ? ",$explode_age[2]" : '' }} --}}
                                {{ !empty($explode_age[0]) ? ": $explode_age[0]" : '' }}

                                {{ !empty($explode_age[1]) && !empty($explode_age[0]) ? "$explode_age[1]" : '' }}
                                {{ !empty($explode_age[2]) ? "$explode_age[2]" : '' }}


                            </td>

                            <td class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Gender </strong>
                            </td>
                            <td width="25%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                {{ $report_header->gender_txt != '' ? " :  $report_header->gender_txt" : '' }}
                            </td>

                        </tr>
                        <tr>
                            <td width="20%" class="text-left" style=" padding-left:5px;padding-right:5px;">
                                <strong>Ref By</strong>
                            </td>
                            <td class="text-left" style=" padding-left:5px;padding-right:5px;" colspan="5">
                                {{ $report_header->ref_doc_name != '' ? " : $report_header->ref_doc_name" : '' }}
                                {{ $report_header->ref_doc_name_degree1 != '' ? ", $report_header->ref_doc_name_degree1" : '' }}
                                {{ $report_header->ref_doc_name_degree2 != '' ? ", $report_header->ref_doc_name_degree2" : '' }}
                                {{ $report_header->ref_doc_name_degree3 != '' ? ", $report_header->ref_doc_name_degree3" : '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="">
                <td>
                    
                    <table
                        style="width: 100%; border:1px solid #999;border-collapse: separate; border-radius: 10px;margin-bottom:3px !important; font-size:13px">

                        <tr>
                            <td class="text-left" style="">
                                <strong>{{ $nature_of_examination }} </strong>
                            </td>
                            <td width="25%" class="text-left" style="">
                                {{ $report_header->report_test_name_list != '' ? " :  $report_header->report_test_name_list" : '' }}
                            </td>

                            <td class="text-left" style=" width:10%;">
                                <strong>LAB Code</strong>
                            </td>
                            <td width="14%" class="text-left" style="">
                                {{ $report_header->lab_code != 0 ? " : $report_header->lab_code" : '' }}
                            </td>

                            <td class="text-left" style="width:15%;">
                                <strong>Invoice Date </strong>
                            </td>
                            <td width="20%" class="text-left" style=" text-align:left !impotant;">
                                {{ !empty($report_header->order_date) ? ': ' . date('d/m/Y', strtotime($report_header->order_date)) : '' }}
                            </td>
                        </tr>
                        <tr>


                            <td class="text-left" style=" text-align:left !important;">
                                <strong>Collection Date </strong>
                            </td>
                            <td width="25%" class="text-left" colspan="3" style=" ">
                                {{ !empty($report_header->sc_sample_coll_keyed_time) ? ': ' . date('d/m/Y H:i a', strtotime($report_header->sc_sample_coll_keyed_time)) : '' }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    <p style="text-align: center; margin:0px !important;padding: 2px; font-size:17px !important;">
                    <strong> {{$report_header->histro_report_header}}</strong>
                     </p>                 
                
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span style="font-size:14px !important; ">
                        @if ($po_hospital_details->hospital_code != 'IMPERIAL')
                            <div style="font-size: 16px">  
                                <strong>Lab ID No </strong>
                                    {{ $report_header->histro_lab_id != '' ? " :  $report_header1->histro_lab_id" : '' }}
                            
                            </div>
                            <div style="font-size: 16px">
                                <strong>Specimen </strong>
                                {{ $report_header1->sam_name != '' ? " :  $report_header1->sam_name" : '' }}
                            </div>
                        @else
                            
                        @endif
                        <?php echo $report_header->note_text_clob; ?>
                    </span>
                </td>
            </tr>
        </tbody>

    
    </table>
    <table width="100%">
   
            <tr>
                <td style="width: 100%; " colspan="12">
                    @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
                        <table style="width: 95%; font-size: 11px; " class="footer_2">
                            <tr>
                                <td width="25%" style="text-align: left;">
                                    @if ($report_header->prepared_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            <i>Prepared BY</i>
                                        @endif

                                        {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                                        @if ($report_header->pr_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->pr_doctor_signature_image) }}"
                                                alt="image" style="width: 120px;height:30px">
                                        @endif
                                        <div>@php echo $report_header->pr_doctor_signature @endphp</div>
                                        <!-- <div>Certified Ortopedic Surgeon</div> -->
                                    @endif
                                </td>
                                <td style="text-align: left;">
                                    @if ($report_header->verified_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            <i>Verified BY</i>
                                        @endif

                                        {{-- <div><strong>{{ $report_header->verified_by }}</strong></div> --}}
                                        @if ($report_header->vr_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->vr_doctor_signature_image) }}"
                                                alt="image" style="width: 120px;height:30px">
                                        @endif
                                        <div>@php echo $report_header->vr_doctor_signature @endphp</div>
                                    @endif
                                </td>
                                 @if ($draft != 'draft')
                                <td width="25%" class="text-left">
                                    @if ($report_header->finalized_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            <i>Finalized BY</i>
                                        @endif

                                        {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                        @if ($report_header->fin_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->fin_doctor_signature_image) }}"
                                                alt="image" style="width: 120px;height:30px">
                                        @endif
                                        <div>@php echo $report_header->fin_doctor_signature @endphp</div>
                                    @endif
                                </td>
                                <td width="25%" class="text-left">
                                    @if ($report_header->finalized_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            <i>Consult BY</i>
                                        @endif

                                        {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                        @if ($report_header->ent_digital_signature_ind == 1)
                                            <img src="{{ asset('images/uploads/doctor_images/thumb' . $report_header->ent_doctor_signature_image) }}"
                                                alt="image" style="width: 120px;height:30px">
                                        @endif
                                        <div>@php echo $report_header->ent_doctor_signature @endphp</div>
                                    @endif
                                </td>
                                @else
                                    <td width="25%" class="text-left" style="vertical-align: top;">
                                        <i>Finalized BY</i>
                                        <p>
                                            <Strong>Not Yet Finalized</Strong>
                                        <div>(Draft Copy)</div>
                                        </p>
                                    </td>
                                @endif
                            </tr>
                            @if ($draft =='draft')
                                <tr>
                                    <td colspan="4" style="text-align: left; vertical-align:bottom">
                                        Advice : Please collect the final report after finalization.
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @else
                        <table style="width: 100%; font-size: 11px; padding-top:50px " class="footer_2">
                            <tr>
                                <td width="60%" style="text-align: left;">
                                    @if ($report_header->prepared_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
                                                <i>Prepared BY</i>
                                            @endif
                                        @endif

                                        {{-- <div><strong>{{ $report_header->prepared_by }}</strong></div> --}}
                                        <div>
                                            @if ($report_header->pr_digital_signature_ind == 1)
                                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->pr_doctor_signature_image) }}"
                                                    alt="image" style="width: 120px;height:30px">
                                            @endif
                                            @php echo $report_header->pr_doctor_signature @endphp
                                        </div>
                                        <!-- <div>Certified Ortopedic Surgeon</div> -->
                                    @endif
                                </td>
                                @if ($draft != 'draft')
                                <td width="40%" class="text-left"style="text-align: center;">
                                    @if ($report_header->finalized_by != '')
                                        @if ($po_hospital_details->hospital_code != 'EWMCH')
                                            @if (!in_array(Session::get('user.ses_hospital_code'), ['IMPERIAL', 'AMCSH','DMHL']))
                                                <i>Finalized BY</i>
                                            @endif
                                        @endif

                                        {{-- <div><strong>{{ $report_header->finalized_by }}</strong></div> --}}
                                        <div>
                                            @if ($report_header->fin_digital_signature_ind == 1)
                                                <img src="{{ asset('images/uploads/doctor_images/thumb/' . $po_hospital_details->fin_doctor_signature_image) }}"
                                                    alt="image" style="width: 120px;height:30px">
                                            @endif
                                            @php echo $report_header->fin_doctor_signature @endphp
                                        </div>
                                    @endif
                                </td>
                                @else
                                    <td width="25%" class="text-left" style="vertical-align: top;">
                                        <i>Finalized BY</i>
                                        <p>
                                            <Strong>Not Yet Finalized</Strong>
                                        <div>(Draft Copy)</div>
                                        </p>
                                    </td>
                                @endif
                            </tr>
                            @if ($draft =='draft')
                                <tr>
                                    <td colspan="4" style="text-align: left; vertical-align:bottom">
                                        Advice : Please collect the final report after finalization.
                                    </td>
                                </tr>
                            @endif
                        </table>
                    @endif
                    <table style="width: 100%; " class="footer_3">
                          <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Prepared By: <strong>{{ Session::get('user.ses_user_name') }}</strong>,
                                <strong>Powered By - H360
                                    [NextGen]
                                </strong>
                            </td>
                            <!-- <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td> -->
                        </tr>
                    </table>
                </td>
            </tr>
     
    </table>
   
</body>

</html>
