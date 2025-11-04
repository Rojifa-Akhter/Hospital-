@if(!empty($grn_data_arr))
@php
$previousValue = null;
@endphp
@foreach($grn_data_arr as $value)
<tr>
    <input type="hidden" id="" name="pmnt_reqdtl_no_pk_{{$value->itemreceive_no_fk}}" value="{{$value->pmnt_reqdtl_no_pk}}">
    <input type="hidden" id="" name="po_no_{{$value->itemreceive_no_fk}}" value="{{$value->purchaseorder_no_fk}}">
    <input type="hidden" id="" name="challan_no_{{$value->itemreceive_no_fk}}" value="{{$value->challan_no}}">
    <input type="hidden" id="" name="store_no_{{$value->itemreceive_no_fk}}" value="{{$value->serviceunit_no_fk_ms}}">
    <input type="hidden" id="" name="supplier_no_{{$value->itemreceive_no_fk}}" value="{{$value->supplier_no_fk}}">
    <input type="hidden" id="" name="total_grn_amt_{{$value->itemreceive_no_fk}}" value="{{number_format($value->grnmst_amnt,2,'.','')}}">
    <input type="hidden" id="" name="return_amt_{{$value->itemreceive_no_fk}}" value="{{number_format($value->grnrtn_amt,2,'.','')}}">
    <input type="hidden" id="" name="current_amt_{{$value->itemreceive_no_fk}}" value="{{number_format($value->payable_amnt,2,'.','')}}">
    <td style="text-align: center;">{{$loop->iteration}}</td>
    @if($value->pmnt_reqmst_no_fk != $previousValue)
    <td rowspan="{{ $grn_data_arr->where('pmnt_reqmst_no_fk', $value->pmnt_reqmst_no_fk)->count() }}" class="text-center">
        {{ $value->pmnt_reqmst_no_fk }}  <br>{{ $value->au_entry_at !="" ? date('d/m/Y',strtotime($value->au_entry_at)):''  }}
    </td>
    @endif
    <td class="text-center">{{$value->itemreceive_no_fk}}</td>
    <td class="text-center">{{$value->purchaseorder_no_fk}}</td>
    <td class="text-center">{{$value->challan_no}}</td>
    <td>{{$value->serviceunit_name}}</td>
    <td>{{$value->supplier_name}}</td>
    <td class="text-right">{{number_format($value->grnmst_amnt,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->grnrtn_amt,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->payable_amnt,2,'.','')}}</td>
    <td class="text-center">
        @if($value->approval_ind  ==1)
        <button type="button" class="btn btn-sm btn-info">Approved</button>
        @elseif($value->accbillprocessdtl_no_pk !='')
        <button type="button" class="btn btn-sm btn-success">Sent</button>
        @endif
    </td>
    <td class="text-center">
        @php
            $condition=$value->accbillprocessdtl_no_pk !='' ? 'checked disabled':'';
        @endphp
    <input type="checkbox" id="payment_select" name="payment_select[]" class="payment_select" {{ $condition}} value="{{$value->itemreceive_no_fk}}">
        <a href="{{route('v2.grn-report-print',$value->itemreceive_no_fk)}}" target="_blank" class="btn btn-warning btn-sm">GRN</a>
        <span class="btn btn-sm btn-success open-modal btnView" data-action="{{route('show-grn-bill-progress',$value->itemreceive_no_fk)}}" data-modal="common-modal-sm" data-title="Show GRN Bill Status" title="Show GRN Bill Status" data-id="{{$value->itemreceive_no_fk}}"><i class="fas fa-eye"></i></span>
    </td>
</tr>
<?php $previousValue = $value->pmnt_reqmst_no_fk; ?>
@endforeach
@endif