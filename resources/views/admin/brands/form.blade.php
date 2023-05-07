{!! Form::model($brand, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::text('title',old('title', $brand->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>
        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $brand->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 270  x 270</p>
        </div>
    </div>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Current Image
            </label>
            <div class="col-3" style="padding-top: 140px">
             <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($brand->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
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
                    @if($brand->id > 0 )
                        Save Changes
                        @else
                        Add Brand
                        @endif
                </button>
                <a href="{!! route('admin.brands.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
</div>

{!! Form::close() !!}

