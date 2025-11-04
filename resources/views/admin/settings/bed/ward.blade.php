<?php
$bed = (isset($bed)&& (!empty($bed))) ? $bed:[];
$ward_no_fk = ($bed) ? $bed->ward_no_fk : '';
?>
<div class="">
    <select class="form-control font_size_12 m-auto select2" id="ward_no_fk" name="ward_no_fk">
        <option selected="selected" value="">select ward</option>
       @if(!empty($ward))
            @foreach ($ward as $record)
                <option value="{{ $record->ward_no_pk }}" {{$record->ward_no_pk == $ward_no_fk ? 'selected' : ''}}>{{ $record->ward_name }}</option>
            @endforeach
        @endif
    </select>
</div>
