<div class="card-header ">
    <h5>Laboratory Life Cycle</h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table data_body">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center" scope="col">SL</th>
                        <th class="text-center" scope="col">Invoice ID</th>
                        <th class="text-left" scope="col">Patient Name</th>
                        <th class="text-center" scope="col">UHID</th>
                        <th class="text-center" scope="col">Sample Id</th>
                        <th class="text-center" scope="col">Item Name</th>
                        <th class="text-center" scope="col">Sample Collection</th>
                        <th class="text-center" scope="col">Lab Receive</th>
                        <th class="text-center" scope="col">Machine Entry Time</th>
                        {{-- @if (session()->get('user.ses_hospital_code') != 'UNICO') --}}
                            <th class="text-center" scope="col">Result Entry</th>
                        {{-- @endif --}}


                        @if (session()->get('user.ses_hospital_code') == 'UNICO')
                            <th class="text-center" scope="col">Report Checked</th>
                            <th class="text-center" scope="col">Report Approved</th>
                        @else
                            <th class="text-center" scope="col">Report Verify</th>
                            <th class="text-center" scope="col">Report Finalized</th>
                        @endif
                        <th class="text-center" scope="col">Report Process</th>
                        <th class="text-center" scope="col">Receive at Delivery</th>
                        <th class="text-center" scope="col">Report Delivery</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
                <input type="hidden" name="hospital_code" id="hospital_code"
                    value="{{ session()->get('user.ses_hospital_code') }}">
            </table>
        </div>
    </div>
</div>

<script>
    $(document).on('change', '#pat_type', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
    });

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).ready(function() {

        var datatable = $('.data_body').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [10, 25, 50, 75, 100, 200, 300],
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('laboratoryLifeCycle.getData') }}",
                "dataType": "json",
                "type": "post",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": -1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        const date = new Date(row[9]);

                        const invoice_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                                .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                            date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
                        
                            return `${row[18]??''} ${row[18] !=null? invoice_date:''}`;

                    }
                },
                {
                    "targets": 0,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${row[0] !=null? row[0]:''}`;
                        // return `${row[0]}`;
                    }
                },
                {
                    "targets": 2,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${row[20] !=null? row[20]:''}`;
                        // return `${row[20]}`;
                    }
                },
                {
                    "targets": 3,
                    // "type": 'date',
                    "render": function(data, type, row, meta) {
                       return `${row[11] !=null? row[11]:''}`;
                    //    return `${row[11]}`;
                    }
                },
                {
                    "targets": 4,
                    // "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `${row[1] !=null? row[1]:''}`;
                       //return `${row[1]}`;
                    }
                },
                {
                    "targets": 5,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                       return `${row[2] !=null? row[2]:''}`;
                    }
                },
                {
                    "targets": 6,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[3]);

                        const coll_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[12]??''} ${row[12] !=null? coll_date:''}`;
                                        }
                },
                {
                    "targets": 7,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[4]);

                        const coll_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[13]??''} ${row[13] !=null? coll_date:''}`;
                    }
                },
                {
                    "targets": 8,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[21]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[21] !=null? machine_date:''}`;
                    }
                },
                {
                    "targets": 9,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[5]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[14]??''} ${row[14] !=null? machine_date:''}`;
                    }
                },
                {
                    "targets": 10,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[6]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[15]??''} ${row[15] !=null? machine_date:''}`;
                    }
                },
                {
                    "targets": 11,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[7]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[16]??''} ${row[16] !=null? machine_date:''}`;
                    }
                },
                {
                    "targets": 12,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[8]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[17]??''} ${row[8] !=null? machine_date:''}`;
                    }
                },
                {
                    "targets": 13,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {
                        const date = new Date(row[10]);

                        const machine_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + " " +
                        date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

                        return `${row[18]??''} ${row[10] !=null? machine_date:''}`;
                    }
                },
            ]
        });
    })


    // getData();

    function getData() {
        $.ajax({
            url: "{{ route('laboratoryLifeCycle.getData') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                if (response.data.length != 0) {
                    setTableData(response.data);
                } else {
                    emptyTable();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function setTableData(data) {
        if ($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }
        $('.data_table tbody').empty();
        var rows = [];
        var table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 2, 5, 6, 7, 8, 9, 10, 11, 12],
                    className: 'text-center'
                },
                {
                    targets: [3, 4],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 75, 100, -1],
                [5, 10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 5,
            "rowCallback": function(row, data, index) {
                console.log(data)
                if (data[15] == 2) { // data[1] refers to the `invoice_code` column in this case
                    $(row).css('background-color', '#ffed4a');
                }
            }

        });

        function getNameDatetime(name, datetime) {
            let result = '';
            if (name != null) result += name;
            if (datetime != null) {
                result += ' (' + datetime + ')';
            } else {
                result += 'N/A';
            }
            return result;
        }

        data.forEach(function(item, index) {

            // console.log(item)
            const sample_collection = getNameDatetime(item.sc_sample_coll_keyed_name, item
                .sc_sample_coll_keyed_time);
            const lab_receive = getNameDatetime(item.lab_rcv_from_sp_keyed_name, item
                .lab_rcv_from_sp_keyed_time);
            const result_entry = getNameDatetime(item.result_ent_keyed_name, item
                .result_prepared_keyed_time);
            const report_verify = getNameDatetime(item.result_verify_keyed_name, item
                .result_verify_keyed_time);
            const report_finalized = getNameDatetime(item.result_final_keyed_name, item
                .result_final_keyed_time);
            const report_process = getNameDatetime(item.report_procees_keyed_name, item
                .report_procees_keyed_time);
            const receive_at_delivery = getNameDatetime(item.report_rcb_keyed_name, item
                .report_rcb_keyed_time);
            const report_delivery = getNameDatetime(item.report_delivered_keyed_name, item
                .report_delivered_time);
            var rowData = [];
            if ($('#hospital_code').val() != "UNICO") {
                rowData = [
                    ++index,
                    item.invoice_code,
                    item.patient_name,
                    item.patient_code,
                    item.lab_code,
                    item.item_name,
                    sample_collection,
                    lab_receive,
                    item.mac_result_date,
                    result_entry,
                    report_verify,
                    report_finalized,
                    report_process,
                    receive_at_delivery,
                    report_delivery,
                    item.delivery_status_no,
                ];
            } else {
                rowData = [
                    ++index,
                    item.invoice_code,
                    item.patient_name,
                    item.patient_code,
                    item.lab_code,
                    item.item_name,
                    sample_collection,
                    lab_receive,
                    item.mac_result_date,
                    report_verify,
                    report_finalized,
                    report_process,
                    receive_at_delivery,
                    report_delivery,
                    item.delivery_status_no,
                ];
            }

            rows.push(rowData);

        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
            <tr>
                <td colspan="13" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }

    function formatDate(date) {
        let formattedDate = new Date(date);
        return formattedDate.toLocaleString('en-GB', {
            hour12: true
        });

    }
</script>
