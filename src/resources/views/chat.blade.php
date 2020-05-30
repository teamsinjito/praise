@extends('layouts.app')

@section('css_js')
<link href="{{ asset('css/chat.css') }}" rel="stylesheet">
<script src="{{ asset('js/chat.js') }}" defer></script>
@endsection

@section('content')
<div class="main-all-area h-100 mx-2">
    <div class="w-100 h-100 main-area">
        <!-- ユーザ一覧 -->
        <div class="col-md-4 col-12 h-100 user-list-area">

            <!-- 一覧 -->
            <div class="user-list mt-5">
                @if(count($userList) > 0)
                    @foreach($userList as $u)
                        <div class="userList-area-row mb-5" data-uid="{{$u->id}}">
                            <div class="userList-user-icon col-lg-3 col-3 pr-1">
                                @if(empty($u->image))
                                    <img class="my-icon border w-100" src="{{ asset('img/user_icon_default.png') }}" alt="ユーザーアイコン">
                                @else
                                    <img class="my-icon border w-100" src="data:image/png;base64,{{ $u->image }}" alt="ユーザーアイコン">
                                @endif
                            </div>
                            <div class="user-chat col pl-0">
                                <div class="chat-header h-25">
                                    <div class="txt_S user-name">{{$u->name}}</div>
                                    <div class="txt_S chat-last-date">{{$u->created_at}}</div>
                                </div>
                                <div class="txt_S pl-3 mt-3 user-message">{{$u->message}}</div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <!-- チャット画面 -->
        <div class="col-md-8 col-12 h-100 chat-area">
            <div class="chat-area-header w-100">
                <h2 class="ml-3 my-3 txt_M"><i class="fas fa-angle-double-right toggle-icon"></i><span class="chat-area-header-user"></span></h2>
            </div>
            <div class="chat-area-main txt_S" data-seq="0">
                

            </div>
            <!-- コメント追加表示ボタン -->
            <p class="col-12 text-center comment-display-toggle txt_M mt-2 mb-4" data-display="off">
                <i class="fas fa-angle-up"></i>&nbsp;Add Message!
            </p>
            <!-- コメント投稿 -->
            <div class="comment-add-row-area">
                <div class="comment-add-row my-2">
                    <div class="comment-user-comment col pl-0">
                        <div class="cp_iptxt col-12 text-center">
                            <input type="text" placeholder="Message..." class="txt_M limited comment" name="comment" maxlength="255" value="{{ old('message') }}">
                            <i class="far fa-paper-plane txt_L sendIcon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection