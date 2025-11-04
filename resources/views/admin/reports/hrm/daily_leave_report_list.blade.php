<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <td class="text-center" scope="col">#SL</td>
                            <td class="text-left" scope="col">Card No</td>
                            <td class="text-left" scope="col"> Name</td>
                            <td class="text-left" scope="col">Designation</td>
                            <td class="text-left" scope="col">Date Of Joining</td>
                            <td class="text-left" scope="col">Day From</td>
                            <td class="text-left" scope="col"> Day To </td>
                            <td class="text-left" scope="col">Leave Count</td>
                            <td class="text-left" scope="col">Reason</td>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($value))
                            @foreach($value as $data)
                            <?php
                            $date1 = date_create($data->from_date);
                            $date2 = date_create($data->to_date);
                            $diff = date_diff($date1, $date2);
                            $diff_date = $diff->format("%a");
                            ?>
                        <tr>
                            <td class="text-center" scope="col">{{$loop->iteration}}</td>
                            <td class="text-left" scope="col">{{$data->person_code}}</td>
                            <td class="text-left" scope="col"> {{$data->full_name}}</td>
                            <td class="text-left" scope="col">{{$data->designation_name}}</td>
                            <td class="text-left" scope="col">{{date('d/m/Y',strtotime($data->join_date))}}</td>
                            <td class="text-left" scope="col">{{date('d/m/Y',strtotime($data->from_date )) }}</td>
                            <td class="text-left" scope="col"> {{ date('d/m/Y',strtotime($data->to_date))}} </td>
                            <td class="text-right" scope="col">{{$diff_date}}</td>
                            <td class="text-left" scope="col">{{$data->leave_reason}}</td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
  $('.data-table').DataTable( {
        "lengthMenu": [[ 50], [50]]
    } );

</script>
