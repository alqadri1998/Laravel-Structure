{!! Form::model($catalog, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">

        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $catalog->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 160 x 160</p>
        </div>
    </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Current Image
            </label>

            <div class="col-3" style="padding-top: 140px">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($catalog->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
            </div>
            {{--<label for="example-text-input" class="col-2 col-form-label ">--}}
                {{--Selected Image--}}
            {{--</label>--}}
            {{--<div class="col-3" style="padding-top: 10px;padding-left: 38px;">--}}
                {{--<img style="width:120px;height: 120px; " src="{!! asset('images/image.png') !!}" id="image" class="selected-image " >--}}
            {{--</div>--}}
            <div class="col-12">
            <div class="form-group m-form__group row pb-4">
        <label for="example-text-input" class="col-3 col-form-label">
                    PDF File   <span class="text-danger">*</span>
                </label>
                <div class="col-7">
                    <label for="pdf-file" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                        Upload PDF
                        <input type="file" id="pdf-file"  name="pdf_file" class="hide" accept="application/pdf">
                    </label>
                    <span class="file-name"></span>
                    {{--                 <input type="file" id=""  name="pdf_file" class=" " accept="application/pdf">--}}
                </div>
            </div>
            </div>

        </div>
 
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                  @if($catalog->id  > 0)
                        Save Changes
                      @else
                        Add Catalog
                      @endif
                </button>
                <a href="{!! route('admin.catalogues.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
<script>
    $(document).ready(function () {
        $('.select_image').hide();
        $('#pdf-file').change(function() {
            var file = $('#pdf-file')[0].files[0].name;
            $('.file-name').text(file);
        });
    });
</script>
