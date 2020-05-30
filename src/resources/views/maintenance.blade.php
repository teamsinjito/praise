@extends('layouts.app')

@section('css_js')
<link href="{{ asset('css/maintenance.css') }}" rel="stylesheet">
<script src="{{ asset('js/maintenance.js') }}" defer></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

{{-- 入力フォーム表示 --}}
@section('content')

<!-- 完了メッセージ -->
@if(session('successed'))
<span data-id="{{session('successed')}}" id="success-alert" style="display:none"></span>
@endif

<div class='multipletab'>
    
    <div class='tab-buttons'>
    <!--add more button right after it with same id attribute of that container. Make sure to use span tag.-->
        <span id='user_tab'>ユーザー情報</span>
        <span id='category_tab'>カテゴリー</span>
        <span id='stamp_tab'>スタンプ</span>
    </div>

    <div class='tab-content'>
    
        <form action="{{ route('user.create')}}" method="post" id="userForm">
            {{ csrf_field() }}
            <div id='user_tab'>
                <label class="txt_XL user_label">パスワード変更</label><br>
                <input id="password" type="password" name="password" placeholder="password"><br>
                <input type="submit" class="registerButton">
            </div>
        </form>

        <form action="{{ route('category.create')}}" method="post" id="categoryForm">
            {{ csrf_field() }}
            <div id='category_tab'>
                <label class="txt_XL">カテゴリー名</label><br>
                <input type="text" name="category_name" class="category-name" maxlength="30" value="" placeholder="30文字以内で入力"><br>
                <input type="button" class="categoryPost registerButton" value="登録"> 
            </div>
        </form>

        <form action="{{ route('stamp.create')}}"  method="post" id="stampForm">
            <div id='stamp_tab'> 
                <label class="txt_XL ">スタンプー名</label><br>
                <input type="text" name="stamp_name" maxlength="30" value="" placeholder="30文字以内で入力"><br>
                <label class="txt_XL category_label">カテゴリー名</label><br>
                {{ Form::select('categories', $categories, null, ['class' => 'categori', 'id' => 'id']) }}<br>
                <label class="txt_XL stamp_label">スタンプ画像</label><br>
                {{ csrf_field() }}
                <input type="file" name="photo" class="photoFile"　id="selectImage" accept="image/*"><br>
                <img id="preview" width="10%" height="10%"><br>
                <input type="submit" class="registerButton">
            </div>
        </form>
    </div>

    <div class='tab-nav'>
        <span class='next'></span>
        <span class='prev'></span>
    </div>

</div>
@endsection