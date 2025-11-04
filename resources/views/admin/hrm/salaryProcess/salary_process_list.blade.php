<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <!-- <th class="text-center" scope="col">#SL</th> -->
            <th class="text-left" scope="col">Year-Month</th>
            <th class="text-center" scope="col">Card No</th>
            <th class="text-center" scope="col">Emp. Name</th>
            <!-- <th class="text-left" scope="col">Desig</th> -->
            <th class="text-left" scope="col">Dept</th>
            <th class="text-left" scope="col">Grade</th>
            <th class="text-left" scope="col">Gross</th>
            <th class="text-left" scope="col">Basic</th>
            <th class="text-left" scope="col">Medical</th>
            <th class="text-left" scope="col">House</th>
            <th class="text-left" scope="col">Att Bonus</th>
            <th class="text-left" scope="col">Conveyance</th>
            <th class="text-left" scope="col">Utility</th>
            <th class="text-left" scope="col">Other Allocation</th>
            <th class="text-left" scope="col">Festival</th>
            <th class="text-left" scope="col">PF</th>
            <th class="text-left" scope="col">Loan</th>
            <th class="text-left" scope="col">Advance</th>
            <th class="text-left" scope="col">At. Deduction</th>
            <th class="text-left" scope="col">oth. Deduction</th>
            <!-- <th class="text-left" scope="col">Status</th> -->
            <!-- <th class="text-left" scope="col">Entry Status</th> -->
            <!-- <th class="text-center" scope="col">Action</th> -->
        </tr>
    </thead>
    <tbody>

        @if(isset($data))
        @foreach($data as $sample_row)
        <tr>
            <td>{{ $sample_row->salary_yyyymm}}</td>
            <td>{{ $sample_row->card_no }}</td>
            <td>{{ $sample_row->full_name }}</td>
            <td>{{ $sample_row->serviceunit_name }}</td>
            <td>{{ $sample_row->grade_name }}</td>
            <td>{{ $sample_row->gross_salary }}</td>
            <td>{{ $sample_row->basic_salary }}</td>
            <td>{{ $sample_row->medical_allowance }}</td>
            <td>{{ $sample_row->house_rent }}</td>
            <td>{{ $sample_row->attendance_bonus }}</td>
            <td>{{ $sample_row->conveyance_allowance }}</td>
            <td>{{ $sample_row->utility_allowance }}</td>
            <td>{{ $sample_row->other_allowance }}</td>
            <td>{{ $sample_row->festival_bonus_amount }}</td>
            <td></td>
            <td>{{ $sample_row->loan_deduct_amount }}</td>
            <td></td>
            <td>{{ $sample_row->att_deduct_amount }}</td>
            <td></td>

        </tr>
        @endforeach
        @endif

    </tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
  $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ]
    });
</script>
