var jqxhr = null;

window.onload = function(){
    // ページ読み込み時に実行したい処理
    $('#mypage-menu-list > li:first > span').click();
}

//メニュータブ押下時
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

//褒めた履歴、褒められた履歴タブ切替時
$('#mypage-menu-list > li > .board').on('click', function() {

    //二重クリック防止
    if(jqxhr){ jqxhr.abort(); }

    var col_cmt;
    //クラス名取得
    var classNames =$(this).attr('class').split(" ");

    if ($('.comment-area').hasClass('active')) {
        col_cmt=6
    }else{
        col_cmt=4
    }
    if($('.'+ classNames[1] +' > .boardImage-IN > div').length){
        $('.'+ classNames[1] +' > .boardImage-IN > .board').removeClass('col-lg-4')
        $('.'+ classNames[1] +' > .boardImage-IN > .board').removeClass('col-lg-6')
        $('.'+ classNames[1] +' > .boardImage-IN > .board').addClass('col-lg-'+col_cmt)

    }

    jqxhr = $.ajax({
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
        if($('.'+ classNames[1] +' > .boardImage-IN > div').length){
            $('.'+ classNames[1] +' > .boardImage-IN > div').remove();
        }
        makeBoardListHTML(data,'.'+ classNames[1] +' > .boardImage-IN');
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
        
        var col_cmt;

        //現在褒めた履歴、褒められた履歴を表示しているか　かつボードが9つ以上あるか
        if($('.my-praise-datas > .active > .boardImage-IN').children().length>8){

            //現在のページ数を取得
            var imglastid = $('.boardImage').attr('data-imgid'); //現在表示されているボードの末尾のID
    
            var classNames= $('.my-praise-datas > .active').attr('class').split(" ");

            $.ajax({
                type: "GET",
                contentType: "application/json",
                // コンテンツ読み込み先URL
                url: "/mypage/"+classNames[0]+"/" + imglastid, //ルーティングのパス
                datatype: 'json',
    
            })
            // Ajaxリクエスト成功時の処理
            .done(function(data) {

                makeBoardListHTML(data,'.my-praise-datas > .active > .boardImage-IN');
            })
            // Ajaxリクエスト失敗時の処理
            .fail(function(data) {
                console.log('Ajaxリクエスト失敗');
                //スクロール禁止解除
                $("body").removeClass("no_scroll");
                $(window).off('touchmove');
            });
        }
    }
});

//レーダーチャート
$('#mypage-menu-list > li > .chart').one('click', function() {

    $.ajax({
        type: "GET",
        contentType: "application/json",
        // コンテンツ読み込み先URL
        url: "/mypage/chart", //ルーティングのパス
        datatype: 'json',

    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // Laravel内で処理された結果がdataに入って返ってくる
        var stampName=[];
        var sendStampCnt=[];
        var getStampCnt=[];

        //取得したデータを整形
        for(var i = 0; i < data.length; i++){
            stampName[i]=data[i]['name']; //スタンプ名
            sendStampCnt[i]=data[i]['cnt1'];//それぞれのスタンプを送った数
            getStampCnt[i]=data[i]['cnt2'];//それぞれのスタンプを貰った数
        }

        //カウント数から最大値を求め、目盛の最大値を算出
        var maxCnt;
        var mergeCnt =$.merge(sendStampCnt,getStampCnt)

        var mergeMaxCnt =Math.max.apply(null, mergeCnt);
        for(var i=0; i< 600; i++){
            var h=i*30;
            if(mergeMaxCnt >= h && mergeMaxCnt < 30+h){
                maxCnt=30+h;
                break;
            }
        }
        var stepSize=maxCnt/5;

        //レーダーチャート生成
        var ctx = $('#myRaderChart');
        var myRadarChart = new Chart(ctx, {
            type: 'radar', 
            data: { 
                labels: stampName,
                datasets: [{
                    label: '送ったスタンプ数',
                    data: sendStampCnt,
                    backgroundColor: 'RGBA(225,95,150, 0.5)',
                    borderColor: 'RGBA(225,95,150, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: 'RGB(46,106,177)'
                },
                {
                    label: '貰ったスタンプ数',
                    data: getStampCnt,
                    backgroundColor: 'RGBA(115,255,25, 0.5)',
                    borderColor: 'RGBA(115,255,25, 1)',
                    borderWidth: 1,
                    pointBackgroundColor: 'RGB(46,106,177)'
                }
            ]
            },
            options: {
                // title: {
                //     display: true,
                // },
                maintainAspectRatio: false,

                scale:{
                    pointLabels: {
                        fontColor: 'var(--main-fn-color-black)',
                        fontSize: 14,
                        fontFamily: "'Bradley Hand','Bradley Hand','Segoe Print','HanziPen TC','ヒラギノ角ゴシック','Hiragino Sans','ＭＳ ゴシック',sans-serif",
                    },
                    ticks:{
                        suggestedMin: 0,
                        suggestedMax: maxCnt,
                        stepSize: stepSize,
                        backdropColor:'rgba(255,255,255,0)',
                        callback: function(value, index, values){
                            return  value
                        },
                        
                    }
                }
            }
        });
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });
})

//相関図
$('#mypage-menu-list > li > .diagram').one('click', function() {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/mypage/diagram',
        type: 'GET',
        datatype: 'json',
        cache: false
    })
    // Ajaxリクエスト成功時の処理
    .done(function(data) {
        // Laravel内で処理された結果がdataに入って返ってくる
        var node=[];

        var dataP = $('#mydiagram').data('path');

        for(var i=0; i<data[0].length;i++){
            var userImg;
            if(data[0][i].image!=null){
                userImg='data:image/png;base64,'+data[0][i].image;
            }
            else{
                userImg='/img/user_icon_default.png'
            }

            node.push({
                "id": data[0][i]['id'].toString(),
                "label": data[0][i]['name'].toString(),
                "shape": 'circularImage',
                "image": userImg.toString(),
            });
        }

        var edge=[];
        for(var i=0; i<data[1].length;i++){

            edge.push({
                "from": data[1][i]['from_user_id'].toString(),
                "to": data[1][i]['to_user_id'].toString(),
                "label": data[1][i]['hometa'].toString(),
                "arrows": "to",
            })
        }
        // console.log(node);

        // create an array with nodes
        var nodes = new vis.DataSet(node);

        // create an array with edges
        var edges = new vis.DataSet(edge);

        // create a network
        var container = document.getElementById('mydiagram');

        // provide the data in the vis format
        var data = {
            nodes: nodes,
            edges: edges
        };
        var options = {
            autoResize: true,
            height: '100%',
            width: '100%',

            nodes:{
                borderWidth:0,
                font:{
                    color: '#444444',
                    face: 'Bradley Hand,Segoe Print,HanziPen TC,ヒラギノ角ゴシック,Hiragino Sans,ＭＳ ゴシック',
                    size: 16,
                },
                color:{
                    background: 'white',
                }

            },
            edges: {
                color: {
                    color: '#5f5f5f',
                },
                width: 1,
                length: 200,
                font:{
                    color: '#444444',
                    size: 14, // px
                    face: 'Bradley Hand,Segoe Print,HanziPen TC,ヒラギノ角ゴシック,Hiragino Sans,ＭＳ ゴシック',
                    background: 'none',
                    strokeWidth: 0, // px
                }
            }
        };

        // initialize your network!
        var network = new vis.Network(container, data, options);
    })
    // Ajaxリクエスト失敗時の処理
    .fail(function(data) {
        console.log('Ajaxリクエスト失敗');
    });

})
//編集ボタン押下時
$('.chamge-my-profile > button').click(function(){

    //[$modal-overlay]をフェードインさせる
    $(".edit-overlay").fadeIn();

});
//編集ウィンドウ閉じる
$('.js-modal-close').on('click',function(){
    $('.edit-overlay').fadeOut();
});
//画像プレビュー
$('#file').on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(".modal__content > .my-icon-name > .my-icon").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

//ロード画面
$("#submit-btn").on("click", function(){
    $("form").submit(); //フォーム実行
    $("#overlay").fadeIn(500); //二度押しを防ぐloading表示
    setTimeout(function(){
        $("#overlay").fadeOut(500);
    },10000);
});