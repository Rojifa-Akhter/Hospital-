<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            @if (Session::get('user.serviceunit') == 'NURSING')
                <h5 class="mt-2 mb-0">Draft Result</h5>
                <small>Pathology / Draft Result</small>
            @else
                @if (isset($mailType) && $mailType == 1)
                    <h5 class="mt-2 mb-0">Result Print & Mail</h5>
                    <small>Pathology / Print & Mail</small>
                @else
                    <h5 class="mt-2 mb-0">Result Finalized</h5>
                    <small>Pathology / Result Finalized</small>
                @endif

            @endif

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                    aria-labelledby="received-by-challan-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            @include('admin.pathology.result_print_delivery_search_panel')
                        </div>
                    </div>
                    <div id="financial-list">
                        @include('admin.pathology.result_entry_delivery_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2();

    if ($('#mailType').val() == 1) {
        $("body").addClass("sidebar-collapse");
    }

    openInvoiceAutocomplete("#prescription_id");

    function deliveryUpdate(element) {
        if (confirm("Are you sure?")) {
            let report_id = $(element).data('report_id');

            $.ajax({
                data: {
                    report_id: report_id,
                },
                url: "{{ route('report-delivery-from-list') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('#searchResult').click();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }

    function deliveryUpdateRad(element) {
        if (confirm("Are you sure?")) {
            let report_id = $(element).data('report_id');

            $.ajax({
                data: {
                    report_id: report_id,
                },
                url: "{{ route('report-delivery-from-list-rad') }}",
                type: "post",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('#searchResult').click();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }

    // var searchDataRequested = false;

    // window.addEventListener('pageshow', function(event) {
    //     if (event.persisted && !searchDataRequested) {
    //         // Set the flag to prevent multiple executions
    //         searchDataRequested = true;

    //         // Call data_search only once
    //         pathologyFunc.searchResultEntry($('#searchResult'))
    //     }
    // });

    // window.addEventListener('pagehide', function(event) {
    // // Reset the flag when leaving the page
    // searchDataRequested = false;
    // });






    

    // $(document).on("click", "#searchResult", function(e) {
    //     var formID = $("#frm-result-search").attr("id");
    //     var formMethod = $("#frm-result-search").attr("method");

    //     // Radiology result load
    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url: "{{ route('radiology.search-result-entry-print-delivery') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(data) {
    //             // Radiology data goes here
    //             $("#financial-list").html(data);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // });
</script>
