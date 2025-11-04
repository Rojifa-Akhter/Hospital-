<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" scope="col">#SL</th>
            <th class="text-left" scope="col">Year</th>
            <th class="text-left" scope="col">Month</th>
            <th class="text-left" scope="col"> Process Description</th>
            <th class="text-left" scope="col">Salary Process Date</th>
            <th class="text-left" scope="col">Salary Process By</th>
            <th class="text-left" scope="col">Salary Process Person Qty</th>
            <th class="text-left" scope="col">Salary Lock By</th>
            <th class="text-left" scope="col">Salary Lock Date</th>
            <th class="text-left w-20" scope="col">Salary Lock </th>
        </tr>
    </thead>
    @if (isset($Salary_locked))
        @foreach ($Salary_locked as $data)
            <?php
            $m_y = $data->salary_yyyymm;
            $date = str_split($m_y, 4);

            ?>

            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-left" scope="col">{{ $date[0] }}</td>
                <td class="text-left" scope="col">
                    <?php

                    if ($date[1] == '01') {
                        $month = 'January';
                    } elseif ($date[1] == '02') {
                        $month = 'February';
                    } elseif ($date[1] == '03') {
                        $month = 'March';
                    } elseif ($date[1] == '04') {
                        $month = 'April';
                    } elseif ($date[1] == '05') {
                        $month = 'May';
                    } elseif ($date[1] == '06') {
                        $month = 'June';
                    } elseif ($date[1] == '07') {
                        $month = 'July';
                    } elseif ($date[1] == '08') {
                        $month = 'August';
                    } elseif ($date[1] == '09') {
                        $month = 'September';
                    } elseif ($date[1] == '10') {
                        $month = 'October';
                    } elseif ($date[1] == '11') {
                        $month = 'November';
                    } elseif ($date[1] == '12') {
                        $month = 'December';
                    }
                    echo $month;
                    // dd($month);
                    ?>
                </td>
                <td class="text-left" scope="col"> {{ $data->process_description }}</td>
                <td class="text-left" scope="col">{{ date('d/m/Y', strtotime($data->salary_process_date)) }}</td>
                <td class="text-left" scope="col">{{ $data->salary_process_by }}</td>
                <td class="text-center" scope="col">{{ $data->salary_process_person_qty }}</td>
                <td class="text-center" scope="col">{{ $data->salary_lock_by }}</td>
                <td class="text-center" scope="col">{{ date('d/m/Y', strtotime($data->salary_lock_date)) }}</td>
                <td class="text-center" scope="col">
                    <button type="button" class="btn btn-sm btn-success mt-0 salaryAdvice" id="salary_advice"
                        value="{{ $data->salary_lock_ind }} " @if ($data->salary_advise_ind == 1) disabled @endif>Sent
                        Salary Advise
                    </button>
                    <button type="button" class="btn btn-sm   mt-0 lookBtn" id="locked"
                        value="{{ $data->salary_lock_ind }} ">
                    </button>
                    @if ($data->salary_advise_ind == 1 && $data->salary_lock_ind == 1)
                        <button type="button" class="btn btn-sm btn-warning mt-0 journalBtn" id="journal"
                            value="{{ $data->salary_lock_ind }} "
                            @if ($data->salary_journal_ind == 1) disabled @endif>Sent To Jounral
                        </button>
                    @else
                        <button type="button" class="btn btn-sm btn-warning mt-0 journalBtn" id="journal"
                            value="{{ $data->salary_lock_ind }} " disabled>Sent To Jounral
                        </button>
                    @endif
                    <input type="hidden" name="" id="locked_hdn" value="{{ $data->process_no_pk }} ">
                    <input type="hidden" name="" id="year_month_hdn" value="{{ $data->salary_yyyymm }} ">
                </td>

            </tr>
        @endforeach
    @endif
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
