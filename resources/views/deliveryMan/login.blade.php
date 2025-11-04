@extends('iCure-Home.includes.cover_master')
@section('cover_content')
<!-- preloader Start -->
<div class="preloader-wrap">
    <div class="preloader">
        <img src="{{ asset('coverpage/img/loader.gif') }}" alt="">
        <!-- <span></span><span></span><span></span><span></span> -->
    </div>
</div>
<!-- preloader End -->

<!-- Sign-in start -->
<!-- Sign-in start -->
<div class="signin">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="signin_img">
                    <img src="{{asset('coverpage/img/signin.png')}}">
                </div>
            </div>
            <div class="col-md-5">
                <div class="signin_section">
                    <h3 class="signin_title">Welcome to MCARE</h3>
                </div>
                @if($flash=session('message'))
                <div class="alert alert-danger text-center" role="alert">
                    {{$flash}}
                </div>
                @endif
                <form action="{{ route('submission') }}" method="post" id="delivery_man_login_form_id">
                    @csrf
                    <div class="form">
                        <div class="form-group">
                            <input type="text" placeholder="Enter Your Email Address" class="form-control sigin_field" name="email" value="{{old('email')}}" id="email" class="@error('email') is-invalid @enderror"/>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class=" form-group">
                            <input type="password" placeholder="Enter Your Password" class="form-control sigin_field" name="password" value="{{old('password')}}" id="password" class="@error('password') is-invalid @enderror"/>
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group text-center pt-3">
                            <button type="submit" class="btn  btn-signin">Log In</button>

                        </div>
                    </div>
                </form>
                {{--
                <div class="text-center create_sign">
                    <h4>Don't have an account? <a href="{{ route('cover.signup') }}">Sign Up</a></h4>
                </div>
                --}}

            </div>
        </div>
    </div>
</div>
<!-- sign-in end -->
<!-- sign-in end -->
@endsection
