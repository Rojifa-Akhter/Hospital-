@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<div class="col-md-12 table-responsive">
    <table id="datatable" class="table table-bordered table-hover table-striped">
        <thead class="bg-primary">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Invoice Date</th>
                <th class="text-center" scope="col">Invoice ID</th>
                <th class="text-center" scope="col">Admission ID</th>
                <th class="text-center" scope="col">App. SN</th>
                {{-- <th class="text-center" scope="col">UHID</th> --}}
                <th class="text-center" scope="col">Patient Name</th>
                <th class="text-center" scope="col">Service Name</th>
                <th class="text-center" scope="col">Room</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center w-20" scope="col">Action</th>
            </tr>
        </thead>

        <tbody>
            @if (!empty($radiologyAppointment))

                @foreach ($radiologyAppointment as $rad_app)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left" style="text-align: center">
                            {{ $rad_app->invoice_date != '' ? date('d/m/Y', strtotime($rad_app->invoice_date)) : '' }}
                        </td>
                        <td class="text-left">{{ $rad_app->invoice_code }}</td>
                        <td class="text-left">
                            {{ !empty($rad_app->admission_no_pk) ? $rad_app->admission_no_pk : 'N/A' }}
                        </td>
                        <td class="text-left">{{ !empty($rad_app->img_app_sl_no) ? $rad_app->img_app_sl_no : 'N/A' }}
                        </td>
                        {{-- <td class="text-left">{{ !empty($rad_app->patient_code) ? $rad_app->patient_code : '' }} </td> --}}
                        <td class="text-left">
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

                            {{-- {{ !empty($rad_app->patient_name) ? $rad_app->patient_name : '' }}  --}}
                        </td>
                        <td class="text-left">{{ !empty($rad_app->item_name) ? $rad_app->item_name : 'N/A' }} </td>
                        <td class="text-left">{{ !empty($rad_app->room_name) ? $rad_app->room_name : 'N/A' }}</td>
                        @if ($rad_app->finalize_key_ind == 1)
                            <td class=""><span class="badge badge-success text-black">Finalzed</span></td>
                        @elseif($rad_app->result_prepared_key_ind == 1)
                            <td class=""><span class="badge badge-primary text-black">Prepared</span></td>
                        @else
                            <td>
                                <span class="badge badge-warning text-black text-center">Pending</span>
                            </td>
                        @endif
                        <td class="text-center">

                            @if ($hospital->hospital_code == 'UNICO')
                                @if ($ind_flag == 1)
                                    @if ($rad_app->finalize_key_ind != 1)
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route('radiology.result-entry-v3', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}"
                                            target="_blank" rel="noopener noreferrer">Result</a>
                                    @endif
                                    @if ($rad_app->finalize_keyed_by == Session::get('user.ses_person_no_fk'))
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route('radiology.result-entry-v3', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}" target="_blank" rel="noopener noreferrer">Finalize Result</a>
                                    @endif
                                @else
                                    @if ($rad_app->finalize_keyed_by == Session::get('user.ses_person_no_fk'))
                                        <a class="btn btn-sm btn-info text-white"
                                            href="{{ route('radiology.result-entry-v3', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}"
                                            rel="tab" target="_blank">Finalize Result</a>
                                    @endif
                                @endif
                            @else
                                @if ($ind_flag == 1)
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route('radiology.result-entry', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}"
                                        target="_blank" rel="noopener noreferrer">Result</a>
                                @else
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route('radiology.result-entry', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}"
                                        rel="tab" target="_blank">Finalize
                                        Result</a>
                                @endif
                            @endif






                            @if ($hospital->hospital_code != 'GMC' && $hospital->hospital_code != 'KBMH')
                                @if ($hospital->hospital_code == 'UNICO')
                                    <a class="btn btn-md btn-warning text-black"
                                        href="{{ route('v3.radiology.rad-report-pdf', $rad_app->radinvoicedtl_no_pk) }}"
                                        target="_blank">Print</a>
                                @else
                                    <!-- <button class="btn btn-sm btn-warning text-black open-modal"
                                        data-modal="common-modal-sm"
                                        data-action="{{ route('radiology.print-form', $rad_app->radinvoicedtl_no_pk) }}"
                                        data-title="Skip Verify Process Click on View and Finalize Button">Print</button> -->
                                        <a class="btn btn-md btn-warning text-black"
                                    href="{{ route('radiology.rad-report-pdf', $rad_app->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                                @endif

                                @if ($hospital->hospital_code == 'EWMCH')
                                    <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                                        class="btn btn-sm btn-secondary text-black" target="_blank"
                                        data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="Print label"
                                        title="Print label">Label</a>
                                @else
                                    {{-- @if ($rad_app->finalize_key_ind == 1) --}}
                                    <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                                        class="btn btn-sm btn-secondary text-black" target="_blank"
                                        data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="Print label"
                                        title="Print label">Label</a>

                                    @inject('trn_id', 'App\Http\Controllers\RadiologyController')

                                @php
                                    $trn_id = $trn_id->getTrnId($rad_app->invoice_no_pk);
                                @endphp
                                <span Class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('bill-invoice-app', [$rad_app->invoice_no_pk,$trn_id]) }}"
                                    data-modal="common-modal-md" data-title="Invoice Details"
                                    title="View Invoice Details" data-id="{{ $rad_app->invoice_no_pk }}"><i
                                        class="fa fa-eye"></i></span>
                                    {{-- @endif --}}
                                @endif
                            @else
                                <a class="btn btn-md btn-warning text-black"
                                    href="{{ route('radiology.rad-report-pdf', $rad_app->radinvoicedtl_no_pk) }}"
                                    target="_blank">Print</a>
                            @endif

                            @if ($hospital->hospital_code == 'KBMH')
                                <a href="{{ route('radiology-appointment-card-print', $rad_app->radinvoicedtl_no_pk) }}"
                                    class="btn btn-sm btn-secondary text-black" target="_blank"
                                    data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="label_print"
                                    title="Print label">Label</a>
                            @endif

                             <a class="btn btn-sm btn-primary text-white"
                                            href="{{ route('ot.investigation-anesthealization', [$rad_app->invoice_code,$rad_app->item_code]) }}"
                                            target="_blank" rel="noopener noreferrer">Anesthetia Referred</a>

                        </td>


                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="11">No Data Found</td>
                </tr>
            @endif


        </tbody>
    </table>
</div>
<script>
    $(document).on("click", ".btn-capture", function() {
        var action = $(this).attr("data-action");
        var invoice_dtl_id = $(this).attr("data-dtl-id");
        $.ajax({
            data: {
                invoice_dtl_id: invoice_dtl_id
            },
            url: action,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                }
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
