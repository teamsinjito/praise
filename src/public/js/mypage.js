window.onload = function(){
    // ページ読み込み時に実行したい処理
    $('#mypage-menu-list > li:first > span').click();
}

//メニューボタン押下時
$('#mypage-menu-list > li > span').click(function(){

    //色変更
    $(this).parent().siblings().css('border-bottom','solid var(--main-fn-color-black) 2px');
    $(this).parent().css('border-bottom','solid var(--main-cm-color-white) 2px');
    $(this).css('color', 'var(--main-cm-color-white)');
    $(this).parent().siblings().children().css('color', 'var(--main-fn-color-black)');

    //クリックした要素のクラス名取得
    var classNames = $(this).attr('class').split(" ");;

    //対象のセクションを表示、それ以外は非表示にする
    $('.my-praise-datas > .'+classNames[1]).css('display','block').addClass('active');
    $('.my-praise-datas > .'+classNames[1]).siblings('section').css('display','none').removeClass('active');

    
})

//画像切替
$(document).on('click','.my-board',function(){ 
    var imgSrc = $(this).attr('src');
    
    console.log(imgSrc);
    if(imgSrc.match('_1.png')){
        imgSrc = imgSrc.replace('_1.png','_2.png');
    }
    else{
        imgSrc = imgSrc.replace('_2.png','_1.png');
    }
    
    $(this).attr('src',imgSrc);
    
})

//ajax　メニュー切替時
$('#mypage-menu-list > li > .board').one('click', function() {

    //クラス名取得
    var classNames =$(this).attr('class').split(" ");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/mypage/'+classNames[1],
        type: 'GET',
        datatype: 'json',


    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // Laravel内で処理された結果がdataに入って返ってくる
        // console.log(data);
        for(var i = 0; i < data.length; i++){
            $('.'+ classNames[1] +' > .my-board-area').append('<div class="col-sm-4 col-12">' +
            '<img class="my-board w-100" src="/storage/img/boards/'+data[i].id+'_1.png">'+
            '</div>')
        }
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        // console.log('Ajaxリクエスト失敗');
    });
});

//ajax スクロールイベント
$(window).on('scroll', function() { 
    
    //最下に来た時
    if ($(window).scrollTop() == $(document).height() - $(window).height()) {

        //現在褒めた履歴、褒められた履歴を表示しているか　かつボードが9つ以上あるか
        if($('.my-praise-datas > .active > .my-board-area').children().length>8){

            //現在のページ数を取得
            var page =$('.my-praise-datas > .active > .my-board-area').data('page');
            console.log(page);
    
            var classNames= $('.my-praise-datas > .active').attr('class').split(" ");

            $.ajax({
                type: "GET",
                contentType: "application/json",
                // コンテンツ読み込み先URL
                url: "/mypage/"+classNames[0]+"/" + page, //ルーティングのパス
                datatype: 'json',
    
            })
            // Ajaxリクエスト成功時の処理
            .done(function(data) {
                // Laravel内で処理された結果がdataに入って返ってくる
                console.log(data);
                for(var i = 0; i < data.length; i++){
                    $('.my-praise-datas > .active > .my-board-area').append('<div class="col-sm-4 col-12">' +
                    '<img class="my-board w-100" src="/storage/img/boards/'+data[i].id+'_1.png">'+
                    '</div>')
                }
                if(data.length){
                    page++;
                    $('.my-praise-datas > .active > .my-board-area').data('page',page);
                }
            })
            // Ajaxリクエスト失敗時の処理
            .fail(function(data) {
                console.log('Ajaxリクエスト失敗');
            });
        }
    }
});