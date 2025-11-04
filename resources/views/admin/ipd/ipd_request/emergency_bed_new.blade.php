@php

    $ward_no_fk = $ipd_admission ? $ipd_admission->new_ward_no_fk : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<label class="col-form-label col-form-label-sm"
    for="destination_ward">{{ 'Bed Category'}} <span
        class="text-danger">*</span></label>
<select class="form-control form-control-sm select2" id="destination_ward" name="destination_ward"
    onchange="bedViewer.getBedByWard(this)" required>
    <option value="">Select One</option>
    @if (!empty($destinationWards))
        @foreach ($destinationWards as $dw)
            <option value="{{ $dw->ward_no_pk }}" {{ !empty($dw->ward_no_pk == $ward_no_fk) ? 'selected' : '' }} data-su_no="{{$dw->service_unit_no_fk}}">
                {{ $dw->ward_name }} <strong>({{ !empty($dw->bed_count) ? $dw->bed_count : 0 }})</strong></option>
        @endforeach
    @endif
</select>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
{{-- fix --}}
<script>
    $('.select2').select2();

    $("#destination_ward").on('change', function() {
        var bed_value = $('#destination_ward').val();
        var bed_data = $('#destination_ward').val();
        $.ajax({
            url: "{{ route('ipd.get-bed-by-ward-count') }}",
            type: 'POST',
            data: {
                bed_value: bed_value,
                bed_data: bed_data
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data)
                $(".all_bed_count").html(data[0]);
                $(".avalable_bed_count").html(data[1]);
                $(".occupied_bed_count").html(data[2]);
                $(".not-ready-label").html(data[3]);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    })
</script>
