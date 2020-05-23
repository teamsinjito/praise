var jqxhr = null;

//ボードのコメントボタン押下処理
$(document).on('click','.board-btn-area > .comment',function(){

    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }

    $('.board-btn-area > .comment').css('color','var(--main-fn-color-gray)');
    $(this).parent().children('.comment').css('color','#D2691E');

    // エラーメッセージリフレッシュ
    $('.comment-post-error').remove();

    //画面レイアウト制御
    //pcかphoneか
    if($(this).hasClass('comment-pc')){
        $('.comment-area').css('display','block');
        //右から出てくる
        $('.comment-area').animate({
            "right": "0px"
        },{ duration: 500 });
        $('.comment-area').css('top','64px');
        $('.comment-area').css('width','27%');
        //コメント投稿エリアの表示、非表示によってコメントリストの初期状態の高さを設定
        if(!$('.comment-list').data('closeh')){
            $('.comment-list').css('height','75%');
        }
        $('.comment-list').data('closeh',75); //コメント投稿エリア非表示時のコメントリストの高さ
        $('.comment-list').data('openh',50); //コメント投稿エリア表示時のコメントリストの高さ

        //メインエリアの横幅を調整
        $('.main-all-area').addClass('col-8');
    
        //ボードの横幅を調整
        $('.board').removeClass('col-lg-4').addClass('col-lg-6');
    }else{
        $('.comment-area').css('display','block');
        //下から出てくる
        $('.comment-area').animate({
            "top": "40%"
        },{ duration: 500 });
        //コメント投稿エリアの表示、非表示によってコメントリストの初期状態の高さを設定
        if(!$('.comment-list').data('closeh')){
            $('.comment-list').css('height','40%');
        }
        $('.comment-list').data('closeh',40);//コメント投稿エリア非表示時のコメントリストの高さ
        $('.comment-list').data('openh',15);//コメント投稿エリア表示時のコメントリストの高さ

    }

    //ボードのIDからコメントを全て取得
    var boardId= $(this).parents('.board').children('img').attr('id');

    $('.comment-add-row > .footer').data('boardid',boardId);

    if($('.comment-area-row').length) {
        $('.comment-area-row').remove();
    }
    $('.comment-area').removeClass('active');
    $('.comment-area').addClass('active');

    jqxhr = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/comments/'+boardId,
        type: 'GET',
        datatype: 'json',
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // 取得したコメントリストでHTMLを構成
        makeCommentListHTML(data);       
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });

});

//取得したコメントリストでHTMLを構成
function makeCommentListHTML (data) {

    for(var i =  0; i<data.length; i++){
        $('.comment-list').append('<div class="comment-area-row my-2">'+
        '<div class="comment-user-icon col-lg-3 col-2 pr-1">'+
        '<img class="my-icon border w-100" src="/storage/img/users/'+data[i].id+'.png">'+
        '</div>'+
        '<div class="comment-user-comment col pl-0">'+
        '<div class="comment-user-name txt_S mb-0">'+data[i].name+'</div>'+
        '<div class="txt_M pl-3">'+data[i].comment+'</div>'+
        '</div>'+
        '<div class="comment-footer-row offset-6">'+
        '<div class="txt_S">'+data[i].created_at+'</div>'+
        '</div>'+
        '</div>'
        )
    }
}

//コメント投稿エリア表示、非表示切替
$(document).on('click','.comment-display-toggle',function(){
    var toggle = $(this).data('display');
    var openh = $('.comment-list').data('openh');
    var closeh = $('.comment-list').data('closeh');

    if(toggle == 'off'){
        $('.comment-add-row-area').show(500);
        $('.comment-list').animate({
            "height":openh +"%"
        },{ duration: 500 });
        $(this).html('<i class="fas fa-angle-down"></i>&nbsp;Add Comment!');
        $(this).data('display','on');
    }else{
        $('.comment-add-row-area').hide(500);
        $('.comment-list').animate({
            "height": closeh+"%"
        },{ duration: 500 });
        $(this).html('<i class="fas fa-angle-up"></i>&nbsp;Add Comment!');
        $(this).data('display','off');
    }
})

//コメント投稿
$(document).on('click','.comment-add-row > .footer > button',function(){

    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }

    // エラーメッセージリフレッシュ
    $('.comment-post-error').remove();

    $('.comment-add-row > .footer > button').prop( 'disabled', true);

    var comment = $('.comment-user-comment > div > input').val();
    var boardId= $(this).parent().data('boardid');
    $('.comment-user-comment > div > input').val("");

    jqxhr = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/comments/'+boardId,
        type: 'POST',
        datatype: 'json',
        data: {'comment': comment}
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {

        //コメントリストをリセット
        if($('.comment-area-row').length) {
            $('.comment-area-row').remove();
        }
        // 取得したコメントリストでHTMLを構成
        makeCommentListHTML(data);

        //コメント数更新
        $('div[name="'+boardId+'"] > .comment-counter').text(data.length);
        
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');

        var atr = JSON.parse(data.responseText)

        if(!$('.comment-list > .comment-post-error').length){
            $('.comment-list').prepend('<div class="alert alert-danger comment-post-error"></div>');
        }
        $.each( atr.errors, function( key, value ) {
            $('.comment-post-error').append('<p class="txt_S mb-0">'+value+'</p>');
        });
    });
    $('.comment-add-row > .footer > button').prop( 'disabled', false);

})

//コメント一覧閉じるボタン押下時
$(document).on('click','.close-comment-icon > i',function(){
    if($('.board-btn-area > .comment-pc').css('display') == 'inline-block'){
        $('.comment-area').animate({
            "right": "-900px"
        },{ duration: 500 });

    }else{
        $('.comment-area').animate({
            "top": "120%"
        },{ duration: 500 });
    }
    $('.board-btn-area > .comment').css('color','var(--main-fn-color-gray)');
    // $('.comment-area').css('display','none');
    $('.comment-area').removeClass('active');
    //TLの横幅を調整
    $('.main-all-area').removeClass('col-8');

    //ボードの横幅を調整
    $('.board').removeClass('col-lg-6').addClass('col-lg-4');
})