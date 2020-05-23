<div class="h-100 col-sm-10 col-12 comment-area p-0">
    <div class="comment-area-header col-12 text-center py-3">
        <div class="close-comment-icon txt_L"><i class="far fa-times-circle"></i></div>
        <div class="comment-area-title txt_L w-100">Comments</div>
    </div>

    <div class="comment-list">
        <!-- コメント取得 -->
    </div>
    <div class="js-commentAdd-fillter">
        <!-- コメント追加表示ボタン -->
        <p class="col-10 offset-1 text-center comment-display-toggle txt_M mt-2 mb-4" data-display="off">
            <i class="fas fa-angle-up"></i>&nbsp;Add Comment!
        </p>
        <!-- コメント投稿 -->
        <div class="comment-add-row-area">
            <div class="comment-add-row my-2">
                <div class="comment-user-icon col-lg-3 col-2 pr-1">
                    <img class="my-icon border w-100" src="/storage/img/users/{{ Auth::user()->id }}.png?<?php echo date("YmdHis");?>">
                </div>
                <div class="comment-user-comment col pl-0">
                    <div class="comment-user-name txt_S mb-0">{{Auth::user()->name}}</div>
                    <div class="cp_iptxt col-12 text-center">
                        <input type="text" placeholder="Comment..." class="txt_M limited comment" name="comment" maxlength="30" value="{{ old('message') }}">
                    </div>
                </div>
                <div class="footer col-8 offset-2 my-4" data-boardid="">
                    <button class="btn-common w-100 txt_L">Send!</button>
                </div>
            </div>
        </div>
    </div>

</div>