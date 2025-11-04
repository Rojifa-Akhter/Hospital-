<!DOCTYPE html>
<html>

<head>
    <style>
        /* body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        } */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
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
            margin-bottom: 2.8cm;
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
            height: 4.7cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            padding-top: 10px;
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
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </strong>
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
    <div style="text-align: center;font-size: 12px; font-style:bold">
        <span>Gate Pass</span>
    </div>
    <div class=""
        style="border: 1px solid #dee2e6; height: 120px; padding: 10px; margin-top: 10px; font-size:10px !important">
        <div class="patient-information d-flex align-items-center">
            <div class="text-left">
                <ul style="list-style: none; padding-left: 0;">

                    <li><b>Department
                            :&nbsp;<span> {{ @$inv_gatepassmst->serviceunit_name }}</span></b>
                    </li>
                    <li><b>Received By
                            :&nbsp;<span> {{ @$inv_gatepassmst->issued_to_name }}</span></b>
                    </li>
                    <li><b>Supplier Name
                            :&nbsp;<span> {{ @$inv_gatepassmst->supplier_name }}</span></b>
                    </li>
                    <li><b>Phone No
                            :</b>&nbsp;<span>
                            {{ @$inv_gatepassmst->issued_to_contact_number }}</span>
                    </li>
                    <li><b>Gate Pass Type
                            :</b>&nbsp;<span>
                            {{ @$inv_gatepassmst->gatepass_type == 'RTRN' ? 'No Return' : 'Return' }}</span>
                    </li>
                    <li>
                        <br>
                        <!-- <b>Security in-Charge
                                                :</b>&nbsp;<span> {{ @$inv_gatepassmst->sec_in_out != '' ? ' PASS ' . @$inv_gatepassmst->sec_in_out : '' }}</span> -->
                    </li>
                    <li>
                        <br>
                        Allowed To Take Following Articles/Emerson
                        {{ ucWords(strtolower(@$inv_gatepassmst->sec_in_out)) }}.
                        {{-- From : &nbsp;<span>
                                                {{ @$inv_gatepassmst->allowed_dates_from != '' ? date('d/m/Y', strtotime(@$inv_gatepassmst->allowed_dates_from)) . ' , ' : '' }}</span>
                        To : &nbsp;<span>
                            {{ @$inv_gatepassmst->allowed_dates_to != '' ? date('d/m/Y', strtotime(@$inv_gatepassmst->allowed_dates_to)) : '' }}</span> --}}
                    </li>


                </ul>
            </div>
            <div class="text-right">
                <ul style="list-style: none; padding-left: 0;">

                    <li>
                        <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                    </li>
                    <li><b>Gate Pass ID
                            :</b>&nbsp;<span> {{ @$inv_gatepassmst->gatepass_uid }}</span>
                    </li>

                    <li><b>Date of Gate Pass:</b>&nbsp;<span>
                            {{ @$inv_gatepassmst->gatepass_date != '' ? date('d/m/Y', strtotime(@$inv_gatepassmst->gatepass_date)) : '' }}</span>
                    </li>
                    @if (!empty(@$inv_gatepassmst->return_date))
                        <li><b>Return Date :</b>&nbsp;<span>
                                {{ @$inv_gatepassmst->return_date != '' ? date('d/m/Y', strtotime(@$inv_gatepassmst->return_date)) : '' }}</span>
                        </li>
                    @endif

                    <li><b>Status:</b>&nbsp;<span>
                            {{ @$inv_gatepassmst->gatepass_save_option }}</span>
                    </li>

                </ul>
            </div>

        </div>

    </div>
</header>
<div class="signature">
    <table style="width: 100%; border:none ; ">

        <tbody>

            <tr>
          
                <!-- @if (!empty($signature_data))
                    @if ($signature_data[0]->user_fullname_ent != '')
                        <td style="text-align:left; border:none ">
                            @if ($signature_data[0]->doctor_signature_image != '')
                           
                                <div style="padding:5px"> <img
                                        src="{{ public_path('images/uploads/doctor_images/' . $signature_data[0]->doctor_signature_image) }}"
                                        width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                            @endif
                            
                        </td>
                    @endif
                  
                    @foreach ($signature_data as $key => $value)
                        @php
                            $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                        @endphp

                        @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:left; border:none " colspan="2">
                                @if ($value->doctor_signature_image != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                            width='60px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif


                            </td>
                        @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">
                                @if ($value->doctor_signature_image != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                            width='60px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif

                            </td>
                        @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">
                                @if ($value->doctor_signature_image != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                            width='60px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif
                            </td>
                        @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">
                                @if ($value->doctor_signature_image != '')
                                    <div style="padding:5px"> <img
                                            src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}"
                                            width='60px' style="padding: 0px  !important; margin:0px !important">
                                    </div>
                                @endif
                            </td>
                        @endif
                    @endforeach
                @endif -->
                <td style="text-align:left; border:none ">
                    <div></div>
                </td>
            </tr>
            <tr style="">
                @if (!empty($signature_data))
                    @if ($signature_data[0]->user_fullname_ent != '')
                        <td style="text-align:center; border:none ">

                            <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                    {{ $signature_data[0]->user_fullname_ent }} </strong></span> <br>
                            <strong> {{ ucwords($signature_data[0]->ent_designation) }}</strong><br>
                            {{ $signature_data[0]->approved_at != '' ? date('d/m/Y h:i a', strtotime($signature_data[0]->approved_at)) : '' }}

                        </td>
                    @endif
                    @foreach ($signature_data as $key => $value)
                        @php
                            $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                        @endphp

                        @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none " colspan="2">

                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $value->user_fullname }} </strong></span> <br> <strong>
                                    {{ ucwords($value->designation) }}</strong><br>
                                {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}

                            </td>
                        @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">


                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $value->user_fullname }} </strong></span> <br> <strong>
                                    {{ ucwords($value->designation) }}</strong><br>
                                {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}


                            </td>
                        @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">

                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $value->user_fullname }} </strong></span> <br> <strong>
                                    {{ ucwords($value->designation) }}</strong><br>
                                {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}
                            </td>
                        @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                            <td style="text-align:center; border:none" colspan="2">

                                <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                        {{ $value->user_fullname }} </strong></span> <br> <strong>
                                    {{ ucwords($value->designation) }}</strong><br>
                                {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}
                            </td>
                        @endif
                    @endforeach
                @endif
                <td style="text-align:center; border:none ">
                    <span style="padding:5px; border-top: black solid 1px;"> <strong>
                            {{ @$inv_gatepassmst->sec_in_out != '' ? ' PASS ' . @$inv_gatepassmst->sec_in_out : '' }}
                        </strong></span>
                    <br> <strong> Security in-Charge</strong>
                    <br>

                </td>
            </tr>
        </tbody>
    </table>
</div>
<footer>
    <?php
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('g:i A');
    ?>

    <div class="" style=" border-top: 1px solid black;">
        <span style="">printed By: {{ $userInfo->user_fullname }}</span>
        &nbsp;
        <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>
        &nbsp;
        <span>Powered By: NEXTGEN IT</span>
    </div>
</footer>

<body>
    <div>
        <table class="table table-bordered " style="">

            <thead>
                <tr>
                    <th style="width: 5%">SL</th>
                    <th class="text-left" style="word-wrap: break-word; width:25%;">Item Name</th>
                    <th class="text-left" style="width: 15%">Model</th>
                    <th style="width: 7%">Uom</th>
                    <th style="width: 8%">Qty</th>
                    <th style="word-wrap: break-word; width:40%">Remarks</th>
                </tr>
            </thead>
            <tbody>

                @if (isset($inv_gatepassdtl))
                    @foreach ($inv_gatepassdtl as $value)
                        <tr>
                            <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            <td class="text-left">{{ $value->item_model }}</td>
                            <td class="text-center">{{ $value->item_uom_text }} </td>
                            <td class="text-center">{{ $value->item_qty }}</td>
                            <td class="text-left">{{ $value->item_remarks }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="6" style="border: none; font-style:bold;">
                        {{ @$inv_gatepassmst->gatepass_purpose_desc }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
