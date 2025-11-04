<table class="table data-table table-bordered table-hover table-striped data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Punch Time</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($punch_dt))
            @foreach ($punch_dt as $dt => $data)

                <?php
                $myString = $dt;
                $emp_dt = explode('~', $myString);
                ?>
                <tr>
                    <td class="text-left" colspan="2">Name: <strong>{{ $emp_dt[0] }}</strong> Date:
                        <strong>{{ $emp_dt[1] != '' ? date('d/m/Y', strtotime($emp_dt[1])) : '' }}</strong>
                    </td>
                </tr>
                @foreach ($data as $punc_details)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $punc_details->attandance_data != '' ? date('h:i a', strtotime($punc_details->attandance_data)) : '' }}</td>

                    </tr>
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>
