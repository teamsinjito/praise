@extends('layouts.app')

@section('css_js')
    <link href="{{ asset('css/praise.css') }}" rel="stylesheet">
    <script src="{{ asset('js/praise.js') }}" defer></script>
@endsection

@section('content')

    <div class="main-all-area h-100 mx-2">
        <div class="praise-all-area">
            <div class="praise-bg-area">
                <div class="praise-area">
                    <header class="progress-bar-area mx-2" id="progress-bar-id">
                        <div class="icon-area progress-circle">
                            <img class="progress-circle praise-step-1" src="" style="visibility:hidden">
                            <p class="text-center">コイツ</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar praise-step-1" role="progressbar" style="width:0%"></div>
                        </div>
                        <div class="icon-area progress-circle">
                            <img class="progress-circle praise-step-2" src="" style="visibility:hidden">
                            <p class="text-center">これで</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar praise-step-2" role="progressbar" style="width:0%"></div>
                        </div>
                        <div class="icon-area progress-circle">
                            <img class="progress-circle praise-step-3" src="" style="visibility:hidden">
                            <p class="text-center">褒める</p>
                        </div>
                    </header>
    
                    <form action="{{ route('praise.create', ['auth_user' => Auth::user()]) }}" method="post">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $message)
                            <p>{{ $message }}</p>
                            @endforeach
                        </div>
                        @endif
                        <main class="praise-steps">
                            <h1 class="border-dark txt_M border-bottom text-center my-4">誰を褒める？</h1>
                            <div class="to-page-area common-page-area-size text-center w-100 my-3">
                                <div class="pre btn-common pager-btn txt_XL col-sm-1"><</div>
                                <!-- ユーザー選択 -->
                                <section class="to-icon-area col-sm-10 col-12 active" id="praise-step-1">
                                    @foreach($users as $u)
                                        @if($loop->iteration % 6 == 1 || $loop->iteration == 1)
                                        <div class="section-page w-100">
                                        @endif                       
                                        <div class="to-icon col-6 col-sm-4 h-25">
                                            <input id="user-icon-id{{ $loop->iteration }}" type="radio" class="praise-step-1" name="to_user" value="{{ $u->id }}">
                                            <label for="user-icon-id{{ $loop->iteration }}">
                                            @if(empty($u->image))
                                            <img class="icon-circle" src="{{ asset('/img/user_icon_default.png')}}?<?php echo date("YmdHis");?>" alt="{{$u->name}}">
                                            @else
                                            <img class="icon-circle" src="data:image/png;base64,{{ $u->image }}" alt="{{$u->name}}">
                                            @endif
                                            </label>
                                            <label for="user-icon-id{{ $loop->iteration }}" class="icon-name txt_M">{{$u->name}}</label>                             
                                        </div>
                                        @if($loop->iteration % 6 == 0 || $loop->remaining == 0)
                                        </div>
                                        @endif   
                                    @endforeach
                                </section>
                                <!-- スタンプ選択 -->
                                <section class="to-icon-area col-sm-10 col-12" id="praise-step-2">
                                    @foreach($stamps as $s)
                                        @if($loop->iteration % 6 == 1 || $loop->iteration == 1)
                                        <div class="section-page w-100">
                                        @endif                       
                                        <div class="to-icon col-6 col-sm-4 h-25">
                                            <input id="stamp-icon-id{{ $loop->iteration }}" type="radio" class="praise-step-2" name="to_stamp" value="{{ $s->id }}">
                                            <label for="stamp-icon-id{{ $loop->iteration }}">
                                            @if(empty($s->image))
                                            <img class="icon-circle icon-circle-s" src="{{ asset('/img/stamp_icon_default.png')}}?<?php echo date("YmdHis");?>" alt="{{$s->name}}">
                                            @else
                                            <img class="icon-circle icon-circle-s" src="data:image/png;base64,{{ $s->image }}" alt="{{$s->name}}">
                                            @endif
                                            </label>
                                            <label for="stamp-icon-id{{ $loop->iteration }}" class="icon-name txt_M">{{$s->name}}</label>                             
                                        </div>
                                        @if($loop->iteration % 6 == 0 || $loop->remaining == 0)
                                        </div>
                                        @endif   
                                    @endforeach
                                </section>
                                <!-- 一言メッセージ入力 -->
                                <section class="to-icon-area col-sm-10 col-12" id="praise-step-3">
                                    <div class="section-page w-100">
                                        <div class="cp_iptxt col-12 text-center py-5">
                                            <input type="text" placeholder="Message..." class="txt_M limited" name="message" maxlength="30" value="{{ old('message') }}">
                                        </div>
                                    </div>
                                </section>
                                <div class="next btn-common pager-btn txt_XL col-sm-1">></div>
                            </div>
                            <div class="step-btn-area col-sm-4 col-12 offset-sm-8">
                                <button type="button" class="pre-step-btn btn-common w-100 txt_L" disabled>Prev</button>
                                <button type="button" class="next-step-btn btn-common w-100 txt_L" disabled>Next</button>
                                <button type="button" class="btn-common w-100 txt_L" id="praise-sabmit-btn">Send</button>
                            </div>
                        </main>
                    </form>
    
                </div>
            </div>
        </div>
    </div>
@endsection

