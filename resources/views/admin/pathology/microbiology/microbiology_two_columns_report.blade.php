@php
$orgnsm_name_1 = isset($orgnsm_name_1) ? $orgnsm_name_1 : $organism_a;
$orgnsm_name_2 = isset($orgnsm_name_2) ? $orgnsm_name_2 : $organism_b;

@endphp

<table class="table table-hover table-striped border m-0">
    <thead>
        <tr class="border-0 bg-navy">
            <th class="p-0 px-1 border-0 w-12" rowspan="2">Antibiotic Name</th>
            <th class="p-0 px-1 border-0 w-12 text-center" colspan="2">Remark</th>
            <th class="p-0 px-1 border-0 text-center" rowspan="2">Show</th>
        </tr>
        <tr class="border-0 bg-navy">

            <th class="p-0 px-1 border-0 w-12">{{ $orgnsm_name_1 }}</th>
            <th class="p-0 px-1 border-0 w-12">{{ $orgnsm_name_2 }}</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($result_test_info))
            @foreach ($result_test_info as $row)
                <tr>
                    @php
                        $attr_id = '';
                        $result = 'R';
                        $result1 = 'R';

                    @endphp
                    @if (!empty($labt_testresultstruct))
                        @foreach ($labt_testresultstruct as $value)
                            @php
                                $attr_id = $value->teststruct_no_fk;
                            @endphp
                            @if ($value->teststruct_no_fk == $row->microbiology_no_pk)
                                @php
                                    $result = $value->result0;
                                    $result1 = $value->result1;
                                @endphp
                            @break
                        @endif
                    @endforeach
                @endif

                <td class="p-0 px-1 border-0">
                    {{ $row->microbiology_name }}
                    <input type="hidden" name="testresult_no_pk_{{ $row->microbiology_no_pk }}"
                        value="{{ $row->microbiology_no_pk }}">

                    <input type="hidden" name="testresult_value_{{ $row->microbiology_no_pk }}"
                        value="{{ $row->microbiology_name }}">
                </td>
                <td class="p-0 px-1 border-0">
                    <select class="form-control font_size_12 m-auto select2" id="result"
                        name="result_{{ $row->microbiology_no_pk }}_1">
                        <option value="">Select</option>
                        <option value="R" @if ($result == 'R') selected @endif>R
                            <strong>(Resistant)</strong>
                        </option>
                        <option value="S" @if ($result == 'S') selected @endif>S
                            @if ($hospital->hospital_code == 'GMC')
                                <strong>(Moderately Sensitive)</strong>
                            @else
                                <strong>(Sensitive)</strong>
                            @endif
                        </option>
                        <option value="I" @if ($result == 'I') selected @endif>I

                            @if ($hospital->hospital_code == 'GMC')
                                <strong>(Strongly Sensitive)</strong>
                            @else
                                <strong>(Intermediate)</strong>
                            @endif
                        </option>
                    </select>
                </td>
                <td class="p-0 px-1 border-0">
                    <select class="form-control font_size_12 m-auto select2" id="result"
                        name="result_{{ $row->microbiology_no_pk }}_2">
                        <option value="">Select</option>
                        <option value="R" @if ($result1 == 'R') selected @endif>R
                            <strong>(Resistant)</strong>
                        </option>
                        <option value="S" @if ($result1 == 'S') selected @endif>S
                            @if ($hospital->hospital_code == 'GMC')
                                <strong>(Moderately Sensitive)</strong>
                            @else
                                <strong>(Sensitive)</strong>
                            @endif
                        </option>
                        <option value="I" @if ($result1 == 'I') selected @endif>I

                            @if ($hospital->hospital_code == 'GMC')
                                <strong>(Strongly Sensitive)</strong>
                            @else
                                <strong>(Intermediate)</strong>
                            @endif
                        </option>
                    </select>
                </td>
                <td class="p-0 px-1 border-0 text-center bg-light">
                    <input class="show_in_rep" type="checkbox" id="show_in_rep" name="show_in_rep[]"
                        value="{{ $row->microbiology_no_pk }}" @if ($attr_id == $row->microbiology_no_pk) checked @endif>

                </td>
            </tr>
        @endforeach
    @else
        <tr class="border-0">
            <td colspan="3" class="text-center text-danger">No Data Found
            </td>
        </tr>
    @endif


</tbody>
</table>
