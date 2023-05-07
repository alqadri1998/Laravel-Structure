<div class="tab-pane fade show active home{!! $languageId !!}" id="home{!! $languageId !!}" role="tabpanel"
     aria-labelledby="home-tab">
    <div class="container">
        <button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom upload-image">
            Upload Image
        </button>
        <input type="file" id="upload_image_input" class="hide upload_image_input" accept="image/*">
    </div>
</div>
<input type="hidden" id="public_select_image" name="image" class="public_select_image" value="">