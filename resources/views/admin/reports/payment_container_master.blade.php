<div class="row">
    <div class="col-md-12">
        <h4 class="mb-3" style="border-bottom: 1px dotted rgb(179, 176, 176); padding-bottom: 5px;">
            Doctor Debit Notes Listing
        </h4>
        <table class="table table-striped table-bordered table-hover data-table">
            <thead class="thead-success">
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Payment Process No</th>
                    <th class="text-center">Payment Process Date</th>
                    <th class="text-center">Payment Date</th>
                    <th class="text-center">Voucher No</th>
                    <th class="text-center">Doctor Code</th>
                    <th class="text-left">Doctor Name</th>
                    <th class="text-right">Sales Amount</th>
                    <th class="text-right">Doctor Payable</th>
                    <th class="text-right">Debit Note Amount</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="doctorPaymentTable">
                @php
                    $totalSales = 0;
                    $totalDocPay = 0;
                @endphp

                @foreach ($doctorPayments as $data)
                    @php
                        $totalSales += $data->ledger_amt_sales;
                        $totalDocPay += $data->doc_amt_total;
                    @endphp
                    <tr>
                        {{-- Hidden primary key --}}
                        <td style="display:none;">
                            <input type="hidden" name="doctorpaymst_no_pk" value="{{ $data->doctorpaymst_no_pk }}">
                            <input type="hidden" name="doctor_person_no_fk" value="{{ $data->doctor_person_no_fk }}">
                        </td>

                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $data->doctorpaymst_no_pk }}</td>
                        <td class="text-center">{{ $data->payment_process_date }}</td>
                        <td class="text-center">{{ $data->payment_date }}</td>
                        <td class="text-center">
                        @if(!empty($data->voucher_no))
                            <a href="{{ route('journal_show') }}?journal_id={{ $data->voucher_no }}"
                            target="_blank"
                            title="Print Journal">
                            {{ $data->voucher_no }}
                            </a>
                        @else
                            -
                        @endif
                        </td>
                        <td class="text-center">{{ $data->doc_code }}</td>
                        <td class="text-left">{{ $data->doc_name }}</td>
                        <td class="text-right">{{ number_format($data->ledger_amt_sales, 2) }}</td>
                        <td class="text-right">{{ number_format($data->doc_amt_total, 2) }}</td>
                        <td class="text-right">{{ number_format($data->doc_debit_note_amt, 2) }}</td>
                        <td class="text-center">

                         {{-- Delete --}}
                            @if (is_null($data->voucher_no))
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-delete-payment"
                                        data-id="{{ $data->doctorpaymst_no_pk }}">
                                    Delete
                                </button>
                            @endif
                            {{-- Details --}}
                            <a target="_blank" href="{{ route('doctor-payment.details', ['id' => $data->doctorpaymst_no_pk]) }}" class="btn btn-sm btn-info">
                                Details
                            </a>
                            {{-- Pay --}}
                            <!-- <button type="button"
                                    class="btn btn-sm btn-success ml-1 open-modal"
                                    data-action="{{ route('partial-doctor-payment', ['id' => $data->doctorpaymst_no_pk]) }}"
                                    data-title="Doctor Payment ( {{ $data->doc_code }} - {{ $data->doc_name }} )">
                                Pay
                            </button> -->
                            {{-- Debit Note --}}
                            @if (is_null($data->voucher_no))
                            <button type="button"
                                    class="btn btn-sm btn-warning ml-1 btn-debit-note"
                                    data-doctorpaymst="{{ $data->doctorpaymst_no_pk }}"
                                    data-doctor="{{ $data->doctor_person_no_fk }}"
                                    data-doc_amt_total="{{ $data->doc_amt_total }}"
                                    data-debit_note_amt="{{ $data->doc_debit_note_amt }}">
                                Debit Note
                            </button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold bg-light">
                    <td colspan="6" class="text-right">Grand Total</td>
                    <td class="text-right">{{ number_format($totalSales, 2) }}</td>
                    <td class="text-right">{{ number_format($totalDocPay, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<!-- Shared Modal -->
<div class="modal fade" id="common-modal-sm" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commonModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="spinner-border" role="status"></div>
      </div>
    </div>
  </div>
</div>
<script>
   $(document).off('click', '.open-modal').on('click', '.open-modal', function () {
        const url = $(this).data('action');
        const title = $(this).data('title') || 'Modal';

        $('#commonModalLabel').text(title);
        $('#common-modal-sm').modal('show');
        $('#common-modal-sm .modal-body').html('<div class="spinner-border" role="status"></div>');

        $.ajax({
            url: url,
            method: 'GET',
            success: function (response) {
                $('#common-modal-sm .modal-body').html(response);

                // Init select2 safely
                if ($('.select2').length) {
                    $('.select2').select2({
                        placeholder: "--Select--",
                        allowClear: true,
                        width: '100%'
                    });
                }
            },
            error: function () {
                $('#common-modal-sm .modal-body').html('<div class="alert alert-danger">Failed to load content.</div>');
            }
        });
    });

    // Delete button with confirmation and AJAX
    $(document).on('click', '.btn-delete-payment', function (e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to delete this payment?')) return;

        const id = $(this).data('id');
        const $row = $(this).closest('tr');

        $.ajax({
            url: "{{ route('doctor-payment.delete', ['id' => 'dummy']) }}".replace('dummy', id),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function () {
                alert('Deleted successfully!');
                $row.remove();
            },
            error: function () {
                alert('Delete failed. Please try again.');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.btn-debit-note').on('click', function () {
            let doctorpaymst_no_pk = $(this).data('doctorpaymst');
            let doctor_person_no_fk = $(this).data('doctor');
            let doc_amt_total = $(this).data('doc_amt_total');
            let debit_note_amt = $(this).data('debit_note_amt');

            $.ajax({
                url: '{{ route('doctor-payment.debit-note') }}',
                type: 'POST',
                data: {
                    doctorpaymst_no_pk: doctorpaymst_no_pk,
                    doctor_person_no_fk: doctor_person_no_fk,
                    doc_amt_total: doc_amt_total,
                    debit_note_amt: debit_note_amt,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert('Debit Note processed successfully!');
                    location.reload();
                },
                error: function (xhr) {
                    alert('Something went wrong. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

