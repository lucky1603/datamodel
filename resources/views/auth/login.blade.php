<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Prijava | NTP Beograd - Akcelerator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
{{--    <link rel="shortcut icon" href="assets/images/favicon.ico">--}}
    <link rel="icon" href="{!! asset('images/custom/blue-logo-transparent.png') !!}"/>

    <!-- App css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-left">
                    <a href="index.html" class="logo-dark">
                        <span><img src="/images/custom/logo-lat.png" alt="" width="80%"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="/images/custom/white-logo-transparent-full.png" alt="" height="18"></span>
                    </a>
                </div>

                <!-- title-->
                <h4 class="mt-3 text-center mb-2">{{ __('Sign In') }}</h4>
                <p class="text-muted mb-4">{{ __('auth.sign_in_message') }}</p>

                <!-- form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">{{ __('Email address') }}</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="{{ __('Enter your email') }}" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="{{ __('Enter your password') }}" value="{{ old('email') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
{{--                    <div class="form-group mb-3">--}}
{{--                        <div class="custom-control custom-checkbox">--}}
{{--                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">--}}
{{--                            <label class="custom-control-label" for="checkbox-signin">{{ __('Remember me') }}</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                    <div class="form-group row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-login mr-1"></i>{{ __('Log in') }}</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
{{--                    <!-- social-->--}}
{{--                    <div class="text-center mt-4">--}}
{{--                        <p class="text-muted font-16">{{ __('Sign in with') }}</p>--}}
{{--                        <ul class="social-list list-inline mt-3">--}}
{{--                            <li class="list-inline-item">--}}
{{--                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>--}}
{{--                            </li>--}}
{{--                            <li class="list-inline-item">--}}
{{--                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>--}}
{{--                            </li>--}}
{{--                            <li class="list-inline-item">--}}
{{--                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>--}}
{{--                            </li>--}}
{{--                            <li class="list-inline-item">--}}
{{--                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                </form>
                <!-- end form-->

                <!-- Footer-->
                {{-- <footer class="footer footer-alt">
                    <p class="text-muted">Don't have an account? <a href="pages-register-2.html" class="text-muted ml-1"><b>Sign Up</b></a></p>
                </footer> --}}

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
{{--            <h2 class="mb-3">I love the color!</h2>--}}
{{--            <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i class="mdi mdi-format-quote-close"></i>--}}
{{--            </p>--}}
{{--            <p>--}}
{{--                - Hyper Admin User--}}
{{--            </p>--}}
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- bundle -->
<script src="assets/js/vendor.min.js"></script>
<script src="assets/js/app.min.js"></script>

</body>

</html>
