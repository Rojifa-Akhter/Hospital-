@if (!empty($cham_hospital))
    @foreach ($cham_hospital as $key => $value)
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input" class="hospital_search"
                        value="{{ !empty($value->chamber_hospital_name) ? ucfirst($value->chamber_hospital_name) : 'n/a' }}" />
                </div>
            </div>
            <input type="text" class="form-control" aria-label="Text input with checkbox"
                value="{{ !empty($value->chamber_hospital_name) ? ucfirst($value->chamber_hospital_name) : 'n/a' }},{{ !empty($value->chamber_hospital_location) ? ucfirst($value->chamber_hospital_location) : 'n/a' }}({{ $value->chamber_hospital_name_count }})"
                readonly="" />
        </div>
    @endforeach
@endif
