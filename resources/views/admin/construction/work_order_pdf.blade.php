@php $po_hospital_details = DB::table('WSEC_HOSPITAL')->first();@endphp
<style>
    @page {
        /* padding-bottom: 100px; */
        /* border: 1px solid red; */
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
        bottom: 0px;
        left: 0cm;
        right: 0cm;
    }
    .tr_border td,
    .tr_border th {
        border: 1px solid #222;
        padding:2px;
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
</style>

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
                        <td colspan="3" class="text-center"><div style="text-align: center;text-decoration:underline"><strong> @isset($data[0]->serviceunit_name) {{ ucwords(strtoupper($data[0]->serviceunit_name))}}  @endisset WORK ORDER</strong> </div></td>
                    </tr>
                </table>
            </td>
        </tr>
        
    </thead>
</table>




<table style="width: 100%;border-collapse:collapse;margin-top:20px">
    <thead>
        <tr>
            <th colspan="8">
                <table style="width: 100%;border-collapse:collapse;">
                    <tbody>
                        <tr><td class="text-left py-2" ><strong>Work Order No: @isset($data[0]->workordermst_no_pk){{$data[0]->workordermst_no_pk}}@endisset</strong></td></tr>                       
                        <tr><td class="text-left py-2" ><strong>Ref: @isset($data[0]->workorder_ref_no){{$data[0]->workorder_ref_no}}@endisset</strong></td></tr>
                        <tr><td class="text-left py-2"><strong>Date: @isset($data[0]->workorder_date){{substr($data[0]->workorder_date, 0, 10)}}@endisset</strong></td></tr>
                        @isset($data[0]->workorder_type)
                            @if(!empty($data[0]->workorder_type))
                            <tr><td class="text-left py-2" ><strong>Work Order Type: 
                                @if($data[0]->workorder_type == 1)
                                    {{'Daily Basis'}}
                                @elseif($data[0]->workorder_type == 2)
                                    {{'Contract Basis'}}
                                @endif
                            
                            </strong></td></tr>
                            @endif
                        @endisset
                        <tr><td class="text-left py-2"><strong>Vendor/Sub-Contractor Name: @isset($data[0]->vendor_name){{$data[0]->vendor_name}}@endisset</strong></td></tr>
                    </tbody>
                </table>
            </th>
        </tr>
    </thead>
    <tbody>

        <tr class="tr_border">
            <td class="text-center" style="width:5%"><strong>SL#</strong></td>
            <td class="text-left" style="width:49%"><strong>Description</strong></td>
            <td class="text-center" style="width:8%"><strong>Type of Worker</strong></td>
            <td class="text-center" style="width:8%;"><strong>Work Qty</strong></td>
            <td class="text-center" style="width:7%"><strong>Unit</strong></td>
            <td class="text-right" style="width:8%"><strong>Rate</strong></td>
            <td class="text-right" style="width:15%"><strong>Amount</strong></td>
            <td class="text-left" style="width:10%"><strong>Remarks</strong></td>
        </tr>

        @php $total = 0; @endphp
        @forelse($data as $key => $row)
            <tr class="tr_border">
                <td class="text-center" style="text-align: center;">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $row->wo_desc }}</td>
                <td class="text-center">{{ $row->typeofwoker }}</td>
                <td class="text-center">{{ $row->work_qty }}</td>
                <td class="text-center">{{ $row->unit }}</td>
                <td class="text-right">{{ number_format($row->rate,2) }}</td>
                <td class="text-right">{{ number_format($row->rate * $row->work_qty ,2) }}</td>
                <td class="text-left">{{ $row->remarks }}</td>
            </tr>
            @php $total+= (floatVal($row->rate) * floatVal($row->work_qty)); @endphp
        @empty
            <tr class="tr_border"> 
                <td colspan="8" class="text-center">Data Not Found</td>
            </tr>
        @endforelse

            @php
                $text_total = getBangladeshCurrency($total);  
            @endphp
            @isset($data[0]->adv_amount)
                @if($data[0]->adv_amount > 0)
                    <tr class="tr_border">
                        <td colspan="6" class="text-center">
                            Advance Amount
                        </td>
                        <td class="text-right">{{number_format($data[0]->adv_amount,2)}}</td>
                        <td></td>
                    </tr>
                    {{-- @php $total -= $data[0]->adv_amount; @endphp --}}
                @endif
            @endisset
            <tr class="tr_border">
                <td colspan="6" class="text-center">
                    <strong>Payable Amount =</strong>
                </td>
                <td class="text-right">{{number_format($total,2)}}</td>
                <td></td>
            </tr>



            <tr>
                <td colspan="8">
                    @php
                        $date1 = new DateTime(substr($data[0]->work_start_date, 0, 10));
                        $date2 = new DateTime(substr($data[0]->work_completion_date, 0, 10));
                        $interval = $date1->diff($date2);
                        $daysDifference = $interval->format('%a');
                    @endphp
                    <table style="width: 100%;border-collapse:collapse;margin-top:10px">
                        <tbody>
                            <tr><td class="text-left py-2" ><strong>In Word: {{Str::ucfirst($text_total)}}</strong></td></tr>
                            <tr><td class="text-left py-2"><strong>Work Start Date:@isset($data[0]->work_start_date){{substr($data[0]->work_start_date, 0, 10)}}@endisset</strong></td></tr>
                            <tr><td class="text-left py-2"><strong>Work Completion Date: @isset($data[0]->work_completion_date){{substr($data[0]->work_completion_date, 0, 10)}}@endisset</strong></td></tr>
                            <tr><td class="text-left py-3"><strong>Total Time for Completion of Work: @isset($data[0]->work_start_date) {{ $daysDifference+1 }} @endisset Days</strong></td></tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="8">
                    <div>
                        @if(!empty($data[0]->termsncon))
                            <strong>Terms & conditions</strong>
                        @endif
                        <div>
                            {!!$data[0]->termsncon!!}
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="8">
                    <table style="width: 100%;">
                            <tr>
                                <td style="text-align: @if(count($signature_data) > 0) center @else left @endif; border:none;vertical-align:bottom">
                                    <div style="padding:5px;height:62px"> 
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
                                        <td style="text-align:center; border:none;vertical-align:bottom;padding-top:0px">

                                            <div style="padding:5px;height:62px"> 
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
                                        <td style="text-align:right; border:none; text-align:center;vertical-align:bottom;padding-top:0px">
                                            <div style="padding:5px;height:62px"> 
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
                                                <div style="padding:5px;height:62px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif
                                            <span > <strong style="text-decoration: overline"> {{$value->user_fullname}} </strong></span><br> 
                                            <strong> {{$value->designation}}</strong> <br>
                                            <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                                        </td>
                                @endif
                                @if($key == 3 && $approval !="" && $approval[1] == "APPROVED")
                                        <td style="text-align:center; border:none;vertical-align:bottom">
                                            @if($value->doctor_signature_image !="")
                                                <div style="padding:5px;height:62px"> <img src="{{ public_path('images/uploads/doctor_images/'.$value->doctor_signature_image) }}" width='60px' style="padding: 0px  !important; margin:0px !important"> </div>
                                            @endif
                                            <span > <strong style="text-decoration: overline"> {{$value->user_fullname}} </strong></span><br> 
                                            <strong> {{$value->designation}}</strong> <br>
                                            <strong> {{$value->approved_at !="" ? date('d/m/Y h:i a',strtotime($value->approved_at)) :''}}</strong>
                                        </td>
                                @endif
                                @endforeach
                            </tr>
                    </table>    
                </td>
            </tr>
    </tbody>
</table>


{{-- <footer>
    <table style="width:100%; border:none">
        <tr>
            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                @php
                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                    $date = $dt->format('g:i A');
                @endphp
                {{ date('d/m/Y') }} {{ $date }}</strong> Printed By:<strong>{{ Session::get('user.ses_user_name') }}</strong></td>
            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]</strong></td>
        </tr>
    </table>
</footer> --}}