var jqxhr = null;

$(document).on('click','.boardImgs',function(){ 
    var imgSrc = $(this).attr('src');
    
    if(imgSrc.match('_1.png')){
        imgSrc = imgSrc.replace('_1.png','_2.png');
        $(this).next().css('display','none');
        $(this).next().next().css('display','block');
    }
    else{
        imgSrc = imgSrc.replace('_2.png','_1.png');
        $(this).next().css('display','block');
        $(this).next().next().css('display','none');
    }
    
    $(this).attr('src',imgSrc);
    
});

$(document).on('mouseenter','.boardImage-IN > div',function(){ 
    // console.log($('.boardImage-IN').data('flameimgpath'));
    $(this).css('background-image','url(' + $('.boardImage-IN').data('flameimgpath') + ')');
    $(this).animate({
        "marginTop": "-10px"
    },{ duration: 500 });
    $(this).children('div').animate({
        "marginTop": "-10px"
    },{ duration: 500 });
});

$(document).on('mouseleave','.boardImage-IN > div',function(){ 
    $(this).css('background-image','none');
    $(this).animate({
        "marginTop": "0px"
    },{ duration: 500 });
    $(this).children('div').animate({
        "marginTop": "-0px"
    },{ duration: 500 });
});

//取得したコメントリストでHTMLを構成
function makeBoardListHTML (data,appendToDom) {

    //HTML作成中はスクロール禁止
    $("body").addClass("no_scroll");
    $(window).on('touchmove', (e) => {
        e.preventDefault();
    });

    for(var i =  0; i<data.length; i++){
        //requestを飛ばせたもののみ追加
        //ボードレイヤー   ---------------------------------------
        if ($('.comment-area').hasClass('active')){
            // 表示されている場合の処理
            var boardLayer = $('<div>', {class:'col-sm-6 col-lg-6 col-12 p-2 board',style:'position:relative'}); 
        } else{
            var boardLayer = $('<div>', {class:'col-sm-6 col-lg-4 col-12 p-2 board',style:'position:relative'}); 

        }
        //ボードimageレイヤー  ---------------------------------------
        var imgLayer = $('<img>', {id:data[i].id,src: '/storage/img/boards/' + data[i].id + '_1.png',alt:'ボード画像',class:'w-100 boardImgs'});
            
        //いいね数、コメント数レイヤー ---------------------------------------
        var goodCommentViewLayer = $('<div>', {class:'txt_S good-view-area',name:data[i].id});
        //いいねアイコン
        var goodIcon = $('<i>',{class:'fas fa-thumbs-up goodView'});
        //いいね数
        var goodCnt = $('<span>',{class:'good-counter mx-1'}).append(data[i].cnt);
        //コメントアイコン
        var commentIcon = $('<i>',{class:'fas fa-comment-dots'});
        //コメント数
        var commentCnt = $('<span>',{class:'comment-counter mx-1'}).append(data[i].cnt_comment);

        //いいね数、コメント数レイヤーに要素を追加
        goodCommentViewLayer.append(goodIcon,goodCnt,commentIcon,commentCnt);

        //いいね、コメント追加ボタンレイヤー --------------------------------------
        var goodCommentBtnLayer = $('<div>', {class:'txt_M board-btn-area'}); 
        //コメントボタン
        var commentBtnPc=$('<i>',{class:'fas fa-comment-dots comment comment-pc'});
        var commentBtnPhone=$('<i>',{class:'fas fa-comment-dots comment comment-phone'});
        var commentBtnTxtPc=$('<span>',{class:'mx-3 comment comment-pc',text:'Comment!'});
        var commentBtnTxtPhone=$('<span>',{class:'mx-3 comment comment-phone',text:'Comment!'});
        
        //いいねボタン
        if (data[i].pushed > 0){
            var goodBtn=$('<i>',{class:'fas fa-thumbs-up good pushed'}).css('color','#EE82EE').prop("disabled", true);
            var goodBtnTxt=$('<span>',{class:'mx-3 good pushed',text:'Favorite!'}).css('color','#EE82EE').prop("disabled", true);

        }else{
            var goodBtn=$('<i>',{class:'fas fa-thumbs-up good'})
            var goodBtnTxt=$('<span>',{class:'mx-3 good',text:'Favorite!'});
        }
        //いいね、コメント追加ボタンレイヤーに要素を追加
        goodCommentBtnLayer.append(commentBtnPc,commentBtnPhone,commentBtnTxtPc,commentBtnTxtPhone,'<br>',goodBtn,goodBtnTxt);
        
        //ボードレイヤーに作成した全レイヤーを追加
        boardLayer.append(imgLayer,goodCommentViewLayer,goodCommentBtnLayer); 
        
        //一度非表示にしてからファードインで表示(appendTo使用対策)
        $(boardLayer).appendTo(appendToDom).delay(600).fadeIn();
        // $('.boardImage-IN').append(boardLayer).hide().fadeIn();
        
        $('.boardImage').attr('data-imgid',data[i].id);                   
    }

    //スクロール禁止解除
    $("body").removeClass("no_scroll");
    $(window).off('touchmove');
}