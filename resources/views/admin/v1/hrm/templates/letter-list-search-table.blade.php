@if (!empty($data))
    @foreach ($data as $letterData)
        <tr>
            <td class="text-left">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $letterData->lettertemp_name }}</td>
            <td class="text-left">{{ $letterData->lettertemp_type }}</td>
            <td class="text-left">{{ $letterData->lettertemp_desc }}</td>

            @if ($letterData->apply_for_letter_ind == 1)
                <td class="text-center"><i class="fas fa-check"></i></td>
            @else
                <td class="text-center"></td>
            @endif

            @if ($letterData->apply_for_email_ind == 1)
                <td class="text-center"><i class="fas fa-check"></i></td>
            @else
                <td class="text-center"></td>
            @endif

            @if ($letterData->apply_for_sms_ind == 1)
                <td class="text-center"><i class="fas fa-check"></i></td>
            @else
                <td class="text-center"></td>
            @endif

            @if ($letterData->status == 1)
                <td class="text-center"><i class="fas fa-check"></i></td>
            @else
                <td class="text-center"></td>
            @endif

            <td class="text-left"></td>
        </tr>
    @endforeach
@endif
