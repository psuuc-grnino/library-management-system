@extends('layouts.app')

@section('content')
<div class="container col-xxl-6 px-4">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">

        <div class="col-lg-6">
            <div class="card shadow-lg p-4">
                 <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3 text-center">Welcome Back!</h1>
            <p class="lead text-center">Log in to continue managing your books.</p>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg">{{ __('Login') }}</button>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                            @endif
                        </div>

                        
                        <div class="text-center mt-3">
                            <p>Don't have yet an account? <a href="{{ route('register') }}" class="text-decoration-none">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-10 col-sm-8 col-lg-6">
            <img src="{{ asset('images/login-image.jpg') }}" class="d-block mx-lg-auto img-fluid rounded-3 shadow" alt="Login Image" width="700" height="300" loading="lazy">
        </div>

    </div>
</div>
@endsection
