@if (!empty($discard_data))
    @foreach ($discard_data as $data)
        <tr>
            <td class="text-left">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->discard_no_pk }}</td>
            <td class="text-left">{{ $data->discard_uid }}</td>
            <td class="text-left">{{ $data->item_name }}</td>
            <td class="text-left">
                {{ date('d/m/Y', strtotime($data->discard_date)) }}</td>
            {{-- <td class="text-left"></td> --}}
            <td class="text-left">{{ $data->ast_register_uid }}</td>
            <td class="text-left">{{ $data->asset_tag_uid }}</td>
            <td class="text-left">{{ $data->item_no_fk }}</td>
            <td class="text-left"></td>
            <td class="text-left">{{ $data->discard_reasons }}</td>
            <td class="text-left">{{ $data->sales_to_text }}</td>
            <td class="text-left">{{ $data->sales_price }}</td>
            <td class="text-left">{{ $data->sales_qty }}</td>
            <td class="text-left">
                {{ $data->sales_price * $data->sales_qty }}</td>
            <td class="text-left">{{ $data->discard_final_remarks }}
            </td>

            <td class="text-center">
                @if (isset($data->discarded_item_pic))
                    <a href="{{ asset('images/uploads/discardImages/' . $data->discarded_item_pic) }}"
                        target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                @endif
            </td>
            <td class="text-center">
                @if (isset($data->discard_auth_letter_pic))
                    <a href="{{ asset('images/uploads/discardImages/' . $data->discard_auth_letter_pic) }}"
                        target="_blank"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                @endif
            </td>
            <td>
                <a href="{{ isset($data->discard_no_pk) ? route('v1.fix-asset-discard-print', $data->discard_no_pk) : '' }}"
                    target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
            </td>
        </tr>
    @endforeach
@endif
