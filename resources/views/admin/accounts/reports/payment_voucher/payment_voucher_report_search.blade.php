@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            <th rowspan="2" class="text-center"> A/C Code</th>
            <th rowspan="2" class="text-center">Name of Account</th>
            <th rowspan="2" class="text-center">Cheque No.</th>
            <th rowspan="2" class="text-center">Sub Account/Cost Center</th>
            <th class="text-center" colspan="2">Amount</th>
        </tr>
        <tr class="thead-dark">
            <th class="text-center">Debit</th>
            <th class="text-center">Credit</th>
        </tr>
    </thead>
    <tbody>
        @php
            $debit = $credit = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $value)
                <tr>
                    <td class="text-left"><strong>
                            <a target="_blank" href="{{ route('account.payment-voucher-report-print', ['voucher_id' => $value->journal_code]) }}"
                                style=" text-decoration:none;">{{ $value->journal_code }}</a></strong> </td>
                    <td class="text-left">
                        {{ !empty($value->account_name) ? ucfirst($value->account_name) : 'N/A' }}</td>
                    <td class="text-center">
                        {{ !empty($value->bank_cheq_number) ? ucfirst($value->bank_cheq_number) : 'N/A' }}</td>

                    <td class="text-left">
                        {{ !empty($value->voucher_type_name) ? $value->voucher_type_name : 'N/A' }}</td>

                    <td class="text-right">
                        {{ !empty($value->trn_dr_account_amount) ? number_format($value->trn_dr_account_amount, 2) : '' }}
                    </td>
                    <td class="text-right">
                        {{ !empty($value->trn_cr_account_amount) ? number_format($value->trn_cr_account_amount, 2) : '' }}
                    </td>
                    <div style="display: none">{{ $debit += $value->trn_dr_account_amount }}</div>
                    <div style="display: none">{{ $credit += $value->trn_cr_account_amount }}</div>

                </tr>
            @endforeach
        @endif
    </tbody>

    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total =</th>
            <th class="text-right bg-light-blue">{{ number_format($debit, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($credit, 2) }}</th>
        </tr>
    </tfoot>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
