// Script written by @hamzadhamiya for @bloggerever.
// http://bloggerever.com

$(function () {
    $.FindContainer = function () {
        $('.tab-content>form>div').each(function findcontent() {
            var newindex = $('.activetab').parent().index();
            var newheight = $('.activetab').height();
            var otherindex = $(this).parent().index();
            var substractindex = otherindex - newindex;
            var currentwidth = $('.multipletab').width();
            var newpositions = substractindex * currentwidth;
            $(this).animate({
                'left': newpositions
            });
        });
    };
    $.FindId = function () {
        $('.tab-content>form>div').each(function () {
            if ($(this).attr('id') == $('.active').attr('id')) {
                $('.tab-content>form>div').removeClass('activetab');
                $(this).addClass('activetab');
            }
        });
    };
    $('.tab-buttons>span').first().addClass('active');
    $('.tab-content>form>div').each(function () {
        var activeid = $('.active').attr('id');
        if ($(this).attr('id') == activeid) {
            $(this).addClass('activetab');
        }
        var currentheight = $('.activetab').height();
        var currentwidth = $('.multipletab').width();
        var currentindex = $(this).parent().index();
        var currentposition = currentindex * currentwidth;
        $(this).css({
            'left': currentposition,
                'width': currentwidth - 40,
                'padding': '0px 20px'
        });
        $(this).attr('data-position', currentposition);
        // $('.tab-content').css('height', currentheight+20);
    });
    $('.tab-buttons>span').click(function () {

        $('.tab-buttons>span').removeClass('active');
        $(this).addClass('active');
        var currentid = $('.active').attr('id');
        $.FindId();
        $.FindContainer();
    });
    $('.next').click(function () {
        var activetabindex = $('.activetab').parent().index() + 1;
        var containers = $('.tab-content>form>div').length;
        if (containers == activetabindex) {
            $('.tab-buttons>span').removeClass('active');
            $('.tab-buttons>span').first().addClass('active');
            var currentid = $('.active').attr('id');
            $.FindId();
            $.FindContainer();
        } else {
            var currentopen = $('.active').next();
            $('.active').removeClass('active');
            currentopen.addClass('active');
            $.FindId();
            $.FindContainer();
        }
    });
  $('.prev').click(function(){
    var activetabindex = $('.activetab').parent().index();
        if (activetabindex == 0) {
            $('.tab-buttons>span').removeClass('active');
            $('.tab-buttons>span').last().addClass('active');
            var currentid = $('.active').attr('id');
            $.FindId();
            $.FindContainer();
        } else {
            var currentopen = $('.active').prev();
            $('.active').removeClass('active');
            currentopen.addClass('active');
            $.FindId();
            $.FindContainer();
        }
});
$('#selectImage').on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $("#preview").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});

    $('.categoryPost').click(function(){
        
        if($('.category-name').val() == ""){
            swal({
                title: "Warning",
                text: "未入力項目あるよ!",
                icon: "warning",
            });
            return;
        }
        $('#categoryForm').submit();
    });
});

window.onload = function(){
    if($('#success-alert').data('id')==1){
        swal({
            title: "complete",
            text: "データが登録できました！!",
            icon: "success",
        });
        return;
    }
    else  if($('#success-alert').data('id')==2){
        swal({
            title: "error",
            text: "データ登録に失敗！入力項目確認して！",
            icon: "error",
        }); 
    }
    else  if($('#success-alert').data('id')==3){
        swal({
            title: "error",
            text: "パスワードチェックに失敗！入力項目確認して！",
            icon: "error",
        }); 
    }
    else  if($('#success-alert').data('id')==4){
        swal({
            title: "complete",
            text: "パスワードの変更が完了しました！",
            icon: "success",
        }); 
    }
};