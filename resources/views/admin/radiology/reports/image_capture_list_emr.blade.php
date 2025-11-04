@if ($image)
@foreach ($image as $value)

    <figure id="main_figure">
           {{-- <input type="hidden" class="image_id" name="image_id[]" value="{{$value->rad_report_imgno_pk}}"> --}}
        {{-- <span onclick="image_delete(this)" type="button" style="" data-id="{{$value->rad_report_imgno_pk}}" id="image_delete" class="text-danger" title="remove" data-action="{{ route('radiology.radiology-image-capture-delete') }}">×</span> --}}

        <a href="{{ asset('images/uploads/image_capture/' . $value->resultimg_path) }}" data-lightbox="roadtrip">
            <img src="{{ asset('images/uploads/image_capture/' . $value->resultimg_path) }}" alt=""
                style="width:150px; height:100px; margin-bottom:10px">

            </a>
    </figure>
@endforeach
@endif
