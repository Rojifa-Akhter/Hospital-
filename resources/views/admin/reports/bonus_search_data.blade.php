<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
    <tr class="global-uhl-table-bg">
        <th class="text-center" rowspan="2">SL#</th>
        {{-- <th class="text-center">Date</th> --}}
        <th class="text-center" rowspan="2">Name</th>
        <th class="text-center" rowspan="2">Join Date</th>
        <th class="text-center" rowspan="2">Present Date</th>
        {{-- <th class="text-center">Card No.</th> --}}
        <th class="text-center" colspan="2">Duration</th>
        <th class="text-center" rowspan="2">Gross Salary</th>
        <th class="text-center" rowspan="2">Bonus Percentage</th>
        <th class="text-center" rowspan="2">Bonus(Tk)</th>
        <th class="text-center" rowspan="2">Action</th>
    </tr>
    <tr>
        <th class="text-center">Year</th>
        <th class="text-center">Month</th>
    </tr>
    </thead>
    <tbody>

    @if(!empty($data))
        @foreach($data as $value)
            <tr>
                <td class="text-center">{{$loop->iteration}}</td>
                <td class="text-left">{{$value->full_name}} <strong> {{!empty($value->designation_name)? "(".$value->designation_name.")" : ''}}</strong> </td>
{{--                 <td class="text-left">{{$value->person_code}}</td> --}}
                <td class="text-left">{{!empty($value->join_date)?date('d/m/Y',strtotime($value->join_date)): ''}}</td>
                <td class="text-left"> {{date('d/m/Y')}}</td>
{{--                <td class="text-left"></td>--}}
{{--                <td class="text-left"></td>--}}
                <td class="text-left">
                    <?php
                    $this_month1 = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                    $start_month1 = \Carbon\Carbon::parse(date('Y-m-d',strtotime($value->join_date)))->floorMonth(); // returns 2019-06-01
                    $diffYear = $start_month1->diffInYears($this_month1);  // returns 1

                    ?>
                    {{ $diffYear }}
                </td>
                <td class="text-left">
                    <?php
                    $this_month = \Carbon\Carbon::parse(date('Y-m-d'))->floorMonth(); // returns 2019-07-01
                    $start_month = \Carbon\Carbon::parse(date('Y-m-d',strtotime($value->join_date)))->floorMonth(); // returns 2019-06-01
                    $diff = $start_month->diffInMonths($this_month);  // returns 1
                    $diffMonth = $diff % 12;
                    ?>
                    {{ $diffMonth }}

                </td>
                <td class="text-left">{{$value->gross_salary}}</td>
                <td class="text-left">
                    @if($diff < 3)
                        {{ '10%' }}
                    @elseif($diff == 3 || $diff < 6)
                        {{ '30%' }}
                    @elseif($diff == 6 || $diff < 12)
                        {{ '40%' }}
                    @else
                        {{ '50%' }}

                    @endif
                </td>
                <td class="text-left">
                    @if($diff < 3)
                        {{ ($value->gross_salary) * 10/100 }}
                    @elseif($diff == 3 || $diff < 6)
                        {{ ($value->gross_salary) * 30/100 }}
                    @elseif($diff == 6 || $diff < 12)
                        {{ ($value->gross_salary) * 40/100 }}
                    @else
                        {{ ($value->gross_salary) * 50/100 }}

                    @endif
                </td>
                <td class="text-center">
{{--                    <a Class="btn btn-sm btn-danger"--}}
{{--                       href="{{ route('hrm.bonus_salary_slip', $value->salary_no_fk) }}"--}}
{{--                       title="pdf Salary Slip" ><i class="fas fa-file-pdf"></i></a>--}}

                    <a href="{{ route('hrm.bonus_salary_slip',[$value->salary_no_fk,$value->salary_yyyymm]) }}"
                       class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                       target="_blank" data-id="{{ $value->salary_no_fk }}" id="bonus_id"
                       title="Print Bonus Pay Slip"><i class="fa fa-file-pdf"></i></a>

                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });


</script>
