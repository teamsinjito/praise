<div class="prised-completed" id="prised-completed">
    <div class="modal-display col-12 col-lg-6 col-sm-8 offset-lg-3 offset-sm-2">
        <div class="completed-title w-100 text-center my-4">
            <h1 class="txt_XL">I have Complimented!</h1>
        </div>
        <div class="newBoard-image w-100 text-center">
            <div class="col-10 col-sm-8 bg-white mx-auto">
                <img src="data:image/png;base64,{{session('praised')->image}}" alt="ボード画像" class="w-100 boardImgs preview">
                <img src="data:image/png;base64,{{session('praised')->image_message}}" alt="ボード画像" class="w-100 boardImgs preview" style="display: none">
            </div>
        </div>
        <div class="modal-close w-100 text-center my-4">
            <div class="modal-class-btn txt_XL"><i class="far fa-times-circle"></i></div>
        </div>
    </div>
</div>