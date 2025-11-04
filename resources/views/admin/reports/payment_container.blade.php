<form action="{{ route('doctor-payment-ledger-submit') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover data-table">
                <thead class="thead-success">
                    <tr style="background-color: rgb(249, 255, 163)" class="">
                        <th class="text-center"><input type="checkbox" id="selectAll"></th>
                        <th class="text-center">SL</th>
                        <th class="text-center">Bill DATE</th>
                        <th class="text-center">Bill No</th>
                        <th class="text-center">Item Type</th>
                        <th class="text-center">MRN</th>
                        <th class="text-left">Patient Name</th>
                        <th class="text-left">Doctor Code</th>
                        <th class="text-left">Doctor Name</th>
                        <th class="text-center">Episode Type</th>
                        <th class="text-center">Invoice Status</th>
                        <th class="text-right">Charge</th>
                        <th class="text-right">Doctor Amount</th>
                    </tr>
                </thead>
                <tbody id="doctorLedgerTable">
                    @php
                        $totalSales = 0;
                        $totalDoctorAmount = 0;
                    @endphp
                    @foreach ($doctorLedgers as $index => $data)
                        @php
                            $totalSales += $data->ledger_amt_sales;
                            $totalDoctorAmount += $data->doc_amt ?? 0;
                        @endphp
                        <tr class="ledger-row" data-index="{{ $index }}"
                            data-itemtype_no_fk="{{ $data->itemtype_no_fk }}"
                            data-ledger_date="{{ $data->invoice_date }}" data-invoice_date="{{ $data->invoice_date }}"
                            data-invoice_no_pk="{{ $data->invoice_no_pk }}"
                            data-item_type_name="{{ $data->item_type_name }}"
                            data-patient_code="{{ $data->patient_code }}" data-patient_name="{{ $data->patient_name }}"
                            data-doc_code="{{ $data->doc_code }}" data-doc_name="{{ $data->doc_name }}"
                            data-cons_type="{{ $data->cons_type }}"
                            data-status="{{ $data->due > 0 ? 'Due' : 'Paid' }}"
                            data-ledger_amt_sales="{{ $data->ledger_amt_sales }}"
                            data-doc_amt="{{ $data->doc_amt ?? 0 }}"
                            data-person_no_fk_doc="{{ $data->person_no_fk_doc }}"
                            data-patient_no_fk="{{ $data->patient_no_fk }}">
                            <td class="text-center"><input type="checkbox" class="row-checkbox"></td>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $data->invoice_date }}</td>
                            <td class="text-center cursor-pointer">
                                <span href="#" class="text-primary font-weight-bold open-modal"
                                    data-id="{{ $data->invoice_no_pk }}"
                                    data-action="{{ route('doctor-payment-ledger-invoice-details', ['invoice_no_pk' => $data->invoice_no_pk]) }}"
                                    data-modal="common-modal-md" data-title="Invoice Details">
                                    {{ $data->invoice_no_pk }}
                                </span>
                            </td>
                            <td class="text-center">{{ $data->item_type_name }}</td>
                            <td class="text-center">{{ $data->patient_code }}</td>
                            <td class="text-left">{{ $data->patient_name }}</td>
                            <td class="text-left">{{ $data->doc_code }}</td>
                            <td class="text-left">{{ $data->doc_name }}</td>
                            <td class="text-center">{{ $data->cons_type }}</td>
                            <td class="text-center {{ $data->status == "Paid" ? 'text-success' : 'text-danger' }}">
                                {{ $data->status }}
                            </td>
                            <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                            <td class="text-right">{{ number_format($data->doc_amt ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold bg-light">
                        <td colspan="11" class="text-right">Grand Total</td>
                        <td class="text-right" id="totalSalesDisplay">{{ number_format($totalSales, 2) }}</td>
                        <td class="text-right" id="totalDoctorAmountDisplay">{{ number_format($totalDoctorAmount, 2) }}
                        </td>
                        <input type="hidden" name="grand_total" value="{{ $totalSales }}">
                        <input type="hidden" name="grand_doctor_total" value="{{ $totalDoctorAmount }}">
                    </tr>
                    <tr>
                        <td colspan="13" class="text-right">
                            <span class="mr-3">Selected Doctor Amount Total: <b id="selectedTotal">0.00</b></span>
                            <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        const $selectAll = $('#selectAll');
        const $checkboxes = $('.row-checkbox');
        const $selectedTotal = $('#selectedTotal');

        function updateSelectedTotal() {
            let total = 0;
            $('.row-checkbox:checked').each(function() {
                const val = parseFloat($(this).closest('tr').data('doc_amt')) || 0;
                total += val;
            });
            $selectedTotal.text(total.toFixed(2));
        }

        $selectAll.on('change', function() {
            $checkboxes.prop('checked', this.checked);
            updateSelectedTotal();
        });

        $checkboxes.on('change', function() {
            $selectAll.prop('checked', $('.row-checkbox:checked').length === $('.row-checkbox').length);
            updateSelectedTotal();
        });

        $('#submitBtn').on('click', function(e) {
            e.preventDefault();
            const $btn = $(this);
            if ($btn.prop('disabled')) return;

            $btn.prop('disabled', true).text('Submitting...');

            const selectedRows = {};
            const selectedIndexes = [];

            let hasMissingDoctor = false;

            $('.row-checkbox:checked').each(function() {
                const $row = $(this).closest('tr');
                const index = $row.data('index');

                const rowData = {
                    item_no_fk: $row.data('itemtype_no_fk'),
                    ledger_date: $row.data('ledger_date'),
                    invoice_date: $row.data('invoice_date'),
                    itemtype_no_fk: $row.data('itemtype_no_fk'),
                    item_type_name: $row.data('item_type_name'),
                    invoice_no_pk: $row.data('invoice_no_pk'),
                    patient_code: $row.data('patient_code'),
                    patient_name: $row.data('patient_name'),
                    doc_code: $row.data('doc_code'),
                    doc_name: $row.data('doc_name'),
                    cons_type: $row.data('cons_type'),
                    status: $row.data('status'),
                    ledger_amt_sales: $row.data('ledger_amt_sales'),
                    doc_amt: $row.data('doc_amt'),
                    person_no_fk_doc: $row.data('person_no_fk_doc'),
                    patient_no_fk: $row.data('patient_no_fk'),
                };

                if (!rowData.person_no_fk_doc) {
                    alert(`Doctor code missing in selected row: ${index}`);
                    hasMissingDoctor = true;
                    return false;
                }

                selectedIndexes.push(index);
                selectedRows[index] = rowData;
            });

            if (hasMissingDoctor || selectedIndexes.length === 0) {
                alert('Please select at least one valid row.');
                $btn.prop('disabled', false).text('Submit');
                return;
            }

            $.ajax({
                url: '{{ route('doctor-payment-ledger-submit') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    selected_rows: selectedIndexes,
                    rows: selectedRows
                },
                success: function(response) {
                    alert('Submission successful!');
                    window.location.href = "{{ route('doctor-payment-master') }}";
                },
                error: function(xhr) {
                    alert('Something went wrong. Please try again.');
                    console.error(xhr.responseText);
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });
    });
</script>
