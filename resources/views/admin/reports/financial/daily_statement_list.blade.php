<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }
</style>
<table class="table data-table table-bordered ">
    <tr>
        <th style="text-align:center;" colspan="6">INDOOR PATIENT STATEMENT</th>
    </tr>
    <thead class="bg-primary">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Word/Cabin</td>
            <!-- <td class="text-left" scope="col"> Name</td>			 -->
            <td class="text-left" scope="col">Previous</td>
            <td class="text-left" scope="col">Admission</td>
            <td style="width:17%" class="text-left" scope="col">Discharge</td>
            <td style="width:8%" class="text-left" scope="col">Present</td>
        </tr>
    </thead>
    @if (isset($group_records))
        @php
            $prev_pat = 0;
            $admission_pat = 0;
            $discharge_pat = 0;
            $total_pat = 0;
        @endphp
        @foreach ($group_records as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data['word'] }}</td>
                <td>
                    {{ $data['previous_patient'] + $data['discharge'] }}
                    @php
                        $prev_pat += $data['previous_patient'] + $data['discharge'];
                    @endphp
                </td>
                <td>
                    {{ $data['admission'] }}
                    @php
                        $admission_pat += $data['admission'];
                    @endphp
                </td>
                <td>
                    {{ $data['discharge'] }}
                    @php
                        $discharge_pat += $data['discharge'];
                    @endphp
                </td>
                <td>
                    {{ abs($data['previous_patient'] + $data['admission']) }}
                    @php
                        $total_pat += abs($data['previous_patient'] + $data['admission']);
                    @endphp
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Grand Total: </td>
            <td>{{ $prev_pat }}</td>
            <td>{{ $admission_pat }}</td>
            <td>{{ $discharge_pat }}</td>
            <td>{{ $total_pat }}</td>
        </tr>
    @endif
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <th style="text-align:center;" colspan="6">OUTDOOR PATIENT STATEMENT</th>
    </tr>

    <thead class="bg-primary">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Department</td>
            <!-- <td class="text-left" scope="col"> Name</td>			 -->
            <td class="text-left" scope="col">New Patient</td>
            <td class="text-left" scope="col">Old Patient</td>
            <td style="width:17%" class="text-left" scope="col">Night Patient</td>
            <td style="width:8%" class="text-left" scope="col">Total Patient</td>
        </tr>
    </thead>
    @if (isset($opd_statement))
        @php
            $new_pat = 0;
            $old_pat = 0;
            $total_opd_pat = 0;
        @endphp
        @foreach ($opd_statement as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->department }}</td>
                <td>
                    {{ $data->new_patient }}
                    @php
                        $new_pat += $data->new_patient;
                    @endphp
                </td>
                <td>
                    {{ $data->old_patient }}
                    @php
                        $old_pat += $data->old_patient;
                    @endphp
                </td>
                <td>
                    {{ $data->night_patient }}
                    @php
                        //$discharge_pat += $data['discharge'];
                    @endphp
                </td>
                <td>
                    {{ abs($data->new_patient + $data->old_patient) }}
                    @php
                        $total_opd_pat += abs($data->new_patient + $data->old_patient);
                    @endphp
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Grand Total: </td>
            <td>{{ $new_pat }}</td>
            <td>{{ $old_pat }}</td>
            <td>{{ '0' }}</td>
            <td>{{ $total_opd_pat }}</td>
        </tr>
    @endif



    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <th style="text-align:center;" colspan="6">DAILY INCOME STATEMENT</th>
    </tr>

    <thead class="bg-primary">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-left" scope="col">Particulars</td>
            <!-- <td class="text-left" scope="col"> Name</td>			 -->
            <td class="text-left" scope="col">Head of Income</td>
            <td class="text-left" scope="col">Amount</td>
        </tr>
    </thead>
    @if (isset($daily_income_statement))
        @php
            $total_coll = 0;
            $sub_total = 0;
            $group_name = '';
            $g = 0;
            $c = 0;
            $t = 0;
        @endphp
        @foreach ($daily_group_income_statement as $data)
            <tr>
                <td colspan="2">{{ $data->item_type_head }}</td>
                <td colspan="2">
                    <table width="100%">
                        @foreach (collect($daily_income_statement)->where('item_type_head', $data->item_type_head) as $subdata)
                            <tr>
                                <td style="text-align: left;">{{ $subdata->serviceunit_name }}</td>
                                <td style="text-align: right;">{{ number_format($subdata->total_collection, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Sub Total: </th>
                            <th style="text-align: right;">{{ number_format(round($data->total_collection), 2) }}</th>
                        </tr>
                    </table>
                </td>
            </tr>
            @php
                $total_coll += $data->total_collection;
            @endphp
        @endforeach
        <tr>
            <th colspan="3" style="text-align: right">Grand Total: </th>
            <th style="text-align: right">{{ number_format(round($total_coll), 2) }}</th>
        </tr>
    @endif



    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>



    <tr>
        @if($hospital_info->hospital_code == 'JKMH')
        <td colspan="3">
            <table width="100%">
                <tr>
                    <th style="text-align:center;" colspan="4">Zakat / Others Fund</th>
                </tr>
                <tr>
                    <td>SL.</td>
                    <td>Particulars</td>
                    <td>Muslim</td>
                    <td>Non Muslim</td>
                </tr>

                @php
                    $z = 0;
                    $mus_pat = 0;
                    $non_pat = 0;
                    $total_opd_pat = 0;
                @endphp
                @if (!empty($zakat_fund_arr))
                    @foreach ($zakat_fund_arr as $key => $zt)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $key }}</td>
                            <td>{{ isset($zt['ISLAM']) ? $zt['ISLAM'] : '' }}</td>
                            <td>{{ isset($zt['OTHERS']) ? $zt['OTHERS'] : '' }}</td>
                            @php
                                $mus_pat = isset($zt['ISLAM']) ? $mus_pat + $zt['ISLAM'] : $mus_pat;
                                $non_pat = isset($zt['OTHERS']) ? $non_pat + $zt['OTHERS'] : $non_pat;
                            @endphp

                        </tr>
                    @endforeach
                @endif
                <tr>
                    <th colspan="3">Grand Total: </th>

                    <th>{{ number_format(round($mus_pat + $non_pat), 2) }}</th>
                </tr>
            </table>
        </td>
        @endif
        @if($hospital_info->hospital_code == 'JKMH')
            <td colspan="3">
        @else
            <td colspan="6">
        @endif
            <table width="100%">
                <tr>
                    <th style="text-align:center;" colspan="2">Bank Deposit</th>
                </tr>
                @if (isset($daily_income_statement))
                    @php
                        $total_coll = 0;
                        $sub_total = 0;
                        $group_name = '';
                        $g = 0;
                        $c = 0;
                        $t = 0;
                    @endphp
                    @foreach ($daily_group_income_statement as $data)
                        <tr>
                            <td>{{ $data->item_type_head }}</td>
                            <td style="text-align: right;">{{ number_format(round($data->total_collection), 2) }}</td>
                        </tr>
                        @php
                            $total_coll += $data->total_collection;
                        @endphp
                    @endforeach
                    <tr>
                        <th style="text-align: right">Grand Total: </th>
                        <th style="text-align: right;">{{ number_format(round($total_coll), 2) }}</th>
                    </tr>
                @endif
            </table>

        </td>
    </tr>

</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
