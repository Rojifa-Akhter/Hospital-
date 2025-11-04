
<label for="doctor" class="col-sm-12 col-form-label col-form-label-sm">Doctor<span class="text-danger">*</span></label>
<div class="col-sm-12">
    <select class="form-control font_size_12 m-auto" id="doctorId" name="doctor" required>
        <option selected="selected" value="">Select Doctor</option>

        @if(!empty($doctor))
        @foreach($doctor as $record)
        <option value="{{$record->person_no_pk}}" {{$record->person_no_pk == $personNoFk? 'selected': ''}}>{{ucfirst(strtolower($record->full_name))}}</option>
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
