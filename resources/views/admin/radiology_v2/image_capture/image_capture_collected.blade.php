<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Sample Collected</h5>
            <small>Radiology / Sample Collected</small>
        </div>
        <div class="col-md-8">
            <h4 class="text-danger float-right mt-2" style="font-family: emoji;">
                <div>Press Enter For Search</div>
            </h4>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " id="sample-collection-tab" data-toggle="tab" href="#sample-collection"
                        role="tab" aria-controls="sample-collection" aria-selected="false">Sample Collection</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="collected-tab" data-toggle="tab" href="#collected" role="tab"
                        aria-controls="collected" aria-selected="true">Collected</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                        aria-controls="pending" aria-selected="false">Pending</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="sample-collection" role="tabpanel"
                    aria-labelledby="sample-collection-tab">

                    <div class="card capture">
                        <div class="card-header">
                            <h5>Image Capture Worklist</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2" id="search-container">
                                <h5>Collected Samples</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="collected" role="tabpanel" aria-labelledby="collected-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Collected Samples</h5>
                        </div>
                        <div class="card-body" id="collected-container">
                            <div class="col-md-12 table-responsive">
                                <table id="datatable" class="table table-bordered table-hover table-striped">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" scope="col">SL</th>
                                            <th class="text-center" scope="col">UHID</th>
                                            <th class="text-center" scope="col">Appointment Date</th>
                                            <th class="text-center" scope="col">Invoice ID</th>
                                            <th class="text-center" scope="col">Invoice Date</th>
                                            <th class="text-center" scope="col">Prescription ID</th>
                                            <th class="text-center" scope="col">App. SN</th>
                                            <th class="text-left" scope="col">Patient Name</th>
                                            <th class="text-left" scope="col"> Investigation</th>
                                            <th class="text-center" scope="col">Room</th>
                                            <th class="text-center" scope="col">Collected</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            @if (!empty($radiologyAppointment))

                                                @foreach ($radiologyAppointment as $rad_app)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> {{ $rad_app->patient_no_fk }} </td>
                                            <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td>
                                            <td> {{ $rad_app->invoice_code }} </td>
                                            <td>{{ date('d/m/Y', strtotime($rad_app->invoice_date)) }}</td>
                                            <td>{{ $rad_app->prescription_no_fk }}</td>
                                            <td>{{ $rad_app->img_app_sl_no }}</td>
                                            <td>{{ $rad_app->patient_name }}</td>
                                            <td>{{ $rad_app->item_name }}</td>
                                            <td>{{ $rad_app->room_name }}</td>
                                            <td class="text-center" id="icon_id">
                                                <button type="button" id="checkBtn" class="btn btn-sm btn-success "><i
                                                        class="fas fa-check"></i></button>
                                                        <div>
                                                            {{ date('d/m/Y', strtotime($rad_app->ic_image_capture_keyed_time)) }}
                                                        </div>

                                            </td>


                                        </tr>
                                        @endforeach
                                        @endif

                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5>Pending Samples</h5>
                        </div>
                        <div class="card-body">
                            <p>Content for Pending Samples will go here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {

        // Handle search button click

        // Handle tab change for Collected samples
        $('a#sample-collection-tab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collection') }}", // Your route here
                type: 'GET',
                beforeSend: function() {
                    $('#search-container').html(
                        '<p>Loading...</p>'); // Show loading message

                },
                success: function(data) {
                    $('#search-container').html(
                        data); // Load the data into the container
                    //    $('#datatable').DataTable(); Initialize DataTables
                },
                error: function() {
                    $('#search-container').html('<p>Error loading data.</p>');
                }
            });
        });

    })

    // Handle tab change for Pending samples
    $('a#pending-tab').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('radiology.radiology-image-capture-pending') }}", // Your route here
            type: 'GET',
            beforeSend: function() {
                $('#pending-container').html('<p>Loading...</p>'); // Show loading message
            },
            success: function(data) {
                $('#pending-container').html(data); // Load the data into the container
            },
            error: function() {
                $('#pending-container').html('<p>Error loading data.</p>');
            }
        });
    });
</script>
