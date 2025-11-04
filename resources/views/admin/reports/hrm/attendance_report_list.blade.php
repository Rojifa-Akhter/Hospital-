<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
<thead class="global-uhl-table-bg">
    <tr>
        <td class="text-center" scope="col">#SL</td>
        <td class="text-left" scope="col">Card No</td>
        <td class="text-left" scope="col"> Name</td>
        <td class="text-left" scope="col">Designation</td>
        <td class="text-left" scope="col">In Time</td>
        <td class="text-left" scope="col">Out Time</td>
        <td class="text-left" scope="col"> Early Out </td>
        <td class="text-left" scope="col">OTH</td>
        <td  class="text-left" scope="col" >Late Note</td>
        <td class="text-left" scope="col">Remark</td>
    </tr>
</thead>

@if(isset($value))
@foreach($value as $data)

<tr>
    <td class="text-center" scope="col">{{$loop->iteration}}</td>
    <td class="text-left" scope="col">{{$data->person_card_no}}</td>
    <td class="text-left" scope="col">{{$data->full_name}}</td>
    <td class="text-left" scope="col">{{$data->designation_name}}</td>
    <td class="text-left" scope="col">{{ isset($data->in_time) ? date('h:i a',strtotime($data->in_time)) : '' }}</td>
    <td class="text-left" scope="col">{{ isset($data->out_time) ? date('h:i a',strtotime($data->out_time)) : '' }}</td>
    <td class="text-left" scope="col">{{ isset($data->early_time_min) ? $data->early_time_min : '' }}</td>
    <td class="text-left" scope="col">{{ ($data->over_time_min == 0)? '' : $data->over_time_min }}</td>
    <td class="text-left" scope="col">{{$data->late_early_leave_note}}</td>
    <td class="text-left" scope="col">{{$data->conflict_comments}}</td>
</tr>
@endforeach
@endif
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    // $('.data-table').DataTable();
    $('.data-table').DataTable( {
        "lengthMenu": [[ 50], [50]]
    } );
</script>
