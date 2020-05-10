window.onload = function(){
    // ページ読み込み時に実行したい処理
    $('#praise-step-1').fadeIn(1500).css('display','flex');
    $('#praise-step-1 > .section-page:first').addClass('active').fadeIn(1500).css('display','flex');

    //ページャーボタンの表示
    if($('#praise-step-1 > .section-page').length > 1){
        $('.to-page-area > .next').css('visibility','visible');
    }
}

$('.next').on('click', function() {
    //現在のステップを取得
    var $praise_step = get_Current_Step();
    var $activePage = $('#'+$praise_step+' > .section-page').filter('.active');

    //activeページを更新
    $activePage.css('display','none').removeClass('active');
    
    var $newActivePage = $activePage.next()
    $newActivePage.css('display','flex').addClass('active');
    

    //戻るボタンを表示
    $('.pre').css('visibility','visible');

    //最終ページであれば次へボタンを非表示
    if(!($newActivePage.next().length)){
        $(this).css('visibility','hidden');
    }
})


$('.pre').on('click',function(){
    //現在のステップを取得
    var $praise_step = get_Current_Step();
    var $activePage = $('#'+$praise_step+' > .section-page').filter('.active');

    $activePage.css('display','none').removeClass('active');
    var $newActivePage = $activePage.prev()
    $newActivePage.css('display','flex').addClass('active');


    $('.next').css('visibility','visible');

    if(!($newActivePage.prev().length)){
        $(this).css('visibility','hidden');
    }
})

//アイコン選択時
$('.section-page > .to-icon > input[type="radio"]').change(function() {
    $('.step-btn-area > .next-step-btn').prop('disabled', false);
});


//Nextボタンクリック時
$('.next-step-btn').on('click',function(){ 

    //現在のステップを取得
    var $praise_step = get_Current_Step();

    // //プログレスバーを更新
    $('#progress-bar-id > .icon-area > .'+$praise_step).css("visibility","visible"); //表示
    $('#progress-bar-id > .progress > .'+$praise_step).css("width","100%"); //バーを表示

    var id = $('#'+$praise_step+' > .section-page > .to-icon > .'+ $praise_step +':checked').val() //選択したアイコンのidを取得

    //アイコン画像を取得
    switch($praise_step){
        case "praise-step-1":
            var folder = 'users';
            break;
        case "praise-step-2":
            var folder = 'stamps';
            break;
    }

    //プログレスバーの画像を選択したアイコンに差し替える
    $('#progress-bar-id > .icon-area > .'+$praise_step).attr('src','/storage/img/'+folder+'/'+id+'.png');
    
    //ステップ番号を更新
    var new_id = parseInt($praise_step.substr( -1 ))+1;
    var $next_praise_step=$praise_step.substr(0,$praise_step.length-1) + (new_id).toString();
    //ステップのタイトルおよびボタンのテキストを更新
    change_Title_Text($next_praise_step);

    //activeページを更新
    $('#'+$praise_step).css('display','none').removeClass('active');
    $('#'+$next_praise_step).addClass('active').fadeIn(1500).css('display','flex');

    $('#'+$next_praise_step+' > .section-page:first').addClass('active').fadeIn(1500).css('display','flex');
    $('#'+$next_praise_step+' > .section-page:not(:first)').css('display','none').removeClass('active');
    //ページャーのリセット
    $('.to-page-area > .pre').css('visibility','hidden');
    if($('#'+$next_praise_step+' > .section-page').length > 1){
        $('.to-page-area > .next').css('visibility','visible');
    }else{
        $('.to-page-area > .next').css('visibility','hidden');
    }

    //Prevボタンを活性化
    $('.pre-step-btn').prop('disabled', false);
    //Nextボタン非活性
    $('.next-step-btn').prop('disabled', true);

})

//Prevボタンクリック時
$('.pre-step-btn').on('click',function(){

    //現在のステップを取得
    var $praise_step = get_Current_Step();
    console.log($praise_step);
    //ステップ番号を更新
    var new_id = parseInt($praise_step.substr( -1 ))-1;
    var $prev_praise_step=$praise_step.substr(0,$praise_step.length-1) + (new_id).toString();
    //ステップのタイトルおよびボタンのテキストを更新
    change_Title_Text($prev_praise_step); 

    // //プログレスバーを更新
    $('#progress-bar-id > .icon-area > .'+$praise_step).css("visibility","hidden"); //表示
    $('#progress-bar-id > .icon-area > .'+$prev_praise_step).css("visibility","hidden"); //表示
    $('#progress-bar-id > .progress > .'+$prev_praise_step).css("width","0%"); //バーを表示
    //選択したアイコンのチェックを外す
    $('#'+$praise_step+' > .section-page > .to-icon > .'+ $praise_step).prop('checked', false);
    $('#'+$prev_praise_step+' > .section-page > .to-icon > .'+ $prev_praise_step).prop('checked', false);



    //activeページを更新
    $('#'+$praise_step).css('display','none').removeClass('active');
    $('#'+$prev_praise_step).addClass('active').fadeIn(1500).css('display','flex');

    $('#'+$prev_praise_step+' > .section-page:first').addClass('active').fadeIn(1500).css('display','flex');
    $('#'+$prev_praise_step+' > .section-page:not(:first)').css('display','none').removeClass('active');
    //ページャーのリセット
    $('.to-page-area > .pre').css('visibility','hidden');
    if($('#'+$prev_praise_step+' > .section-page').length > 1){
        $('.to-page-area > .next').css('visibility','visible');
    }else{
        $('.to-page-area > .next').css('visibility','hidden');
    }

    //Prevボタンの活性化/非活性を判定 
    if($prev_praise_step == "praise-step-1")  {
        $(this).prop("disabled", true);
    }
    //Nextボタン非活性
    $('.next-step-btn').prop('disabled', true);
})

//現在のステップを取得
function get_Current_Step(){
    var $praise_step;

    //現在のステップを取得
    for(var i = 1; i<=$('.to-page-area > section').length; i++){

        if($('.to-page-area > #praise-step-'+i).hasClass('active')){
            $praise_step ='praise-step-'+i;
        }
    }

    return $praise_step;
}

//ステップのタイトルおよびNextボタン、Finishボタンの変更
function change_Title_Text($praise_step){

    switch ($praise_step) {
        case "praise-step-1":
            $('.praise-steps > h1').text("誰を褒める？");
            break;
        case "praise-step-2":
            $('.praise-steps > h1').text("なんて褒める？");
            $('.step-btn-area > .next-step-btn').css('display','block');
            $('#praise-sabmit-btn').css('display','none');
            break;
        case "praise-step-3":
            $('.praise-steps > h1').text("一言どうぞ！");
            $('.step-btn-area > .next-step-btn').css('display','none');
            $('#praise-sabmit-btn').css('display','block');
            break;
        }
}
$("#praise-sabmit-btn").on("click", function(){
    $("form").submit(); //フォーム実行
    $("#overlay").fadeIn(500); //二度押しを防ぐloading表示
    setTimeout(function(){
        $("#overlay").fadeOut(500);
    },10000);
});