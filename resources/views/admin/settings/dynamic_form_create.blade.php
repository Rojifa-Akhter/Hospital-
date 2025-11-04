<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Create New Form Fields</h5>
                <small>Settings / Create New Form Fields</small>
            </div>
        </div>
        <div class="card">

            {{-- <div class="card-header">
                <h5>Create Room</h5>
            </div> --}}
            <div class="card-body mt-2">

                <h1>{{ $template[0]->form_templates_name }}</h1>
                @php
                    $submitUrl = Route::has($template[0]->submit_url) ? route($template[0]->submit_url) : '#';
                @endphp
                <form action="{{ $submitUrl }}" method="POST">
                    @csrf
                    <input type="hidden" name="{{ $template[0]->form_template_no_fk }}" value="{{ $template[0]->form_template_no_fk }}">
                    <div class="form-row">
                        @foreach ($template as $field)
                            <div class="col-md-4">
                                <div class="form-group">
                                    
                                    <input type="hidden" name="{{ $field->db_column_name }}"
                                        value="{{ $field->db_column_name }}">
                                    <label for="{{ $field->field_name }}">
                                        {{ $field->label_name }}
                                        @if ($field->is_required)
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if ($field->field_type === 'text')
                                        <input type="text" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}"
                                            @if ($field->is_required) required @endif>
                                    @elseif($field->field_type === 'textarea')
                                        <textarea class="form-control" id="{{ $field->field_name }}" name="{{ $field->field_name }}" rows="3"
                                            @if ($field->is_required) required @endif></textarea>
                                    @elseif($field->field_type === 'radio' && !empty($field->options))
                                        @php
                                            $itemsList = explode('*', trim($field->options));
                                        @endphp
                                        @foreach ($itemsList as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="{{ $field->field_name }}"
                                                    id="{{ $field->field_name }}_{{ $loop->index }}"
                                                    value="{{ $option }}"
                                                    @if ($field->is_required) required @endif>
                                                <label class="form-check-label"
                                                    for="{{ $field->field_name }}_{{ $loop->index }}">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @elseif($field->field_type === 'checkbox' && !empty($field->options))
                                        @php
                                            $itemsList = explode('*', trim($field->options));
                                        @endphp
                                        @foreach ($itemsList as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="{{ $field->field_name }}[]"
                                                    id="{{ $field->field_name }}_{{ $loop->index }}"
                                                    value="{{ $option }}">
                                                <label class="form-check-label"
                                                    for="{{ $field->field_name }}_{{ $loop->index }}">
                                                    {{ $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @elseif($field->field_type === 'select' && !empty($field->options))
                                        @php
                                            $itemsList = explode('*', trim($field->options));
                                        @endphp
                                        <select class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}"
                                            @if ($field->is_required) required @endif>
                                            <option value="">Select an option</option>

                                            @foreach ($itemsList as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($field->field_type === 'number')
                                        <input type="number" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}"
                                            @if ($field->is_required) required @endif>
                                    @elseif($field->field_type === 'date')
                                        <input type="date" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}"
                                            @if ($field->is_required) required @endif>
                                    @else
                                        <input type="text" class="form-control" id="{{ $field->field_name }}"
                                            name="{{ $field->field_name }}"
                                            @if ($field->is_required) required @endif>
                                    @endif

                                    @error($field->field_name)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @php
                        $response_action = route('show-form-fields', $template[0]->form_template_no_fk);
                    @endphp
                    <button type="submit" class="btn btn-primary" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                </form>
            </div>

        </div>
    </div>
    </div>
</section>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Show/hide options field based on field type
        $('#field_type').change(function() {
            const type = $(this).val();
            if (['radio', 'checkbox', 'select'].includes(type)) {
                $('#options-group').show();
            } else {
                $('#options-group').hide();
            }
        });

        // Handle edit field button click
        $('.edit-field').click(function() {
            const field = JSON.parse($(this).data('field'));
            // Populate and show edit modal (similar to add modal)
            // You would need to implement this
        });
    });
</script>
