
{!! Form::open(['url' => $action, 'method' => 'put', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}

<div class="m-portlet__body">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label" style="text-align: right">
            {!! __('Key') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
                {!! Form::text('updatedKey', old('updatedKey' ,$key), ['class' => 'form-control', 'id' => 'updatedKey', 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label" style="text-align: right">
            {!! __('English Translation') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
                {!! Form::textarea('en_updatedTranslation', old('en_updatedTranslation', $en_translations), ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label" style="text-align: right">
            {!! __('Arabic Translation') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('ar_updatedTranslation', old('ar_updatedTranslation', $ar_translations), ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{{$key}}" name="jsonFileKey" >
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                    Save changes
                </button>
                &nbsp;&nbsp;
                <a href="{!! route('admin.translations.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>

            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}


