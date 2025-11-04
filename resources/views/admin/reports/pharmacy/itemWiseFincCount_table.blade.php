<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-left" scope="col">Test Name</th>
                <th class="text-center" scope="col">Today Item Qty</th>
                <th scope="col" class="text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $today_current_item_qty = 0;
            @endphp
            @if (!empty($serviceUnitData))
                @foreach ($serviceUnitData as $key => $rows)
                    @php
                        $dept_exp = explode('_', $key);
                        $dept = '';
                        if (!empty($dept_exp)) {
                            $dept = $dept_exp[1];
                        }
                        $dep_current_item_qty = 0;
                    @endphp
                    <tr>
                        <td class="text-left" colspan="8"> <strong> {{ $dept }} </strong></td>
                    </tr>
                    @foreach ($rows as $row)
                        <tr>
                            <td class="text-center ">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $row->item_name }} </td>
                            <td class="text-center">{{ $row->item_qty }} </td>
                            <td scope="col" class="text-right "><span
                                    class="btn btn-sm btn-success open-modal btnView"
                                    data-action="{{ route('item-wise-financial-count-item-dtl', [$form_date, $to_date, $row->item_no_fk]) }}"
                                    data-modal="common-modal-md" data-title="Item Details" title="View Invoice Details"
                                    data-id="{{ $row->item_no_fk }}"><i class="fa fa-eye"></i></span></td>
                        </tr>

                        @php
                            $dep_current_item_qty += $row->item_qty;
                        @endphp
                    @endforeach
                    <tr>
                        <td class="text-right" scope="col" colspan="2"> <strong> Department Total = </strong>
                        </td>
                        <td scope="col" class="text-center bg-light-blue">{{ $dep_current_item_qty }}</td>

                    </tr>
                    @php
                        $today_current_item_qty += $dep_current_item_qty;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td class="text-center" scope="col" colspan="8">No Data Available</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" scope="col" colspan="2"> <strong> Total = </strong></td>
                <td scope="col" class="text-center bg-light-blue">{{ $today_current_item_qty }}</td>
            </tr>
        </tfoot>
    </table>
</div>
