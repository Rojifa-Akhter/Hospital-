<div class="card-header">
    <h5>Radiology Life Cycle</h5>
</div>
<div class="card-body">
    <div class="mt-2">
        <div class="table-responsive border-top border-right">
            <table class="table table-bordered table-hover mb-0 data_table data_body">
                <thead class="bg-light-blue">
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Invoice ID</th>
                        <th class="text-left">Patient Name</th>
                        <th class="text-center">UHID</th>
                        <th class="text-center">Item Name</th>
                        <th class="text-center">Sample Collection</th>
                        <th class="text-center">Lab Receive</th>
                        <th class="text-center">Result Entry</th>

                        @if (session()->get('user.ses_hospital_code') == 'UNICO')
                            <th class="text-center">Report Checked</th>
                            <th class="text-center">Report Approved</th>
                        @else
                            <th class="text-center">Report Verify</th>
                            <th class="text-center">Report Finalized</th>
                        @endif

                        <th class="text-center">Receive at Delivery</th>
                        <th class="text-center">Report Delivery</th>
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
    function formatDate(dateString) {
        if (!dateString || dateString === '0000-00-00 00:00:00') return 'N/A';
        const date = new Date(dateString);
        if (isNaN(date)) return 'N/A';
        return ('0' + date.getDate()).slice(-2) + '-' +
            ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
            date.getFullYear() + ' ' +
            ('0' + date.getHours()).slice(-2) + ':' +
            ('0' + date.getMinutes()).slice(-2) + ':' +
            ('0' + date.getSeconds()).slice(-2);
    }

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.data_body').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [10, 25, 50, 75, 100, 200, 300],
            order: [[0, "desc"]],
            ajax: {
                url: "{{ route('radiologyLifeCycle.getData') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columnDefs: [
                {
                    targets: 0, render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1, render: function (data, type, row) {
                        return row[0] || 'N/A'; // invoice_code
                    }
                },
                {
                    targets: 2, render: function (data, type, row) {
                        return row[1] || 'N/A'; // patient_name
                    }
                },
                {
                    targets: 3, render: function (data, type, row) {
                        return row[2] || 'N/A'; // patient_code
                    }
                },
                {
                    targets: 4, render: function (data, type, row) {
                        return row[3] || 'N/A'; // item_name
                    }
                },
                {
                    targets: 5, render: function (data, type, row) {
                        return formatDate(row[4]); // sample_collection_time
                    }
                },
                {
                    targets: 6, render: function (data, type, row) {
                        return row[5] || 'N/A'; // lab_receive
                    }
                },
                {
                    targets: 7, render: function (data, type, row) {
                        return formatDate(row[6]); // result_entry
                    }
                },
                {
                    targets: 8, render: function (data, type, row) {
                        return formatDate(row[7]); // report_verify / checked
                    }
                },
                {
                    targets: 9, render: function (data, type, row) {
                        return formatDate(row[8]); // report_finalized / approved
                    }
                },
                {
                    targets: 10, render: function (data, type, row) {
                        return formatDate(row[9]); // receive at delivery
                    }
                },
                {
                    targets: 11, render: function (data, type, row) {
                        return formatDate(row[10]); // report_delivery
                    }
                }
            ]
        });
    });
</script>
