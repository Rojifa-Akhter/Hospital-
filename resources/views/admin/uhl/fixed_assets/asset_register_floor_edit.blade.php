<select class="form-control form-control-sm select2" id="asset_floor" name="asset_floor" onchange="assetFunc.setLocationData(this)"
disabled>
<option value="">Select floor</option>
@if (!empty($floors))
    @foreach ($floors as $value)
        <option value="{{ $value->physicalstruct_floor_sl }}"  {{ $asset_register_data->physicalstruct_floor_sl == $value->physicalstruct_floor_sl ? 'selected' : '' }}>
            {{ $value->physicalstruct_name }}
            (<strong>{{ $value->physicalstruct_desc }}</strong>)
        </option>
    @endforeach
@endif
</select>
