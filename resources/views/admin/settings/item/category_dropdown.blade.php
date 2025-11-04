<option value="">Select One</option>
@if (isset($sub_cate ))
    @foreach ($sub_cate as  $val)
        <option value="{{ $val->lookupdata_no_pk }}" >
            {{ $val->lookupdata_name }}</option>
    @endforeach
@endif
