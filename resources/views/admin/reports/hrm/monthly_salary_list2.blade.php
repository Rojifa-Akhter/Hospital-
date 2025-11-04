<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<form action="{{ route('hrm.specific_salary_sheet_data_update2') }}" method="POST" id="specific_salary_id"
class="">
@csrf
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" rowspan="2">SL#</th>
            {{-- <th class="text-center" rowspan="2">Card No</th> --}}
            <th class="text-center" rowspan="2">Name, Designation & Joining Date</th>
            <!-- <th class="text-center" rowspan="2">Designation</th> -->
            <!-- <th class="text-center" rowspan="2">AD</th>
                <th class="text-center" rowspan="2">PD</th> -->
            <th class="text-center" rowspan="2">Gross Salary</th>
            <th class="text-center" colspan="3">Salary Stracture</th>
            <th class="text-center" rowspan="2">Convance, D/A & Other Allowance</th>
            <th class="text-center" rowspan="2">Total Attn.</th>
            {{-- <th class="text-center" rowspan="2">Attend Bonus</th> --}}
            {{-- <th class="text-center" rowspan="2">Others</th>
            <th class="text-center" colspan="3">Ovetime</th> --}}
            <!-- <th class="text-center" rowspan="2">Payable Wages</th> -->
            <!-- <th class="text-center" rowspan="2">Late Count</th>
                <th class="text-center" rowspan="2">Deduct Hours</th> -->
            {{-- <th class="text-center" colspan="10">Deduction</th> --}}
            <th class="text-center" rowspan="2">Payable Amount</th>
            <th class="text-center" rowspan="2">Night Allowance</th>
            <th class="text-center" rowspan="2">Absent</th>
            <th class="text-center" rowspan="2">Advance</th>
            <th class="text-center" rowspan="2">In. Tax</th>
            <th class="text-center" rowspan="2">R/S</th>
            <th class="text-center" rowspan="2">Total Deduction</th>
            <th class="text-center" rowspan="2">Net Payable</th>
            {{-- <th class="text-center" rowspan="2">Receipint Signature</th> --}}
            <th class="text-center" rowspan="2">Action</th>
        </tr>
        <tr>

            <td class="text-center">Basic</td>
            <td class="text-center">House Rent</td>
            <td class="text-center">Medical</td>

            {{-- <td class="text-center">Min</td>
            <td class="text-center">Rate</td>
            <td class="text-center">Amount</td>

            <td class="text-center">Late Day</td>
            <td class="text-center">Leave Day</td>
            <td class="text-center">Leave WP day</td>
            <td class="text-center">Abs Day</td>
            <td class="text-center">Pre Day</td>
            <td class="text-center">Abs Deduct Amt</td>
            <td class="text-center">Residence fee </td>
            <td class="text-center">Loan </td>
            <td class="text-center">SF</td>
            <td class="text-center">Other Deduct</td> --}}
        </tr>
    </thead>

    @if (isset($value))
        @foreach ($value as $data)
            @php
                $desig = $data->designation_name;
            @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                {{-- <td class="text-left">{{ $data->card_no }}</td> --}}
                <td class="text-left" style="width:200px">{{ $data->full_name }}<br> {{ $desig ? "$desig" : '' }} <br>{{ isset($data->join_date) ? date('d/m/Y', strtotime($data->join_date)): "" }}</td>
                <!-- <td class="text-left">{{ $data->designation_name }}</td> -->
                <!-- <td class="text-center">00</td>
            <td class="text-center">00</td> -->

                <td class="text-right gross_salary">{{ number_format($data->gross_salary, 2) }}</td>
                <input type="hidden" name="hidden_gross_salary[]" class="hidden_gross_salary" value="{{floatval($data->gross_salary)}}"/>
                <td class="text-right">{{ number_format($data->basic_salary, 2) }}</td>
                <input type="hidden" name="hidden_basic_salary[]" class="hidden_basic_salary" value="{{floatval($data->basic_salary)}}"/>
                <td class="text-right">{{ number_format($data->house_rent, 2) }}</td>
                <input type="hidden" name="hidden_house_rent[]" class="hidden_house_rent" value="{{floatval($data->house_rent)}}"/>
                <td class="text-right">{{ number_format($data->medical_allowance, 2) }}</td>
                <input type="hidden" name="hidden_medical_allowance[]" class="hidden_medical_allowance" value="{{floatval($data->medical_allowance)}}"/>
                <td class="text-right">{{ number_format($data->conveyance_allowance, 2) }}<br>
                    {{ number_format($data->ta_da_allowance, 2) }}<br>{{ number_format($data->other_allowance, 2) }}</td>
                <input type="hidden" name="hidden_conveyance_allowance[]" class="hidden_conveyance_allowance" value="{{floatval($data->conveyance_allowance)}}"/>
                <input type="hidden" name="hidden_ta_da_allowance[]" class="hidden_ta_da_allowance" value="{{floatval($data->ta_da_allowance)}}"/>
                <input type="hidden" name="hidden_other_allowance[]" class="hidden_other_allowance" value="{{floatval($data->other_allowance)}}"/>
                {{-- <td class="text-right">{{ number_format($data->attendance_bonus, 2) }}</td> --}}

                @php

                    if ($data->attendance_days > 0) {
                        $sick_leave = $data->sick_leave;
                        $casual_leave = $data->casual_leave;
                        $attendance_days = ($data->attendance_days - ($data->absent_days + $data->leave_withoutpay_days));

                        $holiday = ($attendance_days - $data->working_days);
                        $one_day_pay_amount = intval($data->gross_salary)/intval($data->attendance_days);

                        $emp_attn_amount = $one_day_pay_amount*$attendance_days;

                        $emp_attn_ded_amount = $one_day_pay_amount*$holiday;
                        $abs_amount = $data->absent_days*$one_day_pay_amount;
                        $leave_wp_amount = $data->leave_withoutpay_days*$one_day_pay_amount;

                    } else {
                        $attendance_days = ($data->attendance_days - ($data->absent_days + $data->leave_withoutpay_days));
                        $holiday = ($attendance_days - $data->working_days);
                        $one_day_pay_amount = intval($data->gross_salary);
                        // $one_day_pay_amount = intval($data->gross_salary)/intval($data->attendance_days);

                        $emp_attn_amount = $one_day_pay_amount;
                        // $emp_attn_amount = $one_day_pay_amount*$attendance_days;
                        $emp_attn_ded_amount = $one_day_pay_amount*$holiday;
                        $abs_amount = $data->absent_days*$one_day_pay_amount;
                        $leave_wp_amount = $data->leave_withoutpay_days*$one_day_pay_amount;
                    }
                @endphp
                <td class="text-right">{{ number_format($attendance_days) }} </td>
                <td class="text-right payable_amount">
                    @php
                        $pay_amount = $emp_attn_amount > 0 ? ($emp_attn_amount) : 0;
                    @endphp
                    {{number_format($pay_amount)}}
                </td>
                <input type="hidden" class="hidden_payment_amount" value="{{floatval($pay_amount)}}"/>
                <td class="text-right"> <input  class="form-control night_allowances" name="night_allowances[]" placeholder="Night allowance" value="{{ number_format($data->night_allowance) }}" onkeyup="handleNightAllowance(this)"/></td>
                <td class="text-right"><input  class="form-control absent_amount" name="absent_amount[]" placeholder="Absent" value="{{ number_format($data->absent_amount) }}" onkeyup="handleAbsentAmount(this)"/></td>
                <td class="text-right"><input  class="form-control advances" name="advances[]"   placeholder="Advance"
                    value="{{ number_format($data->advance_amt) }}" onkeyup="processChange(this)" /></td>
                <td class="text-right"><input  class="form-control income_tax" name="income_tax[]"   placeholder="Income Tax"
                    value="{{ number_format($data->incometax_deduct_amount) }}" onkeyup="handleIncomeTax(this)"/></td>
                <td class="text-right"><input  class="form-control rs" name="rs[]" placeholder="R/S" value="{{ number_format(10) }}" onkeyup="handleRs(this)"/></td>
                <input type="hidden" value="{{$abs_amount}}" class="abs_amount">
                <input type="hidden" value="{{$leave_wp_amount}}" class="leave_wp_amount">
                <td class="text-right total_deduction">{{ number_format(abs(($data->incometax_deduct_amount + $data->revenue_stamp + $data->advance_amt  + $leave_wp_amount + $data->absent_amount))) }}</td>
                <td class="text-right net_payable_amount">
                    @php
                        $net_payable_amount = ($pay_amount + $data->night_allowance - $data->advance_amt - $data->incometax_deduct_amount - $data->revenue_stamp - $data->absent_amount);
                    @endphp
                    {{ number_format($net_payable_amount) }}
                </td>


                {{-- <td class="text-right"> {{ number_format($data->night_allowance) }}<br><input name="night_allowances[]" /></td>
                <td class="text-right">{{ number_format($data->advance_amt) }}<br><input name="advances[]" /></td>
                <td class="text-right">{{ number_format($data->revenue_stamp) }}<br><input name="rs[]" /></td> --}}

                {{-- <td class="text-right">{{ number_format($data->overtime_hours) }}</td>
                <td class="text-right">{{ number_format($data->overtime_rate, 2) }}</td>
                <td class="text-right">{{ number_format($data->overtime_amount, 2) }}</td>

                <td class="text-right">{{ number_format($data->late_days) }}</td>
                <td class="text-right">{{ number_format($data->leave_days) }}</td>
                <td class="text-right">{{ number_format($data->leave_withoutpay_days) }}</td> --}}
                {{-- <td class="text-right">{{ number_format($data->absent_days) }}</td> --}}
                {{-- <td class="text-right">{{ number_format($data->attendance_days) }}</td> --}}
                {{-- <td class="text-right">{{ number_format($data->att_deduct_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->residence_fee, 2) }}</td>
                <td class="text-right">{{ number_format($data->loan_deduct_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->personal_savings_amount, 2) }}</td>
                <td class="text-right">{{ number_format($data->other_deduct_amount, 2) }}</td>
                <td class="text-right"><strong> {{ number_format($data->payable_amount, 2) }} </strong></td> --}}
                {{-- <td class="text-left"></td> --}}
                {{-- <td width="70px"><span Class="btn btn-sm btn-primary open-modal" data-id=""  data-modal="common-modal-md" data-title="Edit Manual Attendence" title="Edit"><i class="fa fa-pencil-alt"></i></span> --}}
                <td width="100px">
                    {{-- <span Class="btn btn-sm btn-primary open-modal" data-id=""
                        data-action="{{ url('hrm/salary-process-edit-list', $data->monthly_salary_no_pk) }}"
                        data-modal="common-modal-md" data-title="Edit Salary Process  [{{ $data->salary_yyyymm }}]"
                        title="Edit"><i class="fa fa-pencil-alt"></i></span> --}}

                    <a Class="btn btn-sm btn-danger"
                        href="{{ url('hrm/monthly_salary_slip', [$data->monthly_salary_no_pk, $net_payable_amount]) }}"
                        title="pdf Salary Slip"><i class="fas fa-file-pdf"></i></a>

                    {{-- <span onclick="deleteSalaryData(this)" class="btn-danger btn btn-sm salary_sheet"
                        id="delete_salary_data"><i class="fa fa-trash" aria-hidden="true"></i>
                    </span> --}}
                    <input type="hidden" name="salary_hdn_id" id="salary_hdn_id"
                        value="{{ $data->monthly_salary_no_pk }}" />
                        <input type="hidden" name="ids[]"
                            value="{{ $data->monthly_salary_no_pk }}" />
                </td>
            </tr>

        @endforeach
    @endif

</table>
<div style="text-align:center;">
    @php
        $response_action = route('hrm.monthly_salary_sheet_jk');
    @endphp
    <button type="button" class="btn btn-success btn-md text-center" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
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

    function handleAdvance(element){
        let basic_salary = Number($(element).parents('tr').find('.hidden_payment_amount').val());
        let house_rent = Number($(element).parents('tr').find('.hidden_house_rent').val());
        let medical = Number($(element).parents('tr').find('.hidden_medical_allowance').val());
        let convience = Number($(element).parents('tr').find('.hidden_conveyance_allowance').val());
        let ta_da = Number($(element).parents('tr').find('.hidden_ta_da_allowance').val());
        let other_allowance = Number($(element).parents('tr').find('.hidden_other_allowance').val());
        let night_allowances = parseInt($(element).parents('tr').find('.night_allowances').val().replace(/,/g, ""));
        let rs = parseInt($(element).parents('tr').find('.rs').val().replace(/,/g, ""));
        let income_tax = parseInt($(element).parents('tr').find('.income_tax').val().replace(/,/g, ""));
        let absent_amount = parseInt($(element).parents('tr').find('.absent_amount').val().replace(/,/g, ""));
        let abs_amount = Number($(element).parents('tr').find('.abs_amount').val());
        let leave_wp_amount = Number($(element).parents('tr').find('.leave_wp_amount').val());
        //let payable_amount = Number(basic_salary+house_rent+medical+convience+ta_da+other_allowance);
        let payable_amount = Number(basic_salary);

        let advance = parseInt($(element).val().replace(/,/g, ""));
        let total_deduction = Number(advance + rs + income_tax + absent_amount + abs_amount + leave_wp_amount);
        let net_payment = Number(payable_amount + night_allowances - advance - rs - income_tax - absent_amount - abs_amount - leave_wp_amount);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
    }

    function handleIncomeTax(element){
        let basic_salary = Number($(element).parents('tr').find('.hidden_payment_amount').val());
        let house_rent = Number($(element).parents('tr').find('.hidden_house_rent').val());
        let medical = Number($(element).parents('tr').find('.hidden_medical_allowance').val());
        let convience = Number($(element).parents('tr').find('.hidden_conveyance_allowance').val());
        let ta_da = Number($(element).parents('tr').find('.hidden_ta_da_allowance').val());
        let other_allowance = Number($(element).parents('tr').find('.hidden_other_allowance').val());
        let night_allowances = parseInt($(element).parents('tr').find('.night_allowances').val().replace(/,/g, ""));
        let rs = parseInt($(element).parents('tr').find('.rs').val().replace(/,/g, ""));
        let advance = parseInt($(element).parents('tr').find('.advances').val().replace(/,/g, ""));
        let absent_amount = parseInt($(element).parents('tr').find('.absent_amount').val().replace(/,/g, ""));
        let abs_amount = Number($(element).parents('tr').find('.abs_amount').val());
        let leave_wp_amount = Number($(element).parents('tr').find('.leave_wp_amount').val());
        //let payable_amount = Number(basic_salary+house_rent+medical+convience+ta_da+other_allowance);
        let payable_amount = Number(basic_salary);
        let income_tax = parseInt($(element).val().replace(/,/g, ""));

        let total_deduction = Number(advance + rs + income_tax + absent_amount + abs_amount + leave_wp_amount);
        let net_payment = Number(payable_amount + night_allowances - advance - rs - income_tax - absent_amount - abs_amount - leave_wp_amount);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
    }
    function handleAbsentAmount(element){
        let basic_salary = Number($(element).parents('tr').find('.hidden_payment_amount').val());
        let house_rent = Number($(element).parents('tr').find('.hidden_house_rent').val());
        let medical = Number($(element).parents('tr').find('.hidden_medical_allowance').val());
        let convience = Number($(element).parents('tr').find('.hidden_conveyance_allowance').val());
        let ta_da = Number($(element).parents('tr').find('.hidden_ta_da_allowance').val());
        let other_allowance = Number($(element).parents('tr').find('.hidden_other_allowance').val());
        let night_allowances = parseInt($(element).parents('tr').find('.night_allowances').val().replace(/,/g, ""));
        let rs = parseInt($(element).parents('tr').find('.rs').val().replace(/,/g, ""));
        let advance = parseInt($(element).parents('tr').find('.advances').val().replace(/,/g, ""));
        let abs_amount = Number($(element).parents('tr').find('.abs_amount').val());
        let leave_wp_amount = Number($(element).parents('tr').find('.leave_wp_amount').val());
        //let payable_amount = Number(basic_salary+house_rent+medical+convience+ta_da+other_allowance);
        let payable_amount = Number(basic_salary);
        let income_tax = parseInt($(element).parents('tr').find('.income_tax').val().replace(/,/g, ""));
        let absent_amount = parseInt($(element).val().replace(/,/g, ""));

        let total_deduction = Number(advance + rs + absent_amount + income_tax + abs_amount + leave_wp_amount);
        let net_payment = Number(payable_amount + night_allowances - advance - rs - income_tax - absent_amount - abs_amount - leave_wp_amount);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
    }

    function handleRs(element){
        let basic_salary = Number($(element).parents('tr').find('.hidden_payment_amount').val());
        let house_rent = Number($(element).parents('tr').find('.hidden_house_rent').val());
        let medical = Number($(element).parents('tr').find('.hidden_medical_allowance').val());
        let convience = Number($(element).parents('tr').find('.hidden_conveyance_allowance').val());
        let ta_da = Number($(element).parents('tr').find('.hidden_ta_da_allowance').val());
        let other_allowance = Number($(element).parents('tr').find('.hidden_other_allowance').val());
        let night_allowances = parseInt($(element).parents('tr').find('.night_allowances').val().replace(/,/g, ""));
        let advance = parseInt($(element).parents('tr').find('.advances').val().replace(/,/g, ""));
        let abs_amount = Number($(element).parents('tr').find('.abs_amount').val());
        let absent_amount = parseInt($(element).parents('tr').find('.absent_amount').val().replace(/,/g, ""));
        let leave_wp_amount = Number($(element).parents('tr').find('.leave_wp_amount').val());
        //let payable_amount = Number(basic_salary+house_rent+medical+convience+ta_da+other_allowance);
        let income_tax = parseInt($(element).parents('tr').find('.income_tax').val().replace(/,/g, ""));
        let payable_amount = Number(basic_salary);

        // let rs = parseInt($(element).parents('tr').find('.rs').val().replace(/,/g, ""));
        let rs = parseInt($(element).val().replace(/,/g, ""));

        let total_deduction = Number(advance + rs + income_tax + absent_amount + abs_amount + leave_wp_amount);
        let net_payment = Number(payable_amount + night_allowances - advance - rs - income_tax - absent_amount - abs_amount - leave_wp_amount);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
        //$(element).parents('tr').find('.hidden_payment_amount').val(net_payment);
    }
    function handleNightAllowance(element){

        let basic_salary = Number($(element).parents('tr').find('.hidden_payment_amount').val());
        let house_rent = Number($(element).parents('tr').find('.hidden_house_rent').val());
        let medical = Number($(element).parents('tr').find('.hidden_medical_allowance').val());
        let convience = Number($(element).parents('tr').find('.hidden_conveyance_allowance').val());
        let ta_da = Number($(element).parents('tr').find('.hidden_ta_da_allowance').val());
        let other_allowance = Number($(element).parents('tr').find('.hidden_other_allowance').val());
        let advance = parseInt($(element).parents('tr').find('.advances').val().replace(/,/g, ""));
        let rs = parseInt($(element).parents('tr').find('.rs').val().replace(/,/g, ""));
        let abs_amount = Number($(element).parents('tr').find('.abs_amount').val());
        let absent_amount = parseInt($(element).parents('tr').find('.absent_amount').val().replace(/,/g, ""));
        let leave_wp_amount = Number($(element).parents('tr').find('.leave_wp_amount').val());
        //let payable_amount = Number(basic_salary+house_rent+medical+convience+ta_da+other_allowance);
        let payable_amount = Number(basic_salary);
        let income_tax = parseInt($(element).parents('tr').find('.income_tax').val().replace(/,/g, ""));
        let night_allowances = parseInt($(element).val().replace(/,/g, ""));
        let total_deduction = Number(advance + rs + income_tax + absent_amount + abs_amount + leave_wp_amount);
        let net_payment = Number(payable_amount + night_allowances - advance - rs - income_tax - absent_amount - abs_amount - leave_wp_amount);

        $(element).parents('tr').find('.total_deduction').text(total_deduction.toFixed(0));
        $(element).parents('tr').find('.net_payable_amount').text(net_payment.toFixed(0));
        //$(element).parents('tr').find('.hidden_payment_amount').val(net_payment);
    }



    function debounce(func, timeout = 200){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
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
