{!! Form::model($repair, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::text('title',old('title', $repair->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('description') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('description',old('description', $repair->translations[$languageId]['description']), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
        </div>
    </div>
    {{--Image--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>

        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $repair->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 326  x 353</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Current Image
        </label>
        <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($repair->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
            </div>
        </div>
    </div>
    {{--/ Image--}}

    {{--Icon--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>

        </label>
        <div class="col-7">


            <div class="tab-pane fade show active home{!! $languageId !!}" id="home{!! $languageId !!}" role="tabpanel"
                 aria-labelledby="home-tab">
                <div class="container">
                    <button type="button" class="btn btn-accent m-btn m-btn--air m-btn--custom upload-icon">
                        Upload Icon
                    </button>
                    <input type="file" id="upload_icon_input" class="hide upload_icon_input" accept="image/*">
                </div>
            </div>
            <input type="hidden" id="public_select_icon" name="icon" class="public_select_icon" value="{{ old('icon') }}">






            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 326  x 353</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Current Icon
        </label>
        <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px;position: absolute;top: 10px;left: 0px;margin-left: 30px;display: flex;justify-content: center;align-items: center; " src="{!! imageUrl(url($repair->icon), 120, 120, 100, 1) !!}" id="image" class="selected-icon img-fluid">
            </div>
        </div>
    </div>
    {{--/Icon--}}


    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <input type="hidden" value="PUT" name="_method">
                <input type="hidden" name="language_id" value="{!! $languageId !!}">
                <div class="col-4"></div>
                <div class="col-7">
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        @if($repair->id > 0 )
                            Save Changes
                        @else
                            Add Service
                        @endif
                    </button>
                    <a href="{!! route('admin.services.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

