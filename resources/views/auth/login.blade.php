@include('layouts.head')
@php
$app_exp_date=DB::table('wsec_hospital')->first();

@endphp
@if(isset($app_exp_date->hospital_exp_date) && !empty($app_exp_date->hospital_exp_date) ? date('Y-m-d',strtotime($app_exp_date->hospital_exp_date)) < date('Y-m-d') :'') <div style="text-align:center; color:red"><strong>{{$app_exp_date->hospital_exp_date_message}}</strong></div>
    @else
    <section id="full_login_content">
        <div class="container-fluid">
            <div class="row align-items-center">

                @php
                $domain = explode('.', (request()->getHttpHost()));
                $imageURL = '';
                $backgroundColor = '';
                $width = '';

                if ($domain[0] == 'localhost' || $domain[0] == '192' || $domain[0] == '63' || $domain[0] == '202' || $domain[0] == 'ewmchp' || $domain[0] == '10') {
                $company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
                $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/h360-mini.png';
                $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
                $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
                } else {
                $company_details = \App\Models\Company::where('hospital_code', strtoupper($domain[0]))
                ->where('status', 1)
                ->first();
                $imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/h360-mini.png';
                $backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
                $width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';
                }

                @endphp

                <div class="col-12 right_side_col">
                    <div class="right_side_content">
                        <div class="login_form shadow-sm">
                            <div class="login_note text-center" style="background-color: {{ $backgroundColor }};width: {{ $width }}; margin: auto">
                                <img class="w-100" src="{{ asset($imageURL) }}">
                            </div>
                        
                            <div class="login_header text-center">
                                <h2>Login</h2>
                            </div>

                            @if (session()->has('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif


                            <form class="mt-3" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    {{-- <label for="email" class="col-form-label text-md-right font_poppins"> {{ __('User Name') }}</label> --}}

                                    <input id="email" type="text" class="form-control form-control-sm font_poppins  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Your User Name" autofocus> @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    {{-- <label for="password" class="col-form-label text-md-right font_poppins">{{ __('Password') }}</label> --}}
                                    <input id="password" type="password" class="form-control form-control-sm font_poppins  @error('password') is-invalid @enderror" name="password" placeholder="Enter Your Password" required autocomplete="current-password"> @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                @if($app_exp_date->hospital_code != 'UNICO')
                                <div class="form-group form-group-sm ">
                                    <div class="form-check pt-2 pb-2">
                                        <input class="form-check-input font_poppins" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label font_poppins" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group form-group-sm mb-0">
                                    <button type="submit" class="btn btn-block btn-success font_poppins">
                                        {{ __('Sign in') }}
                                    </button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif