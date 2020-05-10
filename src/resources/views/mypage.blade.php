@extends('layouts.app')

@section('css_js')
    <link href="{{ asset('css/mypage.css') }}" rel="stylesheet">
    <script src="{{ asset('js/mypage.js') }}" defer></script>
@endsection

@section('content')
    <div class="main-all-area h-100 mx-2">
        <div class="mypage-bg-area h-100 py-4">
            <div class="h-100">
                <header class="my-profiles" id="my-profiles">
                    <div class="my-icon-area ">
                        <div class="my-icon-name col-10">
                            <img class="my-icon" src="/storage/img/users/{{ Auth::user()->id }}.png">
                            <div class="mx-4">
                                <span class="txt_L">{{Auth::user()->name}}</span>
                                <br class="br-iphone">
                                &nbsp;
                                <span class="txt_M">/ {{Auth::user()->user_id}}</span>
                            </div>
                        </div>
                        <div class="chamge-my-profile col-2 py-5">
                            <button type="button" class="btn-common border-0 w-100 h-100">
                                編集
                            </button>
                        </div>
                    </div>
                    <div class="my-profile-area">
                        <div class="col-12 my-profile-txt py-3">
                            <span class="txt_S">{{Auth::user()->profile}}</span>
                        </div>
                        <div class="my-praise-cnt col-12 ">
                            <label class="txt_S"><i class="far fa-smile-wink"></i>&nbsp;褒めた回数: 30回</label>
                            <label class="txt_S offset-1"><i class="far fa-grin-hearts"></i>&nbsp;褒められた回数: 53回</label>
                        </div>
                    </div>
                </header>

                <main class="my-praise-datas ">
                    <nav class="mypage-menu w-100">
                        <ul class="mypage-menu-list col-12 text-center px-5" id="mypage-menu-list">
                            <li class="col-3 txt_S">
                                <a href="#" class="menu-1"><i class="far fa-smile-wink"></i>&nbsp;褒め</a>
                            </li>
                            <li class="col-3 txt_S">
                                <a href="#" class="menu-2"><i class="far fa-grin-hearts"></i>&nbsp;褒められ</a>
                            </li>
                            <li class="col-3 txt_S">
                                <a href="#" class="menu-3"><i class="fas fa-chart-area"></i>&nbsp;チャート</a>
                            </li>
                            <li class="col-3 txt_S">
                                <a href="#" class="menu-4"><i class="fab fa-cloudsmith"></i>&nbsp;相関図</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- 褒めた -->
                    <section class="menu-1">
                        eee
                    </section>
                    <!-- 褒められた -->
                    <section class="menu-2">
                        ffff
                    </section>
                    <!-- チャート -->
                    <section class="menu-3">
                        gggg
                    </section>
                    <!-- 相関図 -->
                    <section class="menu-4">
                            hhh
                    </section>
                </main>
            </div>
        </div>
    </div>
@endsection