@if(!empty($appointments))
    @foreach($appointments as $app_row)

<tr>
    <td class="text-center">{{$loop->iteration}}</td>
    <td class="text-center">{{'Room 137'}}</td>
    <td class="text-left">{{!empty($app_row->patient_name)?$app_row->patient_name:'N/A'}}</td>
    <td class="text-center">{{"high"}}</td>
    <td class="text-center">
        @if($app_row->appoint_status == 1)
            <span class="badge badge-warning">Waiting</span>
        @elseif($app_row->appoint_status == 2)
            <span class="badge badge-success">Prescribed</span>
        @else
            <span class="badge badge-danger">Cancel</span>
        @endif
    </td>
</tr>
    @endforeach
@endif
