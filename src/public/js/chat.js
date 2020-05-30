var jqxhr = null;

//メッセージ投稿エリア表示、非表示切替
$(document).on('click','.comment-display-toggle',function(){
    var toggle = $(this).data('display');

    if(toggle == 'off'){
        $('.comment-add-row-area').show(500);
        $('.chat-area-main').animate({
            height: "60%"
        },{ duration: 500 });
        $(this).html('<i class="fas fa-angle-down"></i>&nbsp;Add Message!');
        $(this).data('display','on');
    }else{
        $('.comment-add-row-area').hide(500);
        $('.chat-area-main').animate({
            height: "80%"
        },{ duration: 500 });
        $(this).html('<i class="fas fa-angle-up"></i>&nbsp;Add Message!');
        $(this).data('display','off');
    }
})
// $(document).on('click','.toggle-icon',function(){
//     $('.user-list-area').css('display','block');
//     $('.chat-area').css('display','none');
// })
//ユーザリスト選択
$(document).on('click','.userList-area-row' ,function(){
    // $('.user-list-area').css('display','none');
    // $('.chat-area').css('display','block');

    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }

    var userName = $(this).find('.user-chat > div > .user-name').text();
    var uid=$(this).data('uid');
    var src=$(this).find('.my-icon').attr('src');

    $('.chat-area-header-user').text(userName);

    //既に開かれているか
    if($(this).hasClass('active')){
        return;
    }
    
    //activeクラスの変更
    $(this).addClass('active');
    $(this).siblings().removeClass('active');

    //チャットエリアを初期化
    $('.chat-area-main').children().remove();
    $('.chat-area-main').attr('id',uid);

    jqxhr = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/chat/personal/'+uid,
        type: 'GET',
        datatype: 'json',
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        console.log('成功');
        var j=0;
        // 取得したコメントリストでHTMLを構成
        for(var i =  0; i<data.length; i++){
            if(data[i].from_user_id == uid){
                j=j+1;
                

                $('.chat-area-main').append('<div class="balloon6">' +
                '<div class="faceicon">'+
                '<img class="my-icon border w-100" src="'+src+'">'+
                '</div>'+
                '<div class="chatting">'+
                '<div class="says">'+
                '<p>'+data[i].message+'</p>'+
                '</div>'+
                '</div>'+
                '<div class="text-position txt_S">'+data[i].created_at+
                '</div>'+
                '</div>')
            }else{
                $('.chat-area-main').append('<div class="mycomment mr-3">'+
                '<p>'+data[i].message+'</p>'+
                '<div class="txt_S">'+data[i].created_at+
                '</div>'+
                '</div>')
            }
        }
        $('.chat-area-main').attr('data-seq',j); 

    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });

})

//メッセージ送信ボタンクリック
$(document).on('click','.sendIcon' ,function(){

    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }

    var comment =$('.comment-user-comment > .cp_iptxt > input').val();

    if (comment == null || comment == '') {
        return
    }

    $('.comment-user-comment > .cp_iptxt > input').val("");

    var uid =$('.chat-area-main').attr('id');
    console.log(uid);
    jqxhr = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/chat/personal/'+uid,
        type: 'POST',
        datatype: 'json',
        data: {'comment': comment}
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // console.log('Ajaxリクエスト成功');
        $('.chat-area-main').append('<div class="mycomment mr-3">'+
        '<p>'+data.message+'</p>'+
        '<div class="txt_S">'+data.created_at+
        '</div>'+
        '</div>');
        
        $('.user-list > div[data-uid='+uid+']').css('order',-1);

        $('.user-list > div[data-uid='+uid+'] > .user-chat > .chat-header > .chat-last-date').text(data.created_at);
        $('.user-list > div[data-uid='+uid+'] > .user-chat > .user-message').text(data.message);
        // $('.user-list > div[data-uid='+uid+']').siblings().css('order',-1);
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });
})
