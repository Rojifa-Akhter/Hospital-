@php    
    $submitRoute = route('leaveDeduction.lateDeductionStore');
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<form method="POST" id="late-deduction-store-{{ rand() }}" action="{{ $submitRoute }}" enctype="multipart/form-data">
    @csrf
    <h5 class="text-center">{{ $full_name }} ({{ date('M, Y', strtotime($monthName)) }})</h5>
    <hr/>
    <div class="form-group row">
        {{-- Leave Type --}}
        <label for="leave_no_fk" class="col-sm-2 col-form-label col-form-label-sm">Leave Type <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control font_size_12 m-auto select2" id="leave_no_fk" name="leave_no_fk" required>
                <option value="" selected disabled>Select Leave Type</option>
                @foreach ($leave_types as $leave_type)
                    <option value="{{ $leave_type->leave_type_lkp_no_fk }}">
                        {{ $leave_type->leave_type_lkp_name }} ({{ $leave_type->no_of_days }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- No of Days --}}
        <label for="no_of_days" class="col-sm-2 col-form-label col-form-label-sm">No of Days</label>
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input type="number" class="form-control form-control-lg " 
                    id="no_of_days" name="no_of_days" value="{{ $to_be_deducted }}" max="{{ $to_be_deducted }}" 
                    placeholder="Enter No. of Days" />
            </div>
        </div>
    </div>

    {{-- Leave Types --}}
    <input type="hidden" name="leave_types" value="{{ $leave_types }}" />

    {{-- Person --}}
    <input type="hidden" name="person_no_fk" value="{{ $person_no_fk }}" />

    {{-- Month & Year --}}
    <input class="form-check-input" type="hidden" name="monthYear" id="monthYear" value="{{ $monthYear }}" />

    {{-- Reason --}}
    <div class="form-group row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="reason" class="col-form-label col-form-label-sm">Reason <span class="text-danger"></span></label>
                <textarea name="reason" required id="reason" class="form-control" cols="30" rows="5" onkeyup="checkBlankSpace(this)" placeholder="Reason" required></textarea>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-3">
            @php
                $redirect_url = route('leaveDeduction');
            @endphp
            <button type="submit" class="btn btn-md btn-primary uhl_save_btn mt-3"
            onclick="btnSaveUpdate(this,'','','','',getData,'{{ $redirect_url }}')">Save</button>
            <button type="button" class="btn btn-md btn-danger mt-3" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-md btn-info mt-3" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();
</script>
