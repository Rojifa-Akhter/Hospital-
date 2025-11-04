@php
    
    $leave_data = isset($leave_data) && !empty($leave_data) ? $leave_data : [];
    $leavetypedays_no_pk = $leave_data ? $leave_data->leavetypedays_no_pk : '';
    $leave_type_lkp_no_fk = $leave_data ? $leave_data->leave_type_lkp_no_fk : '';
    $leave_type_lkp_name = $leave_data ? $leave_data->leave_type_lkp_name : '';
    $leave_code = $leave_data ? $leave_data->leave_code : '';
    $no_of_days = $leave_data ? $leave_data->no_of_days : '';
    $status = $leave_data ? $leave_data->status : '';
    $carry_forword_ind = $leave_data ? $leave_data->carry_forword_ind : '';
    $leave_category_lookup_no_fk = $leave_data ? $leave_data->leave_category_lookup_no_fk : '';
    $gender = $leave_data ? $leave_data->gender : '';
    
@endphp

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('leave_setup.store') }}" method="post" id="leave-setup-create">
        @csrf
        <input type="hidden" name="id" value="{{ $leavetypedays_no_pk }}">

        <div class="form-group row">

            <label for="leave_category" class="col-sm-12 col-form-label col-form-label-sm">Leave Category</label>
            <div class="col-sm-12">
                <select class="form-control font_size_12 m-auto" id="leave_category" value=""
                    name="leave_category" onchange="changeLeave(this)"> required>

                    <option value="0">Select Leave Category</option>
                    @if (!empty($leave_category))
                        @foreach ($leave_category as $key => $value)
                            <option value="{{ $key }}" @if ($key == $leave_category_lookup_no_fk) selected @endif>
                                {{ $value }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <label for="leave_type" class="col-sm-12 col-form-label col-form-label-sm">Leave Name</label>
            <div class="col-sm-12" id="leave_name">
                <select class="form-control font_size_12 m-auto" id="leave_type" name="leave_type">
                    <option value="0">Select Leave Name</option>
                    @if ($leave_type_lkp_no_fk !='')
                    <option selected value="{{ $leave_type_lkp_name. '_'. $leave_type_lkp_no_fk }}">{{ $leave_type_lkp_name }}</option>
                    @endif
                  
                    {{-- @if (!empty($leave))
                    @foreach ($leave as $key => $value)
                        <option value="{{ $key }}" @if ($key == $leave_type_lkp_no_fk) selected @endif>
                            {{ $value }}</option>
                    @endforeach
                @endif --}}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="leave_code" class="col-sm-12 col-form-label col-form-label-sm">Leave Code</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" id="leave_code" name="leave_code"
                    value="{{ $leave_code }}" placeholder="Leave Code" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="leave_days" class="col-sm-12 col-form-label col-form-label-sm">Leave Days</label>
            <div class="col-sm-12">
                <input type="number" class="form-control form-control-sm" id="leave_days" name="leave_days"
                    value="{{ $no_of_days }}" placeholder="Leave Days" required>
            </div>
        </div>

        <div class="col-sm-12">
            <label for="gender" class=""><b>Gender</b></label> &nbsp; &nbsp;
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="Male"
                    {{ $gender == 'Male' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender">Male</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="Female"
                    {{ $gender == 'Female' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender">Female</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="gender" value="Both"
                    {{ $gender == 'Both' ? 'checked' : '' }}>
                <label class="form-check-label" for="gender">Both</label>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="carry_forword_ind" id="carry_forword_ind" value="1"
                    {{ $carry_forword_ind == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="carry_forword_ind">Carry Forward</label>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="leave_status" id="leave_status" value="1"
                    {{ $status == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="leave_status">Active</label>
            </div>
        </div>

        @php
            $response_action = route('leave_setup.index');
        @endphp

        <div class="mt-2 modal-inline">
            <button type="submit" class="btn btn-md btn-success"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
        </div>


    </form>
</div>

<script type="text/javascript">
    function changeLeave(params) {
       
        const cate_id = $(params).val();
        console.log(cate_id + 'leave_category')
        $.ajax({
            type: 'POST',
            url: '{{ route('check-leave-type') }}',
            data: {
                cate_id: cate_id,
            },
            success: function(response) {
                // console.log(response)
                var select_item = '';//`<select class = "form-control font_size_12 m-auto" id = "leave_type" name = "leave_type">`;

                $.each(response, function(key, value) {
                    select_item +=
                        `<option value = "${ value }_${ key }">${value} </option>`;
                });
                // select_item += ` </select>`;
                $('#leave_type').html(select_item);
            },
            error: function() {

            }

        });
    }
    
    $(document).ready(function() {

        const cate_id = $('#leave_category').find(':selected').val();
        // console.log(cate_id + '___cate_id')
        $.ajax({
            type: 'POST',
            url: '{{ route('check-leave-type') }}',
            data: {
                cate_id: cate_id,
            },
            success: function(response) {
                // console.log(response)
                var select_item ='';// `<select class = "form-control font_size_12 m-auto" id = "leave_type" name = "leave_type">`;

                $.each(response, function(key, value) {
                    select_item +=
                        `<option value = "${ value }_${ key }">${value}</option>`;
                });
                // select_item += ` </select>`;
                $('#leave_type').append(select_item);
            },
            error: function() {

            }

        });


    });
</script>
