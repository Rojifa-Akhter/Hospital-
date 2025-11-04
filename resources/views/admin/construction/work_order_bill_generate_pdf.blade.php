@php $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();@endphp
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
        position: fixed;
        bottom: 0;
        left: 0cm;
        right: 0cm;
    }
    .tr_border td,
    .tr_border th {
        padding:15px 2px;
        padding-bottom: 2px !important;
    }
    .text-center{
        text-align: center;
    }
    .text-right{
        text-align: right;
    }
    .text-left{
        text-align: left;
    }
    .py-2{
        padding-top:8px;
        padding-bottom: 8px;
    }
    .py-3{
        padding-top:12px;
        padding-bottom: 12px;
    }
    {
        padding-top:20px;
        padding-bottom: 20px; 
    }
    .bottom-dotted-border{
        border-bottom: 1px dotted black !important;
    }
    .w-35{
        width:35%;
    }
    .vl-b{
        vertical-align: bottom;
    }
</style>

@php
    $total = 0;
    foreach ($data as $key => $value) {
        $total+= $value->rate * $value->work_qty;
    }
@endphp
<table style="width: 100%;border-collapse:collapse;">
    <thead>
        <tr>
            <td>
                <table style="width: 100%; border:none;">
                    <tr>
                        <td style="width: 15%; border:none;">
                            <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                        </td>
                        <td style="text-align:center; border:none;">
                            <span style="font-size: 15px;">
                                <strong>
                                    {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </strong>
                            </span>
                            <br>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>

                        </td>
                        <td style=" text-align:right; width: 15%;  border:none;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><div style="text-align: center;text-decoration:underline"><strong> BILL FORM</strong> </div></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </thead>
</table>


<table style="width: 100%;border-collapse:collapse;margin-top:30px">
    <tbody>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b" ><strong>01. Description of work</strong><span style="float:right">:</span></td>

            <td class="text-left bottom-dotted-border">@foreach($data as $key => $value)  {{$value->wo_desc}}  @isset($data[++$key]) {{','}} @endisset @endforeach </td>
        </tr>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b"><strong>02. Name of the Contractor/Supplier</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">@isset($data[0]->vendor_name) {{$data[0]->vendor_name}} @endisset</strong></td>
        </tr>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b"><strong>03. Work order date & number</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">
                @php 
                    $date = explode(' ', $data[0]->workorder_date);
                @endphp
                @isset($date[0]) {{$date[0]}}, @endisset @isset($data[0]->workordermst_no_pk) {{$data[0]->workordermst_no_pk}} @endisset
            </td>
        </tr>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b"><strong>04. Total work order value</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">{{ number_format($total,2)}}</td>
        </tr>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b"><strong>05. Bill date & number</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">
                @php 
                    $date = explode(' ', $bill_date);
                @endphp
                {{$date[0]}},  {{$bill_no}} 
            </td>
        </tr>
        <tr class="tr_border">
            <td class="text-left w-35 vl-b"><strong>06. Current Bill Amount</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">{{ number_format($current_bill_amount,2)}}</td>
        </tr>
        <tr class="tr_border">

            @php
                $text_total = getBangladeshCurrency($current_bill_amount);
            @endphp
            <td class="text-left w-35"><strong>07. Current R/A Bill Amount</strong><span style="float:right">:</span></td>
            <td class="text-left bottom-dotted-border">{{Str::ucfirst($text_total)}}</td>
        </tr>
    </tbody>
</table>



<div class="signature">
    <table style="width: 100%; border:none ;">
        <tr>
            
            <td style="text-align: @if(count($signature_data) > 0) center @else left @endif; border:none;vertical-align:bottom">
                <div style="padding:5px;height:65px"> 
                    @if(!empty($data[0]->doctor_signature_image))
                        <img src="{{ public_path('images/uploads/doctor_images/'.$data[0]->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> 
                    @endif
                </div>
                <span> <strong style="text-decoration: overline">@isset($data[0]->user_fullname) {{$data[0]->user_fullname}}  @endisset</strong></span> <br> 
                <strong>Executive</strong><br>
                <strong>@isset($data[0]->au_entry_at) {{ date('d/m/Y h:i a',strtotime($data[0]->au_entry_at))}} @endisset</strong>
            </td>
          
            @foreach($signature_data as $key => $value)
                @php 
                    $approval = $value->level_status_text !="" ? explode('-',$value->level_status_text) : '';
                @endphp
                @if($key == 0 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:center; border:none;vertical-align:bottom;padding-top:20px">

                        <div style="padding:5px;height:65px"> 
                            @if(!empty($value->doctor_signature_image))
                                <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> 
                            @endif
                        </div>
                        
                        <span><strong style="text-decoration: overline"> {{$value->user_fullname}} </strong></span><br> 
                        <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>

                    </td>
                @endif
                @if($key == 1 && $approval !="" &&  $approval[1] == "APPROVED")
                    <td style="text-align:right; border:none; text-align:center;vertical-align:bottom;padding-top:20px">
                        <div style="padding:5px;height:65px"> 
                            @if(!empty($value->doctor_signature_image))
                                <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> 
                            @endif
                        </div>
                        <span > <strong style="text-decoration: overline;"> {{$value->user_fullname}} </strong></span><br> 
                        <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                    </td>
                @endif
            @endforeach
        </tr>

        <tr>
            @foreach($signature_data->skip(2) as $key => $value)
            @php 
                $approval = $value->level_status_text !="" ? explode('-',$value->level_status_text) : '';
            @endphp
            @if($key == 2 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:center; border:none;vertical-align:bottom" colspan="2">
                        @if($value->doctor_signature_image !="")
                            <div style="padding:5px;height:65px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                        @endif
                        <span > <strong style="text-decoration: overline"> {{$value->user_fullname}} </strong></span><br> 
                        <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                    </td>
            @endif
            @if($key == 3 && $approval !="" && $approval[1] == "APPROVED")
                    <td style="text-align:center; border:none;vertical-align:bottom">
                        @if($value->doctor_signature_image !="")
                            <div style="padding:5px;height:65px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                        @endif
                        <span > <strong style="text-decoration: overline"> {{$value->user_fullname}} </strong></span><br> 
                        <strong> {{$value->designation}}</strong> <br>
                        <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                    </td>
            @endif
            @endforeach
        </tr>
    </table>
</div>



{{-- <footer>
    <table style="width:100%; border:none">
        <tr>
            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                @php
                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                    $date = $dt->format('g:i A');
                @endphp
                {{ date('d/m/Y') }} {{ $date }}</strong>Printed By:<strong>{{ Session::get('user.ses_user_name') }}</strong></td>
            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]</strong></td>
        </tr>
    </table>
</footer> --}}