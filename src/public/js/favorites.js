//いいねボタン押下処理
$(document).on('click','.board-btn-area > .good',function(){

    var boardId = $(this).parents('.board').children('img').attr('id');
    var parents = $(this).parents('.board');

    $(this).parent().children('.good').css('color','#EE82EE').prop("disabled", true);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/goods/'+boardId,
        type: 'POST',
        datatype: 'json',
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {

        // Laravel内で処理された結果がdataに入って返ってくる

        parents.find('.good-counter').text(data[0].cnt);
        // console.log('Ajaxリクエスト成功');
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });
});