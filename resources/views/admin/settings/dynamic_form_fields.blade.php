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
                
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Field For ({{$templates->form_templates_name}})</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                           
                            <form action="{{ route('store-fields') }}" method="POST" id="fields">
                                @csrf
                                <input type="hidden" name="form_template_id" value="{{ $templates->form_templates_no_pk }}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="label">Label</label>
                                        <input type="text" class="form-control" id="label" name="label"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="field_name">Field Name</label>
                                        <input type="text" class="form-control" id="field_name" name="field_name"
                                            required>
                                        <small class="form-text text-muted">
                                            Must be unique for this form (e.g., "patient_name")
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="db_column_name">DB Column Name</label>
                                        <input type="text" class="form-control" id="db_column_name" name="db_column_name"
                                            required>
                                        <small class="form-text text-muted">
                                            Must be unique for this form (e.g., "patient_name")
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label for="field_type">Field Type</label>
                                        <select class="form-control" id="field_type" name="field_type" required>
                                            <option value="text">Text Input</option>
                                            <option value="textarea">Text Area</option>
                                            <option value="radio">Radio Buttons</option>
                                            <option value="checkbox">Checkboxes</option>
                                            <option value="select">Dropdown</option>
                                            <option value="number">Number</option>
                                            <option value="date">Date</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="options-group" style="display:none;">
                                        <label for="options">Options</label>
                                        <textarea class="form-control" id="options" name="options" placeholder="Enter one option per line"></textarea>
                                        <small class="form-text text-muted">
                                            For radio, checkbox, or select. After One option write * .
                                        </small>
                                    </div>
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="is_required"
                                            name="is_required" value="1">
                                        <label class="form-check-label" for="is_required">Required Field</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" class="form-control" id="sort_order" name="sort_order"
                                            value="0">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @php
                                            $response_action = route('create-fields');
                                    @endphp
                                    <button type="submit" class="btn btn-primary"  onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save Field</button>
                                </div>
                            </form>
                      
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