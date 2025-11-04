@if (!empty($data))

    @foreach ($data as $d)
        @php
            $v = $d->due_duration;
            for ($i = 0; $i <= $v; $i++) {
                $output = [];
                if ($i >= $v) {
                    $years = ($i - ($i % 12)) / 12;
                    $output[] = $years > 1 ? $years . ' Years' : $years . ' Year';
                }
            
                if ($i % 12 > 0) {
                    $monthsRest = $i % 12;
                    $output[] = $monthsRest > 1 ? $monthsRest . ' Months' : $monthsRest . ' Month';
                }
                // if ($i % 12 < 12) {
                //     $onlyMonth = $i % 30;
                //     $output[] = $onlyMonth > 1 ? $onlyMonth . ' Months' : $onlyMonth . ' Month';
                // }
                $display = implode(' ', $output);
            }
            
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="text-left">{{ $d->person_no_pk }}</td>
            <input type="hidden" name="emp_id[]" value="{{ $d->person_no_pk }}">
            <td class="text-left">{{ strtoupper($d->full_name) }}</td>
            <input type="hidden" name="emp_name[]" value="{{ $d->full_name }}">
            <td class="text-left">{{ $d->su_name }}</td>
            <input type="hidden" name="department[]" value="{{ $d->su_name }}">
            <td class="text-left">{{ date('d/m/Y', strtotime($d->join_date)) }}</td>
            <input type="hidden" name="join_date[]" value="{{ $d->join_date }}">
            <td class="text-left">{{ $d->promotrans_date }}</td>
            <input type="hidden" name="last_promotion_date[]" value="{{ $d->promotrans_date }}">
            <td class="text-left">{{ $d->designation }}</td>
            <input type="hidden" name="last_designation[]" value="{{ $d->designation }}">
            {{-- <td class="text-left">{{ $d->designation_name }}</td> --}}
            <td class="text-left">{{ $d->designation_name }}</td>
            <input type="hidden" name="current_designation[]" value="{{ $d->designation_name }}">
            <td class="text-left">
                @php
                    $date1 = date('d/m/Y', strtotime($d->join_date));
                    $date2 = date('Y/m/d');
                    
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                    
                    printf("%d years, %d months, %d days\n", $years, $months, $days);
                @endphp
            </td>
            <input type="hidden" name="current_designation_duration[]">
            <td class="text-left">
                {{-- @if ($d->due_duration <= 1)
                    {{ $d->due_duration }} Month
                @else
                    {{ $d->due_duration }} Months
                @endif --}}
                {{ $display }}
            </td>
            <input type="hidden" name="date_of_due[]" value="{{ $d->due_duration }}">

            <td class="gross_salary" id="gross_salary">{{ $d->gross_salary }}</td>
            <input type="hidden" name="gross_salary[]" class="gross_salary" value="{{ $d->gross_salary }}">

            <td class="text-left">
                <select class="form-control font_size_12 m-auto select2" name="expected_designation[]"
                    id="expected_designation">
                    <option value="">Select Designation</option>
                    @if (!empty($designation))
                        @foreach ($designation as $desig)
                            <option value="{{ $desig->designation_no_pk }}">{{ $desig->designation_name }}</option>
                        @endforeach
                    @endif
                </select>
            </td>
            <td class="text-center">
                <input type="checkbox" id="checkbox_id" name="chk" value="">
            </td>
            <td class="text-left">
                <input name="increment[]" id="percentage" class="form-control estimated_inc"
                    value="{{ $d->regular_promo_percent }}" maxlength='3' pattern='^[0-9]$'
                    onkeyup="handleEstimatedInc(this)">
            </td>



            <td class="text-left estimated_inc_amt">
                {{ ($d->gross_salary * $d->regular_promo_percent) / 100 }}</td>
            <input type="hidden" name="estimated_increment_amout[]" class="estimated_inc_amt"
                value="{{ ($d->gross_salary * $d->regular_promo_percent) / 100 }}">

            <td class="estimated_increment_salary">
                {{ $d->gross_salary + ($d->gross_salary * $d->regular_promo_percent) / 100 }}</td>
            <input type="hidden" name="estimated_increment_salary[]" class="estimated_increment_salary"
                value="{{ $d->gross_salary + ($d->gross_salary * $d->regular_promo_percent) / 100 }}">
            <td>
                <input type="text" id="effective_date" name="effective_date"
                    class="form-control form-control-sm date_picker" placeholder="Effective Date" required="" />
            </td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm deletePromotiontRow"
                    title="Remove"><i class="oi oi-circle-x"></i></button>
                {{-- <td class="text-left"></td>
            <input type="hidden" name="increment_details[]"> --}}
                {{-- <td class="text-center">
			<input type="checkbox" id="" name="">
		</td>
		<td class="text-center"></td> --}}


                <input type="hidden" name="curr_design_no_fk[]" value="{{ $d->curr_design_no_fk }}">

                <input type="hidden" name="final_increment_amt[]" class="estimated_inc_amt"
                    value="{{ ($d->gross_salary * $d->regular_promo_percent) / 100 }}">
        </tr>
    @endforeach

@endif
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.select2').select2();
        $('input:text').prop('readOnly', true);

        $('input:checkbox').on('click', function() {
            if ($(this).prop('checked')) {
                $(this).parent().nextAll().find('input').prop('readOnly', false);
            } else {
                $(this).parent().nextAll().find('input').prop('readOnly', true);
            }
        });

    });

    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });


    function handleEstimatedInc(element) {
        let estimated_inc_perc = Number($(element).val());
        let gross_salary = Number($(element).parent('td').parent('tr').find('.gross_salary').text());
        let estimated_inc_amt = estimated_inc_perc > 0 ? (gross_salary * estimated_inc_perc) / 100 : 0;
        let estimated_salary = gross_salary + estimated_inc_amt;
        // console.log(estimated_inc_amt, estimated_salary);
        $(element).parents('tr').find('.estimated_inc_amt').text(estimated_inc_amt.toFixed(2));
        $(element).parents('tr').find('.estimated_increment_salary').text(estimated_salary.toFixed(2));
        $(element).parents('tr').find('.estimated_inc_amt').val(estimated_inc_amt);
        $(element).parents('tr').find('.estimated_increment_salary').val(estimated_salary);
        // console.log(estimated_inc_amt);
    }

    $("#userTable").on('click', '.deletePromotiontRow', function() {
        $(this).closest('tr').remove();
    });
</script>
