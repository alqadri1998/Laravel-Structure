{!! Form::model($event, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::text('title',old('title', $event->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('description') !!}
                <span class="text-danger">*</span>
            </label>
            <div class="col-7">
                {!! Form::textarea('description',old('description', $event->translations[$languageId]['description']), ['class' => 'form-control', 'placeholder' => 'Description', 'required'=>'required']) !!}
            </div>
        </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>

        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $event->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 326  x 353</p>
        </div>
    </div>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                Current Image
            </label>
            <div class="col-3" style="padding-top: 140px">
             <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($event->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
                </div>
               
            </div>

        </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('start Date') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text"  value="{!!old('start_date')?old('start_date'):\Carbon\Carbon::createFromTimestamp($event->start_date)->format('m/d/Y') !!}"   class="form-control m-bootstrap-select event-datetime-picker" name="start_date" placeholder="Start date">
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('End Date') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <input type="text"  value="{!!old('end_date')?old('end_date'):\Carbon\Carbon::createFromTimestamp($event->end_date)->format('m/d/Y') !!}"  class="form-control m-bootstrap-select event-datetime-picker" name="end_date" placeholder="End date">
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Address') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('event_location', old('event_location', $event->event_location), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'searchmap'.$languageId]) !!}
            {!! Form::hidden('longitude', old('event_location', $event->longitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'longitude'.$languageId]) !!}
            {!! Form::hidden('latitude', old('event_location', $event->latitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'latitude'.$languageId]) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Change Position') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-7">
            <div id="map{!! $languageId !!}" style="height:400px; width:100%;margin-top: 48px"></div>
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
                    @if($event->id > 0 )
                        Save Changes
                        @else
                        Add Event
                        @endif
                </button>
                <a href="{!! route('admin.products.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
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
                    startDate: date
                });
            }
        });
    </script>

    @endpush

