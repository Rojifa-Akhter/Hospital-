<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr class="global-uhl-table-bg">
            <th>Sl.</th>
            <th class="text-left">Patient Code</th>
            <th class="text-left">Patient Name</th>
            <th class="text-center">Cross Match ID</th>
            <th class="text-center">Blood Group</th>
            <th class="text-center">Bag No</th>
            <th class="text-center">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="">
        @if (!empty($data))
        @foreach ($data as $datas)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $datas->patient_code }}</td>
            <td class="text-left">{{ $datas->patient_name }}</td>
            <td class="text-center">{{ $datas->crossmatch_no_pk }}</td>
            <td class="text-center">{{ $datas->blood_group }}</td>
            <td class="text-center">{{ $datas->crossmatch_no_pk }} </td>
            {{-- <td class="text-center">{{ $datas->blood_bag_no }} </td> --}}
            <td class="text-center">
                @if($datas->received_ind == null && $datas->blood_issued_ind == 1)
                    <span class="badge badge-danger">Pending</span>
                @else
                    <span class="badge badge-success">Received</span>
                @endif
            </td>
            <td style="" width="20%">
                @if($datas->received_ind == null && $datas->blood_issued_ind == 1)
                <span>
                    <button title="Blood Received" id="{{ $datas->crossmatch_no_pk }}"
                        class="btn btn-sm btn-success blood_received_button">Receive</button>
                </span>
                @endif
                @if($datas->received_ind == 1 && $datas->blood_issued_ind == 1)
                <span>
                    <button title="Blood Return" id="{{ $datas->crossmatch_no_pk }}"
                        class="btn btn-sm btn-warning blood_return_button">Return</button>
                </span>
                @endif
                <span> <a
                        href="{{ route('ipd.blood-bag-issue-report', [$datas->crossmatch_no_pk, $datas->blood_bag_no]) }}"
                        title="Cross Match Report pdf" target="_blank" class="btn btn-sm btn-primary"><i
                            class="fa fa-file-pdf"> Issue Report</i></a> </span>
            </td>
        </tr>
        @endforeach
        @endif

    </tbody>
</table>
<script>
    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable('.data-table')) {
            $('.data-table').DataTable().destroy(); // Destroy existing instance
        }
        // Reinitialize DataTable
        $('.data-table').DataTable({
            "ordering": true,
            "searching": true,
            "lengthMenu": [10, 20, 50, 75, 100],
            "pageLength": 10, // Number of entries per page
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>