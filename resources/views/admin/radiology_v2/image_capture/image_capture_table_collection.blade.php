<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div class=" mt-3">
                        <div class="" id="pending-container">
                            <div class="col-md-12 table-responsive">
                                <table id="datatable" class="table table-bordered table-hover table-striped">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" scope="col">SL</th>
                                            <th class="text-center" scope="col">UHID</th>
                                            {{-- <th class="text-center" scope="col">Appointment Date</th> --}}
                                            <th class="text-center" scope="col">Invoice ID</th>
                                            <th class="text-center" scope="col">Invoice Date</th>
                                            <th class="text-center" scope="col">Prescription ID</th>
                                            <th class="text-center" scope="col">App. SN</th>
                                            <th class="text-left" scope="col">Patient Name</th>
                                            <th class="text-left" scope="col">Investigation</th>
                                            <th class="text-center" scope="col">Room</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($radiologyAppointment))
                                            @foreach ($radiologyAppointment as $rad_app)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td> {{ $rad_app->patient_no_fk }} </td>
                                                    {{-- <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td> --}}
                                                    <td>{{ $rad_app->invoice_code }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($rad_app->invoice_date)) }}</td>
                                                    <td>{{ $rad_app->prescription_no_fk }}</td>
                                                    <td>{{ $rad_app->img_app_sl_no }}</td>
                                                    <td>{{ $rad_app->patient_name }}</td>
                                                    <td>{{ $rad_app->item_name }}</td>
                                                    <td>{{ $rad_app->room_name }}</td>
                                                    <td class="text-center">
                                                        @if ($rad_app->ic_image_capture_key_ind == 1)
                                                            <button type="button" id="UpdateImageData" disabled
                                                                class="btn btn-sm btn-success btn-capture"
                                                                data-action="{{ route('radiology.update-image-apointment') }}"
                                                                data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Sample
                                                                Collected</button>
                                                        @else
                                                            <button class="btn btn-sm btn-success"
                                                                onclick="sampleCollect(this)"
                                                                data-id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                                data-action="{{ route('radiology.radiology-image-sample-collection-v2') }}"
                                                                data-title="Radiology Image Capture"
                                                                title="Radiology Appointment card">Sample
                                                                Collection</button>
                                                        @endif
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
<script>
    $(document).ready(function() {
        $('#collected-datatable').DataTable();

        $('a#sample-collection-tab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-collection') }}",
                type: 'GET',
                beforeSend: function() {
                    $('#search-container').html(
                    '<p>Loading...</p>');
                },
                success: function(data) {
                    $('#search-container').html(data);
                },
                error: function() {
                    $('#search-container').html('<p>Error loading data.</p>');
                }
            });
        });

        $('a#pending-tab').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('radiology.radiology-image-capture-pending') }}",
                type: 'GET',
                beforeSend: function() {
                    $('#pending-container').html(
                    '<p>Loading...</p>');
                },
                success: function(data) {
                    $('#pending-container').html(data);
                },
                error: function() {
                    $('#pending-container').html('<p>Error loading data.</p>');
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

    function sampleCollect(buttonElement) {
        var url = $(buttonElement).data('action');
        var id = $(buttonElement).data('id');

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id,
            },
            success: function(response) {
                var routeUrl = "{{ route('delivery.radiology-label-print') }}/" + id;
                setTimeout(function() {
                    window.open(routeUrl, "_blank", 'noopener,noreferrer');
                }, 3000);
                dynamicFunc.afterSaveLoadPage("{{ route('radiology.radiology-image-capture-v2') }}");
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    }
</script> --}}
