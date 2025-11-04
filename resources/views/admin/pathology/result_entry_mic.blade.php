<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Result Entry</h5>
            <small>Pathology / Result Entry</small>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab cursor-pointer" data-toggle="tab" role="tab"
                        aria-controls="Result Entry" aria-selected="true" href="{{ route('path.result-entry-mic') }}"
                        rel="tab">Result Entry</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab cursor-pointer" data-toggle="tab" role="tab"
                        aria-controls="Verified Results" aria-selected="false"
                        href="{{ route('path.verified-results-mic') }}" rel="tab">Verified Results</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="result-entry" role="tabpanel"
                    aria-labelledby="received-by-challan-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('admin.pathology.result_entry_search_panel_mic')
                        </div>
                        <div class="col-md-2 pt-4 text-right">
                            <strong>Analyzer : </strong>
                            <span class="badge badge-success">Auto</span>
                            <span class="badge badge-danger">Manual</span>
                        </div>
                    </div>
                    <div id="financial-list">
                        @include('admin.pathology.result_entry_list_mic')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openInvoiceAutocomplete("#prescription_id");
    $('.select2').select2();
    $('body').on('click', '.show_in_rep', function() {
        if ($(this).is(':checked')) {
            $(this).prop('checked', true)
            $(this).attr('checked', true)
        } else {
            $(this).prop('checked', false)
            $(this).attr('checked', false)
        }
    })

</script>
