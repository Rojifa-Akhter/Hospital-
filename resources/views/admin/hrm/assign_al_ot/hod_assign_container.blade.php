@if (!empty($hodAssigndata))
    <form method="post" id="assign_id" data-response-action="" action="{{ route('v1.hrm.store-hod-assign-al-ot') }}">
        @csrf
        <input type="hidden" name="person_no_pk" value="{{ @$hodAssigndata->person_no_pk }}">
        <div class="row">
            <div class="col-12 text-center">
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Employee Name: {{ @$persondata->full_name }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2"> Employee Card: {{ @$persondata->person_code }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Department: {{ @$persondata->serviceunit_no_fk_dept_name }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Unit: {{ @$persondata->su_name }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Duty Roster Type: {{ @$persondata->duty_roster_type }}</span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <label for="dayoff_holiday" class="col-form-label col-form-label-sm">Dayoff/Holiday <span
                        style="color:red">
                        *</span></label>
                <select class="form-control font_size_12" id="dayoff_holiday" name="dayoff_holiday">
                    <option value="">Select Dayoff/Holiday</option>
                    @if(count($dayOffHlidayData) > 0)
                        @foreach ($dayOffHlidayData as $key => $data)
                            <option value="{{ $key }}">{{ $data }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <label for="type" class="col-form-label col-form-label-sm">Assign Type<span style="color:red">
                        *</span></label>
                <select class="form-control font_size_12" id="assign_type" name="assign_type">
                    <option value="">Select Type</option>
                    <option value="al">AL</option>
                    <option value="ot">OT</option>
                </select>
            </div>
            @php
            $response_action = route('hospital-salary-setup');
        @endphp
            <div class="col-md-2">
                <?php 
                    $response_action = route('v1.hrm.hod-assign-al-ot');
                ?>
                <button type="submit" class="btn btn-secondary uhl_common_btn mt-4">Save</button>
            </div>
        </div>
    </form>
@else
<p class="text-center">No Data Here</p>
@endif
<script>
    document.querySelector('.uhl_common_btn').addEventListener('click', function(e) {
        let dayoff_holiday = document.querySelector('#dayoff_holiday').value;
        let assign_type = document.querySelector('#assign_type').value;
        if (dayoff_holiday == '') {
            alert('Please select Dayoff/Holiday !!');
            return false;
        } else if (assign_type == '') {
            alert('please select Assign Type !!');
            return false;
        } else {
            btnSaveUpdate(e.target, '', '', '', '', dynamicFunc.afterSaveLoadPage,
                '{{ $response_action }}')
        }
    })
</script>