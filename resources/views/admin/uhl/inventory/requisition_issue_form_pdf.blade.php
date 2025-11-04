
<style>
    table tr {
        border-bottom: none;
    }

    footer {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 2cm;
        text-align: center;
        font-size: 9px;
        bottom: -80px;
        padding-top: 5px;
        border-top: 1px solid black;
    }

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

    .mb-0 {
        margin-bottom: 0;
    }

    .mb-10 {
        margin-bottom: 10px;
    }

    .logo {
        width: 80px;
        display: inline-block;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .hospital-names {
        margin-bottom: 0;
        font-size: 20px;
        padding-bottom: 0;
    }

    .hospital-logo-info .hospital_info .hospital-address {
        font-weight: 500;
        display: block;
        line-height: 1.2;
    }

    .hospital-logo-info .hospital_info .hospital-contact {
        font-weight: 500;
        display: block;
        line-height: 1.2;
        width: 480px;
    }

    .hospital_info {
        margin-left: 10px;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .title {
        font-size: 14px;
        color: #000;
        padding: 5px 50px;
        border-radius: 3px;
    }

    .form-heading .title-name {
        font-size: 1.35rem;
        line-height: 1;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    .form-heading h5 {
        font-size: 1rem;
        margin-top: -10px;
        font-weight: 400;
    }
    .form-heading p {
        font-size: .8rem;
        margin-top: -10px;
    }
    .border-bottom {
        border-bottom: 1px solid #dee2e6;
    }
    .signature {
        width: 100%;
        /* height: 30px; */
        margin-top: 20px;
        margin-bottom: 10px;
    }
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #222
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
        padding-top: 10px;
    }
</style>



<div class="form-heading  border-bottom pb-3" style="">
    <div id="logo" style="display:inline-block !important; ">
        @if (!empty($po_hospital_details->logo))
        <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="80px" />
        @endif
    </div>
    <div class="hospital-address" style="display:inline-block !important; ">
        <h1 class="mb-0 ">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
        <br>
        <p class="mb-0 ">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
        <br>
        <p class="mb-0 ">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
        <br>
    </div>
</div>

<div class="heading text-center border-bottom mb-10">
    <h2>Indent </h2>
</div>


<div style="border: 1px solid #dee2e6; height: 80px; padding: 10px; margin-top: 10px;">
    <div class="patient-information d-flex align-items-center">
        <div class="text-left">
            <ul style="list-style: none; padding-left: 0;">
                <li><b>Name:</b>&nbsp;<span> {{ @$my_requsition->user_name }}</span></li>
                <li><b>Department:</b>&nbsp;<span>{{ @$my_requsition->to_store }}</span></li>
                <li><b>Delivery Location:</b>&nbsp;<span>{{ @$my_requsition->from_stor }}</span> </li>
            </ul>
        </div>
        <div class="text-right">
            <ul style="list-style: none; padding-left: 0;">
                <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} " /></li>
                <li><b>Indent ID:</b>&nbsp;<span> {{ @$my_requsition->inv_requisition_uid }}</span></li>
                <li><b>Date of Indent:</b>&nbsp;<span>{{ date('d/m/Y', strtotime(@$my_requsition->inv_requisition_date)) }}</span></li>
            </ul>
        </div>
    </div>
</div>

<div style="margin-top: 10px">
    @if (Session::get('user.ses_hospital_code') == 'DMHL')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">#SL</th>
                <th class="text-left">Item Code</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Product Spec.</th>
                <th class="text-left">Item UoM</th>
                <th class="text-center">Req. Qty.</th>
                <th class="text-center">Cost Price</th>
                <th class="text-center">Value</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($my_requsition_items))
                @php $grandTotal = 0; @endphp
                @forelse($my_requsition_items as $value)
                    @php 
                        $itemValue = $value->req_quantity * $value->purchase_price; 
                        $grandTotal += $itemValue; 
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->item_code }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ $value->item_remarks != '0' ? ucwords($value->item_remarks) : '' }}</td>
                        <td class="text-center">{{ $value->uom_code }}</td>
                        <td class="text-center">{{ $value->req_quantity }} </td>
                        <td class="text-right">{{ $value->purchase_price }} </td>
                        <td class="text-right">{{ $itemValue }} </td>
                    </tr>
                @empty
                    <tr><td class="text-center text-danger" colspan="8">Data Not Found</td></tr>
                @endforelse
            @endif
            <tr>
                <td colspan="7" class="text-right"><b>Total:</b></td>
                <td class="text-right"><b>{{ $grandTotal }}</b></td>
            </tr>
            <tr>
                <td colspan="8">
                    <b> Special Instructions</b>:<br>
                    {{ @$my_requsition->indent_remarks }}
                </td>
            </tr>
        </tbody>
    </table>
    
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">#SL</th>
                <th class="text-left">Item Code</th>
                <th class="text-left">Item Name</th>                
                <th class="text-left">Generic Name</th>
                <th class="text-left">Product Spec.</th>
                <th class="text-left">Item UoM</th>
                <th class="text-center">Req. Qty.</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($my_requsition_items))
                @forelse($my_requsition_items as $value)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $value->item_code }}</td>
                        <td class="text-left">{{ $value->item_name }}</td>
                        <td class="text-left">{{ isset($value->generic_name) ? $value->generic_name :''}}</td>
                        <td class="text-left">{{ $value->item_remarks != '0' ? ucwords($value->item_remarks) : '' }}</td>
                        <td class="text-center">{{ $value->uom_code }}</td>
                        <td class="text-center">{{ $value->req_quantity }} </td>
                    </tr>
                @empty
                    <tr><td class="text-center text-danger" colspan="7">Data Not Found</td></tr>
                @endforelse
            @endif

            <tr>
                <td colspan="7">
                    <b> Special Instructions</b>:<br>
                    {{ @$my_requsition->indent_remarks }}
                </td>
            </tr>
        </tbody>
    </table>
    @endif

</div>


<div class="signature">
    <table style="width: 100%; border:none ;">
        <tr>
            @if(!empty($signature_data))
                @foreach($signature_data as $key => $value)
                    @php $approval=$value->level_status_text !="" ? explode('-',$value->level_status_text) : ''; @endphp  

                    @if($key ==0 && $approval !="" && $approval[1] == "APPROVED")
                        <td style="text-align:left; border:none " colspan="2">
                            @if($value->doctor_signature_image !="")
                                <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                            @endif
                            <span style=" border-top: black solid 1px;">
                                <strong> {{$value->user_fullname}} </strong></span>
                                <br>
                                <strong> {{ucwords($value->designation)}}</strong>
                                <br>
                                {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}
                            
                        </td>
                    @elseif($key ==1 && count($signature_data) == 2 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:right; border:none" colspan="2">
                        @if($value->doctor_signature_image !="")
                        <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                        @endif
                        <span style=" border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{ucwords($value->designation)}}</strong>
                        <br>
                            {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}
                    </td>
                    @elseif($key ==1 && count($signature_data) == 3 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:center; border:none" colspan="2">
                        @if($value->doctor_signature_image !="")
                        <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                        @endif
                        <span style="padding:5px; border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{ucwords($value->designation)}}</strong>
                        <br>
                            {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}
                    </td>
                    @elseif($key ==2 && count($signature_data) == 3 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:center; border:none" colspan="2">
                        @if($value->doctor_signature_image !="")
                        <div style="padding:5px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                        @endif
                        <span style="padding:5px; border-top: black solid 1px;"> <strong> {{$value->user_fullname}} </strong></span> <br> <strong> {{ucwords($value->designation)}}</strong>
                        <br>
                            {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}
                    </td>
                    @endif
                @endforeach
            @endif
        </tr>
    </table>
</div>

<footer>
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table>
            <tbody>
                <tr>
                    {{-- <td class="text-left">
                        <span>Printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>
                    </td>
                    <td class="text-right">
                        <span>Powered By: [NEXTGEN]</span>
                    </td> --}}
                    <td style="font-size: 9px; text-align:left;">
                        </strong> <strong>Staff ID: {{ $userInfo->user_code }}. Printing Date & Time: {{ date('d/m/Y, h:ia') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By: NEXTGEN IT
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>
       &nbsp;
       
</footer>