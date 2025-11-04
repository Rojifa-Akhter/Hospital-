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
                <th class="text-center" scope="col">Collected</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            @if (!empty($radiologyAppointment))

                @foreach ($radiologyAppointment as $rad_app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td> {{ $rad_app->invoice_code }} </td>

                        <td>{{ date('d/m/Y', strtotime($rad_app->invoice_date)) }}</td>
                        <td> {{ $rad_app->patient_no_fk }} </td>

                        <td>
                        <div class="doctor_info">
                    <span Class="open-modal" data-id="{{ $rad_app->patient_no_fk }}"
                        data-action="{{$rad_app->patient_no_fk !=''?  route('registration.show', $rad_app->patient_no_fk):'' }}" data-modal="common-modal"
                        data-title="View Patient Information" title="View Patient Information">
                        @if ($rad_app->patient_photo != '')
                            <img class="rounded"
                                src="{{ asset('images/uploads/patient_images/thumb/' . $rad_app->patient_photo) }}">
                        @else
                            @if ($rad_app->gender_txt == 'Male')
                                <img class="rounded" src="{{ asset('images/pt-patient.png') }}">
                            @else
                                <img class="rounded" src="{{ asset('images/female.jpg') }}">
                            @endif
                        @endif
                        <div class="doctor_info_data">
                            <ul style="list-style: none;">
                                <li class="cursor-pointer"><u><strong>{{ $rad_app->patient_code }} </strong></u></li>
                                <li class="cursor-pointer"><u>{{ !empty($rad_app->patient_name) ? $rad_app->patient_name : '' }}</u></li>
                                <li>{{ !empty($rad_app->gender_txt) ? $rad_app->gender_txt : '' }} , {{ !empty($rad_app->mobile1) ? $rad_app->mobile1 : '' }}</li>
                            </ul>
                        </div>
                    </span>
                </div>
                        </td>
                        <td>{{ $rad_app->admission_no_pk !='' ? 'IP-'. $rad_app->admission_no_pk.' , Bed Name- '.$rad_app->bed_name :'' }}</td>
                        {{-- <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td>
                <td>{{ $rad_app->prescription_no_fk }}</td> --}}
                        {{-- <td>{{ $rad_app->img_app_sl_no }}</td> --}}
                        <td>{{ $rad_app->item_name }}</td>
                        {{-- <td>{{ $rad_app->room_name }}</td> --}}
                        <td class="text-center" id="icon_id">
                            @if ($rad_app->ic_image_capture_key_ind == 1)
                                <button type="button" id="checkBtn" class="btn btn-sm btn-success "><i
                                        class="fas fa-check"></i></button>
                                <div>
                                    {{ date('d/m/Y', strtotime($rad_app->ic_image_capture_keyed_time)) }}
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($rad_app->ic_image_capture_key_ind == 1)
                                <button type="button" id="UpdateImageData" disabled
                                    class="btn btn-sm btn-success btn-capture"
                                    data-action="{{ route('radiology.update-image-apointment') }}"
                                    data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Sample Collected</button>

                                <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                                    class="btn btn-sm btn-secondary text-black" target="_blank"
                                    data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="Print label"
                                    title="Print label">Label</a>
                            @else
                                <!-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{ route('radiology.update-image-apointment') }}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}" onclick="capture(this)">Capture</button> -->


                                {{-- <button class="btn btn-sm btn-success btn-capture open-modal" data-id=""
                            data-action="{{ route('radiology.radiology-image-capture-popup', $rad_app->radinvoicedtl_no_pk) }}"
                            data-title="Radiology Image Capture" title="Radiology Appointment card"
                            data-modal="common-modal-sm">Capture</button> --}}
                                <button class="btn btn-sm btn-success" onclick="sampleCollect(this)"
                                    data-id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                    data-action="{{ route('radiology.radiology-image-sample-collection-v2') }}"
                                    data-redirect="{{ route('radiology/radiology-sample-' . $menutype) }}"
                                    data-title="Radiology Image Capture" title="Radiology Appointment card">Sample
                                    Collection</button>
                            @endif
                             @inject('trn_id', 'App\Http\Controllers\RadiologyController')

                                @php
                                    $trn_id = $trn_id->getTrnId($rad_app->invoice_code);
                                @endphp
                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('bill-invoice-app', [$rad_app->invoice_code,$trn_id]) }}"
                                    data-modal="common-modal-md" data-title="Invoice Details"
                                    title="View Invoice Details" data-id="{{ $rad_app->invoice_code }}"><i
                                        class="fa fa-eye"></i></span>

                            {{-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{route("radiology.update-image-apointment")}}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Capture</button> --}}
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>


<script>
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
        var reconnect_type = $(buttonElement).data('data-redirect');

        $.ajax({
            url: url,
            type: 'GET', // Use 'POST' or 'GET' based on your backend setup
            data: {
                id: id,
                // Add other necessary data here if needed
            },
            success: function(data) {
                // Handle successful response
                // alert('Sample collected successfully!');

                if (data.title == "Success") {
                    $(".common-modal-notify").modal("show");
                    $(".common-modal-notify .modal-body").html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>"
                    );
                    $(".common-modal-notify .modal-title").html(data.title);
                    $(".common-modal-notify .modal-body").html(data.msg);
                } else {
                    $(".common-modal-notify-error").modal("show");
                    $(".common-modal-notify-error .modal-title").html(
                        data.title
                    );
                    $(".common-modal-notify-error .modal-body").html(
                        data.msg
                    );
                }

                // Use setTimeout to delay the execution by 3000 milliseconds (3 seconds)
                // setTimeout(function() {
                //     window.open(reconnect_type, "_blank", 'noopener,noreferrer');
                // }, 3000);
                // Refresh the page
                dynamicFunc.afterSaveLoadPage(reconnect_type);


            },
            error: function(xhr, status, error) {
                // Handle errors
                alert('An error occurred: ' + error);
            }
        });
    }
</script>
