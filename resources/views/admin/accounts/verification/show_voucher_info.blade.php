<table class="table mb-0">
    <thead>
        <tr class="bg-primary">
            <th class="text-center w-5">SL</th>
            <th class="text-center w-10">Date</th>
            <th class="text-left w-10">Voucher No</th>
            <th class="text-left">Voucher Type</th>
            <th class="text-center w-10">Status</th>
            <th class="text-center w-10">Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($voucher_info->getData()->data as $voucher)
            @if ($i < 10)
                @php

                    $i = '0' . $i;
                @endphp
            @endif
            <tr>
                <td class="text-center">{{ $i }}</td>
                <td class="text-center">{{ date('Y-m-d', strtotime($voucher->journal_date)) }}</td>
                <td class="text-left">
                    {{-- <a target="_blank" href="{{ route('journal', ['journal_id' => $voucher->journal_code]) }}"
                        style=" text-decoration:none;">{{ $voucher->journal_code }}</a> --}}

                        <a target="_blank" href="{{ route('account.payment-voucher-report-print',$voucher->journal_code) }}"
                            style=" text-decoration:none;">{{ $voucher->journal_code }}</a>

                </td>
                <td class="text-left">{{ $voucher->voucher_type_name }}</td>
                <td class="text-center" width="20%">
                    <span style="cursor: pointer;"
                        class="badge @if ($voucher->verified_ind == 1) badge-success @else badge-danger @endif voucher_active_inactive"
                        data-voucher_type="{{ $voucher->voucher_type_no_fk }}"
                        data-voucher_date="{{ $voucher->journal_date }}" data-voucher_no="{{ $voucher->journal_code }}"
                        action-link="{{ route('set-active-inactive-voucher') }}"
                        @if ($voucher->verified_ind == 1) data-active="1" @else data-active="0" @endif>{{ $voucher->verified_ind == 1 ? 'VERIFIED' : 'NOT VERIFIED' }}</span>
                    <div class="voucher_loader_1 pl-3 text-success"
                        style="float:left; display:none; text-align:center; margin-bottom: 13px; font-weight:900;position:relative;z-index:999;">
                        <i class="fas fa-stroopwafel fa-spin"></i></div>
                </td>
                <td class="text-center">
                    <a href="{{ route('voucher') }}?voucher_id={{ $voucher->journal_code }}" target="__blank"
                        class="btn btn-sm btn-warning"><i class="fa fa-print"></i></a>
                    <a href="{{ route('view_voucher') }}?voucher_id={{ $voucher->journal_code }}" target="__blank"
                        class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                </td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </tbody>
</table>

<script type="text/javascript"></script>
