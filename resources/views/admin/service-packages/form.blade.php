{!! Form::model($servicePackage, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::text('title',old('title', $servicePackage->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Price') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::number('price',old('price', $servicePackage->price), ['class' => 'form-control', 'placeholder' => '125', 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Quantity') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::number('quantity', old('quantity', $servicePackage->quantity), ['class' => 'form-control', 'placeholder' => 'quantity','min=0', 'required'=>'required']) !!}
        </div>
    </div>



    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>
        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $servicePackage->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 161  x 177</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Current Image
        </label>
        <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($servicePackage->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
            </div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Short Description') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('short_description',old('short_description', $servicePackage->translations[$languageId]['short_description']), ['class' => 'form-control', 'placeholder' => 'Short Description']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Long Description') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('long_description',old('long_description', $servicePackage->translations[$languageId]['long_description']), ['class' => 'form-control', 'placeholder' => 'Long Description']) !!}
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
                    @if($servicePackage->id > 0 )
                        {{ __('Save Changes')}}
                        @else
                        {{ __('Add Service Package')}}
                        @endif
                </button>
                <a href="{!! route('admin.packages.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
</div>

{!! Form::close() !!}

