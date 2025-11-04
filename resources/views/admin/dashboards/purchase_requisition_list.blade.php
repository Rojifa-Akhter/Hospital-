@if(!empty($purchase_requisition))
    @foreach($purchase_requisition as $data)
        <tr>
            <td class="text-center">{{!empty($data->pvmsno)?$data->pvmsno:''}}</td>
            <td class="text-left">{{!empty($data->user_name)?$data->user_name:''}}</td>
            <td class="text-center">{{!empty($data->inv_requisition_date)?date("d/m/Y", strtotime($data->inv_requisition_date)):''}}</td>
            <td class="text-left">{{!empty($data->user_name)?$data->user_name:''}} </td>
            <td class="text-right">{{!empty($data->amount)?$data->amount:''}} <small>tk</small></td>
        </tr>
    @endforeach
@endif
