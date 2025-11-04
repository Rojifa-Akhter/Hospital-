<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 10%;">Date</th>
            <th class="text-center" style="width: 10%;">Item Name</th>
            <th class="text-center" style="width: 10%;">Asset Tag</th>
            <th class="text-center" style="width: 10%;">Department</th>
            <th class="text-center" style="width: 15%;">Person Incharge</th>
            <th class="text-center" style="width: 15%;">User Department</th>
            <th class="text-center" style="width: 10%;">Value</th>
            <th class="text-center" style="width: 10%;">Building</th>
            <th class="text-center" style="width: 10%;">Floor</th>
            <th class="text-center" style="width: 10%;">Location</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        @if(!empty($items))
            @foreach($items as $item)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td style="text-align:center">{{ date('d-m-Y', strtotime($item->grn_date)) }}</td>
                    <td style="text-align:left">{{ $item->item_name }}</td>
                    <td style="text-align:left">
                        @php
                            // $head = $value->item_type_name != '' ? '/' . $value->item_type_name : '';
                            $head = $item->ity_group_header_code != '' ? '/' . $item->ity_group_header_code : '';
                            $department = $item->item_serviceunit_code != '' ? '/' . $item->item_serviceunit_code : '';
                        @endphp
                        {{ Session::get('user.ses_hospital_code') . $head . $department . '/' . $item->asset_tag_uid }}
                    </td>
                    <td style="text-align:left">{{ $item->item_serviceunit_name }}</td>
                    <td style="text-align:left">{{ $item->curr_user_incharge }}</td>
                    <td style="text-align:left">{{ $item->person_dept }}</td>
                    <td style="text-align:center">{{ $item->unit_value }}</td>
                    <td style="text-align:left">{{ $item->building_name }}</td>
                    <td style="text-align:left">{{ $item->floor_name }}</td>
                    <td style="text-align:left">{{ $item->curr_location_room_name }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                // { targets: [0, 5, 6, 7], className: 'text-center' },
                // { targets: [1, 2, 3, 4], className: 'text-left' }
            ],
            "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            "pageLength": 10
        });
        $('th').addClass('text-center');
    });
</script>
