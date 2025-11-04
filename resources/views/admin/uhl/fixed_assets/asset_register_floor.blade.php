<select class="form-control form-control-sm select2" id="asset_floor" name="asset_floor" onchange="assetFunc.setLocationData(this)"
required>
<option value="">Select floor</option>
@if (!empty($floors))
    @foreach ($floors as $value)
        <option value="{{ $value->physicalstruct_floor_sl }}">
            {{ $value->physicalstruct_name }}
            (<strong>{{ $value->physicalstruct_desc }}</strong>)
        </option>
    @endforeach
@endif
</select>
