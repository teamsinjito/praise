<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Praise!!') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha256-UzFD2WYH2U1dQpKDjjZK72VtPeWP50NoJjd26rnAdUI=" crossorigin="anonymous" />


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- CSS & JS -->
    @yield('css_js')

</head>
<body>
    <!-- loding -->
    <div id="overlay">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
    </div>
    <div id="app">
        @auth
            <nav class="navbar navbar-expand-sm navbar-light shadow-sm py-0">
                <a class="navbar-brand mx-0 txt_L header-fn-color" href="{{ url('/') }}">
                <img src={{ asset('/img/logo.png')}} class="logo_png" style="width: 100px">
                    &nbsp;
                    {{ config('app.name', 'Praise!!') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                        <a class="nav-link txt_L header-fn-color" href="{{ url('/') }}">
                            <img src={{ asset('/img/user.png')}} alt="ユーザーアイコン" style="width: 40px;">
                            <span>
                                {{ Auth::user()->name }}
                            </span>
                        </a>
                        <span class="nav-link txt_L header-fn-color my-auto span_slice"> / </span>
                        <a class="nav-link txt_L  header-fn-color my-auto"  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Sign out') }}
                        </a>

                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </ul>
                </div>
            </nav>
            <div class="row main-area mx-0">
                <aside class="col-md-2 col-12 px-0 w-100">
                        <div class="sidebar text-center side-color col-md-2 col-12 py-4">
                            <img src={{ asset('/img/user.png')}} alt="ユーザーアイコン" class="w-50 mx-auto">
                            <label class="py-3 txt_L">{{ Auth::user()->name }}</label>
                            <label class="txt_L">{{ Auth::user()->profile }}</label>
                            <div class="py-3 praise_cnt">
                                <label class="txt_M"><i class="far fa-smile-wink"></i>&nbsp;褒めた: 30回</label>
                                <label class="txt_M"><i class="far fa-grin-hearts"></i>&nbsp;褒められた: 53回</label>
                            </div>
                            <div class="contents border-dark border-top border-bottom py-3 mx-4">
                                <a href="/" target="_selef" class="txt_L"><i class="fas fa-stream"></i>&nbsp;Home</a>
                                <a href="{{ route('praise.create', ['auth_user' => Auth::user()]) }}" class="txt_L"><i class="fas fa-award"></i>&nbsp;Praice</a>
                                <a href="" target="_selef" class="txt_L"><i class="fas fa-home"></i>&nbsp;MyPage</a>
                                <a href="" target="_selef" class="txt_L"><i class="fas fa-user-shield"></i>&nbsp;Config</a>
                            </div>
    
                            <div class="other_ mb-0 pt-3">
                                <i class="fas fa-cogs txt_L"></i>
                                <i class="fas fa-mail-bulk txt_L"></i>
                            </div>
                        </div>
                </aside> 
                <main class="col px-0">
                    @yield('content')
                </main>
            </div>
        @else
            <div class="row main-area mx-0">
                <main class="col-12">
                    @yield('content')
                </main>
            </div>
        @endauth
    </div>
</body>
</html>
    