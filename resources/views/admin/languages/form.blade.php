
{!! Form::model(/*$section*/ ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}

<div class="m-portlet__body">

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label" style="text-align: right">
            {!! __('Key') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
                {!! Form::text('trans_key', old('trans_key' /*$section->section_key*/), ['class' => 'form-control', 'id' => 'trans_key', 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label" style="text-align: right">
            {!! __('Translation') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
                {!! Form::textarea('translation', old('translation' /*(($section->section_key=='head-content') ? htmlentities($section->content):$section->content)*/), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
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


