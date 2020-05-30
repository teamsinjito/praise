<div class="sidebar-top">
    <div class="sidebar-icon col-md-12 col-6 offset-md-0 offset-3">
        @if(empty(Auth::user()->image))       
        <img src="{{ asset('/img/user_icon_default.png')}}?<?php echo date("YmdHis");?>" alt="ユーザーアイコン" class="w-75 mx-auto logo-user-icon">
        @else
        <img src="data:image/png;base64,{{ Auth::user()->image }}" alt="ユーザーアイコン" class="w-75 mx-auto logo-user-icon">
        @endif
    </div>
    <div class="sidebar-txt col-md-12 col-6 offset-md-0 offset-3">
        <label class="py-3 txt_L iphone-only-txt">{{ Auth::user()->name }}</label>
    </div>
</div>
<div class="profile-area">
    <label class="txt_S iphone-only-txt">{{ Auth::user()->profile }}</label>
</div>
<div class="py-3 praise_cnt">
    <label class="txt_S"><i class="far fa-smile-wink"></i><span class="iphone-only-txt">&nbsp;褒めた</span> ：{{$myPraiseCount}}回</label>
    <br>
    <label class="txt_S"><i class="far fa-grin-hearts"></i><span class="iphone-only-txt">&nbsp;褒められた</span> ：{{$toMyPraiseCount}}回</label>
</div>
<div class="contents border-dark border-top border-bottom py-3 mx-4">
    <a href="{{ url('/') }}" class="txt_M"><i class="fas fa-stream"></i><span class="iphone-only-txt">&nbsp;Home</span></a>
    <a href="{{ route('praise.create', ['auth_user' => Auth::user()]) }}" class="txt_M"><i class="fas fa-award"></i><span class="iphone-only-txt">&nbsp;Praise</span></a>
    <a href="{{ route('mypage', ['auth_user' => Auth::user()]) }}" class="txt_M"><i class="fas fa-home"></i><span class="iphone-only-txt">&nbsp;MyPage</span></a>
    <a href="{{ route('maintenance') }}" class="txt_M"><i class="fas fa-user-shield"></i><span class="iphone-only-txt">&nbsp;Config</span></a>
</div>

<!-- <div class="other_ mb-0 pt-3">
    <i class="fas fa-cogs txt_M"></i>
    <i class="fas fa-mail-bulk txt_M"></i>
</div> -->