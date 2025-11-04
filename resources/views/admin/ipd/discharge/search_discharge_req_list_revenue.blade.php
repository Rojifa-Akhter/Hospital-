<table class="table data-table border table-striped table-bordered table-hover mb-0">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center"><input type="checkbox" id="selectAllTop" /></th>
            <th class="text-center">SL</th>
            <th class="text-center">Patient</th>
            <th class="text-center">Admission ID</th>
            <th class="text-center">Discharge Date</th>
            <th class="text-center">Doctor</th>
            <th class="text-center">Total Sales</th>
            <th class="text-center">Total Discount</th>
            <th class="text-center">Total Payment</th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($dis_reqLists))
            @foreach ($dis_reqLists as $rap)
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="selectRow" value="{{ $rap->admission_no_pk }}"
                            {{ $rap->revenue_ind ? 'disabled' : '' }}>
                    </td>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        {{ $rap->patient_no_fk ?? '' }} - {{ strtoupper($rap->patient_name ?? '') }}
                    </td>
                    <td class="text-center">{{ $rap->admission_no_pk ?? '' }}</td>
                    <td class="text-center">
                        {{ !empty($rap->dis_datetime) ? date('d/m/Y', strtotime($rap->dis_datetime)) : '' }}
                    </td>
                    <td class="text-left">
                        {{ $rap->primary_doctor_code ?? '' }} - {{ strtoupper($rap->primary_doctor_name ?? '') }}
                    </td>
                    <td class="text-right">{{ number_format($rap->total_sales ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($rap->total_discount ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($rap->total_payment ?? 0, 2) }}</td>
                    <td class="text-center">
                        {{ $rap->revenue_ind ? 'POST' : 'Pending' }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ipd.admission-print-pdf', $rap->admission_no_pk) }}" target="_blank"
                            class="btn btn-outline-primary btn-sm" title="Print Admission Form">
                            <i class="fa fa-book-open"></i>
                        </a>
                        /
                        <a href="{{ route('ipd.ipd-summary-bill-print', $rap->admission_no_pk) }}"
                            class="btn btn-sm btn-warning" target="_blank">
                            <i class="fa fa-file-invoice"></i>
                        </a>
                        /
                        <button {{ $rap->revenue_ind ? 'disabled' : '' }} type="button"
                            data-action="{{ route('ipd.revenue-posting-single', $rap->admission_no_pk) }}"
                            onclick="revenuePostingSingle(this)" class="btn btn-outline-primary btn-sm"
                            title="Revenue Posting">
                            <i class="fas fa-paper-plane text-danger"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot class="global-uhl-table-bg">
        <tr>
            <th class="text-center" colspan="11">
                <button type="button" id="postSelected" class="btn btn-success btn-sm btn-md-global">
                    <i class="fa fa-paper-plane"></i> Post Selected
                </button>
            </th>
        </tr>
    </tfoot>
</table>

<script>
    // Select All Checkbox
    $('#selectAllTop').on('click', function() {
        $('.selectRow:not(:disabled)').prop('checked', this.checked);
    });

    // Bulk Revenue Posting
    $('#postSelected').on('click', function() {
        let selected = [];
        $('.selectRow:checked').each(function() {
            selected.push($(this).val());
        });

        if (selected.length === 0) {
            alert('Please select at least one admission.');
            return;
        }
        if (!confirm('Are you sure you want to post revenue for selected admissions?')) return;

        $.ajax({
            url: "{{ route('ipd.revenue-posting') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                admission_id: selected.join(',')
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                let modalClass = data.title === 'Success' ? '.common-modal-notify' :
                    '.common-modal-notify-error';
                $(modalClass).modal('show');
                $(modalClass + ' .modal-title').html(data.title);
                $(modalClass + ' .modal-body').html(data.msg);

                $.ajax({
                    url: "{{ route('ipd.discharge-req-list-revenue-posting') }}",
                    type: "GET",
                    success: function(res) {
                        $('#page-content').html(res);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            },
            error: function() {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Error");
                $('.common-modal-notify-error .modal-body').html("Something went wrong.");
                $.unblockUI();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // Single-row Revenue Posting
    function revenuePostingSingle(element) {
        let action = $(element).data("action");
        if (!confirm("Are you sure you want to post revenue?")) return;

        $.ajax({
            url: action,
            type: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                let modalClass = data.title === 'Success' ? '.common-modal-notify' :
                    '.common-modal-notify-error';
                $(modalClass).modal('show');
                $(modalClass + ' .modal-title').html(data.title);
                $(modalClass + ' .modal-body').html(data.msg);

                $.ajax({
                    url: "{{ route('ipd.discharge-req-list-revenue-posting') }}",
                    type: "GET",
                    success: function(res) {
                        $('#page-content').html(res);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
