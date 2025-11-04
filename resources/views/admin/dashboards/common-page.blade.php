@php
    $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/h360_logo.png';
    $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';

    $company_name_text_size = isset($company_details->company_name_text_size) ? $company_details->company_name_text_size : '30px';
    $company_slogan_text_size = isset($company_details->company_slogan_text_size) ? $company_details->company_slogan_text_size : '18px';
    $company_address_text_size = isset($company_details->company_address_text_size) ? $company_details->company_address_text_size : '14px';
    $landing_background = isset($company_details->landing_img) ? '/images/uploads/hospital_images/' . $company_details->landing_img : 'images/landing_page_default_image_final.jpg';
    $border_color = isset($company_details->border_colur) ? $company_details->border_colur : '#0abde3';
  
@endphp
@if (Session::get('user.ses_hospital_code') == 'UNICO')
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    @endif

<section id="full_common_page"
    style="background:url({{ asset($landing_background) }}); background-repeat: no-repeat; background-position:right center; background-size: cover; ">

    <div class="common_text text-center" style="border-color: {{ $border_color }}">
        {{-- <span class="software_name"></span> --}}

        <img src="{{ asset($imageURL) }}" alt="" class="img-fluid" style="background-color: {{ $backgroundColor }}"
            width="{{ $company_details->width_landing }}">

        @if (Session::get('user.ses_hospital_code') != 'UNICO')
        <p class="software_title" style="font-size: {{ $company_name_text_size }}">{{ $company_details->hospital_name }}
        </p>
        <h1 class="software_category" style="font-size: {{ $company_slogan_text_size }}">
            {{ $company_details->hospital_slogan }}</h1>
        @endif
        <p class="software_subtitle" style="font-size: {{ $company_address_text_size }}">
            {{ $company_details->addrress1 }}</p>
    </div>
    @if (Session::get('user.ses_hospital_code') == 'UNICO')
        <div class="modal fade bd-example-modal-lg" id="service_modal" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-0">
                        <div class="hospital__window__popup">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner__box">
                                            <h2>Hospital</h2>
                                            <div class="inputGroup">
                                                <input id="radio1" name="radio" type="radio" checked value="{{ $company_details->hospital_no_pk}}" />
                                                <label for="radio1">{{ $company_details->hospital_name}}</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner__box">
                                            <h2>Store/Service Point</h2>
                                            @if (!empty($stores))
                                            @foreach ($stores as $row)
                                            <div class="inputGroup">
                                                <input id="radio3" name="radioOne" type="radio" value="{{ $row->serviceunit_no_pk }}"/>
                                                <label for="radio3"> {{ $row->serviceunit_name }}</label>
                                            </div>
                                            @endforeach
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="p-2 text-right">
                                            <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</section>

<script>
    // $(document).ready(function() {
    //     $("#service_modal").modal('show');
    // });

</script>
