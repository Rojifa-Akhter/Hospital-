
<style>
    table td {
        font-size: 15px;
        border: none;
        padding: 0px 3px;
    }
    table>tbody>tr{
        padding: 2px;
        line-height: 18px;
        margin:4px 0px;
    }
    .text-left{
        text-align:left;
    }
    .text-right{
        text-align:right;
    }
    .text-center{
        text-align: center;
    }
    .lh-10{
        line-height: 10px;
    }
    .top-bottom-border{
        border-top:1px solid #000;
        border-bottom:1px solid #000;
    }
    .top-border{
        border-top:1px solid #000;
    }
    .section-gap{
        padding-top:15px;
    }

</style>
<?php

$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();

?>
<h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name ) ? $org_info->hospital_name : ""}}</h4>           
<div class="voucher_title" style="margin-top: 0px; text-align:center;">
    <h5 style="text-transform:uppercase;margin:0px 0px">
        Purchase Order Worklist
    </h5>
    <h6 class="mb" style="text-transform: uppercase;margin:0px 0px"><b>Date:</b> @if(!empty(@$from_date)) {{date('d/m/Y', strtotime(@$from_date))}} -  @endif   @if(!empty(@$to_date)) {{date('d/m/Y', strtotime(@$to_date))}} @endif</h6>

</div>

<table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="balancesheet-table">
    <thead>
        <tr>
            <th class="text-center" style="width:5%">SL No</th>
            <th class="text-center" style="width:10%">PO No</th>
            <th class="text-center" style="width:10%">PO Date</th>
            <th class="text-center" style="width:25%">Supplier Name</th>
            <th class="text-center" style="width:10%">No of Item </th>
            <th class="text-center" style="width:20%">PO Amount</th>
            <th class="text-center" style="width:5%">Status</th>
            <th class="text-center" style="width:15%">Approval Status</th>
        </tr>                            
    </thead>
    <tbody>                   
        @if(!empty($data))
            @forelse($data as $key => $item)
            @php 
                $approve_text = '';
                $approvalStatusText = $item->approval_status_text;
                    if ($approvalStatusText != null) {
                        if (strpos($approvalStatusText, 'REJECTED') !== false || strpos($approvalStatusText, 'HOLD') !== false) {
                            $approve_text = '<a style="cursor:pointer" class="open-modal"
                                data-action="' . route('v1.my.approval.level.detail-po', '') . '/' . $item->purchaseorder_no_pk . '"
                                data-id="' . $item->purchaseorder_no_pk . '" data-modal="common-modal-sm"
                                data-title="Level Detail" title="Level Detail">
                                <span class="badge badge-warning">(' . $item->approval_level_status_text . ')</span>
                            </a>
                            <span class="text-danger">' . (strpos($approvalStatusText, 'HOLD') !== false ? 'Hold' : 'Rejected') . '</span>';
                        } else {
                            if ($item->approval_level_status_text != '') {
                                $level = explode('/', $item->approval_level_status_text);
                                $approval_status = $level[0] == $level[1] ? 'Approved' : 'Pending';
                                $approval_person = $item->approval_level_status_text != '' ? explode('/', $item->approval_level_status_text) : '';

                                if ($approval_person != '' && $approval_person[0] == $approval_person[1]) {
                                    $approve_text = '<a style="cursor:pointer" class="open-modal"
                                        data-action="' . route('v1.my.approval.level.detail-po', '') . '/' . $item->purchaseorder_no_pk . '"
                                        data-id="' . $item->purchaseorder_no_pk . '" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-success">(' . $item->approval_level_status_text . ')
                                        </span>
                                    </a>';
                                } else {
                                    $approve_text = '<a style="cursor:pointer" class="open-modal"
                                        data-action="' . route('v1.my.approval.level.detail-po', '') . '/' . $item->purchaseorder_no_pk . '"
                                        data-id="' . $item->purchaseorder_no_pk . '" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-warning">(' . $item->approval_level_status_text . ')</span>
                                    </a>';
                                }

                                $approve_text .= '<span>' . $approval_status . '</span>';
                            }
                        }
                    }
            @endphp

                <tr>
                    <td>{{++$key}}</td>
                    @if ($po_hospital_details->hospital_code == 'KPJ')
                         <td>{{$item->purchase_uid}}</td>
                    @else
                    <td>{{$item->purchaseorder_no_pk}}</td>
                    @endif
                    <td>{{$item->purchase_date}}</td>
                    <td>{{$item->supplier_name}}</td>
                    <td>{{$item->total_qty}}</td>
                    <td>{{$item->total_amount}}</td>
                    <td>{{$item->po_save_option == "ISSUE" ? 'Post' : $item->po_save_option}}</td>
                    <td>{!! $approve_text !!}</td>
                </tr>
            @empty
            <tr>
                <td style="text-align:center;color:red" colspan="8">Data Not Found</td>
            </tr>
            @endforelse
        @endif
    </tbody>
</table>
