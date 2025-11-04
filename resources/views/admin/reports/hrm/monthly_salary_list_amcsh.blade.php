<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{ route('hrm.specific_salary_sheet_data_update2') }}" method="POST" id="specific_salary_id" class="">
    @csrf
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-center">Card No</th>
                <th class="text-center">Name</th>
                <th class="text-center">Designation</th>
                <th class="text-center">Joining Date</th>
                <th class="text-center">Gross Salary</th>
                <th class="text-center">Avg. Duty Hr</th>
                <th class="text-center">Total Day of Month</th>
                <th class="text-center">Weekends</th>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Absent Cut.</th>
                <th class="text-center">Payable Days</th>
                <th class="text-center">Leave</th>
                <th class="text-center">Salary Payable</th>
                <th class="text-center">Overtime Hr</th>
                <th class="text-center">Overtime Pay</th>
                <th class="text-center">Total Payable Amt.</th>
                <th class="text-center">Signature</th>

            </tr>

        </thead>
        <?php
        $total_salary_pay = 0;
        $total_overtime_hr = 0;
        $total_overtime_pay = 0;
        $total_payable = 0;
        ?>
        @if (isset($value))
            @foreach ($value as $data)
                @php
                    $desig = $data->designation_name;
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $data->card_no }}</td>
                    <td class="text-left">{{ $data->full_name }}</td>
                    <td class="text-left">{{ $desig ? "$desig" : '' }}</td>
                    <td class="text-left">
                        {{ isset($data->join_date) ? date('d-m-Y', strtotime($data->join_date)) : '' }}</td>
                    {{-- <td class="text-left">{{$data->join_date ? date('d-m-Y', strtotime($data->join_date)) : ""}}</td> --}}
                    <!-- <td class="text-center">00</td>
                <td class="text-center">00</td> -->

                    <td class="text-right gross_salary">{{ number_format($data->gross_salary, 2) }}</td>
                    <input type="hidden" name="hidden_gross_salary[]" class="hidden_gross_salary"
                        value="{{ floatval($data->gross_salary) }}" />
                    <td class="text-right"></td>
                    <td class="text-right">{{ $totalDaysInMonth ? $totalDaysInMonth : '' }}</td>
                    <?php
                    $attendance_days = $data->attendance_days - ($data->absent_days + $data->leave_withoutpay_days);
                    $holiday = $attendance_days - $data->working_days;
                    ?>
                    <td class="text-right">{{ $weekendCount ? $weekendCount : '' }}</td>
                    <td class="text-right">{{ $totalDaysInMonth - $data->absent_days - $data->leave_days }}</td>
                    <?php
                    $presentdays = $totalDaysInMonth - $data->absent_days - $data->leave_days;
                    ?>
                    <td class="text-right">{{ number_format($data->absent_days) }}</td>
                    <td class="text-right"><input type="number" class="form-control income_tax" name="income_tax[]"
                            placeholder="Abs. Cut" value="{{ number_format($data->incometax_deduct_amount) }}"
                            onkeyup="handleAbsentCut(this)" /></td>

                    <td class="text-right">{{ $presentdays }}</td>
                    <td class="text-right">{{ $data->leave_days }}</td>
                    <td class="text-right total_deduction">
                        {{ number_format(abs($data->gross_salary - $data->incometax_deduct_amount)) }}</td>
                    <input type="hidden" class="hidden_total_deduction"
                        value="{{ floatval($data->gross_salary - $data->incometax_deduct_amount) }}" />
                    <td class="text-center">
                        {{-- <input type="number"  class="form-control" name="rs[]" placeholder="Overtime Hr" value="{{ number_format($data->revenue_stamp ? $data->revenue_stamp : $data->overtime_hours) }}"/> --}}
                        @if (isset($data->ot_time))
                            <?php
                            $hour = floor($data->ot_time / 60);

                            $min = $data->ot_time - floor($data->ot_time / 60) * 60;
                            ?>

                            {{ $hour }} : {{ $min }} hr
                        @else
                            0
                        @endif
                    </td>

                    {{-- <td class="text-right"><input type="number"  class="form-control night_allowances" name="night_allowances[]" placeholder="Overtime Pay" value="{{ $data->night_allowance ? $data->night_allowance : "0"}}" onkeyup="handleOvertimePay(this)"/></td> --}}
                    <td class="text-right">
                        @if (isset($data->ot_time) && $data->working_hour != 0)
                            @php
                                $strTime = $hour . '.' . $min;
                                $floatTime = floatval($strTime);
                                $working_hour = ($data->working_hour != 0) ? $data->working_hour : 1;
                                $overtimePayAmt = round(($data->gross_salary / 30 / $working_hour) * $floatTime);
                            @endphp
                        @else
                            @php
                                $floatTime = 0;
                                $overtimePayAmt = 0;
                            @endphp
                        @endif
                        {{ number_format($overtimePayAmt) }}
                        <input type="hidden"class="over_time_pay_amt" value="{{ intval($overtimePayAmt) }}" />

                    </td>
                    <td class="text-right net_payable_amount">
                        @php
                            $total_payable_amount = $data->gross_salary - $data->incometax_deduct_amount + $overtimePayAmt;
                        @endphp
                        {{ number_format($total_payable_amount) }}
                    </td>
                    <td class="text-right"></td>
                    <input type="hidden" name="salary_hdn_id" id="salary_hdn_id"
                        value="{{ $data->monthly_salary_no_pk }}" />
                    <input type="hidden" name="ids[]" value="{{ $data->monthly_salary_no_pk }}" />
                    <input type="hidden" name="advances[]" value="" />

                </tr>

                <?php
                $salary_pay = $data->gross_salary - $data->incometax_deduct_amount;
                $total_salary_pay = $total_salary_pay + $salary_pay;
                $total_overtime_hr = $total_overtime_hr + $floatTime;
                $total_overtime_pay = $total_overtime_pay + $overtimePayAmt;
                $total_payable = $total_payable + $total_payable_amount;
                ?>
            @endforeach
            <tr>
                <td class="text-right table-td" style="text-align: center;" colspan="14"><strong>Total</strong></td>
                <td class="text-right table-td" style="text-align: right;">
                    <strong>{{ number_format($total_salary_pay, 2) }}</strong>
                </td>
                <td class="text-right table-td" style="text-align: right;"><strong>
                        {{number_format($total_overtime_hr, 2)}}
                    </strong></td>
                <td class="text-right table-td" style="text-align: right;">
                    <strong>{{ number_format($total_overtime_pay, 2) }}</strong>
                </td>
                <td class="text-right table-td" style="text-align: right;">
                    <strong>{{ number_format($total_payable, 2) }}</strong>
                </td>
                <td class="text-right table-td" style="text-align: right;"></td>

            </tr>
        @endif

    </table>
    <div style="text-align:center;">
        @php
            $response_action = route('hrm.monthly_salary_sheet_jk');
        @endphp
        <button type="button" class="btn btn-success btn-md text-center mt-2"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
    </div>
</form>

<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
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


    function handleAbsentCut(element) {
        let hidden_gross_salary = Number($(element).parents('tr').find('.hidden_gross_salary').val());

        // let payable_amount = Number(basic_salary);
        // let night_allowances = parseInt($(element).parents('tr').find('.night_allowances').val().replace(/,/g, ""));
        let over_time_pay_amt = Number($(element).parents('tr').find('.over_time_pay_amt').val());
        let income_tax = parseInt($(element).val().replace(/,/g, ""));
        let total_deduction = Number(hidden_gross_salary - income_tax);
        let net_payment = Number(hidden_gross_salary - income_tax + over_time_pay_amt);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
    }


    // function handleOvertimePay(element){

    //     let hidden_gross_salary = Number($(element).parents('tr').find('.hidden_gross_salary').val());
    //     let night_allowances = parseInt($(element).val().replace(/,/g, ""));
    //     let income_tax = parseInt($(element).parents('tr').find('.income_tax').val().replace(/,/g, ""));
    //     let net_payment = Number(hidden_gross_salary - income_tax + night_allowances);

    //     $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
    // }



    function debounce(func, timeout = 200) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                func.apply(this, args);
            }, timeout);
        };
    }



    function deleteSalaryData(element) {
        var salary_id = $(element).siblings('#salary_hdn_id').val();
        //alert(salary_id);


        if (confirm('Are you sure ?')) {
            $.ajax({
                data: {
                    salary_id: salary_id
                },
                url: "{{ route('hrm.delete-monthly_salary_sheet') }}",
                type: 'get',
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $(element).parents("tr").remove();
                    // $(this).closest("tr").remove();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-body').html("Delete successfully");
                },
                complete: function() {

                    $.unblockUI();

                }
            });
        }
        element.preventDefault();
    }
</script>
