 <link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">

 <table id="" class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
 <thead class="bg-light">
    <tr>
        <th class="text-left">SL</th>
        <th class="text-left"  >Name</th>
        <!-- <th class="text-left">Photo</th> -->
    </tr>
</thead>
<tbody>
    @if(!empty($emp_info))
    @foreach($emp_info as $value)
    <tr>
        <td class="text-center">  {{ $loop->iteration  }}  </td>
        <td class="text-left">
            <input type="hidden" name="" id="emp_hidden" value="{{$value->user_no_pk}}">
            <div id="emp_id" class="emp_id cursor-pointer"> {{ $value->full_name . ' (' . $value->user_code . ')'  }}</div>
             </td>
        <!-- <td class="text-left">
        @if(!empty($value->photo_name))
            <img src="{{asset('img/uploads/doctor_images/thumb/')}}/{{ $value->photo_name}} ">

            @else
            <img src="{{asset('img/doctor.png')}}" width="60%">
            @endif
             </td> -->
    </tr>
    @endforeach
    @endif
</tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script >

    $(".data-table").DataTable({
        "ordering": false,
             "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": true,
             "lengthMenu": [
            [10],
            [10]
        ]
            });
</script>
