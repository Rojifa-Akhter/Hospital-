<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
@php
    $basic_salary_val = isset($salarySetupData->basic_salary_perc) ? $salarySetupData->basic_salary_perc / 100 : 0;
    $house_rent_val = isset($salarySetupData->house_rent_perc) ? $salarySetupData->house_rent_perc / 100 : 0;
    $medical_allow_val = isset($salarySetupData->medical_allow_perc) ? $salarySetupData->medical_allow_perc / 100 : 0;
    $ta_da_val = isset($salarySetupData->ta_da_perc) ? $salarySetupData->ta_da_perc / 100 : 0;
    $utility_allow_val = isset($salarySetupData->utility_allow_perc) ? $salarySetupData->utility_allow_perc / 100 : 0;
    $entertainment_val = isset($salarySetupData->entertainment_perc) ? $salarySetupData->entertainment_perc / 100 : 0;
    $festival_bonus_val = isset($salarySetupData->festival_bonus_perc) ? $salarySetupData->festival_bonus_perc / 100 : 0;
    $conveyance_allow_val = isset($salarySetupData->conveyance_allow_perc) ? $salarySetupData->conveyance_allow_perc / 100 : 0;
    $critical_allow_val = isset($salarySetupData->ca_perc) ? $salarySetupData->ca_perc / 100 : 0;
    $special_allow_val = isset($salarySetupData->sa_perc) ? $salarySetupData->sa_perc / 100 : 0;
    $incharge_allow_val = isset($salarySetupData->ica_prea) ? $salarySetupData->ica_prea / 100 : 0;
    $risk_allow_val = isset($salarySetupData->ra_prec) ? $salarySetupData->ra_prec / 100 : 0;
@endphp
<form action="{{ route('payroll.store-employee-salary') }}" method="post" id="employee_salary_id">
    @csrf
    <input type="hidden" name="salary_id" value="{{ isset($salaryInfo->salary_no_pk) ? $salaryInfo->salary_no_pk : '' }}">
    <input type="hidden" name="person_id" value="{{ isset($person_id) ? $person_id : '' }}">
    <div class="form-row" style="font-size: 14px;">
       
        <div class="col-sm-4">
            <p style="margin:0px">Name: <b>{{isset($employee_info->person_code) ? $employee_info->person_code : ""}}</b></p>
            <p style="margin:0px">ID: <b>{{isset($employee_info->full_name) ? $employee_info->full_name : ""}}</b></p>  
        </div>
        <div class="col-sm-4">
            <p style="margin:0px">Department: <b>{{isset($employee_info->su_name) ? $employee_info->su_name : ""}}</b></p>
            <p style="margin:0px">Designation: <b>{{isset($employee_info->designation) ? $employee_info->designation : ""}}</b></p>
        </div>
    </div>
    <div class="form-row">
        <div class="col-sm-3">
            <label for="salary_factor" class="col-form-label col-form-label-sm">Salary Factor<span
                    style="color:red; font-weight:bold"> *</span>
            </label>
            <div class="form-group row pb-3">
                <div class="col-md-12">
                    <div class="input-group flex-nowrap">
                        <select class="form-control form-control-sm" name="salary_factor" id="salary_factor" required
                            onchange = "handleSalaryFactor(this)">
                            {{-- <option value="">select Salary Factor</option> --}}
                            @if (!empty($salary_factor))
                                @foreach ($salary_factor as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ isset($salaryInfo->salary_factor) && $salaryInfo->salary_factor == $key ? 'selected' : ''}}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3" id="grade" style="{{isset($salaryInfo->grade_no_fk) ? 'display: block' : 'display: none'}}">
            <label for="grade_factor" class="col-form-label col-form-label-sm">Grade Factor <span
                    style="color:red; font-weight:bold"> *</span>
            </label>
            <div class="form-row">
                <div class="input-group flex-nowrap">
                    <select class="form-control form-control-sm" name="grade_factor" id="grade_factor">
                        <option value="">select Grade</option>
                        @if (isset($grade))
                          @foreach ($grade as $value)
                            <option value="{{ $value->grade_no_pk }}" {{ isset($salaryInfo->grade_no_fk) && $salaryInfo->grade_no_fk == $value->grade_no_pk ? 'selected' : '' }} >
                                {{ $value->grade_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="salary_info_amt">
        @include('admin.hrm.salarySetup.salary_info')
    </div>
    <div class="modal-footer">
        @php
            $response_action = route('payroll.employee-salary');
        @endphp
        <button class="btn btn-success uhl_save_btn"> Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    function handleSalaryFactor(element) {
        let disabledElements = document.getElementsByClassName("getDisable");
        if (element.value == 'GRADEBASED') {
            document.querySelector('#grade').style.display = 'block';
            document.querySelector('#grade_factor').required = true;
            document.querySelector('#gross_salary').readOnly = true;
            document.querySelector('#gross_salary').value = '';
            for (var i = 0; i < disabledElements.length; i++) {
                disabledElements[i].readOnly = true;
                disabledElements[i].value = ''
            }
        }else if(element.value == 'STRUCTPERC'){
            document.querySelector('#grade').style.display = 'none';
            document.querySelector('#grade_factor').required = false;
            document.querySelector('#gross_salary').readOnly = false;
            document.querySelector('#gross_salary').value = '';
            for (var i = 0; i < disabledElements.length; i++) {
                disabledElements[i].readOnly = true;
                disabledElements[i].value = ''
            }
        } else {
            document.querySelector('#grade').style.display = 'none';
            document.querySelector('#grade_factor').required = false;
            document.querySelector('#gross_salary').readOnly = false;
            document.querySelector('#gross_salary').value = '';
            for (var i = 0; i < disabledElements.length; i++) {
                disabledElements[i].readOnly = false;
                disabledElements[i].value = ''
            }
        }
    }
    function handleGrossSalary(element) {
        if (document.querySelector('#salary_factor').value == 'STRUCTPERC' || document.querySelector('#salary_factor').value == 'GRADEBASED') {
            let gross_salary = element.value;
            let basic_salary_val = "<?php echo $basic_salary_val; ?>";
            let house_rent_val = "<?php echo $house_rent_val; ?>";
            let medical_allow_val = "<?php echo $medical_allow_val; ?>";
            let ta_da_val = "<?php echo $ta_da_val; ?>";
            let utility_allow_val = "<?php echo $utility_allow_val; ?>";
            let entertainment_val = "<?php echo $entertainment_val; ?>";
            let festival_bonus_val = "<?php echo $festival_bonus_val; ?>";
            let conveyance_allow_val = "<?php echo $conveyance_allow_val; ?>";
            let critical_allow_val = "<?php echo $critical_allow_val; ?>";
            let special_allow_val = "<?php echo $special_allow_val; ?>";
            let incharge_allow_val = "<?php echo $incharge_allow_val; ?>";
            let risk_allow_val = "<?php echo $risk_allow_val; ?>";
            // alert(basic_salary_per);
            let basic_salary = Math.round(gross_salary * basic_salary_val);
            let house_allowance = Math.round(gross_salary * house_rent_val);
            let medical_allowance = Math.round(gross_salary * medical_allow_val);
            let transport_allowance = Math.round(gross_salary * ta_da_val);
            let utility_allow = Math.round(gross_salary * utility_allow_val);
            let entertainment = Math.round(gross_salary * entertainment_val);
            let festival_bonus = Math.round(gross_salary * festival_bonus_val);
            let conveyance_allow = Math.round(gross_salary * conveyance_allow_val);
            let critical_allow = Math.round(gross_salary * critical_allow_val);
            let special_allow = Math.round(gross_salary * special_allow_val);
            let incharge_allow = Math.round(gross_salary * incharge_allow_val);
            let risk_allow = Math.round(gross_salary * risk_allow_val);

            document.querySelector("#basic_salary").value = basic_salary;
            document.querySelector("#basic_salary_per").value = "<?php echo isset($salarySetupData->basic_salary_perc) ? $salarySetupData->basic_salary_perc : ''; ?>";
            document.querySelector("#house_rent").value = house_allowance;
            document.querySelector("#house_rent_per").value = "<?php echo isset($salarySetupData->house_rent_perc) ? $salarySetupData->house_rent_perc : ''; ?>";
            document.querySelector("#medical_allowance").value = medical_allowance;
            document.querySelector("#medical_allowance_per").value = "<?php echo isset($salarySetupData->medical_allow_perc) ? $salarySetupData->medical_allow_perc : ''; ?>";
            document.querySelector("#ta_da").value = transport_allowance;
            document.querySelector("#ta_da_per").value = "<?php echo isset($salarySetupData->ta_da_perc) ? $salarySetupData->ta_da_perc : ''; ?>";
            document.querySelector("#conveyance_allowance").value = conveyance_allow;
            document.querySelector("#conveyance_allowance_per").value = "<?php echo isset($salarySetupData->conveyance_allow_perc) ? $salarySetupData->conveyance_allow_perc : ''; ?>";
            document.querySelector("#utility").value = utility_allow;
            document.querySelector("#utility_per").value = "<?php echo isset($salarySetupData->utility_allow_perc) ? $salarySetupData->utility_allow_perc : ''; ?>";
            document.querySelector("#festival_bonus").value = festival_bonus;
            document.querySelector("#festival_bonus_per").value = "<?php echo isset($salarySetupData->festival_bonus_perc) ? $salarySetupData->festival_bonus_perc : ''; ?>";
            document.querySelector("#entertainment").value = entertainment;
            document.querySelector("#entertainment_per").value = "<?php echo isset($salarySetupData->entertainment_perc) ? $salarySetupData->entertainment_perc : ''; ?>";
            document.querySelector("#critical").value = critical_allow;
            document.querySelector("#critical_per").value = "<?php echo isset($salarySetupData->ca_perc) ? $salarySetupData->ca_perc : ''; ?>";
            document.querySelector("#special").value = special_allow;
            document.querySelector("#special_per").value = "<?php echo isset($salarySetupData->sa_perc) ? $salarySetupData->sa_perc : ''; ?>";
            document.querySelector("#incharge").value = incharge_allow;
            document.querySelector("#incharge_per").value = "<?php echo isset($salarySetupData->ica_prea) ? $salarySetupData->ica_prea : ''; ?>";
            document.querySelector("#risk").value = risk_allow;
            document.querySelector("#risk_per").value = "<?php echo isset($salarySetupData->ra_prec) ? $salarySetupData->ra_prec : ''; ?>";
        }
    }
    $(document).on("change", "#grade_factor", function(e) {
        var grade_value = $(this).val();
        $.ajax({
            url: "{{ route('payroll.grade-factor') }}",
            type: 'GET',
            data: {
                grade_value: grade_value
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#salary_info_amt").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    document.querySelector('.uhl_save_btn').addEventListener('click', function(e) {
        let gross_salary = Number(document.querySelector('#gross_salary').value);
        let basic_salary_val = "<?php echo $basic_salary_val; ?>";
        let house_rent_val = "<?php echo $house_rent_val; ?>";
        let medical_allow_val = "<?php echo $medical_allow_val; ?>";
        let ta_da_val = "<?php echo $ta_da_val; ?>";
        let utility_allow_val = "<?php echo $utility_allow_val; ?>";
        let entertainment_val = "<?php echo $entertainment_val; ?>";
        let festival_bonus_val = "<?php echo $festival_bonus_val; ?>";
        let conveyance_allow_val = "<?php echo $conveyance_allow_val; ?>";
        let critical_allow_val = "<?php echo $critical_allow_val; ?>";
        let special_allow_val = "<?php echo $special_allow_val; ?>";
        let incharge_allow_val = "<?php echo $incharge_allow_val; ?>";
        let risk_allow_val = "<?php echo $risk_allow_val; ?>";

        let total_amount = Number(gross_salary * basic_salary_val) + Number(gross_salary * house_rent_val) + Number(gross_salary * medical_allow_val) + Number(gross_salary * ta_da_val) + Number(gross_salary * utility_allow_val) + Number(gross_salary * utility_allow_val) + Number(gross_salary * festival_bonus_val) + Number(gross_salary * entertainment_val) + Number(gross_salary * critical_allow_val) + Number(gross_salary * special_allow_val) + Number(gross_salary * incharge_allow_val) + Number(gross_salary * risk_allow_val) + Number(gross_salary * conveyance_allow_val);

        let total_perc = Number(document.querySelector('#basic_salary_per').value) + Number(document.querySelector('#house_rent_per').value) + Number(document.querySelector('#medical_allowance_per').value) + Number(document.querySelector('#ta_da_per').value) + Number(document.querySelector('#conveyance_allowance_per').value) + Number(document.querySelector('#utility_per').value) + Number(document.querySelector('#festival_bonus_per').value) + Number(document.querySelector('#entertainment_per').value) + Number(document.querySelector('#critical_per').value) + Number(document.querySelector('#special_per').value) + Number(document.querySelector('#incharge_per').value) + Number(document.querySelector('#risk_per').value);

        if ((document.querySelector('#salary_factor').value == 'STRUCTPERC' || document.querySelector('#salary_factor').value == 'GRADEBASED') &&  gross_salary != total_amount) {
            alert('Gross salary must be equal to total amount !!');
            event.preventDefault();
        }else if((document.querySelector('#salary_factor').value == 'STRUCTPERC' || document.querySelector('#salary_factor').value == 'GRADEBASED') &&  total_perc != 100){
            alert('Total percentage must be equal to 100 !!');
            event.preventDefault();
        }else if((document.querySelector('#salary_factor').value == 'FIXED') &&  gross_salary != total_amount){
            alert('Gross salary must be equal to total amount !!');
            event.preventDefault();
        }else{
            btnSaveUpdate(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                '{{ $response_action }}')
        }

    })
</script>
