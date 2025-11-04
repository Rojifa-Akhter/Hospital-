@if (!empty($asset_receive_data_arr))
    @foreach ($asset_receive_data_arr as $value)
        <tr @if ($value->grn_qty == $value->tag_qty) style="background-color:#00FA9A" @endif>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $value->item_code }}</td>
            <td>{{ $value->grn_date != '' ? date('d/m/Y', strtotime($value->grn_date)) : '' }}</td>
            <td>{{ $value->store_name }}</td>
            <td>{{ $value->item_name }}</td>
            {{-- <td>{{ $value->assetcat_name }}</td>
    <td>{{ $value->taxcode_uid }}</td>
    <td>{{ $value->assetclass_name }}</td> --}}
            <td class="text-center">{{ $value->par_item_type_name }}</td>
            <td class="text-center">{{ $value->ity_group_header_name }}</td>
            <td class="text-center">{{ $value->grn_qty }}</td>
            <td class="text-center">{{ $value->tag_qty }}</td>
            <td>
                <!-- <button type="button" class="btn btn-success btn-md btn-md-global" data-toggle="modal" data-target="#exampleModal">Create Tag</button> -->

                <span class="btn btn-md btn-success btn-md-global open-modal btnView"
                    data-action="{{ route('v1.create_tag_popup', $value->itemreceivedtl_no_pk) }}"
                    data-modal="common-modal-sm" data-title="Create Tag" title="Create Tag"
                    data-id="{{ $value->itemreceivedtl_no_pk }}">Create Tag</span>
            </td>
        </tr>
    @endforeach
@endif
