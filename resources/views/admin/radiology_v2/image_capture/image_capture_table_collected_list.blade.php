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
                <th class="text-center" scope="col">Collected</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>

        <tbody>
            <tr>
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
                <td class="text-center" id="icon_id">
                    @if ($rad_app->ic_image_capture_key_ind == 1)
                        <button type="button" id="checkBtn" class="btn btn-sm btn-success "><i
                                class="fas fa-check"></i></button>
                                <div>
                                    {{ date('d/m/Y', strtotime($rad_app->ic_image_capture_keyed_time)) }}
                                </div>

                    @endif
                </td>

                <td class="text-center" id="icon_id">
                    <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                        class="btn btn-sm btn-secondary text-black" target="_blank"
                        data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="Print label"
                        title="Print label">Reprint</a>
                </td>

            </tr>
            @endforeach
            @endif

            </tr>
        </tbody>
    </table>
</div>