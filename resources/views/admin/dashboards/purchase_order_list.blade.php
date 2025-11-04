@if(!empty($purchase_order))
    @foreach($purchase_order as $data)
        <tr>
            <td class="text-center">{{!empty($data->purchaseorder_no_pk)?$data->purchaseorder_no_pk:''}}</td>
            <td class="text-center">{{!empty($data->inv_requisition_no_fk)?$data->inv_requisition_no_fk:''}}</td>
            <td class="text-center">{{!empty($data->user_name)?$data->user_name:''}}</td>
            <td class="text-center">{{!empty($data->purchase_date)?date("d/m/Y", strtotime($data->purchase_date)):''}}</td>
            <td class="text-center">{{!empty($data->item_name)?$data->item_name:''}}</td>
            <td class="text-right">{{($data->approved_qty) * ($data->sales_price) }}<small>tk</small></td>
        </tr>
    @endforeach
@endif
