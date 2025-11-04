<form id="result_processed" action="{{ route('rad.save-checkbox') }}" method="post">
    @csrf
    <table class="table table-bordered table-hover table-striped m-0 mt-2">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" scope="col">Apppointment Date</th>
                <th class="text-center" scope="col">Invoice Code</th>
                <th class="text-center" scope="col">App. SN</th>
                <th class="text-center" scope="col">
                    <?php
                    $hospital_code = Session::get('user.ses_hospital_code');
                    ?>
                    @if ($hospital_code != 'UNICO')
                        Patient ID
                    @else
                        UHID
                    @endif


                </th>
                <th class="text-center" scope="col">Patient Name</th>
                <th class="text-center" scope="col">Investigation</th>
                <th class="text-center" scope="col">Room</th>
                <th class="text-center" scope="col">Status</th>
                <th style="width: 10%;">
                    <input type="checkbox" id="selectAll" />
                </th>
                {{-- <th class="" scope="col" style="width: 20%;">
                    <table class="table  table-striped m-0 ">
                        <tr class="global-uhl-table-bg">
                            <th style="border: none; ">
                                <input type="checkbox" id="selectAllRad" /> Report all
                            </th>
                            <th style="border: none; ">
                                <input type="checkbox" id="selectAllRadLabel" /> Label all
                            </th>
                        </tr>
                    </table>
                </th> --}}
            </tr>
        </thead>

        <tbody>
            @if (!empty($radiologyAppointment))

                @foreach ($radiologyAppointment as $rad_app)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left" style="text-align: center">
                            {{ date('d-m-Y', strtotime($rad_app->invoice_date)) }}</td>
                        <td class="text-left">{{ $rad_app->invoice_code }}</td>
                        <td class="text-left">{{ $rad_app->img_app_sl_no }}</td>
                        <td class="text-left">{{ $rad_app->patient_no_fk }}</td>
                        <td class="text-left">{{ $rad_app->patient_name }}</td>
                        <td class="text-left">{{ $rad_app->item_name }}</td>
                        <td class="text-left">{{ $rad_app->room_name }}</td>

                        @if ($rad_app->radt_report_rcb_ind == 1)
                            <td class="text-center">
                                <span class="badge badge-success text-black">
                                    Receive
                                </span>
                            </td>
                        @elseif($rad_app->radt_report_rcb_ind != 1)
                            <td class="text-center">
                                <span class="badge badge-success text-black">
                                    Receive Pending
                                </span>
                            </td>
                        @elseif($rad_app->finalize_key_ind == 1)
                            <td class="text-center">
                                <span class="badge badge-primary text-black">
                                    Finalzed
                                </span>
                            </td>
                        @endif
                        <td class="text-center w-5">
                            <input type="hidden" name="hdn_lab_id" value="{{ $rad_app->invoice_no_pk }}">
                            <input type="checkbox" class="is_check" name="is_paid_amount[]" id="checkBOx"
                                value="{{ $rad_app->rad_report_no_pk }}"
                                {{ $rad_app->radt_report_rcb_ind == '1' ? 'checked disabled' : '' }}>
                        </td>
                        @php
                            $rad_report_url = route('radiology.rad-report-pdf', $rad_app->radinvoicedtl_no_pk);
                        @endphp
                        {{-- <td class="text-center w-15">

                            <input type="checkbox" name="mulltiple_print[]" class="mulltiple_print"
                                id="mulltiple_print_{{ $rad_app->radinvoicedtl_no_pk }}"
                                data-report_id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                value="{{ $rad_app->radinvoicedtl_no_pk }}" />
                            &nbsp;
                            <span class="btn btn-sm btn-warning text-black"
                                data-invoice="{{ $rad_app->invoice_no_pk }}" data-report_route="{{ $rad_report_url }}"
                                target="_blank" onclick="reportPrint(this)">Report</span>

                            &nbsp;
                            <input type="checkbox" name="mulltiple_print_label[]" class="mulltiple_print_label"
                                id="mulltiple_print_label_{{ $rad_app->radinvoicedtl_no_pk }}"
                                data-report_id="{{ $rad_app->radinvoicedtl_no_pk }}"
                                value="{{ $rad_app->radinvoicedtl_no_pk }}" />

                            &nbsp;
                            <a href="{{ route('delivery.radiology-label-print', $rad_app->radinvoicedtl_no_pk) }}"
                                class="btn btn-sm btn-secondary text-black" target="_blank"
                                data-id="{{ $rad_app->radinvoicedtl_no_pk }}" id="admission_id"
                                title="Print label">Label</a>


                        </td> --}}
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12">No Data Found</td>
                </tr>
            @endif


            @if (empty($radiologyAppointment))
                <tr>
                    <td class="text-center" colspan="11"></td>
                </tr>
            @else
                <tr>
                    <td class="text-right" colspan="10">
                        @php
                            $response_action = route('report-process-radiology');
                        @endphp
                        <button class="btn btn-sm btn-success"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send
                            to Reception</button>

                    </td>
                    {{-- <td class="">
                        <div class="">
                            <button id="all_print" type="button" onclick="allReportPrintRad(this)"
                                class="btn btn-sm btn-warning text-black ml-3 ">Report print All</button>
                            <button id="all_print" type="button" onclick="allLabelPrintRad(this)" data-url=""
                                target="_blank" class="btn btn-sm btn-secondary text-black ml-5 ">Label print
                                All</button>
                        </div>
                    </td> --}}
                </tr>
            @endif


        </tbody>
    </table>
</form>
<script>
    $('#selectAll').click(function(e) {
        // var table = $(e.target).closest('table');
        // $('td input:checkbox', table).prop('checked', this.checked);
        if ($('#selectAll').is(':checked')) {
            $('.is_check').prop('checked', true);
        } else {
            $('.is_check').prop('checked', false);
        }
    });

    $('#selectAllRad').click(function(e) {
        if ($('#selectAllRad').is(':checked')) {
            $('.mulltiple_print').prop('checked', true);
        } else {
            $('.mulltiple_print').prop('checked', false);
        }
    });
    $('#selectAllRadLabel').click(function(e) {
        if ($('#selectAllRadLabel').is(':checked')) {
            $('.mulltiple_print_label').prop('checked', true);
        } else {
            $('.mulltiple_print_label').prop('checked', false);
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

    function reportPrint(thisElement) {
        var invoice_id = $(thisElement).attr("data-invoice");
        var report_route = $(thisElement).attr("data-report_route");
        // var pdf_url ="{{ route('radiology.rad-report-pdf', ':id') }}";
        // var pdf_url_id=pdf_url.replace(':id', report_id);
        if (report_route == "#") {
            return;
        }
        var url = "{{ route('radiology.rad-report-validate') }}";

        $.ajax({
            async: true,
            data: {
                invoice_id: invoice_id
            },
            url: url,
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                if (data == "PASS") {
                    window.location.replace(report_route, '_blank');
                } else {
                    alert(data);
                    return;
                }
                // $('.common-modal-notify').modal('show');
                // $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                // $('.common-modal-notify .modal-title').html(data.title);
                // $('.common-modal-notify .modal-body').html(data.msg);
                // window.location.href = "{{ route('report-delivery') }}";
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function allLabelPrintRad(element) {
        var report_id = $('.mulltiple_print_label').map((_, el) => el.value).get();
        var id = '';
        report_id.forEach(element => {
            if ($('#mulltiple_print_label_' + element).is(':checked')) {
                id += element + '_';
            }
        });
        console.log(id);
        var url = "{{ route('delivery.radiology-label-print-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }

    function allReportPrintRad(element) {
        var report_id = $('.mulltiple_print').map((_, el) => el.value).get();
        var id = '';
        //         var array = $('.mulltiple_print').map(function(){
        //   return $(this).attr('data-paymentStatus')
        // }).get();
        console.log(report_id);
        report_id.forEach(element => {
            if ($('#mulltiple_print_' + element).is(':checked') && $('#mulltiple_print_' + element).prop(
                    'disabled') == false) {
                id += element + '_';

            }
        });
        if (!id) {
            return;
        }
        console.log(id);

        var url = "{{ route('radiology.rad-report-pdf-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }
</script>
