@if(!empty($class_data))
    @foreach($class_data as $value)
    <tr>
    <td class="text-center">{{$loop->iteration}}</td>
    <td class="text-center class_id" >{{$value->assetclass_no_pk}}</td>
    <td class="text-center class_uid" >{{$value->assetclass_uid}}</td>
    <td class="text-left class_name" >{{$value->assetclass_name}}</td>
    <td class="text-center">
        <span class="btn btn-sm btn-primary" onclick="editClass(this)"><i class="fa fa-pencil-alt"></i></span>
    </td>
</tr>
    @endforeach
@endif
