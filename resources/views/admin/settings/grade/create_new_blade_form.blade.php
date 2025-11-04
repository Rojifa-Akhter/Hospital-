@php
    $grade = isset($grade) && !empty($grade) ? $grade : [];
    $grade_no_pk = $grade ? $grade->grade_no_pk : '';
    $grade_name = $grade ? $grade->grade_name : '';
    $salary_grade_factor = $grade ? $grade->salary_grade_factor : '';
    $gross_salary = $grade ? $grade->gross_salary : '';
    $basic_salary = $grade ? $grade->basic_salary : '';
    $basic_salary_per = $grade ? $grade->basic_salary_perc : '';
    $house_rent = $grade ? $grade->house_rent : '';
    $house_rent_per = $grade ? $grade->house_rent_perc : '';
    $medical_allow = $grade ? $grade->medical_allow : '';
    $medical_allow_per = $grade ? $grade->medical_allow_perc : '';
    $attendance_bonus = $grade ? $grade->attendance_bonus : '';
    $conveyance_allow = $grade ? $grade->conveyance_allow : '';
    $conveyance_allow_per = $grade ? $grade->conveyance_allow_perc : '';
    $utility = $grade ? $grade->utility : '';
    $utility_per = $grade ? $grade->utility_perc : '';
    $entertainment = $grade ? $grade->entertainment : '';
    $entertainment_per = $grade ? $grade->entertainment_perc : '';
    $festival_bonus = $grade ? $grade->festival_bonus : '';
    $festival_bonus_per = $grade ? $grade->festival_bonus_perc : '';
    $ta_da = $grade ? $grade->ta_da : '';
    $ta_da_per = $grade ? $grade->ta_da_perc : '';
    $status = $grade ? $grade->status : '';
@endphp
<div class=" col-lg-5 col-xl-12">
    <form action="{{ route('grade.store') }}" method="post" id="grade-create">
        @csrf
        <input type="hidden" name="id" value="{{ $grade_no_pk }}">

        <div class="form-group form-row">
            <div class="col-sm-2">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Grade Factor
                    <span class="text-danger">*</span></label>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="input-group flex-nowrap">
                            <select class="form-control form-control-sm" name="grade_Per" id="grade_Per" required>
                                <option value="">select Grade</option>
                                <?php foreach ($gradePer as  $key => $value): ?>
                                <option value="{{ $key }}"
                                    {{ $salary_grade_factor == $key ? 'selected' : '' }}>{{ $value }}</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-2">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Grade Name<span
                        class="text-danger">*</span></label>
                <div class="form-row">
                    <div class="">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control form-control-sm" id="grade_name" name="grade_name"
                                value="{{ $grade_name }}" placeholder="Grade Name" required autocomplete="off">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-2">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Gross Salary<span
                        class="text-danger">*</span></label>
                <div class="form-row">
                    <div class="">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm " id="gross_salary"
                                name="gross_salary" value="{{ $gross_salary }}" placeholder="0.00" autocomplete="off"
                                required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-4">
                <label for="basic_salary" class=" col-form-label col-form-label-sm">Basic Salary</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only "
                                id="basic_salary" name="basic_salary" value="{{ $basic_salary }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="basic_salary_per"
                                name="basic_salary_per" value="{{ $basic_salary_per }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="medical_allowance" class=" col-form-label col-form-label-sm">Medical Allowance </label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="medical_allowance" name="medical_allowance" value="{{ $medical_allow }}"
                                placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent"
                                id="medical_allowance_per" name="medical_allowance_per"
                                value="{{ $medical_allow_per }}" placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="house_rent" class=" col-form-label col-form-label-sm">House Rent </label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="house_rent" name="house_rent" value="{{ $house_rent }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="house_rent_per"
                                name="house_rent_per" value="{{ $house_rent_per }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">Utility</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="utility" name="utility" value="{{ $utility }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="utility_per"
                                name="utility_per" value="{{ $utility_per }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">Conveyance Allowance
                </label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="Conveyance_allowance" name="Conveyance_allowance"
                                value="{{ $conveyance_allow }}" placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent"
                                id="Conveyance_allowance_per" name="Conveyance_allowance_per"
                                value="{{ $conveyance_allow_per }}" placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="house_rent" class=" col-form-label col-form-label-sm">Entertainment </label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="entertainment" name="entertainment" value="{{ $entertainment }}"
                                placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="entertainment_per"
                                name="entertainment_per" value="{{ $entertainment_per }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Festival Bonus</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="festival_bonus" name="festival_bonus" value="{{ $festival_bonus }}"
                                placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent"
                                id="festival_bonus_per" name="festival_bonus_per" value="{{ $festival_bonus_per }}"
                                placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="Conveyance_allowance" class=" col-form-label col-form-label-sm">TA/DA</label>
                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only amount"
                                id="ta_da" name="ta_da" value="{{ $ta_da }}" placeholder="0.00"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">%</span>
                            </div>
                            <input type="text" class="form-control form-control-sm percent" id="ta_da_per"
                                name="ta_da_per" value="{{ $ta_da_per }}" placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <label for="attendence_bonus" class=" col-form-label col-form-label-sm">Attendance Bonus</label>

                <div class="form-row">
                    <div class="col-sm-6">
                        <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="addon-wrapping">Amt</span>
                            </div>
                            <input type="text" class="form-control form-control-sm sum number_only "
                                id="attendence_bonus" name="attendence_bonus" value="{{ $attendance_bonus }}"
                                placeholder="0.00" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name=" grade_status" id="grade_status" value="1"
                {{ $status == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="grade_status">Active</label>
        </div>
        @php
            $response_action = route('grade.index');
        @endphp
        <div class="mt-2 modal-inline">
            <button type="button" class="btn btn-md btn-success uhl_common_btn">Save</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        var grade = $('#grade_Per').val();

        $(document).on('keyup', '.percent', function() {
            var grade_factor = $('#grade_Per').val();
            var thisValue = $(this).val();
            var calculate_by = "";
            if (grade_factor == "GROSSPERC") {
                calculate_by = "gross_salary";
            } else if (grade_factor == "BASICPERC") {
                calculate_by = "basic_salary";
            }
            if (calculate_by != "") {
                var grade = $('#grade_Per').val();
                var gross_salary = $('#gross_salary').val();
                if (grade_factor == "GROSSPERC") {
                    var basic_salary_per = $('#gross_salary').val() * $('#basic_salary_per').val() /
                        100;
                    $('#basic_salary').val(basic_salary_per);
                }

                var medical_allowance_per = $('#' + calculate_by).val() * $('#medical_allowance_per')
                    .val() / 100;
                var ta_da_per = $('#' + calculate_by).val() * $('#ta_da_per').val() / 100;
                var conveyance_allow_per = $('#' + calculate_by).val() * $('#Conveyance_allowance_per')
                    .val() / 100;
                var house_rent_per = $('#' + calculate_by).val() * $('#house_rent_per').val() / 100;
                var utility_per = $('#' + calculate_by).val() * $('#utility_per').val() / 100;
                var entertainment_per = $('#' + calculate_by).val() * $('#entertainment_per').val() /
                    100;
                var festival_bonus_per = $('#' + calculate_by).val() * $('#festival_bonus_per').val() /
                    100;

                $('#medical_allowance').val(medical_allowance_per);
                $('#ta_da').val(ta_da_per);
                $('#Conveyance_allowance').val(conveyance_allow_per);
                $('#house_rent').val(house_rent_per);
                $('#utility').val(utility_per);
                $('#entertainment').val(entertainment_per);
                $('#festival_bonus').val(festival_bonus_per);
                if (grade_factor == "BASICPERC") {
                    var sum = 0;
                    $('.sum').each(function() {
                        sum += Number($(this).val());
                    });
                    $('#gross_salary').val(sum);
                }
            }
        });
        $(document).on('change', '#grade_Per', function() {
            var grade_factor = $('#grade_Per').val();
            if (grade_factor == "AMOUNT") {
                $(".percent").attr("readonly", "readonly");
                $(".amount").removeAttr("readonly", "readonly");
            } else {
                $(".amount").attr("readonly", "readonly");
                $(".percent").removeAttr("readonly", "readonly");
            }
            $('#gross_salary').val('');
            $('#basic_salary').val('');
            $('#basic_salary_per').val('');
            $('#attendence_bonus').val('');
            $('#medical_allowance').val('');
            $('#medical_allowance_per').val('');
            $('#ta_da').val('');
            $('#ta_da_per').val('');
            $('#Conveyance_allowance').val('');
            $('#Conveyance_allowance_per').val('');
            $('#house_rent').val('');
            $('#house_rent_per').val('');
            $('#utility').val('');
            $('#utility_per').val('');
            $('#entertainment').val('');
            $('#entertainment_per').val('');
            $('#festival_bonus').val('');
            $('#festival_bonus_per').val('');
        });
        document.querySelector('.uhl_common_btn').addEventListener('click', function(e) {
            let basic_salary = isNullOrUndefinedOrNaN(document.querySelector('#basic_salary').value) ?
                0 : parseFloat(
                    document.querySelector('#basic_salary').value);
            let medical_allowance = isNullOrUndefinedOrNaN(document.querySelector('#medical_allowance')
                .value) ? 0 : parseFloat(
                document.querySelector('#medical_allowance').value);
            let house_rent = isNullOrUndefinedOrNaN(document.querySelector('#house_rent').value) ? 0 :
                parseFloat(
                    document.querySelector('#house_rent').value);
            let utility = isNullOrUndefinedOrNaN(document.querySelector('#utility').value) ? 0 :
                parseFloat(
                    document.querySelector('#utility').value);
            let Conveyance_allowance = isNullOrUndefinedOrNaN(document.querySelector(
                '#Conveyance_allowance').value) ? 0 : parseFloat(
                document.querySelector('#Conveyance_allowance').value);
            let entertainment = isNullOrUndefinedOrNaN(document.querySelector('#entertainment').value) ?
                0 : parseFloat(
                    document.querySelector('#entertainment').value);
            let festival_bonus = isNullOrUndefinedOrNaN(document.querySelector('#festival_bonus')
                .value) ? 0 : parseFloat(
                    document.querySelector('#festival_bonus').value);
            let ta_da = isNullOrUndefinedOrNaN(document.querySelector('#ta_da').value) ? 0 : parseFloat(
                document.querySelector('#ta_da').value);
            let attendence_bonus = isNullOrUndefinedOrNaN(document.querySelector('#attendence_bonus')
                .value) ? 0 : parseFloat(
                document.querySelector('#attendence_bonus').value);
            let basic_salary_per = isNullOrUndefinedOrNaN(document.querySelector('#basic_salary_per')
                .value) ? 0 : parseFloat(
                document.querySelector('#basic_salary_per').value);
            let medical_allowance_per = isNullOrUndefinedOrNaN(document.querySelector(
                '#medical_allowance_per').value) ? 0 : parseFloat(
                document.querySelector('#medical_allowance_per').value);
            let house_rent_per = isNullOrUndefinedOrNaN(document.querySelector('#house_rent_per')
                .value) ? 0 : parseFloat(
                    document.querySelector('#house_rent_per').value);
            let utility_per = isNullOrUndefinedOrNaN(document.querySelector('#utility_per').value) ? 0 :
                parseFloat(
                    document.querySelector('#utility_per').value);
            let Conveyance_allowance_per = isNullOrUndefinedOrNaN(document.querySelector(
                '#Conveyance_allowance_per').value) ? 0 : parseFloat(document.querySelector(
                '#Conveyance_allowance_per').value);
            let entertainment_per = isNullOrUndefinedOrNaN(document.querySelector('#entertainment_per')
                .value) ? 0 : parseFloat(
                document.querySelector('#entertainment_per').value);
            let festival_bonus_per = isNullOrUndefinedOrNaN(document.querySelector(
                '#festival_bonus_per').value) ? 0 : parseFloat(
                document.querySelector('#festival_bonus_per').value);
            let ta_da_per = isNullOrUndefinedOrNaN(document.querySelector('#ta_da_per').value) ? 0 :
                parseFloat(
                    document.querySelector('#ta_da_per').value);
            let total_percentage = basic_salary_per + medical_allowance_per + house_rent_per +
                utility_per + Conveyance_allowance_per + entertainment_per + festival_bonus_per +
                ta_da_per;
            let total_amount = basic_salary + medical_allowance + house_rent + utility +
                Conveyance_allowance + entertainment + festival_bonus + ta_da + attendence_bonus;

            let gross_salary = isNullOrUndefinedOrNaN(document.querySelector('#gross_salary').value) ?
                0 : parseFloat(
                    document.querySelector('#gross_salary').value);
            let grade_Per = document.querySelector('#grade_Per').value;
            let grade_name = document.querySelector('#grade_name').value;

            if (grade_Per == "" || grade_name == "" || gross_salary == "") {
                alert('Please fill up Grade Factor, Grade Name, Gross Salary.');
                return false;
            } else if (grade_Per == 'AMOUNT' && (gross_salary != total_amount)) {
                alert('Total amount must be equal to gross amount.');
                return false;
            } else if ((grade_Per == 'BASICPERC' || grade_Per == 'GROSSPERC') && (gross_salary !=
                    total_amount || total_percentage != 100)) {
                alert('Total amount must be equal to gross amount and total percentage must be equal to 100.');
                return false;
            } else {
                btnSaveUpdateUpload(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                    '{{ $response_action }}')
            }
        })
    })
</script>
