@php

$testAttribute = isset($testAttribute) && !empty($testAttribute) ? $testAttribute : [];
$teststruct_no_fk = $testAttribute ? $testAttribute->teststruct_no_fk : '';
@endphp
<select class="form-control font_size_12 m-auto select2" id="attribute_name" name="attribute_name" required>
    <option selected="selected" data-price="0" value="">Select Attribute Name</option>
    @foreach ($test_attributes as $record)
        <option value="{{ $record->teststruct_no_pk }}"
            {{ $record->teststruct_no_pk == $teststruct_no_fk ? 'selected' : '' }}>
            {{ $record->attr }}</option>
    @endforeach
</select>
