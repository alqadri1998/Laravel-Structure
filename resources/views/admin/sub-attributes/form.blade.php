
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
    <input type="hidden" name="parent_id" value="{{$attribute->parent_id?$attribute->parent_id:$parent}}">
    @if(env('COLOR_ATTRIBUTE_ID') == $attribute->parent_id)
        <div class="form-group m-form__group row" >
            <label for="example-text-input" class="col-3 col-form-label">


            </label>
            <div class="col-7">
                @include('admin.common.upload-gallery-modal',['old_image' => $attribute->image])
                <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 165 x 165</p>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Current Image
            </label>

            <div class="col-3" style="padding-top: 140px">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($attribute->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">

            </div>
            {{--<label for="example-text-input" class="col-2 col-form-label ">--}}
            {{--Selected Image--}}
            {{--</label>--}}
            {{--<div class="col-3" style="padding-top: 10px;padding-left: 38px;">--}}
            {{--<img style="width:120px;height: 120px; " src="{!! asset('images/image.png') !!}" id="image" class="selected-image " name="image" >--}}
            {{--</div>--}}
        </div>
    @endif
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                   @if($attribute->id > 0)
                       Save Changes
                       @else
                        Add Subattribute
                       @endif
                </button>
                <a href="{!! route('admin.attributes.index',$parent) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

