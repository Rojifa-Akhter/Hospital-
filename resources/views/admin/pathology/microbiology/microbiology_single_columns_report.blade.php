<table class="table table-hover table-striped border m-0">
    <thead>
        <tr class="border-0 bg-navy">
            <th class="p-0 px-1 border-0 w-12">Antibiotic Name</th>
            <th class="p-0 px-1 border-0 text-center">Show</th>
            <th class="p-0 px-1 border-0 w-12">Remark</th>
        </tr>
    </thead>
    <tbody>

        @if (!empty($result_test_info))
            @foreach ($result_test_info as $row)
                <tr>
                    @php
                        $attr_id = '';
                        $result = 'R';
                    @endphp
                    @if (!empty($labt_testresultstruct))
                        @foreach ($labt_testresultstruct as $value)
                            @php
                                $attr_id = $value->teststruct_no_fk;
                            @endphp
                            @if ($value->teststruct_no_fk == $row->microbiology_no_pk)
                                @php
                                    $result = $value->result0;
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

                <td class="p-0 px-1 border-0 text-center bg-light">
                    <input class="show_in_rep" type="checkbox" id="show_in_rep" name="show_in_rep[]"
                        value="{{ $row->microbiology_no_pk }}" @if ($attr_id == $row->microbiology_no_pk) checked @endif>

                </td>
                <td class="p-0 px-1 border-0">
                    <select class="form-control font_size_12 m-auto select2" id="result"
                        name="result_{{ $row->microbiology_no_pk }}_1">

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
            </tr>
        @endforeach
    @else
        <tr class="border-0">
            <td colspan="3" class="text-center text-danger">No Data Found</td>
        </tr>
    @endif


</tbody>
</table>
