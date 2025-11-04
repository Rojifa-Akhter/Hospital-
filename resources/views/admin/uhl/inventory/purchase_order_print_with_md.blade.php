@php
    $sign_css = File::exists(public_path('images/uploads/doctor_images/director_sign.png')) ? '5.5cm' : '5.5cm';
    // when add digital sign= 7.3cm
@endphp
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Purchase Order Print</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <link rel="stylesheet" href="css/purchase_order_print.css" media="all" />
    <style type="text/css">
        @page {
            margin-top: 1.5cm;
            margin-bottom: 0.8cm;
            margin-left: 0.8cm;
            margin-right: 0.8cm;
            height: 29.7cm;
            width: 21 cm;
        }

        body {
            /* margin-top: 2.5cm; */
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 1.5cm;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            color: #000000;
            /* border: 1px solid black; */
        }
        table{
            border-collapse: collapse;
        }
        td,th{
            padding: 2px !important;
        }
        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 4cm;
            text-align: center;
            font-size: 9px;
            bottom: 0px;
            /*border-top: 1px solid black;*/
            padding-top: 10px;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            /* height: 2.5cm; */
            font-size: 9px;
            /*top: -10px;
            border-top: 1px solid black;*/
            padding-top: 10px;
            z-index: 999999999;
        }

        .fixed_signature{
            position: absolute;
            left: 0;
            right: 0;

        }

        .section {
            position: relative;
            width: 100%;
            height: 310px;
            /* padding-bottom: 20px;  */
            /* border: 1px solid black  */
        }

        .md_signature{
            z-index: 9999999999;
            position: relative;
            left: 0;
            right: 0;
            font-size: 9px;
            /* bottom: 70px; */
            padding-top: 90px;
            text-align: center;
            font-size: 9px;
        }

        .singature {
            position: relative;
            z-index: 999999999;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            /* border: 1px solid black  */
        }

        /* .singature {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: <?=$sign_css ?>;
            text-align: center;
            font-size: 9px;
            bottom: -70px;
        } */

        .thank_you {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            top:880px;
            padding-left: 15px;
            /* height: 6cm; */
            /* 5.5; */
            /* text-align: left; */
            font-size: 9px;
            /* bottom: -10px; */
            /* padding-top: 10px; */
            /* margin-top: 60px; */
        }
    </style>
</head>
@php
    //dd($po_hospital_details );
    $imagePath = isset($po_hospital_details->logo) ? 'images/uploads/hospital_images/thumb/' . $po_hospital_details->logo : 'images/kbmh.jpg';
    // dd(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo));
@endphp

<body>
    @if (!empty($po_hospital_details) && $po_hospital_details->report_header_image_prshde_ind == 1)
        <header>
            <table style="width: 100%; border-collapse:collapse;" class="signature">
                <tr style="">
                    <td style="width: 20%;">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="120" alt="" />
                    </td>
                    <td style="text-align:left;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                        <br>
                        Address:<span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone
                        No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            </table>
        </header>
    @else
        @if (Session::get('user.ses_hospital_code') != 'UNICO')
            <div style="height: 1cm;"></div>
        @endif
    @endif
    <footer style="border-top: 1px solid transparent;">
        <div class="">
            <table style="width: 100%; border:none ">
                @if (Session::get('user.ses_hospital_code') != 'UNICO')
                    @if (Session::get('user.ses_hospital_code') == 'JKMH')
                        <tr style=" ">
                            <td style="text-align:left; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">GM, Admin & Procurement</span><br> --}}

                                <span style="padding:5px;">Prepared By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->passed_by_name : '' }}
                                </span><br>
                                {{-- <span style="padding:5px;">Director, Admin</span><br> --}}

                                <span style="padding:5px;">Manager (Accounts)</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                                <span style="padding:5px;">DGM</span>
                            </td>
                            <td style="border:none"></td>
                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                {{-- <span style="padding:5px;">Director, Finance</span><br> --}}
                                <span style="padding:5px;">DMD</span>
                            </td>
                        </tr>
                    @else
                        <tr style=" ">
                            <td style="text-align:left; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                <span style="padding:5px;">Head of Pharmacy </span><br>

                                <span style="padding:5px;">Prepared By</span>

                            </td>
                            <td style="border:none"></td>
                            <td style="text-align:center; width:20%; border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->prepared_by_name : '' }}</span><br>
                                <span style="padding:5px;">GM, Admin & Procurement</span><br>

                                <span style="padding:5px;"> Review By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:center; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px; ">{{ isset($signed_user) ? $signed_user->passed_by_name : '' }}
                                </span><br>
                                <span style="padding:5px;">Director, Admin</span><br>

                                <span style="padding:5px;">Checked By</span>

                            </td>
                            <td style="border:none"></td>

                            <td style="text-align:right; width:20%;border-top: black solid 1px;">
                                <span
                                    style="padding:5px;">{{ isset($signed_user) ? $signed_user->approved_by_name : '' }}</span><br>
                                <span style="padding:5px;">Director, Finance</span><br>
                                <span style="padding:5px;">Approved By</span>
                            </td>
                        </tr>
                    @endif
                @endif
            </table>

        </div>
        @if (!in_array(Session::get('user.ses_hospital_code'), ['UNICO']))
            <table style="border:0px; border-top:1px solid #222;">
                <tr>
                    <td style="border: 0px; padding-top: 5px; text-align: left;">Prepared By:
                        {{ $userInfo->user_fullname }} &nbsp;&nbsp; Printing Date & Time: {{ date('d/m/Y') }}
                    </td>
                    <!-- <td style="padding-right:50px">
                    <p class="page" style="padding-right:50px">Page </p>
                </td> -->
                    <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
                </tr>
            </table>
        @endif
        <!-- <p class="page" style=""> <span id="pageCounter"></span> </p> -->
    </footer>


    <main style="padding-bottom: 0px;">
        <div id="details" class="clearfix" style=" margin-bottom:1px; margin-top:0px">
            <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px; width: 20%; font-size:15px; border-radius: 15px; background-color:E9E8E8">
                <strong>{{ $po_master_info->poheader == '0' ? 'Work Order' : 'Purchase Order' }}</strong>
            </p>
            <div class="" style="margin-top: 25px !important; margin-bottom: 5px;">

                <table>
                    <tr>
                        <td style="text-align: left;">
                        @if($po_master_info->reference_no !="")
                            <strong>Ref:</strong> {{ $po_master_info->reference_no }}<br><br>
                        @endif
                        @if($po_master_info->supplier_name !="")
                            <strong>To: {{ strtoupper($po_master_info->supplier_name) }} </strong><br>
                        @endif
                        @if($po_master_info->addr1 !="")
                            <strong>Address:</strong> {{ $po_master_info->addr1 }}<br>
                        @endif
                        @if($po_master_info->refer_contact_name !="")
                            <strong>Attention :</strong> {{ $po_master_info->refer_contact_name }}<strong> Cell:</strong> {{ $po_master_info->refer_contact_mobile }}                           
                            <br>
                        @endif
                        @if($po_master_info->refer_contact_email !="")
                            <strong> Email:</strong> {{ $po_master_info->refer_contact_email }}<br>    
                        @endif                  
                                          

                          
                        </td>
                        <td style="width: 40%;">
                            <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />
                            <br>                          
                            <strong>PO ID:</strong> {{ $po_master_info->purchase_uid }}<br>
                            <strong>PO NO:</strong> {{ $po_master_info->purchaseorder_no_pk }}<br>
                            <!-- $purchase_order_id -->
                            <strong>Date of PO:</strong>
                            {{ date('d/m/Y', strtotime($po_master_info->purchase_date)) }}<br>
                            @if($po_master_info->quotation_ref !="")
                            <strong>Quotation Ref :</strong>
                            {{ isset($po_master_info->quotation_ref) ? $po_master_info->quotation_ref : '' }}<br>
                            @endif
                        </td>
                    </tr>
                    @if($po_master_info->reference_sub !="")
                    <tr>
                        <td colspan="2" style="text-align: left; padding-top:5px">   
                            <strong> Subject : </strong> {{ $po_master_info->reference_sub }}<br>                              
                        </td>
                    </tr>
                    @endif   

                </table>
            </div>
        </div>
        <div id="details" class="clearfix" style=" margin-bottom:1px">


        </div>

        </div>
        @if($po_master_info->reference_sub_body !="")
        <table style="margin-top: 0px; width:100%">
            <tr>
                <td style="text-align: left;"> {!! isset($po_master_info->reference_sub_body) ? $po_master_info->reference_sub_body : '' !!}
                </td>
            </tr>
        </table>
        @endif


        <table class="" border="1" style="margin-top: 0px; width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width:5%">Sl.</th>
                    <!-- <th class="text-left">Item Code</th> -->
                    <th class="text-left" style="width:23%">Item Name</th>
                    <th class="text-left" style="width:23%">Item Specification</th>
                    <th class="text-center" style="width:7%"> UoM</th>
                    <th class="text-center" style="width:10%">Quantity</th>
                    <!-- <th class="text-center">Total Quantity</th> -->
                    <th class="text-right" style="width:14%" >Unit Price</th>
                    <th class="text-right" style="width:18%">Total Amount </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dollar_ind = '';
                    $dollar_rate = 0;
                    $total_dollar_rate = 0;
                @endphp
                <?php $total = 0; ?>
                @if (isset($po_child_details_info))

                    @foreach ($po_child_details_info as $value)
                        @php
                            $dollar_ind = $value->dollar_rate;
                            $dollar_rate = $value->dollar_rate != '' ? $value->item_rate / $value->dollar_rate : $value->item_rate;
                            $total_dollar_rate = $value->dollar_rate != '' ? ($value->item_rate / $value->dollar_rate) * $value->entry_qty : $value->entry_qty * $value->item_rate;
                        @endphp
                        <tr>
                            <td class="text-center  bg-light">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            <td class="text-left">{{ $value->refer_item_specification }}</td>
                            <td class="text-center">
                                {{ $value->uom_code }}
                            </td>
                            <td class="text-center">{{ $value->entry_qty }} {{ $value->pr_uom_name }} </td>
                           
                            <td class="text-right">
                                @if ($value->currency_sign == 'USD')
                                    $
                                @elseif($value->currency_sign == 'EUR')
                                    €
                                @else
                                    Tk.
                                @endif{{ number_format($dollar_rate, 2) }}
                            </td>
                            <td class="text-right">
                                @if ($value->currency_sign == 'USD')
                                    $
                                @elseif($value->currency_sign == 'EUR')
                                    €
                                @else
                                    Tk.
                                @endif {{ number_format($total_dollar_rate, 2) }}
                            </td>
                        </tr>
                        @php
                            $total += $value->dollar_rate != '' ? $value->entry_qty * ($value->item_rate / $value->dollar_rate) : $value->entry_qty * $value->item_rate;
                            
                        @endphp
                    @endforeach
                @endif
            </tbody>

            @php
                
                $dollar_exp = [];
                if (!empty($dollar_rate_currency) && $dollar_rate_currency != '_') {
                    $dollar_exp = explode('_', $dollar_rate_currency);
                }
                
            @endphp


            <tfoot>
                <tr>
                    <td class="border-0" colspan="4"></td>
                    <td class="border-0 text-right bg-light">
                        <strong>Total:</strong>
                    </td>
                    <td class="border-0 text-right bg-light" colspan="2">
                        <strong>
                            @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                $
                            @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                €
                            @else
                                Tk.
                            @endif{{ number_format($total, 2) }}
                    </td>
                </tr>

                @if ($po_master_info->vat_amount > 0)
                    <tr>
                        <td class="border-0" colspan="4"></td>

                        <td class="border-0 text-right bg-light">
                            <strong>Duty/Vat :
                                {{ $po_master_info->vat_percent > 0 ? '(' . number_format($po_master_info->vat_percent, 2) . ')' . '% :' : '' }}</strong>

                        </td>

                        <td class="border-0 text-right bg-light" colspan="2">
                            <strong>
                                @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                    $
                                @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                    €
                                @else
                                    Tk.
                                @endif
                                {{ !empty($dollar_exp) ? number_format($po_master_info->vat_amount / $dollar_exp[0], 2) : number_format($po_master_info->vat_amount, 2) }}
                        </td>
                    </tr>
                @endif
                @if ($po_master_info->discount_amount > 0)
                    <tr>
                        <td class="border-0" colspan="4"></td>
                        <td class="border-0 text-right bg-light">
                            <strong>Discount
                                ({{ number_format($po_master_info->discount_percent, 2) }}%):</strong>

                        </td>
                        <td class="border-0 text-right bg-light" colspan="2">
                            <strong>
                                @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                    $
                                @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                    €
                                @else
                                    Tk.
                                @endif
                                {{ !empty($dollar_exp) ? number_format($po_master_info->discount_amount / $dollar_exp[0], 2) : number_format($po_master_info->discount_amount, 2) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    @php
                        
                        if (!empty($dollar_exp)) {
                            $total = $total + $po_master_info->vat_amount / $dollar_exp[0] - $po_master_info->discount_amount / $dollar_exp[0];
                        } else {
                            $total = $total + $po_master_info->vat_amount - $po_master_info->discount_amount;
                        }
                    @endphp
                    <td class="border-0" colspan="4"></td>
                    <td class="border-0 text-right bg-light"><strong>Payable:</strong>

                    </td>
                    <td class="border-0 text-right bg-light" colspan="2"> <strong>
                            @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                                $
                            @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                                €
                            @else
                                Tk.
                            @endif {{ number_format($total, 2) }}
                        </strong>
                    </td>

                </tr>
            </tfoot>
        </table>

        @php
            $number = number_format($total, 2, '.', '');
            $locale = 'en_US';
            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
            $in_words = numfmt_format($fmt, $number);
        @endphp
        <div style="padding-left:7px">
            <span><strong> Total Job Cost ( In Words ) : {{ ucfirst($in_words) }} @if (!empty($dollar_exp) && $dollar_exp[1] == 'USD')
                dollar only
            @elseif(!empty($dollar_exp) && $dollar_exp[1] == 'EUR')
                Euro only
            @else
                Taka only
            @endif. </strong></span>
        </div>
        

        <div style="margin-top:5px;padding-left:7px">
            @if (!empty($terms))

                @foreach ($terms as $header => $terms_condition)
                    <div class="text-left "> <strong> {{ $header }}</strong></div>

                    @foreach ($terms_condition as $value)
                        <span class="text-left ">
                            {{ sprintf('%02d', $loop->iteration) }}. </span>
                        <span class="text-left">{{ $value->description }}</span>
                    @endforeach
                @endforeach
                <div style="font-weight: bold; margin-top:5px">Please sign and return the copy of this letter as acceptance of the above order.</div>
            @endif
        </div>

        <div class="section">
            <div class="fixed_signature">
                <div style="font-weight: bold;margin-top:5px;padding-left:7px">For {{ Session::get('user.hospital_name') }}</div>
            
    
                <div class="md_signature" style="padding-bottom:70px">
                    <table style="width: 100%; border:none ;font-size:14px">
                        <tbody>
                            <tr>
                                <td style="text-align:left; border:none;">                                 
                                    <span style="border-top: black solid 1px;"> <strong> @if(isset($md_information->full_name))  {{$md_information->full_name}} @endif </strong></span> <br> 
                                      <strong > Managing Director </strong>
                                      <div style="padding-top: 15px"><strong>Recommended,</strong></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
    
    
                <div class="singature">    
                    <table style="width: 100%; border:none ;font-size:14px" >
                        <tbody>
                            @if (!empty($signature_data))               
                            <tr style="">                          
                                @foreach ($signature_data as $key => $value)
                                    @php
                                        $approval = $value->level_status_text != '' ? explode('-', $value->level_status_text) : '';
                                    @endphp
                                    @if ($key == 0 && $approval != '' && $approval[1] == 'APPROVED')
                                        <td style="text-align:left; border:none " colspan="2">
        
                                            
                                            <!-- @if ($value->doctor_signature_image != '')
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif -->
                                            <span style=" border-top: black solid 1px;"> <strong>
                                                    {{ $value->user_fullname }} </strong></span> <br> <strong>
                                                {{ ucwords($value->designation) }}</strong> 
                                                {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
        
                                        </td>
                                    @elseif($key == 1 && count($signature_data) == 2 && $approval != '' && $approval[1] == 'APPROVED')
                                        <td style="text-align:right; border:none; text-align:center;">
                                            
                                            <!-- @if ($value->doctor_signature_image != '')
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif -->
                                            <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                                    {{ $value->user_fullname }} </strong></span> <br> <strong>
                                                {{ ucwords($value->designation) }}</strong> 
                                                {{-- <br>{{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                                        </td>
                                    @elseif($key == 1 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                        <td style="text-align:center; border:none" colspan="2">
                                            
                                            <!-- @if ($value->doctor_signature_image != '')
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif -->
                                            <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                                    {{ $value->user_fullname }} </strong></span> <br> <strong>
                                                {{ $value->designation }}</strong> 
                                            <strong>
                                                {{-- <br> {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }}</strong> --}}
                                        </td>
                                    @elseif($key == 2 && count($signature_data) == 3 && $approval != '' && $approval[1] == 'APPROVED')
                                        <td style="text-align:center; border:none" colspan="2">
        
                                            
                                            <!-- @if ($value->doctor_signature_image != '')
                                            <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/' . $value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif -->
                                            <span style="padding:5px; border-top: black solid 1px;"> <strong>
                                                    {{ $value->user_fullname }} </strong></span> <br> <strong>
                                                {{ ucwords($value->designation) }}</strong> 
                                                {{-- <br> {{ $value->approved_at != '' ? date('d/m/Y h:i a', strtotime($value->approved_at)) : '' }} --}}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                            @endif
                            @if(isset($po_master_info->copy_to))  <tr><td colspan="4" style="text-align: left;"> <strong>Copy To : </strong> <span> {{ $po_master_info->copy_to }}</span> </td></tr>@endif
                        </tbody>
                    </table>                
                </div>
    
            </div>
        </div>

    </main>
</body>

</html>
