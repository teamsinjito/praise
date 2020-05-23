@extends('layouts.app')

@section('css_js')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<link href="{{ asset('css/board.css') }}" rel="stylesheet">
<link href="{{ asset('css/comments.css') }}" rel="stylesheet">
<script src="{{ asset('js/home.js') }}" defer></script>
<script src="{{ asset('js/board.js') }}" defer></script>
<script src="{{ asset('js/comments.js') }}" defer></script>
<script src="{{ asset('js/favorites.js') }}" defer></script>
@endsection

@section('content')

<!-- 完了メッセージ -->
@if(session('praised'))
    @include('praiseComplete')
@endif

{{-- ボード表示 --}}
<div class="main-all-area boardImage h-100 mx-2 my-2" data-imgid="{{$boardPaths[count($boardPaths) - 1] -> id}}">
    <div class="w-100 boardImage-IN" data-flameimgpath = "{{ asset('/storage/img/templetes/board_frame.png') }}">
    @if(count($boardPaths) > 0)
        @foreach($boardPaths as $board)
            <div class="col-sm-6 col-lg-4 col-12 p-2 board">
                <img id="{{$board->id}}" src="{{ asset('/storage/img/boards/'.$board->id. '_1.png') }}" alt="ボード画像" class="w-100 boardImgs">
                <!-- いいね数 コメント数-->
                <div class="txt_S good-view-area" name="{{$board->id}}">
                    <i class="fas fa-thumbs-up goodView"></i>
                    <span class="good-counter">{{$board->cnt}}</span>
                    <i class="fas fa-comment-dots"></i>
                    <span class="comment-counter">{{$board->cnt_comment}}</span>
                </div>
                <!-- コメント追加、いいね追加ボタン -->
                <div class="txt_M board-btn-area">
                    <i class="fas fa-comment-dots comment comment-pc"></i>
                    <i class="fas fa-comment-dots comment comment-phone"></i>
                    <span class="mx-3 comment comment-pc"> Comment!</span>
                    <span class="mx-3 comment comment-phone"> Comment!</span>
                    <br>
                    @if($board->pushed > 0)               
                        <i class="fas fa-thumbs-up good pushed"></i>
                        <span class="mx-3 good pushed"> Favorite!</span>
                    @else
                        <i class="fas fa-thumbs-up good"></i>
                        <span class="mx-3 good"> Favorite!</span>
                    @endif
                    
                </div>
            </div>
        @endforeach
    @endif
    </div>
</div>

<!-- コメント欄 -->
@include('comments')

@endsection