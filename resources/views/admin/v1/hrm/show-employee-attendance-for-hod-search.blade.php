
@if (!empty($data))
  @foreach ($data as $attn_data)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $attn_data->card_no }}</td>
            <td class="text-left">{{ $attn_data->full_name }}</td>
            <td class="text-center">{{ $attn_data->contact_number }}</td>
            <td class="text-left">{{ $attn_data->serviceunit_name }}</td>
            <td class="text-left">{{ $attn_data->duty_roster_type }}</td>
            <td class="text-center">{{ $attn_data->att_date ? date('d-m-Y', strtotime($attn_data->att_date)) : '' }}</td>
            <td class="text-center">{{ $attn_data->in_time ? date('H:i', strtotime($attn_data->in_time)) : '' }}</td>
            <td class="text-center">{{ $attn_data->out_time ? date('H:i', strtotime($attn_data->out_time)) : '' }}</td>
        </tr>
    @endforeach
@endif