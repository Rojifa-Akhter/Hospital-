
<label for="lookup_data" class="col-sm-12 col-form-label col-form-label-sm">Lookup Data<span class="text-danger">*</span></label>
<div class="col-sm-12">
    <select class="form-control font_size_12 m-auto" id="lookup_data" name="lookup_data" required>
        <option selected="selected" value="">Select Lookup Data</option>

        @if(!empty($presLookupData))
        @foreach($presLookupData as $data)
        <option value="{{$data->pres_lookupdata_no_pk}}"  {{$data->pres_lookupdata_no_pk == $lookupDataId? 'selected': ''}}>{{$data->pres_lookupdata_name}}</option>
        @endforeach
        @endif
    </select>
</div>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(function() {

        $('.select2').select2();
    });
</script>
