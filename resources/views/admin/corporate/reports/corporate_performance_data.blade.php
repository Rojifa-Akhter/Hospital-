<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
                {{-- <th class="text-center" scope="col" style="width:62px;">Date</th> --}}
                <th class="text-center" scope="col">Employee Name</th>
                <th class="text-center" scope="col">Corporate Code</th>
                <th class="text-center" scope="col">Corporate Name</th>
                <th class="text-center" scope="col">OPD Consultation</th>
                <th class="text-center" scope="col">IPD Admission</th>
                <th class="text-center" scope="col">OT Execution</th>
                <th class="text-center" scope="col">Procedure</th>
                <th class="text-center" scope="col">Total Investigation</th>
                <th class="text-center" scope="col">Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_consultation = $total_ipd_service = $total_ot_excution = $total_predure = $total_investigation = 0;
            @endphp
            @if (!empty($data))
                @foreach ($data as $key => $row)
                    <tr>
                        <td class="text-left global-uhl-table-bg">{{ $loop->iteration }}</td>
                        <td class="text-left global-uhl-table-bg">
                            {{ !empty($row->signatory_name) ? $row->signatory_name : '' }}</td>
                        <td class="text-left global-uhl-table-bg">
                            {{ !empty($row->ccm_client_code) ? $row->ccm_client_code : '' }}</td>
                        <td class="text-left global-uhl-table-bg">
                            {{ !empty($row->ccm_client_name) ? $row->ccm_client_name : '' }}</td>
                        <td class="text-center global-uhl-table-bg">
                            {{ !empty($row->consultation) ? $row->consultation : 0 }}</td>
                        <td class="text-center global-uhl-table-bg">
                            {{ !empty($row->ipd_service) ? $row->ipd_service : 0 }}
                        </td>
                        <td class="text-center global-uhl-table-bg">
                            {{ !empty($row->ot_excution) ? $row->ot_excution : 0 }}
                        </td>
                        <td class="text-center global-uhl-table-bg">{{ !empty($row->predure) ? $row->predure : 0 }}</td>
                        <td class="text-center global-uhl-table-bg">
                            {{ !empty($row->investigation) ? $row->investigation : 0 }}</td>
                        <td></td>

                        <div style="display: none">{{ $total_consultation += $row->consultation }}</div>
                        <div style="display: none">{{ $total_ipd_service += $row->ipd_service }}</div>
                        <div style="display: none">{{ $total_ot_excution += $row->ot_excution }}</div>
                        <div style="display: none">{{ $total_predure += $row->predure }}</div>
                        <div style="display: none">{{ $total_investigation += $row->investigation }}</div>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="15">No Data Available</th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" scope="col" colspan="4">Total = </th>
                <th scope="col" class="text-center global-uhl-table-bg">
                    {{ $total_consultation }}
                </th>
                <th scope="col" class="text-center global-uhl-table-bg">
                    {{ $total_ipd_service }}
                </th>
                <th scope="col" class="text-center global-uhl-table-bg">
                    {{ $total_ot_excution }}
                </th>
                <th scope="col" class="text-center global-uhl-table-bg">
                    {{ $total_predure }}
                </th>
                <th scope="col" class="text-center global-uhl-table-bg">
                    {{ $total_investigation }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
