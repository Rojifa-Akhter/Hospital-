<table class="table data-table table-striped table-bordered table-hover" id="corporate_list">
    <thead class="bg-light-blue">
        @if ($type == 'DETAILS')
            <tr>
                <th class="text-left table-td" scope="col">Sl</th>
                <th class="text-left table-td" scope="col"> Invoice Info</th>
                <th class="text-left table-td" scope="col">Corporate Name</th>
                <th class="text-left table-td" scope="col">Patient Info</th>
                <th class="text-right table-td" style="text-align:right;" scope="col">Sales</th>
                <th class="text-right table-td" style="text-align:right;" scope="col">Collection
                </th>
                <th class="text-right table-td" style="text-align:right; width:50px" scope="col">Due</th>
            </tr>
        @elseif ('SUMMARY')
            <tr>
                <th class="text-center" scope="col">Sl</th>
                <th class="text-center" scope="col">Date</th>
                <th class="text-left" scope="col">Corporate ID</th>
                <th class="text-left" scope="col">Name</th>
                <th class="text-left" scope="col">Patient Count</th>
                <th class="text-right" scope="col">Sales</th>
                <th class="text-right" scope="col">Collection</th>
                <th class="text-right" scope="col">Due</th>
            </tr>
        @endif
    </thead>
    <tbody>
        @php
            $total_sales = $total_collection = $total_due = 0;
            $counter = 0;
        @endphp
        @if (!empty($report_data))
            @foreach ($report_data as $key => $row)
                @if ($type == 'DETAILS')
                    @if ($row->net_sales < 1)
                        @if ($row->collection < 1)
                            {{-- <tr> --}}
                            {{-- <td class="text-left">{{ $loop->iteration }}</td>

                    <td class="text-left">{{ !empty($row->invoice_code) ? $row->invoice_code : '' }}</td>
                    <td class="text-left">{{ date("d/m/y", strtotime($row->invoice_date)) }}</td>
                    <td class="text-left">{{ !empty($row->patient_code) ? $row->patient_code : '' }}</td>
                    <td class="text-left">{{ !empty($row->patient_name) ? $row->patient_name : '' }}</td>
                    <td class="text-left">{{ !empty($row->patient_name) ? $row->passport_no : '' }}</td>
                    <td class="text-left">{{ !empty($row->cc_depandant) ? $row->cc_depandant : '' }}</td>
                    <td class="text-left">{{ !empty($row->cc_relation) ? $row->cc_relation : '' }}</td>
                    <td class="text-right">
                        {{ !empty($row->sales) ? number_format($row->net_sales, 2, '.', '') : 0 }}
                    </td>
                    <td class="text-right">
                        {{ !empty($row->collection) ? number_format($row->collection, 2, '.', '') : 0 }}
                    </td>
                    <td class="text-right">{{ !empty($row->due) ? number_format($row->due, 2, '.', '') : 0 }}
                    </td> --}}
                            <?php $counter = $counter + 1; ?>
                            <tr>
                                <td style="text-align: center">{{ $counter }}</td>
                                <td class="text-left">Inv no. :
                                    {{ !empty($row->invoice_code) ? $row->invoice_code : '' }}
                                    <br>{{ date('d/m/y', strtotime($row->invoice_date)) }}
                                </td>
                                <td class="text-left">{{ !empty($row->ccm_client_code) ? $row->ccm_client_name : '' }}
                                </td>
                                <td class="text-left">
                                    {{ !empty($row->patient_code) ? $row->patient_code : '' }}<br>
                                    {{ !empty($row->patient_name) ? $row->patient_name : '' }}<br>
                                    Age :{{ !empty($row->age) ? $row->age : '' }}<br>
                                    Ph : {{ !empty($row->mobile1) ? $row->mobile1 : '' }}<br>
                                    Pass no.: {{ !empty($row->passport_no) ? $row->passport_no : '' }}
                                </td>
                                <td class="text-right" style="text-align:right;">
                                    {{ !empty($row->sales) ? number_format($row->net_sales, 2, '.', '') : 0 }}
                                </td>
                                <td class="text-right" style="text-align:right;">
                                    {{ !empty($row->collection) ? number_format($row->collection, 2, '.', '') : 0 }}
                                </td>
                                <td class="text-right" style="text-align:right;">
                                    {{ !empty($row->due) ? number_format($row->due, 2, '.', '') : 0 }}
                                </td>
                            </tr>
                            {{-- </tr> --}}
                            @php
                                $total_sales += $row->net_sales;
                                $total_collection += $row->collection;
                                $total_due += $row->due;
                            @endphp
                        @endif
                    @endif
                @elseif ($type == 'SUMMARY')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ date('d/m/y', strtotime($row->invoice_date)) }}</td>
                        <td class="text-left">{{ !empty($row->ccm_client_code) ? $row->ccm_client_code : '' }}</td>
                        <td class="text-left">{{ !empty($row->patient_name) ? $row->patient_name : '' }}</td>
                        <td class="text-left">{{ !empty($row->patient_count) ? $row->patient_count : '' }}</td>
                        <td class="text-right">
                            {{ !empty($row->sales) ? number_format($row->net_sales, 2, '.', '') : 0 }}
                        </td>
                        <td class="text-right">
                            {{ !empty($row->collection) ? number_format($row->collection, 2, '.', '') : 0 }}
                        </td>
                        <td class="text-right">{{ !empty($row->due) ? number_format($row->due, 2, '.', '') : 0 }}
                        </td>
                    </tr>
                    @php
                        $total_sales += $row->net_sales;
                        $total_collection += $row->collection;
                        $total_due += $row->due;
                    @endphp
                @endif
            @endforeach
        @else
            <tr>
                @if ($type == 'DETAILS')
                    <th class="text-center" scope="col" colspan="9">No Data Available</th>
                @elseif ($type == 'SUMMARY')
                    <th class="text-center" scope="col" colspan="8">No Data Available</th>
                @endif

            </tr>

        @endif
    </tbody>
    <tfoot>

        @if ($type == 'DETAILS')
            @php
                $colclass = 4;
            @endphp
        @elseif ($type == 'SUMMARY')
            @php
                $colclass = 5;
            @endphp
        @endif

        <tr>
            <th class="text-right" scope="col" colspan="{{ $colclass }}">Total = </th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_sales, 2, '.', '') }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_collection, 2, '.', '') }}
            </th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_due, 2, '.', '') }}</th>
        </tr>
    </tfoot>
</table>
