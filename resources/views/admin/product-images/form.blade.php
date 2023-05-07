{!! Form::model($faq, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Question') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('question', old('question', $faq->translations[$languageId]['question']), ['class' => 'form-control', 'required'=>'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Answer') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('answer', old('answer', $faq->translations[$languageId]['answer']), ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{!! $languageId !!}" name="language_id">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    Save changes
                </button>
                <a href="{!! route('admin.faqs.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}



