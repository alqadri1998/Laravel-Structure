{!! Form::model($coupon, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-md-4 col-xl-3 col-form-label">
            Coupon Code
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-7 col-xl-7">
          <p class="m--padding-top-10">{!! $code !!}</p>
            <input type="hidden" name="code" value="{!! $code !!}">
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-md-4 col-xl-3 col-form-label">
            Discount In Percentage
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-7 col-xl-7">
            {!! Form::number('percent',old('percent', $coupon->percent), ['class' => 'form-control', 'placeholder' => 'percent','min=0','step=0.01', 'required'=>'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            End Date
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text"  value="{!!$coupon->end_date?\Carbon\Carbon::createFromTimestamp($coupon->end_date)->format('m/d/Y'):old('end_date') !!}"   class="form-control m-bootstrap-select event-datetime-picker" name="end_date" placeholder="End date" required>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <input type="hidden" value="PUT" name="_method">
                <input type="hidden" name="language_id" value="{!! $languageId !!}">
                <div class="col-4"></div>
                <div class="col-7">
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                      @if($coupon->id  > 0)
                           Save Changes
                          @else
                            Add Coupon
                          @endif
                    </button>
                    <a href="{!! route('admin.coupons.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@push('script-page-level')
    <script>
        $(document).ready(function(){
            var date = new Date();
            if ($('.event-datetime-picker').length > 0) {
                $('.event-datetime-picker').datepicker({
                    format: "m/d/yyyy",
                    startDate: date,
                });
            }
        });
    </script>

@endpush


