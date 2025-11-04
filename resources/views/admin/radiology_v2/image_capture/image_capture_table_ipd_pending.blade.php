{{-- <link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" /> --}}

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="sample-collection-tab" data-toggle="tab" href="#sample-collection" role="tab" aria-controls="sample-collection" aria-selected="false">Sample Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="collected-tab" data-toggle="tab" href="#collected" role="tab" aria-controls="collected" aria-selected="false">Collected</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
                </li>
            </ul> --}}
            <div class="tab-content" id="myTabContent">

                <!-- Sample Collection Tab -->
                <div class="tab-pane fade" id="sample-collection" role="tabpanel" aria-labelledby="sample-collection-tab">
                    <div class="card capture">
                        <div class="card-header">
                            <h5>Image Capture Worklist</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2" id="search-container">
                                <h5>Pending Samples Collection</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collected Tab -->
                <div class="tab-pane fade" id="collected" role="tabpanel" aria-labelledby="collected-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Collected Samples</h5>
                        </div>
                        <div class="card-body" id="collected-container">
                            <h5>Collected Samples</h5>
                        </div>
                    </div>
                </div>

                <!-- Pending Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="card mt-3">
                        {{-- <div class="card-header">
                            <h5>Pending Samples</h5>
                        </div> --}}
                        <div class="card-body" id="pending-container">
                            <div class="col-md-12 table-responsive">
                                <table id="datatable" class="table table-bordered table-hover table-striped">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" scope="col">SL</th>

                                            <th class="text-center" scope="col">Invoice No</th>

                                            <th class="text-center" scope="col">Invoice Date</th>
                                            <th class="text-center" scope="col">UHID</th>

                                            <th class="text-left" scope="col">Patient Name</th>
                                            <th class="text-center" scope="col">IP Info / Admission Info</th>

                                            {{-- <th class="text-center" scope="col">Appointment Date</th>
                                            <th class="text-center" scope="col">Prescription ID</th> --}}
                                            {{-- <th class="text-center" scope="col">App. SN</th> --}}
                                            <th class="text-left" scope="col"> Service Name</th>
                                            {{-- <th class="text-center" scope="col">Room</th> --}}
                                            {{-- <th class="text-center" scope="col">Collected</th> --}}
                                            <th class="text-center" scope="col">Action</th> </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($radiologyAppointment))
                                            @foreach ($radiologyAppointment as $rad_app)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td> {{ $rad_app->invoice_code }} </td>

                                                    <td>{{ date('d/m/Y', strtotime($rad_app->invoice_date)) }}</td>
                                                     <td> {{ $rad_app->patient_no_fk }} </td>

                                                     <td>{{ $rad_app->patient_name }}</td>
                                                     <td>{{ $rad_app->admission_no_pk }}</td>
                                                    {{-- <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td>
                                                    <td>{{ $rad_app->prescription_no_fk }}</td> --}}
                                                    {{-- <td>{{ $rad_app->img_app_sl_no }}</td> --}}
                                                    <td>{{ $rad_app->item_name }}</td>
                                                    {{-- <td>{{ $rad_app->room_name }}</td> --}}

                                                    <td class="text-center">
                                                        @if ($rad_app->ic_image_capture_key_ind == 1)
                                                            <button type="button" id="UpdateImageData" disabled class="btn btn-sm btn-success btn-capture"
                                                                data-action="{{ route('radiology.update-image-apointment') }}"
                                                                data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Sample Collected</button>
                                                        @else
                                                            <!-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{ route('radiology.update-image-apointment') }}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}" onclick="capture(this)">Capture</button> -->


                                                            {{-- <button class="btn btn-sm btn-success btn-capture open-modal" data-id=""
                                                                data-action="{{ route('radiology.radiology-image-capture-popup', $rad_app->radinvoicedtl_no_pk) }}"
                                                                data-title="Radiology Image Capture" title="Radiology Appointment card"
                                                                data-modal="common-modal-sm">Capture</button> --}}
                                                            <button class="btn btn-sm btn-success" onclick="sampleCollect(this)"
                                                                data-id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                                data-action="{{ route('radiology.radiology-image-sample-collection-v2') }}"
                                                                data-title="Radiology Image Capture" title="Radiology Appointment card">Sample
                                                                Collection</button>
                                                        @endif
                                                        {{-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{route("radiology.update-image-apointment")}}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Capture</button> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}

<script>
    $(document).ready(function() {
        // Initialize DataTables for pending samples on page load
        var pendingTable = $('#datatable').DataTable();

        // Handle tab change for Sample Collection
        $('a#sample-collection-tab').on('click', function(e) {
            var type = $('#typeInput').val();
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collection') }}",
                type: 'GET',
                data: {
                    type: type
                },
                beforeSend: function() {
                    $('#search-container').html('<p>Loading...</p>');
                },
                success: function(data) {
                    $('#search-container').html(data);
                    // Initialize DataTable if it contains a table
                    $('#search-container table').DataTable();
                },
                error: function() {
                    $('#search-container').html('<p>Error loading data.</p>');
                }
            });
        });

        // Handle tab change for Collected samples
        $('a#collected-tab').on('click', function(e) {
            var type = $('#typeInput').val();
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collected') }}",
                type: 'GET',
                beforeSend: function() {
                    $('#collected-container').html('<p>Loading...</p>');
                },
                data: {
                    type: type
                },
                success: function(data) {
                    $('#collected-container').html(data);
                    // Initialize DataTable for collected samples
                    $('#collected-container table').DataTable();
                },
                error: function() {
                    $('#collected-container').html('<p>Error loading data.</p>');
                }
            });
        });
    });


    $(document).on('click', '.open-modal', function() {
        $('.modal-dialog').addClass('modal-dialog-scrollable');

    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Function to handle sample collection
    function sampleCollect(buttonElement) {
        var url = $(buttonElement).data('action');
        var id = $(buttonElement).data('id');

        $.ajax({
            url: url,
            type: 'GET', // Use 'POST' or 'GET' based on your backend setup
            data: {
                id: id,
                // Add other necessary data here if needed
            },
            success: function(response) {
                // Handle successful response
                // alert('Sample collected successfully!');
                var routeUrl = "{{ route('delivery.radiology-label-print') }}/" + id;

                // Use setTimeout to delay the execution by 3000 milliseconds (3 seconds)
                setTimeout(function() {
                    window.open(routeUrl, "_blank", 'noopener,noreferrer');
                }, 3000);
                // Refresh the page
                dynamicFunc.afterSaveLoadPage("{{ route('radiology.radiology-image-capture-v2') }}");




            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('An error occurred: ' + error);
            }
        });
    }
</script>
