<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr class="global-uhl-table-bg">
            <th>Sl.</th>
            <th class="text-center">Patient Code</th>
            <th class="text-left">Patient Name</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Donor ID</th>
            <th class="text-left">Donor Name</th>
            <th class="text-center">Cross Match ID</th>
            {{-- <th class="text-center">Component</th> --}}
            <th class="text-center">Bag No</th>
            <th class="text-center">BG</th>
            {{-- <th class="text-center">Expiry Date</th> --}}
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="">
        @if (!empty($data))
        @foreach ($data as $cross_match_data)
        <tr>
            <td style="text-align: center;">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $cross_match_data->patient_code }}</td>
            <td class="text-left">{{ $cross_match_data->patient_name }}</td>
            <td class="text-center">{{ $cross_match_data->admission_no_fk }}</td>
            <td class="text-center">{{ $cross_match_data->donor_no_fk }}</td>
            <td class="text-left">{{ $cross_match_data->donor_name }}</td>
            <td class="text-center">{{ $cross_match_data->crossmatch_no_pk }}</td>
            <td class="text-center">{{ $cross_match_data->crossmatch_no_pk }}</td>
            <td class="text-center">{{ $cross_match_data->blood_group }} </td>
            <td style="">
                <span> <a
                        href="{{ route('ipd.bag-sticker-pdf', [$cross_match_data->crossmatch_no_pk, $cross_match_data->blood_bag_no]) }}"
                        title="Bag Sticker" target="_blank"><i class="fa fa-file-pdf"> Bag Sticker</i></a> </span> <br>

                <span> <a
                        href="{{ route('ipd.cross-match-match-report', [$cross_match_data->crossmatch_no_pk, $cross_match_data->blood_bag_no]) }}"
                        title="Cross Match Report pdf" target="_blank"><i class="fa fa-file-pdf">Cross Match
                            Report</i></a> </span> <br>
                @if($cross_match_data->blood_issued_ind != '1' && Session::get('user.ses_hospital_code') == "UNICO")
                <span class="btn btn-sm btn-outline-primary open-modal" data-id=""
                    data-action="{{ route('ipd.edit-donor-cross-match', $cross_match_data->crossmatch_no_pk) }}"
                    data-modal="common-modal" data-title="Edit Donor Cross Match" title="Edit"><i
                        class="fa fa-pencil-alt"></i></span>
                @endif
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