
{!! Form::model($attribute, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name', old('name', $attribute->translations[$languageId]['name']), ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required']) !!}
        </div>
    </div>
    <input type="hidden" name="parent_id" value="0">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Featured') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-7 mt-2 pt-1">
            <input type="checkbox" {{$attribute->is_featured == 1?'checked':''}}  name="is_featured" value="1">
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
                    @if($attribute->id  > 0)
                        Save Changes
                        @else
                        Add Attribute
                        @endif
                </button>
                <a href="{!! route('admin.attributes.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

