@if ($type == 'referral_summary' || $type == 'referral_performance')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL#</th>
                <th>

                    @if ($type != 'referral_performance')
                        @if (Session::get('user.auth_mark_ind') == 1)
                            <input type="checkbox" id="select-all" /> <!-- Select All Checkbox -->
                        @else
                            <input type="checkbox" id="select-all" disabled /> <!-- Select All Checkbox -->
                        @endif
                    @else
                        <input type="checkbox" id="select-all" disabled /> <!-- Select All Checkbox -->
                    @endif
                </th>
                <th>Referral Name</th>
                <th>Branch Name</th>
                <th>Invoice Qty</th>
                <th>Total Test Qty</th>

                <th>Total Sales Amount</th>

                <th>Payment</th> <!-- Corrected to match SQL field -->
                <th>Discount On Sales</th>
                <th>Net Sales Amount</th>
                @if ($type != 'referral_performance')
                    <th>Doctor Profit</th>
                    <th>Discount From Profit</th>
                @endif
                <th>Payable Profit</th>
                <th>Collection Amount</th> <!-- Corrected to match SQL field -->
                <th>Balance Due Amount</th> <!-- Corrected to match SQL field -->

            </tr>
        </thead>
        <tbody>
            @php
                // Initialize totals for each column
                $total_invoice_qty = 0;
                $total_test_qty = 0;
                $total_sales = 0;
                $total_payment = 0;
                $total_discount_by_org = 0;
                $total_discount = 0;
                $total_doctor_discount = 0;
                $total_net_sales = 0;
                $total_due = 0;
                $total_doctor_profit = 0;
                $total_payable_profit = 0;
                $total_collection_amount = 0; // Add this variable
            @endphp

            @foreach ($data as $row)
                <tr>
                    <!-- Individual Row Checkbox -->
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        @if ($type != 'referral_performance')
                            @if (Session::get('user.auth_mark_ind') == 1)
                                <input type="checkbox" class="select-row" data-id="{{ $row->referral_id }}"
                                    {{ $row->referral_payable_ind == 1 ? 'checked' : '' }} />
                            @else
                                <input type="checkbox" class="select-row" disabled
                                    {{ $row->referral_payable_ind == 1 ? 'checked' : '' }}
                                    data-id="{{ $row->referral_id }}" />
                            @endif
                        @else
                            <input type="checkbox" class="select-row" disabled
                                {{ $row->referral_payable_ind == 1 ? 'checked' : '' }}
                                data-id="{{ $row->referral_id }}" />
                        @endif

                    </td>
                    <td>
                        <a href="{{ route('marketing.referral-doctor-details', [
                            $row->referral_id,
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_from)->format('d-m-y'),
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_to)->format('d-m-y'),
                        ]) }}"
                            class="cursor-pointer" target="_blank" data-id="{{ $row->referral_id }}"
                            title="Referral Doctor Details">
                            {{ $row->referral_name ?? 'Total' }}
                        </a>
                    </td>
                    <td>{{ $row->branch_name ?? '' }}</td>
                    <td class="text-center">{{ number_format($row->total_invoice_qty, 0) }}</td>

                    <td class="text-center">{{ number_format($row->total_test_qty, 0) }}</td>

                    <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>

                    <td class="text-right">{{ number_format($row->total_payment, 2) }}</td>
                    <!-- Corrected to match SQL field -->
                    <td class="text-right">{{ number_format($row->total_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_net_sales, 2) }}</td>
                    @if ($type != 'referral_performance')
                        <td class="text-right">{{ number_format($row->total_doctor_profit, 2) }}</td>
                        <td class="text-right">{{ number_format($row->total_doctor_discount, 2) }}</td>
                        <!-- Assuming it's "Discount from Profit" -->
                    @endif

                    @php
                        $payable_profit = $row->total_doctor_profit - $row->total_doctor_discount;
                    @endphp
                    <td class="text-right">{{ number_format($payable_profit, 2) }}</td>

                    <td class="text-right">

                        {{ number_format($row->total_payment, 2) }}

                    </td>
                    <td class="text-right">{{ number_format($row->total_due, 2) }}</td>


                    @php
                        // Accumulate totals for footer
                        $total_invoice_qty += $row->total_invoice_qty;
                        $total_test_qty += $row->total_test_qty;
                        $total_sales += $row->total_sales;
                        $total_payment += $row->total_payment;
                        $total_discount_by_org += $row->total_discount_by_org;
                        $total_discount += $row->total_discount;
                        $total_doctor_discount += $row->total_doctor_discount;
                        $total_net_sales += $row->total_net_sales;
                        $total_due += $row->total_due;
                        $total_doctor_profit += $row->total_doctor_profit;
                        $total_payable_profit += $payable_profit;
                        $total_collection_amount += $row->total_payment; // Accumulate this value
                    @endphp
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>

                <td class="text-center">{{ number_format($total_test_qty, 0) }}</td>

                <td class="text-right">{{ number_format($total_sales, 2) }}</td>

                <td class="text-right">{{ number_format($total_payment, 2) }}</td>
                <!-- Corrected to match SQL field -->
                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                <td class="text-right">{{ number_format($total_net_sales, 2) }}</td>
                @if ($type != 'referral_performance')
                    <td class="text-right">{{ number_format($total_doctor_profit, 2) }}</td>
                    <td class="text-right">{{ number_format($total_doctor_discount, 2) }}</td>
                    <!-- Assuming it's "Discount from Profit" -->
                @endif
                <td class="text-right">{{ number_format($total_payable_profit, 2) }}</td>

                <!-- Add the total collection and due amounts -->
                <td class="text-right">{{ number_format($total_collection_amount, 2) }}</td>
                <!-- Add this line for total collection -->

                <td class="text-right">{{ number_format($total_due, 2) }}</td> <!-- Add this line for total due -->

            </tr>
        </tfoot>
    </table>
@elseif ($type == 'referral_summary_1')
    <form method="GET" action="{{ route('ledger.print') }}" id="ledger-form">
        <!-- Serial Number Range and Limit Inputs -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="serial_from">From Serial</label>
                <input type="number" class="form-control" name="serial_from" id="serial_from"
                    value="{{ old('serial_from', $serial_from ?? '') }}" placeholder="Enter From Serial" required>
            </div>
            <div class="col-md-3">
                <label for="serial_to">To Serial</label>
                <input type="number" class="form-control" name="serial_to" id="serial_to"
                    value="{{ old('serial_to', $serial_to ?? '') }}" placeholder="Enter To Serial" required>
            </div>
            <div class="col-md-3">
                <label for="limit">Limit</label>
                <input type="number" class="form-control" name="limit" id="limit"
                    value="{{ old('limit', $limit ?? 10) }}" placeholder="Enter Limit" min="1">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <!-- Print Multiple Ledger Button -->
                <button type="submit" class="btn btn-primary" id="print-ledger-btn">Print Multiple Ledger</button>
            </div>
        </div>

        <!-- Hidden Date Fields -->
        <input type="hidden" name="date_from" id="date_from" value="{{ $date_from }}">
        <input type="hidden" name="date_to" id="date_to" value="{{ $date_to }}">
    </form>


    <!-- Table for Data Display -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL#</th>
                <th><input type="checkbox" id="select-all" disabled /> <!-- Select All Checkbox --> </th>
                <th>Referral Name</th>
                <th>Referral Address</th>
                <th>Total Invoice Qty</th>
                <th>Total Test Qty</th>
                <th>Total Sales Amount</th>
                <th>Discount On Sales</th>
                <th>Payable Amount</th>
                <th>Collection Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Initialize totals for each column
                $total_invoice_qty = 0;
                $total_test_qty = 0;
                $total_sales = 0;
                $total_discount = 0;
                $total_net_sales = 0;
                $total_due = 0;
                $total_doctor_profit = 0;
            @endphp

            @foreach ($data as $row)
                <tr>
                    <!-- Individual Row Checkbox -->
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        <input type="checkbox" class="select-row" disabled checked data-id="{{ $row->referral_id }}" />
                    </td>
                    <td>
                        <a href="{{ route('marketing.investigation-wise-details', [
                            $row->referral_id,
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_from)->format('d-m-y'),
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_to)->format('d-m-y'),
                            $agent
                        ]) }}"
                            class="cursor-pointer" target="_blank" data-id="{{ $row->referral_id }}" id="referral_id"
                            title="Referral Doctor Details">
                            {{ $row->referral_name ?? 'total' }}
                        </a>
                    </td>
                    <td>{{ $row->referral_addr ?? '' }}</td>
                    <td class="text-center">{{ number_format($row->total_invoice_qty, 0) }}</td>
                    <td class="text-center">{{ number_format($row->total_test_qty, 0) }}</td>
                    <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_net_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_payment, 2) }}</td>
                </tr>

                @php
                    // Accumulate totals for footer
                    $total_invoice_qty += $row->total_invoice_qty;
                    $total_test_qty += $row->total_test_qty;
                    $total_sales += $row->total_sales;
                    $total_discount += $row->total_discount;
                    $total_net_sales += $row->total_net_sales;
                    $total_due += $row->total_due;
                    $total_doctor_profit += $row->total_payment;
                @endphp
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                <td class="text-center">{{ number_format($total_test_qty, 0) }}</td>
                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                <td class="text-right">{{ number_format($total_net_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_doctor_profit, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    {{--
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL#</th>
                <th><input type="checkbox" id="select-all" disabled/> <!-- Select All Checkbox --> </th>
                <th>Referral Name</th>
                <th>Branch Name</th>
                <th>Total Invoice Qty</th>
                <th>Total Test Qty</th>
                <th>Total Sales Amount</th>
                <th>Discount On Sales</th>
                <th>Payable Amount</th>
                <th>Collection Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Initialize totals for each column
                $total_invoice_qty = 0;
                $total_test_qty = 0;
                $total_sales = 0;
                $total_discount = 0;
                $total_net_sales = 0;
                $total_due = 0;
                $total_doctor_profit = 0;
            @endphp

            @foreach ($data as $row)
                <tr>
                    <!-- Individual Row Checkbox -->
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">

                        <input type="checkbox" class="select-row" disabled checked data-id="{{ $row->referral_id }}" />
                    </td>
                    <td>
                        <a href="{{ route('marketing.investigation-wise-details', [
                            $row->referral_id,
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_from)->format('d-m-y'),
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_to)->format('d-m-y'),
                        ]) }}"
                            class="cursor-pointer" target="_blank" data-id="{{ $row->referral_id }}" id="referral_id"
                            title="Referral Doctor Details">
                            {{ $row->referral_name ?? 'total' }}
                        </a>
                    </td>
                    <td>{{ $row->branch_name ?? '' }}</td>
                    <td class="text-center">{{ number_format($row->total_invoice_qty, 0) }}</td>
                    <td class="text-center">{{ number_format($row->total_test_qty, 0) }}</td>
                    <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_discount, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_net_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_doctor_profit, 2) }}</td>
                </tr>

                @php
                    // Accumulate totals for footer
                    $total_invoice_qty += $row->total_invoice_qty;
                    $total_test_qty += $row->total_test_qty;
                    $total_sales += $row->total_sales;
                    $total_discount += $row->total_discount;
                    $total_net_sales += $row->total_net_sales;
                    $total_due += $row->total_due;
                    $total_doctor_profit += $row->total_doctor_profit;
                @endphp
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                <td class="text-center">{{ number_format($total_test_qty, 0) }}</td>
                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_discount, 2) }}</td>
                <td class="text-right">{{ number_format($total_net_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_doctor_profit, 2) }}</td>
            </tr>
        </tfoot>
    </table> --}}
@elseif ($type == 'referral_summary_2')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL#</th>
                <th><input type="checkbox" id="select-all" disabled /> <!-- Select All Checkbox --> </th>
                <th>Referral Name</th>
                <th>Referral Address</th>
                <th>Total Invoice Qty</th>
                <th>Total Sales Amount</th>
                <th>Payable Profit</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Initialize totals for each column
                $total_invoice_qty = 0;
                $total_test_qty = 0;
                $total_sales = 0;
                $total_discount = 0;
                $total_net_sales = 0;
                $total_due = 0;
                $total_doctor_profit = 0;
            @endphp

            @foreach ($data as $row)
                <tr>
                    <!-- Individual Row Checkbox -->
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        <input type="checkbox" class="select-row" disabled checked
                            data-id="{{ $row->referral_id }}" />
                    </td>
                    <td>
                        <a href="{{ route('marketing.investigation-wise-details', [
                            $row->referral_id,
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_from)->format('d-m-y'),
                            \Carbon\Carbon::createFromFormat('d/m/Y', $date_to)->format('d-m-y'),
                            $agent
                        ]) }}"
                            class="cursor-pointer" target="_blank" data-id="{{ $row->referral_id }}"
                            id="referral_id" title="Referral Doctor Details">
                            {{ $row->referral_name ?? 'total' }}
                        </a>
                    </td>
                    <td>{{ $row->referral_addr ?? '' }}</td>
                    <td class="text-center">{{ number_format($row->total_invoice_qty, 0) }}</td>
                    <td class="text-right">{{ number_format($row->total_sales, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_payable_profit, 2) }}</td>
                </tr>

                @php
                    // Accumulate totals for footer
                    $total_invoice_qty += $row->total_invoice_qty;
                    $total_sales += $row->total_sales;
                    $total_doctor_profit += $row->total_payable_profit;
                @endphp
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4"><strong>Total</strong></td>
                <td class="text-center">{{ number_format($total_invoice_qty, 0) }}</td>
                <td class="text-right">{{ number_format($total_sales, 2) }}</td>
                <td class="text-right">{{ number_format($total_doctor_profit, 2) }}</td>
            </tr>
        </tfoot>
    </table>




@endif
<script>
    $(document).ready(function() {
        // Handle "Select All" checkbox change
        $('#select-all').on('change', function() {
            var isChecked = $(this).prop('checked'); // Get the state of "Select All"
            // Set all individual checkboxes to the same state as "Select All"
            $('.select-row').prop('checked', isChecked);

            // Optionally, send AJAX request to update the server with selected referral IDs
            var selectedReferralIds = [];
            var allReferralIds = [];
            $('.select-row').each(function() {
                allReferralIds.push($(this).data('id'));
                if ($(this).prop('checked')) {
                    selectedReferralIds.push($(this).data('id'));
                }
            });

            // Trigger the AJAX request for the selected referrals
            updateReferralStatus(allReferralIds, selectedReferralIds);
        });

        // Handle individual checkbox change
        $('.select-row').on('change', function() {
            // If all individual checkboxes are selected, check the "Select All" checkbox
            if ($('.select-row:checked').length === $('.select-row').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }

            var selectedReferralIds = [];
            var allReferralIds = [];
            $('.select-row').each(function() {
                allReferralIds.push($(this).data('id'));
                if ($(this).prop('checked')) {
                    selectedReferralIds.push($(this).data('id'));
                }
            });

            updateReferralStatus(allReferralIds, selectedReferralIds);
        });

        // Function to update referral status on the server
        function updateReferralStatus(allReferralIds, selectedReferralIds) {
            $.ajax({
                url: "{{ route('update.referral.checkbox') }}", // Define the correct route
                method: 'POST',
                data: {
                    referral_ids: allReferralIds, // List of all referral IDs
                    selected_referral_ids: selectedReferralIds, // List of selected referral IDs
                    _token: "{{ csrf_token() }}", // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Selection updated on the server!');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating selection: ' + error);
                }
            });
        }
    });
</script>
