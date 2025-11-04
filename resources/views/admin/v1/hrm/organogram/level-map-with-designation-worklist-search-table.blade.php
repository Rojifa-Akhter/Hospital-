@if (!empty($data_with_label))
    @foreach ($data_with_label as $label => $data)
        @php
            $lavel_exp = explode('_', $label);
        @endphp
        {{-- <thead> --}}
        <tr>
            <th colspan="3" class="text-left">
                <b>{{ $label != '' ? $lavel_exp[1] : '' }}</b>
            </th>
        </tr>
        {{-- </thead> --}}

        @foreach ($data as $value)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left"> {{ $value->designation_name }}</td>
                {{-- <td class="text-center">
																<button class="btn btn-success btn-sm"
																	onclick="Update({{ $value->organogramlvlmapdg_no_pk }})">
																	<i class="far fa-edit"></i>
																</button>
															</td> --}}
            </tr>
        @endforeach
    @endforeach
@endif
