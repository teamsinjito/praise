<div class="sidebar-top">
    <div class="sidebar-icon col-md-12 col-6 offset-md-0 offset-3">
        <img src="/storage/img/users/{{ Auth::user()->id }}.png?<?php echo date("YmdHis");?>" alt="ユーザーアイコン" class="w-75 mx-auto logo-user-icon">
    </div>
    <div class="sidebar-txt col-md-12 col-6 offset-md-0 offset-3">
        <label class="py-3 txt_L iphone-only-txt">{{ Auth::user()->name }}</label>
    </div>
</div>
<label class="txt_S iphone-only-txt">{{ Auth::user()->profile }}</label>
<div class="py-3 praise_cnt">
    <label class="txt_S"><i class="far fa-smile-wink"></i><span class="iphone-only-txt">&nbsp;褒めた</span> ：30回</label>
    <br>
    <label class="txt_S"><i class="far fa-grin-hearts"></i><span class="iphone-only-txt">&nbsp;褒められた</span> ：53回</label>
</div>
<div class="contents border-dark border-top border-bottom py-3 mx-4">
    <a href="/" target="_selef" class="txt_M"><i class="fas fa-stream"></i><span class="iphone-only-txt">&nbsp;Home</span></a>
    <a href="{{ route('praise.create', ['auth_user' => Auth::user()]) }}" class="txt_M"><i class="fas fa-award"></i><span class="iphone-only-txt">&nbsp;Praise</span></a>
    <a href="{{ route('mypage', ['auth_user' => Auth::user()]) }}" class="txt_M"><i class="fas fa-home"></i><span class="iphone-only-txt">&nbsp;MyPage</span></a>
    <a href="" target="_selef" class="txt_M"><i class="fas fa-user-shield"></i><span class="iphone-only-txt">&nbsp;Config</span></a>
</div>

<div class="other_ mb-0 pt-3">
    <i class="fas fa-cogs txt_M"></i>
    <i class="fas fa-mail-bulk txt_M"></i>
</div>