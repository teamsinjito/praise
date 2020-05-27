//いいねボタン押下処理
$(document).on('click','.board-btn-area > .good',function(){
    
    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }
    var pushedFlg;

    if($(this).hasClass('pushed')){

        $(this).parent().children('.good').css('color','var(--main-fn-color-gray)');
        $(this).removeClass('pushed');
        pushedFlg=1;

    }else{
        $(this).parent().children('.good').css('color','#EE82EE');
        $(this).addClass('pushed');
        pushedFlg=0;
    }

    var boardId = $(this).parents('.board').children('img').attr('id');
    var parents = $(this).parents('.board');

    jqxhr = $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/goods/'+boardId,
        type: 'POST',
        datatype: 'json',
        data: {'pushedFlg': pushedFlg}
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // Laravel内で処理された結果がdataに入って返ってくる

        parents.find('.good-counter').text(data[0].cnt);
        // console.log('Ajaxリクエスト成功');
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        // console.log('Ajaxリクエスト失敗');
    });
});