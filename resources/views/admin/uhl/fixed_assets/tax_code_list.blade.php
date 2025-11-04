
@if(!empty($tax_data))
@foreach($tax_data as $value)
<tr>
<input type="hidden" class="taxcode" id="taxcode" value="{{$value->taxcode_no_pk}}">
    <td>{{$loop->iteration}}</td>
    <td class="tax_uid">
        {{$value->taxcode_uid}}       
    </td>
    <td class="tax_forfeiture">{{$value->asset_forfeiture_ind == 1? 'Yes' : 'No'}}</td>
    <td class="tax_name">{{$value->taxcode_name}}</td>
    <td class="tax_1year">{{$value->tax_year1_pct}}</td>
    <td class="tax_2year">{{$value->tax_year2_pct}}</td>
    <td class="tax_3year">{{$value->tax_year3_pct}}</td>
    <td class="tax_4year">{{$value->tax_year4_pct}}</td>
    <td class="tax_5year">{{$value->tax_year5_pct}}</td>
    <td class="tax_totalyear">{{$value->tax_year1to5_pct}}</td>
    <td class="tax_forfeiture_ind">{{$value->asset_forfeiture_ind}}</td>
   
    <td>
    <span class="btn btn-sm btn-primary" onclick="edittax(this)"><i class="fa fa-pencil-alt"></i></span>
    </td>
</tr>
@endforeach
@endif