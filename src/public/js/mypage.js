window.onload = function(){
    // ページ読み込み時に実行したい処理
    $('#mypage-menu-list > li:first > a').parent().css('border-bottom','solid var(--main-cm-color-white) 2px');
    $('#mypage-menu-list > li:first > a').css('color','var(--main-cm-color-white)');

    $('.my-praise-datas > section:first').css('display','block');

}

//メニューボタン押下時
$('#mypage-menu-list > li > a').click(function(){

    //色変更
    $(this).parent().siblings().css('border-bottom','solid var(--main-fn-color-black) 2px');
    $(this).parent().css('border-bottom','solid var(--main-cm-color-white) 2px');
    $(this).css('color', 'var(--main-cm-color-white)');
    $(this).parent().siblings().children().css('color', 'var(--main-fn-color-black)');

    //クリックした要素のクラス名取得
    var className = $(this).attr('class');

    //対象のセクションを表示、それ以外は非表示にする
    $('.my-praise-datas > section[class='+className+']').css('display','block');
    $('.my-praise-datas > section[class='+className+']').siblings('section').css('display','none');

})