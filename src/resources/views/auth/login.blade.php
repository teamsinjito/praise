@extends('layouts.app')

@section('content')


<div class="container">
    <div class="col-sm-6 offset-sm-3 text-center">
        <div class="login-form-title txt_XL">SINJITO</div>
        <div class="form-contents">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row form-contents-area">
                    <input id="user_id" type="user_id" class="login-form-control txt_L w-100 border-0 @error('user_id') is-invalid @enderror" name="user_id" placeholder="user id" value="{{ old('user_id') }}" required autocomplete="user_id" autofocus>
                </div>
                @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="row form-contents-area">
                    <input id="password" type="password" class="login-form-control txt_L w-100 border-0 @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="row form-check chkbox px-5 py-3">
                    <input style="display:none" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label txt_M text-center" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="row py-2">
                    <button type="submit" class="btn btn-common border-0">
                        {{ __('SIGN UP') }}
                    </button>
                </div>
                <!-- あとで削除 -->
                <a class="nav-link txt_L  header-fn-color my-auto"  href="{{ route('register') }}">register</a>

            </form>
        </div>      
    </div>
</div>
@endsection
