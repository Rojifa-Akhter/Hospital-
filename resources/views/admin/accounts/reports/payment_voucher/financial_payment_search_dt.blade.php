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
            <th class="text-center">Income Head</th>
            <th class="text-center">Notes</th>
            <th class="text-center">TK</th>
            {{-- <th rowspan="2" class="text-center">TK</th> --}}
        </tr>
    </thead>
    <tbody>
        @php
                    $f_bottom_head = $f_dr_amt = $f_cr_amt = 0;
                @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $key => $data)


                @php
                    $t_bottom_head = $t_dr_amt = $t_cr_amt = 0;
                @endphp

                <tr class="bg-primary">
                    <td colspan="6" style="text-align: left"><strong>
                            @if ($key == 'CURRENT ASSET')
                                {{ 'ASSETS' }}
                            @elseif ($key == 'CURRENT LIABILITY')
                                {{ 'LIABILITIES' }}
                            @endif
                        </strong>
                    </td>
                </tr>
                @foreach ($data as $key1 => $dt)
                    <tr class="bg-info">
                        <td colspan="6" style="text-align: left"><strong>
                                {{ ucfirst($key1) }}
                            </strong>
                        </td>
                    </tr>
                    @php
                        $total_bottom_head = $total_dr_amt = $total_cr_amt = 0;
                    @endphp
                    @foreach ($dt as $value)
                        <tr>
                            {{-- <td class="text-left"><strong>{{ $value->journal_date }}</strong> </td> --}}
                            <td class="text-left">
                                {{ !empty($value->root_head_5) ? ucfirst($value->root_head_5) : 'N/A' }}</td>

                            <td class="text-center">
                                {{ !empty($value->bottom_head) ? $value->bottom_head : 0 }}</td>
                            <td class="text-right">
                                {{ !empty($value->amount) ? number_format($value->amount, 1) : '0.00' }}</td>
                            <td class="text-right">
                                {{-- {{ !empty($value->amount) ? number_format($value->amount, 1) : '0.00' }}</td> --}}
                                <div style="display: none">
                                    <strong>{{ $total_bottom_head += $value->bottom_head }}</strong>
                                </div>
                                <div style="display: none"><strong>{{ $total_dr_amt += $value->amount }}</strong>
                                </div>
                                {{-- <div style="display: none"><strong>{{ $total_cr_amt += $value->amount }}</strong>
                        </div> --}}

                        </tr>
                    @endforeach
                    <tr>
                        <th class="text-right">Total {{ ucfirst(strtolower($key)) }} =</th>
                        <th class="text-center bg-light-blue">{{ $total_bottom_head }}</th>
                        <th class="text-right bg-light-blue">{{ number_format($total_dr_amt, 2) }}</th>
                        {{-- <th class="text-right bg-light-blue">{{ number_format($total_cr_amt, 2) }}</th> --}}
                    </tr>
                    <div style="display: none">
                        <strong>{{ $t_bottom_head += $total_bottom_head }}</strong>
                    </div>
                    <div style="display: none"><strong>{{ $t_dr_amt += $total_dr_amt }}</strong>
                    </div>

                    {{-- <div style="display: none">{{ $debit += $debit_sub }}</div>
                <div style="display: none">{{ $credit += $credit_sub }}</div> --}}
                @endforeach
                <tr class="bg-warning">
                    <th class="text-right">Total @if ($key == 'CURRENT ASSET')
                            {{ 'ASSETS' }}
                        @elseif ($key == 'CURRENT LIABILITY')
                            {{ 'LIABILITIES' }}
                        @endif =</th>
                    <th class="text-center">{{ $t_bottom_head }}</th>
                    <th class="text-right">{{ number_format($t_dr_amt, 2) }}</th>
                    <div style="display: none"><strong>{{ $f_dr_amt += $total_dr_amt }}</strong>
                    </div>
                    {{-- <th class="text-right bg-light-blue">{{ number_format($total_cr_amt, 2) }}</th> --}}
                </tr>
            @endforeach

            @php
                $net_profit_loss = $f_dr_amt;
            @endphp
            @if ($net_profit_loss > 0)
                <tr>
                    <td style="padding-bottom: 5px; font-weight:bold;">Retained Earnings </td>
                    @php
                        $net_profit = $net_profit_loss;
                    @endphp
                    <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;">
                        {{ number_format(abs($net_profit_loss), 2) }}</td>
                </tr>
            @endif


            @if ($net_profit_loss < 0)
                <tr>
                    <td style="padding-bottom: 5px; font-weight:bold; text-align: left;">Retained Earnings </td>
                    @php
                        $net_profit = $net_profit_loss;
                    @endphp
                    <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;text-align: right; " colspan="2">
                        {{ '(' . number_format(abs($net_profit_loss), 2) . ')' }}</td>
                </tr>
            @endif
        @endif
    </tbody>
    {{--
    <tfoot>
        <tr>
            <th class="text-right" colspan="4">Total =</th>
            <th class="text-right bg-light-blue">{{ number_format($debit, 2) }}</th>
            <th class="text-right bg-light-blue">{{ number_format($credit, 2) }}</th>
        </tr>
    </tfoot> --}}
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
