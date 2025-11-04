@php

$testAttribute = isset($testAttribute) && !empty($testAttribute) ? $testAttribute : [];

$teststructval_no_pk = $testAttribute ? $testAttribute->teststructval_no_pk : '';
$analyzer_no_fk = $testAttribute ? $testAttribute->analyzer_no_fk : '';
$teststruct_no_fk = $testAttribute ? $testAttribute->teststruct_no_fk : '';
$test_result = $testAttribute ? $testAttribute->test_result : '';
$default_ind = $testAttribute ? $testAttribute->default_ind : '';
$status = $testAttribute ? $testAttribute->status : '';
$item_no_fk = $testAttribute ? $testAttribute->item_no_fk : '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('path.attribute-data-default-store') }}" method="post" id="att-create">
        @csrf

        <div class="form-group row">
            <div class="col-md-6">
                <label for="su_name" class="">Service Item <span class="text-danger">*</span></label>
                <div class="">
                    <input type="hidden" name="id" value="{{ $teststructval_no_pk }}">

                    <select class="form-control font_size_12 m-auto select2" onchange="getAttribute(this)"
                        id="item_name_parent" name="item_name_parent" required>
                        <option selected="selected" data-price="0" value="">Select Service Item</option>
                        @foreach ($pathAttrubute as $record)
                            <option value="{{ $record->item_no_pk }}"
                                {{ $record->item_no_pk == $item_no_fk ? 'selected' : '' }}>
                                {{ $record->item_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <label for="attribute_list" class="">Attribute Name <span
                        class="text-danger">*</span></label>
                <div class="attribute_list_data">
                    @include('admin.settings.path_attribute.path_attribute_value_list')
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-md-6">
                {{-- <label for="default_value" class="">Default Value</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="default_value"
                        name="default_value" value="" placeholder="Enter Default Value">
                </div> --}}
                <div class="card p-0 m-0 border-0">
                    <div class="card-header p-0 m-0">Default Value</div>
                    <div class="card-body p-0 m-0"><textarea id="def_value"
                            name="default_value">{{ $test_result }}</textarea></div>
                </div>



            </div>

            <div class="col-md-6">
                <label for="default_value" class=""></label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="default_ind" id="default_ind" value="1"
                            {{ $default_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="default_ind">Default</label>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group row">

            <div class="col-md-6">
                <label for="status" class="">Status</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                            {{ $status == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal-footer">
            @php
                $response_action = route('pathology/attribute-list');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="{{ route('pathology/attribute-list') }}" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>




<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    loadEditor("def_value");

    $(document).on('change', '#item_name_parent', function() {
        var item_id = $('#item_name_parent').val();

        $.ajax({
            url: "{{ route('path.attribute-data') }}",
            type: 'POST',
            data: {
                item_id: item_id
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.attribute_list_data').html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    })
    $('.select2').select2({});
</script>
