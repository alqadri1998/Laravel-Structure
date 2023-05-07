
{!! Form::model($page, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('title', old('title', $page->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Content') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('content', old('content', $page->translations[$languageId]['content']), ['class' => 'form-control', 'placeholder' => 'Content']) !!}
        </div>
    </div>
    @if($page->slug == config('settings.about_us'))
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Image') !!}   
            <span class="text-danger"></span>
        </label>
        <div class="col-7">
            <div class="col-7">
                @if($page->id > 0)
                <label class="choose-image">
                    Choose Image
                    {!! Form::file('image', ['id'=>'image', 'accept'=>'image/*']) !!}
                @else
                    {!! Form::file('image', ['id'=>'image', 'accept'=>'image/*']) !!}
                    </label>
                @endif
            </div>
            {{--@include('admin.common.upload-gallery-modal')--}}
        </div>
    </div>
    <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Current Image
            </label>
            <div class="col-3" style="padding-top: 10px">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{!! imageUrl(asset($page->image), 120, 120, 100, 1) !!}" id="selected-image" class="img-fluid">
            </div>
            </div>
        </div>
    @endif
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <input type="hidden" name="page_id" value="{!! $pageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    @if($pageId > 0)
                        Save Changes
                        @else
                        Add Info Page
                        @endif
                </button>
                <a href="{!! route('admin.pages.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

