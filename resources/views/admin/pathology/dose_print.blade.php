<!DOCTYPE html>
<html>

<head>
    <style>
        @page{
            /* margin: .3cm 0cm;           
            size:  80mm 40mm ; */
            margin-top: 5px;
        
            margin-bottom: 0px;
            margin-left: 0px;
            margin-right: 0px;
			/* width: 450px; */
            size: 80mm 50mm;
            /* size: 100mm 50mm; */
            /* vertical-align: text-top; */
        }
        body {
            margin: 0cm;
            /* padding-left: 20px;
            padding-right: 20px; */
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11.5px;
            line-height: 150%;
           
        } 
        .page-break {
            page-break-after: always;
        }   
       
    </style>
</head>
@php
    $po_hospital_details = DB::table('wsec_hospital')
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
@endphp
<body onload="window.print()">   
    @if(!empty($data))
    {{-- @dd($data) --}}
        @foreach($data as $value)
            @inject('expiryDate','App\Http\Controllers\InvestigationCancelController')
            @php
                $expiry_dates = $expiryDate->expiryDatedosePrint($value->item_no_fk, $value->invoice_no_pk);
            @endphp
        <section style=" border:1px solid black;height:47mm;padding-left:5px">
            <div style="border-bottom: 1px solid black; padding-top:5px"> 
                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->logo) }}" width="40" alt="">
                <span style="font-size: 12px;margin-left:10px"> <strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
            </div>
            {{-- <div style="text-align: center;"> <strong>Invoice No : {{$value->invoice_no_pk}}</strong></div>  --}}
            <div style=" padding-top:5px;"> <strong> Visit Date : </strong>{{$value->au_entry_at !="" ? date('d/m/Y h:i a', strtotime($value->au_entry_at))  : ''}}</div>       
            <div style=""> <strong> UHID : </strong>{{ $value->patient_code }} ,<strong> Patient Name : </strong>  {{$value->patient_name}}</div> 
            <div style="">{{$value->brand_name}}  - {{$value->dosage}} - {{$value->route}} -  ({{$value->instruction_take }}) - [{{$value->duration .' '.$value->duration_mu}}]</div>            
             
            @if(!empty($expiry_dates))
                <div style=""> <strong>Expiry Date :  </strong>
                    @foreach($expiry_dates as $item)
                        {{$item->expiry_date !=""? date('d-m-Y', strtotime($item->expiry_date)) :''}} 
                        {{$item->batch_no !='' ? ' ( '. $item->batch_no .' ), ':''}}
                    @endforeach
                </div>        
            @endif
            <div style=""> <strong>Doctor Name : </strong>{{ucwords($value->doctor_name)}}</div> 
            <small style=""> <strong>printing Date : </strong> {{date('d/m/Y h:i a')}}</small> 
             
            @if ($loop->iteration != count($data))
                <div class="page-break"></div>
            @endif
         </section>
        @endforeach
    @endif
</body>
</html>