@php
    $redirect_url = route('v1.medical-benefit-setup');
@endphp

<form action="{{ route('v1.update-medical-benefit') }}" method="post" id="updateMedicalBenefitForm">
    @csrf
    <input type="hidden" name="medical_benefit_no_pk" value="{{ $data->medical_benefit_pk }}">

    <div class="form-group form-row">
        <label for="benefit_type_no" class="col-4 col-form-label">
            Benefit Type <span style="color:#dc3545">*</span>
        </label>
        <div class="col-8">
            <select name="benefit_type_no" id="benefit_type_no" class="form-control form-control-sm select2" required>
                <option value="">Select Benefit Type</option>
                @foreach ($medicalBenefitTypes as $key => $name)
                    <option value="{{ $key }}"
                        {{ isset($data->benefit_type_no) && $data->benefit_type_no == $key ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="benefit_type_name" id="benefit_type_name"
                value="{{ $data->benefit_type_name ?? '' }}">
        </div>
    </div>

    <div class="form-group form-row">
        <label for="benefit_effective_at" class="col-4 col-form-label">
            Effective Date <span style="color:#dc3545">*</span>
        </label>
        <div class="col-8">
            <input type="date" class="form-control form-control-sm" id="benefit_effective_at"
                name="benefit_effective_at"
                value="{{ isset($data->benefit_effective_at) ? \Carbon\Carbon::parse($data->benefit_effective_at)->format('Y-m-d') : '' }}"
                required>
        </div>
    </div>

    <div class="form-group form-row">
        <label for="benefit_amount" class="col-4 col-form-label">
            Benefit Amount <span style="color:#dc3545">*</span>
        </label>
        <div class="col-8">
            <input type="number" step="0.01" class="form-control form-control-sm" id="benefit_amount"
                name="benefit_amount" placeholder="Enter Benefit Amount" value="{{ $data->benefit_amount ?? '' }}"
                required>
        </div>
    </div>

    <div class="form-group form-row">
        <label for="status" class="col-4 col-form-label">Status</label>
        <div class="col-8">
            <select name="status" id="status" class="form-control form-control-sm">
                <option value="1" {{ isset($data->status) && $data->status == 1 ? 'selected' : '' }}>Active
                </option>
                <option value="2" {{ isset($data->status) && $data->status == 2 ? 'selected' : '' }}>Inactive
                </option>
            </select>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary uhl_save_btn">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
</form>

<script>
    document.getElementById('benefit_type_no').addEventListener('change', function() {
        const selectedKey = this.value;
        const benefitTypes = @json($medicalBenefitTypes);
        document.getElementById('benefit_type_name').value = benefitTypes[selectedKey] || '';
    });

    $('#benefit_type_no').select2({
        placeholder: "Select Benefit Type",
        allowClear: true
    });
</script>
