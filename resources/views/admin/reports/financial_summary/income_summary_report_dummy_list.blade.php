@if(isset($data) && !empty($data))
@foreach($data as $value)
<tr>    
    <td style="text-align: center;">{{$loop->iteration}}</td>
    <td class="text-center">{{$value->invoice_no_fk}}</td>
    <td class="text-center">{{$value->invoice_date !="" ? date('d/m/Y',strtotime($value->invoice_date)) :''}}</td>
    <td class="text-center">{{$value->patient_name}}</td>
    <td class="text-center">{{$value->patient_code}}</td>
    <td class="text-center">{{$value->admission_no_fk}}</td>
    <td class="text-center">{{$value->patient_age}}</td>
    <td class="text-center">{{$value->gender_txt}}</td>
    <td class="text-center">{{$value->cashier_name}}</td>
    <td class="text-right">{{number_format($value->ledger_amt_sales,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->ledger_amt_discount,2,'.','')}}</td>   
    <td class="text-right">{{number_format($value->ledger_amt_payment,2,'.','')}}</td> 
    <td class="text-right">{{number_format(($value->ledger_amt_sales ) -( $value->ledger_amt_payment +  $value->ledger_amt_discount),2,'.','')}}</td>    
</tr>
@endforeach
@endif
