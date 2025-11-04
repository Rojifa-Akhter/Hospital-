@if(!empty($sql))
@foreach($sql as $value)
<tr>
    <td class="text-center">{{$loop->iteration}}</td>
    <td class="text-left">{{$value->person_code}}</td>
    <td class="text-left">{{$value->full_name}}</td>
    <td class="text-left">{{$value->phone_mobile}}</td>
    <td style="width:150px;"> <button class="btn btn-primary btn-md open-modal" data-modal="common-modal-sm" data-action="{{ url('/employee-card-issue-popup/'. $value->person_no_pk) }}" data-title="Create Card Issue" title="Create Card Issue"><i class="fa fa-plus"></i> Add Card</button></td>
</tr>
@endforeach
@endif
