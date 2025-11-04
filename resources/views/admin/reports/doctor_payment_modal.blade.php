<form id="doctor-payment-form" method="POST" action="{{ route('doctor-account-payment-entry') }}">
  @csrf

  {{-- Paid Tax --}}
  <div class="form-group">
    <label>Paid Amount Tax</label>
    <input type="number" class="form-control" name="paid_tax" step="0.01" value="{{ $payment->tax_amount }}" readonly>
  </div>

  {{-- Paid Vat --}}
  <div class="form-group">
    <label>Paid Amount Vat</label>
    <input type="number" class="form-control" name="paid_vat" step="0.01" value="{{ $payment->vat_amount }}" readonly>
  </div>

  {{-- Paid Amount --}}
  <div class="form-group">
    <label>Paid Amount</label>
    <input type="number" class="form-control" name="paid_amount" step="0.01" value="{{ $payment->acc_pay_amount }}" readonly>
  </div>

  {{-- General Ledger --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="general_ledger">General Ledger</label>
    </div>
    <div class="form-group col-sm-8">
      <select class="form-control form-control-sm select2" id="general_ledger" name="general_ledger">
        <option value="">--Select--</option>
        @foreach($chartof_accounts as $account)
          <option value="{{ $account->account_no_pk }}">{{ $account->account_name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Payment Type --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="payment_type">Payment Type</label>
    </div>
    <div class="form-group col-sm-8">
      <select class="form-control form-control-sm select2" id="payment_type" name="payment_type">
        <option value="">--Select--</option>
        @foreach($voucher_type as $account)
          <option value="{{ $account->voucher_type_name }}">{{ $account->voucher_type_name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Cheque No --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="cheque_no">Cheque No</label>
    </div>
    <div class="form-group col-sm-8">
      <select class="form-control form-control-sm select2" id="cheque_no" name="cheque_no">
        <option value="">-Select-</option>
        @foreach($verifiedChequeNos as $account)
          <option value="{{ $account->checque_no }}">{{ $account->checque_no }}</option>
        @endforeach
      </select>
    </div>
  </div>

  {{-- Cheque Date --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="cheque_date">Cheque Date</label>
    </div>
    <div class="form-group col-sm-8">
      <input type="date" class="form-control form-control-sm" id="cheque_date" name="cheque_date" />
    </div>
  </div>

  {{-- VAT --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="amount_vat">Amount VAT</label>
    </div>
    <div class="form-group col-sm-8">
      <input type="text" class="form-control form-control-sm" id="amount_vat" name="amount_vat" value="0"
        oninput="validatePayableAmount('vat')" />
    </div>
  </div>

  {{-- Tax --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="amount_tax">Amount Tax</label>
    </div>
    <div class="form-group col-sm-8">
      <input type="text" class="form-control form-control-sm" id="amount_tax" name="amount_tax" value="0"
        oninput="validatePayableAmount('tax')" />
    </div>
  </div>

  {{-- Payable Amount --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="paid_amount">Payable Amount</label>
    </div>
    <div class="form-group col-sm-8">
      <input type="text" class="form-control form-control-sm" id="paid_amount" name="paid_amount"
        value="{{ $payment->due }}" oninput="validatePayableAmount('paid')" readonly />
      <input type="hidden" name="grn_no" id="grn_no" value="{{ $payment->doctorpaymst_no_pk }}">
    </div>
  </div>

  {{-- Error Message --}}
  <div class="form-group">
    <small id="error-msg" style="display: none; color: red;"></small>
  </div>

  {{-- Remarks --}}
  <div class="form-row">
    <div class="form-group col-sm-4">
      <label for="remarks">Remarks</label>
    </div>
    <div class="form-group col-sm-8">
      <textarea class="form-control form-control-sm" id="remarks" name="remarks" placeholder="Remarks" rows="4" required></textarea>
    </div>
  </div>

  {{-- Submit Button --}}
  <button type="button" id="btn-submit-payment" class="btn btn-primary btn-block">Submit Payment</button>
</form>

{{-- Optional Overlay --}}
<div id="loading-overlay" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.3); z-index:9999;">
  <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:#fff;">
    Processing...
  </div>
</div>

{{-- JS --}}
<script>
  $(document).ready(function () {
    $('#paymentModal').modal('show');

    $('.select2').select2({
      placeholder: "--Select--",
      allowClear: true,
      width: '100%'
    });
  });

  function validatePayableAmount(triggeredBy = '') {
    const dueAmount = parseFloat("{{ $payment->due }}") || 0;
    const payableInput = document.getElementById('paid_amount');
    const taxInput = document.getElementById('amount_tax');
    const vatInput = document.getElementById('amount_vat');
    const errorMsg = document.getElementById('error-msg');

    const taxVal = parseFloat(taxInput.value) || 0;
    const vatVal = parseFloat(vatInput.value) || 0;
    let payableVal = parseFloat(payableInput.value) || 0;

    const maxPayable = dueAmount - taxVal - vatVal;

    if (triggeredBy === 'tax' || triggeredBy === 'vat') {
      payableInput.value = maxPayable >= 0 ? maxPayable.toFixed(2) : 0;
      errorMsg.style.display = 'none';
      return;
    }

    if (payableVal > maxPayable) {
      errorMsg.style.display = 'block';
      errorMsg.textContent = `Payable amount cannot exceed ${maxPayable.toFixed(2)} (Due - Tax - VAT)`;
      payableInput.value = maxPayable >= 0 ? maxPayable.toFixed(2) : 0;
    } else {
      errorMsg.style.display = 'none';
    }
  }

  $(document).on('click', '#btn-submit-payment', function (e) {
    e.preventDefault();

    let $btn = $(this);
    if ($btn.prop('disabled')) return;

  const paidAmount = parseFloat($('#paid_amount').val()) || 0;
  const remarks = $('#remarks').val().trim();

  // 🔒 Stop if remarks is empty and payment is being made
  if (paidAmount == 0) {
    $('#error-msg').text('Payment will be greater than Zero(0).').show();
    $('#remarks').focus();
    return; // ❌ Do not continue to payment
  } else {
    $('#error-msg').hide();
  }

  if (remarks === '') {
    $('#error-msg').text('Remarks are required when payment is made.').show();
    $('#remarks').focus();
    return; // ❌ Do not continue to payment
  } else {
    $('#error-msg').hide();
  }


    $btn.prop('disabled', true).text('Processing...');
    $('#loading-overlay').show();

    let form = $('#doctor-payment-form');
    let actionUrl = form.attr('action');
    let formData = form.serialize();

    $.ajax({
      url: actionUrl,
      type: 'POST',
      data: formData,
      success: function (response) {
        alert(response.msg || 'Payment submitted successfully!');
        $('#common-modal-sm').modal('hide');
      },
      error: function (xhr) {
        const response = xhr.responseJSON;
        alert((response && response.msg) || 'Failed to submit payment. Please try again.');
      },
      complete: function () {
        $('#loading-overlay').hide();
        $btn.prop('disabled', false).text('Submit Payment');
        window.location.reload();
      }
    });
  });
</script>
