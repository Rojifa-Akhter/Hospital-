@if(!empty($grn_data_arr))
@php
$previousValue = null;
@endphp
@foreach($grn_data_arr as $value)
<tr>
    <td style="text-align: center;">{{$loop->iteration}}</td>
    @if($value->pmnt_reqmst_no_fk != $previousValue)
    <td rowspan="{{ $grn_data_arr->where('pmnt_reqmst_no_fk', $value->pmnt_reqmst_no_fk)->count() }}" class="text-center">
    <a target="_blank" href="{{route('supplier-payment-request-pdf',$value->pmnt_reqmst_no_fk)}}" class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a><br>
        {{ $value->pmnt_reqmst_no_fk }} <br>{{ $value->au_entry_at !="" ? date('d/m/Y',strtotime($value->au_entry_at)):''  }}
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
        @if($value->approval_ind ==1)
        <button type="button" class="btn btn-sm btn-info">Approved</button>
        @else
        <button type="button" class="btn btn-sm btn-warning"> Pending</button>
        @endif
        <a href="{{route('v2.grn-report-print',$value->itemreceive_no_fk)}}" target="_blank" class="btn btn-warning btn-sm">GRN</a>


        <span class="btn btn-sm btn-success  open-modal btnView" data-action="{{route('show-grn-bill-progress',$value->itemreceive_no_fk)}}" data-modal="common-modal-sm" data-title="Show GRN Bill Status" title="Show GRN Bill Status" data-id="{{$value->itemreceive_no_fk}}"><i class="fas fa-eye"></i></span>
    </td>
</tr>
<?php $previousValue = $value->pmnt_reqmst_no_fk; ?>
@endforeach
@endif