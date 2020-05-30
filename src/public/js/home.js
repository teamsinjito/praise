//完了メッセージウィンドウ閉じる
$('.modal-class-btn').on('click',function(){
    $('#prised-completed').fadeOut();
});
window.onload = function(){
    // ページ読み込み時に実行したい処理
    $('.board-btn-area > .pushed').css('color','#EE82EE');
    $('#prised-completed > .modal-display').fadeIn();

    
}

$(window).on('scroll', function () {

    var imglastid = $('.boardImage').attr('data-imgid'); //現在表示されているボードの末尾のID
    var doch = $(document).innerHeight(); //ページ全体の高さ
    var winh = $(window).innerHeight(); //ウィンドウの高さ
    var bottom = doch - winh; //ページ全体の高さ - ウィンドウの高さ = ページの最下部位置

    if (bottom <= $(window).scrollTop()) {
    // if ($(window).scrollTop() == $(document).height() - $(window).height()) {

        if(imglastid > 1){
            //一番下までスクロールした時に実行
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/goods'+imglastid,
                type: 'GET',
                datatype: 'json',
            })
            .done(function(data) {
                
                makeBoardListHTML(data,'.boardImage-IN');
            })
            // Ajaxリクエスト失敗時の処理
            .fail(function(data) {
                // console.log('Ajaxリクエスト失敗');
                //スクロール禁止解除
                $("body").removeClass("no_scroll");
                $(window).off('touchmove');
            });


        }
        
    }
});