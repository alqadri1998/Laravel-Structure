{!! Form::model($order, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}

<div class="m-portlet__body">

              </div>
    {{--<div class="form-group m-form__group row">--}}
        {{--<label for="example-text-input" class="col-3 col-form-label">--}}
            {{--{!! __('Address') !!}--}}
            {{--<span class="text-danger">*</span>--}}
        {{--</label>--}}
        {{--<div class="col-7">--}}
            {{--{!! Form::textarea('address', old('address', $order->address), ['class' => 'form-control', 'placeholder' => 'Address', ]) !!}--}}
        {{--</div>--}}
    {{--</div>--}}

        <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-3 col-form-label">
                    {!! __('Description') !!}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-7">
                    {!! Form::textarea('description', old('description', $order->description), ['class' => 'form-control', 'placeholder' => 'Description', ]) !!}
                </div>
              </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Region') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::select('region', $regions, old('region', $order->region), ['class' => 'form-control', 'id' => 'region' ,'required'=>'required']) !!}
        </div>
    </div>

      
</div>
{{--<div class="m-portlet__foot m-portlet__foot--fit" style="margin-top: 25px">--}}
    <div class="m-form__actions"  style="margin-top: 25px">
        <div class="row" >
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="language_id" value="{!! $languageId !!}">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                    Save changes
                </button>
                <a href="{!! route('admin.orders.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}

