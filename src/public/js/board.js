// $('.boardImage-IN > div >img').on('click',function(){ 
$(document).on('click','.boardImage-IN > div >img',function(){ 
    var imgSrc = $(this).attr('src');
    
    if(imgSrc.match('_1.png')){
        imgSrc = imgSrc.replace('_1.png','_2.png');
    }
    else{
        imgSrc = imgSrc.replace('_2.png','_1.png');
    }
    
    $(this).attr('src',imgSrc);
    
});

$(window).on('scroll', function () {
    var imglastid = $('.boardImage').attr('data-imgid'); //現在表示されているボードの末尾のID
    var boardspath = '/storage/img/boards/' //ボード格納場所
    var doch = $(document).innerHeight(); //ページ全体の高さ
    var winh = $(window).innerHeight(); //ウィンドウの高さ
    var bottom = doch - winh; //ページ全体の高さ - ウィンドウの高さ = ページの最下部位置

    if (bottom <= $(window).scrollTop()) {
        //一番下までスクロールした時に実行
        
        //画面を三分割しているので3枚表示する(末尾自身は含まないので-1してスタート)
        for(let i = imglastid - 1; i != imglastid - 4; i--){
            //requestを飛ばせたもののみ追加
            if(i > 0){
                var boardImage_board = $('<div>', {class:'col-12 col-sm-4 p-2'}); 
                var scrollboard = $('<img>', {id:i,src: location.href + 'storage/img/boards/' + i + '_1.png',alt:'ボード画像',class:'w-100 boardImgs'});
                
                boardImage_board.append(scrollboard);
                
                //一度非表示にしてからファードインで表示(appendTo使用対策)
                $(boardImage_board).appendTo('.boardImage-IN').hide().fadeIn(700);
                
                $('.boardImage').attr('data-imgid',i);
            }
        }
    }
});

// $(".boardImage-IN > div > .boardImgs").mouseenter(function(){
$(document).on('mouseenter','.boardImage-IN > div > .boardImgs',function(){ 
    console.log($('.boardImage-IN').data('flameimgpath'));
    $(this).parent().css('background-image','url(' + $('.boardImage-IN').data('flameimgpath') + ')');
});
// $(".boardImage-IN > div > .boardImgs").mouseleave(function(){
$(document).on('mouseleave','.boardImage-IN > div > .boardImgs',function(){ 
    $(this).parent().css('background-image','none');
});
