<div class="card">
    <div class="card-header">
        <h5>Leave List </h5>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div id="search-result" class="col-12 table-responsive">
                <table id="leave_list_table" class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-left">Leave Code</th>
                            <th class="text-left">Leave Name</th>
                            <th class="text-center">Apply Date </th>
                            <th class="text-center"> From</th>
                            <th class="text-center"> To</th>

                            <th class="text-center">Leave Request</th>
                            <th class="text-center">Reason</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($leave_status))
                            @foreach ($leave_status as $key => $element)
                                <td class="text-left">
                                    @php
                                        $words = explode(' ', $element->lookupdata_name);
                                        $acronym = '';
                                        
                                        foreach ($words as $w) {
                                            $acronym .= mb_substr($w, 0, 1);
                                        }
                                        
                                    @endphp
                                    {{-- {{ $acronym }} --}}
                                    {{ $element->leave_code }}
                                </td>
                                <td class="text-left">{{ $element->lookupdata_name }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($element->au_entry_at)) }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($element->from_date)) }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($element->to_dates)) }}</td>

                                <td class="text-center">{{ $element->total_days }}</td>
                                <td class="text-center">{{ $element->leave_reason }}</td>
                                <td class="text-center">
                                    @if ($element->approved_dept_ind == 2 || $element->approved_hr_ind == 2)
                                        <span class=" btn-danger btn-sm">Rejected</span>
                                    @elseif($element->approved_hr_ind == 1)
                                        <span class=" btn-success btn-sm">Approved</span>
                                    @else
                                        <span class=" btn-warning btn-sm">Pending</span>
                                    @endif

                                </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Leave Status </h5>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div id="search-result" class="col-12 table-responsive">
                <table id="data-table" class="data-table table-bordered table-hover table-striped mt-2 border mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-left">Leave Name</th>
                            <th class="text-left">Total Days</th>
                            <th class="text-left">Day taken</th>
                            <th class="text-left">Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($leave_info))
                            @if (!empty($leave_status))
                                @foreach ($leave_info as $leave_in)
                                    <tr>
                                        <td class="text-left">{{ $leave_in->leave_type_lkp_name }}</td>
                                        <td class="text-left">{{ $leave_in->no_of_days }}</td>
                                        @php
                                            $totalDayTaken = 0;
                                        @endphp

                                        @foreach ($leave_status as $leave_st)
                                            @if ($leave_st->leave_type_lkp_no_fk == $leave_in->leave_type_lkp_no_fk && $leave_st->approved_hr_ind == '1')
                                                @php
                                                    $totalDayTaken += $leave_st->total_days;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <td class="text-left">{{ $totalDayTaken }}</td>
                                        <td class="text-left">{{ $leave_in->no_of_days - $totalDayTaken }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#leave_list_table').DataTable({
            ordering: false,
            "pageLength": 7,
            "aLengthMenu": [
                [7, 25, 30, 50, -1],
                [7, 25, 30, 50, "All"]
            ],

        });
    });
</script>
