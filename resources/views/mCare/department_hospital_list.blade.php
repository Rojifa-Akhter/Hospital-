@if (!empty($dept))
    @foreach ($dept as $key => $value)
        <div class="input-group mb-2" id="dept_data">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" aria-label="Checkbox for following text input " id="dept_search_id"
                        data_sp_id="" class="dept_search"
                        value="{{ !empty($value->specialization) ? ucfirst($value->specialization) : 'N/A' }}" />
                </div>
            </div>
            <input type="text" class="form-control dept" aria-label="Text input with checkbox"
                value="{{ !empty($value->specialization) ? ucfirst($value->specialization) : 'N/A' }} ({{ !empty($value->specialization_count) ? ucfirst($value->specialization_count) : 'N/A' }})"
                readonly="" />
        </div>
    @endforeach
@endif
