<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
<table class="table data-table table-bordered ">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Atten.Date</td>
            <td class="text-center" scope="col" style="width:10%">Employee Card</td>
            <td class="text-left" scope="col" >Employee Name</td>
            <td class="text-left" scope="col" >Designation</td>
            <td class="text-left" scope="col">Dept.</td>
            {{-- <td style="width:17%" class="text-left" scope="col">Shift</td> --}}
            <td class="text-left" scope="col">Punch Time</td>
        </tr>
    </thead>

    @if (isset($allPunchdata))
        @foreach ($allPunchdata as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($data->check_date)) }}</td>
                <td class="text-center" scope="col"> {{ $data->card_no }}</td>
                <td class="text-left" scope="col">{{ $data->full_name }}</td>
                <td class="text-left" scope="col">
                    {{ $data->serviceunit_name != '' ? $data->serviceunit_name : '' }}</td>
                <td class="text-left" scope="col">
                    {{ $data->designation_name != '' ? $data->designation_name : '' }}</td>
                {{-- <td class="text-left" scope="col">

                    <table>
                        <tr>
                            <td class="border-0 text-left" colspan="2"> {{ $data->shift_code }} </td>

                        </tr>
                        <tr>
                            <td class="border-0 text-left"> <strong>Duty In </strong> </td>
                            <td class="border-0 text-left"> :
                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_in_time)) : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 text-left"> <strong>Duty Out </strong> </td>
                            <td class="border-0 text-left"> :
                                {{ isset($data->duty_in_time) ? date('h:i a', strtotime($data->duty_out_time)) : '' }}
                            </td>
                        </tr>
                    </table>
                </td> --}}
                <td class="text-left" scope="col">{{ $data->checktimes }}</td>
            </tr>
        @endforeach
    @endif
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
