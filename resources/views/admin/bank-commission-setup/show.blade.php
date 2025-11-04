<style>
    .card-body-compact {
        padding: 0.75rem;
    }

    .fw-bold {
        font-weight: 600;
    }

    .fw-semibold {
        font-weight: 500;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .text-danger {
        color: #dc3545;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.75rem;
        color: #000;
    }

    .form-check-input {
        position: static;
        margin-top: 0;
        margin-left: 0;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
        vertical-align: middle;
    }

    input[type="checkbox"]:disabled {
        cursor: not-allowed;
    }

    #add-row-btn {
        border: 1px solid #000;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        background: none !important;
    }

    #save-btn {
        padding: 0.25rem 1rem !important;
    }

</style>

<div class="bg-white border-bottom shadow-sm px-3 py-2">
    <h5 class="mb-0 fw-bold">Bank Commission Setup</h5>
    <small class="text-muted"> {{ $account->account_name }} Setup</small>
</div>

<div class="container-fluid pb-4 pt-2">

    <div class="text-right">
        <a href="{{ route('admin.bank-commission-setup.index') }}" class="btn btn-md btn-secondary">Back</a>
    </div>

    <div class="card mt-2">
        <div class="card-body card-body-compact">

            <h6 class="card-title font-weight-bold">{{ $account->account_name }}</h6>
                
            <form action="{{ route('admin.bank-commission-setup.update') }}" method="post" id="commission-rate-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="account_key" value="{{ $account->account_no_pk }}">

                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0" id="commission-rates-table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center" style="width: 60px;">#</th>
                                <th scope="col">Payment Method <span class="text-danger">*</span></th>
                                <th scope="col" class="text-center" style="width: 160px;">Commission Rate <span class="text-danger">*</span></th>
                                <th scope="col" class="text-center" style="width: 60px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($commissionRates as $idx => $rate)
                                <tr>
                                    <td class="text-center align-middle row-number">{{ $loop->iteration }}</td>

                                    <td>
                                        <select
                                            name="payment_method_key[]"
                                            class="form-control form-control-sm payment-method-select"
                                            required
                                        >
                                            <option value="">Select Payment Method</option>
                                            @foreach ($paymentMethods as $key => $name)
                                                <option 
                                                    value="{{ $key }}" 
                                                    data-name="{{ $name }}"
                                                    {{ (isset($rate['payment_method_key']) && $rate['payment_method_key'] == $key) ? 'selected' : '' }}
                                                >
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input 
                                            type="hidden" 
                                            name="payment_method_name[]" 
                                            class="payment-method-name" 
                                            value="{{ isset($rate['payment_method_key']) ? ($paymentMethods[$rate['payment_method_key']] ?? '') : '' }}"
                                        >
                                    </td>

                                    <td class="text-center">
                                        <input
                                            type="number"
                                            name="commission_rate[]"
                                            value="{{ isset($rate['commission_rate']) ? (float) $rate['commission_rate'] : '' }}"
                                            class="form-control form-control-sm text-right"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            required
                                        >
                                    </td>

                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Delete" aria-label="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center align-middle row-number">1</td>
                                    <td>
                                        <select
                                            name="payment_method_key[]"
                                            class="form-control form-control-sm payment-method-select"
                                            required
                                        >
                                            <option value="">Select Payment Method</option>
                                            @foreach ($paymentMethods as $key => $name)
                                                <option value="{{ $key }}" data-name="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="payment_method_name[]" class="payment-method-name">
                                    </td>
                                    <td class="text-center">
                                        <input
                                            type="number"
                                            name="commission_rate[]"
                                            class="form-control form-control-sm text-right"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            required
                                        >
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Delete" disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endempty
                        </tbody>
                    </table>
                </div>

                <template id="commission-rate-row-template">
                    <tr>
                        <td class="text-center align-middle row-number"></td>
                        <td>
                            <select
                                name="payment_method_key[]"
                                class="form-control form-control-sm payment-method-select"
                                required
                            >
                                <option value="">Select Payment Method</option>
                                @foreach ($paymentMethods as $key => $name)
                                    <option value="{{ $key }}" data-name="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="payment_method_name[]" class="payment-method-name">
                        </td>
                        <td class="text-center">
                            <input
                                type="number"
                                name="commission_rate[]"
                                class="form-control form-control-sm text-right"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                required
                            >
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </template>

                <div class="text-center mt-3">
                    <button type="button" id="add-row-btn" class="btn btn-sm">
                        <i class="fa fa-plus"></i> Add Row
                    </button>
                </div>

                <div class="mt-4 text-right">
                    <button type="submit" class="btn btn-primary" id="save-btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {

        const tableBody = document.querySelector('#commission-rates-table tbody');
        const addRowBtn = document.getElementById('add-row-btn');
        const rowTpl = document.getElementById('commission-rate-row-template');

        function updateTableState() {
            // Update serial numbers
            tableBody.querySelectorAll('tr').forEach((row, idx) => {
                row.querySelector('.row-number').textContent = idx + 1;
            });

            // Disable trash buttons if only one row
            const removeButtons = tableBody.querySelectorAll('.remove-row');
            removeButtons.forEach(btn => {
                btn.disabled = tableBody.rows.length === 1;
            });
        }

        function addRow() {
            const tableRow = rowTpl.content.firstElementChild.cloneNode(true);

            tableBody.appendChild(tableRow);

            const newRow = tableBody.querySelector('tr:last-child');

            updateTableState();
        }

        addRowBtn.addEventListener('click', addRow);

        tableBody.addEventListener('click', function (e) {
            const btn = e.target.closest('.remove-row');
            if (!btn || btn.disabled) return;

            if (tableBody.rows.length > 1) {
                const row = btn.closest('tr');

                row.remove();
                updateTableState();
            }
        });

        tableBody.addEventListener('change', function (e) {
            const selectElement = e.target.closest('.payment-method-select');
            if (!selectElement) return;

            const selectedValue = selectElement.value;
            if (!selectedValue) {
                const row = selectElement.closest('tr');
                const paymentMethodNameInput = row.querySelector('.payment-method-name');
                paymentMethodNameInput.value = '';
                return;
            }

            const allSelects = tableBody.querySelectorAll('.payment-method-select');
            let duplicateFound = false;
            
            allSelects.forEach(select => {
                if (select !== selectElement && select.value === selectedValue) {
                    duplicateFound = true;
                }
            });

            if (duplicateFound) {
                alert('This payment method is already selected in another row. Please select a different payment method.');
                selectElement.value = ''; 
                const row = selectElement.closest('tr');
                const paymentMethodNameInput = row.querySelector('.payment-method-name');
                paymentMethodNameInput.value = '';
                return;
            }

            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const paymentMethodName = selectedOption.getAttribute('data-name') || '';
            
            const row = selectElement.closest('tr');
            const paymentMethodNameInput = row.querySelector('.payment-method-name');
            
            paymentMethodNameInput.value = paymentMethodName;
        });

        $('#commission-rate-form').on('submit', function (e) {
            e.preventDefault();

            const form = this;
            const button = $('#save-btn');

            button.prop('disabled', true).text('Processing...');

            const formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response, textStatus, jqXHR) {

                    alert(response.message || 'Created successfully.');

                    location.reload();
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422 && xhr.responseJSON?.errors) {
                        console.error('Validation Error:', xhr.responseJSON);
                        const messages = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        alert('Please check your input:\n\n' + messages);
                    } 
                    else {
                        console.error('Server Error:', xhr.responseJSON?.message || xhr.statusText);
                        alert('Something went wrong. Please try again.');
                    }
                },
                complete: function () {
                    button.prop('disabled', false).text('Save');
                },
            });
        });

    })();
</script>