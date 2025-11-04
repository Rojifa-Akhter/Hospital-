<!-- CSS Links -->
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Sample Collection</h5>
            <small>
                {{ $menutype }} / Sample Collection
            </small>
            <input type="hidden" id="typeInput" placeholder="Enter type" value="{{ $type }}">

        </div>
        {{-- <div class="col-md-8 text-right">
            <h4 class="text-danger mt-2" style="font-family: emoji;">
                Press Enter For Search
            </h4>
        </div> --}}
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="sample-collection-tab" data-toggle="tab"
                        href="#sample-collection">Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="collected-tab" data-toggle="tab" href="#collected">Collected</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ipd-pending-tab" data-toggle="tab" href="#ipd-pending">IPD Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ipd-collected-tab" data-toggle="tab" href="#ipd-collected">IPD Collected</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- Sample Collection Tab -->
                <div class="tab-pane fade show active" id="sample-collection" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5><i class="fa fa-search"></i> Search</h5>
                        </div>
                        <div class="card-body">
                            <form id="frmSearch" action="{{ route('radiology.search-image-prescription') }}"
                                method="POST">
                                @csrf
                                <div class="form-row justify-content-center">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm"
                                                for="appointment_list_form">Invoice
                                                Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm m-0 from_date date_picker"
                                                    id="appointment_list_form" name="appointment_list_form"
                                                    value="" placeholder="dd-mm-yyyy">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 date_picker"
                                                    id="appointment_list_to" name="appointment_list_to" value=""
                                                    placeholder="dd-mm-yyyy">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <label class="col-form-label col-form-label-sm"
                                                for="appointment_list_form">Invoice
                                                ID.</label>
                                        <input type="text" class="form-control form-control-sm" id="invoice_id"
                                            name="invoice_id" maxlength="50" placeholder="Enter Invoice ID">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="button" class="btn btn-block btn-success"
                                            id="btnSearchAppointment">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Image Capture Worklist</h5>
                        </div>
                        <div class="card-body" id="search-container">
                            @include('admin.radiology_v2.image_capture.image_capture_table_v2')
                        </div>
                    </div>
                </div>

                <!-- Collected Tab -->
                <div class="tab-pane fade" id="collected" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Collected Samples</h5>
                        </div>
                        <div class="card-body" id="collected-container">
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Tab -->
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Pending Samples</h5>
                        </div>
                        <div class="card-body" id="pending-container">
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>

                <!-- IPD Pending Tab -->
                <div class="tab-pane fade" id="ipd-pending" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>IPD Pending Samples</h5>
                        </div>
                        <div class="card-body" id="ipd-pending-container">
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>

                <!-- IPD Collected Tab -->
                <div class="tab-pane fade" id="ipd-collected" role="tabpanel">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>IPD Collected Samples</h5>
                        </div>
                        <div class="card-body" id="ipd-collected-container">
                            <p>Loading...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Links -->
<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Datepicker and Select2
        $('.date_picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $('.select2').select2();

        // Load tab data function
        function loadTabData(url, container) {
            var type = $('#typeInput').val();
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    type: type
                },
                beforeSend: function() {
                    $(container).html('<p>Loading...</p>');
                },
                success: function(data) {
                    $(container).html(data);
                },
                error: function() {
                    $(container).html('<p>Error loading data.</p>');
                }
            });
        }

        // Tab click event handling
        $('a#collected-tab').on('click', function(e) {
            e.preventDefault();
            loadTabData("{{ route('radiology.radiology-image-capture-collected') }}",
                '#collected-container');
        });
        $('a#sample-collection').on('click', function(e) {
            e.preventDefault();
            loadTabData("{{ route('radiology.radiology-image-capture-collection') }}",
                '#collected');
        });

        $('a#pending-tab').on('click', function(e) {
            e.preventDefault(); // Prevent default tab switch
            loadTabData("{{ route('radiology.radiology-image-capture-pending') }}",
                '#pending-container');

            // Manually activate the tab after loading data
            $('#myTab a').removeClass('active');
            $(this).addClass('active'); // Activate the clicked tab

            // Manually switch the tab content as well
            $('#myTabContent .tab-pane').removeClass('active show');
            $('#pending').addClass('active show'); // Show the pending tab content
        });

        $('a#ipd-pending-tab').on('click', function(e) {
            e.preventDefault();
            loadTabData("{{ route('radiology.radiology-image-capture-ipd-pending') }}",
                '#ipd-pending-container');
        });

        // Handle IPD Collected tab
        $('a#ipd-collected-tab').on('click', function(e) {
            e.preventDefault();
            loadTabData("{{ route('radiology.radiology-image-capture-ipd-collected') }}",
                '#ipd-collected-container');
        });

        // Search button click
        $('#btnSearchAppointment').on("click", function() {
            var type = $('#typeInput').val();
            $.ajax({
                data: $('#frmSearch').serialize() + '&type=' + encodeURIComponent(type),
                url: $('#frmSearch').attr('action'),
                type: 'POST',
                beforeSend: function() {
                    // Show loading UI (optional)
                },
                success: function(data) {
                    $("#search-container").html(data);
                }
            });
        });


        // Handle Enter key in Invoice ID field
        $('#invoice_id').on('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                $('#btnSearchAppointment').click(); // Trigger search
            }
        });
    });
</script>
