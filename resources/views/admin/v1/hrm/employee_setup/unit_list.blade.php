<label for="doctor_code">Units</label>
<select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
    <option value="">Select</option>
    @if (!empty($service_unit))
        @foreach ($service_unit as $value)
            <option value="{{ $value->serviceunit_no_pk }}">
                {{ $value->serviceunit_name }}</option>
        @endforeach
    @endif
</select>