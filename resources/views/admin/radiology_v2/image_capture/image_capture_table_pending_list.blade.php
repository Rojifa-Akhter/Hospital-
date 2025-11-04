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
                            {{-- <th class="text-center" scope="col">Appointment Date</th>
                                            <th class="text-center" scope="col">Prescription ID</th> --}}
                            {{-- <th class="text-center" scope="col">App. SN</th> --}}
                            <th class="text-left" scope="col"> Service Name</th>
                            {{-- <th class="text-center" scope="col">Room</th> --}}
                            {{-- <th class="text-center" scope="col">Collected</th> --}}
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

                                    <td>{{ $rad_app->patient_name }}</td>
                                    {{-- <td>{{ date('d/m/Y', strtotime($rad_app->img_app_dttm)) }}</td>
                                                    <td>{{ $rad_app->prescription_no_fk }}</td> --}}
                                    {{-- <td>{{ $rad_app->img_app_sl_no }}</td> --}}
                                    <td>{{ $rad_app->item_name }}</td>
                                    {{-- <td>{{ $rad_app->room_name }}</td> --}}

                                    <td class="text-center">
                                        @if ($rad_app->ic_image_capture_key_ind == 1)
                                            <button type="button" id="UpdateImageData" disabled
                                                class="btn btn-sm btn-success btn-capture"
                                                data-action="{{ route('radiology.update-image-apointment') }}"
                                                data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}">Sample
                                                Collected</button>
                                        @else
                                            <!-- <button type="button" id="UpdateImageData" class="btn btn-sm btn-success btn-capture" data-action="{{ route('radiology.update-image-apointment') }}" data-dtl-id="{{ $rad_app->radinvoicedtl_no_pk }}" onclick="capture(this)">Capture</button> -->


                                            {{-- <button class="btn btn-sm btn-success btn-capture open-modal" data-id=""
                                                                data-action="{{ route('radiology.radiology-image-capture-popup', $rad_app->radinvoicedtl_no_pk) }}"
                                                                data-title="Radiology Image Capture" title="Radiology Appointment card"
                                                                data-modal="common-modal-sm">Capture</button> --}}
                                            <button class="btn btn-sm btn-success" onclick="sampleCollect(this)"
                                                data-id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                                data-action="{{ route('radiology.radiology-image-sample-collection-v2') }}"
                                                data-title="Radiology Image Capture"
                                                title="Radiology Appointment card">Sample
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