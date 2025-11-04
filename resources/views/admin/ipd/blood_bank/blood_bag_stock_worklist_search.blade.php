<table class="table table-striped table-bordered table-hover data-table">
    <thead class="thead-success">
        <tr class="global-uhl-table-bg">
            <th class="text-left">Sl.</th>
            <th class="text-left">Patient Code</th>
            <th class="text-left">Patient Name</th>
            <th class="text-left">Cross Match ID</th>
            <th class="text-left">Component</th>
            <th class="text-left">Blood Group</th>
            <th class="text-left">Bag No</th>
            {{-- <th class="text-center">test</th> --}}
            <th class="text-left">Expiry Date</th>
            <th class="text-center">Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            {{-- @dd($data); --}}
            @foreach ($data as $datas)
                @php
                    $component = '';
                    if ($datas->whole_blood) {
                        $component = $datas->whole_blood;
                    }

                    if ($datas->prbc_rcc_pcv) {
                        $component = $datas->prbc_rcc_pcv;
                    }
                    if ($datas->washed_prbc) {
                        $component = $datas->washed_prbc;
                    }
                    if ($datas->platalet_concentrate) {
                        $component = $datas->platalet_concentrate;
                    }

                    $component_expiry_date = '';
                    if ($datas->whole_blood_exp_date) {
                        $component_expiry_date = $datas->whole_blood_exp_date;
                    }

                    if ($datas->prbc_rcc_pcv_exp_date) {
                        $component_expiry_date = $datas->prbc_rcc_pcv_exp_date;
                    }
                    if ($datas->washed_prbc_exp_date) {
                        $component_expiry_date = $datas->washed_prbc_exp_date;
                    }
                    if ($datas->platalet_concentrate_exp_date) {
                        $component_expiry_date = $datas->platalet_concentrate_exp_date;
                    }
                    $current_date = date('d-m-Y');
                    $expiry_date = date('d-m-Y', strtotime($component_expiry_date));
                    $tr_class = $expiry_date < $current_date ? 'bg-warning' : '';

                @endphp

                <tr class="<?php echo $tr_class; ?>">
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $datas->patient_code }}</td>
                    <td class="text-left">{{ $datas->patient_name }}</td>
                    <td class="text-center">{{ $datas->crossmatch_no_pk }}</td>
                    <td class="text-center">{{ $component }}</td>
                    <td class="text-center">{{ $datas->blood_group }}</td>
                    <td class="text-center">{{ $datas->crossmatch_no_pk }} </td>
                    {{-- <td class="text-center">{{ $datas->blood_bag_no }} </td> --}}
                    <td class="text-center">
                        {{ !empty($component_expiry_date) ? date('d-m-Y', strtotime($component_expiry_date)) : '' }}
                    </td>
                    <td class="text-center">
                        @if($datas->blood_issued_ind == null && $datas->discard_ind == null && $expiry_date > $current_date)
                            <span class="badge badge-danger">Issue Pending</span>
                        @elseif($datas->blood_issued_ind == 1 && $datas->discard_ind == null && $expiry_date > $current_date)
                            <span class="badge badge-success">Issued</span>
                        @elseif($datas->blood_issued_ind == null && $datas->discard_ind == 1 && $expiry_date < $current_date)
                            <span class="badge badge-danger">Discarded</span>
                        @else
                            <span class="badge badge-danger">Expired</span>
                        @endif
                    </td>

                    <td style="" width="20%">
                        @if ($expiry_date < $current_date)
                            <span>
                                <button title="Discard" id="{{ $datas->crossmatch_no_pk }}"
                                    class="btn btn-sm btn-danger mt-1 blood_discard_button"
                                    @if ($datas->discard_ind == 1) disabled @endif>Discard</button>
                            </span>
                        @else
                            @if ($datas->blood_issued_ind != 1)
                                <span>
                                    <button title="Blood Issue" id="{{ $datas->crossmatch_no_pk }}"
                                        class="btn btn-sm btn-success blood_issue_button"> Blood Issue</button>
                                </span>
                            @else
                            @endif
                            <span>
                                <a href="{{ route('ipd.blood-bag-issue-report', [$datas->crossmatch_no_pk, $datas->blood_bag_no]) }}"
                                    title="Cross Match Report pdf" target="_blank" class="btn btn-sm btn-success"><i
                                        class="fa fa-file-pdf"> Issue Report</i></a>
                            </span>
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