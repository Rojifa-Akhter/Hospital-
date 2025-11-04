@php
$doctor_id = Auth::user()->patient_no_fk ?? '';
$user_no_pk = Auth::user()->user_no_pk ?? '';
$doctor_mobile_num = Auth::user()->phone_mobile ?? '';

$otp_num = Auth::user()->last_otp_text;
$otp_array = str_split($otp_num, 1);

@endphp


<div class="signin">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="signin_img">
                    <img src="{{ asset('coverpage/img/signin.png') }}">
                </div>
            </div>
            <div class="col-md-5">
                <div class="signin_section">
                    <h3 class="signin_title">Enter the code that was sent to</h3>
                </div>

                <form action="{{ route('cover.verify-otp') }}" method="post" id="otpVerify">
                    @csrf
                    <input type="hidden" name="user_no_pk" value="{{ $user_no_pk }}">
                    <div class="results">
                        @if (\Illuminate\Support\Facades\Session::get('success'))
                            <div class="alert alert-success">
                                {{ \Illuminate\Support\Facades\Session::get('success') }}
                            </div>
                        @endif

                        @if (\Illuminate\Support\Facades\Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ \Illuminate\Support\Facades\Session::get('fail') }}
                            </div>
                        @endif
                    </div>
                    <div class="form">

                        <div class=" mt-3" form-group-sm>
                            <div style="background-color: #f5efef;padding: 10px;" class="text-center">

                                <p for="" style="color: #c70707;font-size:22px" class="text-center"
                                    id="verify_mobile_number">+88{{ $doctor_mobile_num }}
                                </p>
                                <input id="" type="text" style="   width: 50px;
                                    height: 50px !important;
                                    padding: 5px !important;
                                    border-radius: 5px !important;
                                    font-size: 22px;
                                    text-align: center;
                                    display: inline-block;
                                    margin: 0px 5px;" maxlength="1"
                                    class="otp_field form-control form-control-sm font_poppins inputs" value=""
                                    name="otp_0">
                                <input id="" type="text" style="   width: 50px;
                                    height: 50px !important;
                                    padding: 5px !important;
                                    border-radius: 5px !important;
                                    font-size: 22px;
                                    text-align: center;
                                    display: inline-block;
                                    margin: 0px 5px;" maxlength="1"
                                    class="otp_field form-control form-control-sm font_poppins inputs" value=""
                                    name="otp_1">
                                <input id="" type="text" style="   width: 50px;
                                    height: 50px !important;
                                    padding: 5px !important;
                                    border-radius: 5px !important;
                                    font-size: 22px;
                                    text-align: center;
                                    display: inline-block;
                                    margin: 0px 5px;" maxlength="1"
                                    class="otp_field form-control form-control-sm font_poppin inputs" value=""
                                    name="otp_2">
                                <input id="" type="text" style="   width: 50px;
                                    height: 50px !important;
                                    padding: 5px !important;
                                    border-radius: 5px !important;
                                    font-size: 22px;
                                    text-align: center;
                                    display: inline-block;
                                    margin: 0px 5px;" maxlength="1"
                                    class="otp_field form-control form-control-sm font_poppins inputs" value=""
                                    name="otp_3">
                                <br>
                                <span
                                    class="text-center">{{ $otp_array[0] }}{{ $otp_array[1] }}{{ $otp_array[2] }}{{ $otp_array[3] }}</span>
                            </div>


                        </div>
                        <div class="form-group text-center pt-3">
                            <button type="submit" class="btn btn-signin">Verify</button>
                            {{-- @php --}}
                            {{-- $response_url = route('cover-page-v2'); --}}
                            {{-- @endphp --}}
                            {{-- <button type="submit" class="btn btn-theme mt-3" onclick="loginFunction(this)">Log In</button> --}}

                        </div>
                    </div>
                </form>

                <div class="text-center create_sign">
                    <h4>Don't have an account? <a href="{{ route('cover.signup') }}">Sign Up</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_js')
    <script>
        $(".inputs").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).next('.inputs').focus();
            }
        });

        // new

        function loginFunction(thisElement) {
            event.preventDefault();

            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");

            if (formValidation(formID) == false) {
                return;
            }

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent Successfully',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    })
                    $.unblockUI();

                },
                error: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'error',
                        title: 'Email And Password Is Not Match',
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

        // end
    </script>
@endpush
