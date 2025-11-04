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
                    <h3 class="signin_title">Welcome to M Care</h3>
                </div>

                <?php
                $data_id = isset($id) ? $id : '';
                ?>

                <form action="{{ route('cover.login-for-appoitment', $data_id) }}" method="post"
                    id="signin_appointment">

                    @csrf
                    {{-- <input type="hidden" value="{{ $id }}" name="id"> --}}
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
                        <div class=" form-group">
                            <input type="text" maxlength="13" placeholder="Enter Mobile Number"
                                class="form-control sigin_field number_only" name="mobile" required />
                            <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                        </div>

                        <div class="form-group text-center pt-3">
                            <button type="submit" class="btn btn-signin">Log In</button>

                        </div>
                    </div>
                </form>

                <div class="text-center create_sign">
                    <h4>Don't have an account? <a href="{{ route('cover.signup-for-appointment', $data_id) }}">Sign
                            Up</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_js')
    <script>
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
