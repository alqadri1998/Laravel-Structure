{!! Form::model($category, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name',old('name', $category->translations[$languageId]['name']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

    {{--Subcategory Image Input--}}
  {{--  <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Image') !!}
            <span class="text-danger"></span>

        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $category->image])
            <p class="mt-3 ml-3 text-danger smaller-font-size">Recommended size 165 x 165</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Current Image
        </label>
        <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">

                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($category->image), 120, 120, 100, 1) !!}"
                     id="image" class="selected-image img-fluid">

            </div>

        </div>
    </div>--}}
    {{--/ Subcategory Image Input--}}

    <input type="hidden" name="parent_id" value="{{$category->parent_id?$category->parent_id:$parent}}">

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                    @if($category->id > 0)
                        Save Changes
                        @else
                        Add Model
                        @endif
                </button>
                <a href="{!! route('admin.categories.sub-categories.index',$parent) !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

<script>
    $(document).ready(function () {
        $('.select_image').hide();
    });
</script>
