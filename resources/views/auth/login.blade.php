@extends('layouts.app')
@section('title','Login')

@section('login_content')
    <div class="container-xxl bg-gradient-primary">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('assets/img/logo/app.png') }}">
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder" style="padding-left:8px">R T B T S</span>
                            </a>
                        </div>
                        <h4 class="mb-2 center">Login to Your Account.</h4>
                        <p class="mb-4 center">Please sign-in to start your adventure</p>
                        <!-- Login Form -->
                        <form id="formAuthentication" class="mb-3 needs-validation" action="{{ route('login') }}" method="POST">
                        @csrf
                            <!-- Username Input -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input 
                                    id="email" 
                                    type="text" 
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    @if(Cookie::has('email')) value="{{Cookie::get('email')}}" @endif
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required autocomplete="email" 
                                    autofocusaria-describedby="emailHelp"
                                    placeholder="Enter your email or username"
                                    autofocus >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Password Input -->
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="#" onclick="not_available()">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        @if(Cookie::has('pass')) value="{{Cookie::get('pass')}}" @endif
                                        name="password" 
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        required autocomplete="current-password"
                                        aria-describedby="password" >
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Remember Me -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        @if(Cookie::has('email')) checked @endif

                                        type="checkbox" 
                                        name="remember"
                                        id="remember" 
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                                </div>
                            </div>
                            <!-- Sign-in / Submit Button -->
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection