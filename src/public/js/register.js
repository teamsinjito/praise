//画像プレビュー
$('#file').on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(".my-icon").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});