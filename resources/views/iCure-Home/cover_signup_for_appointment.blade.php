@extends('iCure-Home.includes.cover_master')
@section('cover_content')
    <!-- preloader Start -->
    <div class="preloader-wrap">
        <div class="preloader">
            <img src="{{ asset('coverpage/img/loader.gif') }}" alt="">
        </div>
    </div>
    <!-- preloader End -->


    <!-- Sign-in start -->
    <div class="signin">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="signin_img">
                        <img src="{{ asset('coverpage/img/signup.png') }}" alt="sign-up-page" />
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="signin_section">
                        <h3 class="signin_title">I'm here for you!</h3>
                    </div>

                    <form action="{{ route('cover.signup-store-for-appointment', $id) }}" method="post" id="signUp">
                        @csrf
                        <input type="hidden" name="id">
                        <div class="form">
                            <div class=" form-group">
                                <input type="text" placeholder="Full Name *" name="full_name"
                                    class="form-control sigin_field full_name" />
                                <span class="text-danger">@error('full_name') {{ $message }} @enderror</span>
                            </div>

                            <div class=" form-group">
                                <input type="text" placeholder="Phone Number *" maxlength="13" name="phone"
                                    class="form-control sigin_field number_only phone_number" required />
                                <span class="text-danger">@error('phone_number') {{ $message }} @enderror</span>
                            </div>

                            <div class="form-group text-center pt-3">
                                <button type="submit" class="btn btn-signin" onclick="matchPassword(this)">Sign Up</button>
                            </div>
                            <div class="text-center create_sign">
                                <h4>Already Have a Account ? <a
                                        href="{{ route('cover.sign-in-for-appointment', $id) }}">Sign
                                        In</a></h4>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- sign-in end -->

@endsection

@push('custom_js')
    <script>
        $(document).ready(function(thisElement) {
            $('body').on('change', '.user_type', function() {
                let user = $(this).val()
                if (user === "doc") {
                    $('.doctor_ex_part').removeClass('d-none');
                } else {
                    $('.doctor_ex_part').addClass('d-none');
                }
            })
        });

        function matchPassword(thisElement, responesUrl = '') {
            var pw1 = $('.password').val();
            var pw2 = $('.c_password').val();
            if (pw1 != pw2) {
                alert("Passwords did not match");
            }

            event.preventDefault();

            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    {{-- if (data == 'doc') { --}}
                    {{-- window.location = '{{ url("cover/otp-verify") }}'; --}}
                    {{-- } else { --}}
                    {{-- window.location = '{{ url("cover/otp-verify") }}'; --}}
                    {{-- } --}}
                    window.location = '{{ url('cover/otp-verify') }}';



                    $.unblockUI();

                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Went Wrong !',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    })
                    $.unblockUI();
                }
            });

            event.stopImmediatePropagation();
        }
    </script>
@endpush
