@php
use Illuminate\Support\Facades\File;
@endphp
<div class="col-md-12 table-responsive">
    <table id="datatable" class="table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Invoice Date</th>
                <th class="text-center" scope="col">Invoice Code</th>
                <th class="text-center" scope="col">Admission ID</th>
                <th class="text-center" scope="col">App. SN</th>
                <th class="text-center" scope="col">Patient ID</th>
                <th class="text-center" scope="col">Patient Name</th>
                <th class="text-center" scope="col">Investigation</th>
                <th class="text-center" scope="col">Room</th>
                <th class="text-center" scope="col">Status</th>
                @if(Session::get('user.ses_hospital_code')=="IMPERIAL")
                <th class="text-center" scope="col">Template</th>
                @endif
                <th class="text-center w-20" scope="col">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($radiologyAppointment as $rad_app)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center" style="text-align: cente; white-space:nowrap">{{ $rad_app->invoice_date != '' ? date('d-m-Y', strtotime($rad_app->invoice_date)) : '' }}</td>
                    <td class="text-center">{{ $rad_app->invoice_code }}</td>

                    <td class="text-center">{{ $rad_app->admission_no_pk }}</td>
                    <td class="text-left">{{ $rad_app->img_app_sl_no }}</td>
                    <td class="text-center">{{ $rad_app->patient_no_fk }}</td>
                    <td class="text-left">{{ $rad_app->patient_name }}</td>
                    <td class="text-left">{{ $rad_app->item_name }}</td>
                    <td class="text-left">{{ $rad_app->room_name }}</td>
                    @if ($rad_app->finalize_key_ind == 1)
                        <td class="text-center"><span class="badge badge-success text-black">Finalized</span></td>
                        {{-- @elseif($rad_app->verify_key_ind==1)<td class="text-center"><span class="badge badge-info text-black">Verifed</span></td> --}}
                    @elseif($rad_app->result_prepared_key_ind == 1)
                        <td class="text-center"><span class="badge badge-primary text-black">Prepared</span></td>
                    @else
                    <td>
                        <span class="badge badge-warning text-black text-center">Pending</span>
                    </td>
                    @endif
                    @if(Session::get('user.ses_hospital_code')=="IMPERIAL")
                    <td class="text-left">

                        <select class="form-control form-control-sm result_template" id="result_template" name="result_template" @if($rad_app->finalize_key_ind == 1) disabled @endif>
                            <option value="">Choose Template</option>
                            @if (!empty($template_name))
                            @foreach ($template_name as $template)
                            <option value="{{ $template->result_template_no_pk }}_{{$rad_app->radinvoicedtl_no_pk}}">
                                {{ $template->template_name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </td>
                    @endif
                    <td class="text-center">
                        @if ($ind_flag == 1)
                        <a class="btn btn-sm btn-info text-white" href="{{ route('radiology.result-entry', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}" target="_blank" rel="noopener noreferrer">Result</a>
                    @else
                        <a class="btn btn-sm btn-info text-white" href="{{ route('radiology.result-entry', [$rad_app->radinvoicedtl_no_pk, $ind_flag]) }}" target="_blank" rel="noopener noreferrer">Finalize
                            Result</a>
                    @endif

                        {{-- <button class="btn btn-sm btn-warning text-black open-modal" data-modal="common-modal-sm" data-action="{{ route('radiology.print-form', $rad_app->radinvoicedtl_no_pk) }}" data-title="Skip Verify Process Click on View and Finalize Button">Print</button> --}}
                        {{-- <a class="btn btn-sm btn-warning text-black" --}}
                        {{-- href="{{  route("radiology.rad-report-pdf",$rad_app->radinvoicedtl_no_pk)}}" target="_blank">Print</a> --}}
                        <a class="btn btn-sm btn-warning text-black"
                        href="{{  route("v1.radiology.rad-report-pdf",$rad_app->radinvoicedtl_no_pk)}}" target="_blank">Print</a>



                        <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}" class="btn btn-sm btn-secondary text-black" target="_blank" data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="Print label" title="Print label">Label</a>
                        @if(Session::get('user.ses_hospital_code')=="IMPERIAL" && File::exists(public_path('images/uploads/radiology_report/' . $rad_app->radinvoicedtl_no_pk.'.doc')) && $rad_app->finalize_key_ind == 1)
                        <a href="{{ route('documents-open', $rad_app->radinvoicedtl_no_pk) }}" class="btn btn-sm btn-info text-black" target="_blank" data-id="{{ $rad_app->radinvoicedtl_no_pk }}"  title="Word file open"><i class="fas fa-file-word"></i></a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No Data Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<script>
    $('.result_template').on('change', function() {
        var selectedOption = $(this).val();
        if (selectedOption != "") {
            var templete_url = "{{ route('documents', ':id') }}";
            templete_url = templete_url.replace(":id", selectedOption);
            console.log(templete_url)
            window.open(templete_url);
        }


    });
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
