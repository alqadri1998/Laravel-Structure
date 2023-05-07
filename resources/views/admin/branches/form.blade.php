{!! Form::model($branch, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-7">
            {!! Form::text('title',old('title', $branch->translations[$languageId]['title']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>

        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-3 col-form-label">
                {!! __('Timings') !!}
                <span class="text-danger">*</span>
            </label>
            <div class="col-7">
                {!! Form::textarea('timings',old('timings', $branch->timings), ['class' => 'form-control', 'placeholder' => 'Workings days and off days with timings', 'required'=>'required']) !!}
            </div>
        </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            <span class="text-danger"></span>
        </label>
        <div class="col-7">
            @include('admin.common.upload-gallery-modal',['old_image' => $branch->image])
            <p class="ml-3 mt-3 text-danger smaller-font-size">Recommended size 262  x 160</p>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Current Image
        </label>
        <div class="col-3" style="padding-top: 140px">
            <div class="d-flex justify-content-center align-items-center">
                <img style="width:120px;height: 120px; " src="{!! imageUrl(url($branch->image), 120, 120, 100, 1) !!}" id="image" class="selected-image img-fluid">
            </div>
        </div>
    </div>


    {{--Monday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Monday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->monday)) checked @endif name="mondayIsOn">
        </div>
        @if(!empty($branch->monday))
        @foreach(json_decode($branch->monday) as $key=>$time)
            @if($key == "start_time")
            <div class="col-">
                <input type="text"  value="{{$time}}"   class="form-control m-bootstrap-select event-datetime-picker" name="monday_start_time" placeholder="Start date">
            </div>
            @else
                <div class="col-">
                    <input type="text"  value="{{$time}}"   class="form-control m-bootstrap-select event-datetime-picker" name="monday_end_time" placeholder="End date">
                </div>
            @endif
        @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control m-bootstrap-select event-datetime-picker" name="monday_start_time" placeholder="Start date">
            </div>
            <div class="col-">
                <input type="text" class="form-control m-bootstrap-select event-datetime-picker" name="monday_end_time" placeholder="Start date">
            </div>
        @endif
    </div>
    {{--/ Monday--}}

    {{--tuesday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Tuesday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox"  @if(!empty($branch->tuesday)) checked @endif name="tuesdayIsOn">
        </div>
        @if(!empty($branch->tuesday))
            @foreach(json_decode($branch->tuesday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control m-bootstrap-select event-datetime-picker" name="tuesday_start_time" placeholder="Start date">

                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control m-bootstrap-select event-datetime-picker" name="tuesday_end_time" placeholder="nd date">

                    </div>
                @endif
            @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control m-bootstrap-select event-datetime-picker" name="tuesday_start_time" placeholder="Start date">

            </div>
            <div class="col-">
                <input type="text" class="form-control m-bootstrap-select event-datetime-picker" name="tuesday_end_time" placeholder="Start date">
            </div>
        @endif
    </div>
    {{--/ tuesday--}}

    {{--wednesday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Wednesday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->wednesday)) checked @endif name="wednesdayIsOn">
        </div>

        @if(!empty($branch->wednesday))
            @foreach(json_decode($branch->wednesday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="wednesday_start_time">
                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="wednesday_end_time">
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="wednesday_start_time">
            </div>
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="wednesday_end_time">
            </div>
        @endif
    </div>
    {{--/ wednesday--}}

    {{--thursday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Thursday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->thursday)) checked @endif name="thursdayIsOn">
        </div>

        @if(!empty($branch->thursday))
            @foreach(json_decode($branch->thursday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="thursday_start_time">
                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="thursday_end_time">
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="thursday_start_time">
            </div>
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="thursday_end_time">
            </div>
        @endif
    </div>
    {{--/ thursday--}}

    {{--friday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Friday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->friday)) checked @endif name="fridayIsOn">
        </div>
        @if(!empty($branch->friday))
            @foreach(json_decode($branch->friday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="friday_start_time">
                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="friday_end_time">
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="friday_start_time">
            </div>
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="friday_end_time">
            </div>
        @endif
    </div>
    {{--/ friday--}}

    {{--saturday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Saturday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->saturday)) checked @endif name="saturdayIsOn">
        </div>

        @if(!empty($branch->saturday))
            @foreach(json_decode($branch->saturday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="saturday_start_time">
                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="saturday_end_time">
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="saturday_start_time">
            </div>
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="saturday_end_time">
            </div>
        @endif

    </div>
    {{--/ saturday--}}

    {{--sunday--}}
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Sunday') !!}
            <span class="text-danger"></span>
        </label>
        <div class="col-1 mt-2 pt-1">
            <input type="checkbox" @if(!empty($branch->sunday)) checked @endif name="sundayIsOn">
        </div>

        @if(!empty($branch->sunday))
            @foreach(json_decode($branch->sunday) as $key=>$time)
                @if($key == "start_time")
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="sunday_start_time">
                    </div>
                @else
                    <div class="col-">
                        <input type="text" value="{{$time}}" class="form-control event-datetime-picker" name="sunday_end_time">
                    </div>
                @endif

            @endforeach

        @else
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="sunday_start_time">
            </div>
            <div class="col-">
                <input type="text" class="form-control event-datetime-picker" name="sunday_end_time">
            </div>
        @endif
    </div>
    {{--/ sunday--}}

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-md-4 col-xl-3 col-form-label">
            {!! __('Branch Phone Number') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-7 col-xl-7">
            {!! Form::text('phone',old('phone', $branch->phone), ['class' => 'form-control', 'placeholder' => 'Phone number of branch','maxlength' => 16 , 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-md-4 col-xl-3 col-form-label">
            {!! __('Branch Whatsapp Number') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-md-7 col-xl-7">
            {!! Form::text('whatsapp_phone',old('whatsapp_phone', $branch->whatsapp_phone), ['class' => 'form-control', 'placeholder' => 'Whatsapp phone number of branch','maxlength' => 16 , 'required'=>'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Address') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('address', old('address', $branch->address), ['class' => 'form-control', 'placeholder' => 'Address of the branch', 'id'=>'searchmap'.$languageId]) !!}
            {!! Form::hidden('longitude', old('address', $branch->longitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'longitude'.$languageId]) !!}
            {!! Form::hidden('latitude', old('address', $branch->latitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id'=>'latitude'.$languageId]) !!}
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
                    @if($branch->id > 0 )
                        {{ __('Save Changes')}}
                        @else
                        {{ __('Add Branch')}}
                        @endif
                </button>
                <a href="{!! route('admin.branches.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{!! __('Cancel') !!}</a>
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
                $('.event-datetime-picker').timepicker({
                });
            }
        });

    </script>

    @endpush

