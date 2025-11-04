@if (!empty($citys))
    @foreach ($citys as $key => $value)
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" class="city_search"
                        value="{{ !empty($value->chamber_hospital_city_name) ? ucfirst($value->chamber_hospital_city_name) : 'N/A' }}" />
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"
                value="{{ !empty($value->chamber_hospital_city_name) ? ucfirst($value->chamber_hospital_city_name) : 'N/A' }}"
                readonly="" id="city_checkbox" onclick="validate(this)" />
        </div>
    @endforeach
@endif
