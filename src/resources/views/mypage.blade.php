@extends('layouts.app')

@section('css_js')
    <link href="{{ asset('css/mypage.css') }}" rel="stylesheet">
    <link href="{{ asset('css/board.css') }}" rel="stylesheet">
    <link href="{{ asset('css/comments.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <script src="{{ asset('js/mypage.js') }}" defer></script>
    <script src="{{ asset('js/board.js') }}" defer></script>
    <script src="{{ asset('js/comments.js') }}" defer></script>
    <script src="{{ asset('js/favorites.js') }}" defer></script>
@endsection

@section('content')
    <div class="main-all-area  mx-2">
        <div class="mypage-bg-area  py-4">
            <div class="">
                <header class="my-profiles" id="my-profiles">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $message)
                            <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                    <div class="my-icon-area ">
                        <div class="my-icon-name col-sm-10 col-9">
                            @if(empty(Auth::user()->image))
                            <img class="my-icon" src="{{ asset('/img/user_icon_default.png')}}?<?php echo date("YmdHis");?>" alt="ユーザーアイコン">
                            @else
                            <img class="my-icon" src="data:image/png;base64,{{ Auth::user()->image }}" alt="ユーザーアイコン">
                            @endif
                            <div class="mx-4">
                                <span class="txt_L">{{Auth::user()->name}}</span>
                            </div>
                        </div>
                        <div class="chamge-my-profile col-sm-2 col-3 py-5">
                            <button type="button" class="btn-common border-0 w-100 h-100">
                                <i class="fas fa-pen"></i>
                                <span class="large-only-txt">&nbsp;編集</span>
                            </button>
                        </div>
                    </div>
                    <div class="my-profile-area">
                        <div class="col-12 my-profile-txt py-3">
                            <span class="txt_S">{{Auth::user()->profile}}</span>
                        </div>
                        <div class="my-praise-cnt col-12 ">
                            <label class="txt_S"><i class="far fa-smile-wink"></i>&nbsp;褒めた回数: {{$myPraiseCount}}回</label>
                            <label class="txt_S offset-1"><i class="far fa-grin-hearts"></i>&nbsp;褒められた回数: {{$toMyPraiseCount}}回</label>
                        </div>
                    </div>
                </header>

                <main class="my-praise-datas">
                    <nav class="mypage-menu w-100">
                        <ul class="mypage-menu-list col-12 text-center px-5" id="mypage-menu-list">
                            <li class="col-3 txt_S">
                                <span class="board menu-1"><i class="far fa-smile-wink"></i><span class="large-only-txt">&nbsp;褒め</span></span>
                            </li>
                            <li class="col-3 txt_S">
                                <span class="board menu-2"><i class="far fa-grin-hearts"></i><span class="large-only-txt">&nbsp;褒められ</span></span>
                            </li>
                            <li class="col-3 txt_S">
                                <span class="chart menu-3"><i class="fas fa-chart-area"></i><span class="large-only-txt">&nbsp;チャート</span></span>
                            </li>
                            <li class="col-3 txt_S">
                                <span class="diagram menu-4"><i class="fab fa-cloudsmith"></i><span class="large-only-txt">&nbsp;相関図</span></span>
                            </li>
                        </ul>
                    </nav>

                    <!-- 褒めた -->
                    <section class="menu-1 boardImage">
                        <div class="my-board-area boardImage-IN w-100" data-page=1 data-flameimgpath = "{{ asset('img/board_frame.png') }}"></div>
                    </section>
                    <!-- 褒められた -->
                    <section class="menu-2 boardImage">
                        <div class="my-board-area boardImage-IN" data-page=1 data-flameimgpath = "{{ asset('/img/board_frame.png') }}"></div>
                    </section>
                    <!-- チャート -->
                    <section class="menu-3">
                        <div class="my-chart-area chart-container">
                            <canvas id="myRaderChart" class='w-100'></canvas>
                        </div>
                    </section>
                    <!-- 相関図 -->
                    <section class="menu-4">
                        <div class="my-diagram-area w-100" id="mydiagram" data-path="{{asset('/img/')}}"></div>
                    </section>
                </main>

            </div>
        </div>

        <!-- 編集 -->
        <section class="edit-overlay">
            <div class="modal__bg"></div>
            <form method="POST" action="{{ route('mypage.edit') }}" enctype="multipart/form-data" >
            {{ csrf_field() }}
                <div class="modal__content">
                    <div class="header col-12 text-center py-3">
                        <div class="edit-title col-12 txt_L">Edit Profile</div>
                    </div>
                    <div class="my-icon-name border-bottom col-12 text-center py-3">
                        @if(empty(Auth::user()->image))
                        <img class="my-icon border" src="{{ asset('/img/user_icon_default.png')}}?<?php echo date(  "YmdHis");?>" alt="ユーザーアイコン">
                        @else
                        <img class="my-icon border" src="data:image/png;base64,{{ Auth::user()->image }}" alt="ユーザーアイコン">                       
                        @endif
                        <label for="file" class="file-btn mt-auto">
                            <i class="fas fa-camera txt_M pl-2"></i>
                            <input type="file" id="file" accept="image/*" name="img"/>
                        </label>
                    </div>

                    <div class="name-area border-bottom col-12 text-center py-3">
                        <h2 class="col-sm-2 col-2 txt_M">name</h2>
                        <div class="col-sm-10 col-10">
                            <input type="text" class="w-100 border border-0 txt_M" value="{{Auth::user()->name}}" name="name" minlength="1" maxlength="30">
                        </div>
                    </div>
                    <div class="profile-area border-bottom col-12 text-center py-3">
                        <h2 class="col-sm-2 col-2 txt_M">profile</h2>
                        <div class="col-sm-10 col-10">
                            <textarea rows="1" cols="25" type="text" class="w-100 border border-0 txt_M" name="profile" maxlength="100">{{Auth::user()->profile}}</textarea>
                        </div>
                    </div>
                    <div class="footer col-sm-4 col-12 offset-sm-8 my-4">
                        <button type="button" class="js-modal-close btn-common w-100 txt_L">Prev</button>
                        <button type="submit" class="btn-common w-100 txt_L" id="submit-btn">Save!</button>
                    </div>
                </div><!--modal__inner-->
            </form>
        </section>
    </div>

    <!-- コメント欄 -->
    @include('comments')

@endsection