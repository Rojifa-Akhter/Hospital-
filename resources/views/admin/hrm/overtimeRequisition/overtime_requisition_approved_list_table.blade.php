<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
<form action="{{ route('hrm.overtime_requisition_approve') }}" method="POST" id="ov_requisition_approve"
class="">
    @csrf
    <table class="table  table-bordered ">
        <thead class="global-uhl-table-bg">
            <tr>
                <td class="text-center" scope="col">#SL</td>
                <td class="text-left" scope="col">Employee Name</td>
                <td class="text-left" scope="col">Employee Card</td>
                <td class="text-left" scope="col">Dept.</td>
                <td class="text-left" scope="col">Approved By(1st)</td> 
                {{-- <td class="text-left" scope="col">Approve Date(1st)</td>  --}}
                <td style="width:8%" class="text-left" scope="col">Actual OT</td>
                <td style="width:8%" class="text-left" scope="col">Approved OT</td>
                <td class="text-left" scope="col">Status</td>
                <td class="text-center" scope="col">Action</td>
            </tr>
        </thead>

        @if (!empty($overtimeRequisitiondata))
            @foreach ($overtimeRequisitiondata as $data)
                <tr>
                    <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                    <td class="text-left" scope="col">{{ $data->full_name }}</td>
                    <td class="text-left" scope="col"> {{ $data->person_card_no }}</td>
                    <td class="text-left" scope="col">
                        {{ $data->department != '' ? $data->department : '' }}</td>
                        <td class="text-left" scope="col"> {{ $data->user_fullname }}</td>
                        {{-- <td class="text-left" scope="col"> {{ isset($data->approve_date) ? date('d-m-Y', strtotime($data->approve_date)) : "" }}</td> --}}
                    <td class="text-left" scope="col">
                        <?php
                        $actHour = floor($data->actual_ot_time / 60) > 0 ? floor($data->actual_ot_time / 60).' hr ' : '';

                        $actMin = ($data->actual_ot_time -  floor($data->actual_ot_time / 60) * 60) > 0 ?($data->actual_ot_time -  floor($data->actual_ot_time / 60) * 60). ' min' : '';
                    ?>
                        {{ $actHour}} {{$actMin}}
                    </td>
                    <td class="text-left" scope="col">
                        <?php
                        $hour = floor($data->ot_time / 60) > 0 ? floor($data->ot_time / 60).' hr ' : '';

                        $min = ($data->ot_time -  floor($data->ot_time / 60) * 60) > 0 ?($data->ot_time -  floor($data->ot_time / 60) * 60). ' min' : '';
                    ?>
                        {{ $hour}} {{$min}}
                    </td>
                   
                    <td class="text-left" scope="col">
                        {!! isset($data->finalize_ind) 
                            ? '<span class="badge badge-primary">finalized</span>' 
                            : '<span class="badge badge-danger">pending</span>' !!}
                    </td>
                    <td class="text-center">
                        <a style="cursor:pointer" class="open-modal btn btn-sm btn-secondary" data-action="{{ route('hrm.overtime_requisition_approved_detail',[$data->person_no_fk, $data->attendance_yyyymm, $data->finalize_ind]) }}"  data-modal="common-modal-sm" data-title="Overtime Requisition Approved Detail"  title="Detail">
                            <i class="fa fa-eye" aria-hidden="true" style="color: #fff !important"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
                <tr>
                    <td class="text-center" colspan="8">No data here</td>
                </tr>
        @endif
    </table>

</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
    $(document).on("click", ".print", function(e) {

            var itemArray = $(".cheque_item")
                .map(function() {
                    if ($(this).is(":checked")) {
                        return this.value;
                    }
                }).get();
            if (itemArray == "") {
                alert("Please Select Item");
                return false;
            }
            // $('form').attr('action', "{{ route('cheque-print-all') }}");

    });
    $('#PathselectAll').click(function(e) {
        if ($('#PathselectAll').is(':checked')) {
            $('.requisition_item').prop('checked', true);
        } else {
            $('.requisition_item').prop('checked', false);
        }
    });
</script>
