<?php
echo '
{!! Form::model('.'$'.$variable.', [\'url\' => $action, \'method\' => \'post\', \'role\' => \'form\', \'class\' => \'m-form m-form--fit m-form--label-align-right\', \'enctype\' => \'multipart/form-data\']) !!}
<div class="m-portlet__body">
    ';?>
@foreach ($formFields as $key=>$fields)
  {!! $fields !!}
      @endforeach
<?php
        echo
    '
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                    Save changes
                </button>
                <a href="{!! route(\'admin.'.$view.'.index\') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __(\'Cancel\') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

';