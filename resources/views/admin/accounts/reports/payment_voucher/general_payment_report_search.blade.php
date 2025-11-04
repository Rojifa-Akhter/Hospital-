@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-light-blue">
            {{-- <th rowspan="2" class="text-center"> Date</th> --}}
            <th rowspan="2" class="text-center">Transaction Type</th>
            <th rowspan="2" class="text-center">Journal Code</th>
            <th rowspan="2" class="text-center">Memo/Description</th>
            <th rowspan="2" class="text-center">Account</th>
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
            @foreach ($report_data as $key => $dt)
                @php
                    $debit_sub = $credit_sub = 0;
                @endphp
                <tr>
                    <td colspan="6" style="text-align: left"><strong>{{ date('d/m/Y', strtotime($key)) }}</strong>
                    </td>
                </tr>
                @foreach ($dt as $value)
                    <tr>
                        {{-- <td class="text-left"><strong>{{ $value->journal_date }}</strong> </td> --}}
                        <td class="text-left">
                            {{ !empty($value->voucher_type_name) ? ucfirst($value->voucher_type_name) : 'N/A' }}</td>
                        <td class="text-center">


                            <a target="_blank" href="{{ route('account.payment-voucher-report-print', ['voucher_id' => $value->journal_code]) }}"
                                style=" text-decoration:none;">{{ $value->journal_code }}</a></td>

                        <td class="text-left">
                            {{ !empty($value->narration_text) ? $value->narration_text : 'N/A' }}</td>
                        <td class="text-left">
                            {{ !empty($value->trn_account_code) ? $value->trn_account_code : 'N/A' }}</td>

                        <td class="text-right">
                            <strong>{{ !empty($value->trn_dr_account_amount) ? number_format($value->trn_dr_account_amount, 2) : 0 }}</strong>
                        </td>
                        <td class="text-right">
                            <strong>{{ !empty($value->trn_cr_account_amount) ? number_format($value->trn_cr_account_amount, 2) : 0 }}</strong>
                        </td>
                        <div style="display: none"><strong>{{ $debit_sub += $value->trn_dr_account_amount }}</strong>
                        </div>
                        <div style="display: none"><strong>{{ $credit_sub += $value->trn_cr_account_amount }}</strong>
                        </div>

                    </tr>
                @endforeach
                <tr>
                    <th class="text-right" colspan="4">Total =</th>
                    <th class="text-right bg-light-blue">{{ number_format($debit_sub, 2) }}</th>
                    <th class="text-right bg-light-blue">{{ number_format($credit_sub, 2) }}</th>
                </tr>

                <div style="display: none">{{ $debit += $debit_sub }}</div>
                <div style="display: none">{{ $credit += $credit_sub }}</div>
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
