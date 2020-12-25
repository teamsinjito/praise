@extends('layouts.app')

@section('content')


<div class="container">
    <div class="col-sm-6 offset-sm-3 text-center">
        <div class="login-form-title txt_XL">{{ config('app.name', 'Praise!!') }}</div>
        <div class="form-contents">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row form-contents-area">
                    <input id="user_id" type="text" class="login-form-control txt_L w-100 border-0 @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                </div>
                @error('email')
                    <span class="error-form-group w-100 p-2 txt_XS" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="row form-contents-area">
                    <input id="password" type="password" class="login-form-control txt_L w-100 border-0 @error('password') is-invalid @enderror" name="password" placeholder="password" autocomplete="current-password">
                </div>
                @error('password')
                    <span class="error-form-group w-100 p-2 txt_XS" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <!-- <div class="row form-check chkbox px-5 py-3">
                    <input style="display:none" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label txt_M text-center" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div> -->

                <div class="row py-2 form-contents-area">
                    <button type="submit" class="btn btn-common border-0">
                        {{ __('SIGN IN') }}
                    </button>
                </div>
                <!-- あとで削除 -->
                <!-- <a class="nav-link txt_L  header-fn-color my-auto"  href="{{ route('register') }}">register</a> -->

            </form>
        </div>      
    </div>
</div>
@endsection
