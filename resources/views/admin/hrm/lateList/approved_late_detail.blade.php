<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <div class="form-group row">
            <div class="col-md-12">
                <div style="font-size: 14px">
                    <p class="mb-0">Employee Name: <strong>{{ $lateDeductiondata[0]->full_name }}</strong></p>
                    <p class="mb-0">Card No.: <strong>{{ $lateDeductiondata[0]->person_code }}</strong></p>
                    <p class="mb-0">Department: <strong>{{ $lateDeductiondata[0]->department }}</strong></p>
                    @php
                       use Carbon\Carbon;
                        $yearMonth =  $lateDeductiondata[0]->deduction_month ; 
                        preg_match('/^(\d{1,2})(\d{4})$/', $yearMonth, $matches);
                        $monthNumber = $matches[1]; 
                        $year = $matches[2]; 
                        $date = Carbon::createFromFormat('n-Y', "$monthNumber-$year");
                        $formattedDate = $date->format('F, Y');
                    @endphp
                    <p class="">Month Year: <strong>{{ $formattedDate }} </strong>
                    </p>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="global-uhl-table-bg">
                        <td>#SL</td>
                        <td class="text-center">Deduction Type</td>
                        <td class="text-center">Leave Code</td>
                        <td class="text-center">No. Of Days</td>
                    </thead>
                    <tbody>
                        @foreach ($lateDeductiondata as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{$data->deduction_type}}</td>
                                <td class="text-center">{{$data->leave_code}}</td>
                                <td class="text-center">{{$data->no_of_days}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    $(".timepicker").timepicker({
        defaultTime: new Date(),
        interval: false,
        // 'timeFormat': '24'
        // showInputs: false,
        showMeridian: false,
        minuteStep: 1,
        // setTime: null
    });
</script>
