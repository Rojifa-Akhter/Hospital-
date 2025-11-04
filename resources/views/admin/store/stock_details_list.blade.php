            @php
                $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
                $grn_pdf = '';
                @endphp


@if (!empty($transactions))

    @php
        $stock_position = 0; // $opening_qty;
    @endphp
    {{-- @dd($transactions) --}}

    @foreach ($transactions as $trans)
        @php
            if (
                strtoupper($trans->trans_type_iss_rcv) == 'ISSUE' ||
                strtoupper($trans->trans_type_iss_rcv) == 'RCVRTN' ||
                strtoupper($trans->trans_type_iss_rcv) == 'DAMAGE' ||
                strtoupper($trans->trans_type_iss_rcv) == 'EXPIRED' ||
                strtoupper($trans->trans_type_iss_rcv) == 'TRANSOUT' ||
                strtoupper($trans->trans_type_iss_rcv) == 'ADJNEG' ||
                strtoupper($trans->trans_type_iss_rcv) == 'STKRTN'
            ) {
                $stock_position = floatval($stock_position) - floatval($trans->item_qty);
            }

            if (
                strtoupper($trans->trans_type_iss_rcv) == 'RECEIVE' ||
                strtoupper($trans->trans_type_iss_rcv) == 'OPEN' ||
                strtoupper($trans->trans_type_iss_rcv) == 'ISSRTN' ||
                strtoupper($trans->trans_type_iss_rcv) == 'TRANSIN' ||
                strtoupper($trans->trans_type_iss_rcv) == 'ADJPOS' ||
                strtoupper($trans->trans_type_iss_rcv) == 'RTNRCV'
            ) {
                $stock_position =
                    $stock_position <= 0
                        ? 0 + floatval($trans->item_qty)
                        : floatval($stock_position) + floatval($trans->item_qty);
            }

        @endphp
        <tr>

            @if (!empty($trans->transref_no) && strtoupper($trans->trans_type) == 'GRN')
                @php
                    $label = $hospital_code == 'KPJ' ? $trans->itemreceive_uid : $trans->transref_no;
                    $grn_pdf = '<a href="' . route('v2.grn-report-print', $trans->transref_no) . '" target="_blank" class="btn btn-warning btn-sm">' . $label . '</a>';
                @endphp
            @endif
            <td class="text-center">{{ $loop->iteration }}</td>
            {{-- <td class="text-center">{!! strtoupper($trans->trans_type) == "GRN" ? $grn_pdf : $trans->transref_no !!}</td> --}}
            <td class="text-center">{!! strtoupper($trans->trans_type) == 'GRN' && !empty($grn_pdf) ? $grn_pdf : $trans->transref_no !!}</td>
            <td class="text-left">{{ date('d/m/Y', strtotime($trans->trans_date)) }}</td>
            <td class="text-left">{{ date('h:m:s a', strtotime($trans->trans_date)) }}</td>
            <td class="text-left"> {{ $trans->batch_no }}
                {{ $trans->internal_batch_no_uq != '' ? '(' . $trans->internal_batch_no_uq . ')' : '' }} </td>
            <td class="text-right"><strong>
                @if (date('d/m/Y', strtotime($trans->expiry_date))  != '01/01/1970')
                ({{ date('d/m/Y', strtotime($trans->expiry_date)) }})
                @else
                N/A
                @endif
                </strong></td>
            <td class="text-left">
                {{ strtoupper($trans->trans_type_text_chd) }}
                {{ $trans->trans_type_text_chd != '' ? '(' . $trans->trans_type_text_chd . ')' : '' }}
            </td>

            <td class="text-right">

                @if ($trans->trans_type_iss_rcv != 'ISSUE')
                    {{ $trans->supplier_name }}
                @else
                    N/A
                @endif
            </td>
            <td class="text-right">{{ number_format($trans->cost_price, 2) }}</td>
            <td class="text-right">{{ $trans->item_qty }}</td>
            <td class="text-right">
                {{ $stock_position <= 0 ? 0 : number_format($stock_position, 2) }}

            </td>
        </tr>
    @endforeach

@endif
