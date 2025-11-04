
    <h4 style="margin-top: 20px; text-align:center;">{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
    <div style="margin-top: 20px; text-align:center;">
        <h5 style="margin-bottom: 10px; text-transform:uppercase;">Purchase Requisition {{$title}}</h5>
        <h6 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
    </div>

    <table style="width:100%">
        <thead>
            <tr>
                <th style="font-size:10px;border:1px solid #000000;">SL</th>
                <th style="font-size:10px;border:1px solid #000000;">PR No</th>
                <th style="font-size:10px;border:1px solid #000000; text-align:left">PR Date</th>
                <th style="font-size:10px;border:1px solid #000000;">Indent No</th>
                <th style="font-size:10px;border:1px solid #000000;">Item No</th>
                <th style="font-size:10px;border:1px solid #000000;">Item Name</th>
                <th style="font-size:10px;border:1px solid #000000;">UoM</th>
                <th style="font-size:10px;border:1px solid #000000;">Main Store</th>
                <th style="font-size:10px;border:1px solid #000000;">PR Qty</th>
                <th style="font-size:10px;border:1px solid #000000;">PO Qty</th>
                <th style="font-size:10px;border:1px solid #000000;">GRN Qty</th>
                <th style="font-size:10px;border:1px solid #000000;"> Status</th>
                <th style="font-size:10px;border:1px solid #000000;">Approval Status</th>
            </tr>                                                                  
        </thead>

        <tbody>
            @foreach($datas as $item)
                <tr>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $loop->iteration }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;text-align:center">{{ $item->pr_no}}  </td>
                    <td style="font-size:10px;border:1px solid #8a8888;text-align:left">{{ $item->pr_date !="" ?date('d/m/Y',strtotime($item->pr_date)) :'' }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888; text-align:center">{{ $item->indent_no }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;text-align:center">{{ $item->item_no_fk }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->item_name }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->uom_name }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->main_store_name }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->pr_qty }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->po_qty }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;">{{ $item->grn_qty }}</td>
                    <td style="font-size:10px;border:1px solid #8a8888;text-align:center">
                    @if($item->pr_status == 2)
                    Pending
                    @elseif($item->pr_status == 3)
                    Partial
                    @endif                   
                    </td>
                    <td style="font-size:10px;border:1px solid #8a8888;text-align:center">{{ $item->approval_status }}</td>
                </tr>
            @endforeach     
        </tbody>
        
    </table>


