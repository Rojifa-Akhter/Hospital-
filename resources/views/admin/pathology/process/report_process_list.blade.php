<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">


<form id="result_processed" action="{{ route('path.save-checkbox') }}" method="post">
    @csrf

    <table class="table table-bordered table-hover table-striped m-0 mt-2 RePc">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL#</th>
                <th class="text-left">UHID </th>
                <th>Invoice No </th>
                <th>LAB No</th>
                <th>LAB ID</th>
                <th style="width: 3%;">Sample Coll. Date</th>
                <th>Exam Name</th>
                <th>Specimen</th>
                <th>Container</th>
                <th>Analyzer</th>
                <th>Status</th>
                <th>
                    <input type="checkbox" id="selectAll" />
                </th>
                {{-- <th class="text-center">Print &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox" id="selectAllPath"
                        class="ml-4" checked />
                </th> --}}
            </tr>
        </thead>
        <tbody>

            @if (!empty($invoice_item_arr))

                @foreach ($invoice_item_arr as $row)

                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $row->patient_code }}</td>
                        <td>{{ $row->invoice_no_fk }}</td>
                        <td>{{ $row->lab_no_pk }}</td>
                        <td>{{ $row->lab_code }}</td>
                        <td>{{ date('d/m/Y', strtotime($row->sc_sample_coll_keyed_time)) }}</td>
                        <td>{{ $row->item_name }}</td>
                        <td>{{ $row->sam_name }}</td>
                        <td>{{ $row->container_name }}</td>

                        @if ($row->lab_result_prepared_key_ind == 1)
                            <td>Done</td>
                        @else
                            <td></td>
                        @endif

                        @if ($row->report_rcb_ind == 1)
                            <td class="text-center">
                                <span class="badge badge-success ">
                                    Receive Pending
                                </span>
                            </td>
                        @elseif($row->lab_result_final_key_ind == 1)
                            <td class="text-center">
                                <span class="badge badge-primary">
                                    Finalized
                                </span>
                            </td>
                        @endif
                        <td class="text-center">
                            <input type="checkbox" class="is_check" name="is_paid_amount[]" id="checkBOx"
                                value="{{ $row->report_no_fk }}"
                                {{ $row->report_rcb_ind == '1' ? 'checked disabled' : '' }}>
                        </td>
                        {{-- <td>
                            @php

                                $report_url = $row->report_url != null ? route($row->report_url, $row->report_no_fk) : '#';
                            @endphp

                            <span class="btn btn-sm btn-warning" target="_blank" data-invoice="{{ $row->invoice_no_fk }}"
                                data-report_route="{{ $report_url }}"
                                onclick="reportPrint(this)">Report</span>
                            <a href="{{ route('delivery.pathology-label-print', $row->invoice_no_fk) }}"
                                class="btn btn-sm btn-secondary text-black" target="_blank"
                                data-id="{{ $row->invoice_no_fk }}" id="pathology_delivery"
                                title="Print label">Label</a>

                            &nbsp;
                            <input type="checkbox" name="mulltiple_print_path[]" class="mulltiple_print_path"
                                id="mulltiple_print_path_{{ $row->invoice_no_fk }}"
                                data-report_id="{{ $row->invoice_no_fk }}" value="{{ $row->invoice_no_fk }}"
                                checked />
                        </td> --}}
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="12" class="text-danger">No Data Found</td>
                </tr>
            @endif

            @if (empty($invoice_item_arr))
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-left"></td>
                    <td class="text-center"></td>
                    <td class="text-left"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <td class="text-center"></td>
                    <td class="text-left"></td>
                </tr>

            @else
                <tr>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-left"></td>
                    <td class="text-center"></td>
                    <td class="text-left"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-left"></td>
                    <td class="text-center">
                        @php
                            $response_action = route('report-process-pathology');
                        @endphp
                        <button class="btn btn-sm btn-success"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Send
                            to Reception</button>


                    </td>
                    {{-- <td class="text-left">
                        <div class=" text-right">
                            <button id="all_print" type="button" onclick="allLabelPrintPath(this)" data-url=""
                                target="_blank" class="btn btn-sm btn-secondary text-black mr-2 ">Label print
                                All</button>
                        </div>
                    </td> --}}
                </tr>

            @endif

        </tbody>

    </table>
</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
 $('.RePc').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });



    $('#selectAll').click(function(e) {
        // var table= $(e.target).closest('table');
        // $('td input:checkbox .is_check').prop('checked',this.checked);
        // $('.is_check).prop('checked',this.checked);
        if ($('#selectAll').is(':checked')) {
            $('.is_check').prop('checked', true);
        } else {
            $('.is_check').prop('checked', false);
        }
    });
    $('#selectAllPath').click(function(e) {
        if ($('#selectAllPath').is(':checked')) {
            $('.mulltiple_print_path').prop('checked', true);
        } else {
            $('.mulltiple_print_path').prop('checked', false);
        }
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
                    // window.location.replace(report_route, '_blank');
                    window.open(report_route, '_blank');
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

    function allLabelPrintPath(element) {
        var report_id = $('.mulltiple_print_path').map((_, el) => el.value).get();
        var id = '';
        report_id.forEach(element => {
            if ($('#mulltiple_print_path_' + element).is(':checked')) {
                id += element + '_';
            }
        });
        console.log(id);
        var url = "{{ route('delivery.pathology-label-print-all', ':report_data') }}";
        var pdf_url_id = url.replace(':report_data', id);
        window.location.replace(pdf_url_id);
    }

    // function allReportPrintPath(element) {
    //     var report_id = $('.mulltiple_print_path').map((_, el) => el.value).get();
    //     var report_url= $('.mulltiple_print_path').attr('data-report_route');
    //     console.log(jQuery.makeArray(report_url ));
    //     var id = '';
    //     var url ='';
    //     report_id.forEach(element => {
    //         if ($('#mulltiple_print_path_' + element).is(':checked') && $('#mulltiple_print_path_' + element).prop(
    //                 'disabled') == false) {
    //             id += element + '_';
    //             url += $('#mulltiple_print_path_' + element).attr('data-report_route')+'_';
    //         }
    //     });
    //     if (!id) {
    //         return;
    //     }
    //     console.log(id);
    //     console.log(url);
    //     return;
    //     var url = "{{ route('delivery.pathology-label-print-all', ':report_data') }}";
    //     var pdf_url_id = url.replace(':report_data', id);
    //     window.location.replace(pdf_url_id);
    // }

</script>
