@extends('layouts.app')

@section('css_js')
<link href="{{ asset('css/board.css') }}" rel="stylesheet">
<script src="{{ asset('js/board.js') }}" defer></script>
@endsection

@section('content')

{{-- ボード表示 --}}
<div class="boardImage mx-2 my-2" data-imgid="{{$boardPaths[count($boardPaths) - 1] -> id}}">
<div class="w-100 boardImage-IN" data-flameimgpath = "{{ asset('/storage/img/templetes/board_frame.png') }}">
@if(count($boardPaths) > 0)
    @foreach($boardPaths as $board)
        <div class="col-12 col-sm-4 p-2">
            <img id="{{$board->id}}" src="{{ asset('/storage/img/boards/'.$board->id. '_1.png') }}" alt="ボード画像" class="w-100 boardImgs">
            <!-- <img src="{{ asset('/storage/img/templetes/board_frame.png') }}" class="boardFlame"> -->
        </div>
    @endforeach
@endif
</div>

</div>

@endsection