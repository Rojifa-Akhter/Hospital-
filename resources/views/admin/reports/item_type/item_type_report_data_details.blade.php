<?php
$doctor_name = !empty($report_data) ? $report_data[0]->finalize_by : '';
?>
<table class="table data-table table-bordered table-hover table-striped data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-left" colspan="4">{{ ucfirst($doctor_name) }}</th>
        </tr>
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">No Of Test</th>

        </tr>


    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ ucfirst($data->item_name) }} Patient</td>
                    <td class="text-left">{{ ucfirst($data->deparment) }}</td>
                    <td class="text-center">{{ $data->no_of_test }}</td>
                </tr>
                <div style="display: none">{{ $total += $data->no_of_test }}</div>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total =</th>
            <th class="text-center bg-light-blue">{{ $total }}</th>
        </tr>
    </tfoot>
</table>
